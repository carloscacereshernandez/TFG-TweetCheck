@extends('layout')
@section('content')
    <div class="border-bottom mb-3">
        <form action="{{route('users')}}" method="get">
            <div class="row justify-content-center mb-3">
                <div class="col-12">
                    <div class="row">
                        <div class="col-12 col-md-10 mb-3">
                            <input type="text" class="form-control" placeholder="Buscar Usuario" aria-describedby="button-addon2" name="search" style="border-radius:20px">
                        </div>
                        <div class="col-12 col-md-2 mb-3">
                            <button class="btn btn-block btn-primary btn-pill" type="submit" id="button-addon2"><b>Buscar</b></button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <h3>Usuarios</h3>
    @if (count($users)==0)
        <small class="text-muted">No hay usuarios</small>
    @else
    <div class="row mt-5">
        @foreach($users as $user)
            <div class="col-6 col-md-3 mb-3">
                <a class="tweet-link" href="{{route('user',$user->id)}}">
                    <div class="card tweetCard" >
                        <div class="card-body text-dark" style="height: 150px">
                            <div class="row">
                                <div class="col-12 mb-2">
                                    <div class="row justify-content-center">
                                        <img class="rounded-circle profile-thumb" src="{{$user->image}}" alt="">
                                    </div>
                                </div>
                                <div class="col-12">
                                    
                                        <h6 class="profile-name">{{$user->name}}</h6>
                                        <small>@ {{$user->username}} </small>
                                      
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div> 
    <div class="row justify-content-center">
        {{$users->links('pagination::bootstrap-4')}}
    </div>
    @endif
    
@endsection