@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Usuarios</div>
                <div class="card-body">
                    <div id="users" data-role="{{ auth()->user()->highest_role }}"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection