<?php

namespace App\Models;

use App\Jobs\StoreCurrentImage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

/**
 * @property int $interval
 * @property string $name
 * @property Carbon $last_snapshot_at
 * @property Collection<Camera> $cameras
 *
 * @method static Builder dueForSnapshot()
 */
class Lapse extends Model
{
    use HasFactory;

    protected $casts = [
        'last_snapshot_at' => 'datetime',
    ];

    protected $fillable = [
        'name',
        'interval',
    ];

    public function cameras(): BelongsToMany
    {
        return $this->belongsToMany(Camera::class);
    }

    public function snapshots(): HasMany
    {
        return $this->hasMany(Snapshot::class);
    }

    public function scopeDueForSnapshot($query)
    {
        $intervalInSeconds = $this->interval * 60;

        return $query
            ->where('is_paused', false)
            ->where(function ($query) use ($intervalInSeconds) {
                $query
                    ->whereNull('last_snapshot_at')
                    ->orWhereRaw("strftime('%s', 'now') - strftime('%s', last_snapshot_at) > {$intervalInSeconds}");
            });
    }

    public function snapshot(): void
    {
        $this->cameras->each(fn (Camera $camera) => StoreCurrentImage::dispatch($camera, $this));

        $this->last_snapshot_at = now();
        $this->save();
    }
}
