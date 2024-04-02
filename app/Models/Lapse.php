<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * @property int $id
 * @property int $interval
 * @property bool $is_paused
 * @property Carbon $last_snapshot_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property-read Collection<Camera> $cameras
 * @property-read MediaCollection $snapshots
 *
 * @method static Builder dueForSnapshot()
 */
class Lapse extends Model
{
    use HasFactory;

    protected $casts = [
        'last_snapshot_at' => 'datetime',
        'is_paused' => 'bool',
    ];

    protected $fillable = [
        'name',
        'interval',
        'is_paused',
    ];

    public function cameras(): BelongsToMany
    {
        return $this->belongsToMany(Camera::class);
    }

    public function scopeDueForSnapshot($query)
    {
        return $query
            ->where('is_paused', false)
            ->where(function ($query) {
                $query
                    ->whereNull('last_snapshot_at')
                    ->orWhereRaw("strftime('%s', 'now') - strftime('%s', last_snapshot_at) > interval * 60");
            });
    }

    protected function snapshots(): Attribute
    {
        return Attribute::make(
            get: fn () => new MediaCollection(Media::query()
                ->where('collection_name', config('media.snapshots'))
                ->where('custom_properties->lapse_id', $this->id)
                ->get())
        );
    }
}
