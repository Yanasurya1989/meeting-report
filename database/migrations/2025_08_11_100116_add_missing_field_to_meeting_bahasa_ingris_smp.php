<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('meeting_bahasa_ingris_smp', function (Blueprint $table) {
            $table->text('notulen')->after('id');
            $table->json('peserta')->after('notulen');
            $table->longText('capture_image')->after('peserta');
            $table->dateTime('waktu_rapat')->after('capture_image');
        });
    }

    public function down(): void
    {
        Schema::table('meeting_bahasa_ingris_smp', function (Blueprint $table) {
            $table->dropColumn(['notulen', 'peserta', 'capture_image', 'waktu_rapat']);
        });
    }
};
