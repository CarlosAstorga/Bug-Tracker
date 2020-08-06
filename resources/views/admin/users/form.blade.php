@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <a>Asignar roles</a>
                    <a href="{{ route('admin.users.index') }}">Regresar al listado</a>
                </div>
                <img style="vertical-align:center; width:200px; height: 200px" id="avatar" class="rounded-circle card-img-top align-self-center mt-3" src="/images/{{$user->avatar}}" alt="Card image cap">
                <div class="card-body">

                    <form action="{{ route('admin.users.update', $user) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group row">

                            <div class="col-md-8 offset-md-2">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item text-center">
                                        <i class="fas fa-user form-check-input"></i>{{$user->name}}
                                    </li>
                                    @foreach($roles as $role)
                                    <li class="list-group-item">
                                        <input id="{{$role->title}}" class="form-check-input" type="checkbox" name="roles[]" value="{{ $role->id}}" @if($user->hasRole($role->title)) checked @endif>
                                        <label for="{{$role->title}}" class="form-check-label">{{ $role->title }}</label>`
                                    </li>

                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-8 offset-md-2">
                                <button type="submit" class="btn btn-success btn-block">
                                    Asignar
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