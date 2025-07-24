<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Notifications\ReminderNotification;
use Carbon\Carbon;

class SendReminders extends Command
{
    protected $signature = 'reminders:send';
    protected $description = 'Send scheduled user reminders';

    public function handle()
    {
        \Log::info("🕐 SendReminders running at " . now()->format('H:i'));

        $now = Carbon::now();
        $currentTime = $now->format('H:i');
        $currentDay = $now->format('l');

        $dueReminders = DB::table('remindars as r')
            ->join('users as u', 'u.id', '=', 'r.user_id')
            ->where(function ($query) use ($currentTime, $currentDay) {
                $query->where(function ($q) {
                    $q->where('r.recurrence', 'none')
                      ->where('r.scheduled_time', '<=', now())
                      ->where('r.sent', 0);
                })
                ->orWhere(function ($q) use ($currentTime) {
                    $q->where('r.recurrence', 'daily')
                      ->where('r.time_of_day', $currentTime);
                })
                ->orWhere(function ($q) use ($currentTime, $currentDay) {
                    $q->where('r.recurrence', 'weekly')
                      ->where('r.time_of_day', $currentTime)
                      ->where('r.day_of_week', $currentDay);
                });
            })
            ->select('r.*', 'u.email', 'u.full_name', 'u.id as user_id')
            ->get();

        foreach ($dueReminders as $row) {
            $reminder = (object) $row;

            // Load full user model (needed for Laravel's notify)
            $user = User::find($reminder->user_id);
            if (! $user) {
                \Log::warning("⚠️ User not found for reminder ID {$reminder->id}");
                continue;
            }

            // Get latest conversion reading
            $latestReading = DB::table('conversions')
                ->where('user_id', $reminder->user_id)
                ->orderByDesc('converted_at')
                ->first();

            // Send Markdown-based notification
            $user->notify(new ReminderNotification($reminder, $latestReading, $user));


            // Mark as sent if one-time
            if ($reminder->recurrence === 'none') {
                DB::table('remindars')->where('id', $reminder->id)->update(['sent' => 1]);
            }

            $this->info("✅ Sent reminder to {$user->email}");
        }

        return Command::SUCCESS;
    }
}
