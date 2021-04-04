<?php

namespace core\controllers;

use core\classes\Store;


/**
 * Class Main
 * @package core\controllers
 */
class Main
{

    /**
     * @throws \Exception
     */
    public function index(){
        //preparar o layout
        $layouts = [
            "layouts/htmlHeader",
            "layouts/header",
            "inicio",
            "layouts/footer",
            "layouts/htmlFooter"
        ];

        Store::carregarView($layouts);
    }

    /**
     * @throws \Exception
     */
    public function loja(){
        if(empty($_SESSION["cliente"])) {
            Store::redirect();
        }

        //preparar as views
        $layouts = [
            "layouts/htmlHeader",
            "layouts/header",
            "loja",
            "layouts/footer",
            "layouts/htmlFooter"
        ];

        Store::carregarView($layouts);
    }

    /**
     * @throws \Exception
     */
    public function carrinho() {
        $layouts = [
            "layouts/htmlHeader",
            "layouts/header",
            "carrinho",
            "layouts/footer",
            "layouts/htmlFooter",
        ];

        Store::carregarView($layouts);
    }

    /**
     * @throws \Exception
     */
    public function novoCliente()
    {
        //verifica se já existe cliente logado (sessão aberta)
        if(!Store::clienteLogado()) {
            $layouts = [
                "layouts/htmlHeader",
                "layouts/header",
                "registo",
                "layouts/footer",
                "layouts/htmlFooter",
            ];

            Store::carregarView($layouts);
        }else{
            $this->index();
            return;
        }
    }
}