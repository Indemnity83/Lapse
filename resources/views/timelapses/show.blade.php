<x-app-layout>
    <x-slot name="header">
        <h2
            class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200"
        >
            {{ $timelapse->name }}
        </h2>
    </x-slot>

    <div>
        <div class="mx-auto max-w-7xl py-10 sm:px-6 lg:px-8">
            @livewire("timelapses.status", ["timelapse" => $timelapse])

            <x-section-border />

            @livewire("timelapses.update-timelapse-information-form", ["timelapse" => $timelapse])

            <x-section-border />

            @livewire("timelapses.camera-form", ["timelapse" => $timelapse])

            @livewire("timelapses.video-list", ["timelapse" => $timelapse])

            <x-section-border />

            <div class="mt-10 sm:mt-0">
                @livewire("timelapses.delete-timelapse-form", ["timelapse" => $timelapse])
            </div>
        </div>
    </div>
</x-app-layout>
