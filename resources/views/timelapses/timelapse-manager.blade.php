<div>
    <div class="mt-10 sm:mt-0">
        <x-form-section submit="createTimelapse">
            <x-slot name="title">
                {{ __("Add A Timelapse") }}
            </x-slot>

            <x-slot name="description">
                {{ __("Add a timelapse that will collect snapshots from one or a more cameras at the given interval.") }}
            </x-slot>

            <x-slot name="form">
                <!-- Timelapse Name -->
                <div class="col-span-6 lg:col-span-4">
                    <x-label for="name" value="{{ __('Name') }}" />
                    <x-input
                        id="name"
                        type="text"
                        class="mt-1 block w-full"
                        wire:model="state.name"
                    />
                    <x-input-error for="name" class="mt-2" />
                </div>

                <!-- Interval -->
                <div class="col-span-6 lg:col-span-2">
                    <x-label
                        for="url"
                        value="{{ __('Interval in minutes') }}"
                    />
                    <x-input
                        id="interval"
                        type="number"
                        class="mt-1 block w-full"
                        wire:model="state.interval"
                        min="1"
                    />
                    <x-input-error for="url" class="mt-2" />
                </div>

                <div class="col-span-6">
                    <x-label value="{{ __('Cameras') }}" />
                    <div
                        class="sm:grid-cols my-2 grid grid-cols-3 rounded-md border border-gray-300 p-4 dark:border-gray-700"
                    >
                        @foreach ($cameras as $camera)
                            <x-label for="terms">
                                <div class="flex items-center">
                                    <x-checkbox
                                        value="{{ $camera['id'] }}"
                                        wire:model="state.cameras.{{ $camera['id'] }}"
                                    />

                                    <div class="ms-2">
                                        {{ $camera["name"] }}
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
                    {{ __("Added.") }}
                </x-action-message>

                <x-button>
                    {{ __("Add") }}
                </x-button>
            </x-slot>
        </x-form-section>
    </div>

    @if ($timelapses->isNotEmpty())
        <x-section-border />

        <div class="mt-10 sm:mt-0">
            <x-action-section>
                <x-slot name="title">
                    {{ __("Timelapses") }}
                </x-slot>

                <x-slot name="description">
                    {{ __("Here are each of the configured timelapses.") }}
                </x-slot>

                <!-- Timelapse List -->
                <x-slot name="content">
                    <div class="space-y-6">
                        @foreach ($timelapses->sortBy("name") as $timelapse)
                            <div class="flex items-center justify-between">
                                <div class="flex flex-row items-center">
                                    <div class="flex items-center">
                                        <div class="ms-4 flex flex-col">
                                            <div class="dark:text-white">
                                                <a
                                                    href="{{ route("timelapses.show", $timelapse) }}"
                                                >
                                                    {{ $timelapse->name }}
                                                </a>
                                            </div>
                                            <div>
                                                @if ($timelapse->is_paused)
                                                    <span
                                                        class="inline-flex items-center rounded-md bg-gray-50 px-1.5 py-0.5 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10 dark:bg-gray-900"
                                                    >
                                                        {{ __(":interval minute interval", ["interval" => $timelapse->interval]) }}
                                                    </span>
                                                @else
                                                    <span
                                                        class="inline-flex items-center rounded-md bg-green-50 px-1.5 py-0.5 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20 dark:bg-gray-900"
                                                    >
                                                        {{ __(":interval minute interval", ["interval" => $timelapse->interval]) }}
                                                    </span>
                                                @endif
                                                <span
                                                    class="inline-flex items-center rounded-md bg-gray-50 px-1.5 py-0.5 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10 dark:bg-gray-900"
                                                >
                                                    {{ $timelapse->cameras->count() }}
                                                    cameras
                                                </span>
                                                <span
                                                    class="inline-flex items-center rounded-md bg-gray-50 px-1.5 py-0.5 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10 dark:bg-gray-900"
                                                >
                                                    {{ $timelapse->snapshots->count() }}
                                                    snapshots
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </x-slot>
            </x-action-section>
        </div>
    @endif
</div>
