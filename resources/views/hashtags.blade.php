@extends('layout')
@section('content')
    <div class="border-bottom mb-3">
        <form action="{{route('hashtags')}}" method="get">
            <div class="row justify-content-center mb-3">
                <div class="col-12">
                    <div class="row">
                        <div class="col-12 col-md-10 mb-3">
                            <input type="text" class="form-control" placeholder="Buscar Hashtag" aria-describedby="button-addon2" name="search" style="border-radius:20px">
                        </div>
                        <div class="col-12 col-md-2 mb-3">
                            <button class="btn btn-block btn-primary btn-pill" type="submit" id="button-addon2"><b>Buscar</b></button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <h3>Hashtags</h3>
    @if (count($hashtags)==0)
        <small class="text-muted">No hay Hashtags</small>
    @else
        @foreach($hashtags as $hashtag)
            <a href="{{route('hashtag',$hashtag->id)}}" class="btn btn-outline-primary btn-pill mb-2">
                #{{$hashtag->word}}
            </a>
        @endforeach
    @endif
    
@endsection