<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Client;
use Exception;
use Illuminate\Http\Request;

class ClientsController extends Controller
{

    public function listClients()
    {
        try {
            $clients = Client::listClients();
            return $clients;
        } catch (Exception $e) {
            exit($e->getMessage());
        }
    }

    public function findClient(Request $r)
    {
        try {
            $client = Client::findClient($r->input('cpf'));
            return $client;
        } catch (Exception $e) {
            exit($e->getMessage());
        }
    }

    public function getClient(Request $r)
    {
        try {
            $client = Client::getClient($r->id);
            return $client;
        } catch (Exception $e) {
            exit($e->getMessage());
        }
    }

    public function editClient(Request $r)
    {
        try {
            $clientId = $r->id;

            $inputs = $r->only('name', 'email', 'phone', 'cpf', 'dt_birth', 'address_id', 'address_number', 'address_complement');

            $client = Client::editClient($clientId, $inputs);

            return $client;
        } catch (Exception $e) {
            exit($e->getMessage());
        }
    }
}
