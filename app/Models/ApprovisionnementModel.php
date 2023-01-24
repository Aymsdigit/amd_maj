<?php

namespace App\Models;

use CodeIgniter\Model;

class ApprovisionnementModel extends Model
{
    protected $table = 'tbl_approvisionnement';

    protected $primaryKey = 'id';

    protected $allowedFields = ['id_fournisseur', 'id_article', 'qte', 'prix', 'date_insertion', 'date_modification'];

    function getAll()
    {
        $builder = $this->db->table('tbl_approvisionnement');
        $builder->select('*, tbl_fournisseur.nom_prenoms as fournisseur, tbl_article.titre as article, qte as quantite, prix, tbl_approvisionnement.date_insertion as date, tbl_approvisionnement.id as id_approvisionnement');
        $builder->join('tbl_fournisseur', 'tbl_fournisseur.id = tbl_approvisionnement.id_fournisseur');
        $builder->join('tbl_article', 'tbl_article.id = tbl_approvisionnement.id_article');
        $builder->orderBy('tbl_approvisionnement.id', 'DESC');
        $query = $builder->get();
        return $query->getResult();
    }

    function getglobal()
    {
        $builder = $this->db->table('tbl_approvisionnement');
        $builder->select('*, tbl_chge_prix.prix as newPrice, tbl_article.titre as article, SUM(qte) as quantite');
        $builder->join('tbl_chge_prix', 'tbl_chge_prix.id_article = tbl_approvisionnement.id_article');
        $builder->join('tbl_article', 'tbl_article.id = tbl_approvisionnement.id_article');
        $builder->groupBy('tbl_approvisionnement.id_article');
        $query = $builder->get();
        return $query->getResult();
    }
}