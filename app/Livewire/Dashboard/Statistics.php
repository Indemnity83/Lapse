<?php

namespace App\Livewire\Dashboard;

use Illuminate\Support\Number;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Statistics extends Component
{
    public function snapshotCount(): string
    {
        return Number::format(Media::query()
            ->where('collection_name', 'snapshots')
            ->count());
    }

    #[Computed]
    public function timelapseCount(): string
    {
        return Number::format(Media::query()
            ->where('collection_name', 'timelapse')
            ->count());
    }

    #[Computed]
    public function snapshotSize(): string
    {
        return Number::fileSize(Media::query()
            ->where('collection_name', 'snapshots')
            ->sum('size'), 2);
    }

    #[Computed]
    public function timelapseSize(): string
    {
        return Number::fileSize(Media::query()
            ->where('collection_name', 'timelapse')
            ->sum('size'), 2);
    }

    public function render()
    {
        return view('dashboard.statistics');
    }
}
