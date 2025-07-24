<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\SymptomLog;
use App\Models\Conversion;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class SymptomLogs extends Component
{
    public $symptom;
    public $notes;

    public function save()
    {
        $this->validate([
            'symptom' => 'required|string|max:255',
            'notes' => 'nullable|string|max:1000',
        ]);

        SymptomLog::create([
            'user_id'   => Auth::id(),
            'logged_at' => now(),
            'symptom'   => $this->symptom,
            'notes'     => $this->notes,
        ]);

        $this->reset(['symptom', 'notes']);
        session()->flash('success', 'Symptom log saved successfully.');
    }

    public function delete($id)
    {
        $log = SymptomLog::where('id', $id)
            ->where('user_id', Auth::id())
            ->first();

        if ($log) {
            $log->delete();
            session()->flash('success', 'Log deleted.');
        }
    }

    public function render()
    {
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

                if ($log->glucose_before && $log->glucose_after) {
                    $delta = abs($log->glucose_after->original_value - $log->glucose_before->original_value);
                    $log->correlation = $delta > 30 ? 'High' : ($delta > 10 ? 'Moderate' : 'Low');
                } else {
                    $log->correlation = 'Uncertain';
                }

                return $log;
            });

        return view('livewire.symptom-logs', [
            'logs' => $logs,
        ]);
    }
}
