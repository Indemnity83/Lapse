<?php

namespace App\Livewire\Dashboard;

use Illuminate\Support\Number;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Statistics extends Component
{
    public MediaCollection $media;

    public function mount(): void
    {
        $this->fresh();
    }

    public function fresh(): void
    {
        $this->media = new MediaCollection(Media::all());
    }

    #[Computed]
    public function countForHumans()
    {
        return Number::forHumans($this->media->count());
    }

    #[Computed]
    public function sizeForHumans()
    {
        return Number::fileSize($this->media->totalSizeInBytes());
    }

    public function render()
    {
        return view('dashboard.statistics');
    }
}
