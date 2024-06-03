<?php

namespace App\Console\Commands;

use App\Models\Timelapse;
use Illuminate\Console\Command;
use Illuminate\Contracts\Console\PromptsForMissingInput;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\Console\Helper\ProgressBar;

use function Laravel\Prompts\search;

class FillTimelapseCommand extends Command implements PromptsForMissingInput
{
    protected $signature = 'timelapse:fill {timelapse}';

    protected $description = 'Fill in any missing snapshots with blank frames';

    public function handle(): void
    {
        $timelapse = Timelapse::find($this->argument('timelapse'));

        if (is_null($timelapse)) {
            $this->error('Timelapse not found');

            return;
        }

        if (is_null($timelapse->last_snapshot_at)) {
            $this->error('Timelapse has no snapshots');

            return;
        }

        $this->line("Processing {$timelapse->name} with {$timelapse->cameras->count()} cameras.");

        $snapshots = Media::query()
            ->where('collection_name', config('media.snapshots'))
            ->where('custom_properties->timelapse_id', $timelapse->id)
            ->get();

        $intervals = $snapshots
            ->groupBy(fn ($snapshot) => substr($snapshot->name, -22, -7));

        $this->withProgressBar($intervals->count() * $timelapse->cameras->count(), function (ProgressBar $bar) use ($timelapse, $intervals) {
            $count = 0;
            foreach ($intervals as $interval => $snapshots) {
                foreach ($timelapse->cameras as $camera) {

                    if (! in_array($camera->id, Arr::pluck($snapshots, 'model_id'))) {
                        $filename = "camera-{$camera->id}-{$interval}30.jpeg";

                        // Add frame to media collection
                        $camera
                            ->addMedia(UploadedFile::fake()->image('missing', 240, 135))
                            ->usingName($filename)
                            ->usingFileName($filename)
                            ->withCustomProperties(['timelapse_id' => $timelapse->id, 'error' => 'Missing snapshot'])
                            ->toMediaCollection(config('media.snapshots'))
                            ->save();

                        $count++;
                    }

                    $bar->advance();
                }
            }

            $this->info("\n\nGenerated {$count} missing snapshots");
        });

    }

    protected function promptForMissingArgumentsUsing(): array
    {
        return [
            'timelapse' => fn () => search(
                label: 'Search for a timelapse:',
                options: fn ($value) => strlen($value) > 0
                    ? Timelapse::where('name', 'like', "%{$value}%")->pluck('name', 'id')->all()
                    : []
            ),
        ];
    }
}
