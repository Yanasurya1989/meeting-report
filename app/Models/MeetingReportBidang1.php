<?php

// app/Models/MeetingReportBidang1.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MeetingReportBidang1 extends Model
{
    protected $table = 'meeting_report_bidang1';

    protected $fillable = [
        'notulen',
        'peserta',
        'waktu_rapat',
        'capture_image',
    ];

    protected $casts = [
        'peserta' => 'array',
        'waktu_rapat' => 'datetime',
    ];
}
