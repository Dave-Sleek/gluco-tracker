<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Notification;
use App\Models\Conversion;
use App\Models\User;
use OneSignal;

class ConversionController extends Controller
{
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'User not logged in'], 401);
        }

        $validated = $request->validate([
            'original_value' => 'required|numeric',
            'original_unit' => 'required|in:mg/dL,mmol/L',
            'type' => 'required|in:fasting,after_meal',
            'label' => 'required|string|max:255',
        ]);

        $originalValue = (float) $validated['original_value'];
        $originalUnit = $validated['original_unit'];
        $type = $validated['type'];
        $label = $validated['label'];

        if ($originalUnit === 'mg/dL') {
            $convertedValue = round($originalValue / 18, 1);
            $convertedUnit = 'mmol/L';
        } else {
            $convertedValue = round($originalValue * 18, 0);
            $convertedUnit = 'mg/dL';
        }

        try {
            $conversion = Conversion::create([
                'user_id' => Auth::id(),
                'original_value' => $originalValue,
                'original_unit' => $originalUnit,
                'converted_value' => $convertedValue,
                'converted_unit' => $convertedUnit,
                'type' => $type,
                'label' => $label,
                'converted_at' => now(),
            ]);

            // ✅ Define the user before push logic
            $user = Auth::user();
            $readingMgDl = ($originalUnit === 'mg/dL') ? $originalValue : $convertedValue;
            $externalUserId = (string) $user->id;

            // 🚨 Send push if user wants notifications AND reading is high
            if ($readingMgDl > 140 && $user->notifications_enabled) {
                OneSignal::sendNotificationToExternalUser(
                    "Your glucose reading is {$readingMgDl} mg/dL — please consult your physician.",
                    [$externalUserId],
                    null,
                    ['reading' => $readingMgDl],
                    null,
                    null,
                    '🩺 Blood Sugar Alert'
                );

                // ✅ Log it while we're still inside the function
                Log::info("🔔 Notification sent to user {$externalUserId}");

                Notification::create([
                    'user_id' => $user->id,
                    'type' => 'glucose',
                    'title' => '🩺 Blood Sugar Alert',
                    'message' => "Reading reached {$readingMgDl} mg/dL",
                    'triggered_value' => $readingMgDl,
                    'status' => 'pending',
                    'sent_at' => now()
                ]);
            }

            return response()->json([
                'success' => true,
                'original_value' => $originalValue,
                'original_unit' => $originalUnit,
                'converted_value' => $convertedValue,
                'converted_unit' => $convertedUnit,
                'label' => $label,
                'type' => $type
            ]);
            Log::info("🔔 Notification sent to user {$externalUserId}");
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Database error: ' . $e->getMessage()], 500);
        }
    }
}
