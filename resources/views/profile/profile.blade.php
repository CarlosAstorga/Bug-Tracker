@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header justify-content-between d-flex">
                    <a>Mi perfil</a>
                    <a href="{{ url('profile/edit') }}">Editar</a>
                </div>
                @if ($message = Session::get('success'))
                <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{{ $message }}</strong>
                </div>
                @endif
                <img style="vertical-align:center; width:200px; height: 200px" id="avatar" class="rounded-circle card-img-top align-self-center mt-3" src="/images/{{auth()->user()->avatar}}" alt="Card image cap">
                <div class="card-body justify-content-center d-flex">
                    <ul class="list-group list-group-flush mt-3">
                        <li class="list-group-item"><i class="fas fa-user mr-3"></i>{{auth()->user()->name}}</li>
                        <li class="list-group-item"><i class="fas fa-tag mr-3"></i>{{auth()->user()->join_roles}}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection