<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MeetingReportBidang3 extends Model
{
    protected $table = 'meeting_report_bidang3';

    protected $fillable = [
        'notulen',
        'peserta',
        'capture_image',
        'waktu_rapat',
    ];

    protected $casts = [
        'peserta' => 'array',
        'waktu_rapat' => 'datetime',
    ];
}
