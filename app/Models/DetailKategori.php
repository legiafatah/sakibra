<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailKategori extends Model
{
    protected $table = 'detail_kategori';
    protected $fillable = ['kategori_id', 'nama'];
    public $timestamps = false;
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }
}
