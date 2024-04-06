<x-form-section submit="updateTimelapse">
    <x-slot name="title">
        {{ __("Timelapse Information") }}
    </x-slot>

    <x-slot name="description">
        {{ __("Update the timelapse name and interval.") }}
    </x-slot>

    <x-slot name="form">
        <!-- Name -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="name" value="{{ __('Timelapse Name') }}" />
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
            <x-input-error for="interval" class="mt-2" />
        </div>

        <!-- Cameras -->
        <div class="col-span-6">
            <x-label value="{{ __('Cameras') }}" />
            <div
                class="sm:grid-cols my-2 grid grid-cols-3 rounded-md border border-gray-300 p-4 dark:border-gray-700"
            >
                @foreach ($cameras as $camera)
                    <x-label for="terms">
                        <div class="flex items-center">
                            <x-checkbox
                                value="{{ $camera->id }}"
                                wire:model="state.cameras.{{ $camera->id }}"
                            />

                            <div class="ms-2">
                                {{ $camera->name }}
                            </div>
                        </div>
                    </x-label>
                @endforeach
            </div>
            <x-input-error for="cameras" class="mt-2" />
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
