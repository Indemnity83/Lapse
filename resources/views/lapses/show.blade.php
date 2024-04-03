<x-app-layout>
    <x-slot name="header">
        {{-- @livewire('lapses.header', ['lapse' => $lapse]) --}}
        <h2
            class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200"
        >
            {{ $lapse->name }}
        </h2>
    </x-slot>

    <div>
        <div class="mx-auto max-w-7xl py-10 sm:px-6 lg:px-8">
            @livewire("lapses.status", ["lapse" => $lapse])

            <x-section-border />

            @livewire("lapses.update-lapse-information-form", ["lapse" => $lapse])

            <x-section-border />

            @livewire("lapses.camera-form", ["lapse" => $lapse])

            @livewire("lapses.video-list", ["lapse" => $lapse])

            <x-section-border />

            <div class="mt-10 sm:mt-0">
                @livewire("lapses.delete-lapse-form", ["lapse" => $lapse])
            </div>
        </div>
    </div>
</x-app-layout>
