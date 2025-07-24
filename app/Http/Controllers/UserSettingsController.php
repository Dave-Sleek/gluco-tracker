<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserSettingsController extends Controller
{
    /**
     * Show the settings page (optional).
     */
    public function edit()
    {
        return view('settings.edit'); // Make sure you have a corresponding Blade view
    }

    /**
     * Update notification preference.
     */
    public function updateNotificationPreference(Request $request)
    {
        $user = Auth::user();

        // Optional: validate presence of the checkbox field
        $request->validate([
            'notifications_enabled' => 'nullable|boolean',
        ]);

        // Update based on whether the checkbox is present
        $user->notifications_enabled = $request->has('notifications_enabled');
        $user->save();

        return back()->with('success', 'Notification preference updated.');
    }
}
