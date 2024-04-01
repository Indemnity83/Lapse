<x-action-section>
    <x-slot name="title">
        {{ __("Delete Lapse") }}
    </x-slot>

    <x-slot name="description">
        {{ __("Permanently delete the Timelapse.") }}
    </x-slot>

    <x-slot name="content">
        <div class="max-w-xl text-sm text-gray-600 dark:text-gray-400">
            {{ __("Once the timelapse is deleted, all of its snapshots will be ungrouped. Before deleting this timelapse, please download any data or information that you wish to retain.") }}
        </div>

        <div class="mt-5">
            <x-danger-button
                wire:click="confirmLapseDeletion"
                wire:loading.attr="disabled"
            >
                {{ __("Delete Timelapse") }}
            </x-danger-button>
        </div>

        <!-- Delete User Confirmation Modal -->
        <x-dialog-modal wire:model.live="confirmingLapseDeletion">
            <x-slot name="title">
                {{ __("Delete Timelapse") }}
            </x-slot>

            <x-slot name="content">
                {{ __("Are you sure you want to delete this timelapse? Once the timelapse is deleted, all of its snapshots will be ungrouped. Please enter the timelapse name to permanently delete the timelapse.") }}

                <div
                    class="mt-4"
                    x-data="{}"
                    x-on:confirming-delete-user.window="setTimeout(() => $refs.lapse - name.focus(), 250)"
                >
                    <x-input
                        class="mt-1 block w-3/4"
                        placeholder="{{ $lapse->name }}"
                        x-ref="lapse-name"
                        wire:model="name"
                        wire:keydown.enter="deleteLapse"
                    />

                    <x-input-error for="name" class="mt-2" />
                </div>

                <x-toggle
                    class="mt-3"
                    id="remove-media-toggle"
                    checked="{{ $clearMediaOnDelete }}"
                    wire:click="$toggle('clearMediaOnDelete')"
                >
                    {{ __("Remove images") }}
                </x-toggle>
            </x-slot>

            <x-slot name="footer">
                <x-secondary-button
                    wire:click="$toggle('confirmingLapseDeletion')"
                    wire:loading.attr="disabled"
                >
                    {{ __("Cancel") }}
                </x-secondary-button>

                <x-danger-button
                    class="ms-3"
                    wire:click="deleteLapse"
                    wire:loading.attr="disabled"
                >
                    {{ __("Delete Timelapse") }}
                </x-danger-button>
            </x-slot>
        </x-dialog-modal>
    </x-slot>
</x-action-section>
