<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JadwalPenimbangan extends Model
{
    use HasFactory;

    protected $table = 'jadwal_penimbangan';

    protected $fillable = [
        'bulan',
        'lokasi_posyandu',
        'tanggal_penimbangan',
        'waktu',
        'keterangan',
    ];
}
