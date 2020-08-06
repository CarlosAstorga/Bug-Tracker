@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <a>Detalles del proyecto</a>
                    <span>
                        <a href="{{ route('projects.edit', $project->id) }}">Editar</a> |
                        <a href="{{ route('projects.index') }}">Regresar al listado</a>
                    </span>
                </div>

                <div class="card-body">
                    <div class="form-group row">
                        <label for="title" class="col-md-3 col-form-label text-md-right font-weight-bold">Título</label>

                        <div class="col-md-7">
                            <input id="title" type="text" readonly class="form-control-plaintext" name="title" value="{{ $project->title }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="description" class="col-md-3 col-form-label text-md-right font-weight-bold">Descripción</label>

                        <div class="col-md-7">
                            <textarea id="description" readonly style="resize: none;" class="form-control-plaintext" name="description">{{ $project->description }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    Usuarios asignados
                </div>
                <div class="card-body">
                    <div id="projectUsers"></div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    Tickets relacionados
                </div>
                <div class="card-body">
                    <div id="projectTickets"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection