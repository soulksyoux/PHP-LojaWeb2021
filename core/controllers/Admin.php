<?php


namespace core\controllers;
use core\classes\Store;
use core\models\Administrador;

class Admin
{
    public function index()
    {

        if(!Store::adminLogado()) {
            Store::redirect("admin-login", true);
            return;
        }

        $layouts = [
            "admin/layouts/htmlHeader",
            "admin/layouts/header",
            "admin/home",
            "admin/layouts/footer",
            "admin/layouts/htmlFooter",
        ];

        Store::carregarView($layouts);
    }

    public function adminLogin()
    {

        if(Store::adminLogado()) {
            Store::redirect("inicio", true);
            return;
        }

        $layouts = [
            "admin/layouts/htmlHeader",
            "admin/layouts/header",
            "admin/login",
            "admin/layouts/footer",
            "admin/layouts/htmlFooter",
        ];

        Store::carregarView($layouts);
    }

    public function submeterLoginAdmin() {

        if(empty($_POST)) {
            $_SESSION["erro"] = "dados invalidos";
            Store::redirect("admin-login", true);
            return;
        }

        //validar se o post password 1 e 2 não estão vazios
        if(empty($_POST["text_email_admin"]) || empty($_POST["text_senha"])) {
            $_SESSION["erro"] = "os dados tem de estar preenchidos";
            Store::redirect("admin-login", true);
            return;
        }

        $email = trim(strtolower($_POST["text_email_admin"]));
        $password = trim($_POST["text_senha"]);

        //validar se o email é válido
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION["erro"] = "o email é invalido";
            Store::redirect("admin-login", true);
            return;
        }

        //validar se a senha tem mais de 3 caracteres
        if(mb_strlen($password) < 4) {
            $_SESSION["erro"] = "A senha tem de ter mais de 3 caracteres";
            Store::redirect("admin-login", true);
            return;
        }

        $admin_model = new Administrador();
        $admin = $admin_model->obterAdminPorEmail($email);

        //validar se o email existe na BD

        if(!$admin) {
            $_SESSION["erro"] = "administrador não registado na bd";
            Store::redirect("admin-login", true);
            return;
        }

        //validar se password é valida

        if(!password_verify($password, $admin->senha)) {
            $_SESSION["erro"] = "senha de administrador invalida";
            Store::redirect("admin-login", true);
            return;
        }

        //gravar na sessao o admin
        $_SESSION["admin_id"] = $admin->id_administrador;
        $_SESSION["admin_user"] = $admin->utilizador;

        $layouts = [
            "admin/layouts/htmlHeader",
            "admin/layouts/header",
            "admin/home",
            "admin/layouts/footer",
            "admin/layouts/htmlFooter",
        ];

        Store::carregarView($layouts);
    }

    public function logoutAdmin()
    {
        unset($_SESSION["admin"]);
        Store::redirect("admin-login", true);
    }

    public function listaClientes() {
        echo "Lista de clientes";
    }
}