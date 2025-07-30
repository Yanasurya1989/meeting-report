<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMeetingReportSmaTable extends Migration
{
    public function up()
    {
        Schema::create('meeting_report_sma', function (Blueprint $table) {
            $table->id();
            $table->text('notulen');
            $table->json('peserta'); // karena checkbox bisa lebih dari 1
            $table->longText('capture_image')->nullable(); // base64 image
            $table->timestamp('waktu_rapat');
            $table->timestamps(); // created_at dan updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('meeting_report_sma');
    }
}
