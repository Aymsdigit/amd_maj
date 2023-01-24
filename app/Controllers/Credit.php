<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ClientModel;
use App\Models\CreditModel;

class Credit extends BaseController
{
    public function index()
    {
        //
    }
    public function fetch_credit()
    {
        $creditModel = new CreditModel();
        $clientModel = new ClientModel();
        $credit = $creditModel->getAll();
        foreach ($credit as $row) 
        {
            $client = $clientModel->where('id', $row->client_id)->first();
            $output[] = array(
                'nom_prenoms' => $client["nom_prenoms"],
                'date_insertion' => $row->date_credit,
                'id' => $row->credit_id,
                'reste' => $row->montant_credit - $row->montant_paie,
                'etat' => $row->etat,
                'credit' => $row->montant_credit,
                'client_id' => $row->client_id,
                
            );
        }
        echo json_encode($output);
    }
}