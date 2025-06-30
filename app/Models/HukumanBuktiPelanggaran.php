<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HukumanBuktiPelanggaran extends Model
{
    protected $table = 'hukuman_bukti_pelanggaran';

    protected $fillable = [
        'hukuman_id',
        'bukti_pelanggaran_id',
    ];

    public $timestamps = true;

    public function hukuman()
    {
        return $this->belongsTo(Hukuman::class);
    }

    public function buktiPelanggaran()
    {
        return $this->belongsTo(BuktiPelanggaran::class);
    }
}
