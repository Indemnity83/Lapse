<div wire:poll.30s>
    <dl class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-4">
        <x-stats-card>
            <x-slot name="metric">{{ __("Snapshots Count") }}</x-slot>
            <x-slot name="value">{{ $this->snapshotCount() }}</x-slot>
        </x-stats-card>

        <x-stats-card>
            <x-slot name="metric">{{ __("Snapshot Size") }}</x-slot>
            <x-slot name="value">{{ $this->snapshotSize() }}</x-slot>
        </x-stats-card>

        <x-stats-card>
            <x-slot name="metric">{{ __("Timelapse Count") }}</x-slot>
            <x-slot name="value">{{ $this->timelapseCount() }}</x-slot>
        </x-stats-card>

        <x-stats-card>
            <x-slot name="metric">{{ __("Timelapse Size") }}</x-slot>
            <x-slot name="value">{{ $this->timelapseSize() }}</x-slot>
        </x-stats-card>
    </dl>
</div>
