<?php

namespace App\Actions\Timelapses;

use App\Models\Timelapse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateTimelapse
{
    use AsAction;

    public function handle(Timelapse $timelapse, array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:100', Rule::unique('timelapses')->ignore($timelapse->id)],
            'interval' => ['required', 'numeric', 'integer', 'min:1'],
            'cameras' => ['required', 'array', 'min:1'],
        ])->validateWithBag('updateTimelapse');

        $timelapse->forceFill([
            'name' => $input['name'],
            'interval' => $input['interval'],
        ])->save();

        $timelapse->cameras()->sync(array_keys($input['cameras']));
    }
}
