<?php


namespace core\models;


use core\classes\DataBase;

class Administrador
{

    public function obterAdminPorEmail($email): ?\stdClass {
        $params = ["utilizador" => $email];
        $db = new DataBase();
        $admin = $db->select("SELECT * FROM administradores WHERE utilizador = :utilizador AND delected_at IS NULL", $params);

        if(count($admin) != 1) {
            return null;
        }

        return $admin[0];
    }

}