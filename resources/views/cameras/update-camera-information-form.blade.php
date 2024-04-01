<x-form-section submit="updateCameraInformation">
    <x-slot name="title">
        {{ __("Camera Information") }}
    </x-slot>

    <x-slot name="description">
        {{ __("Update the camera name and snapshot address.") }}
    </x-slot>

    <x-slot name="form">
        <!-- Name -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="name" value="{{ __('Name') }}" />
            <x-input
                id="name"
                type="text"
                class="mt-1 block w-full"
                wire:model="state.name"
                required
            />
            <x-input-error for="name" class="mt-2" />
        </div>

        <!-- URL -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="url" value="{{ __('Snapshot URL') }}" />
            <x-input
                id="url"
                type="url"
                class="mt-1 block w-full"
                wire:model="state.url"
                required
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
