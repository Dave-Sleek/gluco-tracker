<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\StoreSubscriptionRequest;

class SubscriptionController extends Controller
{
    public function show()
{
    $userId = Auth::id();

    $subscription = DB::table('subscriptions')
        ->where('user_id', $userId)
        ->select('plan', 'start_date', 'amount_paid', 'end_date', 'payment_reference', 'status')
        ->first();

    return view('subscription.details', compact('subscription'));
}
public function renew()
{
    $user = Auth::user();

    $paystackPublicKey = config('services.paystack.public_key');
    $amount = 2000 * 100; // in kobo
    $callbackUrl = route('payment.verify'); // Laravel route for callback

    return view('subscription.renew', [
        'email' => $user->email,
        'paystackKey' => $paystackPublicKey,
        'amount_paid' => $amount,
        'callbackUrl' => $callbackUrl
    ]);
}
}
