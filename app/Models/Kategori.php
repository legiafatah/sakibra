<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = 'kategori';
    protected $fillable = ['admin_id' , 'nama'];
    
    public $timestamps = false;
    public function detailKategori()
    {
        return $this->hasMany(DetailKategori::class, 'kategori_id');
    }

        public function admin()
    {
        return $this->belongsTo(Juri::class, 'admin_id');
    }

    public function aksesjuri()
    {
        return $this->hasMany(AksesJuri::class, 'kategori_id'); // Sesuaikan nama kolom
    }

}
