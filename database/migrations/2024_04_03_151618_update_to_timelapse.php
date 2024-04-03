<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

return new class extends Migration
{
    public function up(): void
    {
        Schema::rename('lapses', 'timelapses');
        Schema::rename('camera_lapse', 'camera_timelapse');

        Schema::table('camera_timelapse', function (Blueprint $table) {
            $table->renameColumn('lapse_id', 'timelapse_id');
        });

        DB::table('media')
            ->where('model_type', 'App\Models\Lapse')
            ->update(['model_type' => 'App\Models\Timelapse']);

        Media::all()->each(function (Media $media) {
            if ($media->hasCustomProperty('lapse_id')) {
                $timelapseId = $media->getCustomProperty('lapse_id');

                $media->setCustomProperty('timelapse_id', $timelapseId);
                $media->forgetCustomProperty('lapse_id');
                $media->save();
            }
        });
    }

    public function down(): void
    {
        Schema::rename('timelapses', 'lapses');
        Schema::rename('camera_timelapse', 'camera_lapse');

        Schema::table('camera_lapse', function (Blueprint $table) {
            $table->renameColumn('timelapse_id', 'lapse_id');
        });

        DB::table('media')
            ->where('model_type', 'App\Models\Timelapse')
            ->update(['model_type' => 'App\Models\Lapse']);

        Media::all()->each(function (Media $media) {
            if ($media->hasCustomProperty('timelapse_id')) {
                $lapseId = $media->getCustomProperty('timelapse_id');

                $media->setCustomProperty('lapse_id', $lapseId);
                $media->forgetCustomProperty('timelapse_id');
                $media->save();
            }
        });
    }
};
