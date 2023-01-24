<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ClientModel;

class Client extends BaseController
{
    public function index()
    {
        //
    }

    public function fetch_client()
    {
        $clientModel = new ClientModel();
        $client = $clientModel->findAll();
        echo json_encode($client);
    }
}