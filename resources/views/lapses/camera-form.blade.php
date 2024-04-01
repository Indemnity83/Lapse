<x-form-section submit="updateCameras">
    <x-slot name="title">
        {{ __("Timelapse Cameras") }}
    </x-slot>

    <x-slot name="description">
        {{ __("Manage the cameras that are prt of this timelapse.") }}
    </x-slot>

    <x-slot name="form">
        <div
            class="col-span-6 grid grid-flow-row-dense grid-cols-1 sm:grid-cols-3"
        >
            @foreach ($cameras as $camera)
                <x-toggle
                    id="cam-{{ $camera['id'] }}"
                    checked="{{ $camera['enabled'] }}"
                    wire:click="toggleCamera({{ $camera['id'] }})"
                >
                    {{ $camera["name"] }}
                </x-toggle>
            @endforeach
        </div>
    </x-slot>
</x-form-section>
