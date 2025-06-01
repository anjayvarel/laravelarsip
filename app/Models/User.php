<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasFactory, HasRoles;

    protected $table = 'users';

    protected $fillable = [
        'nama', 
        'nip',
        'password',
        'role',
        'remember_token'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Otomatis mengenkripsi password sebelum disimpan ke database
    public function setPasswordAttribute($value)
    {
        if ($value) { // Pastikan password tidak kosong
            $this->attributes['password'] = Hash::make($value);
        }
    }

    public function username()
    {
        return 'nip';
    }
}
