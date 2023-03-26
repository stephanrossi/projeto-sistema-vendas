<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Address;
use Exception;
use Illuminate\Http\Request;

class AddressesController extends Controller
{
    public function getAddress(Request $r)
    {
        try {
            $address = Address::getAddress($r->input('cep'));

            return $address;
        } catch (Exception $e) {
            exit($e->getMessage());
        }
    }
}
