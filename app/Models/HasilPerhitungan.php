<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HasilPerhitungan extends Model
{
    use HasFactory;

    protected $table = 'hasil_perhitungan';

    protected $fillable = [
        'id_bayi',
        'gizi_baik',
        'gizi_cukup',
        'gizi_kurang',
        'z_score',
        'status',
    ];

    public function bayi()
    {
        return $this->belongsTo(DataBayi::class, 'id_bayi');
    }
}
