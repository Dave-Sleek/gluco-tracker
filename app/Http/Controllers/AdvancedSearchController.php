<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdvancedSearchController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id();
        $start = $request->query('start_date');
        $end = $request->query('end_date');
        $type = $request->query('type');
        $label = $request->query('label');
        $page = max(1, (int) $request->query('page', 1));
        $limit = 10;

        $query = DB::table('conversions')->where('user_id', $userId);

        if ($start && $end) {
            $query->whereBetween('converted_at', ["$start 00:00:00", "$end 23:59:59"]);
        }

        if ($type) {
            $query->where('type', $type);
        }

        if ($label) {
            $query->where('label', 'like', "%$label%");
        }

        $total = $query->count();
        $totalPages = ceil($total / $limit);

        $results = $query
            ->orderByDesc('converted_at')
            ->offset(($page - 1) * $limit)
            ->limit($limit)
            ->get();

        return view('advance_search.index', [
            'data' => $results,
            'totalPages' => $totalPages,
            'currentPage' => $page,
            'start_date' => $start,
            'end_date' => $end,
            'type' => $type,
            'label' => $label,
        ]);
    }

    public function exportCsv(Request $request): StreamedResponse
    {
        $userId = Auth::id();
    
        $query = DB::table('conversions')
            ->where('user_id', $userId);
    
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('converted_at', [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59'
            ]);
        }
    
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
    
        if ($request->filled('label')) {
            $query->where('label', 'like', '%' . $request->label . '%');
        }
    
        $query->orderByDesc('converted_at');
    
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="readings_export.csv"',
        ];
    
        $callback = function () use ($query) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Date', 'Reading', 'Unit', 'Type', 'Label']);
    
            foreach ($query->cursor() as $row) {
                fputcsv($file, [
                    $row->converted_at,
                    $row->converted_value,
                    $row->converted_unit,
                    $row->type,
                    $row->label
                ]);
            }
    
            fclose($file);
        };
    
        return response()->stream($callback, 200, $headers);
    }
}
