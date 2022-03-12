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
            if (!password_verify($password, $data[0]["password"])) {
                return $this->loginFail();
            } else {
                $data = $data[0];
                session()->set("token", $data["login_tokens"]);
                $data = [
                    "name" => $data["name"],
                    "born_date" => $data["born_date"],
                    "gender" => $data["gender"],
                    "address" => $data["address"],
                    "token" => $data["login_tokens"],
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
        $token = $this->request->getGet("token");
        if ($token != session()->get("token") || $token == null) {
            return $this->respond(["message" => "Invalid token"], 401);
        }
        session()->destroy();
        return $this->respond(["message" => "logout success"], 200);
    }
    public function loginFail()
    {
        return $this->respond(["message" => "ID card number or password incorrect"], 401);
    }
}
