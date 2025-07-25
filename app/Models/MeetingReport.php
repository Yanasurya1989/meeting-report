<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MeetingReport extends Model
{
    protected $fillable = ['notulen', 'peserta', 'waktu_rapat', 'capture_image'];
    protected $casts = [
        'peserta' => 'array',
        'waktu_rapat' => 'datetime',
    ];
}
