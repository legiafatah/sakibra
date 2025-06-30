<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AksesJuri extends Model
{
    protected $table = 'akses_juri';

    protected $fillable = [
        'kategori_id',
        'juri_id',
    ];
    public $timestamps = false;

    public function juri()
    {
        return $this->belongsTo(Juri::class, 'juri_id');
    }
    
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

}
