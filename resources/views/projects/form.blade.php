@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if($project->exists)
            <form id="form" method="POST" action=" {{ route('projects.update', $project->id )}}">
                @method('PUT')
                @else
                <form id="form" method="POST" action=" {{ route('projects.store')}}">
                    @endif
                    @csrf
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            @if($project->exists)
                            <a>Detalles del proyecto</a>
                            @else
                            <a>Nuevo proyecto</a>
                            @endif
                            <a href="{{ route('projects.index') }}">Regresar al listado</a>
                        </div>

                        <div class="card-body">
                            <div class="form-group row">
                                <label for="title" class="col-md-3 col-form-label text-md-right">Título</label>

                                <div class="col-md-7">
                                    <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title', $project->title) }}" required autocomplete="title" autofocus maxlength="50">

                                    @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="description" class="col-md-3 col-form-label text-md-right">Descripción</label>

                                <div class="col-md-7">
                                    <textarea id="description" style="resize: none;" class="form-control @error('description') is-invalid @enderror" name="description" required autocomplete="description" autofocus maxlength="100">{{ old('description', $project->description) }}</textarea>

                                    @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="card">
                        <div class="card-header">Asignar usuarios</div>
                        <div class="card-body">

                            <div class="row">
                                <div class="col-md-5">
                                    <div class="input-group mb-3">
                                        <input id="search" type="text" class="form-control" placeholder="Buscar.." />
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                <i id="userListIcon" class="fas fa-search"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <ul id="userList" class="list-group list-group-flush" style="height: 325px; overflow:auto;">
                                    </ul>
                                </div>

                                <div class="col-md-7">
                                    <div class="input-group mb-3">
                                        <input id="searchUsers" type="text" class="form-control" placeholder="Buscar.." />
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                <i id="icon" class="fas fa-search"></i>
                                            </span>
                                        </div>
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-success">
                                                @if($project->exists)
                                                Guardar
                                                @else
                                                Registrar
                                                @endif
                                            </button>
                                        </div>
                                    </div>
                                    <div class="table-responsive" style="height: 325px;">
                                        <table class="table table-striped table-bordered table-sm">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th style="position: sticky; top: 0">Nombre</th>
                                                    <th style="position: sticky; top: 0">Rol</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tbody">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
        </div>
    </div>
</div>

@endsection
@section('scripts')
<script src="{{ asset('js/project/form.js') }}" defer></script>
<script>
    window.onload = function() {
        initProjectForm("{{ $project->id }}");
    }
</script>
@endsection