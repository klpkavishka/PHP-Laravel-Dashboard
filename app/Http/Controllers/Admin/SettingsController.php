<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Artisan;

class SettingsController extends Controller
{
    /**
     * Display the settings page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $settings = [
            'app_name' => config('app.name'),
            'app_email' => config('mail.from.address'),
            'notification_enabled' => config('app.notifications_enabled', true),
        ];

        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Update the application settings.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'app_name' => 'required|string|max:255',
            'app_email' => 'required|email',
            'notification_enabled' => 'boolean'
        ]);

        // In a real application, you would update these settings
        // in a persistent storage like database or .env file

        return redirect()->route('admin.settings')
            ->with('success', 'Settings updated successfully.');
    }

    /**
     * Clear application cache.
     *
     * @return \Illuminate\Http\Response
     */
    public function clearCache()
    {
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('view:clear');
        Artisan::call('route:clear');

        return redirect()->route('admin.settings')
            ->with('success', 'Application cache cleared successfully.');
    }
}
