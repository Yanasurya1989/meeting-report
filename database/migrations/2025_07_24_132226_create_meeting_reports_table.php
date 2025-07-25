<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('meeting_reports', function (Blueprint $table) {
            $table->id();
            $table->text('notulen'); // isi notulen meeting
            $table->json('peserta'); // list peserta dan status hadir
            $table->timestamp('waktu_rapat'); // waktu dari capture foto
            $table->string('capture_image')->nullable(); // nama file capture
            $table->timestamps(); // created_at untuk tanggal input, updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('meeting_reports');
    }
};
