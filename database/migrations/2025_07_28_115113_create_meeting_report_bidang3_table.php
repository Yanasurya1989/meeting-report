<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMeetingReportBidang3Table extends Migration
{
    public function up()
    {
        Schema::create('meeting_report_bidang3', function (Blueprint $table) {
            $table->id();
            $table->text('notulen');
            $table->json('peserta')->nullable();
            $table->string('capture_image');
            $table->timestamp('waktu_rapat')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('meeting_report_bidang3');
    }
}
