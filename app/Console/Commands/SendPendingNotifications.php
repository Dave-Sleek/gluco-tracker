<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Notifications\PendingEmailNotification;

class SendPendingNotifications extends Command
{
    protected $signature = 'notifications:send-pending';
    protected $description = 'Send pending email notifications using Laravel MailMessage';

    public function handle()
    {
        $notifications = DB::table('notifications as n')
            ->join('users as u', 'n.user_id', '=', 'u.id')
            ->where('n.type', 'email')
            ->where('n.status', 'pending')
            ->select('n.id', 'n.title', 'n.message', 'n.user_id', 'u.email', 'u.full_name')
            ->get();

        foreach ($notifications as $notification) {
            try {
                $user = User::find($notification->user_id);

                if ($user) {
                    $user->notify(new PendingEmailNotification($notification->title, $notification->message));

                    DB::table('notifications')->where('id', $notification->id)->update([
                        'status' => 'sent',
                        'sent_at' => now(),
                    ]);

                    $this->info("✅ Sent to {$notification->email}");
                } else {
                    $this->warn("⚠️ User not found for ID: {$notification->user_id}");
                }
            } catch (\Exception $e) {
                DB::table('notifications')->where('id', $notification->id)->update(['status' => 'failed']);

                $this->error("❌ Failed to send to {$notification->email}: {$e->getMessage()}");
            }
        }

        return Command::SUCCESS;
    }
}
