<?php

namespace App\Models;

use CodeIgniter\Model;

class CategorieModel extends Model
{
    protected $table            = 'tbl_categorie';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['titre', 'date_insertion', 'date_modification'];

    
}