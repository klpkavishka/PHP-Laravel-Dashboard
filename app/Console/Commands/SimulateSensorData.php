<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Sensor;
use App\Models\Reading;
use App\Models\Alert;

class SimulateSensorData extends Command
{
    protected $signature = 'sensors:simulate';
    protected $description = 'Simulate readings from air quality sensors';

    public function handle()
    {
        $sensors = Sensor::where('active', true)->get();

        foreach ($sensors as $sensor) {
            // Generate random but realistic AQI values
            $aqi = $this->generateRealisticAqi($sensor->id);
            $pm25 = $aqi * 0.8 + rand(-5, 5);
            $pm10 = $aqi * 1.5 + rand(-10, 10);

            $status = $this->getAqiStatus($aqi);

            Reading::create([
                'sensor_id' => $sensor->id,
                'aqi' => $aqi,
                'pm25' => $pm25,
                'pm10' => $pm10,
                'status' => $status,
                'reading_time' => now(),
            ]);

            // Create alert if AQI is high
            if ($aqi > 150) {
                Alert::create([
                    'sensor_id' => $sensor->id,
                    'type' => 'high_aqi',
                    'message' => "High AQI detected at {$sensor->name}: {$aqi}",
                    'active' => true,
                ]);
            }
        }

        $this->info('Sensor data simulated successfully.');
    }

    private function generateRealisticAqi($sensorId)
    {
        // Get last reading to ensure continuity
        $lastReading = Reading::where('sensor_id', $sensorId)
            ->latest('reading_time')
            ->first();

        $baseAqi = $lastReading ? $lastReading->aqi : rand(30, 120);

        // Add variation with limits to ensure realism
        $variation = rand(-10, 10);
        $newAqi = max(20, min(300, $baseAqi + $variation));

        return $newAqi;
    }

    private function getAqiStatus($aqi)
    {
        if ($aqi <= 50) return 'Good';
        if ($aqi <= 100) return 'Moderate';
        if ($aqi <= 150) return 'Unhealthy for Sensitive Groups';
        if ($aqi <= 200) return 'Unhealthy';
        if ($aqi <= 300) return 'Very Unhealthy';
        return 'Hazardous';
    }
}
