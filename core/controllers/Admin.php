<?php


namespace core\controllers;
use core\classes\Store;

class Admin
{
    public function index()
    {
        //$_SESSION["admin"] = "aa";

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
        echo "Login";
    }

    public function listaClientes() {
        echo "Lista de clientes";
    }
}