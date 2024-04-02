<?php

namespace App\Actions\Timelapses;

use App\Jobs\CaptureSnapshot;
use App\Models\Camera;
use App\Models\Lapse;
use Lorisleiva\Actions\Concerns\AsAction;

class QueueSnapshots
{
    use AsAction;

    public function handle(Lapse $lapse)
    {
        $lapse->cameras->each(fn (Camera $camera) => CaptureSnapshot::dispatch($camera, $lapse));
        $lapse->last_snapshot_at = now();
        $lapse->save();
    }
}
