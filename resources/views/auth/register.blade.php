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
                    <div class="card-header d-flex justify-content-between">
                        Regístrate
                        <a href=" {{ route('login') }}">Iniciar sesión</a>
                    </div>

                    <div class="card-body">
                        <div class="row justify-content-center mt-3">
                            <i style="font-size: 3rem" class="fas fa-spider"></i>
                        </div>
                        <div class="row justify-content-center mb-3 mt-3 text-secondary" style="font-family: 'Nunito', sans-serif;font-size: 2rem">
                            Bug Tracker
                        </div>
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="form-row mb-3">
                                <div class="input-group offset-md-2 col-md-8">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Nombre">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-signature"></i></span>
                                    </div>

                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row  mb-3">
                                <div class="input-group offset-md-2 col-md-8">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Correo electronico">
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

                            <div class="form-row  mb-3">
                                <div class="input-group offset-md-2 col-md-8">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Contraseña">
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

                            <div class="form-row  mb-3">
                                <div class="input-group offset-md-2 col-md-8">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Repetir contraseña">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-key"></i></span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <div class="col-md-8 offset-md-2">
                                    <button type="submit" class="btn btn-primary btn-block">
                                        Registrarse
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>