<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\FournisseurModel;

class Fournisseur extends BaseController
{
    public function index()
    {
        //
    }

    public function fetch_fournisseur()
    {
        $fournisseurModel = new FournisseurModel();
        $fournisseur = $fournisseurModel->findAll();
        echo json_encode($fournisseur);
    }

    public function insert()
	{
		if ($this->request->getVar('action')) 
		{
			helper(['form', 'url']);
			$name_error = '';
            $contact_error = '';
            $adresse_error = '';
			$error = 'no';
			$success = 'no';
			$message='';

			$error = $this->validate([
				'name' => [
					'rules' => 'required|min_length[3]',
					'errors' => [
					'required' => 'Veuillez remplir ce champ',
					'min_length' => 'Votre titre doit comporter au moins (03) trois caractères'
					],
				],
                'contact' => [
					'rules' => 'required',
					'errors' => [
					'required' => 'Veuillez remplir ce champ',
					],
				],
                'adresse' => [
					'rules' => 'required',
					'errors' => [
					'required' => 'Veuillez remplir ce champ',
					],
				],
			]);

			if (!$error)
			{
				$error = 'yes';
				$validation = \config\Services::validation();
				if ($validation->getError('name'))
				{
					$name_error = $validation->getError('name');
				}
                if ($validation->getError('contact'))
				{
					$contact_error = $validation->getError('contact');
				}
                if ($validation->getError('adresse'))
				{
					$adresse_error = $validation->getError('adresse');
				}
			}
			else
			{
				$success= 'yes';
				if ($this->request->getVar('action') == 'Add')
				{
					$fournisseurModel = new FournisseurModel();
					$fournisseurModel->save([
						'nom_prenoms' => $this->request->getVar('name'),
                        'contact' => $this->request->getVar('contact'),
                        'adresse' => $this->request->getVar('adresse'),
						
					]);

					$message = '<div class="alert alert-success">Fournisseur ajouté</div>';
				}

				// Mettre à jour
				if ($this->request->getVar('action') == 'Edit')
				{
					$fournisseurModel = new FournisseurModel();

					$id = $this->request->getVar('hidden_id');

					$data = [
						'nom_prenoms' => $this->request->getVar('name'),
                        'contact' => $this->request->getVar('contact'),
                        'date_modification' => date('Y-m-d')
					];

					$fournisseurModel->update($id, $data);

					$message = '<div class="alert alert-info">Modification effectuée avec succès</div>';
				}
			}

			$output = array(
				'name_error' => $name_error,
                'contact_error' => $contact_error,
                'adresse_error' => $adresse_error,
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
            $fournisseurModel = new FournisseurModel();

            $fournisseurModel->where('id', $id)->delete($id);

            echo json_encode('<div class="alert alert-danger">Fournisseur supprimé</div>');
        }
    }

    public function show()
    {
        if ($this->request->getVar('id'))
        {
            $fournisseurModel = new FournisseurModel();

            $fournisseur_data = $fournisseurModel->where('id', $this->request->getVar('id'))->first();

            echo json_encode($fournisseur_data);
        }
    }
}