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
                                        {{ $camera->snapshotsFor($timelapse)->count() }}
                                        {{ __("snapshots") }} from
                                        {{ $camera->name }}
                                    </div>
                                </div>

                                <div class="flex items-center">
                                    <!-- Zip Download -->
                                    <button
                                        wire:click="download({{ $camera->id }})"
                                        class="ms-6 flex cursor-pointer text-sm text-gray-400 hover:underline focus:outline-none"
                                    >
                                        {{ __("Download") }}
                                    </button>

                                    <!-- Render Video -->
                                    <button
                                        wire:click="video({{ $camera->id }})"
                                        class="ms-6 flex cursor-pointer text-sm text-gray-400 hover:underline focus:outline-none"
                                    >
                                        @if (false)
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 16 16"
                                                fill="currentColor"
                                                class="me-1.5 h-4 w-4 animate-spin"
                                            >
                                                <path
                                                    fill-rule="evenodd"
                                                    d="M13.836 2.477a.75.75 0 0 1 .75.75v3.182a.75.75 0 0 1-.75.75h-3.182a.75.75 0 0 1 0-1.5h1.37l-.84-.841a4.5 4.5 0 0 0-7.08.932.75.75 0 0 1-1.3-.75 6 6 0 0 1 9.44-1.242l.842.84V3.227a.75.75 0 0 1 .75-.75Zm-.911 7.5A.75.75 0 0 1 13.199 11a6 6 0 0 1-9.44 1.241l-.84-.84v1.371a.75.75 0 0 1-1.5 0V9.591a.75.75 0 0 1 .75-.75H5.35a.75.75 0 0 1 0 1.5H3.98l.841.841a4.5 4.5 0 0 0 7.08-.932.75.75 0 0 1 1.025-.273Z"
                                                    clip-rule="evenodd"
                                                />
                                            </svg>
                                            {{ __("Rendering") }}
                                        @else
                                            {{ __("Make Video") }}
                                        @endif
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
