<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sensor;

class SensorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sensors = [
            [
                'name' => 'Central Park Monitor',
                'location' => 'Downtown City Center',
                'latitude' => 6.9271,
                'longitude' => 79.8612,
                'active' => true
            ],
            [
                'name' => 'Industrial Zone Sensor',
                'location' => 'Northern Industrial Area',
                'latitude' => 6.9350,
                'longitude' => 79.8500,
                'active' => true
            ],
            [
                'name' => 'Coastal Monitor',
                'location' => 'Beach Front',
                'latitude' => 6.9150,
                'longitude' => 79.8700,
                'active' => true
            ],
            [
                'name' => 'Residential Area Sensor',
                'location' => 'Western Suburbs',
                'latitude' => 6.9300,
                'longitude' => 79.8400,
                'active' => true
            ],
        ];

        foreach ($sensors as $sensorData) {
            Sensor::create($sensorData);
        }
    }
}
