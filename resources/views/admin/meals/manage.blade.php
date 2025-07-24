@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <h3 class="mb-4">Manage Meals</h3>

        @livewire('admin-manage-meals') {{-- Mount Livewire component here --}}
    </div>
@endsection
