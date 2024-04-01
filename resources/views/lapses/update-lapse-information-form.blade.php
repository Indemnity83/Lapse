<x-form-section submit="updateLapseName">
    <x-slot name="title">
        {{ __("Timelapse Information") }}
    </x-slot>

    <x-slot name="description">
        {{ __("Update the timelapse name and interval.") }}
    </x-slot>

    <x-slot name="form">
        <!-- Name -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="name" value="{{ __('Lapse Name') }}" />
            <x-input
                id="name"
                type="text"
                class="mt-1 block w-full"
                wire:model="state.name"
                required
            />
            <x-input-error for="name" class="mt-2" />
        </div>

        <!-- Interval -->
        <div class="col-span-6 lg:col-span-2">
            <x-label for="url" value="{{ __('Interval in minutes') }}" />
            <x-input
                id="interval"
                type="number"
                class="mt-1 block w-full"
                wire:model="state.interval"
                min="1"
            />
            <x-input-error for="url" class="mt-2" />
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-action-message class="me-3" on="saved">
            {{ __("Saved.") }}
        </x-action-message>

        <x-button wire:loading.attr="disabled" wire:target="photo">
            {{ __("Save") }}
        </x-button>
    </x-slot>
</x-form-section>
