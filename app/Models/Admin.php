<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    protected $table = 'admin'; // bukan 'admins'
    public $timestamps = false;
    protected $fillable = [
        'superadmin_id', 'nama', 'jk', 'no_wa', 'username', 'password', 'status'
    ];
    // public $timestamps = false;

    public function superadmin()
    {
        return $this->belongsTo(Superadmin::class);
    }

    public function peserta()
    {
        return $this->hasMany(Peserta::class, 'admin_id');
    }

    public function juri()
    {
        return $this->hasMany(Juri::class, 'admin_id');
    }

        public function kategori()
    {
        return $this->hasMany(Kategori::class, 'admin_id');
    }
}

