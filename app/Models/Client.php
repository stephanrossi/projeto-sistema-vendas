<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Client extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'email', 'phone', 'address_id', 'address_number', 'address_complement', 'cpf_cnpj', 'dt_birth'];
    protected $table = 'clients';

    public function address()
    {
        return $this->belongsTo(Address::class);
    }
}
