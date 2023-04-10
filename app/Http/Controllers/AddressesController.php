<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Address;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class AddressesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $address = Address::all();

            return response()->json([
                'error' => false,
                'data' => $address
            ]);
        } catch (\Throwable $th) {
            exit($th->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $r)
    {
        try {
            $cepFormatted = preg_replace('/[^0-9]/', '', $r->cep);

            if (strlen($cepFormatted) != 8) {
                return response()->json([
                    'error' => true,
                    'msg' => 'CEP inválido.'
                ]);
                exit();
            }

            $response = Http::cep($cepFormatted);

            if (isset($response['erro'])) {
                return response()->json([
                    "error" => true,
                    "msg" => "CEP inválido"
                ]);
                exit();
            }

            $address = Address::create([
                'cep' => $cepFormatted,
                'address' => $response['logradouro'],
                'city' => $response['localidade'],
                'state' => $response['uf'],
                'cod_ibge' => $response['ibge']
            ]);

            return response()->json([
                'error' => false,
                'data' => $address
            ], 201);
        } catch (Exception $e) {
            exit($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $r)
    {
        try {
            $cepFormatted = preg_replace('/[^0-9]/', '', $r->query('cep'));

            if (strlen($cepFormatted) !== 8) {
                return response()->json([
                    "error" => true,
                    "msg" => "CEP inválido"
                ]);
                exit();
            }
            $address = Address::firstWhere('cep', $cepFormatted);

            if (empty($address)) {
                return response()->json([
                    'error' => true,
                    'msg' => 'CEP não encontrado.'
                ]);
            } else {
                return $address;
            }
        } catch (Exception $e) {
            exit($e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
