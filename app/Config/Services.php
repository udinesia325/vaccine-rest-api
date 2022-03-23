<?php

namespace Config;

use App\Models\Msociety;
use CodeIgniter\Config\BaseService;

/**
 * Services Configuration file.
 *
 * Services are simply other classes/libraries that the system uses
 * to do its job. This is used by CodeIgniter to allow the core of the
 * framework to be swapped out easily without affecting the usage within
 * the rest of your application.
 *
 * This file holds any application-specific services, or service overrides
 * that you might need. An example has been included with the general
 * method format you should use for your service methods. For more examples,
 * see the core Services file at system/Config/Services.php.
 */
class Services extends BaseService
{
    /*
     * public static function example($getShared = true)
     * {
     *     if ($getShared) {
     *         return static::getSharedInstance('example');
     *     }
     *
     *     return new \CodeIgniter\Example();
     * }
     */
    /**
     * untuk cek token di database
     * @param token dari request di parameter
     * 
     * @return data|error akan error jika data tidak ada 
     */
    public static function getToken($token)
    {
        $user = new Msociety();
        $data = $user->db->table("societies")
            ->select("*")
            ->where("login_tokens", $token)
            ->get()->getResultArray();
        // jika kosong langsung lempar error
        if (count($data) == 0) {
            header("Content-Type:application/json", true, 401);
            die(json_encode(["message" => "Unauthorized user"]));
        }
        return $data[0]; //ambil yang pertama
    }
    /**
     * ini untuk menghapus login_tokens yang ada di database
     */
    public static function logout($token)
    {
        $user = new Msociety();
        $user->db->table("societies")
            ->set("login_tokens", "")
            ->where("login_tokens", $token)
            ->update();
    }
}
