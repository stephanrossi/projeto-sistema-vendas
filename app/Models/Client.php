<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\TryCatch;

class Client extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'email', 'phone', 'address_id', 'address_number', 'address_complement'];
    protected $table = 'clients';

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public static function listClients()
    {
        try {
            $clients = DB::table('clients')
                ->get();

            return $clients;
        } catch (Exception $e) {
            exit($e->getMessage());
        }
    }

    public static function findClient($cpf)
    {
        try {
            $client = DB::table('clients')
                ->select('name', 'email', 'phone', 'cpf', 'dt_birth', 'address_id', 'address_number', 'adress_complement')
                ->where('cpf', $cpf)
                ->get();

            if (count($client) == 0) {
                return response()->json([], 204);
            } else {
                return $client[0];
            }
        } catch (Exception $e) {
            exit($e->getMessage());
        }
    }

    public static function getClient($id)
    {
        try {
            $client = DB::table('clients')
                ->select('name', 'email', 'phone', 'cpf', 'dt_birth', 'address_id', 'address_number', 'address_complement')
                ->where('id', $id)
                ->get();
            if (count($client) == 0) {
                return response()->json([], 204);
            } else {
                return $client[0];
            }
        } catch (Exception $e) {
            exit($e->getMessage());
        }
    }

    public static function editClient($clientId, $inputs)
    {
        try {
            extract($inputs);

            $client = DB::table('clients')
                ->where('id', $clientId)
                ->update([
                    'name' => $name,
                    'email' => $email,
                    'phone' => $phone,
                    'cpf' => $cpf,
                    'dt_birth' => $dt_birth,
                    'address_id' => $address_id,
                    'address_number' => $address_number,
                    'address_complement' => $address_complement
                ]);
            return $client;
        } catch (Exception $e) {
            exit($e->getMessage());
        }
    }
}
