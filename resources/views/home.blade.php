@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Dashboard</div>
                <div class="card-body">
                    <div id="dashboard" class="row">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="{{ asset('js/chart.js') }}" defer></script>
<script>
    window.onload = function() {
        initChart("{{ auth()->user()->name }}");
    }
</script>
@endsection