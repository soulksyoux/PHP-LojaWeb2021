<?php


namespace core\controllers;

use core\classes\Email;
use core\classes\Store;
use core\models\Cliente;

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

        $cliente = new Cliente();
        $email = $_POST["text_email"];

        if($cliente->email_registado($email)){
            $_SESSION["erro"] = "O email já se encontra registado";
        }

        if(!empty($_SESSION["erro"])) {
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

        $purl = Store::criarHash(24);

        if($cliente->registar_novo_cliente($purl)) {
            echo "Registo efetuado!!!";
        }

        $linkPurl = APP_URL . "?a=confirmar_email&purl=$purl";

        $toEmail = "andytod80@gmail.com";
        $toName = "AndreGP";
        $subject = "Email de teste";
        $body = "Este é um email de teste enviado da APP via PHPMailer";
        $body .= "<br>";
        $body .= "O link de confirmação é o seguinte:";
        $body .= "<br><br>";
        $body .= $linkPurl;

        $mail = new Email();
        if($mail->enviar_email_confirmacao_novo_cliente($toEmail, $toName, $subject, $body)) {
            echo "email enviado!!!";
        }

    }
}