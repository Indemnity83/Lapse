<?php

namespace App\Actions\Timelapses;

use App\Models\Lapse;
use Illuminate\Support\Facades\Validator;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateLapseInformation
{
    use AsAction;

    public function handle(Lapse $lapse, array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'interval' => ['required', 'numeric', 'integer', 'min:1'],
        ])->validateWithBag('updateLapseName');

        $lapse->forceFill([
            'name' => $input['name'],
            'interval' => $input['interval'],
        ])->save();
    }
}
