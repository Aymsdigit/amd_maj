<?php

namespace App\Models;

use CodeIgniter\Model;

class PerteModel extends Model
{
    protected $table            = 'tbl_perte';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['id_article', 'qte', 'montant', 'date_insertion', 'date_modification'];


    function getAll()
    {
        $builder = $this->db->table('tbl_perte');
        $builder->select('*, tbl_perte.qte as quantite, tbl_perte.montant as montant, tbl_article.titre as article, tbl_perte.date_insertion as date, tbl_perte.id as id_perte');
        $builder->join('tbl_article', 'tbl_article.id = tbl_perte.id_article');
        $query = $builder->get();
        return $query->getResult();
    }
}