<?php

namespace App\Models;

use CodeIgniter\Model;

class Mspot extends Model
{
    protected $table            = 'spots';
    protected $primaryKey       = 'id_spots';
    protected $allowedFields    = ["regional_id", "name", "address", "serve", "capacity"];
    public function getSpotGroupByIdSpot($id = null)
    {
        if (is_null($id)) {
            return $this->db->table("spots")
                ->select("*")
                // ->join("spot_vaccines", "spots.id_spots = spot_vaccines.spot_id")
                ->groupBy("id_spots")
                // ->join("vaccines", "vaccines.id_vaccines = spot_vaccines.vaccine_id")
                ->get()->getResultArray();
        }
    }
}
