<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeetingPKS extends Model
{
    use HasFactory;

    protected $table = 'meeting_pks';

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
