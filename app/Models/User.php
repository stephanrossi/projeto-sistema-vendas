<?php

namespace App\Models;

use Exception;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, HasApiTokens, Notifiable;
    protected $table = 'users';
    protected $fillable = ['name', 'email', 'password', 'permissions', 'username', 'api_token'];
    protected $hidden = ['password'];

    public function sellings()
    {
        return $this->hasMany(Sale::class);
    }
}
