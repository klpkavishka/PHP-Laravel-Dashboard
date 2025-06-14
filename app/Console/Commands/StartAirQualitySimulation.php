<?php

namespace App\Console\Commands;

use App\Jobs\SimulateAirQualityData;
use App\Models\SimulationConfig;
use Illuminate\Console\Command;

class StartAirQualitySimulation extends Command
{
    protected $signature = 'airquality:simulate';
    protected $description = 'Start the air quality data simulation';

    public function handle()
    {
        $config = SimulationConfig::first();
        if (!$config) {
            $config = SimulationConfig::create([
                'frequency_minutes' => 15,
                'baseline_aqi' => 50,
                'variation_range' => 20,
                'status' => 'stopped'
            ]);
        }

        $config->status = 'running';
        $config->save();

        $this->info('Starting air quality simulation...');
        dispatch(new SimulateAirQualityData());
        $this->info('Simulation job dispatched.');
    }
}
