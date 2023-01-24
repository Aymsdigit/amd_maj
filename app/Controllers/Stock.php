<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\StockModel;

class Stock extends BaseController
{
    public function index()
    {
        //
    }

    public function fetch_stock()
    {
        $stockModel = new StockModel();
        $stock = $stockModel->stock_info();
        foreach ($stock as $row) 
        {
            $output[] = array(
                'titre' => $row->titre,
                'seuil' => $row->seuil,
                'retour' => $row->qte_total_retour,
                'qte_total_entree' => $row->qte_total_entree,
                'qte_total_vente' => $row->qte_total_vente,
                'qte_total_perdue' => $row->qte_total_perdue,
                'restante' => $row->qte_total_entree - ($row->qte_total_perdue + $row->qte_total_vente + $row->qte_total_retour),
                'prixBase' => $row->prixBase,
                'mr' => $row->prixBase * ($row->qte_total_entree - ($row->qte_total_perdue + $row->qte_total_vente + $row->qte_total_retour)),
            );
        }
        echo json_encode($output);
    }
}