<?php

namespace App\Models;

use CodeIgniter\Model;

class Msociety extends Model
{
    protected $table            = 'societies';
    protected $primaryKey       = 'id_societies';
    protected $allowedFields    = ["id_card_number", "password", "name", "born_date", "gender", "address", "regional_id", "login_tokens"];
}
