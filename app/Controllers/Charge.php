<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ChargeModel;

class Charge extends BaseController
{
    public function index()
    {
        //
    }

    public function fetch_charge()
    {
        $chargeModel = new ChargeModel();
        $charge = $chargeModel->findAll();
        echo json_encode($charge);
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
					$chargeModel = new ChargeModel();
					$chargeModel->save([
						'motif' => $this->request->getVar('motif'),
                        'montant' => $this->request->getVar('montant'),
						'date_insertion' => date('Y-m-d'),
					]);

					$message = '<div class="alert alert-success">charge ajoutée</div>';
				}

				// Mettre à jour
				if ($this->request->getVar('action') == 'Edit')
				{
					$chargeModel = new ChargeModel();

					$id = $this->request->getVar('hidden_id');

					$data = [
						'motif' => $this->request->getVar('motif'),
                        'montant' => $this->request->getVar('montant'),
                        'date_modification' => date('Y-m-d'),
					];

					$chargeModel->update($id, $data);

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
            $chargeModel = new ChargeModel();

            $chargeModel->where('id', $id)->delete($id);

            echo json_encode('<div class="alert alert-danger">charge supprimée</div>');
        }
    }

    public function show()
    {
        if ($this->request->getVar('id'))
        {
            $chargeModel = new ChargeModel();

            $charge_data = $chargeModel->where('id', $this->request->getVar('id'))->first();

            echo json_encode($charge_data);
        }
    }
}