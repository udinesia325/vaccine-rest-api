<?php

namespace App\Controllers;

use App\Models\{Mconsultations};
use CodeIgniter\RESTful\ResourceController;

class Consultations extends ResourceController
{
    public $consultations;
    public function __construct()
    {
        $this->consultations = new Mconsultations();
    }
    public function index()
    {
        $society = \Config\Services::getToken($this->request->getGet("token"));
        $result = [];
        $data = $this->consultations->db
            ->table("consultations")
            ->select("*")
            ->join("medicals", "consultations.doctor_id = medicals.id_medicals")
            ->where("society_id", $society["id_societies"])
            ->get()->getResultArray();
        // return var_dump($data);
        foreach ($data as $d) {
            // push ke result
            $result[] = [
                "id" => $d["id_consultation"],
                "status" => $d["status"],
                "disease_history" => $d["disease_history"],
                "current_symptomps" => $d["current_symptomps"],
                "doctor_notes" => $d["doctor_notes"],
                "doctor" => $d["name"]
            ];
        }

        return $this->respond(["consultations" => $result], 200);
    }
    public function create()
    {
        $societyData = \Config\Services::getToken($this->request->getGet("token"));
        $society_id = $societyData["id_societies"];
        $data = [
            "disease_history" => $this->request->getPost("disease_history"),
            "current_symptomps" => $this->request->getPost("current_symptomps"),
            "society_id" => $society_id
        ];
        $this->consultations->insert($data);
        return $this->respond(["message" => "request consultations sent succesful"], 200);
    }
}
