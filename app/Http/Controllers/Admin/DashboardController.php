<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sensor;
use App\Models\Reading;
use App\Models\User;
use App\Models\Alert;
use App\Models\SimulationConfig;

class DashboardController extends Controller
{
    public function index()
    {
        $activeSensors = Sensor::where('status', 'active')->count();
        $totalUsers = User::count();
        $activeAlerts = Alert::where('active', true)->count();
        $todayDataPoints = Reading::whereDate('created_at', today())->count();
        $simulationStatus = SimulationConfig::first()?->status ?? 'stopped';

        $recentAlerts = Alert::with('sensor')
            ->where('active', true)
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'activeSensors',
            'totalUsers',
            'activeAlerts',
            'todayDataPoints',
            'simulationStatus',
            'recentAlerts'
        ));
    }
}
