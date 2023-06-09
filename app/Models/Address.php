<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;
    protected $table = 'addresses';
    protected $fillable = ['cep', 'address', 'city', 'state', 'cod_ibge'];

    public function __construct()
    {
    }

    public function clients()
    {
        return $this->hasMany(Client::class);
    }
}
