<?php

namespace core\models;

use core\classes\DataBase;
use core\classes\Store;

class Cliente
{

    /**
     * @return bool
     * @throws \Exception
     */
    public function email_registado($email): bool
    {
        $db = new DataBase();
        $param = ["email" => strtolower(trim($email))];
        $recuperaCliente = $db->select("SELECT email FROM clientes WHERE email = :email", $param);

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


        $db = new DataBase();
        $params = [
            "email" => strtolower(trim($_POST["text_email"])),
            "senha" => password_hash(trim($_POST["text_senha_1"]),PASSWORD_BCRYPT ),
            "nome" => trim($_POST["text_nome_completo"]),
            "morada" => trim($_POST["text_morada"]),
            "cidade" => trim($_POST["text_cidade"]),
            "telefone" => trim($_POST["text_telefone"]),
            "purl" => $purl
        ];

        if (!$db->insert("INSERT INTO clientes (email, senha, nome, morada, cidade, telefone, purl) 
                            VALUES (:email, :senha, :nome, :morada, :cidade, :telefone, :purl)", $params)
        ) {
            return false;
        }

        return true;
    }

    public function validar_utilizador_apos_registo($purl): bool{
        $db = new DataBase();

        //tenta recuperar o registo com o purl ja sanitizado
        try {
            $cliente = $db->select("SELECT * FROM clientes WHERE purl = :purl", ["purl" => $purl]);

        }catch (\Exception $e) {
            return false;
        }

        //valida se o registo recuperado é apenas um
        if(count($cliente) !== 1) {
            return false;
        }

        $params = [
            "id_cliente" => $cliente[0]->id_cliente,
            "purl" => "",
            "ativo" => 1
        ];

        try {
            $insere = $db->update("UPDATE clientes SET purl = :purl, ativo = :ativo WHERE id_cliente = :id_cliente", $params);
        }catch (\Exception $e) {
            echo null;
        }

        if(!$insere) {
            echo "c";
            return false;
        }

        return true;
    }

}