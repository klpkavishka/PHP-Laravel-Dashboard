@extends('admin.layouts.admin')

@section('title', 'Simulation Management')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>Data Simulation Configuration</h5>
    </div>
    <div class="card-body">
        <div class="mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <h6>Simulation Status</h6>
                <div>
                    <span class="badge {{ $config->status == 'running' ? 'bg-success' : 'bg-danger' }}">
                        {{ $config->status }}
                    </span>
                    <form action="{{ route('admin.simulation.toggle') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-sm {{ $config->status == 'running' ? 'btn-danger' : 'btn-success' }}">
                            {{ $config->status == 'running' ? 'Stop' : 'Start' }} Simulation
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <form action="{{ route('admin.simulation.update') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="frequency_minutes" class="form-label">Data Generation Frequency (minutes)</label>
                <input type="number" class="form-control" id="frequency_minutes" name="frequency_minutes"
                       value="{{ $config->frequency_minutes }}" min="1" max="60">
            </div>

            <div class="mb-3">
                <label for="baseline_aqi" class="form-label">Baseline AQI Level</label>
                <input type="number" class="form-control" id="baseline_aqi" name="baseline_aqi"
                       value="{{ $config->baseline_aqi }}" min="0" max="500">
            </div>

            <div class="mb-3">
                <label for="variation_range" class="form-label">Variation Range (±)</label>
                <input type="number" class="form-control" id="variation_range" name="variation_range"
                       value="{{ $config->variation_range }}" min="5" max="100">
            </div>

            <button type="submit" class="btn btn-primary">Save Configuration</button>
        </form>
    </div>
</div>
@endsection
