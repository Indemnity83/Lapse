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
                        <div class="mb-2 flex items-center">
                            <button
                                wire:click="toggleCamera('{{ $camera["id"] }}')"
                                type="button"
                                class="{{ $camera["enabled"] ? "bg-indigo-600" : "bg-gray-200" }} relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2"
                                role="switch"
                                aria-checked="false"
                                aria-labelledby="annual-billing-label"
                            >
                                <span
                                    aria-hidden="true"
                                    class="{{ $camera["enabled"] ? "translate-x-5" : "translate-x-0" }} pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"
                                ></span>
                            </button>
                            <span
                                class="ml-3 text-sm"
                                id="annual-billing-label"
                            >
                                <span class="font-medium text-gray-900">
                                    {{ $camera["name"] }}
                                </span>
                            </span>
                        </div>
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
                                                {{ $lapse->name }}
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

                                <div class="flex items-center">
                                    @if ($lapse->is_paused)
                                        <button
                                            class="ms-2 text-sm text-indigo-600 underline dark:text-indigo-400"
                                            wire:click="runLapse('{{ $lapse->id }}')"
                                        >
                                            {{ __("Run") }}
                                        </button>
                                    @else
                                        <button
                                            class="ms-2 text-sm text-gray-400 underline"
                                            wire:click="pauseLapse('{{ $lapse->id }}')"
                                        >
                                            {{ __("Pause") }}
                                        </button>
                                    @endif

                                    <button
                                        class="ms-6 cursor-pointer text-sm text-red-500"
                                        wire:click="confirmLapseRemoval('{{ $lapse->id }}')"
                                    >
                                        {{ __("Remove") }}
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </x-slot>
            </x-action-section>
        </div>
    @endif

    <!-- Remove Lapse Confirmation Modal -->
    <x-confirmation-modal wire:model.live="confirmingLapseRemoval">
        <x-slot name="title">
            {{ __("Are you absolutely sure?") }}
        </x-slot>

        <x-slot name="content">
            <div class="prose-sm dark:prose-invert">
                <p>
                    {{ __('Unexpected bad things will happen if you don\'t read this!') }}
                </p>
                <p>
                    {{ __("This action cannot be undone.") }}
                    {{ __("This will permanently delete the :name timelapse, and all of the related snapshots will no longer be grouped together.", ["name" => $lapseBeingRemoved?->name]) }}
                </p>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button
                wire:click="$toggle('confirmingLapseRemoval')"
                wire:loading.attr="disabled"
            >
                {{ __("Cancel") }}
            </x-secondary-button>

            <x-danger-button
                class="ms-3"
                wire:click="removeLapse"
                wire:loading.attr="disabled"
            >
                {{ __("Remove") }}
            </x-danger-button>
        </x-slot>
    </x-confirmation-modal>
</div>
