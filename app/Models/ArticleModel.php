<?php

namespace App\Models;

use CodeIgniter\Model;

class ArticleModel extends Model
{
    protected $table = 'tbl_article';

    protected $primaryKey = 'id';

    protected $allowedFields = ['titre', 'id_categorie', 'seuil', 'date_insertion', 'date_modification'];


    function getAll()
    {
        $builder = $this->db->table('tbl_article');
        $builder->select('seuil, tbl_article.date_insertion as article_insertion, tbl_categorie.titre as titreCategorie, tbl_article.titre as titreArticle, tbl_article.id as idArticle, tbl_categorie.id as idCategorie');
        $builder->join('tbl_categorie', 'tbl_categorie.id = tbl_article.id_categorie',);
        $builder->orderBy('tbl_article.id', 'DESC');
        $query = $builder->get();
        return $query->getResult();
    }
    
}