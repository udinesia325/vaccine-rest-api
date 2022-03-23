<?php

namespace App\Controllers;

use App\Models\{Msociety, Mregional};
use CodeIgniter\RESTful\ResourceController;

class Login extends ResourceController
{
    public $societies;
    public $regionals;
    public function __construct()
    {
        $this->societies = new  Msociety();
        $this->regionals = new  Mregional();
    }
    public function index()
    {
        $id_card_number = $this->request->getPost("id_card_number");
        $password = $this->request->getPost("password");
        $validation = [
            "id_card_number" => "required",
            "password" => "required"
        ];
        if ($this->validate($validation)) {
            $data = $this->societies->db->table("societies")
                ->select("*")
                ->join("regionals", "societies.regional_id=regionals.id_regionals")
                ->where("id_card_number", $id_card_number)
                ->get()->getResultArray();
            // return var_dump($data);
            if (count($data) == 0) {
                return $this->loginFail();
            }
            if (!password_verify($password, $data[0]["password"])) {
                return $this->loginFail();
            } else {
                $data = $data[0]; //ambil data pertama
                // return $this->respond($data);
                // isi login token dengan md5 dari id user
                $this->societies->db->table("societies")
                    ->set("login_tokens", md5($data["id_card_number"]))
                    ->where("id_societies", $data["id_societies"])
                    ->update();
                $data = [
                    "name" => $data["name"],
                    "born_date" => $data["born_date"],
                    "gender" => $data["gender"],
                    "address" => $data["address"],
                    "token" => md5($data["id_card_number"]),
                    "regional" => [
                        "id" => $data["id_regionals"],
                        "province" => $data["province"],
                        "district" => $data["district"],
                    ]
                ];
                return $this->respond($data, 200);
            }
        } else {
            return $this->loginFail();
        }
    }
    public function logout()
    {
        \Config\Services::getToken($this->request->getGet("token"));
        \Config\Services::logout($this->request->getGet("token"));
        return $this->respond(["message" => "logout success"], 200);
    }
    public function loginFail()
    {
        return $this->respond(["message" => "ID card number or password incorrect"], 401);
    }
}
