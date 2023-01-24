<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ChangePrixModel;
use App\Models\PerteModel;

class Perte extends BaseController
{
    public function index()
    {
        //
    }

    public function fetch_perte()
    {
        $perteModel = new PerteModel();
        $perte = $perteModel->getAll();
        echo json_encode($perte);
    }

    function insert_perte()
    {
        if ($this->request->getVar('action')) 
		{
			helper(['form', 'url']);
			$article_error = '';
			$quantite_error = '';
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
					'min_length' => 'Votre seuil minimum doit etre 1'
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
			}
			else
			{
				$success= 'yes';
				if ($this->request->getVar('action') == 'Add')
				{
					$perteModel = new PerteModel();
                    $changeModel = new ChangePrixModel();

                    // récuperons le prix de base stocké
                    $base_price = $changeModel->where('id_article', $this->request->getVar('article'))->first();
                    $montant = $base_price["prix"] * $this->request->getVar('quantite');

					$perteModel->save([
						'id_article' => $this->request->getVar('article'),
						'qte' => $this->request->getVar('quantite'),
						'montant' => $montant,
						
					]);

					$message = '<div class="alert alert-success">Perte ajoutée</div>';
				}

				// Mettre à jour
				if ($this->request->getVar('action') == 'Edit')
				{
					$perteModel = new PerteModel();
                    $changeModel = new ChangePrixModel();
                    $base_price = $changeModel->where('id_article', $this->request->getVar('article'))->first();
                    $montant = $base_price["prix"] * $this->request->getVar('quantite');

					$id = $this->request->getVar('hidden_id');

					$data = [
						'qte' => $this->request->getVar('quantite'),
						'montant' => $montant,
                        'date_modification'=>date('Y-m-d') 
					];

					$perteModel->update($id, $data);

					$message = '<div class="alert alert-info">Modification effectuée avec succès</div>';
				}
			}

			$output = array(
				'article_error' => $article_error,
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
            $perteModel = new PerteModel();

            $perteModel->where('id', $id)->delete($id);

            echo json_encode('<div class="alert alert-danger">Perte supprimée</div>');
        }
    }

    function show()
    {
        if ($this->request->getVar('id'))
        {
            $perteModel = new PerteModel();

            $perte_data = $perteModel->where('id', $this->request->getVar('id'))->first();

            echo json_encode($perte_data);
        }
    }
}