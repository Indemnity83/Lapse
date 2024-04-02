<?php

namespace App\Actions\Cameras;

use App\Models\Camera;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateCameraInformation
{
    use AsAction;

    public function handle(Camera $camera, array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255', Rule::unique('cameras')->ignore($camera->id)],
            'url' => ['required', 'url', 'max:255'],
        ])->validateWithBag('updateCameraInformation');

        $camera->forceFill([
            'name' => $input['name'],
            'url' => $input['url'],
        ])->save();
    }
}
