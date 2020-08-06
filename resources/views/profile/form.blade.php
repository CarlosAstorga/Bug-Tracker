@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header justify-content-between d-flex">
                    <a>Editar perfil</a>
                    <a href="{{ url('profile') }}">Regresar</a>
                </div>
                <img style="vertical-align:center; width:200px; height: 200px" id="avatar" class="rounded-circle card-img-top align-self-center mt-3" src="/images/{{auth()->user()->avatar}}" alt="Card image cap">
                @if (count($errors) > 0)
                <div class="alert alert-danger mt-3 mb-0">
                    <strong>Error!</strong> No se pudo completar la acción
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <div class="card-body">
                    <form method="POST" action=" {{ route('profile.update', auth()->user()->id)}}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-10 offset-md-1">
                                <div class="custom-file">
                                    <input id="imageInput" type="file" class="custom-file-input" accept=".jpeg,.png,.jpg" lang="es" name="avatar">
                                    <label id="label" class="custom-file-label" style="width:100%; white-space: nowrap; overflow:hidden;" for="imageInput">Seleccionar imagen</label>
                                </div>
                            </div>

                        </div>

                        <div class="row mt-3">
                            <div class="input-group col-md-10 offset-md-1">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" autocomplete="name" autofocus placeholder="Usuario" maxlength="40">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                </div>

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mt-3 mb-3">
                            <div class="col-md-10 offset-md-1">
                                <button id="submit" type="submit" class="btn btn-success btn-block">
                                    Guardar cambios
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="{{ asset('js/profile.js') }}" defer></script>
@endsection