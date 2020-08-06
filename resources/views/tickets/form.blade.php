@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    @if($ticket->exists)
                    <a>Editar Ticket</a>
                    @else
                    <a>Nuevo Ticket</a>
                    @endif
                    <a href="{{ route('tickets.index') }}">Regresar al listado</a>
                </div>

                <div class="card-body">
                    @if($ticket->exists)
                    <form id="form" method="POST" action=" {{ route('tickets.update', $ticket->id )}}">
                        @method('PUT')
                        @else
                        <form id="form" method="POST" action=" {{ route('tickets.store')}}">
                            @endif
                            @csrf

                            <div class="form-row">

                                <div class="form-group col-md-12">
                                    <label for="title">Título</label>
                                    <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title', $ticket->title) }}" required autocomplete="title" autofocus maxlength="50">

                                    @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row">

                                <div class="form-group col-md-12">
                                    <label for="description">Descripción</label>

                                    <textarea id="description" style="resize: none;" class="form-control @error('description') is-invalid @enderror" name="description" required autocomplete="description" autofocus maxlength="100">{{ old('description', $ticket->description) }}</textarea>

                                    @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="category">Categoria</label>

                                    <select name="category_id" class="custom-select @error('category_id') is-invalid @enderror" id="category" required autofocus>
                                        <option hidden value="0"></option>
                                        @foreach($catalogs['category'] as $option)
                                        @if(old('category_id') == $option->id)
                                        <option value="{{$option->id}}" selected>{{$option->title}}</option>
                                        @elseif($ticket->category_id == $option->id && old('category_id') == null)
                                        <option value="{{$option->id}}" selected>{{$option->title}}</option>
                                        @else
                                        <option value="{{$option->id}}">{{$option->title}}</option>
                                        @endif
                                        @endforeach
                                    </select>

                                    @error('category_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            @can('assign-users')
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="priority">Prioridad</label>
                                    <select name="priority_id" class="custom-select @error('priority_id') is-invalid @enderror" id="priority" required autofocus>
                                        <option hidden value="0"></option>
                                        @foreach($catalogs['priority'] as $option)
                                        @if(old('priority_id') == $option->id)
                                        <option value="{{$option->id}}" selected>{{$option->title}}</option>
                                        @elseif($ticket->priority_id == $option->id && old('priority_id') == null)
                                        <option value="{{$option->id}}" selected>{{$option->title}}</option>
                                        @else
                                        <option value="{{$option->id}}">{{$option->title}}</option>
                                        @endif
                                        @endforeach
                                    </select>

                                    @error('priority_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="project">Proyecto</label>
                                    <select name="project_id" class="custom-select @error('project_id') is-invalid @enderror" id="project" required autofocus>
                                        <option hidden value="0"></option>
                                        @if (count($catalogs['project']) <= 0) <option disabled>Asigna usuarios a un proyecto</option>
                                            @endif
                                            @foreach($catalogs['project'] as $option)
                                            @if(old('project_id') == $option->id)
                                            <option value="{{$option->id}}" selected>{{$option->title}}</option>
                                            @elseif($ticket->project_id == $option->id && old('project_id') == null)
                                            <option value="{{$option->id}}" selected>{{$option->title}}</option>
                                            @else
                                            <option value="{{$option->id}}">{{$option->title}}</option>
                                            @endif
                                            @endforeach
                                    </select>

                                    @error('project_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="developer">Encargado</label>
                                    <select name="developer_id" class="custom-select @error('developer_id') is-invalid @enderror" id="developer" required autofocus>
                                        <option hidden value="0"></option>
                                        <option disabled>Selecciona un proyecto</option>
                                    </select>

                                    @error('developer_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="status">Estatus</label>
                                    <select name="status_id" class="custom-select @error('status_id') is-invalid @enderror" id="status" required autofocus>
                                        <option hidden value="0"></option>
                                        @foreach($catalogs['status'] as $option)
                                        @if(old('status_id') == $option->id)
                                        <option value="{{$option->id}}" selected>{{$option->title}}</option>
                                        @elseif($ticket->status_id == $option->id && old('status_id') == null)
                                        <option value="{{$option->id}}" selected>{{$option->title}}</option>
                                        @else
                                        <option value="{{$option->id}}">{{$option->title}}</option>
                                        @endif
                                        @endforeach
                                    </select>

                                    @error('status_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>


                            </div>

                            @elsecan('change-status')
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="status">Estatus</label>
                                    <select name="status_id" class="custom-select @error('status_id') is-invalid @enderror" id="status" required autofocus>
                                        <option hidden value="0"></option>
                                        @foreach($catalogs['status'] as $option)
                                        @if(old('status_id') == $option->id)
                                        <option value="{{$option->id}}" selected>{{$option->title}}</option>
                                        @elseif($ticket->status_id == $option->id && old('status_id') == null)
                                        <option value="{{$option->id}}" selected>{{$option->title}}</option>
                                        @else
                                        <option value="{{$option->id}}">{{$option->title}}</option>
                                        @endif
                                        @endforeach
                                    </select>

                                    @error('status_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            @endcan
                            <div class="form-group row mt-3">
                                <div class="col-md-12">
                                    <button id="submitButton" type="button" class="btn btn-success btn-block">
                                        Registrar
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
<script>
    let isSaving = false;
    const button = document.getElementById('submitButton');
    const form = document.getElementById('form');
    const fragment = document.createDocumentFragment();
    const users = document.getElementById('developer');
    const oldValue = "{{old('developer_id')}}";
    if (document.getElementById('project')) {
        const project = document.getElementById('project');

        if (project.value > 0) {
            fetchUsers(project.value);
        }

        project.addEventListener('change', e => {
            fetchUsers(e.target.value);
        });
    }

    button.addEventListener('click', e => {
        if (!isSaving) {
            isSaving = true;
            form.submit();
        }
    });

    function fetchUsers(id) {
        fetch(`/projects/${id}/users/list`)
            .then(response => response.json())
            .then(response => {
                users.innerHTML = `<option hidden value="0"></option>`;
                response.data.forEach(user => {
                    const option = document.createElement('option');
                    option.value = user.id;
                    if (oldValue == user.id) {
                        option.selected = true;
                    } else if ("{{$ticket->developer_id}}" == user.id &&
                        oldValue == false) {
                        option.selected = true;
                    }

                    option.textContent = user.name;
                    fragment.appendChild(option);
                });
                users.appendChild(fragment);
                while (fragment.firstChild) {
                    fragment.removeChild(fragment.firstChild);
                }
            });
    }
</script>
@endsection