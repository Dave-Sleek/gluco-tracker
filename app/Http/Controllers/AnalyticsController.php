<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Conversion;
use Carbon\Carbon;

class AnalyticsController extends Controller
{
    public function index()
    {
        return view('analytics.index'); // Ensure 'analytics.index' exists in views
    }

    public function fetchAnalytics(Request $request)
    {
        try {
            if (!Auth::check()) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            $userId = Auth::id();
            $filter = $request->query('filter', 'week');

            $query = Conversion::where('user_id', $userId);

            if ($filter === 'week') {
                $query->where('converted_at', '>=', now()->subDays(7));
            } elseif ($filter === 'month') {
                $query->where('converted_at', '>=', now()->subMonth());
            }

            $conversions = $query->orderBy('converted_at', 'asc')->get();
            

            // Initialize response data structure
            $data = [
                'fasting' => [],
                'after_meal' => [],
                'calendar' => [],
                'all_values' => [],
            ];

            foreach ($conversions as $conversion) {
                // $date = $conversion->converted_at->toDateString();
                $date = Carbon::parse($conversion->converted_at)->toDateString();
                $value = (float) $conversion->original_value;
                $type = $conversion->type;

                if ($type === 'fasting') {
                    $data['fasting'][] = ['date' => $date, 'value' => $value];
                } elseif ($type === 'after_meal') {
                    $data['after_meal'][] = ['date' => $date, 'value' => $value];
                }

                $data['calendar'][] = [
                    'title' => ucfirst($type) . ": " . $value,
                    'start' => $conversion->converted_at
                ];

                $data['all_values'][] = $value;
            }

            // A1C estimation formula
            $avg = count($data['all_values']) ? array_sum($data['all_values']) / count($data['all_values']) : 0;
            $data['a1c_estimate'] = round(($avg + 46.7) / 28.7, 2);

            return response()->json(['success' => true, 'data' => $data]);

        } catch (\Exception $e) {
            Log::error('Fetch Analytics Error: ' . $e->getMessage()); // Log the error
            return response()->json(['error' => 'Internal Server Error', 'message' => $e->getMessage()], 500);
        }
    }
}
