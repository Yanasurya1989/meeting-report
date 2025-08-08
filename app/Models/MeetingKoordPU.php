<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeetingKoordPU extends Model
{
    use HasFactory;

    protected $table = 'meeting_koord_pu';

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
