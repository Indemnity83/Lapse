<x-action-section>
    <x-slot name="title">
        {{ __("Videos") }}
    </x-slot>

    <x-slot name="description">
        {{ __("All the generated videos for this timelapse.") }}
    </x-slot>

    <!-- Camera List -->
    <x-slot name="content">
        <div class="space-y-6">
            @foreach ($videos as $video)
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="ms-4 dark:text-white">
                            {{ $video->name }}
                        </div>
                    </div>

                    <div class="flex items-center">
                        <!-- Video Download -->
                        <a
                            class="ms-6 cursor-pointer text-sm text-sky-600 hover:underline focus:outline-none"
                            href="{{ $video->getUrl() }}"
                            download="{{ $video->file_name }}"
                        >
                            {{ __("Download") }}
                        </a>

                        <button
                            class="ms-6 cursor-pointer text-sm text-red-600 focus:outline-none"
                            wire:click="delete({{ $video->id }})"
                        >
                            {{ __("Delete") }}
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    </x-slot>
</x-action-section>
