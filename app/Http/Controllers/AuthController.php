<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use App\Models\User;
use WhichBrowser\Parser;
use App\Models\UserLog;
use Illuminate\Support\Facades\Session;
use App\Models\Notification;
use App\Notifications\WelcomeNotification;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;


class AuthController extends Controller
{
    /**
     * Handle login
     */
    public function login(Request $request)
    {
        // Ensure session exists to prevent CSRF token mismatch
        if (!$request->hasSession()) {
            return response()->json([
                'success' => false,
                'message' => 'Session expired. Please refresh and try again.',
            ], 419);
        }

        // Validate request data
        $data = $request->only('email', 'password');
        $validator = Validator::make($data, [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Authenticate user
        $user = User::where('email', $request->email)->first();
        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);
            Session::put('user_id', $user->id);
            $this->logActivity($user->id, 'Login', $request);
            \Log::info('➡️ About to log user activity');

            return response()->json([
                'success' => true,
                'message' => 'Login successful.',
                'redirect' => $user->is_admin ? '/admin/dashboard' : '/dashboard',
                'is_admin' => $user->is_admin,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid credentials',
        ], 401);
    }


    /**
     * Handle registration
     */
    public function register(Request $request)
    {
        $data = $request->only('email', 'password', 'full_name');

        $validator = Validator::make($data, [
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Create new user
        $user = User::create([
            'full_name'      => $data['full_name'],
            'email'          => $data['email'],
            'password'       => Hash::make($data['password']),
            'profile_image'  => 'default.png',
            'is_subscribed'  => 0,
            'has_paid'       => 0,
            'trial_start_date' => now(), // Add trial start date here
            'created_at'     => now(),
            'updated_at'     => now(),
        ]);

        Auth::login($user);

        // ✅ Send welcome email
        $user->notify(new WelcomeNotification());

        // ✅ Log in notifications table for dashboard display
        Notification::create([
            'user_id' => $user->id,
            'type' => 'email',
            'title' => '🎉 Welcome, ' . $user->full_name . '!',
            'message' => 'Thank you for signing up. Start tracking your readings and stay on top of your health.',
            'status' => 'pending',
            'sent_at' => now(),
            'created_at' => now()
        ]);

        // ✅ Now respond to frontend
        return response()->json([
            'success' => true,
            'message' => 'Registration successful',
        ]);
    }

    /**
     * Handle forgot password (send reset email)
     */
    public function forgot_password(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink($request->only('email'));

        return response()->json([
            'success' => $status === Password::RESET_LINK_SENT,
            'message' => __($status),
        ]);
    }

    /**
     * Handle password reset
     */
    public function reset_password(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->save();

                $user->setRememberToken(Str::random(60));
            }
        );

        return response()->json([
            'success' => $status === Password::PASSWORD_RESET,
            'message' => __($status),
        ]);
    }

    /**
     * Handle logout
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json([
            'success' => true,
            'message' => 'Logged out successfully',
        ]);
    }

    /**
     * Get authenticated user's profile
     */
    public function profile()
    {
        return response()->json([
            'success' => true,
            'user' => Auth::user(),
        ]);
    }

    private function getLocationFromIp(string $ip): string
    {
        $cacheKey = "ip_location_{$ip}";

        // 🔒 Localhost, loopback, or carrier-grade NAT check
        if (
            $ip === '127.0.0.1' || $ip === '::1' ||
            str_starts_with($ip, '192.168.') ||
            str_starts_with($ip, '10.') ||
            str_starts_with($ip, '100.') // common CGNAT range
        ) {
            return 'Abuja, Nigeria'; // 🪄 fallback for local/mobile dev
        }

        return Cache::remember($cacheKey, now()->addDays(7), function () use ($ip) {
            // 🔹 Primary: ip-api.com
            try {
                $response = Http::get("http://ip-api.com/json/{$ip}?fields=status,message,city,regionName,country");

                if ($response->json('status') === 'success') {
                    return trim(implode(', ', array_filter([
                        $response->json('city'),
                        $response->json('regionName'),
                        $response->json('country')
                    ])), ', ');
                }

                \Log::warning("⚠️ ip-api.com failed: " . $response->json('message'));
            } catch (\Throwable $e) {
                \Log::error("❌ ip-api.com exception: " . $e->getMessage());
            }

            // 🔹 Fallback: ipinfo.io
            try {
                $fallback = Http::get("https://ipinfo.io/{$ip}/json");

                if ($fallback->ok()) {
                    return trim(implode(', ', array_filter([
                        $fallback->json('city'),
                        $fallback->json('region'),
                        $fallback->json('country')
                    ])), ', ');
                }

                \Log::warning("⚠️ ipinfo.io returned incomplete data for IP {$ip}");
            } catch (\Throwable $e) {
                \Log::error("❌ ipinfo.io exception: " . $e->getMessage());
            }

            return 'Location unavailable';
        });
    }


    private function logActivity($userId, $action, Request $request, array $payload = [])
    {
        \Log::info('📥 Inside logActivity method');

        $ipAddress = $request->ip();
        $userAgentString = $request->header('User-Agent') ?? 'Unknown';
        $parser = new Parser($userAgentString);

        $browser = $parser->browser->toString() ?? 'Unknown';
        $os = $parser->os->toString() ?? 'Unknown';
        $device = $parser->device->toString() ?? 'Unknown';
        $userAgentInfo = "Browser: $browser; OS: $os; Device: $device";

        $location = $this->getLocationFromIp($ipAddress);

        try {
            UserLog::create([
                'user_id'       => $userId,
                'action'        => $action,
                'ip_address'    => $ipAddress,
                'user_agent'    => $userAgentInfo,
                'location'      => $location,
                'timestamp'     => now(),
                'last_activity' => now(),
                'payload'       => json_encode($payload ?? []),
            ]);
            \Log::info("✅ Inserted user log for user_id: {$userId} — Location: {$location}");
        } catch (\Throwable $e) {
            \Log::error('❌ Logging failed: ' . $e->getMessage());
        }
    }

    public function storeToken(Request $request)
    {
        $user = Auth::user();

        \Log::info('Before update:', ['token' => $request->token]);

        $user->device_token = $request->token;
        $user->save();

        \Log::info('After update:', ['device_token' => $user->device_token]);

        return response()->json(['status' => 'Token saved']);
    }
}
