@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h3 class="mb-4">✏️ Edit Meal</h3>

    <form action="{{ route('admin.meals.update', $meal->id) }}" method="POST" enctype="multipart/form-data" class="card p-4 shadow-sm">
        @csrf
        @method('PUT')

        @if (session()->has('message'))
            <div class="alert alert-success mb-3">
                {{ session('message') }}
            </div>
        @endif

        <div class="mb-3">
            <label class="form-label">Meal Name</label>
            <input type="text" name="name" class="form-control" value="{{ $meal->name }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" required>{{ $meal->description }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Category</label>
            <select name="category" class="form-select" required>
                <option value="balanced" {{ $meal->category == 'balanced' ? 'selected' : '' }}>Balanced</option>
                <option value="low_glycemic" {{ $meal->category == 'low_glycemic' ? 'selected' : '' }}>Low Glycemic</option>
                <option value="energy_boost" {{ $meal->category == 'energy_boost' ? 'selected' : '' }}>Energy Booster</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Replace Image (optional)</label>
            <input type="file" name="image" accept="image/*" class="form-control">
        </div>

        @php
            $nutrients = $meal->nutrients;
        @endphp

        <div class="row mb-3">
            <div class="col">
                <label>Carbs</label>
                <input type="number" name="carbs" class="form-control" value="{{ $nutrients['carbs'] ?? 0 }}" required>
            </div>
            <div class="col">
                <label>Fiber</label>
                <input type="number" name="fiber" class="form-control" value="{{ $nutrients['fiber'] ?? 0 }}" required>
            </div>
            <div class="col">
                <label>Protein</label>
                <input type="number" name="protein" class="form-control" value="{{ $nutrients['protein'] ?? 0 }}" required>
            </div>
        </div>

        <button type="submit" class="btn btn-success">💾 Update Meal</button>
        <a href="{{ route('admin.meals.manage') }}" class="btn btn-secondary ms-2">← Back</a>
    </form>
</div>
@endsection
