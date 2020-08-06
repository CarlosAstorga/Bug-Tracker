@extends('layouts.app')
@section('css')
<style>
    .invalid-value {
        color: red;
        font-size: 80%;
    }

    .sticky-item {
        position: sticky;
        top: 0
    }
</style>
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <a>Detalles del ticket</a>
                    <a href=" {{ route('tickets.index') }}">Regresar al listado</a>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <label for="title" class="col-md-3 col-form-label text-md-right font-weight-bold">Título</label>

                        <div class="col-md-7">
                            <input id="title" type="text" readonly class="form-control-plaintext" name="title" value="{{ $ticket->title }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="description" class="col-md-3 col-form-label text-md-right font-weight-bold">Descripción</label>

                        <div class="col-md-7">
                            <textarea id="description" readonly style="resize: none;" class="form-control-plaintext" name="description">{{ $ticket->description }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">Archivos</div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <div class="custom-file">
                                <input id="fileInput" type="file" class="custom-file-input" accept=".jpeg,.png,.jpg,.gif,.svg,.pdf" lang="es" name="file">
                                <label class="custom-file-label" style="width:100%; white-space: nowrap; overflow:hidden;" for="fileInput">Seleccionar archivo</label>
                            </div>
                        </div>
                        <div class="col-md-6 offset-md-2">
                            <div class="input-group">
                                <input id="inputDesc" name="notes" type="text" class="form-control" placeholder="Añadir una descripción" maxlength="50">
                                <div class="input-group-append">
                                    <button id="submitButton" class="btn btn-success">Guardar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-5">
                        <div class="col-md-12">
                            <div class="table-responsive" style="height: 305px;">
                                <table class="table table-striped table-bordered">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th class="sticky-item">Archivo</th>
                                            <th class="sticky-item">Descripción</th>
                                            <th class="sticky-item">Subido por</th>
                                            <th class="sticky-item">Subido el dia</th>
                                            @can('manage-projects')
                                            <th class="sticky-item" style="width: 10%">Acciones</th>
                                            @endcan
                                        </tr>
                                    </thead>
                                    <tbody id="fileTable">
                                        @if(count($ticket->files) <= 0) <tr>
                                            <td style="text-align: center;" colspan="5"><i>No se encontraron registros</i></td>
                                            </tr>
                                            @endif
                                            @foreach($ticket->files as $file)
                                            <tr id="file-{{$file->id}}">
                                                <td>
                                                    <a href="{{ route('file.download', $file->id) }}">Descargar Archivo</a>
                                                </td>
                                                <td>{{$file->notes}}</td>
                                                <td>{{$file->uploader->name}}</td>
                                                <td>{{$file->created_at->format('d/m/Y g:i:s')}}</td>
                                                @can('manage-projects')
                                                <td class="p-0 d-flex">
                                                    <a class="flex-fill btn btn-light" style="line-height: 3; border-radius: 0">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </td>
                                                @endcan
                                            </tr>
                                            @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">Comentarios</div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6 offset-md-6">
                            <div class="input-group">
                                <input id="inputComment" type="text" name="message" class="form-control" placeholder="Añadir un comentario" maxlength="50">
                                <div class="input-group-append">
                                    <button id="submitComment" class="btn btn-success">Guardar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive" style="height: 305px;">
                                <table class="table table-striped table-bordered">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th class="sticky-item">Creado por</th>
                                            <th class="sticky-item">Comentario</th>
                                            <th class="sticky-item">Creado el día</th>
                                            @can('manage-projects')
                                            <th class="sticky-item" style="width: 10%">Acciones</th>
                                            @endcan
                                        </tr>
                                    </thead>
                                    <tbody id="commentTable">
                                        @if(count($ticket->comments) <= 0) <tr>
                                            <td style="text-align: center;" colspan="4"><i>No se encontraron registros</i></td>
                                            </tr>
                                            @endif
                                            @foreach($ticket->comments as $comment)
                                            <tr id="comment-{{$comment->id}}">
                                                <td>{{$comment->submitter->name}}</td>
                                                <td>{{$comment->message}}</td>
                                                <td>{{$comment->created_at->format('d/m/Y g:i:s')}}</td>
                                                @can('manage-projects')
                                                <td class="p-0 d-flex">
                                                    <a class="flex-fill btn btn-light" style="line-height: 3; border-radius: 0">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </td>
                                                @endcan
                                            </tr>
                                            @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('scripts')
<script src="{{ asset('js/ticket/ticket.js') }}" defer></script>
<script>
    window.onload = function() {
        initTicket("{{ count($ticket->files) }}", "{{ count($ticket->comments) }}", "{{ $ticket->id }}", "{{ $role }}");
    }
</script>
@endsection