<?php

namespace App\Console\Commands;

use App\Models\SimulationConfig;
use Illuminate\Console\Command;

class StopAirQualitySimulation extends Command
{
    protected $signature = 'airquality:stop';
    protected $description = 'Stop the air quality data simulation';

    public function handle()
    {
        $config = SimulationConfig::first();
        if (!$config) {
            $this->error('Simulation configuration not found.');
            return 1;
        }

        $config->status = 'stopped';
        $config->save();

        $this->info('Air quality simulation has been stopped.');
        return 0;
    }
}
