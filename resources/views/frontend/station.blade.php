@extends('frontend.layouts.main')

@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('public.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">{{ $sensor->name }}</li>
                </ol>
            </nav>
            <h1>{{ $sensor->name }}</h1>
            <p class="lead">{{ $sensor->location }}</p>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header">
                    <h5>Current Air Quality</h5>
                </div>
                <div class="card-body">
                    @if($sensor->latestReading && $sensor->latestReading->aqi !== null)
                        <div class="text-center">
                            <div class="display-1
                                @if($sensor->latestReading->aqi < 50) text-success
                                @elseif($sensor->latestReading->aqi < 100) text-warning
                                @elseif($sensor->latestReading->aqi < 150) text-danger
                                @else text-dark @endif">
                                {{ $sensor->latestReading->aqi }}
                            </div>
                            <p class="lead mt-3">
                                @if($sensor->latestReading->aqi < 50)
                                    Good
                                @elseif($sensor->latestReading->aqi < 100)
                                    Moderate
                                @elseif($sensor->latestReading->aqi < 150)
                                    Unhealthy
                                @else
                                    Very Unhealthy
                                @endif
                            </p>
                            <div class="text-muted">
                                Last updated {{ $sensor->latestReading->created_at->diffForHumans() }}
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-6">
                                <div class="card bg-light">
                                    <div class="card-body text-center">
                                        <h6>Temperature</h6>
                                        <h3>{{ $sensor->latestReading->temperature }}°C</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="card bg-light">
                                    <div class="card-body text-center">
                                        <h6>Humidity</h6>
                                        <h3>{{ $sensor->latestReading->humidity }}%</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-warning">
                            No readings available for this sensor.
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header">
                    <h5>Sensor Details</h5>
                </div>
                <div class="card-body">
                    <table class="table">
                        <tbody>
                            <tr>
                                <th>ID</th>
                                <td>{{ $sensor->id }}</td>
                            </tr>
                            <tr>
                                <th>Location</th>
                                <td>{{ $sensor->location }}</td>
                            </tr>
                            <tr>
                                <th>Coordinates</th>
                                <td>
                                    @if($sensor->latitude && $sensor->longitude)
                                        {{ $sensor->latitude }}, {{ $sensor->longitude }}
                                    @else
                                        Not available
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    @if($sensor->active)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-secondary">Inactive</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Installed</th>
                                <td>{{ $sensor->created_at->format('F j, Y') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>24 Hour AQI Trend</h5>
                </div>
                <div class="card-body">
                    <canvas id="hourlyChart" width="400" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Prepare data for the chart
        const hours = @json(array_keys($hourlyReadings->toArray()));
        const aqiData = @json(array_values($hourlyReadings->toArray()));

        // Create background colors based on AQI values
        const backgroundColors = aqiData.map(value => {
            if (value < 50) return 'rgba(40, 167, 69, 0.5)';   // Good
            if (value < 100) return 'rgba(255, 193, 7, 0.5)';  // Moderate
            if (value < 150) return 'rgba(220, 53, 69, 0.5)';  // Unhealthy
            return 'rgba(52, 58, 64, 0.5)';                    // Very Unhealthy
        });

        // Initialize the chart
        const ctx = document.getElementById('hourlyChart').getContext('2d');
        const hourlyChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: hours,
                datasets: [{
                    label: 'Hourly AQI',
                    data: aqiData,
                    backgroundColor: backgroundColors,
                    borderColor: backgroundColors.map(color => color.replace('0.5', '1')),
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Air Quality Index (AQI)'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Hour'
                        }
                    }
                }
            }
        });
    });
</script>
@endsection
