<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AverageController extends Controller
{
    public function getSevenDayAverage()
    // public function getWeeklyTrend(): JsonResponse
    {
        $user_id = Auth::id();
    
        if (!$user_id) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    
        // Current week: last 7 days
        $current_week = DB::table('conversions')
            ->where('user_id', $user_id)
            ->where('converted_at', '>=', now()->subDays(7))
            ->avg('original_value');
    
        // Previous week: 7–14 days ago
        $previous_week = DB::table('conversions')
            ->where('user_id', $user_id)
            ->whereBetween('converted_at', [now()->subDays(14), now()->subDays(7)])
            ->avg('original_value');
    
        // Determine trend
        $trend = [
            'text' => '--',
            'class' => 'text-muted',
            'icon' => ''
        ];
    
        if ($current_week && $previous_week && $previous_week != 0) {
            $change = (($current_week - $previous_week) / $previous_week) * 100;
            $trend_value = round(abs($change), 1);
    
            if ($change > 0) {
                $trend['text'] = "$trend_value% higher than last week";
                $trend['class'] = "text-danger";
                $trend['icon'] = "bi-arrow-up";
            } else {
                $trend['text'] = "$trend_value% lower than last week";
                $trend['class'] = "text-success";
                $trend['icon'] = "bi-arrow-down";
            }
        }
    
        return response()->json([
            'avg_value' => round($current_week, 1),
            'trend_text' => $trend['text'],
            'trend_class' => $trend['class'],
            'trend_icon' => $trend['icon']
        ]);
    }
}