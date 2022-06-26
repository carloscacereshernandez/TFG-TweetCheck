<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tweet;
use App\Models\TwitterUser;
use App\Models\Media;
use App\Models\Hashtag;
use App\Models\Annotation;
use GuzzleHttp\Client;
use DateTime;

class TweetController extends Controller
{
    //
    public function verifyTweet(Request $request)
    {
        $tweet_id=get_tweet_id($request->input('tweetLink'));
        if($tweet_id!=-1){
            try {
                $tweet=Tweet::where('twitter_id',$tweet_id)->first();
                //si no está en la base de datos
                if (empty($tweet)){
                    $twitter_client = new Client(['base_uri' => env('TWITTER_API_ROUTE')]);
                    $res = $twitter_client->request('GET', 
                        '/2/tweets/'.$tweet_id.'?tweet.fields=attachments,author_id,context_annotations,created_at,entities,geo,id,in_reply_to_user_id,lang,possibly_sensitive,public_metrics,referenced_tweets,source,text,withheld&media.fields=url,preview_image_url&expansions=attachments.media_keys', 
                        [
                            'headers' => 
                            [
                                'Authorization' => "Bearer ".env('TWITTER_BEARER_TOKEN')
                            ]
                        ]
                    );
                    $res_json=json_decode($res->getBody());
                    
                    if($res_json->data->lang!='es'){
                        return back()->with('error','El idioma del tweet debe ser español');
                    }

                    //obtenemos el analisis del texto
                    $text_client = new Client(['base_uri' => env('TEXT_SERVICE_ROUTE')]);
                    $text_variables = $text_client->request('POST', 
                        '/analyze',
                        [
                            'json' =>[
                                'text' => $res_json->data->text
                            ]
                        ]
                    );

                    $text_variable_json =json_decode($text_variables->getBody());

                    //guardado del usuario
                    $user = TwitterUser::where('twitter_id', $res_json->data->author_id)->first();

                    if(empty($user)){
                        $new_user=app('App\Http\Controllers\TwitterUserController')->create($res_json->data->author_id);
                        $user = $new_user;
                    }else{
                        app('App\Http\Controllers\TwitterUserController')->updateStatus($user->id);
                    }

                    //guardamos el tweet

                    $new_tweet=new Tweet();
                    $new_tweet->twitter_id = $res_json->data->id;
                    $new_tweet->text = $res_json->data->text;
                    $new_tweet->retweets = $res_json->data->public_metrics->retweet_count;
                    $new_tweet->likes = $res_json->data->public_metrics->like_count;
                    $new_tweet->replies = $res_json->data->public_metrics->reply_count;
                    $new_tweet->quotes = $res_json->data->public_metrics->quote_count;
                    $new_tweet->polarity = $text_variable_json->polarity;
                    $new_tweet->subjectivity = $text_variable_json->subj;
                    $new_tweet->toxicity_rate = $text_variable_json->toxicity_score;
                    $new_tweet->claim = $text_variable_json->claim;
                    $new_tweet->posted_at = \DateTime::createFromFormat('Y-m-d\TH:i:s', substr_replace($res_json->data->created_at,"", -5));
                    $new_tweet->user()->associate($user);
                    $new_tweet->save();

                    //guardamos toda la media
                    if(isset( $res_json->includes->media )){
                        $media_list = $res_json->includes->media;
                        foreach ($media_list as $media) {
                            $new_media = new Media();
                            $new_media->type = $media->type;
                            $new_media->url= ($media->type=='photo')? $media->url : $media->preview_image_url;
                            $new_media->tweet()->associate($new_tweet);
                            $new_media->save();
                        }
                    }

                    //guardamos todos los hashtags y los asociamos al tweet
                    if(isset($res_json->data->entities->hashtags)){
                        $hashtags = $res_json->data->entities->hashtags;
                        foreach ($hashtags as $hashtag) {
                            $saved_hashtag = Hashtag::where('word',$hashtag->tag)->first();
                            if(empty($saved_hashtag)){
                                $new_hashtag = new Hashtag();
                                $new_hashtag->word=$hashtag->tag;
                                $new_hashtag->save();
                                $new_hashtag->tweets()->attach($new_tweet);
                            }else{
                                $saved_hashtag->tweets()->attach($new_tweet);
                            }
                        }
                    }

                    //guardamos todos las context annotations y los asociamos al tweet
                    if(isset($res_json->data->context_annotations)){
                        $annotations = $res_json->data->context_annotations;
                        foreach ($annotations as $annotation) {
                            $saved_annotation = Annotation::where('name',$annotation->entity->name)->first();
                            if(empty($saved_annotation)){
                                $saved_annotation = new Annotation();
                                $saved_annotation->name=$annotation->entity->name;
                                $saved_annotation->description=$annotation->domain->name;
                                $saved_annotation->save();
                                $saved_annotation->tweets()->attach($new_tweet);
                            }else{
                                $saved_annotation->tweets()->attach($new_tweet);
                            }
                        }
                    }
                    
                    return redirect()->route('tweet.detail',$new_tweet->id);
                }else{
                    $this->updateTweet($tweet->id);
                    app('App\Http\Controllers\TwitterUserController')->updateStatus($tweet->user->id);
                    return redirect()->route('tweet.detail',$tweet->id);
                }
            } catch (\Throwable $th) {
                return back()->with('error','No se puede recuperar Tweet');
            }
            
        }else{
            return back()->with('error','Url inválida');
        }
      
    }

    public function viewTweet($id){
        $tweet=Tweet::findOrFail($id);
        $this->updateTweet($tweet->id);
        app('App\Http\Controllers\TwitterUserController')->updateStatus($tweet->user->id);
        $google_client = new Client(['base_uri' => env('GOOGLE_FACTCHECK_ROUTE')]);
        $fact_checks=[];
        foreach ($tweet->annotations as $a) {
            $res = $google_client->request('GET', 
                '/v1alpha1/claims:search?key='.env('GOOGLE_FACTCHECK_KEY').'&query='.$a->name.'&languageCode=es&pageSize=10&maxAgeDays=14'
            );
            $response = json_decode($res->getBody());
            if(isset($response->claims)){
                $fact_checks=array_merge($fact_checks,$response->claims);
            }
        }
        return view('tweet-detail',compact('tweet','fact_checks'));
    }

    public function updateTweet($id) {
        $tweet=Tweet::findOrFail($id);
        $date = strtotime(date("Y-m-d H:i:s"));
        if($tweet->deleted==0&&hours_between(strtotime($tweet->updated_at),$date)>=1){
            $twitter_client = new Client(['base_uri' => env('TWITTER_API_ROUTE')]);
            $res = $twitter_client->request('GET', 
                '/2/tweets/'.$tweet->twitter_id.'?tweet.fields=public_metrics', 
                [
                    'headers' => 
                    [
                        'Authorization' => "Bearer ".env('TWITTER_BEARER_TOKEN')
                    ]
                ]
            );
            $res_json=json_decode($res->getBody());
            if(isset( $res_json->data )){ //sigue estando disponible
                $tweet->retweets = $res_json->data->public_metrics->retweet_count;
                $tweet->likes = $res_json->data->public_metrics->like_count;
                $tweet->replies = $res_json->data->public_metrics->reply_count;
                $tweet->quotes = $res_json->data->public_metrics->quote_count;
                $tweet->save();
            }else{ //usuario ha eliminado el tweet
                $tweet->retweets = 0;
                $tweet->likes = 0;
                $tweet->replies = 0;
                $tweet->quotes = 0;
                $tweet->deleted = 1;
                $tweet->save();
            }
        }
    }
}
