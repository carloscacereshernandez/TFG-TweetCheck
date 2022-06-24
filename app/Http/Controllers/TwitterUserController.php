<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TwitterUser;

use GuzzleHttp\Client;
use DateTime;

class TwitterUserController extends Controller
{
    //
    public function create($twitter_id){
        $twitter_client = new Client(['base_uri' => env('TWITTER_API_ROUTE')]);
        $user_response = $twitter_client->request('GET', 
        '/2/users/'.$twitter_id.'?user.fields=profile_image_url,description', ['headers' => ['Authorization' => "Bearer ".env('TWITTER_BEARER_TOKEN')]]);
    
        $user_data=json_decode($user_response->getBody());

        $new_user=new TwitterUser();
        $new_user->twitter_id=$user_data->data->id;
        $new_user->name=$user_data->data->name;
        $new_user->username=$user_data->data->username;
        $new_user->description=$user_data->data->description;
        $new_user->image=$user_data->data->profile_image_url;
        $new_user->save();
        return $new_user;
    }

    public function updateStatus($id){
        $user = TwitterUser::findOrFail($id);
        $date = strtotime(date("Y-m-d H:i:s"));
        if (hours_between(strtotime($user->updated_at),$date)>=12) {
            $twitter_client = new Client(['base_uri' => env('TWITTER_API_ROUTE')]);
            $user_response = $twitter_client->request('GET', 
            '/2/users/'.$user->twitter_id.'?user.fields=profile_image_url,description', ['headers' => ['Authorization' => "Bearer ".env('TWITTER_BEARER_TOKEN')]]);
        
            $user_data=json_decode($user_response->getBody());
            $user->name=$user_data->data->name;
            $user->description=$user_data->data->description;
            $user->image=$user_data->data->profile_image_url;
            $user->save();
        }
    }   
}
