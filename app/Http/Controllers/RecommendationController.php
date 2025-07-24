<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class RecommendationController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $entries = DB::table('conversions')
            ->where('user_id', $userId)
            ->orderByDesc('converted_at')
            ->limit(30)
            ->get(['original_value', 'original_unit', 'type', 'label', 'converted_at']);

        $results = $this->analyzeData($entries);

        return view('recommendations.index', [
            'advice' => $results['advice'],
            'flags' => $results['flags'],
            'chartData' => $entries,
        ]);
    }

    private function analyzeData($entries)
    {
        $highs = $lows = 0;
        $flags = [];
        $advice = [];
        $missed = ['morning' => 0, 'afternoon' => 0, 'evening' => 0];
        $fasting = $after_meal = [];

        $total = $entries->count();

        if ($total === 0) {
            return [
                'advice' => ['❗ No blood sugar data available. Start logging your readings to get personalized recommendations.'],
                'flags' => []
            ];
        }

        foreach ($entries as $entry) {
            $unit = $entry->original_unit ?? 'mg/dL';
            $value = (float) $entry->original_value;

            // Normalize all to mg/dL for logic
            if ($unit === 'mmol/L') {
                $value *= 18;
            }

            // Collect averages by type
            $type = strtolower(trim($entry->type));
            if ($type === 'fasting') $fasting[] = $value;
            elseif ($type === 'after_meal') $after_meal[] = $value;

            // High/Low flagging
            if ($value < 70) {
                $lows++;
                $flags[] = "Reading {$entry->original_value} {$unit} – Considered hypoglycemia.";
            } elseif ($value > 180) {
                $highs++;
                $flags[] = "Reading {$entry->original_value} {$unit} – Considered hyperglycemia.";
            }

            // Time-of-day tracking
            $hour = Carbon::parse($entry->converted_at)->hour;
            if ($hour < 11) $missed['morning']++;
            elseif ($hour < 17) $missed['afternoon']++;
            else $missed['evening']++;
        }

        // Calculate averages
        $avg_fasting = count($fasting) ? round(array_sum($fasting) / count($fasting), 1) : null;
        $avg_after_meal = count($after_meal) ? round(array_sum($after_meal) / count($after_meal), 1) : null;

        // Recommendations based on averages
        if ($avg_fasting !== null) {
            if ($avg_fasting < 70) {
                $advice[] = "⚠️ Average fasting is low (<strong>{$avg_fasting} mg/dL</strong>). Watch for hypoglycemia.";
            } elseif ($avg_fasting > 130) {
                $advice[] = "🍽️ Elevated fasting average (<strong>{$avg_fasting} mg/dL</strong>). Try low-carb dinners, morning walks, or talk to your doctor about <strong>Metformin</strong>.";
            }
        }

        if ($avg_after_meal !== null) {
            if ($avg_after_meal < 70) {
                $advice[] = "⚠️ Post-meal average is low (<strong>{$avg_after_meal} mg/dL</strong>). Be cautious of insulin timing.";
            } elseif ($avg_after_meal > 180) {
                $advice[] = "🍚 High post-meal average (<strong>{$avg_after_meal} mg/dL</strong>). Consider reducing carbs, walking after meals, or fast-acting insulin.";
            }
        }

        // Over-time logging advice
        foreach ($missed as $time => $count) {
            if ($count < 7) {
                $advice[] = "🕒 Only {$count}/7 readings in the {$time}. Log more often during that period for better insights.";
            }
        }

        // Stable range
        if (empty($advice)) {
            $advice[] = "<i class='bi bi-check-circle' style='color:green;'></i> Great job! Your readings look stable and well-managed.";
        }

        return ['advice' => $advice, 'flags' => $flags];
    }
}
