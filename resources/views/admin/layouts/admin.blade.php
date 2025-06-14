<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Air Quality Dashboard - Admin</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- Custom CSS -->
    <style>
        .sidebar {
            min-height: 100vh;
            background-color: #343a40;
        }
        .sidebar-link {
            color: rgba(255, 255, 255, 0.85);
            text-decoration: none;
            display: block;
            padding: 10px 15px;
        }
        .sidebar-link:hover {
            background-color: #495057;
            color: white;
        }
        .sidebar-link.active {
            background-color: #0d6efd;
            color: white;
        }
        .main-content {
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 p-0 sidebar">
                <div class="p-3 text-white">
                    <h4>AQ Dashboard</h4>
                </div>
                <div class="nav flex-column">
                    <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                    </a>
                    <a href="{{ route('admin.sensors.index') }}" class="sidebar-link {{ request()->routeIs('admin.sensors.*') ? 'active' : '' }}">
                        <i class="fas fa-microchip me-2"></i> Sensors
                    </a>
                    <a href="{{ route('admin.alerts.index') }}" class="sidebar-link {{ request()->routeIs('admin.alerts.*') ? 'active' : '' }}">
                        <i class="fas fa-bell me-2"></i> Alerts
                    </a>
                    <a href="{{ route('admin.simulation.index') }}" class="sidebar-link {{ request()->routeIs('admin.simulation.*') ? 'active' : '' }}">
                        <i class="fas fa-vial me-2"></i> Simulation
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="sidebar-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        <i class="fas fa-users me-2"></i> Users
                    </a>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-10 main-content">
                <div class="container-fluid">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2>@yield('title', 'Dashboard')</h2>
                        <div>
                            <!-- This section would typically have user profile/logout options -->
                        </div>
                    </div>

                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Additional scripts -->
    @yield('scripts')
</body>
</html>
