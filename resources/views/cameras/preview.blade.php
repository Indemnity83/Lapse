<x-action-section submit="updateCameraInformation">
    <x-slot name="title">
        {{ __("Camera Preview") }}
    </x-slot>

    <x-slot name="description">
        {{ __("Live preview from the camera URL. If this isn't working then you likely have an invalid url.") }}
    </x-slot>

    <x-slot name="content">
        <img
            wire:poll.1s
            class="aspect-video w-full"
            src="{{ $camera->url . "?timestamp=" . time() }}"
            alt="{{ $camera->name }}"
        />
    </x-slot>
</x-action-section>
