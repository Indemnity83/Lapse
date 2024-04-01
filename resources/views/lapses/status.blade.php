<x-action-section>
    <x-slot name="title">
        {{ __("Timelapse Status") }}
    </x-slot>

    <x-slot name="description">
        {{ __("Information about, and control of the timelapse.") }}
    </x-slot>

    <x-slot name="content">
        <div class="max-w-xl text-sm text-gray-600 dark:text-gray-400">
            {{ __("Once the timelapse is deleted, all of its snapshots will be ungrouped. Before deleting this timelapse, please download any data or information that you wish to retain.") }}
        </div>

        <div class="mt-5">
            @if ($lapse->is_paused)
                <x-button wire:click="runLapse()" wire:loading.attr="disabled">
                    {{ __("Start the Timelapse") }}
                </x-button>
            @else
                <x-secondary-button
                    wire:click="pauseLapse()"
                    wire:loading.attr="disabled"
                >
                    {{ __("Pause the Timelapse") }}
                </x-secondary-button>
            @endif
        </div>
    </x-slot>
</x-action-section>
