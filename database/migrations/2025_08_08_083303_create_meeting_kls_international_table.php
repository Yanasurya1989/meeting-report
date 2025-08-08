<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('meeting_kls_international', function (Blueprint $table) {
            $table->id();
            $table->text('notulen');
            $table->json('peserta'); // checkbox array
            $table->longText('capture_image')->nullable(); // base64
            $table->dateTime('waktu_rapat');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('meeting_kls_international');
    }
};
