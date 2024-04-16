<?php

namespace App\Livewire\Timelapses;

use App\Models\Camera;
use App\Models\Timelapse;
use Livewire\Component;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class SnapshotList extends Component
{
    public $perPage = 0;
    public $timelapse;
    public $camera;
    public $snapshots;
    public $hasMorePages = false;

    public function mount(Timelapse $timelapse, Camera $camera)
    {
        $this->timelapse = $timelapse;
        $this->camera = $camera;

        $this->loadMore();
    }

    public function loadMore()
    {
        $this->perPage += 40;

        $media = $this->camera->media()
            ->where('custom_properties->timelapse_id', $this->timelapse->id)
            ->paginate($this->perPage);

        $this->snapshots = $media->all();
        $this->hasMorePages = $media->hasMorePages();
    }

    public function download($snapshotId)
    {
        $mediaItem = Media::findOrFail($snapshotId);

        return response()->download($mediaItem->getPath(), $mediaItem->file_name);
    }

    public function render()
    {
        return view('timelapses.snapshot-list');
    }
}
