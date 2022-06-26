@extends('layout')
@section('content')

<h3 class="mb-3">Verificar un tweet</h3>
<form action="{{route('verify')}}" method="post">
    @csrf
    <div class="input-group mb-3" >
        <input type="text" class="form-control verify-form @if (Session::has('error'))is-invalid @endif" placeholder="Tweet Link" aria-describedby="button-addon2" name="tweetLink">
        <div class="input-group-append">
            <button class="btn btn-primary verify-button" type="submit" id="button-addon2"><b>Verificar</b></button>
        </div>
        @if (Session::has('error'))
            <div class="invalid-feedback ml-3">{{Session::get('error')}}</div>
        @endif
    </div>
</form>

<hr>

<div class="mt-5">

    <h3 class="mt-3">Últimos Tweets</h3>
    <p class="mb-5">¡Descubre los últimos tweets verificados de la plataforma!</p>

    @foreach ($tweets as $tweet)
        <a class="tweet-link" href="{{route('tweet.detail',$tweet->id)}}">
            <div class="card item mb-5 tweetCard">
                <div class="card-body text-dark">
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
                            <small class="text-muted">{{$tweet->posted_at}}</small>
                        </div>
                    </div>
                
                    <div class="row mx-2">
                            @if(count($tweet->photos()))<span><i class="fa-regular fa-images mr-2"></i> {{count($tweet->photos())}} </span>@endif
                            @if(count($tweet->videos()))<span><i class="fa-solid fa-video ml-3 mr-2"></i> {{count($tweet->videos())}}  </span>@endif
                            @if(count($tweet->gifs()))<span><i class="fa fa-file-image-o ml-3 mr-2"></i> {{count($tweet->gifs())}} </span>@endif
                    </div>
                </div>
            </div>
        </a>
    @endforeach
    
    
</div>


@endsection