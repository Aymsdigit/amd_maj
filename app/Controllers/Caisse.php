<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\VenteModel;

class Caisse extends BaseController
{
    public function index()
    {
        //
    }

    function fetch_load()
    {
        $venteModel = new VenteModel();
        $vente = $venteModel->getAll();
        echo json_encode($vente);
    }
}