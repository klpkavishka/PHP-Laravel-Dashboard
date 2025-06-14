<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\SimulateAirQualityData;
use App\Models\SimulationConfig;
use Illuminate\Http\Request;

class SimulationController extends Controller
{
    /**
     * Display simulation configuration page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $config = SimulationConfig::first() ?? new SimulationConfig();
        return view('admin.simulation.index', compact('config'));
    }

    /**
     * Update simulation configuration.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'frequency_minutes' => 'required|integer|min:1|max:60',
            'baseline_aqi' => 'required|integer|min:0|max:500',
            'variation_range' => 'required|integer|min:5|max:100',
        ]);

        $config = SimulationConfig::first();
        if (!$config) {
            $config = new SimulationConfig();
        }

        $config->fill($validated);
        $config->save();

        return redirect()->route('admin.simulation.index')
            ->with('success', 'Simulation configuration updated successfully');
    }

    /**
     * Toggle simulation status between running and stopped.
     *
     * @return \Illuminate\Http\Response
     */
    public function toggle()
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

        $config->status = $config->status === 'running' ? 'stopped' : 'running';
        $config->save();

        // If started, dispatch job to start simulation
        if ($config->status === 'running') {
            SimulateAirQualityData::dispatch();
        }

        $message = $config->status === 'running' ? 'Simulation started' : 'Simulation stopped';
        return redirect()->route('admin.simulation.index')
            ->with('success', $message);
    }
}
