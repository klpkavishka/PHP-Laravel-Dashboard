@extends('admin.layouts.admin')

@section('title', 'Create New Alert')

@section('content')
    <div class="card">
        <div class="card-header">
            <h5>Create New Alert</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.alerts.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="sensor_id" class="form-label">Sensor</label>
                    <select class="form-select @error('sensor_id') is-invalid @enderror" id="sensor_id" name="sensor_id" required>
                        <option value="">Select a sensor</option>
                        @foreach($sensors as $sensor)
                            <option value="{{ $sensor->id }}" {{ old('sensor_id') == $sensor->id ? 'selected' : '' }}>
                                {{ $sensor->name }} ({{ $sensor->location_name }})
                            </option>
                        @endforeach
                    </select>
                    @error('sensor_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="parameter" class="form-label">Parameter</label>
                    <select class="form-select @error('parameter') is-invalid @enderror" id="parameter" name="parameter" required>
                        <option value="aqi" {{ old('parameter') == 'aqi' ? 'selected' : '' }}>Air Quality Index (AQI)</option>
                        <option value="pm25" {{ old('parameter') == 'pm25' ? 'selected' : '' }}>PM2.5</option>
                        <option value="pm10" {{ old('parameter') == 'pm10' ? 'selected' : '' }}>PM10</option>
                        <option value="co" {{ old('parameter') == 'co' ? 'selected' : '' }}>CO</option>
                        <option value="no2" {{ old('parameter') == 'no2' ? 'selected' : '' }}>NO₂</option>
                        <option value="so2" {{ old('parameter') == 'so2' ? 'selected' : '' }}>SO₂</option>
                        <option value="o3" {{ old('parameter') == 'o3' ? 'selected' : '' }}>O₃</option>
                    </select>
                    @error('parameter')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="condition" class="form-label">Condition</label>
                        <select class="form-select @error('condition') is-invalid @enderror" id="condition" name="condition" required>
                            <option value="above" {{ old('condition') == 'above' ? 'selected' : '' }}>Above</option>
                            <option value="below" {{ old('condition') == 'below' ? 'selected' : '' }}>Below</option>
                            <option value="equal" {{ old('condition') == 'equal' ? 'selected' : '' }}>Equal to</option>
                        </select>
                        @error('condition')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="threshold" class="form-label">Threshold Value</label>
                        <input type="number" class="form-control @error('threshold') is-invalid @enderror" id="threshold" name="threshold" value="{{ old('threshold') }}" required step="0.01">
                        @error('threshold')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="message" class="form-label">Alert Message</label>
                    <textarea class="form-control @error('message') is-invalid @enderror" id="message" name="message" rows="3" required>{{ old('message') }}</textarea>
                    @error('message')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.alerts.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Create Alert</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // You can add any JavaScript for form validation or dynamic behavior here
    });
</script>
@endsection
