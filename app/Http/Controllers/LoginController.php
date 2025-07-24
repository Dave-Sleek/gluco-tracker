<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\UserLog;
use Illuminate\Support\Facades\Password;
use WhichBrowser\Parser;

class LoginController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6'
        ]);

        $hashedPassword = Hash::make($request->password);
        $user = User::create([
            'email' => $request->email,
            'password' => $hashedPassword
        ]);

        Session::put('user_id', $user->id);
        $this->logActivity($user->id, 'Register', $request);

        return response()->json(['success' => true, 'message' => 'Registered successfully.']);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

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

        return response()->json(['success' => false, 'message' => 'Invalid credentials.']);
    }

    public function forgot_password(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink($request->only('email'));
        return $status === Password::RESET_LINK_SENT
            ? response()->json(['success' => true, 'message' => 'Password reset link sent.'])
            : response()->json(['success' => false, 'message' => 'Unable to send reset link.']);
    }

    public function reset_password(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
            'token' => 'required'
        ]);

        $status = Password::reset($request->only('email', 'password', 'password_confirmation', 'token'), function ($user, $password) {
            $user->forceFill(['password' => Hash::make($password)])->save();
        });

        return $status === Password::PASSWORD_RESET
            ? response()->json(['success' => true, 'message' => 'Password reset successful.'])
            : response()->json(['success' => false, 'message' => 'Failed to reset password.']);
    }

    public function logout()
    {
        Auth::logout();
        Session::forget('user_id');
        return response()->json(['success' => true, 'message' => 'Logged out successfully.']);
    }

    public function profile()
    {
        $user = Auth::user();
        return response()->json(['success' => true, 'data' => $user]);
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

        try {
            UserLog::create([
                'user_id'       => $userId,
                'action'        => $action,
                'ip_address'    => $ipAddress,
                'user_agent'    => $userAgentInfo,
                'timestamp'     => now(),
                'last_activity' => now(),
                'payload'       => json_encode($payload ?? []),
            ]);
            \Log::info('✅ Inserted user log for user_id: ' . $userId);
        } catch (\Throwable $e) {
            \Log::error('❌ Logging failed: ' . $e->getMessage());
        }
    }
}
