<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $products = Product::all();

            return response([
                'error' => false,
                'data' => $products
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
            $data = $r->all();

            $product = Product::create($data);

            return response([
                'error' => false,
                'data' => $product
            ]);
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
            $product = Product::find($id);

            if (!$product) {
                return response([
                    'error' => true,
                    'msg' => 'Produto não encontrado.'
                ]);
            }

            return $product;
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
    public function update(Request $r, string $id)
    {
        try {
            $product = Product::find($id);

            if (!$product) {
                return response([
                    'error' => true,
                    'msg' => 'Produto não encontrado.'
                ]);
            }

            $product->name = $r->name;
            $product->description = $r->description;
            $product->category_id = $r->category_id;
            $product->quantity_type_id;
            $product->sell_price = $r->sell_price;
            $product->manufacturer_id = $r->manufacturer_id;
            $product->save();

            return response([
                'error' => false,
                'data' => $product
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
        //
    }
}
