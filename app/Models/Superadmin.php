<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Superadmin extends Authenticatable
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'superadmin';

    protected $fillable = [
        'nama', 'jk', 'no_wa', 'username', 'password', 'status'
    ];

    protected $hidden = [
        'password',
    ];

    public function admins()
{
    return $this->hasMany(Admin::class);
}
}

