<?php

namespace App\Jobs;

use App\Models\SimulationConfig;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SimulateAirQualityData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $config = SimulationConfig::first();

        // Check if simulation should continue
        if (!$config || $config->status !== 'running') {
            return;
        }

        // Generate simulated data
        $this->generateAirQualityData($config);

        // Schedule the next iteration
        dispatch(new self())->delay(now()->addMinutes($config->frequency_minutes));
    }

    /**
     * Generate simulated air quality data based on configuration
     */
    private function generateAirQualityData(SimulationConfig $config): void
    {
        $baselineAqi = $config->baseline_aqi;
        $variationRange = $config->variation_range;

        // Generate random AQI value within the variation range
        $randomVariation = rand(-$variationRange, $variationRange);
        $simulatedAqi = max(0, $baselineAqi + $randomVariation);

        // Here you would save the data to the database
        // This is a placeholder for the actual data storage logic
        // You might want to create an AirQualityReading model for this

        // For now, just log the generated value
        \Log::info("Simulated AQI reading: {$simulatedAqi}");
    }
}
