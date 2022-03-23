<?php

namespace App\Controllers;

use App\Models\{Mconsultations, Mspot, Mvaccination};
use CodeIgniter\RESTful\ResourceController;

class Vaccinations extends ResourceController
{
    public $vaccinations;
    public $consultations;
    public $spot;
    public function __construct()
    {
        $this->vaccinations = new Mvaccination();
        $this->consultations = new Mconsultations();
        // $this->vaccinations = new Mspot();
    }
    public function index()
    {
    }
    public function create()
    {

        $society = \Config\Services::getToken($this->request->getGet("token"));
        $spot_id = $this->request->getPost("spot_id");
        $date = $this->request->getPost("date");
        $validation = [
            "spot_id" => "required",
            "date" => "required|valid_date"
        ];
        // validasi field
        if (!$this->validate($validation)) {
            return $this->respond([
                "message" => "Invalid Field",
                "errors" => $this->validator->getErrors()
            ], 401);
        }
        //ambil semua data dari table berikut
        $all_data = $this->vaccinations->db->table("vaccinations")
            ->select("*")
            ->join("societies", "vaccinations.society_id = societies.id_societies")
            ->join("consultations", "societies.id_societies = consultations.society_id")
            ->where("societies.id_societies", $society["id_societies"])
            ->get()->getResultArray();

        //jika udah vaksin lebih dari dua kali
        if (count($all_data) > 1) { //karena index di mulai dari nol
            return $this->respond(["message" => "Society has been 2x vaccinated"], 401);
        }
        //jika vaksin yang pertama kurang dari 30 hari 
        if (count($all_data) > 0) { //apakah sudah pernah vaksin pertama atau tidak
            $date_data = strtotime($all_data[0]["date"]);
            $now = strtotime($date);
            $diff = round((($now - $date_data) / 3600) / 24); //bandingkan dengan vaksin pertama
            // return $this->respond(["message" => $diff]);
            if ($diff < 30) {
                return $this->respond(["message" => "Wait at least + 30 day form 1st vaccination"], 401);
            }
        }
        // return  $this->respond(["date" => $diff]);

        //cek apakah sudah di accept atau belum untuk semua consultation berdasarkan id society saat ini
        $consultations = $this->consultations->db->table("consultations")
            ->select("*")
            ->join("societies", "consultations.society_id = societies.id_societies")
            ->get()->getResultArray();

        foreach ($consultations as $c) {
            if ($c["status"] != "accepted") {
                return $this->respond(["message" => "your consultations must be accepted by doctor before"], 401);
            }
        }


        // jika semua pengecekan berhasil maka insert ke database
        $data = [
            "society_id" => $society["id_societies"],
            "spot_id" => $this->request->getPost("spot_id"),
            "date" => $this->request->getPost("date"),
        ];
        $society_id =  $society["id_societies"];
        $spot_id = $this->request->getPost("spot_id");
        $date = $this->request->getPost("date");
        //untuk first atau second
        $message = count($all_data) == 0 ? "first" : "second";
        $this->vaccinations->db->query("INSERT INTO vaccinations(society_id,spot_id,date) VALUES('$society_id','$spot_id','$date')");
        return $this->respond(["message" => "$message Vaccinations registered successful"]);
    }
    public function show($id = null)
    {
        $society = \Config\Services::getToken($this->request->getGet("token"));
        $result = [];
        $all_data = $this->vaccinations->db->table("vaccinations")
            ->select("*,spots.name as spotname,vaccines.name as vaccinename, societies.name as societyname,medicals.name as medicalname")
            ->join("societies", "vaccinations.society_id = societies.id_societies")
            ->join("consultations", "societies.id_societies = consultations.society_id")
            ->join("spots", "vaccinations.spot_id=spots.id_spots ")
            ->join("regionals", "societies.regional_id = regionals.id_regionals")
            ->join("vaccines", "vaccinations.vaccine_id = vaccines.id_vaccines")
            ->join("medicals", "medicals.spot_id = spots.id_spots")
            ->where("societies.id_societies", $society["id_societies"])
            ->groupBy("vaccinations.id_vaccinations")
            ->get()->getResultArray();
        $state = 1;
        // return $this->respond(["message" => $all_data]);
        // semua tabel memiliki name makanya di merge
        foreach ($all_data as $a) {
            $result[$state == 1 ? "first" : "second"] = [
                "queue" => count($all_data),
                "dose" => $a["dose"],
                "vaccination_date" => $a["date"],
                "spot" => [
                    "id" => $a["id_spots"],
                    "name" => $a["spotname"],
                    "address" => $a["address"],
                    "serve" => $a["serve"],
                    "capacity" => $a["capacity"],
                ],
                "regional" => [
                    "id" => $a["id_regionals"],
                    "province" => $a["province"],
                    "district" => $a["district"],
                ],
                "status" => "done",
                "vaccine" => [
                    "id" => $a["id_vaccines"],
                    "name" => $a["vaccinename"],
                ],
                "vaccinator" => [
                    "id" => $a["id_medicals"],
                    "name" => $a["medicalname"],
                ],
            ];
            $state++;
        }
        if (count($all_data) == 1) $result["second"] = null;
        return $this->respond(["vaccinations" => $result]);
    }
}
