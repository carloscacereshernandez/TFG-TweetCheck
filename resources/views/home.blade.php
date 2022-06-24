@extends('layout')
@section('content')

<h3 class="mb-3">Verificar un tweet</h3>
<form action="{{route('verify')}}" method="post">
    @csrf
    <div class="input-group mb-3" >
        <input type="text" class="form-control verify-form" placeholder="Tweet Link" aria-describedby="button-addon2" name="tweetLink">
        <div class="input-group-append">
            <button class="btn btn-primary verify-button" type="submit" id="button-addon2"><b>Verificar</b></button>
        </div>
    </div>
</form>

<hr>

<div class="mt-5">

    <h3 class="mt-3">Últimos Tweets</h3>
    <p class="mb-5">¡Descubre los últimos tweets verificados de la plataforma!</p>

    <a class="tweet-link" href="">
        <div class="card item mb-5 tweetCard">
            <div class="card-body text-dark">
                <div class="row mb-3 mx-2">
                    <img class="rounded-circle profile-thumb" src="data:image/png;base64,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" alt="">
                    <div class="col ml-3">
                        <h6 class="profile-name">Nombre del perfil</h6>
                        <small>@nombre_del_perfil</small>
                    </div>
                </div>
                <div class="row mb-3 mx-2">
                    <div class="col">
                        <p class="item-content"> This is some text within a card block.</p>
                        <small class="text-muted">15/11/2021 14:20</small>
                    </div>
                </div>
            
                <div class="row mx-2">
                        <span><i class="fa-regular fa-images mr-2"></i> +5 </span>
                        <span><i class="fa-solid fa-video ml-3 mr-2"></i> 1 </span>
                </div>
            </div>
        </div>
    </a>
    <a class="tweet-link" href="">
        <div class="card item mb-5 tweetCard">
            <div class="card-body text-dark">
                <div class="row mb-3 mx-2">
                    <img class="rounded-circle profile-thumb" src="data:image/png;base64,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" alt="">
                    <div class="col ml-3">
                        <h6 class="profile-name">Nombre del perfil</h6>
                        <small>@nombre_del_perfil</small>
                    </div>
                </div>
                <div class="row mb-3 mx-2">
                    <div class="col">
                        <p class="item-content"> This is some text within a card block.</p>
                        <small class="text-muted">15/11/2021 14:20</small>
                    </div>
                </div>
            
                <div class="row mx-2">
                        <span><i class="fa-regular fa-images mr-2"></i> +5 </span>
                        <span><i class="fa-solid fa-video ml-3 mr-2"></i> 1 </span>
                </div>
            </div>
        </div>
    </a>
</div>


@endsection