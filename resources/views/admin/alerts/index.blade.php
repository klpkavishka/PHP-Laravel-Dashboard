@extends('admin.layouts.admin')

@section('title', 'Alerts Management')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5>Alerts</h5>
            <a href="{{ route('admin.alerts.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> New Alert
            </a>
        </div>
        <div class="card-body">
            @if(isset($alerts) && $alerts->count() > 0)
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Sensor</th>
                            <th>Type</th>
                            <th>Message</th>
                            <th>Threshold</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($alerts as $alert)
                            <tr>
                                <td>{{ $alert->sensor->name ?? 'N/A' }}</td>
                                <td>{{ $alert->type }}</td>
                                <td>{{ $alert->message }}</td>
                                <td>{{ $alert->threshold_value }}</td>
                                <td>
                                    <span class="badge {{ $alert->active ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $alert->active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>{{ $alert->created_at->format('Y-m-d H:i') }}</td>
                                <td class="d-flex">
                                    <a href="{{ route('admin.alerts.edit', $alert->id) }}" class="btn btn-sm btn-primary me-1">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.alerts.destroy', $alert->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this alert?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                @if(isset($alerts) && method_exists($alerts, 'links'))
                    <div class="mt-4">
                        {{ $alerts->links() }}
                    </div>
                @endif
            @else
                <div class="alert alert-info">
                    No alerts found. Click 'New Alert' to create one.
                </div>
            @endif
        </div>
    </div>
@endsection
