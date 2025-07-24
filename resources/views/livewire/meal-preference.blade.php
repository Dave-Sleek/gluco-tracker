<div>
    <form wire:submit.prevent="updatePreference">
        <label for="mealPreference">Choose your meal style:</label>
        <select wire:model="mealPreference" class="form-control">
            <option value="balanced">Balanced</option>
            <option value="low_glycemic">Low Glycemic</option>
            <option value="energy_boost">Energy Booster</option>
        </select>
        <button type="submit" class="btn btn-primary mt-2"><i class="bi bi-save"></i> Save Preference</button>
    </form>
    @if (session()->has('message'))
        <div class="alert alert-success mt-3">
            {{ session('message') }}
        </div>
    @endif
</div>
