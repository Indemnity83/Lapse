<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lapses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('interval');
            $table->datetime('last_snapshot_at')->nullable();
            $table->boolean('is_paused')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lapses');
    }
};
