<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>TweetCheck</title>
    <link rel="icon" type="image/x-icon" href="/images/favicon.png">        
        <!-- CSS Dependencies -->
        <link href="{{ asset('css/main.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <link rel="stylesheet" href="https://unpkg.com/shards-ui@latest/dist/css/shards.min.css">
        <script src="https://kit.fontawesome.com/7fd29058f9.js" crossorigin="anonymous"></script>
</head>
<body>
    <!--NAVBAR-->
    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom border-light">
        <div class="container">
            <!--    
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            -->
            <a class="navbar-brand mx-auto" href="#">
                <img src="/images/logo.png" class="d-block d-md-none" height="20px" alt="">
                <img src="/images/logo.png" class="d-none d-md-block" height="30px" alt="">
            </a>
            <!--
            <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
                
            <ul class="navbar-nav mx-auto mt-2 mt-lg-0">
                <li class="nav-item active">
                <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="#">Link</a>
                </li>
                <li class="nav-item">
                <a class="nav-link disabled" href="#">Disabled</a>
                </li>
            </ul>

            <ul class="navbar-nav mt-2 mt-lg-0 ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
                      Configuración de cuenta
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                      <a class="dropdown-item" href="#">Mi perfil</a>
                      <a class="dropdown-item" href="#">Cambiar Contraseña</a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item text-danger" href="#">Cerrar sesión</a>
                    </div>
                  </li>
            </ul>

            </div>-->
        </div>
    </nav>
    <!--NAVBAR-->
    <!--MENU-->
    <div class="container menu-container">
        <ul class="nav nav-pills main-menu pr-5 pb-2 pt-1">
            <li class="nav-item">
                <a class="nav-link @if(Request::path() === '/') active @endif nav-menu-item" href="{{route('home')}}"><i class="fa-solid fa-bell"></i> Últimos tweets</a>
            </li>
            <li class="nav-item">
                <a class="nav-link nav-menu-item @if(Request::path() === 'verify') active @endif " href="{{route('verify-form')}}"><i class="fa-solid fa-magnifying-glass"></i> Verificar tweet</a>
            </li>
            <li class="nav-item nav-menu-item">
                <a class="nav-link nav-menu-item @if(Request::path() === 'hashtags') active @endif" href="{{route('hashtags')}}"><i class="fa-solid fa-hashtag"></i> Hashtags</a>
            </li>
            <li class="nav-item nav-menu-item">
                <a class="nav-link nav-menu-item @if(Request::path() === 'users') active @endif" href="{{route('users')}}"><i class="fa-solid fa-users"></i> Usuarios</a>
            </li>
        </ul>
        <div class="gradient"></div>
    </div>
    <div class="border-bottom border-light mt-n1 shadow-sm"></div>
    <!--MENU-->

    <div class="container my-5"  >   
        @yield('content')
    </div>
    <!-- Optional JavaScript -->
    <!-- JavaScript Dependencies: jQuery, Popper.js, Bootstrap JS, Shards JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/shards-ui@latest/dist/js/shards.min.js"></script>
</body>
</html>
