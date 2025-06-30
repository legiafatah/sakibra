<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peringkat extends Model
{

    protected $table = 'peringkat';

    protected $fillable = [
        'nama', // atau kolom lainnya sesuai struktur tabel peringkat kamu
    ];

    public $timestamps = false;

    public function hasilPenilaian()
    {
        return $this->hasMany(HasilPenilaian::class);
    }
}
