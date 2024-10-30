<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('anpr_events', function (Blueprint $table) {
            $table->id();
            $table->string('license_plate')->nullable();
            $table->timestamp('event_time')->nullable();
            $table->string('xml_path')->nullable();
            $table->string('license_plate_image_path')->nullable();
            $table->string('detection_image_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anpr_events');
    }
};
