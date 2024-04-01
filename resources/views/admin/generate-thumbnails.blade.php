<x-action-section>
    <x-slot name="title">
        {{ __("Generate Thumbnails") }}
    </x-slot>

    <x-slot name="description">
        {{ __("Use this to generate fresh thumbnails.") }}
    </x-slot>

    <x-slot name="content">
        <div class="max-w-xl text-sm text-gray-600 dark:text-gray-400">
            {{ __("Note that conversions are queued, so it might take a while to see the effects of the generation in your application..") }}
        </div>

        <div class="mt-5 flex space-x-6">
            <x-button
                wire:click="generateThumbnails"
                wire:loading.attr="disabled"
            >
                {{ __("Generate") }}
            </x-button>
        </div>
    </x-slot>
</x-action-section>
