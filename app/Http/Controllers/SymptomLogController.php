<?php

// app/Http/Controllers/SymptomLogController.php

namespace App\Http\Controllers;

use App\Models\SymptomLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SymptomLogController extends Controller
{
    /**
     * Display a listing of the user's symptom logs.
     */
    public function index()
    {
        $logs = SymptomLog::where('user_id', Auth::id())
            ->with('glucoseLog')
            ->orderBy('logged_at', 'desc')
            ->get();

        return response()->json($logs);
    }

    /**
     * Store a newly created symptom log.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'logged_at' => 'nullable|date',
            'symptom' => 'required|string|max:255',
            'notes' => 'nullable|string',
            'glucose_log_id' => 'nullable|exists:glucose_logs,id',
        ]);

        $symptomLog = SymptomLog::create([
            'user_id' => Auth::id(),
            'logged_at' => $validated['logged_at'] ?? now(),
            'symptom' => $validated['symptom'],
            'notes' => $validated['notes'] ?? null,
            'glucose_log_id' => $validated['glucose_log_id'] ?? null,
        ]);

        return response()->json([
            'message' => 'Symptom logged successfully',
            'log' => $symptomLog,
        ], 201);
    }

    /**
     * Show a specific symptom log.
     */
    public function show($id)
    {
        $log = SymptomLog::where('id', $id)
            ->where('user_id', Auth::id())
            ->with('glucoseLog')
            ->firstOrFail();

        return response()->json($log);
    }

    /**
     * Update an existing symptom log.
     */
    public function update(Request $request, $id)
    {
        $log = SymptomLog::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $validated = $request->validate([
            'logged_at' => 'nullable|date',
            'symptom' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'glucose_log_id' => 'nullable|exists:glucose_logs,id',
        ]);

        $log->update($validated);

        return response()->json([
            'message' => 'Symptom log updated',
            'log' => $log,
        ]);
    }

    /**
     * Delete a symptom log.
     */
    public function destroy($id)
    {
        $log = SymptomLog::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $log->delete();

        return response()->json([
            'message' => 'Symptom log deleted',
        ]);
    }
}
