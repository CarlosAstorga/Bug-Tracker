@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <a>Proyectos</a>
                    <a href="{{ route('projects.create') }}">Nuevo proyecto</a>
                </div>
                <div class="card-body">
                    <div id="projects" data-role="{{ auth()->user()->highest_role }}"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection