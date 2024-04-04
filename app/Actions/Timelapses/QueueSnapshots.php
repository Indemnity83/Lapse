<?php

namespace App\Actions\Timelapses;

use App\Jobs\CaptureSnapshot;
use App\Models\Camera;
use App\Models\Timelapse;
use Lorisleiva\Actions\Concerns\AsAction;

class QueueSnapshots
{
    use AsAction;

    public function handle(Timelapse $timelapse)
    {
        $timelapse->cameras->each(fn (Camera $camera) => CaptureSnapshot::dispatch($camera, $timelapse));
        $timelapse->last_snapshot_at = now();
        $timelapse->save();
    }
}
