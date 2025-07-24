@extends('layouts.app')

@section('content')
    <div class="container">
        <h2> Meal Logger</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('meal-log.store') }}" method="POST" class="mb-4">
            @csrf
            <label for="meal_description">What did you eat?</label>
            <textarea name="meal_description" class="form-control" rows="3" placeholder="E.g. Rice with beans and chicken..."
                required></textarea>
            <button class="btn btn-primary mt-2"><i class="bi bi-save"></i> Log Meal</button>
        </form>

        <h5> Your Meal History</h5>
        @forelse ($mealLogs as $meal)
            <div class="border p-2 mb-2 bg-light rounded d-flex justify-content-between align-items-start">
                <div>
                    <strong>{{ $meal->meal_description }}</strong><br>
                    <span class="text-muted">{{ $meal->logged_at->diffForHumans() }}</span><br>

                    @foreach ($meal->tags ?? [] as $tag)
                        <span class="badge bg-info">{{ $tag }}</span>
                    @endforeach

                    @if ($meal->glucose)
                        <span class="badge bg-warning">
                            Glucose ({{ \Carbon\Carbon::parse($meal->glucose->converted_at)->format('F j • g:iA') }}):
                            {{ $meal->glucose->original_value }} {{ $meal->glucose->original_unit }}
                        </span>
                    @endif
                    @if (isset($meal->recommendation))
                        <div class="mt-2 alert alert-info small">
                            💡 {{ $meal->recommendation }}
                        </div>
                    @endif
                </div>
                <!-- 🗑️ Remove Button -->
                <form action="{{ route('meal-log.destroy', $meal->id) }}" method="POST"
                    onsubmit="return confirm('Are you sure you want to delete this meal?')" class="ms-3">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete meal log"><i class="bi bi-trash"></i></button>
                </form>
            </div>
        @empty
            <p class="text-muted">No meals logged yet. Start tracking now!</p>
        @endforelse

    </div>
@endsection
