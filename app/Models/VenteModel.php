<?php

namespace App\Models;

use CodeIgniter\Model;

class VenteModel extends Model
{
    protected $table = 'tbl_vente';

    protected $primaryKey = 'id';

    protected $allowedFields = ['id_client', 'id_article', 'qte','prix', 'prix_entree','type_vente','date_insertion','date_modification'];
    
    function last_event()
    {
        $builder = $this->db->table('tbl_vente');
        $builder->orderBy('id', 'DESC');
        $builder->limit(1);
        $query = $builder->get();
        return $query->getResult();
    }
    
    function bestArticle($month)
    {
        $builder = $this->db->table('tbl_vente');
        $builder->select('*, SUM(tbl_vente.qte_sortie) as quantite, tbl_vente.pt as montant');
        $builder->where('mois_vente', $month);
        $builder->orderBy('quantite', 'DESC');
        $builder->limit(10);
        $builder->join('tbl_article', 'tbl_article.id = tbl_vente.id_article');
        $builder->groupBy("id_article");
        $query = $builder->get();
        return $query->getResult();
    }
    
    public function bestClient($month)
    {
        $builder = $this->db->table('tbl_vente');
        $builder->select('*, SUM(pt) as mt_sortie');
        $builder->where('mois_vente', $month);
        $builder->orderBy('mt_sortie', 'DESC');
        $builder->limit(10);
        $builder->join('tbl_client', 'tbl_vente.id_client = tbl_client.id');
        $builder->groupBy("id_client");
        $query = $builder->get();
        return $query->getResult();
    }

    function vente_mois()
    {
        $builder = $this->db->table('tbl_vente');
        $builder->orderBy('id', 'DESC');
        $builder->limit(3);
        $builder->db->groupBy("id");
        $query = $builder->get();
        return $query->getResult();
    }

    function getAll()
    {
        $builder = $this->db->table('tbl_vente');
        $builder->select('*, tbl_vente.qte as quantite, tbl_vente.date_insertion as date_vente, (tbl_vente.prix * tbl_vente.qte) as montant, tbl_article.titre as article, tbl_vente.id as id_vente');
        $builder->join('tbl_article', 'tbl_article.id = tbl_vente.id_article');
        $builder->join('tbl_client', 'tbl_client.id = tbl_vente.id_client');
        $builder->orderBy('tbl_vente.id', 'DESC');
        $query = $builder->get();
        return $query->getResult();
    }
    
    function caisse()
    {
        
    }
}