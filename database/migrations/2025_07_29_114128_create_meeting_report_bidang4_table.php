<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('meeting_report_bidang4', function (Blueprint $table) {
            $table->id();
            $table->text('notulen');
            $table->json('peserta')->nullable();
            $table->longText('capture_image')->nullable(); // base64 string
            $table->timestamp('waktu_rapat')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('meeting_report_bidang4');
    }
};
