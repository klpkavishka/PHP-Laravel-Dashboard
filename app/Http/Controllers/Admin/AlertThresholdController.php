<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AlertThreshold;
use Illuminate\Http\Request;

class AlertThresholdController extends Controller
{
    public function index()
    {
        $thresholds = AlertThreshold::all();
        return view('admin.alerts.index', compact('thresholds'));
    }

    public function create()
    {
        return view('admin.alerts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category' => 'required|string|max:255',
            'min_value' => 'required|integer|min:0',
            'max_value' => 'required|integer|greater_than:min_value',
            'color_code' => 'required|string|max:7',
            'display_alert' => 'boolean',
        ]);

        AlertThreshold::create($validated);

        return redirect()->route('admin.alerts.index')
            ->with('success', 'Alert threshold created successfully');
    }

    public function edit(AlertThreshold $alert)
    {
        return view('admin.alerts.edit', compact('alert'));
    }

    public function update(Request $request, AlertThreshold $alert)
    {
        $validated = $request->validate([
            'category' => 'required|string|max:255',
            'min_value' => 'required|integer|min:0',
            'max_value' => 'required|integer|greater_than:min_value',
            'color_code' => 'required|string|max:7',
            'display_alert' => 'boolean',
        ]);

        $alert->update($validated);

        return redirect()->route('admin.alerts.index')
            ->with('success', 'Alert threshold updated successfully');
    }

    public function destroy(AlertThreshold $alert)
    {
        $alert->delete();

        return redirect()->route('admin.alerts.index')
            ->with('success', 'Alert threshold deleted successfully');
    }
}
