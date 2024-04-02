<?php

namespace App\Actions\Timelapses;

use App\Models\Lapse;
use Lorisleiva\Actions\Concerns\AsAction;

class DeleteLapse
{
    use AsAction;

    public function handle(Lapse $lapse, bool $purge = true): void
    {
        $lapse->snapshots->each(
            fn ($snapshot) => $purge ? $snapshot->delete() : $snapshot->forgetCustomProperty('lapse_id')
        );
        $lapse->delete();
    }
}
