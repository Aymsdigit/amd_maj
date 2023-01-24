<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\RetourModel;

class Retour extends BaseController
{
    public function index()
    {
        //
    }

    public function fetch_retour()
    {
        $retourModel = new RetourModel();
        $retour = $retourModel->getAll();
        echo json_encode($retour);
    }

    public function insert()
	{
		if ($this->request->getVar('action')) 
		{
			helper(['form', 'url']);
			$motif_error = '';
            $article_error = '';
            $quantite_error = '';
            $adresse_error = '';
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
				'motif' => [
					'rules' => 'required|min_length[3]',
					'errors' => [
					'required' => 'Veuillez remplir ce champ',
					'min_length' => 'Votre titre doit comporter au moins (03) trois caractères'
					],
				],
                'adresse' => [
					'rules' => 'required|min_length[3]',
					'errors' => [
					'required' => 'Veuillez remplir ce champ',
					'min_length' => 'Votre titre doit comporter au moins (03) trois caractères'
					],
				],
                'quantite' => [
					'rules' => 'required|numeric',
					'errors' => [
					'required' => 'Veuillez remplir ce champ',
					],
				],
			]);

			if (!$error)
			{
				$error = 'yes';
				$validation = \config\Services::validation();
				if ($validation->getError('motif'))
				{
					$motif_error = $validation->getError('motif');
				}
                if ($validation->getError('quantite'))
				{
					$quantite_error = $validation->getError('quantite');
				}
                if ($validation->getError('adresse'))
				{
					$adresse_error = $validation->getError('adresse');
				}
                if ($validation->getError('article'))
				{
					$article_error = $validation->getError('article');
				}
			}
			else
			{
				$success= 'yes';
				if ($this->request->getVar('action') == 'Add')
				{
					$retourModel = new RetourModel();
					$retourModel->save([
						'motif' => $this->request->getVar('motif'),
                        'id_article' => $this->request->getVar('article'),
                        'adresse' => $this->request->getVar('adresse'),
                        'quantite' => $this->request->getVar('quantite'),
						'date_insertion' => date('Y-m-d'),
					]);

					$message = '<div class="alert alert-success">Retour ajouté</div>';
				}

				// Mettre à jour
				if ($this->request->getVar('action') == 'Edit')
				{
					$retourModel = new RetourModel();

					$id = $this->request->getVar('hidden_id');

					$data = [
						'motif' => $this->request->getVar('motif'),
                        'id_article' => $this->request->getVar('article'),
                        'adresse' => $this->request->getVar('adresse'),
                        'motif' => $this->request->getVar('motif'),
                        'quantite' => $this->request->getVar('quantite'),
                        'date_modification' => date('Y-m-d'),
					];

					$retourModel->update($id, $data);

					$message = '<div class="alert alert-info">Modification effectuée avec succès</div>';
				}
			}

			$output = array(
				'motif_error' => $motif_error,
                'article_error' => $article_error,
                'adresse_error' => $adresse_error,
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
            $retourModel = new RetourModel();

            $retourModel->where('id', $id)->delete($id);

            echo json_encode('<div class="alert alert-danger">Retour supprimé</div>');
        }
    }

    public function show()
    {
        if ($this->request->getVar('id'))
        {
            $retourModel = new RetourModel();

            $retour_data = $retourModel->where('id', $this->request->getVar('id'))->first();

            echo json_encode($retour_data);
        }
    }
}