<div>
    <form wire:submit.prevent="save" class="mb-4">
        <div class="mb-2">
            <label>Symptom</label>
            <select wire:model.defer="symptom" class="form-select">
                <option value="">-- Select Symptom --</option>
                <option value="Fatigue">😫 Fatigue</option>
                <option value="Dizziness">😵 Dizziness</option>
                <option value="Mood Drop">😐 Mood Drop</option>
                <option value="Cravings">🤤 Cravings</option>
                <option value="Stress">😰 Stress</option>
                <option value="Poor Sleep">😴 Poor Sleep</option>
            </select>
        </div>

        <div class="mb-2">
            <label>Notes</label>
            <textarea wire:model.defer="notes" class="form-control" placeholder="Optional notes..."></textarea>
        </div>

        <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Log Symptom</button>
    </form>

    @foreach ($logs as $log)
        <div class="border p-2 mb-2 bg-light rounded">
            <strong>{{ $log->symptom }}</strong>
            <span class="text-muted">{{ \Carbon\Carbon::parse($log->logged_at)->diffForHumans() }}</span><br>

            @if ($log->notes)
                <small><i class="bi bi-file-text"></i> {{ $log->notes }}</small><br>
            @endif

            @if ($log->glucose_before)
                <span class="badge bg-warning">Before: {{ $log->glucose_before->original_value }}
                    {{ $log->glucose_before->original_unit }}</span>
            @endif

            @if ($log->glucose_after)
                <span class="badge bg-info">After: {{ $log->glucose_after->original_value }}
                    {{ $log->glucose_after->original_unit }}</span>
            @endif

            @if (isset($log->correlation))
                <span class="badge bg-secondary">🧠 Correlation: {{ $log->correlation }}</span>
            @endif
        </div>
    @endforeach

    @foreach ($logs as $log)
        <div class="border p-2 mb-2 rounded bg-light d-flex justify-content-between align-items-start">
            <div>
                <strong>{{ $log->symptom }}</strong>
                <span class="text-muted">{{ \Carbon\Carbon::parse($log->logged_at)->diffForHumans() }}</span><br>
                @if ($log->notes)
                    <small>{{ $log->notes }}</small>
                @endif
            </div>
            <button class="btn btn-sm btn-outline-danger" wire:click="delete({{ $log->id }})"
                title="Remove symptom log">
                <i class="bi bi-trash"></i>
            </button>
        </div>
    @endforeach

</div>
