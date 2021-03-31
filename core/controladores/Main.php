<?php

namespace core\controladores;

use core\classes\Store;

class Main
{
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

    public function loja(){
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
}