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
            <div class="mt-10 sm:mt-0">
                @livewire("timelapses.status", ["timelapse" => $timelapse])
            </div>

            <x-section-border />

            <div class="mt-10 sm:mt-0">
                @livewire("timelapses.update-timelapse-form", ["timelapse" => $timelapse])
            </div>

            @if ($timelapse->snapshots->count())
                <x-section-border />
                <div class="mt-10 sm:mt-0">
                    @livewire("timelapses.camera-form", ["timelapse" => $timelapse])
                </div>
            @endif

            @if ($timelapse->videos->count())
                <x-section-border />
                <div class="mt-10 sm:mt-0">
                    @livewire("timelapses.video-list", ["timelapse" => $timelapse])
                </div>
            @endif

            <x-section-border />

            <div class="mt-10 sm:mt-0">
                @livewire("timelapses.delete-timelapse-form", ["timelapse" => $timelapse])
            </div>
        </div>
    </div>
</x-app-layout>
