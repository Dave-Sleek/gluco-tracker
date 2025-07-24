<div>
    <form wire:submit.prevent="submit" class="card p-4 shadow-sm">
        @if (session()->has('message'))
            <div class="alert alert-success mb-3">
                {{ session('message') }}
            </div>
        @endif

        {{-- @if ($carbs || $fiber || $protein) --}}
        <div class="mt-3">
            <strong>🔢 Total Nutrients:</strong> {{ $this->totalNutrients }}
        </div>
        {{-- @endif --}}

        <div class="mb-3">
            <label class="form-label">Meal Name</label>
            <input type="text" class="form-control" wire:model="name">
            @error('name')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea class="form-control" wire:model="description"></textarea>
            @error('name')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Category</label>
            <select class="form-select" wire:model="category">
                <option value="balanced">Balanced</option>
                <option value="low_glycemic">Low Glycemic</option>
                <option value="energy_boost">Energy Booster</option>
            </select>
            @error('name')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Image Path</label>
            {{-- <input type="text" class="form-control" wire:model="image_url"> --}}
            <input type="file" wire:model="image" accept="image/*" class="form-control">
            @error('name')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        @if ($image)
            <div class="mb-3">
                <img src="{{ $image->temporaryUrl() }}" alt="Preview" class="img-fluid rounded shadow-sm"
                    style="max-height: 200px;">
            </div>
        @endif

        <div class="row">
            <div class="col">
                <label>Carbs</label>
                <input type="number" wire:model.lazy="carbs" class="form-control" placeholder="Carbs">
                @error('name')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>
            <div class="col">
                <label>Fiber</label>
                <input type="number" wire:model.lazy="fiber" class="form-control" placeholder="Fiber">
                @error('name')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>
            <div class="col">
                <label>Protein</label>
                <input type="number" wire:model.lazy="protein" class="form-control" placeholder="Protein">
                @error('name')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <button type="submit" class="btn btn-primary mt-3"><i class="bi bi-plus-circle"></i> Add Meal</button>
        <button wire:click="submit" class="btn btn-primary me-2"><i class="bi bi-save"></i> Save</button>
        <button wire:click="saveAndReset" class="btn btn-secondary"><i class="bi bi-save"></i> <i
                class="bi bi-plus-circle"></i> Save & Add Another</button>
    </form>
</div>
