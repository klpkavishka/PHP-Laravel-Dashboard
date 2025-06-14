<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alert;
use App\Models\Sensor;
use Illuminate\Http\Request;

class AlertController extends Controller
{
    /**
     * Display a listing of the alerts.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $alerts = Alert::with('sensor')->get();
        return view('admin.alerts.index', compact('alerts'));
    }

    /**
     * Show the form for creating a new alert.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sensors = Sensor::where('status', 'active')->get();
        return view('admin.alerts.create', compact('sensors'));
    }

    /**
     * Store a newly created alert in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'sensor_id' => 'required|exists:sensors,id',
            'parameter' => 'required|string|max:50',
            'threshold' => 'required|numeric',
            'condition' => 'required|in:above,below,equal',
            'status' => 'required|in:active,inactive',
            'message' => 'required|string'
        ]);

        // Map the validated data to match the Alert model fields
        // Include the threshold value in the message instead since there's no dedicated column
        $message = $validated['message'] . ' [' . $validated['condition'] . ' ' . $validated['threshold'] . ']';

        $alertData = [
            'sensor_id' => $validated['sensor_id'],
            'type' => $validated['parameter'],  // Map 'parameter' to 'type'
            'message' => $message,
            'active' => $validated['status'] === 'active',
        ];

        Alert::create($alertData);

        return redirect()->route('admin.alerts.index')
            ->with('success', 'Alert created successfully.');
    }

    /**
     * Display the specified alert.
     *
     * @param  \App\Models\Alert  $alert
     * @return \Illuminate\Http\Response
     */
    public function show(Alert $alert)
    {
        return view('admin.alerts.show', compact('alert'));
    }

    /**
     * Show the form for editing the specified alert.
     *
     * @param  \App\Models\Alert  $alert
     * @return \Illuminate\Http\Response
     */
    public function edit(Alert $alert)
    {
        $sensors = Sensor::where('status', 'active')->get();
        return view('admin.alerts.edit', compact('alert', 'sensors'));
    }

    /**
     * Update the specified alert in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Alert  $alert
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Alert $alert)
    {
        $validated = $request->validate([
            'sensor_id' => 'required|exists:sensors,id',
            'parameter' => 'required|string|max:50',
            'threshold' => 'required|numeric',
            'condition' => 'required|in:above,below,equal',
            'status' => 'required|in:active,inactive',
            'message' => 'required|string'
        ]);

        // Map the validated data to match the Alert model fields
        // Include the threshold value in the message instead since there's no dedicated column
        $message = $validated['message'] . ' [' . $validated['condition'] . ' ' . $validated['threshold'] . ']';

        $alertData = [
            'sensor_id' => $validated['sensor_id'],
            'type' => $validated['parameter'],
            'message' => $message,
            'active' => $validated['status'] === 'active',
        ];

        $alert->update($alertData);

        return redirect()->route('admin.alerts.index')
            ->with('success', 'Alert updated successfully.');
    }

    /**
     * Remove the specified alert from storage.
     *
     * @param  \App\Models\Alert  $alert
     * @return \Illuminate\Http\Response
     */
    public function destroy(Alert $alert)
    {
        $alert->delete();

        return redirect()->route('alerts.index')
            ->with('success', 'Alert deleted successfully.');
    }
}
