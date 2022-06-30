@extends('layout')
@section('content')

    <div class="border-light border-bottom mb-3">
        <div class="row mb-3 mx-2">
            <img class="rounded-circle profile-thumb" src="{{$tweet->user->image}}" alt="">
            <div class="col ml-3">
                <h6 class="profile-name">{{$tweet->user->name}}</h6>
                <small>{{$tweet->user->username}}</small>
            </div>
        </div>
        <div class="row mb-3 mx-2">
            <div class="col">
                <p class="item-content">{{$tweet->text}}</p>
                @foreach($tweet->hashtags as $hashtag)
                    <a href="">#{{$hashtag->word}}</a>
                @endforeach
                <div class="row my-3">
                    <small class="mr-3" title="Retweets" ><i class="fa-solid fa-retweet"></i> {{$tweet->retweets}}</small>
                    <small class="mr-3" title="Likes" ><i class="fa-solid fa-heart"></i> {{$tweet->likes}}</small>
                    <small class="mr-3" title="Respuestas" ><i class="fa-solid fa-comment"></i> {{$tweet->replies}}</small>
                    <small class="mr-3" title="Citas" ><i class="fa-solid fa-quote-left"></i> {{$tweet->quotes}}</small>
                </div>
                <small class="text-muted">{{$tweet->posted_at}} - verificado en: {{$tweet->created_at}}</small>
            </div>
        </div>
    </div>
    <div class="">
        <ul class="nav nav-pills nav-justified mb-3" id="pills-tab" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Análisis del lenguaje</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="pills-media-tab" data-toggle="pill" href="#pills-media" role="tab" aria-controls="pills-media" aria-selected="false">Medios</a>
            </li>
            @if(count($fact_checks)>0)
            <li class="nav-item">
              <a class="nav-link" id="pills-factchecks-tab" data-toggle="pill" href="#pills-factchecks" role="tab" aria-controls="pills-factchecks" aria-selected="false">Verificaciones recientes</a>
            </li>
            @endif
          </ul>
          <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                <h5>Análisis del lenguaje</h5>
                <div class="card">
                    <div class="card-body">
                        Polaridad
                        <div class="row mb-3">
                            <div class="col pr-0 mr-0">
                                <div class="progress progress-lg justify-content-end border-right" style="border-radius:10px 0 0 10px" id="polarity1">
                                    @if ($tweet->polarity < 0)
                                        <div class="progress-bar bg-danger" role="progressbar" style="width: {{abs($tweet->polarity*100)}}%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" >-{{abs($tweet->polarity*100)}}% </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col pl-0 ml-0">
                                <div class="progress progress-lg border-left" style="border-radius:0 10px 10px 0" id="polarity2">
                                    @if ($tweet->polarity >= 0)
                                        <div class="progress-bar bg-success text-dark" role="progressbar" style="width: {{abs($tweet->polarity*100)}}%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">+{{abs($tweet->polarity*100)}}%</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        Subjetividad
                        <div class="row mb-3">
                            <div class="col">
                                <div class="progress progress-lg" >
                                    <div class="progress-bar" role="progressbar" style="width: {{abs($tweet->subjectivity*100)}}%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">{{abs($tweet->subjectivity*100)}}%</div>
                                </div>
                            </div>
                        </div>
                        Toxicidad
                        <div class="row mb-3">
                            <div class="col">
                                <div class="progress progress-lg" >
                                    <div class="progress-bar bg-warning text-dark" role="progressbar" style="width: {{abs($tweet->toxicity_rate*100)}}%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">{{abs($tweet->toxicity_rate*100)}}%</div>
                                </div>
                            </div>
                        </div>
                        Afirmaciones en el texto (Claims): 
                        @if ($tweet->claim)
                            <button type="button" class=" ml-3 btn btn-outline-success btn-pill disabled">Si</button>
                        @else
                            <button type="button" class=" ml-3 btn btn-outline-danger btn-pill disabled">No</button>
                        @endif
                    </div>    
                </div> 
            </div>
            <div class="tab-pane fade" id="pills-media" role="tabpanel" aria-labelledby="pills-media-tab">
                <h5 class="mb-3">Medios</h5>
                <ul class="list-group">
                    @foreach ($tweet->media as $media)
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-6 col-md-4">
                                    <img src="{{$media->url}}" class="rounded"  style="height:150px;width:100%;object-fit: cover;object-position:center center;">
                                </div>
                                <div class="col-6 col-md-8">
                                    <div class="row">
                                        <div class="col-12 col-md-6 mt-md-5">
                                            @switch($media->type)
                                                @case('photo')
                                                    <h6 class="ml-3 ml-md-5">
                                                        <i class="fa-regular fa-images mr-2"></i> Imagen
                                                    </h6>
                                                    @break
                                            
                                                @case('video')
                                                    <i class="fa-solid fa-video mr-2"></i> Video
                                                    @break
                                            
                                                @default
                                                    <i class="fa fa-file-image-o mr-2"></i> GIF
                                            @endswitch
                                        </div>
                                        <div class="col-12 col-md-6 mt-md-5">
                                            <a href="https://www.google.com/searchbyimage?site=search&sa=X&image_url={{$media->url}}" target="_blank" class="btn btn-outline-primary btn-pill">Ver en Google</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
            @if(count($fact_checks)>0)
            <div class="tab-pane fade" id="pills-factchecks" role="tabpanel" aria-labelledby="pills-factchecks-tab">
                <h5 class="mb-3">Verificaciones relacionadas</h5>
                <div class="row">
                    @foreach ($fact_checks as $fact)
                    <div class="col-sm-6 col-md-3">
                        <div class="card mb-3">
                            <div class="card-body">
                                <p class="card-title">{{$fact->text}}</p>
                                @if(isset($fact->claimDate))
                                <small>{{substr_replace($fact->claimDate,"", -10)}}</small>
                                @endif
                                <br>
                                <small> <b>Verificado por:</b> </small>
                                <ul class="list-group list-group-flush">
                                    @foreach ($fact->claimReview as $rev)

                                        <li class="list-group-item">{{$rev->publisher->name}}: <a href="{{$rev->url}}" target="_blank" ><b>{{$rev->textualRating}}</b> </a></li>

                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
            </div>
            @endif
    </div>

@endsection