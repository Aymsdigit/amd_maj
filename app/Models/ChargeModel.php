<?php

namespace App\Models;

use CodeIgniter\Model;

class ChargeModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'tbl_charge';
    protected $primaryKey       = 'id';
    protected $allowedFields = ['motif', 'montant', 'date_insertion', 'date_modification'];
}