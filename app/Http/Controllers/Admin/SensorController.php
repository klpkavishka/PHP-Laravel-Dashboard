<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sensor;
use Illuminate\Http\Request;

class SensorController extends Controller
{
    /**
     * Display a listing of the sensors.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sensors = Sensor::all();
        return view('admin.sensors.index', compact('sensors'));
    }

    /**
     * Show the form for creating a new sensor.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.sensors.create');
    }

    /**
     * Store a newly created sensor in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location_name' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        Sensor::create($validated);

        return redirect()->route('admin.sensors.index')
            ->with('success', 'Sensor created successfully');
    }

    /**
     * Show the form for editing the specified sensor.
     *
     * @param  \App\Models\Sensor  $sensor
     * @return \Illuminate\Http\Response
     */
    public function edit(Sensor $sensor)
    {
        return view('admin.sensors.edit', compact('sensor'));
    }

    /**
     * Update the specified sensor in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sensor  $sensor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sensor $sensor)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location_name' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'status' => 'required|in:active,inactive',
        ]);

        $sensor->update($validated);

        return redirect()->route('admin.sensors.index')
            ->with('success', 'Sensor updated successfully');
    }

    /**
     * Remove the specified sensor from storage.
     *
     * @param  \App\Models\Sensor  $sensor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sensor $sensor)
    {
        $sensor->delete();

        return redirect()->route('admin.sensors.index')
            ->with('success', 'Sensor deleted successfully');
    }
}
