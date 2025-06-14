@extends('admin.layouts.admin')

@section('content')
    <div class="row">
        <!-- Stats Cards -->
        <div class="col-md-3">
            <div class="card bg-light">
                <div class="card-body">
                    <h5>Active Sensors</h5>
                    <h2>{{ $activeSensors }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-light">
                <div class="card-body">
                    <h5>Total Users</h5>
                    <h2>{{ $totalUsers }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-light">
                <div class="card-body">
                    <h5>Active Alerts</h5>
                    <h2>{{ $activeAlerts }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-light">
                <div class="card-body">
                    <h5>Data Points Today</h5>
                    <h2>{{ number_format($todayDataPoints/1000, 1) }}k</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <!-- Sensor Network Map -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5>Sensor Network</h5>
                </div>
                <div class="card-body" style="height: 400px;">
                    <div id="sensor-map" style="height: 100%;">
                        <p class="text-center text-muted my-5">Map Integration Coming Soon</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Alerts -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5>Recent Alerts</h5>
                </div>
                <div class="card-body">
                    @foreach($recentAlerts as $alert)
                        <div class="alert-item d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h6>{{ $alert->sensor->name }}</h6>
                                <small>{{ $alert->created_at->diffForHumans() }}</small>
                            </div>
                            <div>
                                @if($alert->sensor->latest_reading)
                                <span class="badge @if($alert->sensor->latest_reading->aqi < 50) bg-success
                                    @elseif($alert->sensor->latest_reading->aqi < 100) bg-warning
                                    @else bg-danger @endif">
                                    AQI: {{ $alert->sensor->latest_reading->aqi }}
                                </span>
                                @else
                                <span class="badge bg-secondary">No Data</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
