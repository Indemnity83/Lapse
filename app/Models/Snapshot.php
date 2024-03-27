<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $path
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property-read Camera $camera
 * @property-read Lapse $lapse
 */
class Snapshot extends Model
{
    use HasFactory;

    protected $fillable = [
        'path',
    ];

    public function lapse(): BelongsTo
    {
        return $this->belongsTo(Lapse::class);
    }

    public function camera(): BelongsTo
    {
        return $this->belongsTo(Camera::class);
    }
}
