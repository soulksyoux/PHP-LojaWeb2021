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
            Store::redirect("novo-cliente");
            return;
        }

        //valida se a senha tem mais de 4 caracteres
        if(mb_strlen($_POST["text_senha_1"]) < 4) {
            $_SESSION["erro"] = "A senha tem de ter mais de 3 caracteres";
            Store::redirect("novo-cliente");
            return;
        }

        //valida se a senha 1 é igual à senha de confirmação 2
        if ($_POST['text_senha_1'] !== $_POST['text_senha_2']) {
            $_SESSION["erro"] = "As senhas nao sao iguais";
            Store::redirect("novo-cliente");
            return;
        }

        //valida se o user já existe na bd

        $cliente = new Cliente();
        $email = $_POST["text_email"];

        if ($cliente->email_registado($email)) {
            $_SESSION["erro"] = "O email já se encontra registado";
            Store::redirect("novo-cliente");
            return;
        }


        $purl = Store::criarHash(APP_PURL_LENGTH);

        if (!$cliente->registar_novo_cliente($purl)) {
            $_SESSION["erro"] = "Erro no registo!";
            Store::redirect("novo-cliente");
            return;
        }

        $linkPurl = APP_BASE_URL . "?a=confirmar_email&purl=$purl";

        $toEmail = "andytod80@gmail.com";
        $toName = "AndreGP";
        $subject = "Email de teste";
        $body = "<h2>Benvindo à " . APP_NAME . "</h2>";
        $body .= "<p><a href=$linkPurl>Clique para confirmar o seu registo!</a></p>";

        $mail = new Email();

        if (!$mail->enviar_email($toEmail, $toName, $subject, $body)) {
            $_SESSION["erro"] = "Erro no registo!";
            Store::redirect("novo-cliente");
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
            Store::redirect();
            return;
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
            Store::redirect("");
            return;
        }

        //var_dump(Store::clienteLogado(), $_SESSION);

        // validar se existe um post com os dados de email e password
        if($_SERVER["REQUEST_METHOD"] != 'POST') {
            Store::redirect("");
            return;
        }

        if(empty($_POST["text_email"]) || empty($_POST["text_senha_1"]) || !filter_var(trim($_POST["text_email"]), FILTER_VALIDATE_EMAIL)) {
            $_SESSION["erro"] = "Dados de login inválidos!!";
            Store::redirect("login");
            return;
        }

        // validar se o email enviado no form corresponde a 1 registo na bd
        $cliente = new Cliente();

        $dados_login = [
            "email" => strtolower(trim($_POST["text_email"])),
            "senha" => $_POST["text_senha_1"]
        ];

        if(!$cliente->validar_login($dados_login)){
            $_SESSION["erro"] = "Dados de login inválidos!!";
            Store::redirect("login");
            return;
        }

        //echo "Login com sucesso!!!";
        if(isset($_SESSION["tmp_carrinho"]) && $_SESSION["tmp_carrinho"] == true) {
            unset($_SESSION["tmp_carrinho"]);
            Store::redirect("finalizar_encomenda_resumo");
        }else{
            Store::redirect("loja");
        }

    }

    public function alterarDadosPessoais()
    {
        if(!Store::clienteLogado()) {
            Store::redirect("login");
            return;
        }

        $cliente = new Cliente();
        $cliente = $cliente->recuperaClienteById($_SESSION["cliente"]);


        $layouts = [
            "layouts/htmlHeader",
            "layouts/header",
            "alterar_dados_pessoais",
            "layouts/footer",
            "layouts/htmlFooter",
        ];

        Store::carregarView($layouts, ["cliente" => $cliente]);
    }

    public function gravarDadosPessoais() {

        if(empty($_SESSION["cliente"])) {
            $_SESSION["erro"] = "necessário user logado";
            Store::redirect("login");
            return;
        }

        if(empty($_POST)){
            $_SESSION["erro"] = "post vazio";
            Store::redirect("alterar_dados_pessoais");
            return;
        }

        if(empty($_POST['text_email']) || empty($_POST['text_nome_completo']) || empty($_POST['text_morada']) || empty($_POST['text_cidade'])){
            $_SESSION["erro"] = "campos necessários a vazio";
            Store::redirect("alterar_dados_pessoais");
            return;
        }

        $cliente_model = new Cliente();
        $cliente = $cliente_model->recuperaClienteById($_SESSION["cliente"]);

        if(
            !empty($cliente) &&
            $_POST['text_email'] == $cliente->email &&
            $_POST["text_nome_completo"] == $cliente->nome &&
            $_POST["text_morada"] == $cliente->morada &&
            $_POST["text_cidade"] == $cliente->cidade &&
            $_POST["text_telefone"] == $cliente->telefone) {
            $_SESSION["erro"] = "não houve alteração de valores";
            Store::redirect("alterar_dados_pessoais");
            return;
        }

        $cliente = $cliente_model->update_cliente($_SESSION["cliente"], $_POST);

        if(!$cliente) {
            Store::redirect("alterar_dados_pessoais");
            return;
        }

        $_SESSION["cliente_nome"] = $_SESSION["cliente_nome"] != $_POST["text_nome_completo"] ? $_POST["text_nome_completo"] : $_SESSION["cliente_nome"];
        $_SESSION["cliente_email"] = $_SESSION["cliente_email"] != $_POST["text_email"] ? $_POST["text_email"] : $_SESSION["cliente_email"];

        $layouts = [
            "layouts/htmlHeader",
            "layouts/header",
            "alteracao_dados_sucesso",
            "layouts/footer",
            "layouts/htmlFooter",
        ];

        Store::carregarView($layouts, ["cliente" => $cliente]);

    }

    public function alterarPassword()
    {
        if(!Store::clienteLogado()) {
            $_SESSION["erro"] = "necessário user logado";
            Store::redirect("login");
            return;
        }

        $layouts = [
            "layouts/htmlHeader",
            "layouts/header",
            "alterar_password",
            "layouts/footer",
            "layouts/htmlFooter",
        ];

        Store::carregarView($layouts);
    }

    public function gravarPassword()
    {
        if(empty($_SESSION["cliente"])) {
            $_SESSION["erro"] = "necessário user logado";
            Store::redirect("login");
            return;
        }

        //validar se o post password 1 e 2 não estão vazios
        if(empty($_POST["text_password_atual"]) || empty($_POST["text_password"]) || empty(($_POST["text_password2"]))) {
            $_SESSION["erro"] = "As passwords tems de estar preenchidas";
            Store::redirect("alterar_password");
            return;
        }

        //validar se as duas passwords digitadas são iguais
        if($_POST["text_password"] != $_POST["text_password2"]) {
            $_SESSION["erro"] = "As passwords tem de ser iguais";
            Store::redirect("alterar_password");
            return;
        }

        //validar se a senha tem mais de 4 caracteres
        if(mb_strlen($_POST["text_password"]) < 4) {
            $_SESSION["erro"] = "A senha tem de ter mais de 3 caracteres";
            Store::redirect("alterar_password");
            return;
        }

        //aplicar um hash à password
        $password = password_hash(trim($_POST["text_password"]),PASSWORD_BCRYPT );

        //validar se a senha atual corresponde
        $cliente = new Cliente();
        $cliente_pass = $cliente->validarPassword($_SESSION["cliente"], $_POST["text_password_atual"]);
        if(!$cliente_pass) {
            $_SESSION["erro"] = "Senha atual incorreta";
            Store::redirect("alterar_password");
            return;
        }

        //validar se a nova senha é diferente da atual
        if($_POST["text_password_atual"] == $_POST["text_password"]) {
            $_SESSION["erro"] = "Senha atual tem de ser diferente da nova!";
            Store::redirect("alterar_password");
            return;
        }

        //guardar a password na bd
        $cliente = new Cliente();
        $cliente = $cliente->update_password($_SESSION["cliente"], $password);

        if(!$cliente) {
            $_SESSION["erro"] = "Erro ao efetuar a operacao";
            Store::redirect("alterar_password");
            return;
        }

        $layouts = [
            "layouts/htmlHeader",
            "layouts/header",
            "alteracao_password_sucesso",
            "layouts/footer",
            "layouts/htmlFooter",
        ];

        Store::carregarView($layouts);
    }


    public function logout()
    {
        $_SESSION["cliente"] = null;
        $_SESSION["cliente_email"] = null;
        $_SESSION["cliente_nome"] = null;
        Store::redirect("");
    }



}