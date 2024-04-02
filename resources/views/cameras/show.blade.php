<x-app-layout>
    <x-slot name="header">
        <h2
            class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200"
        >
            {{ $camera->name }}
        </h2>
    </x-slot>

    <div>
        <div class="mx-auto max-w-7xl py-10 sm:px-6 lg:px-8">
            @livewire("cameras.update-camera-information-form", ["camera" => $camera])

            <x-section-border />

            <div class="mt-10 sm:mt-0">
                @livewire("cameras.delete-camera-form", ["camera" => $camera])
            </div>
        </div>
    </div>
</x-app-layout>
