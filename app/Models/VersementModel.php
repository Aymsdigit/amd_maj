<?php

namespace App\Models;

use CodeIgniter\Model;

class VersementModel extends Model
{
    protected $table = 'tbl_versement';

    protected $primaryKey = 'id';

    protected $allowedFields = ['motif', 'montant', 'date_insertion', 'date_modification'];
}