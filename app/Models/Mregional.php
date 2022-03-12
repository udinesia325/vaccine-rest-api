<?php

namespace App\Models;

use CodeIgniter\Model;

class Mregional extends Model
{
    protected $table            = 'regionals';
    protected $primaryKey       = 'id_regionals';
    protected $allowedFields    = ["province", "district"];
}
