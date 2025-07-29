<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MeetingReportBidang2 extends Model
{
    protected $table = 'meeting_report_bidang2';

    protected $fillable = [
        'judul',
        'notulen',
        'peserta',
        'waktu_rapat',
        'tempat',
        'capture_image',
    ];
}
