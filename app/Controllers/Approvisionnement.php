<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ApprChangeModel;
use App\Models\ApprovisionnementModel;
use App\Models\ChangePrixModel;
use App\Models\PerteModel;
use App\Models\StockModel;
use App\Models\SupplyModel;
use App\Models\VenteModel;

class Approvisionnement extends BaseController
{
    public function index()
    {
        //
    }
    public function fetch_approvisionnement()
    {
        $approvisionnementModel = new ApprovisionnementModel();
        $approvisionnement = $approvisionnementModel->getAll();
        echo json_encode($approvisionnement);
    }

    function fetch_global()
    {
        $approvisionnementModel = new ApprovisionnementModel();
        $approvisionnement = $approvisionnementModel->getglobal();
        echo json_encode($approvisionnement);
    }
    
    function insert()
    {
        if ($this->request->getVar('action')) 
		{
            helper(['form', 'url']);
			$article_error = '';
			$fournisseur_error = '';
			$quantite_error = '';
            $prix_error = '';
			$error = 'no';
			$success = 'no';
			$message='';

            $error = $this->validate([
				'article' => [
					'rules' => 'required',
					'errors' => [
					'required' => 'Veuillez choisir un article'
					],
				],
				'quantite' => [
					'rules' => 'required|numeric|min_length[1]',
					'errors' => [
					'required' => 'Veuillez remplir ce champ',
					'numeric' => 'Veuillez entrer des nombres',
					'min_length' => 'Votre minimum doit etre 1'
					],
				],
                'prix' => [
					'rules' => 'required|numeric|min_length[1]',
					'errors' => [
					'required' => 'Veuillez remplir ce champ',
					'numeric' => 'Veuillez entrer des nombres',
					'min_length' => 'Votre minimum doit etre 1'
					],
				],
				'fournisseur' => [
					'rules' => 'required',
					'errors' => [
					'required' => 'Veuillez choisir un fournisseur',
					],
				],
			]);

            if (!$error)
			{
				$error = 'yes';
				$validation = \config\Services::validation();
				if ($validation->getError('article'))
				{
					$article_error = $validation->getError('article');
				}
				if ($validation->getError('fournisseur'))
				{
					$fournisseur_error = $validation->getError('fournisseur');
				}
				if ($validation->getError('quantite'))
				{
					$quantite_error = $validation->getError('quantite');
				}
                if ($validation->getError('prix'))
				{
					$prix_error = $validation->getError('prix');
				}
			}
			else
			{
                $approvisionnementModel = new ApprovisionnementModel();
                $changeModel = new ChangePrixModel();
                $venteModel = new VenteModel();
                $perteModel = new PerteModel();
                $stockModel = new StockModel();
                $id_article = $this->request->getVar('article');
                $success= 'yes';
				if ($this->request->getVar('action') == 'Add')
				{
					
                    // Vérifions s'il y a déjà un approvisionnement
                    $approExist = $approvisionnementModel->where('id_article', $id_article)->countAllResults();

                    if ($approExist == 0) 
                    {
                        // Insertion de l'approvisionnement ainsi que son prix
                        $approvisionnementModel->save([
                            'id_fournisseur' => $this->request->getVar('fournisseur'),
                            'id_article' => $this->request->getVar('article'),
                            'qte' => $this->request->getVar('quantite'),
                            'prix' =>  $this->request->getVar('prix'),
                        ]);

                        $changeModel->save([
                            'id_article' => $this->request->getVar('article'),
                            'prix' =>  $this->request->getVar('prix'),
                            
                        ]);
    
                        $message = '<div class="alert alert-success">Approvisionnement effectué</div>';
                    }
                    else
                    {
                        // Remarque il y a déjà un approvisionnement
                        // Vérifions s'il n' y a pas déjà eu de vente ni de perte sur cet article

                        $venteExist = $venteModel->where('id_article', $this->request->getVar('article'))->countAllResults();
                        $perteExist = $perteModel->where('id_article', $this->request->getVar('article'))->countAllResults();

                        if ($venteExist == 0 && $perteExist == 0) 
                        {
                            // S'il n' y a pas eu de vente ni de perte
                            $approvisionnementModel->save([
                                'id_fournisseur' => $this->request->getVar('fournisseur'),
                                'id_article' => $this->request->getVar('article'),
                                'qte' => $this->request->getVar('quantite'),
                                'prix' =>  $this->request->getVar('prix'),
                            ]);

                            // Verifions et recuperons le prix de base
                            $req_prixBase = $approvisionnementModel->select('SUM(qte) as qte_total, SUM(qte * prix)/SUM(qte) as prixGlobal')->where('id_article', $this->request->getVar('article'))->groupBy('id_article')->findAll();
                            $prixBase = $req_prixBase[0]["prixGlobal"];

                            // Récuperons l'id du changement de prix en fonction de l'article
                            $req_id = $changeModel->where('id_article', $this->request->getVar('article'))->first();

                            // Ainsi mettons à jour le prix de base de new_appro change
                            $data = [
                                'prix' => $prixBase,
                                'date_modification' => date('Y-m-d')
                            ];
                            $changeModel->update($req_id["id"], $data);
                            
                            $message = '<div class="alert alert-success">Entrée effectuée avec succès!!</div>';
                            
                        }
                        else
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
                            // récuperons le prix de base stocké
                            $basePrice = $changeModel->where('id_article', $this->request->getVar('article'))->first();

                            $montantRestant = $stockRestant * $basePrice['prix'];

                            // Article en cours nouveau montant
                            $newMontant = $this->request->getVar('quantite') * $this->request->getVar('prix');
                            // Nouveau prix de base
                            $newBasePrice = ($montantRestant + $newMontant)/($stockRestant + $this->request->getVar('quantite'));

                            $approvisionnementModel->save([
                                'id_fournisseur' => $this->request->getVar('fournisseur'),
                                'id_article' => $this->request->getVar('article'),
                                'qte' => $this->request->getVar('quantite'),
                                'prix' =>  $this->request->getVar('prix'),
                            ]);

                            // Ainsi mettons à jour le prix de base de new_appro change
                            $data = [
                                'prix' => $newBasePrice,
                                'date_modification' => date('Y-m-d')
                            ];
                            $changeModel->update($basePrice["id"], $data);
                            
                            $message = '<div class="alert alert-success">Entrée effectuée avec succès!!</div>';

                        }
                    }
					
				}

                // Mettre à jour
				if ($this->request->getVar('action') == 'Edit')
				{
					$id = $this->request->getVar('hidden_id');

                    // Récuperons les infos de cet approvisionnement
                    $appro_info = $approvisionnementModel->where('id', $id)->first();
                    $id_article = $appro_info["id_article"];
                    $pb = $appro_info["prix"];
		            $qte_prec = $appro_info["qte"];

                    // déterminons le stock restant
                    // déterminons le stock restant
                    $req_entree = $approvisionnementModel->select('SUM(qte) as qtyEntree')->where('id_article', $id_article)->first();
                    $req_perte = $perteModel->select('SUM(qte) as qtyPerdue')->where('id_article', $id_article)->first();
                    $req_vente = $venteModel->select('SUM(qte) as qtyVendue')->where('id_article', $id_article)->first();
                    $qtyVendue = $req_vente['qtyVendue'];
                    $qtyPerdue = $req_perte['qtyPerdue'];
                    $qtyEntree = $req_entree['qtyEntree'];
                    
                    $stockRestant = $qtyEntree - ($qtyPerdue + $qtyVendue);
                    // le nouveau stock restant sans la qte de cet approvisionnement
		            $newStockRestant = $stockRestant - $qte_prec;

                    // Récuperons le prix de base stocké
                    $basePrice = $changeModel->where('id_article', $id_article)->first();
                    
                    if ($newStockRestant == 0) 
                    {
                        $recup_prec_price = 0;
                        $new_base_price = (($recup_prec_price * $newStockRestant) + ($this->request->getVar('quantite') * $this->request->getVar('prix')))/($newStockRestant + $this->request->getVar('quantite'));
                    }
                    else
                    {
                        $recup_prec_price = (($stockRestant * $basePrice["prix"]) - ($qte_prec * $pb))/$newStockRestant;

                        $new_base_price = (($recup_prec_price * $newStockRestant) + ($this->request->getVar('quantite') * $this->request->getVar('prix')))/($newStockRestant + $this->request->getVar('quantite'));
                    }
                    
                    // Ainsi mettons à jour la table approvisionnement et le prix de base de new_appro change

                    $data_appro = [
                        'id_fournisseur' => $this->request->getVar('fournisseur'),
                        'id_article' => $this->request->getVar('article'),
                        'qte' => $this->request->getVar('quantite'),
                        'prix' =>  $this->request->getVar('prix'),
                        'date_modification' => date('Y-m-d')
                    ];

                    $approvisionnementModel->update($id, $data_appro);
                    // Récuperons l'id du changement de prix en fonction de l'article
                    $req_id = $changeModel->where('id_article', $id_article)->first();
                    $data_change = [
                        'prix' => $new_base_price,
                        'date_modification' => date('Y-m-d')
                    ];
                    $changeModel->update($req_id['id'], $data_change);

                    $message = '<div class="alert alert-info">Modification éffectuée '.$new_base_price.'</div>';
				
                }
                
				
			}

			$output = array(
				'article_error' => $article_error,
				'quantite_error' => $quantite_error,
				'fournisseur_error' => $fournisseur_error,
                'prix_error' => $prix_error,
				'success' => $success,
				'error' => $error,
				'message' => $message,
			);

            echo json_encode($output);
            
        }
    }

    public function show()
    {
        if ($this->request->getVar('id'))
        {
            $approvisionnementModel = new ApprovisionnementModel();

            $approvisionnement_data = $approvisionnementModel->where('id', $this->request->getVar('id'))->first();

            echo json_encode($approvisionnement_data);
        }
    }

    function delete()
    {
        if ($this->request->getVar('id'))
        {
            $approvisionnementModel = new ApprovisionnementModel();
                $changeModel = new ChangePrixModel();
                $venteModel = new VenteModel();
                $perteModel = new PerteModel();
                $stockModel = new StockModel();

            $id = $this->request->getVar('id');

            // Récuperons les infos de cet approvisionnement
            $appro_info = $approvisionnementModel->where('id', $id)->first();
            $id_article = $appro_info["id_article"];
            $pb = $appro_info["prix"];
            $qte_prec = $appro_info["qte"];

            // déterminons le stock restant
            $req_entree = $approvisionnementModel->select('SUM(qte) as qtyEntree')->where('id_article', $id_article)->first();
            $req_perte = $perteModel->select('SUM(qte) as qtyPerdue')->where('id_article', $id_article)->first();
            $req_vente = $venteModel->select('SUM(qte) as qtyVendue')->where('id_article', $id_article)->first();
            $qtyVendue = $req_vente['qtyVendue'];
            $qtyPerdue = $req_perte['qtyPerdue'];
            $qtyEntree = $req_entree['qtyEntree'];
            // Quantité totale stock restant
            $stockRestant = $qtyEntree - ($qtyPerdue + $qtyVendue);

            // le nouveau stock restant sans la qte de cet approvisionnement
            $newStockRestant = $stockRestant - $qte_prec;

            // Récuperons le prix de base stocké
            $basePrice = $changeModel->where('id_article', $id_article)->first();
            if ($newStockRestant == 0) 
            {
                $recupPrecPrice = 0;
            }
            else
            {
                $recupPrecprice = (($stockRestant * $basePrice["prix"]) - ($qte_prec * $pb))/$newStockRestant;
            }
            

            $approvisionnementModel->where('id', $id)->delete($id);
             // Récuperons l'id du changement de prix en fonction de l'article
             $req_id = $changeModel->where('id_article', $id_article)->first();

            $data_change = [
                'prix' => $recupPrecprice,
                'date_modification' => date('Y-m-d')
            ];
            $changeModel->update($req_id['id'], $data_change);

            echo json_encode('<div class="alert alert-danger">Approvisionnement supprimé</div>');
        }
    }

}