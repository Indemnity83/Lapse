<div>
    <div class="mt-10 sm:mt-0">
        <x-form-section submit="addCamera">
            <x-slot name="title">
                {{ __("Add Camera") }}
            </x-slot>

            <x-slot name="description">
                {{ __("Add a new camera to your application, enabling it to capture snapshots.") }}
            </x-slot>

            <x-slot name="form">
                <div class="col-span-6">
                    <div
                        class="max-w-xl text-sm text-gray-600 dark:text-gray-400"
                    >
                        {{ __("Please provide a convenient name and URL to the current snapshot of the camera. URLs to the camera's webpage or to a video or RTSP stream are not supported.") }}
                    </div>
                </div>

                <!-- Camera Name -->
                <div class="col-span-6 lg:col-span-2">
                    <x-label for="name" value="{{ __('Name') }}" />
                    <x-input
                        id="name"
                        type="text"
                        class="mt-1 block w-full"
                        wire:model="addCameraForm.name"
                    />
                    <x-input-error for="name" class="mt-2" />
                </div>

                <!-- Camera Url -->
                <div class="col-span-6 lg:col-span-4">
                    <x-label for="url" value="{{ __('Snapshot URL') }}" />
                    <x-input
                        id="url"
                        type="url"
                        class="mt-1 block w-full"
                        wire:model="addCameraForm.url"
                    />
                    <x-input-error for="url" class="mt-2" />
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

    @if ($cameras->isNotEmpty())
        <x-section-border />

        <div class="mt-10 sm:mt-0">
            <x-action-section>
                <x-slot name="title">
                    {{ __("Cameras") }}
                </x-slot>

                <x-slot name="description">
                    {{ __("All of the cameras available in the application.") }}
                </x-slot>

                <!-- Camera List -->
                <x-slot name="content">
                    <div class="space-y-6">
                        @foreach ($cameras->sortBy("name") as $camera)
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <button
                                        class="relative cursor-pointer"
                                        wire:click="previewCamera('{{ $camera->id }}')"
                                    >
                                        <img
                                            wire:poll
                                            class="aspect-video h-14 border border-gray-300 object-cover sm:rounded-md dark:border-gray-700 dark:bg-gray-900"
                                            src="{{ $camera->url . "?timestamp=" . time() }}"
                                            alt="{{ $camera->name }}"
                                        />
                                        <div
                                            class="absolute inset-0 z-10 flex aspect-video h-14 items-center justify-center overflow-hidden bg-white text-black opacity-0 duration-300 hover:opacity-60"
                                        >
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke-width="1.5"
                                                stroke="currentColor"
                                                class="h-8 w-8"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607ZM10.5 7.5v6m3-3h-6"
                                                />
                                            </svg>
                                        </div>
                                    </button>
                                    <div class="ms-4 flex flex-col">
                                        <div class="dark:text-white">
                                            {{ $camera->name }}
                                        </div>
                                        <div
                                            class="text-xs text-gray-400 dark:text-gray-300"
                                        >
                                            {{ $camera->url }}
                                        </div>
                                    </div>
                                </div>

                                <div class="flex items-center">
                                    <button
                                        class="ms-6 cursor-pointer text-sm text-red-500"
                                        wire:click="confirmCameraRemoval('{{ $camera->id }}')"
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

    <!-- Remove Camera Confirmation Modal -->
    <x-confirmation-modal wire:model.live="confirmingCameraRemoval">
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
                    {{ __("This will permanently delete the :name camera, and remove all of its snapshots.", ["name" => $cameraBeingRemoved?->name]) }}
                </p>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button
                wire:click="$toggle('confirmingCameraRemoval')"
                wire:loading.attr="disabled"
            >
                {{ __("Cancel") }}
            </x-secondary-button>

            <x-danger-button
                class="ms-3"
                wire:click="removeCamera"
                wire:loading.attr="disabled"
            >
                {{ __("Remove") }}
            </x-danger-button>
        </x-slot>
    </x-confirmation-modal>

    <!-- Camera Preview Modal -->
    <x-modal maxWidth="7xl" wire:model.live="previewingCamera">
        <img
            wire:poll
            class="aspect-video border border-gray-300 object-cover sm:rounded-md dark:border-gray-700 dark:bg-gray-900"
            src="{{ $cameraBeingPreviewed?->url . "?timestamp=" . time() }}"
        />
    </x-modal>
</div>
