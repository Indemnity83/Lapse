<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * @property int $id
 * @property string $name
 * @property string $url
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property-read string $thumb_url
 * @property-read Collection<Lapse> $lapses
 * @property-read MediaCollection $snapshots
 */
class Camera extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $fillable = [
        'name',
        'url',
    ];

    public function lapses(): BelongsToMany
    {
        return $this->belongsToMany(Lapse::class);
    }

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection(config('media.snapshots'))
            ->acceptsMimeTypes(['image/jpeg', 'image/png']);
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(200)
            ->height(200)
            ->sharpen(10);
    }

    protected function snapshots(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->getMedia(config('media.snapshots'))
        );
    }

    protected function thumbUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->getMedia(config('media.snapshots'))->last()?->getUrl('thumb') ?? ''
        );
    }

    protected function lastSnapshotAt(): Attribute
    {
        return Attribute::make(
            get: function () {
                return $this->getMedia(config('media.snapshots'))->last()?->created_at;
                $timestamp = $this->getMedia(config('media.snapshots'))->last()?->created_at;
                if ($timestamp != null) {
                    return $timestamp->diffInSeconds() < 60 ? __('just now') : $timestamp->diffForHumans();
                }

                return null;
            }
        );
    }
}
