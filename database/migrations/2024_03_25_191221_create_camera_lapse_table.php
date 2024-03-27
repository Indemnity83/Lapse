<?php

use App\Models\Camera;
use App\Models\Lapse;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('camera_lapse', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Camera::class);
            $table->foreignIdFor(Lapse::class);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('camera_lapse');
    }
};
