<?php

namespace App\Actions\Timelapses;

use App\Models\Timelapse;
use Lorisleiva\Actions\Concerns\AsAction;

class DeleteTimelapse
{
    use AsAction;

    public function handle(Timelapse $timelapse, bool $purge = true): void
    {
        $timelapse->snapshots->each(
            fn ($snapshot) => $purge ? $snapshot->delete() : $snapshot->forgetCustomProperty('timelapse_id')
        );
        $timelapse->delete();
    }
}
