@extends('layout')
@section('content')
<div class="border-bottom mb-3">
    <h3>#{{$hashtag->word}}</h3>
    <p class="text-muted">{{count($hashtag->tweets)}} Tweets</p>
</div>

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
<div class="row justify-content-center">
    {{$tweets->links('pagination::bootstrap-4')}}
</div>
@endsection