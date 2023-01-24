<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\VenteModel;

class Dashboard extends BaseController
{
    public function index()
    {
        echo ("this is a dashboard");
    }

    public function show_dashboard()
    {
        echo ("this show a dashboard");
    }
    public function best_article()
    {
        $venteModel = new VenteModel();
        $month = $this->request->getVar('month');
        $req_best_article = $venteModel->bestArticle($month);
        
        echo json_encode($req_best_article);
    }
    function best_client()
    {
        $venteModel = new VenteModel();
        $month = $this->request->getVar('month');
        $req_best_client = $venteModel->bestClient($month);
        
        echo json_encode($req_best_client);
    }
}