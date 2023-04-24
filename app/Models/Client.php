<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
