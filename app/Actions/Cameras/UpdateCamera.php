<?php

namespace App\Actions\Cameras;

use App\Models\Camera;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateCamera
{
    use AsAction;

    public function handle(Camera $camera, array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:100', Rule::unique('cameras')->ignore($camera->id)],
            'url' => ['required', 'url', 'max:255'],
        ])->validateWithBag('updateCamera');

        $camera->forceFill([
            'name' => $input['name'],
            'url' => $input['url'],
        ])->save();
    }
}
