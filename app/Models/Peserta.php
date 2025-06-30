<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Peserta extends Authenticatable
{
    protected $table = 'peserta';

    protected $fillable = [
        'admin_id',
        'kategori',
        'no_peserta',
        'nama',
        'kode',
        'status',
        'date',
    ];

    public $timestamps = false;
    protected $casts = [
            'status' => 'boolean',
    ];

    // Relasi ke admin (jika diperlukan)
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
    public function hasilPenilaian()
    {
        return $this->hasMany(HasilPenilaian::class, 'peserta_id');
    }
    
    public function hukuman()
    {
        return $this->hasMany(Hukuman::class, 'peserta_id');
    }
    

}
