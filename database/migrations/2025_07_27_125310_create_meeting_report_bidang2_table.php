<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('meeting_report_bidang2', function (Blueprint $table) {
            $table->id();
            $table->string('judul')->nullable();
            $table->text('notulen');
            $table->text('peserta')->nullable(); // bisa digunakan untuk menyimpan array peserta
            $table->dateTime('waktu_rapat');
            $table->string('tempat')->nullable();
            $table->string('capture_image')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('meeting_report_bidang2');
    }
};
