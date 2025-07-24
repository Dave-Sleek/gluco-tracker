<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Conversion;
use App\Models\Notification;
use App\Models\Reminder;
use App\Models\Subscription;
use Carbon\Carbon;
use App\Models\SymptomLog;
use App\Models\MealLog;
use App\Services\AiAdvisor;

class DashboardController extends Controller
{
    public function index()
    {

        $user = Auth::user();


        // if (!auth()->user()->hasVerifiedEmail()) {
        //     return redirect()->route('verification.notice');
        // }

        // if (!$user->hasVerifiedEmail()) {
        //     return redirect()->route('verification.notice');
        // }

        // Symptom Log
        $logs = SymptomLog::where('user_id', Auth::id())
            ->latest('logged_at')
            ->take(10)
            ->get()
            ->map(function ($log) {
                $log->glucose_before = Conversion::where('user_id', Auth::id())
                    ->where('converted_at', '<=', $log->logged_at)
                    ->latest('converted_at')
                    ->first();

                $log->glucose_after = Conversion::where('user_id', Auth::id())
                    ->where('converted_at', '>', $log->logged_at)
                    ->oldest('converted_at')
                    ->first();

                // ✅ Add correlation logic
                if ($log->glucose_before && $log->glucose_after) {
                    $delta = abs($log->glucose_after->original_value - $log->glucose_before->original_value);
                    $log->correlation = $delta > 30 ? 'High' : ($delta > 10 ? 'Moderate' : 'Low');
                } else {
                    $log->correlation = null; // or 'Uncertain'
                }

                return $log;
            });

        // Meal Log
        $mealLogs = MealLog::where('user_id', Auth::id())
            ->latest('logged_at')
            ->get()
            ->map(function ($meal) {
                $meal->glucose = $meal->nearestConversion();
                $meal->recommendation = AiAdvisor::getMealAdvice($meal);
                return $meal;
            });

        // MealPlanner
        $plannedMeals = Auth::user()
            ->mealPlans()
            ->whereDate('scheduled_for', today())
            ->with('meal')
            ->get();

        // Recent 4 readings
        $recent_readings = Conversion::where('user_id', $user->id)
            ->orderByDesc('converted_at')
            ->take(4)
            ->get();

        // Notification count
        $unread_count = Notification::where('user_id', $user->id)
            ->where('status', 'pending')
            ->count();

        // Latest value preview
        $latest = Conversion::where('user_id', $user->id)
            ->orderByDesc('converted_at')
            ->first();

        // Last 5 reminders
        $reminders = Reminder::where('user_id', $user->id)
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

        // Recommendations (14 days of data)
        $days = 14;
        $cutoff = Carbon::now()->subDays($days);
        $readings = Conversion::where('user_id', $user->id)
            ->where('converted_at', '>=', $cutoff)
            ->get();

        $fasting = $after_meal = [];
        foreach ($readings as $r) {
            $value = floatval($r->original_value);
            if ($r->type === 'fasting') $fasting[] = $value;
            elseif ($r->type === 'after_meal') $after_meal[] = $value;
        }

        $avg_fasting = count($fasting) ? round(array_sum($fasting) / count($fasting), 1) : null;
        $avg_after_meal = count($after_meal) ? round(array_sum($after_meal) / count($after_meal), 1) : null;

        $recommendations = [];
        if ($avg_fasting !== null && $avg_fasting > 130) {
            $recommendations[] = "<i class='bi bi-check-circle' style='color:green;'></i> 🍽️ Your average fasting sugar is high (<strong>{$avg_fasting} mg/dL</strong>). Try low-carb dinners, morning walks, or talk to your doctor about <strong>Metformin</strong>.";
        }
        if ($avg_after_meal !== null && $avg_after_meal > 180) {
            $recommendations[] = "<i class='bi bi-check-circle' style='color:green;'></i> 🍚 Post-meal spikes detected (<strong>{$avg_after_meal} mg/dL</strong>). Consider reducing carbs, walking after meals, or ask about fast-acting insulin.";
        }
        if (
            ($avg_fasting !== null && $avg_fasting < 70) ||
            ($avg_after_meal !== null && $avg_after_meal < 70)
        ) {
            $recommendations[] = "<i class='bi bi-check-circle' style='color:green;'></i> ⚠️ Low readings found (<70 mg/dL). Be cautious of hypoglycemia. Carry glucose tablets and consult your doctor.";
        }
        if (empty($recommendations)) {
            $recommendations[] = "Great job! Both fasting and post-meal averages are in the healthy range. Keep it up!";
        }


        $activeSubscription = Subscription::where('user_id', $user->id)
            ->where('status', 'active')
            ->first();

        $subscriptionCountdown = null;
        $subscriptionExpiresAt = null;
        $invoice = $activeSubscription;

        if ($activeSubscription) {
            if (!is_null($activeSubscription->end_date)) {
                $subscriptionExpiresAt = Carbon::parse($activeSubscription->end_date);
                $subscriptionCountdown = (int) round(Carbon::now()->diffInDays($subscriptionExpiresAt, false));

                // 🚀 Redirect user to subscribe page if expired or expires today
                if ($subscriptionCountdown <= 0) {
                    return redirect()->route('payment.subscribe');
                }
            } else {
                // Lifetime plan assumed
                $subscriptionExpiresAt = null;
                $subscriptionCountdown = null;
            }
        }

        $daysLeft = $subscriptionCountdown;

        // \Log::info('Subscription end date: ' . $activeSubscription->end_date);
        // \Log::info('Countdown: ' . $subscriptionCountdown);


        // Trial or subscription logic
        $days_left = null; // 👈 Ensures it's always defined
        if ($activeSubscription) {
            $show_trial_banner = false;
        } else {
            if ($user->trial_start_date) {
                $trial_start = Carbon::parse($user->trial_start_date);
                $today = Carbon::today();
                $diff = $trial_start->diffInDays($today);

                if ($diff <= 7) {
                    $days_left = 7 - $diff;
                    $show_trial_banner = true;
                } else {
                    // Redirect to subscribe page
                    return redirect()->route('payment.subscribe');
                }
            } else {
                // No trial start date - redirect
                return redirect()->route('payment.subscribe');
            }
        }

        return view('dashboard.index', compact(
            'user',
            'recent_readings',
            'unread_count',
            'latest',
            'reminders',
            'recommendations',
            'show_trial_banner',
            'logs',
            'mealLogs',
            'days_left',
            'subscriptionCountdown',
            'subscriptionExpiresAt',
            'plannedMeals',
            'invoice'
        ));
    }
    public function storeToken(Request $request)
    {
        Auth::user()->update([
            'device_token' => $request->token
        ]);

        return response()->json(['status' => 'Token saved']);
    }
}
