<div>
    <div class="mt-10 sm:mt-0">
        <x-form-section submit="addLapse">
            <x-slot name="title">
                {{ __("Add A Timelapse") }}
            </x-slot>

            <x-slot name="description">
                {{ __("Add a timelapse that will collect snapshots from one or a more cameras at the given interval.") }}
            </x-slot>

            <x-slot name="form">
                <!-- Lapse Name -->
                <div class="col-span-6 lg:col-span-4">
                    <x-label for="name" value="{{ __('Name') }}" />
                    <x-input
                        id="name"
                        type="text"
                        class="mt-1 block w-full"
                        wire:model="addLapseForm.name"
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
                        wire:model="addLapseForm.interval"
                        min="1"
                    />
                    <x-input-error for="url" class="mt-2" />
                </div>

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

    @if ($lapses->isNotEmpty())
        <x-section-border />

        <div class="mt-10 sm:mt-0">
            <x-action-section>
                <x-slot name="title">
                    {{ __("Timelapses") }}
                </x-slot>

                <x-slot name="description">
                    {{ __("Here are each of the configured timelapses.") }}
                </x-slot>

                <!-- Lapse List -->
                <x-slot name="content">
                    <div class="space-y-6">
                        @foreach ($lapses->sortBy("name") as $lapse)
                            <div class="flex items-center justify-between">
                                <div class="flex flex-row items-center">
                                    <div class="flex items-center">
                                        <div class="ms-4 flex flex-col">
                                            <div class="dark:text-white">
                                                <a
                                                    href="{{ route("lapses.show", $lapse) }}"
                                                >
                                                    {{ $lapse->name }}
                                                </a>
                                            </div>
                                            <div>
                                                @if ($lapse->is_paused)
                                                    <span
                                                        class="inline-flex items-center rounded-md bg-gray-50 px-1.5 py-0.5 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10 dark:bg-gray-900"
                                                    >
                                                        {{ __(":interval minute interval", ["interval" => $lapse->interval]) }}
                                                    </span>
                                                @else
                                                    <span
                                                        class="inline-flex items-center rounded-md bg-green-50 px-1.5 py-0.5 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20 dark:bg-gray-900"
                                                    >
                                                        {{ __(":interval minute interval", ["interval" => $lapse->interval]) }}
                                                    </span>
                                                @endif
                                                <span
                                                    class="inline-flex items-center rounded-md bg-gray-50 px-1.5 py-0.5 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10 dark:bg-gray-900"
                                                >
                                                    {{ $lapse->cameras->count() }}
                                                    cameras
                                                </span>
                                                <span
                                                    class="inline-flex items-center rounded-md bg-gray-50 px-1.5 py-0.5 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10 dark:bg-gray-900"
                                                >
                                                    {{ $lapse->snapshots->count() }}
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
