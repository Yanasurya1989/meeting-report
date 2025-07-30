<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MeetingReportSma extends Model
{
    protected $table = 'meeting_report_sma';

    protected $fillable = [
        'notulen',
        'peserta',
        'capture_image',
        'waktu_rapat',
    ];

    protected $casts = [
        'peserta' => 'array',        // otomatis diconvert dari/ke array JSON
        'waktu_rapat' => 'datetime', // supaya bisa format pakai ->format() di view
    ];
}
