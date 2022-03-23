<?php

namespace App\Models;

use CodeIgniter\Model;

class MspotVaccines extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'spot_vaccines';
    protected $primaryKey       = 'id_spot_vaccines';
    protected $allowedFields    = ["spot_id", "vaccine_id"];
}
