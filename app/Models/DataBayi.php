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
        'bb_tb',
        'tgl_penimbangan'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function penanganan()
    {
        return $this->hasOne(Penanganan::class, 'data_bayi_id');
    }

}
