@extends('admin.layouts.admin')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5>Sensor Management</h5>
        <a href="{{ route('admin.sensors.create') }}" class="btn btn-primary">Add New Sensor</a>
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Location</th>
                    <th>Coordinates</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sensors as $sensor)
                <tr>
                    <td>{{ $sensor->id }}</td>
                    <td>{{ $sensor->name }}</td>
                    <td>{{ $sensor->location_name }}</td>
                    <td>{{ $sensor->latitude }}, {{ $sensor->longitude }}</td>
                    <td>
                        <span class="badge {{ $sensor->status == 'active' ? 'bg-success' : 'bg-danger' }}">
                            {{ $sensor->status }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('admin.sensors.edit', $sensor) }}" class="btn btn-sm btn-info">Edit</a>

                        <form action="{{ route('admin.sensors.destroy', $sensor) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
