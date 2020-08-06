@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Verifica tu cuenta</div>

                <div class="card-body">
                    @if (session('resent'))
                    <div class="alert alert-success" role="alert">
                        Un enlace de verificación ha sido enviado a tu dirección de correo electrónico
                    </div>
                    @endif

                    Antes de proceder, revisa tu correo por un enlace de verificación.
                    Si no recibiste el correo
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">Da click aqui para solicitar otro</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection