<?php

// app/Models/MeetingReportBidang1.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MeetingManajemenLevel extends Model
{
    protected $table = 'meeting_manajemen_level';

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
