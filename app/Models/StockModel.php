<?php

namespace App\Models;

use CodeIgniter\Model;

class StockModel extends Model
{
    protected $table = 'tbl_stock';

    protected $primaryKey = 'id';

    protected $allowedFields = ['id_article', 'qte_restante'];


    function getArticleStock($id_article)
    {
        $builder = $this->db->table('tbl_article');
        // $builder->select('SUM(qte_entree) as qte_total_entree, SUM(qte_entree * pb)/SUM(qte_entree) as moy_pb, SUM(qte_sortie) as qte_total_sortie');
        $builder->join('(SELECT SUM(tbl_approvisionnement.qte) as qte_total_entree, SUM(tbl_approvisionnement.qte * tbl_approvisionnement.prix)/SUM(tbl_approvisionnement.qte) as moy_pb from tbl_approvisionnement GROUP by tbl_approvisionnement.id_article) tbl_ap' , 'tbl_ap.id_article = tbl_article.id', 'left');
        $builder->join('(SELECT SUM(tbl_vente.qte) as qte_total_vente from tbl_vente GROUP by tbl_vente.id_article) tbl_v', 'tbl_ap.id_article = tbl_v.id_article', 'left');
        $builder->join('(SELECT SUM(tbl_perte.qte) as qte_total_perdue from tbl_perte GROUP by tbl_perte.id_article) tbl_p', 'tbl_article.id = tbl_p.id_article', 'left');
        $builder->where('tbl_article.id', $id_article);
        $builder->groupBy('tbl_article.id');
        $query = $builder->get();
        return $query->getResult();
    }

    function getStock($id_article)
    {
        $builder = $this->db->table('tbl_article');
        // $builder->select('SUM(qte_entree) as qte_total_entree, SUM(qte_entree * pb)/SUM(qte_entree) as moy_pb, SUM(qte_sortie) as qte_total_sortie');
        $builder->join('(SELECT *, SUM(qte_entree) as qte_total_entree, SUM(qte_entree * pb)/SUM(qte_entree) as moy_pb from tbl_approvisionnement GROUP by tbl_approvisionnement.id_article) tbl_ap' , 'tbl_ap.id_article = tbl_article.id', 'left');
        $builder->join('(SELECT *, SUM(qte_sortie) as qte_total_vente from tbl_vente GROUP by tbl_vente.id_article) tbl_v', 'tbl_ap.id_article = tbl_v.id_article', 'left');
        $builder->join('(SELECT *, SUM(qte_perdue) as qte_total_perdue from tbl_perte GROUP by tbl_perte.id_article) tbl_p', 'tbl_article.id = tbl_p.id_article', 'left');
        $builder->where('tbl_article.id', $id_article);
        $builder->groupBy('tbl_article.id');
        $query = $builder->get();
        return $query->getResult();
    }

    function stock_info()
    {
        $builder = $this->db->table('tbl_article');
        $builder->join('(SELECT *, tbl_chge_prix.prix as prixBase from tbl_chge_prix GROUP by tbl_chge_prix.id_article) tbl_apr' , 'tbl_apr.id_article = tbl_article.id', 'left');
        $builder->join('(SELECT *, SUM(tbl_approvisionnement.qte) as qte_total_entree, SUM(tbl_approvisionnement.qte * tbl_approvisionnement.prix)/SUM(tbl_approvisionnement.qte) as moy_pb from tbl_approvisionnement GROUP by tbl_approvisionnement.id_article) tbl_ap' , 'tbl_ap.id_article = tbl_article.id', 'left');
        $builder->join('(SELECT *, SUM(tbl_vente.qte) as qte_total_vente from tbl_vente GROUP by tbl_vente.id_article) tbl_v', 'tbl_ap.id_article = tbl_v.id_article', 'left');
        $builder->join('(SELECT *, SUM(quantite) as qte_total_retour from tbl_retour GROUP by tbl_retour.id_article) tbl_r', 'tbl_ap.id_article = tbl_r.id_article', 'left');
        $builder->join('(SELECT *, SUM(tbl_perte.qte) as qte_total_perdue from tbl_perte GROUP by tbl_perte.id_article) tbl_p', 'tbl_article.id = tbl_p.id_article', 'left');
        $builder->groupBy('tbl_article.id');
        $query = $builder->get();
        return $query->getResult();
    
    }
}