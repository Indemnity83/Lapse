<?php

namespace App\Livewire\Timelapses;

use App\Models\Timelapse;
use Livewire\Component;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class VideoList extends Component
{
    public $timelapse;

    public MediaCollection $videos;

    public function mount(Timelapse $timelapse)
    {
        $this->timelapse = $timelapse;
        $this->videos = $timelapse->getMedia('timelapse');
    }

    public function delete($mediaId)
    {
        Media::findOrfail($mediaId)->delete();
        $this->videos = $this->timelapse->getMedia('timelapse');
    }

    public function render()
    {
        return view('timelapses.video-list');
    }
}
