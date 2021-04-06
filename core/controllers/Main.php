<?php

namespace core\controllers;

use core\classes\Store;
use core\models\Produto;


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

        //valida se existe user na sessao
        if(!Store::clienteLogado() || !Store::valida_user_em_sessao()) {
            Store::redirect();
            return;
        }

        //analisa que categoria mostra

        $produtos = new Produto();

        if($_SERVER['REQUEST_METHOD'] == 'GET' && !empty($_GET['c'])) {
            $produtos = $produtos->lista_produtos($_GET['c']);
        }else{
            $produtos = $produtos->lista_produtos();
        }

        //preparar as views
        $layouts = [
            "layouts/htmlHeader",
            "layouts/header",
            "loja",
            "layouts/footer",
            "layouts/htmlFooter"
        ];

        Store::carregarView($layouts, ["produtos" => $produtos]);
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