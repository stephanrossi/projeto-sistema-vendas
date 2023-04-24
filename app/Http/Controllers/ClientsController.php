<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Helpers\CpfCnpjValidator as CpfCnpjValidator;
use App\Models\Client;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class ClientsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        try {
            $client = Client::all();

            return response()->json([
                'error' => false,
                'data' => $client
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
        $validator = Validator::make($r->all(), [
            "name"              => "required|string|max:255",
            "email"             => "required|email",
            "phone"             => "required|string",
            "cpf_cnpj"          => "string|unique:clients|nullable",
            "dt_birth"          => "date|nullable",
            "address_id"        => "integer|nullable",
            "address_number"    => "integer|nullable",
            "address_complement" => "string|nullable",
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'msg' => $validator->errors()->messages()
            ], 400);
        }

        $cpf_cnpj = preg_replace('/[^0-9]/', '', $r->input('cpf_cnpj'));

        if (strlen($cpf_cnpj) < 11 || strlen($cpf_cnpj) > 14) {
            return response()->json([
                'error' => true,
                'msg' => 'CPF ou CNPJ inválidos'
            ]);
        }

        if (strlen($cpf_cnpj) == 11) {
            if (!CpfCnpjValidator::validateCPF($cpf_cnpj)) {
                return response()->json([
                    'error' => true,
                    'msg' => 'CPF inválido.'
                ]);
            }
        }

        if (strlen($cpf_cnpj) == 14) {
            if (!CpfCnpjValidator::validateCNPJ($cpf_cnpj)) {
                return response()->json([
                    'error' => true,
                    'msg' => 'CNPJ inválido.'
                ]);
            }
        }

        $client = Client::create([
            'name' => $r->input('name'),
            'email' => $r->input('email'),
            'phone' => $r->input('phone'),
            'address_id' => $r->input('address_id'),
            'address_number' => $r->input('address_number'),
            'address_complement' => $r->input('address_complement'),
            'cpf_cnpj' => $cpf_cnpj,
            'dt_birth' => $r->input('dt_birth')
        ]);

        return response()->json([
            'error' => false,
            'data' => $client
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $r)
    {
        try {
            $client = Client::query()
                ->when(
                    $r->search,
                    function (Builder $b) use ($r) {
                        $b->where('cpf_cnpj', $r->search)
                            ->orWhere('email', $r->search)
                            ->orWhere('name', 'LIKE', "%{$r->search}%")
                            ->orWhere('phone', 'LIKE', "%{$r->search}%");
                    }
                )
                ->get();

            if (count($client) == 0) {
                return response()->json([
                    'error' => true,
                    'msg' => 'Cliente não encontrado.'
                ]);
            }

            return response()->json([
                'error' => false,
                'data' => $client
            ], 200);
        } catch (\Throwable $th) {
            throw $th->getMessage();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $r)
    {
        try {
            $id = $r->id;

            $client = Client::find($id);

            if (!$client) {
                return response()->json([
                    'error' => true,
                    'msg' => 'Cliente não encontrado.'
                ]);
            } else {
                return $client;
            }
        } catch (\Throwable $th) {
            throw $th->getMessage();
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $r, string $id)
    {
        try {
            $clientExists = Client::find($id);

            if (!$clientExists) {
                return response()->json([
                    'error' => true,
                    'msg' => 'Cliente não encontrado.'
                ]);
            }

            $client = Client::where('id', $id)
                ->update([
                    'name' => $r->name,
                    'cpf_cnpj' => $r->cpf_cnpj,
                    'email' => $r->email,
                    'phone' => $r->phone,
                    'address_id' => $r->address_id,
                    'address_number' => $r->address_number,
                    'dt_birth' => $r->dt_birth
                ]);

            if ($client !== 1) {
                return response()->json([
                    'error' => true,
                    'msg' => "Ocorreu um erro, confira os dados e tente novamente."
                ]);
            }

            return $client;
        } catch (Exception $e) {
            exit($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $client = Client::destroy($id);

            if (!$client) {
                return response()->json([
                    'error' => true,
                    'msg' => 'Cliente não encontrado.'
                ]);
            }

            if ($client !== 1) {
                return response()->json([
                    'error' => true,
                    'msg' => 'Ocorreu um erro, confira os dados e tente novamente.'
                ]);
            }

            return $client;
        } catch (Exception $e) {
            exit($e->getMessage());
        }
    }
}
