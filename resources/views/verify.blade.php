@extends('layout')
@section('content')
<div class="d-none d-md-block" style="position:absolute;top:40%;left:50%; width:50%;transform:translate(-50%,-50%);">
    <div class="card">
        <div class="card-body">
            <h3 class="mb-3">Verificar un tweet</h3>
            <p>Introduce un enlace al tweet que quieres verificar, y automaticamente recibe información sobre la veracidad de su contenido.</p>
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
        </div>
    </div>
</div>
<div class="d-block d-md-none">
    <div class="card">
        <div class="card-body">
            <h3 class="mb-3">Verificar un tweet</h3>
            <p>Introduce un enlace al tweet que quieres verificar, y automaticamente recibe información sobre la veracidad de su contenido.</p>
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
        </div>
    </div>
</div>
@endsection