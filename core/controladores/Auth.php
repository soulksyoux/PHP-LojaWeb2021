<?php


namespace core\controladores;

use core\classes\DataBase;
use core\classes\Store;

class Auth
{
    public function registarUser()
    {

        //verifica se já existe uma sessão
        if (Store::clienteLogado() && $_SERVER['REQUEST_METHOD'] != 'POST') {
            $layouts = [
                "layouts/htmlHeader",
                "layouts/header",
                "inicio",
                "layouts/footer",
                "layouts/htmlFooter",
            ];

            Store::carregarView($layouts);
            return;
        }


        //valida se os dados que vem do post sao validos
        if (empty($_POST['text_email']) && empty($_POST['text_senha_1']) && empty($_POST['text_senha_2'])
            && empty($_POST['text_nome']) && empty($_POST['text_morada']) && empty($_POST['text_cidade'])) {
            $_SESSION["erro"] =  "Post tem dados em falta";
        }

        //valida se a senha 1 é igual à senha de confirmação 2
        if ($_POST['text_senha_1'] !== $_POST['text_senha_2']) {
            $_SESSION["erro"] =  "As senhas nao sao iguais";
        }

        //valida se o user já existe na bd
        $db = new DataBase();
        $recuperaCliente = $db->select("SELECT email FROM clientes WHERE email = :email",
            ["email" => $_POST["text_email"]]);

        if (!empty($recuperaCliente)) {
            $_SESSION["erro"] =   "O email já se encontra registado";
        }

        if($_SESSION["erro"]) {
            $layouts = [
                "layouts/htmlHeader",
                "layouts/header",
                "registo",
                "layouts/footer",
                "layouts/htmlFooter",
            ];

            Store::carregarView($layouts);
            return;
        }


        if ($db->insert("INSERT INTO clientes (email, senha, nome, morada, cidade, telefone) 
                            VALUES (:email, :senha, :nome, :morada, :cidade, :telefone)",
            [
                "email" => $_POST["text_email"],
                "senha" => $_POST["text_senha_1"],
                "nome" => $_POST["text_nome_completo"],
                "morada" => $_POST["text_morada"],
                "cidade" => $_POST["text_cidade"],
                "telefone" => $_POST["text_telefone"]
            ])
        ) {
            echo "Registo inserido";
            return;
        }
    }
}