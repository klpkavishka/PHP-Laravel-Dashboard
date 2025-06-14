<?php

namespace App\Http\Controllers;

use App\Models\Sensor;
use App\Models\Reading;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PublicDashboardController extends Controller
{
    public function index()
    {
        // Fetch active sensors with their latest readings
        $sensors = Sensor::where('status', 'active')
            ->with('latestReading')
            ->get();

        return view('frontend.dashboard', compact('sensors'));
    }

    public function sensorDetail($id)
    {
        $sensor = Sensor::with('latestReading')->findOrFail($id);
        return view('frontend.sensor-detail', compact('sensor'));
    }

    // This is the same as sensorDetail but kept for backward compatibility
    public function stationDetail($id)
    {
        return $this->sensorDetail($id);
    }

    public function getHistoricalData(Request $request, $id)
    {
        $period = $request->input('period', 'day');
        $sensor = Sensor::findOrFail($id);

        // Define the time range based on the requested period
        switch ($period) {
            case 'week':
                $startDate = Carbon::now()->subDays(7);
                $groupBy = 'date_format(reading_time, "%Y-%m-%d")';
                $format = 'Y-m-d';
                break;
            case 'month':
                $startDate = Carbon::now()->subDays(30);
                $groupBy = 'date_format(reading_time, "%Y-%m-%d")';
                $format = 'Y-m-d';
                break;
            case 'day':
            default:
                $startDate = Carbon::now()->subHours(24);
                $groupBy = 'date_format(reading_time, "%Y-%m-%d %H:00")';
                $format = 'Y-m-d H:00';
                break;
        }

        // Get readings for the specified time range
        $readings = Reading::where('sensor_id', $id)
            ->where('reading_time', '>=', $startDate)
            ->orderBy('reading_time')
            ->get();

        // Format data for chart.js
        $labels = $readings->pluck('reading_time')->map(function($date) use ($format) {
            return Carbon::parse($date)->format($format);
        })->toArray();

        $datasets = [
            [
                'label' => 'AQI',
                'data' => $readings->pluck('aqi')->toArray(),
                'borderColor' => '#ff7e00',
                'backgroundColor' => 'rgba(255, 126, 0, 0.2)',
                'fill' => true
            ],
            [
                'label' => 'PM2.5',
                'data' => $readings->pluck('pm25')->toArray(),
                'borderColor' => '#0077ff',
                'backgroundColor' => 'transparent'
            ],
            [
                'label' => 'PM10',
                'data' => $readings->pluck('pm10')->toArray(),
                'borderColor' => '#00aaff',
                'backgroundColor' => 'transparent'
            ]
        ];

        return response()->json([
            'labels' => $labels,
            'datasets' => $datasets
        ]);
    }
}
