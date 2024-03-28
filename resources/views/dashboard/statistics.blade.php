<div wire:poll.30s="fresh">
    <x-section-title>
        <x-slot name="title">Snapshots</x-slot>
        <x-slot name="description"></x-slot>
    </x-section-title>

    <dl class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-2">
        <x-stats-card>
            <x-slot name="metric">{{ __("Total Snapshots") }}</x-slot>
            <x-slot name="value">{{ $this->countForHumans }}</x-slot>
        </x-stats-card>

        <x-stats-card>
            <x-slot name="metric">{{ __("Snapshot Size") }}</x-slot>
            <x-slot name="value">{{ $this->sizeForHumans }}</x-slot>
        </x-stats-card>
    </dl>
</div>
