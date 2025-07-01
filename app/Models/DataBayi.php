<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DataBayi extends Model
{
    use HasFactory;

    protected $table = 'data_bayi';

    protected $fillable = [
        'id_user',
        'nama',
        'umur',
        'jenis_kelamin',
        'berat',
        'tinggi',
        'lila',
        'bb_tb'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function hasilPerhitungan()
    {
        return $this->hasOne(HasilPerhitungan::class, 'id_bayi');
    }
}
