<?php

namespace App\Models;

use Exception;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class User extends Model
{
    use HasFactory, HasApiTokens;
    protected $table = 'users';
    protected $fillable = ['name', 'email', 'password', 'permissions', 'username', 'api_token'];
    protected $hidden = ['password'];

    public function sellings()
    {
        return $this->hasMany(Sale::class);
    }

    public static function createUser($data)
    {
        try {
            extract($data);

            $user = DB::table('users')
                ->insert([
                    'name' => $name,
                    'email' => $email,
                    'password' => Hash::make($password),
                    'permissions' => $permissions,
                    'username' => $permissions,
                    'api_token' => Str::random(60)
                ]);
        } catch (Exception $e) {
            exit($e->getMessage());
        }
    }
}
