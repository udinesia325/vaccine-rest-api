<?php

namespace App\Controllers;

use App\Models\{Mspot, MspotVaccines, Mvaccination, Mvaccines};
use CodeIgniter\RESTful\ResourceController;

class Spots extends ResourceController
{
    public $spots;
    public $spotVaccines;
    public $vaccines;
    public $vaccinations;
    public function __construct()
    {
        $this->spots = new Mspot();
        $this->spotVaccines = new MspotVaccines();
        $this->vaccines = new Mvaccines();
        $this->vaccinations = new Mvaccination();
    }
    public function index()
    {
        // contoh
        // akhir contoh
        \Config\Services::getToken($this->request->getGet("token"));
        $result = [];
        $data_spot_with_vaccine =  $this->spots->getSpotGroupByIdSpot();
        // return $this->respond($data_spot_with_vaccine);
        // secara default false semua
        $available = [
            "Sinovac"  => false,
            "AstraZeneca"  => false,
            "Moderna"  => false,
            "Pfizer"  => false,
            "Sinnopharm"  => false,
        ];
        $vaccine = $this->vaccines->getVaccineWithSpotVaccines(); //ambil semua dengan spot vaksin juga

        foreach ($vaccine as $v) {
            $available[$v["name"]] = true; //ubah jadi true jika ada di dalam looping ini
        }
        // return $this->respond(["spots" => $available]);
        foreach ($data_spot_with_vaccine as $data_spot) {
            // push result dengan satu persatu data
            $result[] = [
                "id"  => $data_spot["id_spots"],
                'name' => $data_spot["name"],
                'address'  => $data_spot["address"],
                'serve' => $data_spot["serve"],
                'capacity' => $data_spot["capacity"],
                "available_vaccines" =>  $available
            ];
        }
        return $this->respond(["spots" => $result]);
    }
    public function show($id = null)
    {
        \Config\Services::getToken($this->request->getGet("token"));
        if ($this->request->getGet("date") != null) {
            $date = date("F d,Y", strtotime($this->request->getGet("date")));
        } else {
            $date = date("F d,Y", time());
        }

        $data_spot = $this->vaccinations->getByIdSpotOrDate($id, $date);
        $result = [
            "date" => $date,
            "spot" => [
                "id" => $id,
                "name" => $data_spot["name"],
                "address" => $data_spot["address"],
                "serve" => $data_spot["serve"],
                "capacity" => $data_spot["capacity"],
            ],
            "vaccinations_count" => $this->vaccinations->countBySpot($id)
        ];
        return $this->respond(["message" => $result]);
    }
}
