<?php

namespace App\Models;

use CodeIgniter\Model;

class Mvaccines extends Model
{
    protected $table            = 'vaccines';
    protected $primaryKey       = 'id_vaccines';
    protected $allowedFields    = ["name"];
    public function getVaccineBySpot($id_spot)
    {
        return $this->db->table("vaccines")->select("*")
            ->join("spot_vaccines", "vaccines.id_vaccines = spot_vaccines.vaccine_id")
            ->get()->getResultArray();
    }
    public function getVaccineWithSpotVaccines()
    {
        return $this->db->table("vaccines")
            ->select("*")
            ->join("spot_vaccines", "vaccines.id_vaccines = spot_vaccines.vaccine_id")
            ->get()->getResultArray();
    }
}
