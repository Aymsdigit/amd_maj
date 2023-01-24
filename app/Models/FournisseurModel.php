<?php

namespace App\Models;

use CodeIgniter\Model;

class FournisseurModel extends Model
{
    protected $table = 'tbl_fournisseur';

    protected $primaryKey = 'id';

    protected $allowedFields = ['nom_prenoms', 'contact', 'adresse', 'date_insertion', 'date_modification'];
}