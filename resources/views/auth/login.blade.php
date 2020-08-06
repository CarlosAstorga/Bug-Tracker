<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Bug Tracker</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/login.js') }}" defer></script>


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        body {
            background:
                linear-gradient(27deg, #151515 5px, transparent 5px) 0 5px,
                linear-gradient(207deg, #151515 5px, transparent 5px) 10px 0px,
                linear-gradient(27deg, #222 5px, transparent 5px) 0px 10px,
                linear-gradient(207deg, #222 5px, transparent 5px) 10px 5px,
                linear-gradient(90deg, #1b1b1b 10px, transparent 10px),
                linear-gradient(#1d1d1d 25%, #1a1a1a 25%, #1a1a1a 50%, transparent 50%, transparent 75%, #242424 75%, #242424);
            background-color: #131313;
            background-size: 20px 20px;
        }

        .card {
            height: 32rem;
        }
    </style>

</head>

<body>
    <div class="container">
        <div class="row align-items-center justify-content-center" style="height: 100vh;">
            <div class="col-md-6 align-self-center">
                <div class="card">
                    <div class="card-header">Iniciar sesión</div>

                    <div class="card-body">
                        <div class="row justify-content-center mt-3">
                            <i style="font-size: 3rem" class="fas fa-spider"></i>
                        </div>
                        <div class="row justify-content-center mb-3 mt-3 text-secondary" style="font-family: 'Nunito', sans-serif;font-size: 2rem">
                            Bug Tracker
                        </div>
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="form-row mb-3">
                                <div class="input-group col-md-8 offset-md-2">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Correo electrónico">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-at"></i></span>
                                    </div>

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row mb-3">
                                <div class="input-group col-md-8 offset-md-2">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Contraseña">

                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-key"></i></span>
                                    </div>


                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-8 offset-md-2">
                                    <button type="submit" class="btn btn-primary btn-block">
                                        Entrar
                                    </button>
                                </div>
                            </div>
                        </form>

                        <div class="form-row justify-content-center mt-3">
                            @if (Route::has('register'))
                            <div>
                                No tienes cuenta?&nbsp;<a href="{{ route('register') }}">Registrate</a>
                            </div>
                            @endif

                        </div>
                        @if (Route::has('register'))
                        <div class="form-row justify-content-center">
                            ó
                        </div>
                        @endif

                        <form id="demo" method="POST" action="{{ route('login.demo') }}">
                            @csrf
                            <div class="form-row justify-content-center mb-4">
                                Entra con un&nbsp;<a onclick="document.getElementById('demo').submit();" class="text-primary" role="button"> usuario de prueba</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>