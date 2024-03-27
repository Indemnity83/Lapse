<?php

namespace App\Models;

use DateTime;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\File;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

/**
 * @property int $id
 * @property string $name
 * @property string $url
 * @property DateTime $created_at
 * @property DateTime $updated_at
 * @property Collection<Lapse> $lapses
 * @property Collection<Snapshot> $snapshots
 */
class Camera extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'url',
    ];

    // TODO: This feels like it belongs in the Snapshot model
    private array $allowedMimeTypes = [
        'image/jpeg',
        'image/png',
        'image/gif',
    ];

    public function lapses(): BelongsToMany
    {
        return $this->belongsToMany(Lapse::class);
    }

    public function snapshots(): HasMany
    {
        return $this->hasMany(Snapshot::class);
    }

    // TODO: Might make sense to move this to the snapshot model pass in the url, and return a snapshot?
    // Could use the form $this->snapshots->save(Snapshot::fromUrl($this->url))
    /**
     * @throws Exception
     */
    public function createSnapshot(): Snapshot
    {
        if (! Str::startsWith($this->url, ['http://', 'https://'])) {
            //            throw InvalidUrl::doesNotStartWithProtocol($url);
            throw new Exception('URL must start with http:// or https://');
        }

        // Download image to temporary file and check mime type
        $temporaryFile = $this->getTempFile($this->url);
        $this->guardAgainstInvalidMimeType($temporaryFile, $this->allowedMimeTypes);

        // Determine filename
        $filename = basename(parse_url($this->url, PHP_URL_PATH));
        $filename = urldecode($filename);

        // Try to get the file extension from the filename
        $extension = pathinfo($filename, PATHINFO_EXTENSION);

        // If extension is empty, try to get it from the mime type
        if (! $extension) {
            $mediaExtension = explode('/', mime_content_type($temporaryFile));
            $extension = $mediaExtension[1];
        }

        // build the file name for the snapshot
        $name = Arr::join([
            'camera',
            $this->id,
            now()->format('Y-m-d-His'),
        ], '-') . ".{$extension}";

        return $this->snapshots()->create([
            'path' => Storage::disk('public')->putFileAs('snapshots', $temporaryFile, $name),
        ]);
    }

    /**
     * @throws Exception
     */
    protected function guardAgainstInvalidMimeType(string $file, ...$allowedMimeTypes)
    {
        $allowedMimeTypes = Arr::flatten($allowedMimeTypes);

        if (empty($allowedMimeTypes)) {
            return;
        }

        $validation = Validator::make(
            ['file' => new File($file)],
            ['file' => 'mimetypes:' . implode(',', $allowedMimeTypes)]
        );

        if ($validation->fails()) {
            //            throw MimeTypeNotAllowed::create($file, $allowedMimeTypes);
            throw new Exception('Invalid mime type');
        }
    }

    private function getTempFile(string $url): string
    {
        $temporaryFile = tempnam(sys_get_temp_dir(), 'media-library');

        Http::withUserAgent(config('app.name'))
            ->throw(fn () => throw new Exception('Failed to download image: ' . $url))
            ->sink($temporaryFile)
            ->get($url);

        return $temporaryFile;
    }
}
