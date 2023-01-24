<?php

namespace App\Models;

use CodeIgniter\Model;

class CreditModel extends Model
{
    protected $table = 'tbl_credit';

    protected $primaryKey = 'id';

    protected $allowedFields = ['id_client', 'id_vente', 'montant','etat', 'date_insertion','date_modification'];

    function getAll()
    {
        $builder = $this->db->table('tbl_credit');
        $builder->select('*,SUM(tbl_credit.montant) as montant_credit, tbl_credit.date_insertion as date_credit, tbl_credit.id as credit_id, tbl_credit.id_client as client_id ');
        $builder->groupBy('tbl_credit.id_client');
        $builder->join('(SELECT *, SUM(tbl_paiement.montant) as montant_paie from tbl_paiement GROUP by tbl_paiement.id_credit) tbl_paie' , 'tbl_paie.id_credit = tbl_credit.id', 'left');
        
        $query = $builder->get();
        return $query->getResult();
    }
}