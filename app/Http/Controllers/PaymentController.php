<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use DateTime;
use DateInterval;
use Carbon\Carbon;

class PaymentController extends Controller
{
    public function verify(Request $request)
    {
        $reference = $request->query('reference');
        if (!$reference) {
            abort(400, 'No reference supplied');
        }
    
        $response = Http::withToken('sk_test_7b70605c298a79f58005f14bce31835212b662d0')
            ->get("https://api.paystack.co/transaction/verify/" . urlencode($reference));
    
        if (!$response->ok() || !$response['status']) {
            return redirect()->route('payment.failed')->withErrors('Payment verification failed.');
        }
    
        $data = $response['data'];
        $metadata = $data['metadata'] ?? [];
    
        if (!isset($metadata['user_id'], $metadata['plan'])) {
            abort(400, 'Missing metadata.');
        }
    
        $user_id = $metadata['user_id'];
        $plan = $metadata['plan'];
        $amount = $data['amount_paid'] ?? ($data['amount'] ?? 0) / 100;
    
        if ($data['status'] !== 'success') {
            return redirect()->route('payment.failed');
        }
    
        $today = Carbon::today();
        $interval = match($plan) {
            'annual' => '1 year',
            'monthly' => '1 month',
            default => '100 years'
        };
    
        $existing = DB::table('subscriptions')->where('user_id', $user_id)->first();
    
        if ($existing) {
            $current_end = Carbon::parse($existing->end_date);
            $effective_start = $current_end->greaterThan($today) ? $current_end : $today;
            $updated_end = $effective_start->copy()->add($interval)->format('Y-m-d');
    
            DB::table('subscriptions')->where('user_id', $user_id)->update([
                'end_date' => $updated_end,
                'plan' => $plan,
                'amount_paid' => $amount,
                'status' => 'active',
                'updated_at' => now(),
            ]);
        } else {
            $new_end_date = $today->copy()->add($interval)->format('Y-m-d');
    
            DB::table('subscriptions')->insert([
                'user_id' => $user_id,
                'plan' => $plan,
                'amount_paid' => $amount,
                'payment_reference' => $reference,
                'start_date' => $today->format('Y-m-d'),
                'end_date' => $new_end_date,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    
        // ✅ Store invoice
        DB::table('invoices')->insert([
            'user_id' => $user_id,
            'reference' => $reference,
            'plan' => $plan,
            'amount' => $amount,
            'issued_at' => now(),
            'created_at' => now(),
            'updated_at' => now()
        ]);
    
        DB::table('users')->where('id', $user_id)->update(['has_paid' => 1]);
    
        DB::table('notifications')->insert([
            'user_id' => $user_id,
            'type' => 'email',
            'title' => 'Subscription Activated',
            'message' => "Your {$plan} subscription has been successfully activated.",
            'status' => 'pending',
            'sent_at' => now(),
            'created_at' => now(),
        ]);
    
        Session::put('payment_success', true);
    
        return redirect()->route('dashboard');
    }

    public function subscribe()
{
    return view('payment.subscribe', [
        'email' => Auth::user()->email,
        'paystackKey' => config('services.paystack.public_key'),
    ]);
}

}    
