<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penanganan extends Model
{
    protected $table = 'penanganan';

    protected $fillable = [
        'data_bayi_id',
        'keterangan',
    ];

    public function bayi()
    {
        return $this->belongsTo(DataBayi::class, 'data_bayi_id');
    }
}
