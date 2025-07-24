<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use OneSignal;

class HealthAlertController extends Controller
{
    public function sendPushToUser(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'original_value' => 'required|numeric',
            'original_unit' => 'required|in:mg/dL,mmol/L'
        ]);

        $user = User::find($request->user_id);
        $reading = $request->original_value;

        if ($request->original_unit === 'mg/dL') {
            $reading *= 18;
        }

        if ($reading > 140) {
            OneSignal::sendNotificationToExternalUser(
                "Your reading is $reading mg/dL — please consult your physician.",
                $user->id,
                null,
                ['reading' => $reading],
                null,
                null,
                '🩺 Blood Test Alert'
            );
              
            return response()->json(['status' => 'Notification sent via OneSignal']);
        }

        return response()->json(['message' => 'Reading is normal. No alert sent.']);
    }
}
