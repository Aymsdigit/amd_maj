<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ApprovisionnementModel;
use App\Models\ChangePrixModel;
use App\Models\CreditModel;
use App\Models\PerteModel;
use App\Models\StockModel;
use App\Models\VenteModel;

class Vente extends BaseController
{
    public function index()
    {
        //
    }

    public function fetch_vente()
    {
        $venteModel = new VenteModel();
        $vente = $venteModel->getAll();
        echo json_encode($vente);
    }

    function insert()
    {
        if ($this->request->getVar('action')) 
		{
			helper(['form', 'url']);
			$article_error = '';
			$quantite_error = '';
            $client_error = '';
            $prix_error = '';
            $type_error = '';
			$error = 'no';
			$success = 'no';
			$message='';
            
            $approvisionnementModel = new ApprovisionnementModel();
            $changeModel = new ChangePrixModel();
            $venteModel = new VenteModel();
            $perteModel = new PerteModel();
            $stockModel = new StockModel();

            $id_article = $this->request->getVar('article');
            $quantite = $this->request->getVar('quantite');
            $prix = $this->request->getVar('prix');
            $client = $this->request->getVar('client');
            $type = $this->request->getVar('type');

			$error = $this->validate([
				'article' => [
					'rules' => 'required',
					'errors' => [
					'required' => 'Veuillez choisir un article'
                ],
                ],
                'client' => [
					'rules' => 'required',
					'errors' => [
					'required' => 'Veuillez choisir un client'
                ],
                ],
                'type' => [
					'rules' => 'required',
					'errors' => [
					'required' => 'Veuillez choisir un type'
                ],
				],
				'quantite' => [
					'rules' => 'required|numeric|min_length[1]',
					'errors' => [
					'required' => 'Veuillez remplir ce champ',
					'numeric' => 'Veuillez entrer des nombres',
					'min_length' => 'Votre quantite minimum doit etre 1'
					],
				],
                'prix' => [
					'rules' => 'required|numeric|min_length[1]',
					'errors' => [
					'required' => 'Veuillez remplir ce champ',
					'numeric' => 'Veuillez entrer des nombres',
					'min_length' => 'Votre prix minimum doit etre 1'
					],
				]
			]);

			if (!$error)
			{
				$error = 'yes';
				$validation = \config\Services::validation();
				if ($validation->getError('article'))
				{
					$article_error = $validation->getError('article');
				}
				if ($validation->getError('quantite'))
				{
					$quantite_error = $validation->getError('quantite');
				}
                if ($validation->getError('prix'))
				{
					$prix_error = $validation->getError('prix');
				}
                if ($validation->getError('type'))
				{
					$type_error = $validation->getError('type');
				}
                if ($validation->getError('client'))
				{
					$client_error = $validation->getError('client');
				}
			}
			else
			{
				$success= 'yes';
				if ($this->request->getVar('action') == 'Add')
				{
					// déterminons le stock restant
                    $req_entree = $approvisionnementModel->select('SUM(qte) as qtyEntree')->where('id_article', $this->request->getVar('article'))->first();
                    $req_perte = $perteModel->select('SUM(qte) as qtyPerdue')->where('id_article', $this->request->getVar('article'))->first();
                    $req_vente = $venteModel->select('SUM(qte) as qtyVendue')->where('id_article', $this->request->getVar('article'))->first();
                    $qtyVendue = $req_vente['qtyVendue'];
                    $qtyPerdue = $req_perte['qtyPerdue'];
                    $qtyEntree = $req_entree['qtyEntree'];
                    // Quantité totale stock restant
                    $stockRestant = $qtyEntree - ($qtyPerdue + $qtyVendue);

                    // Récuperons le prix de base stocké
                    $base_price = $changeModel->where('id_article', $id_article)->first();
                    $pb= $base_price["prix"]; 
                    $mb = $quantite * $pb;
                    if ($stockRestant >= $quantite) 
                    {
                        $data_a_inserer = [
                            'id_client' => $client,
                            'id_article' => $id_article,
                            'qte' => $quantite,
                            'prix' => $prix,
                            'prix_entree' => $pb,
                            'type_vente' => $type,
                            
                        ];
                        $venteModel->insert($data_a_inserer);
                        
                        $last_event = $venteModel->last_event();
                        foreach ($last_event as $value) 
                        {
                            # code...
                        }
                        
                        if ($type == "credit")
                        {
                            $creditModel = new CreditModel();
                            $data_insert = [
                                'id_vente' => $value->id,
                                'id_client' => $client,
                                'montant' => $quantite * $prix,
                                'etat' => 'pending',
                                
                            ];
                            $creditModel->insert($data_insert);
                        }

                        $message = '<div class="alert alert-success">Vente effectuée avec succès !!</div>';
                    }
                    else
                    {
                        $message = '<div class="alert alert-warning">La quantité disponible : '.$stockRestant.' est insuffisante pour cette vente!!<br/> Voulez vous vous <a href="approvisionnement">réapprovisionner</a> ??</div>';
                    }
                    					
				}

				// Mettre à jour
				if ($this->request->getVar('action') == 'Edit')
				{
                    $id = $this->request->getVar('hidden_id');
					$venteModel = new VenteModel();
                    $creditModel = new CreditModel();
                    $approvisionnementModel = new ApprovisionnementModel();
                    
                    // déterminons le stock restant
                    $req_entree = $approvisionnementModel->select('SUM(qte) as qtyEntree')->where('id_article', $this->request->getVar('article'))->first();
                    $req_perte = $perteModel->select('SUM(qte) as qtyPerdue')->where('id_article', $this->request->getVar('article'))->first();
                    $req_vente = $venteModel->select('SUM(qte) as qtyVendue')->where('id_article', $this->request->getVar('article'))->first();
                    $qtyVendue = $req_vente['qtyVendue'];
                    $qtyPerdue = $req_perte['qtyPerdue'];
                    $qtyEntree = $req_entree['qtyEntree'];
                    // Quantité totale stock restant
                    $stockRestant = $qtyEntree - ($qtyPerdue + $qtyVendue);
                    // Récuperons le prix de base stocké
                    $base_price = $changeModel->where('id_article', $id_article)->first();
                    $pb= $base_price["prix"]; 
                    

                    if ($stockRestant >= $quantite) 
                    {
                        $data = [
                            'id_client' => $client,
                            'id_article' => $id_article,
                            'qte' => $quantite,
                            'prix' => $prix,
                            'prix_entree' => $pb,
                            'type_entree' => $type,
                            'date_modification' => date('Y-m-d'),
                        ];
                        
                        $venteModel->update($id, $data);
                        $req_credit = $creditModel->where('id_vente', $id)->first();
                        if ($type == "credit")
                        {
                            $creditModel = new CreditModel();

                            // Vérifions s'il y a déjà une entree
                            // Si oui on la modifie sinon on l'enregistre

                            $credit_existe = $creditModel->where('id_vente', $id)->countAllResults();

                            if ($credit_existe == 1)
                            {
                                $data_modif = [
                                    'id_client' => $client,
                                    'montant' => $quantite * $prix,
                                    'date_modification' => date('Y-m-d')
                                    
                                ];
                                $creditModel->update($req_credit["id"], $data_modif);
                            }
                            else
                            {
                                // On va enregistrer
                                $data_ins = [
                                    'id_vente' => $id,
                                    'id_client' => $client,
                                    'montant' => $quantite * $prix,
                                    'etat' => 'pending',
                                    'date_insertion' => date('Y-m-d'),
                                    
                                ];
                                $creditModel->insert($data_ins);
                            }

                        }
                        else
                        {
                            $creditModel->where('id', $req_credit["id"])->delete($req_credit["id"]);
                        }

                        $message = '<div class="alert alert-info">vente modifiée</div>';
                    }
                    else
                    {
                        $message = '<div class="alert alert-warning">La quantité disponible : '.$stockRestant.' est insuffisante pour cette vente!!<br/> Voulez vous vous <a href="approvisionnement">réapprovisionner</a> ??</div>';
                    }
				}
			}

			$output = array(
				'article_error' => $article_error,
                'prix_error' => $prix_error,
                'type_error' => $type_error,
                'client_error' => $client_error,
				'quantite_error' => $quantite_error,
				'success' => $success,
				'error' => $error,
				'message' => $message
			);

			echo json_encode($output);
		}
    }

    function delete()
    {
        if ($this->request->getVar('id'))
        {
            $id = $this->request->getVar('id');
            $venteModel = new VenteModel();
            $creditModel = new CreditModel();

            $req_credit = $creditModel->where('id_vente', $id)->first();
            $venteModel->where('id', $id)->delete($id);
            $creditModel->where('id', $req_credit["id"])->delete($req_credit["id"]);

            echo json_encode('<div class="alert alert-danger">Perte supprimée</div>');
        }
    }

    function show()
    {
        if ($this->request->getVar('id'))
        {
            $venteModel = new VenteModel();

            $vente_data = $venteModel->where('id', $this->request->getVar('id'))->first();

            echo json_encode($vente_data);
        }
    }
}