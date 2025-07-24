@extends('layouts.app')

@section('content')
<div class="container">
    <h2>📋 My Symptom Logs</h2>

    @forelse ($logs as $log)
        <div class="card mb-3">
            <div class="card-body">
                <h5>{{ $log->symptom }} <small class="text-muted">{{ $log->logged_at->format('F j, Y h:i A') }}</small></h5>
                @if($log->notes)
                    <p>{{ $log->notes }}</p>
                @endif
                @if($log->glucoseLog)
                    <span class="badge bg-info">Glucose: {{ $log->glucoseLog->reading ?? 'N/A' }} mg/dL</span>
                @endif
            </div>
        </div>
    @empty
        <p>No symptoms logged yet. Ready to start?</p>
    @endforelse
</div>
@endsection
