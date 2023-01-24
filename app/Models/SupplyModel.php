<?php

namespace App\Models;

use CodeIgniter\Model;

class SupplyModel extends Model
{
    protected $table            = 'tbl_supply';
    protected $primaryKey       = 'id';
    protected $allowedFields = ['id_fournisseur', 'id_article', 'qte_entree', 'pb', 'date_entree', 'new_pb'];
}