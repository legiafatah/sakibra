<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hukuman extends Model
{
    protected $table = 'hukuman';

    protected $fillable = [
        'peserta_id', 'bukti_pelanggaran_id', 'nama', 'nilai', 'bukti',
    ];
    public $timestamps = false;
    public function peserta()
    {
        return $this->belongsTo(Peserta::class, 'peserta_id');
    }

    public function buktiPelanggaran()
    {
        return $this->belongsTo(BuktiPelanggaran::class, 'bukti_pelanggaran_id');
    }
}
