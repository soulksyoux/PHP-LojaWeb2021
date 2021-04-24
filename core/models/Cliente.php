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
     * @param $email
     * @return bool
     * @throws \Exception
     */
    public function email_alterado_registado($email): bool
    {
        $db = new DataBase();
        $param = ["email" => strtolower(trim($email)), "id_cliente" => $_SESSION["cliente"]];
        $recuperaCliente = $db->select("SELECT email FROM clientes WHERE email = :email && id_cliente != :id_cliente", $param);

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

    /**
     * @param int $id
     * @param array $dados
     * @return bool
     * @throws \Exception
     */
    public function update_cliente(int $id, array $dados): bool {

        $db = new DataBase();

        $params = [
            "id_cliente" => $id,
            "email" => strtolower(trim($dados["text_email"])),
            "nome" => trim($dados["text_nome_completo"]),
            "morada" => trim($dados["text_morada"]),
            "cidade" => trim($dados["text_cidade"]),
            "telefone" => trim($dados["text_telefone"]),
        ];

        if(!filter_var($params["email"], FILTER_VALIDATE_EMAIL)) {
            $_SESSION["erro"] = "email invalido";
            return false;
        }

        //validar se o email a alterar já existe noutra conta da bd
        if($this->email_alterado_registado($params["email"])) {
            $_SESSION["erro"] = "email já registado";
            return false;
        }

        //validar se existem realmente dados a alterar que sao diferentes do estado original


        if (!$db->update("UPDATE clientes SET email = :email, nome = :nome, morada = :morada, cidade = :cidade, telefone = :telefone WHERE id_cliente = :id_cliente" , $params)) {
            return false;
        }

        return true;
    }

    /**
     * @param int $id
     * @param string $password
     * @return bool
     * @throws \Exception
     */
    public function update_password(int $id, string $password): bool
    {

        $params = [
            "id_cliente" => $id,
            "password" => $password
        ];

        $db = new DataBase();
        $db = $db->update("UPDATE clientes SET senha = :password WHERE id_cliente = :id_cliente", $params);

        if(!$db) {
            return false;
        }

        return true;

    }


    /**
     * @param $purl
     * @return bool
     */
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


    /**
     * @param $dados
     * @return bool
     * @throws \Exception
     */
    public function validar_login($dados)
    {
        $db = new DataBase();

        // validar se o email enviado no form corresponde a 1 registo na bd
        $cliente = $db->select("SELECT * FROM clientes WHERE email = :email AND ativo = 1 AND deleted_at IS NULL", ["email" => $dados["email"]]);

        //var_dump($cliente);

        if(count($cliente) != 1) {
            //echo "cliente nao encontrado";
            return false;
        }

        // validar se a password corresponde após de usar o hash
        //var_dump($dados["senha"], $cliente[0]->senha);

        if(!password_verify($dados["senha"], $cliente[0]->senha)){
            //echo "senha inválida";
            return false;
        }

        $_SESSION["cliente"] = $cliente[0]->id_cliente;
        $_SESSION["cliente_email"] = $cliente[0]->email;
        $_SESSION["cliente_nome"] = $cliente[0]->nome;

        return true;
    }

    /**
     * @param $id_cliente
     * @return mixed|null
     * @throws \Exception
     */
    public function recuperaClienteById($id_cliente) {
        if(empty($_SESSION["cliente"])) {
            return null;
        }

        if(empty($id_cliente)) {
            return null;
        }

        $params = ["id" => $_SESSION["cliente"]];

        $db = new DataBase();
        $find = $db->select("SELECT id_cliente, email, nome, morada, cidade, telefone FROM clientes WHERE id_cliente = :id", $params);

        return $find[0];
    }


    /**
     * @param int $id_cliente
     * @param string $password
     * @return bool
     * @throws \Exception
     */
    public function validarPassword(int $id_cliente, string $password): bool
    {
        $params = [
          "id_cliente" => $id_cliente
        ];

        $db = new DataBase();
        $cliente = $db->select("SELECT senha FROM clientes WHERE id_cliente = :id_cliente", $params);

        if(count($cliente) != 1) {
            return false;
        }

        if(!password_verify($password, $cliente[0]->senha)) {
            return false;
        }

        return true;
    }

}