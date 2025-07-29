<?php

// database/migrations/xxxx_xx_xx_create_meeting_report_bidang1_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMeetingReportBidang1Table extends Migration
{
    public function up()
    {
        Schema::create('meeting_report_bidang1', function (Blueprint $table) {
            $table->id();
            $table->text('notulen');
            $table->json('peserta')->nullable();
            $table->timestamp('waktu_rapat')->nullable();
            $table->string('capture_image')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('meeting_report_bidang1');
    }
}
