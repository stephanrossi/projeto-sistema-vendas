<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Response as FacadesResponse;

class Address extends Model
{
    use HasFactory;
    protected $table = 'addresses';
    protected $fillable = ['cep', 'address', 'city', 'state', 'cod_ibge'];

    public function clients()
    {
        return $this->hasMany(Client::class);
    }

    public static function getAddress($cep)
    {
        try {
            $cepFormatted = str_replace('-', '', $cep);

            if (strlen($cepFormatted) !== 8) {
                echo json_encode([
                    "error" => true,
                    "msg" => "CEP inválido"
                ]);
                exit();
            }

            $getAddress = DB::table('addresses')
                ->select('address', 'city', 'state')
                ->where('cep', $cepFormatted)
                ->get();

            if (count($getAddress) <= 0) {
                self::insertNewAddress($cep);
            } else {
                return $getAddress[0];
            }
        } catch (Exception $e) {
            exit($e->getMessage());
        }
    }

    private static function insertNewAddress($cep)
    {
        try {
            $response = Http::cep($cep);

            if (isset($response['erro'])) {
                echo json_encode([
                    "error" => true,
                    "msg" => "CEP não encontrado"
                ]);
                exit();
            } else {
                $cepFormatted = str_replace('-', '', $response['cep']);

                $newAddress = DB::selectOne("INSERT INTO addresses (cep, address, city, state, cod_ibge) VALUES (?,?,?,?,?) RETURNING address, city, state", [$cepFormatted, $response['logradouro'], $response['localidade'], $response['uf'], $response['ibge']]);

                $encodedAddress = json_encode($newAddress);

                echo $encodedAddress;
            }
        } catch (Exception $e) {
            exit($e->getMessage());
        }
    }
}
