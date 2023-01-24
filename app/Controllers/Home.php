<?php

namespace App\Controllers;

use App\Models\ArticleModel;
use App\Models\CategorieModel;
use App\Models\CreditModel;
use App\Models\VenteModel;

class Home extends BaseController
{
    
    public function index()
    {
        $categorieModel = new CategorieModel();
        $articleModel = new ArticleModel();
        $today = date('Y-m-d');
        
        $data = [
            // categories operations
            'allCategories' => $categorieModel->countAllResults(),
            'todayCategories' => $categorieModel->where('date_insertion', $today)->countAllResults(),
            // Articles Operations
            'allArticles' => $articleModel->countAllResults(),
            'todayArticles' => $articleModel->where('date_insertion', $today)->countAllResults(),
            
			'title' => "Tableau de bord",
            'subtitle'=> ''
		];
        return view('dashboard', $data);
    }
    
    function category()
    {
        $data = [
			'title' => "categorie",
            'subtitle'=> ''
		];
        return view('categorie', $data);
    }

    function article()
    {
        $data = [
			'title' => "article",
            'subtitle'=> ''
		];
        return view('article', $data);
    }

    function fournisseur()
    {
        $data = [
			'title' => "fournisseur",
            'subtitle'=> ''
		];
        return view('fournisseur', $data);
    }

    function perte()
    {
        $data = [
			'title' => "perte",
            'subtitle'=> ''
		];
        return view('perte', $data);
    }
    
    function approvisionnement()
    {
        $data = [
			'title' => "approvisionnement",
            'subtitle'=> ''
		];
        return view('approvisionnement', $data);
    }

    function charge()
    {
        $data = [
			'title' => "charge",
            'subtitle'=> ''
		];
        return view('charge', $data);
    }

    function versement()
    {
        $data = [
			'title' => "versement",
            'subtitle'=> ''
		];
        return view('versement', $data);
    }

    function retour()
    {
        $data = [
			'title' => "retour",
            'subtitle'=> ''
		];
        return view('retour', $data);
    }

    function stock()
    {
        $data = [
			'title' => "stock",
            'subtitle'=> ''
		];
        return view('stock', $data);
    }

    function caisse()
    {
        $data = [
			'title' => "caisse",
            'subtitle'=> ''
		];
        return view('caisse', $data);
    }

    function credit()
    {
        $data = [
			'title' => "credit",
            'subtitle'=> ''
		];
        return view('credit', $data);
    }

    function vente()
    {
        $venteModel = new VenteModel();
        $data = [
			'title' => "vente",
            'subtitle'=> '',
            'vente_mois' => $venteModel->select('*, SUM(prix) as prix_total')->orderBy('id', 'desc')->limit(3)->groupBy('date_insertion')->get(),
		];
        return view('vente', $data);
    }

    
}