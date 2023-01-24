<?php

namespace App\Models;

use CodeIgniter\Model;

class ChangePrixModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'tbl_chge_prix';
    protected $primaryKey       = 'id';
    protected $allowedFields = ['id_article', 'prix', 'date_insertion', 'date_modification'];
}