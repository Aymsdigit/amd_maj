<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CategorieModel;

class Category extends BaseController
{
    public function index()
    {
        //
    }
    public function fetch_categories()
    {
        $categorieModel = new CategorieModel();
        $categorie = $categorieModel->orderBy('titre', 'ASC')->findAll();
        echo json_encode($categorie);
    }
    public function insert()
	{
		if ($this->request->getVar('action')) 
		{
			helper(['form', 'url']);
			$title_error = '';
			$error = 'no';
			$success = 'no';
			$message='';

			$error = $this->validate([
				'categorie-title' => [
					'rules' => 'required|min_length[3]',
					'errors' => [
					'required' => 'Veuillez remplir ce champ',
					'min_length' => 'Votre titre doit comporter au moins (03) trois caractères'
					],
				],
			]);

			if (!$error)
			{
				$error = 'yes';
				$validation = \config\Services::validation();
				if ($validation->getError('categorie-title'))
				{
					$title_error = $validation->getError('categorie-title');
				}
			}
			else
			{
				$success= 'yes';
				if ($this->request->getVar('action') == 'Add')
				{
					$categorieModel = new CategorieModel();
					$categorieModel->save([
						'titre' => $this->request->getVar('categorie-title'),
						'date_insertion' => date("Y-m-d"),
						
					]);

					$message = '<div class="alert alert-success">Catégorie ajoutée</div>';
				}

				// Mettre à jour
				if ($this->request->getVar('action') == 'Edit')
				{
					$categorieModel = new CategorieModel();

					$id = $this->request->getVar('hidden_id');

					$data = [
						'titre' => $this->request->getVar('categorie-title'),
						'date_modification' => date('Y-m-d')
					];

					$categorieModel->update($id, $data);

					$message = '<div class="alert alert-info">Modification effectuée avec succès</div>';
				}
			}

			$output = array(
				'title_error' => $title_error,
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
            $categorieModel = new CategorieModel();

            $categorieModel->where('id', $id)->delete($id);

            echo json_encode('<div class="alert alert-danger">Catégorie supprimée</div>');
        }
    }

    public function show()
    {
        $id = $this->request->getVar('id');
        if ($id)
        {
            $categorieModel = new CategorieModel();

            $categorie_data = $categorieModel->where('id', $this->request->getVar('id'))->first();

            echo json_encode($categorie_data);
        }
    }
}