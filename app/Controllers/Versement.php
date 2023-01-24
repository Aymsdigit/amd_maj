<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\VersementModel;

class Versement extends BaseController
{
    public function index()
    {
        //
    }

    public function fetch_versement()
    {
        $versementModel = new VersementModel();
        $versement = $versementModel->findAll();
        echo json_encode($versement);
    }

    public function insert()
	{
		if ($this->request->getVar('action')) 
		{
			helper(['form', 'url']);
			$motif_error = '';
            $montant_error = '';
			$error = 'no';
			$success = 'no';
			$message='';

			$error = $this->validate([
				'motif' => [
					'rules' => 'required|min_length[3]',
					'errors' => [
					'required' => 'Veuillez remplir ce champ',
					'min_length' => 'Votre titre doit comporter au moins (03) trois caractères'
					],
				],
                'montant' => [
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
                if ($validation->getError('montant'))
				{
					$montant_error = $validation->getError('montant');
				}
			}
			else
			{
				$success= 'yes';
				if ($this->request->getVar('action') == 'Add')
				{
					$versementModel = new VersementModel();
					$versementModel->save([
						'motif' => $this->request->getVar('motif'),
                        'montant' => $this->request->getVar('montant'),
						'date_versement' => date('Y-m-d'),
					]);

					$message = '<div class="alert alert-success">versement ajoutée</div>';
				}

				// Mettre à jour
				if ($this->request->getVar('action') == 'Edit')
				{
					$versementModel = new VersementModel();

					$id = $this->request->getVar('hidden_id');

					$data = [
						'motif' => $this->request->getVar('motif'),
                        'montant' => $this->request->getVar('montant'),
					];

					$versementModel->update($id, $data);

					$message = '<div class="alert alert-info">Modification effectuée avec succès</div>';
				}
			}

			$output = array(
				'motif_error' => $motif_error,
                'montant_error' => $montant_error,
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
            $versementModel = new VersementModel();

            $versementModel->where('id', $id)->delete($id);

            echo json_encode('<div class="alert alert-danger">versement supprimée</div>');
        }
    }

    public function show()
    {
        if ($this->request->getVar('id'))
        {
            $versementModel = new VersementModel();

            $versement_data = $versementModel->where('id', $this->request->getVar('id'))->first();

            echo json_encode($versement_data);
        }
    }
}