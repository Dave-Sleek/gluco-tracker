<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;
use App\Models\Feedback;
use App\Models\FeedbackReply;
use Illuminate\Support\Facades\DB;
use App\Notifications\SendPushNotification;
use App\Models\User;
use OneSignal;

class NotificationController extends Controller
{
    public function index(Request $request)
{
    $user_id = Auth::id();
    $tab = $request->query('tab', 'unread'); // default to 'unread'

    $typeIcons = [
        'email' => 'bi-envelope',
        'sms' => 'bi-chat-dots',
        'push' => 'bi-bell',
        'telegram' => 'bi-telegram',
    ];

    $statusBadge = [
        'sent' => 'success',
        'pending' => 'warning',
        'failed' => 'danger',
    ];

    $notifications = null;
    $replies = null;

    if ($tab === 'replies') {
        $replies = DB::table('feedback_replies as fr')
        ->join('feedback as f', 'fr.feedback_id', '=', 'f.id')
        ->where('f.user_id', $user_id)
        ->select('fr.*', 'f.type as feedback_type', 'f.message as feedback_message')
        ->get();
    
    } else {
        $notifications = DB::table('notifications')
    ->where('user_id', $user_id)
    ->when($tab === 'unread', function ($query) {
        $query->where('status', '!=', 'sent');
    })
    ->when($tab === 'feedback_replies', function ($query) {
        $query->where('type', 'email')->where('title', 'like', 'Feedback Reply%');
    })
    ->when($tab === 'glucose', function ($query) {
        $query->where('type', 'glucose');
    })
    ->when($tab === 'symptom', function ($query) {
        $query->where('type', 'symptom');
    })
    ->orderByDesc('created_at')
    ->get();

    }

    return view('notifications.index', compact('tab', 'notifications', 'replies', 'typeIcons', 'statusBadge'));
}

public function dismiss(Request $request, $id)
{
    $userId = Auth::id();

    $updated = DB::table('notifications')
        ->where('id', $id)
        ->where('user_id', $userId)
        ->update([
            'status' => 'sent',
        ]);

        return redirect()->back()->with('status', $updated ? 'Notification dismissed.' : 'Notification not found.');
    // return response()->json(['success' => $updated > 0]);
}


public function markAllAsSent(Request $request)
{
    $userId = Auth::id(); // Laravel handles session/auth for you

    DB::table('notifications')
        ->where('user_id', $userId)
        ->where('status', '!=', 'sent')
        ->update(['status' => 'sent']);
    return response()->json(['success' => true]);
}


public function unreadCount()
{
    $count = DB::table('notifications')
        ->where('user_id', Auth::id())
        ->where('status', '!=', 'sent')
        ->count();

    return response()->json(['count' => $count]);
}

public function markAsRead(Request $request, $id)
{
    $userId = Auth::id(); // Automatically gets the logged-in user

    $updated = DB::table('notifications')
        ->where('id', $id)
        ->where('user_id', $userId)
        ->update(['status' => 'sent']);

    return response()->json(['success' => $updated > 0]);
}

public function sendAlert($userId)
    {
        $user = User::findOrFail($userId);

        $user->notify(new SendPushNotification([
            'message' => 'Your sugar level is higher than normal. Take a quick check!',
            'id' => 999,
        ]));

        return response()->json(['success' => true]);
    }

public function storeToken(Request $request)
{
    auth()->user()->update([
        'device_token' => $request->token
    ]);

    return response()->json(['message' => 'Token saved']);
}

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
            [$user->id], // OneSignal expects an array here
            null,
            ['reading' => $reading],
            null,
            null,
            '🩺 Blood Test Alert'
        );
    
        // ✅ Log the alert into the notifications table
        DB::table('notifications')->insert([
            'user_id' => $user->id,
            'type' => 'glucose',
            'title' => '🩺 Blood Sugar Alert',
            'message' => "Reading of $reading mg/dL exceeded threshold.",
            'status' => 'sent',
            'triggered_value' => $reading,
            'sent_at' => now(),
            'created_at' => now()
        ]);
    
        return response()->json(['status' => 'Notification sent via OneSignal']);
    }
    
    return response()->json(['message' => 'Reading is normal. No alert sent.']);
}


}
