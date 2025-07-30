<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MeetingReportSmp extends Model
{
    protected $table = 'meeting_report_smp';

    protected $fillable = [
        'notulen',
        'peserta',
        'capture_image',
        'waktu_rapat',
    ];

    protected $casts = [
        'peserta' => 'array', // supaya otomatis decode JSON jadi array
        'waktu_rapat' => 'datetime',
    ];
}
