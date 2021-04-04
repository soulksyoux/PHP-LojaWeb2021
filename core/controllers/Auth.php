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
            $_SESSION["erro"] = "Post tem dados em falta";
        }

        //valida se a senha 1 é igual à senha de confirmação 2
        if ($_POST['text_senha_1'] !== $_POST['text_senha_2']) {
            $_SESSION["erro"] = "As senhas nao sao iguais";
        }

        //valida se o user já existe na bd

        $cliente = new Cliente();
        $email = $_POST["text_email"];

        if ($cliente->email_registado($email)) {
            $_SESSION["erro"] = "O email já se encontra registado";
        }

        if (!empty($_SESSION["erro"])) {
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


        $purl = Store::criarHash(APP_PURL_LENGTH);

        if (!$cliente->registar_novo_cliente($purl)) {
            $_SESSION["erro"] = "Erro no registo!";
            return;
        }



        $linkPurl = APP_BASE_URL . "?a=confirmar_email&purl=$purl";

        $toEmail = "andytod80@gmail.com";
        $toName = "AndreGP";
        $subject = "Email de teste";
        $body = "<h2>Benvindo à " . APP_NAME . "</h2>";
        $body .= "<p><a href=$linkPurl>Clique para confirmar o seu registo!</a></p>";

        $mail = new Email();

        if (!$mail->enviar_email_confirmacao_novo_cliente($toEmail, $toName, $subject, $body)) {
            $_SESSION["erro"] = "Erro no registo!";
            return;
        }

        $layouts = [
            "layouts/htmlHeader",
            "layouts/header",
            "registo_sucesso",
            "layouts/footer",
            "layouts/htmlFooter",
        ];

        Store::carregarView($layouts);
        return;

    }

    public function confirmarEmail()
    {

        //valida se cliente já está logado
        if (Store::clienteLogado() || empty($_GET['purl'])) {
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

        if (!empty($_GET['purl']) && (mb_strlen($_GET['purl']) != APP_PURL_LENGTH)) {
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

        //Sanitize do purl vindo do $_GET
        $purl = filter_input(INPUT_GET, "purl", FILTER_SANITIZE_STRING);

        //verificar na bd se existe algum purl igual ao que foi gerado e faz update do registo na bd
        $cliente = new Cliente();



        if (!$cliente->validar_utilizador_apos_registo($purl)) {

            Store::redirect();
        }

        $layouts = [
            "layouts/htmlHeader",
            "layouts/header",
            "conta_confirmada_sucesso",
            "layouts/footer",
            "layouts/htmlFooter",
        ];

        Store::carregarView($layouts);
        return;

    }

    public function login() {
        if(Store::clienteLogado()) {
            $_SESSION["erro"] = "Já existe um cliente logado!";
        }

        $layouts = [
            "layouts/htmlHeader",
            "layouts/header",
            "login",
            "layouts/footer",
            "layouts/htmlFooter",
        ];

        Store::carregarView($layouts);
        return;
    }

    public function validarLogin() {
        // validar se existe já uma sessão logada
        // validar se existe um post com os dados de email e password
        // validar se o email enviado no form corresponde a 1 registo na bd
        // validar se o registo recuperado tem o estado ativo = 1
        // validar se a password corresponde após de usar o hash
        // criar uma sessão com o id do user
        // reencaminhar para a página de inicio


        //$_SESSION["cliente"] = "andre"; -> apagar


        // validar se existe já uma sessão logada
        if(Store::clienteLogado()) {
            $_SESSION["erro"] = "Já existe um cliente logado!";
            Store::redirect("login");
        }

        //var_dump(Store::clienteLogado(), $_SESSION);

        // validar se existe um post com os dados de email e password
        if(empty($_POST)) {
            $_SESSION["erro"] = "Não existem dados de login";
            echo "Não existem dados de login";
            return;
        }

        if(empty($_POST["text_email"]) || empty($_POST["text_senha_1"])) {
            $_SESSION["erro"] = "Email ou senha inválidos";
            echo "Email ou senha inválidos";
            return;
        }

        // validar se o email enviado no form corresponde a 1 registo na bd
        $cliente = new Cliente();

        $dados_login = [
            "email" => $_POST["text_email"],
            "senha" => $_POST["text_senha_1"]
        ];

        if(!$cliente->validar_login($dados_login)){
            $_SESSION["erro"] = "Email ou senha inválidos";
            echo "Erro ao validar cliente";
            return;
        }


        Store::redirect("loja");
        //echo "Login com sucesso!!!";
    }

    public function logout()
    {
        $_SESSION["cliente"] = null;
        Store::redirect("");
    }

}