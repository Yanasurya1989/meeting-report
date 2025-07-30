<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MeetingReportSD extends Model
{
    protected $table = 'meeting_report_sd';

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
