<div class="container my-4">
    <h2 class="mb-4">🥗 Your Smart Meal Suggestions</h2>

   @if (session()->has('message'))
    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1100;">
        <div class="toast align-items-center text-white bg-success border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    {{ session('message') }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>
@endif

    @push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const toastEl = document.querySelector('.toast');
            if (toastEl) {
                const toast = new bootstrap.Toast(toastEl, { delay: 3000 });
                toast.show();
            }
        });
    </script>
    @endpush


    <div class="row">
        <div class="mb-3">
                <div class="alert alert-info">
                    Update your meal style to personalize suggestions:
                    @livewire('meal-preference', [], key('meal-preference'))
                </div>
            </div>

        @forelse ($meals as $meal)
            <div class="col-md-4 mb-4" wire:key="meal-{{ $meal->id }}">
                <div class="card h-100 shadow-sm">
                   @if ($meal->image_url)
                        <img src="{{ asset($meal->image_url) }}"
                            class="card-img-top"
                            alt="{{ $meal->name }}"
                            style="height: 290px; width: 100%; object-fit: cover;">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $meal->name }}</h5>
                        <p class="card-text">{{ $meal->description }}</p>
                        <button wire:click="addToPlan({{ $meal->id }})" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i> Add to Plan
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center text-muted my-5">
                😞 No meal suggestions available right now.<br>
                Try updating your health profile or click <strong>“Suggest New Meals”</strong> to refresh.
            </div>
        @endforelse
    </div>

    <div class="text-center mt-4">
        <button wire:click="swap" wire:loading.attr="disabled" class="btn btn-outline-success">
            <i class="bi bi-arrow-clockwise"></i> Suggest New Meals
        </button>
        <br />
        <div wire:loading class="text-center mt-2">
            <small>Loading new suggestions...</small>
        </div>
    </div>
</div>
