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
        $dados = [
            "titulo" => APP_NAME . " " . APP_VERSION,
            "nomes" => ["andre", "vitor", "miguel", "filipe"]
        ];
        Store::carregarView($layouts, $dados);
    }

    public function loja(){
        //preparar as views
        $layouts = [
            "layouts/htmlHeader",
            "loja",
            "layouts/htmlFooter"
        ];
        $dados = [
            "titulo" => "Loja",
            "loja" => "Loja do Quim"
        ];
        Store::carregarView($layouts, $dados);
    }
}