<?php

namespace App\Models;

use CodeIgniter\Model;

class Mvaccination extends Model
{
    protected $table            = 'vaccinations';
    protected $primaryKey       = 'id_vaccinations';
    protected $allowedFields    = ["dose", "date", "society_id", "spot_id", "vaccine_id", "doctor_id", "officer_id"];
    public function getByIdSpotOrDate($spot_id, $date)
    {
        return (array) $this->db->table("vaccinations")
            ->select("*")
            ->join("spots", "vaccinations.spot_id = spots.id_spots")
            ->where("spots.id_spots", $spot_id)
            ->orWhere("vaccinations.date", $date)
            ->get()->getFirstRow();
    }
    public function countBySpot($spot_id)
    {
        $data = $this->db->table("vaccinations")
            ->select("*")
            ->where("spot_id", $spot_id)
            ->get()->getResultArray();
        return count($data);
    }
}
