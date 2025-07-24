<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Notifications\SubscriptionExpiringNotification;
use App\Models\User;
use Carbon\Carbon;

class CheckExpiringSubscriptions extends Command
{
    protected $signature = 'subscriptions:check-expiring';
    protected $description = 'Notify users if their subscription is about to expire';

    public function handle()
    {
        $threshold = now()->addDays(3); // Notify 3 days before expiry

        $invoices = DB::table('invoices')->get();

        foreach ($invoices as $invoice) {
            $issuedAt = Carbon::parse($invoice->issued_at);

            // Determine subscription duration
            switch (strtolower($invoice->plan)) {
                case 'monthly':
                    $expiresAt = $issuedAt->copy()->addDays(30);
                    break;
                case 'yearly':
                    $expiresAt = $issuedAt->copy()->addYear();
                    break;
                case 'lifetime':
                    $expiresAt = null; // Never expires
                    break;
                default:
                    $expiresAt = null; // Unknown plan type
                    break;
            }

            if ($expiresAt && $expiresAt->lte($threshold)) {
                $user = User::find($invoice->user_id);

                if ($user) {
                    $user->notify(new SubscriptionExpiringNotification($invoice));
                }
            }
        }

        $this->info('Subscription expiry reminders sent.');
    }
}
