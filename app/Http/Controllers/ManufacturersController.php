<?php

namespace App\Http\Controllers;

use App\Models\Manufacturer;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Client\ResponseSequence;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;

class ManufacturersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $manufacturer = Manufacturer::all();

            if (!$manufacturer) {
                return response()->json([
                    'error' => true,
                    'msg' => 'Um erro ocorreu. Tente novamente.'
                ]);
            }

            if (count($manufacturer) == 0) {
                return response()->json([
                    'error' => false,
                    'data' => 'Nenhum fabricante encontrado.'
                ]);
            }

            return response([
                'error' => false,
                'data' => $manufacturer
            ]);
        } catch (Exception $e) {
            exit($e->getMessage());
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
            $name = $r->only('name');

            $manufacturer = Manufacturer::create($name);

            if (!$manufacturer) {
                return response([
                    'error' => true,
                    'msg' => 'Um erro ocorreu. Tente novamente.'
                ], 500);
            }

            return response([
                'error' => false,
                'data' => $manufacturer
            ], 201);
        } catch (Exception $e) {
            exit($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $manufacturer = Manufacturer::find($id);

            if (!$manufacturer) {
                return response([
                    'error' => true,
                    'msg' => 'Fabricante não encontrado.'
                ]);
            }

            return response([
                'error' => false,
                'data' => $manufacturer
            ]);
        } catch (Exception $e) {
            exit($e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $r)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $r, string $id)
    {
        try {
            $manufacturer = Manufacturer::find($id);

            if (!$manufacturer) {
                return response()->json([
                    'error' => true,
                    'msg' => 'Fabricante não encontrado.'
                ]);
            }

            $manufacturer->name = $r->name;
            $manufacturer->save();

            return response()->json([
                'error' => false,
                'data' => $manufacturer
            ]);
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
            $manufacturer = Manufacturer::find($id);

            if (!$manufacturer) {
                return response()->json([
                    'error' => true,
                    'msg' => 'Fabricante não encontrado.'
                ]);
            }

            Manufacturer::destroy($id);
        } catch (Exception $e) {
            exit($e->getMessage());
        }
    }
}
