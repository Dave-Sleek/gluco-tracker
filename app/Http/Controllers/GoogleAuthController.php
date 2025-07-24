<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use App\Models\Notification; // ✅ Import Notification model
use Illuminate\Support\Facades\Auth;

class GoogleAuthController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Check if user exists or create new one
            $user = User::where('email', $googleUser->getEmail())->first();
            if (!$user) {
                $user = User::create([
                    'full_name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                ]);
            }

            // Log user in
            Auth::login($user);

            // Optional: Store session values
            session([
                'user_id' => $user->id,
                'full_name' => $user->full_name,
                'email' => $user->email,
            ]);

            // ✅ Insert notification into the system
            // $message = "Hi {$user->full_name}, you just logged in using your Google account.<br><br>";
            // $message .= "If this wasn't you, please <a href=\"" . route('support') . "\">contact support</a> immediately.";

            // Notification::create([
            //     'user_id' => $user->id,
            //     'type' => 'login',
            //     'title' => 'Google Login Detected',
            //     'message' => 'you just logged in using your Google account.',
            //     'status' => 'pending',
            //     'sent_at' => now(),
            // ]);

            // Redirect to dashboard
            return redirect()->route('dashboard');
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Something went wrong during Google authentication.');
        }
    }
}
