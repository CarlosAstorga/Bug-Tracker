@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <a>Tickets</a>
                    <a href="{{ route('tickets.create') }}">Nuevo ticket</a>
                </div>

                <div class="card-body">
                    <div id="tickets" data-role="{{ auth()->user()->highest_role }}"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection