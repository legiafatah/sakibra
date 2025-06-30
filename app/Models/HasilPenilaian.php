<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilPenilaian extends Model
{
    use HasFactory;

    protected $table = 'hasil_penilaian';

    protected $fillable = [
        'juri_id',
        'peserta_id',
        'detail_kategori_id',
        'peringkat_id',
        'nilai',
        'status'
    ];

    // Relasi ke model Juri
    public function juri()
    {
        return $this->belongsTo(Juri::class);
    }

    // Relasi ke model Peserta
    public function peserta()
    {
        return $this->belongsTo(Peserta::class);
    }

    // Relasi ke model DetailKategori
    public function detailKategori()
    {
        return $this->belongsTo(DetailKategori::class);
    }

    public $timestamps = false; 

    public function peringkat()
    {
        return $this->belongsTo(Peringkat::class);
    }

    public function kategori()
    {
        return $this->belongsTo(DetailKategori::class, 'detail_kategori_id')
                    ->with('kategori'); // Eager load relasi kategori
    }

}
