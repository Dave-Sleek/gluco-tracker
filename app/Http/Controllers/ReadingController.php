<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Kreait\Laravel\Firebase\Facades\Firebase;

class ReadingController extends Controller
{
    public function getLatestReading()
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $userId = Auth::id();

        try {
            $latest = DB::table('conversions')
                ->where('user_id', $userId)
                ->orderBy('converted_at', 'desc')
                ->first();

            if (!$latest) {
                return response()->json([]);
            }

            // Optionally add health condition logic
            $condition = null;

            if ($latest) {
                $value = $latest->original_value;
                $unit = $latest->original_unit;

                // Convert to mg/dL for consistent evaluation
                if ($unit === 'mmol/L') {
                    $value = $value * 18;
                }

                if ($value < 70) {
                    $condition = 'Low';
                } elseif ($value <= 130) {
                    $condition = 'Target (Fasting)';
                } elseif ($value <= 180) {
                    $condition = 'Target (Post-Meal)';
                } elseif ($value <= 250) {
                    $condition = 'High';
                } else {
                    $condition = 'Very High';
                }
            }

            return response()->json([
                'original_value' => $latest->original_value,
                'original_unit' => $latest->original_unit,
                'converted_value' => $latest->converted_value,
                'converted_unit' => $latest->converted_unit,
                'converted_at' => $latest->converted_at,
                'type' => $latest->type,
                'label' => $latest->label,
                'condition_status' => $condition,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Server error: ' . $e->getMessage()], 500);
        }
    }

    public function sendPushToUser($userId)
    {
        $user = \App\Models\User::findOrFail($userId);
        $deviceToken = $user->device_token;

        $messaging = Firebase::messaging();

        $message = CloudMessage::withTarget('token', $deviceToken)
            ->withNotification(Notification::create(
                'Health Alert',
                'Your sugar level is high!'
            ));

        $messaging->send($message);

        return response()->json(['status' => 'Push sent']);
    }

    // public function sendAlert($userId)
    // {
    //     $user = User::findOrFail($userId);

    //     $user->notify(new SendPushNotification([
    //         'message' => 'Your sugar level is higher than normal. Take a quick check!',
    //         'id' => 999,
    //     ]));

    //     return response()->json(['success' => true]);
    // }
}
