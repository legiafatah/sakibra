<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Juri extends Authenticatable

{
        use HasFactory;
    
        protected $table = 'juri';
        public $timestamps = false;
        protected $fillable = [
            'admin_id',
            'nama',
            'jk',
            'username',
            'password',
            'status',
        ];
        protected $hidden = ['password'];
        protected $casts = [
            'status' => 'boolean',
        ];


        public function aksesjuri()
        {
            return $this->hasMany(AksesJuri::class, 'juri_id'); // Sesuaikan nama kolom
        }

        public function admin()
        {
            return $this->belongsTo(Admin::class);
        }
}



