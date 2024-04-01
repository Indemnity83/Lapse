<x-action-section>
    <x-slot name="title">
        {{ __("Delete Camera") }}
    </x-slot>

    <x-slot name="description">
        {{ __("Permanently delete the camera.") }}
    </x-slot>

    <x-slot name="content">
        <div class="max-w-xl text-sm text-gray-600 dark:text-gray-400">
            {{ __("Once the camera is deleted, all of its snapshots will also be permanently deleted. Before deleting this camera, please download any data or information that you wish to retain.") }}
        </div>

        <div class="mt-5">
            <x-danger-button
                wire:click="confirmCameraDeletion"
                wire:loading.attr="disabled"
            >
                {{ __("Delete Camera") }}
            </x-danger-button>
        </div>

        <!-- Delete User Confirmation Modal -->
        <x-dialog-modal wire:model.live="confirmingCameraDeletion">
            <x-slot name="title">
                {{ __("Delete Camera") }}
            </x-slot>

            <x-slot name="content">
                {{ __("Are you sure you want to delete this camera? Once the camera is deleted, all of its snapshots will be permanently deleted. Please enter the camera name to permanently delete the camera.") }}

                <div
                    class="mt-4"
                    x-data="{}"
                    x-on:confirming-delete-user.window="setTimeout(() => $refs.camera - name.focus(), 250)"
                >
                    <x-input
                        class="mt-1 block w-3/4"
                        placeholder="{{ $camera->name }}"
                        x-ref="camera-name"
                        wire:model="name"
                        wire:keydown.enter="deleteCamera"
                    />

                    <x-input-error for="name" class="mt-2" />
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-secondary-button
                    wire:click="$toggle('confirmingCameraDeletion')"
                    wire:loading.attr="disabled"
                >
                    {{ __("Cancel") }}
                </x-secondary-button>

                <x-danger-button
                    class="ms-3"
                    wire:click="deleteCamera"
                    wire:loading.attr="disabled"
                >
                    {{ __("Delete Camera") }}
                </x-danger-button>
            </x-slot>
        </x-dialog-modal>
    </x-slot>
</x-action-section>
