<?php

namespace App\Console\Commands;

use App\Models\Sensor;
use Illuminate\Console\Command;

class SetupInitialSensors extends Command
{
    protected $signature = 'airquality:setup-sensors';
    protected $description = 'Set up initial sensors in Colombo';

    public function handle()
    {
        $sensors = [
            [
                'name' => 'Colombo 01',
                'location_name' => 'Fort',
                'latitude' => 6.9271,
                'longitude' => 79.8612,
                'status' => 'active'
            ],
            [
                'name' => 'Colombo 03',
                'location_name' => 'Kollupitiya',
                'latitude' => 6.9179,
                'longitude' => 79.8528,
                'status' => 'active'
            ],
            [
                'name' => 'Colombo 05',
                'location_name' => 'Havelock Town',
                'latitude' => 6.8913,
                'longitude' => 79.8636,
                'status' => 'active'
            ],
            [
                'name' => 'Colombo 07',
                'location_name' => 'Cinnamon Gardens',
                'latitude' => 6.9108,
                'longitude' => 79.8711,
                'status' => 'active'
            ],
            [
                'name' => 'Bambalapitiya',
                'location_name' => 'Bambalapitiya',
                'latitude' => 6.8994,
                'longitude' => 79.8561,
                'status' => 'active'
            ],
        ];

        foreach ($sensors as $sensor) {
            Sensor::create($sensor);
        }

        $this->info('Initial sensors created successfully.');
    }
}
