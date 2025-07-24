<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ReminderController extends Controller
{
    public function store(Request $request)
{
    $request->validate([
        'subject' => 'required|string|max:255',
        'body' => 'required|string',
        'recurrence' => 'required|in:none,daily,weekly',
        'scheduled_time' => 'nullable|date',
        'day_of_week' => 'nullable|string|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
        'time_of_day' => 'nullable',
    ]);

    $reminder = new \App\Models\Reminder();
    $reminder->user_id = Auth::id();
    $reminder->subject = $request->subject;
    $reminder->body = $request->body;
    $reminder->recurrence = $request->recurrence;

    if ($request->recurrence === 'none') {
        $reminder->scheduled_time = $request->scheduled_time;
    } elseif ($request->recurrence === 'daily') {
        $reminder->time_of_day = $request->time_of_day;
    } elseif ($request->recurrence === 'weekly') {
        $reminder->time_of_day = $request->time_of_day;
        $reminder->day_of_week = $request->day_of_week;
    }

    $reminder->save();

    return redirect()->route('dashboard')->with('status', 'reminder_created');
}
}
