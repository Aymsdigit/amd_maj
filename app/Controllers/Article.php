<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ArticleModel;

class Article extends BaseController
{
    public function index()
    {
        //
    }
    public function fetch_article()
    {
        $articleModel = new ArticleModel();
        $article = $articleModel->orderBy('titre','ASC')->getAll();
        echo json_encode($article);
    }

    public function load_article()
    {
        $articleModel = new ArticleModel();
        $article = $articleModel->orderBy('titre' ,'ASC')->findAll();
        echo json_encode($article);
    }

    public function insert()
	{
		if ($this->request->getVar('action')) 
		{
			helper(['form', 'url']);
			$article_error = '';
			$seuil_error = '';
			$categorie_error = '';
			$error = 'no';
			$success = 'no';
			$message='';

			$error = $this->validate([
				'article-title' => [
					'rules' => 'required|min_length[3]',
					'errors' => [
					'required' => 'Veuillez remplir ce champ',
					'min_length' => 'Votre titre doit comporter au moins (03) trois caractères'
					],
				],
				'article-seuil' => [
					'rules' => 'required|numeric|min_length[1]',
					'errors' => [
					'required' => 'Veuillez remplir ce champ',
					'numeric' => 'Veuillez entrer des nombres',
					'min_length' => 'Votre seuil minimum doit etre 1'
					],
				],
				'categorie' => [
					'rules' => 'required',
					'errors' => [
					'required' => 'Veuillez choisir une catégorie',
					],
				],
			]);

			if (!$error)
			{
				$error = 'yes';
				$validation = \config\Services::validation();
				if ($validation->getError('article-title'))
				{
					$article_error = $validation->getError('article-title');
				}
				if ($validation->getError('article-seuil'))
				{
					$seuil_error = $validation->getError('article-seuil');
				}
				if ($validation->getError('categorie'))
				{
					$categorie_error = $validation->getError('categorie');
				}
			}
			else
			{
				$success= 'yes';
				if ($this->request->getVar('action') == 'Add')
				{
					$articleModel = new ArticleModel();
					$articleModel->save([
						'titre' => $this->request->getVar('article-title'),
						'seuil' => $this->request->getVar('article-seuil'),
						'id_categorie' => $this->request->getVar('categorie'),
						
					]);

					$message = '<div class="alert alert-success">Article ajouté</div>';
				}

				// Mettre à jour
				if ($this->request->getVar('action') == 'Edit')
				{
					$articleModel = new ArticleModel();

					$id = $this->request->getVar('hidden_id');

					$data = [
						'titre' => $this->request->getVar('article-title'),
						'seuil' => $this->request->getVar('article-seuil'),
						'id_categorie' => $this->request->getVar('categorie'),
						'date_modification' => date('Y-m-d')
					];

					$articleModel->update($id, $data);

					$message = '<div class="alert alert-info">Modification effectuée avec succès</div>';
				}
			}

			$output = array(
				'article_error' => $article_error,
				'seuil_error' => $seuil_error,
				'categorie_error' => $categorie_error,
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
            $articleModel = new ArticleModel();

            $articleModel->where('id', $id)->delete($id);

            echo json_encode('<div class="alert alert-danger">Article supprimé</div>');
        }
    }

    public function show()
    {
        if ($this->request->getVar('id'))
        {
            $articleModel = new ArticleModel();

            $article_data = $articleModel->where('id', $this->request->getVar('id'))->first();

            echo json_encode($article_data);
        }
    }
}