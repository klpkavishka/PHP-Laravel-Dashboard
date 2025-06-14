<!-- resources/views/frontend/dashboard.blade.php -->
@extends('frontend.layouts.app')

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-12">
            <h1>Air Quality Dashboard</h1>
            <p class="lead">Real-time air quality monitoring across monitoring stations</p>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Air Quality Map</h5>
                </div>
                <div class="card-body p-0">
                    <div id="map" style="height: 500px;"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Location Information</h5>
                </div>
                <div class="card-body">
                    <h4 id="selected-location">Select a location</h4>
                    <div class="row mt-3">
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <h6>AQI</h6>
                                    <h3 id="aqi-value">-</h3>
                                    <p id="aqi-status" class="mb-0">-</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <h6>PM2.5</h6>
                                    <h3 id="pm25-value">-</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <h6>PM10</h6>
                                    <h3 id="pm10-value">-</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">AQI Trend</h5>
                </div>
                <div class="card-body">
                    <canvas id="trendChart" height="250"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">AQI Legend</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="d-flex align-items-center mb-2">
                                <div style="width: 20px; height: 20px; background-color: #00e400;" class="me-2"></div>
                                <span>Good (0-50)</span>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <div style="width: 20px; height: 20px; background-color: #ffff00;" class="me-2"></div>
                                <span>Moderate (51-100)</span>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <div style="width: 20px; height: 20px; background-color: #ff7e00;" class="me-2"></div>
                                <span>Unhealthy for Sensitive Groups (101-150)</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center mb-2">
                                <div style="width: 20px; height: 20px; background-color: #ff0000;" class="me-2"></div>
                                <span>Unhealthy (151-200)</span>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <div style="width: 20px; height: 20px; background-color: #99004c;" class="me-2"></div>
                                <span>Very Unhealthy (201-300)</span>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <div style="width: 20px; height: 20px; background-color: #7e0023;" class="me-2"></div>
                                <span>Hazardous (301+)</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">About Air Quality Index</h5>
                </div>
                <div class="card-body">
                    <p>The Air Quality Index (AQI) is a measure for reporting air quality. Higher AQI values indicate greater levels of air pollution and increased health concerns.</p>
                    <p>Click on a monitoring station on the map to see detailed air quality information and historical data.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Pass server-side sensor data to JavaScript
    window.sensors = @json($sensors);
</script>
@endpush
