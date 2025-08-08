<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('meeting_ks_kesiswaan', function (Blueprint $table) {
            $table->id();
            $table->text('notulen');
            $table->json('peserta');
            $table->string('capture_image');
            $table->dateTime('waktu_rapat');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('meeting_ks_kesiswaan');
    }
};
