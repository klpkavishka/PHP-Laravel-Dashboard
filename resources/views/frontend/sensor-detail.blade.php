@extends('frontend.layouts.main')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>{{ $sensor->name }} - {{ $sensor->location_name }}</h5>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        @if($sensor->latestReading)
                        <h1 class="display-4 text-{{ getAqiColorClass($sensor->latestReading->aqi) }}">
                            {{ $sensor->latestReading->aqi }}
                        </h1>
                        <h3>{{ $sensor->latestReading->status }}</h3>
                        <p>Last updated: {{ $sensor->latestReading->created_at->diffForHumans() }}</p>

                        <div class="row mt-4">
                            <div class="col-6">
                                <h5>PM2.5</h5>
                                <h2>{{ $sensor->latestReading->pm25 }} μg/m³</h2>
                            </div>
                            <div class="col-6">
                                <h5>PM10</h5>
                                <h2>{{ $sensor->latestReading->pm10 }} μg/m³</h2>
                            </div>
                        </div>
                        @else
                        <p>No readings available</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>Air Quality Information</h5>
                </div>
                <div class="card-body">
                    <h6>What is AQI?</h6>
                    <p>The Air Quality Index (AQI) is a measure for reporting daily air quality. It indicates how clean or polluted the air is and what associated health effects might be a concern.</p>

                    <h6>Health Implications</h6>
                    <ul>
                        <li><strong>Good (0-50):</strong> Air quality is satisfactory with little or no risk.</li>
                        <li><strong>Moderate (51-100):</strong> Acceptable quality, but may cause concern for a small number of people.</li>
                        <li><strong>Unhealthy for Sensitive Groups (101-150):</strong> Members of sensitive groups may experience health effects.</li>
                        <li><strong>Unhealthy (151-200):</strong> Everyone may begin to experience health effects.</li>
                        <li><strong>Very Unhealthy (201-300):</strong> Health warnings of emergency conditions.</li>
                        <li><strong>Hazardous (301+):</strong> Health alert: everyone may experience serious health effects.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>Historical Data</h5>
                    <div class="btn-group">
                        <button class="btn btn-sm btn-outline-primary period-selector" data-period="day">24 Hours</button>
                        <button class="btn btn-sm btn-outline-primary period-selector" data-period="week">Week</button>
                        <button class="btn btn-sm btn-outline-primary period-selector" data-period="month">Month</button>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="historicalChart" height="300"></canvas>
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
        // Initial data
        const ctx = document.getElementById('historicalChart').getContext('2d');
        let historicalChart;

        // Load 24-hour data by default
        loadHistoricalData('day');

        // Period selector buttons
        document.querySelectorAll('.period-selector').forEach(button => {
            button.addEventListener('click', function() {
                document.querySelectorAll('.period-selector').forEach(btn => {
                    btn.classList.remove('active');
                });
                this.classList.add('active');
                loadHistoricalData(this.dataset.period);
            });
        });

        // Set first button as active
        document.querySelector('.period-selector[data-period="day"]').classList.add('active');

        function loadHistoricalData(period) {
            fetch(`/api/sensor/${@json($sensor->id)}/historical-data?period=${period}`)
                .then(response => response.json())
                .then(data => {
                    if (historicalChart) {
                        historicalChart.destroy();
                    }

                    historicalChart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: data.labels,
                            datasets: data.datasets
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'top',
                                },
                                title: {
                                    display: true,
                                    text: 'Air Quality Trend'
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                })
                .catch(error => console.error('Error loading data:', error));
        }
    });
</script>
@endsection
