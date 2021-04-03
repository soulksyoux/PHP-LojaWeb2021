<?php

namespace core\models;

use core\classes\DataBase;
use core\classes\Store;

class Cliente
{
    /**
     * @var DataBase
     */
    private $db;


    /**
     * Cliente constructor.
     */
    public function __construct()
    {
        $this->db = new DataBase();
    }


    /**
     * @return bool
     * @throws \Exception
     */
    public function email_registado($email): bool
    {
        $param = ["email" => strtolower(trim($email))];
        $recuperaCliente = $this->db->select("SELECT email FROM clientes WHERE email = :email", $param);

        if (empty($recuperaCliente)) {
            return false;
        }

        return true;
    }


    /**
     * @param string $purl
     * @return bool
     * @throws \Exception
     */
    public function registar_novo_cliente(string $purl): bool {

        $params = [
            "email" => strtolower(trim($_POST["text_email"])),
            "senha" => password_hash(trim($_POST["text_senha_1"]),PASSWORD_BCRYPT ),
            "nome" => trim($_POST["text_nome_completo"]),
            "morada" => trim($_POST["text_morada"]),
            "cidade" => trim($_POST["text_cidade"]),
            "telefone" => trim($_POST["text_telefone"]),
            "purl" => $purl
        ];

        if (!$this->db->insert("INSERT INTO clientes (email, senha, nome, morada, cidade, telefone, purl) 
                            VALUES (:email, :senha, :nome, :morada, :cidade, :telefone, :purl)", $params)
        ) {
            return false;
        }

        return true;
    }
}