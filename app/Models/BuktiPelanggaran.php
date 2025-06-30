<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BuktiPelanggaran extends Model
{
    protected $table = 'bukti_pelanggaran';

    public $timestamps = false;

    protected $fillable = [
        'image',
        'waktu',
    ];

    public function hukuman()
    {
        return $this->hasMany(Hukuman::class, 'bukti_pelanggaran_id');
    }
    
}
