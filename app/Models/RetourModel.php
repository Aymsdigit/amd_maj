<?php

namespace App\Models;

use CodeIgniter\Model;

class RetourModel extends Model
{
    protected $table = 'tbl_retour';

    protected $primaryKey = 'id';

    protected $allowedFields = ['motif', 'quantite', 'date_insertion', 'date_modification', 'adresse', 'id_article'];

    function getAll()
    {
        $builder = $this->db->table('tbl_retour');
        $builder->select('*, tbl_article.id as id_article, tbl_retour.id as id_retour');
        $builder->join('tbl_article', 'tbl_article.id = tbl_retour.id_article');
        $builder->orderBy('tbl_retour.id', 'DESC');
        $query = $builder->get();
        return $query->getResult();
    }
}