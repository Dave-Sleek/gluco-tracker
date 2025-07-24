<div>
    <div class="container py-4">
        <h3 class="mb-4"> Manage Meals</h3>

        @if (session()->has('message'))
            <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
                {{ session('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-center mb-3">
            <a href="{{ route('admin.add-meals') }}" class="btn btn-success">
                <i class="bi bi-plus-circle"></i> Add New Meal
            </a>
        </div>


        <div class="input-group mb-3">
            <input type="text" wire:model.lazy="search" class="form-control" placeholder="Search meals...">
            <button class="btn btn-primary" wire:click="searchMeals"><i class="bi bi-search"></i> Search</button>
        </div>

        <div class="row g-4">
            @forelse ($this->meals as $meal)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm">
                        @if ($meal->image_url)
                            <img src="{{ asset($meal->image_url) }}" alt="{{ $meal->name }}" class="card-img-top"
                                style="height: 200px; object-fit: cover;">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $meal->name }}</h5>
                            <p class="card-text">{{ $meal->description }}</p>

                            <p class="small text-muted mb-1">
                                <strong>Category:</strong> {{ ucfirst($meal->category) }}
                            </p>

                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Carbs</th>
                                        <th>Fiber</th>
                                        <th>Protein</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $nutrients = $meal->nutrients; @endphp
                                    <tr>
                                        <td>{{ $nutrients['carbs'] ?? '—' }}</td>
                                        <td>{{ $nutrients['fiber'] ?? '—' }}</td>
                                        <td>{{ $nutrients['protein'] ?? '—' }}</td>
                                    </tr>
                                </tbody>
                            </table>

                            <div class="d-flex justify-content-between mt-3">
                                <a href="{{ route('admin.meals.edit', $meal->id) }}" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form method="POST" action="{{ route('admin.meals.delete', $meal->id) }}"
                                    onsubmit="return confirm('Are you sure you want to delete this meal?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger"> <i class="bi bi-trash"></i> Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center text-muted my-5">
                    😞 No meals found. Try searching or add a new one.
                </div>
            @endforelse
        </div>
    </div>
</div>
