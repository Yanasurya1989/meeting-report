<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMeetingReportSmpTable extends Migration
{
    public function up(): void
    {
        Schema::create('meeting_report_smp', function (Blueprint $table) {
            $table->id();
            $table->text('notulen');
            $table->json('peserta'); // karena multiple peserta (array)
            $table->longText('capture_image')->nullable(); // base64 string
            $table->dateTime('waktu_rapat');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('meeting_report_smp');
    }
}
