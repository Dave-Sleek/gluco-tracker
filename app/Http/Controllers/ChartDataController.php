<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChartDataController extends Controller
{
    public function getChartData(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $userId = Auth::id();
        $days = (int) $request->query('days', 7);

        if ($days <= 0 || $days > 90) {
            return response()->json(['error' => 'Invalid time range.'], 400);
        }

        try {
            $data = DB::table('conversions')
                ->where('user_id', $userId)
                ->where('converted_at', '>=', now()->subDays($days))
                ->orderBy('converted_at', 'asc')
                ->get(['converted_at', 'original_value']);

            $labels = $data->pluck('converted_at')->map(function ($dt) {
                return \Carbon\Carbon::parse($dt)->format('Y-m-d H:i');
            });

            $values = $data->pluck('original_value')->map(function ($val) {
                return round((float) $val, 2);
            });

            return response()->json([
                'labels' => $labels,
                'values' => $values,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Server error: ' . $e->getMessage()], 500);
        }
    }
}
