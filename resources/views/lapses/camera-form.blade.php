<div>
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

    @if ($camerasWithSnapshots)
        <x-section-border />

        <div class="mt-10 sm:mt-0">
            <x-action-section>
                <x-slot name="title">
                    {{ __("Snapshots") }}
                </x-slot>

                <x-slot name="description">
                    {{ __("All of the cameras that have snapshots for this timelapse.") }}
                </x-slot>

                <!-- Camera List -->
                <x-slot name="content">
                    <div class="space-y-6">
                        @foreach ($camerasWithSnapshots as $camera)
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="ms-4 dark:text-white">
                                        {{ $camera->snapshotsFor($lapse)->count() }}
                                        {{ __("snapshots") }} from
                                        {{ $camera->name }}
                                    </div>
                                </div>

                                <div class="flex items-center">
                                    <!-- Zip Download -->
                                    <button
                                        wire:click="download({{ $camera->id }})"
                                        class="ms-6 cursor-pointer text-sm text-gray-500 hover:underline focus:outline-none"
                                    >
                                        {{ __("Download") }}
                                    </button>

                                    <!-- Render Video -->
                                    <button
                                        wire:click="video({{ $camera->id }})"
                                        class="ms-6 cursor-pointer text-sm text-gray-500 hover:underline focus:outline-none"
                                    >
                                        {{ __("Render") }}
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </x-slot>
            </x-action-section>
        </div>
    @endif
</div>
