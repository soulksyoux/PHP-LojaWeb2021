<?php

namespace core\controllers;

use core\classes\Store;
use core\models\Cliente;
use core\models\Encomenda;
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

        $categorias = $produtos->lista_categorias();

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

        Store::carregarView($layouts, ["produtos" => $produtos, "categorias" => $categorias]);
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

    public function verConta()
    {
        if(!Store::clienteLogado()) {
            Store::redirect("login");
            return;
        }

        $layouts = [
            "layouts/htmlHeader",
            "layouts/header",
            "gerir_conta",
            "layouts/footer",
            "layouts/htmlFooter",
        ];

        Store::carregarView($layouts);

    }

    public function verEncomendas() {

        //verifica se cliente logado
        if(!Store::clienteLogado() || !Store::valida_user_em_sessao()) {
            Store::redirect("login");
            return;
        }

        //obter as encomendas do cliente logado
        $encomenda_model = new Encomenda();
        $encomendas = $encomenda_model->obter_encomendas_cliente($_SESSION["cliente"]);

        //calcular o total para cada encomenda e acrescentar ao array
        if(count($encomendas) > 0) {

            foreach ($encomendas as $key => $encomenda) {
                //obter produtos para a encomenda
                $total = 0;
                $produto_model = new Produto();
                $produtos_encomenda = $produto_model->lista_produtos_de_encomenda($encomenda->id_encomenda);

                foreach ($produtos_encomenda as $produto) {
                    $total += $produto->preco_unitario * $produto->quantidade;
                }

                $encomendas[$key]->total = $total;
            }
        }

        $layouts = [
            "layouts/htmlHeader",
            "layouts/header",
            "ver_encomendas",
            "layouts/footer",
            "layouts/htmlFooter",
        ];

        Store::carregarView($layouts, ["encomendas" => $encomendas]);
    }

    public function verDetalheEncomenda()
    {
        $id_encomenda = $a = filter_input(INPUT_GET, 'id_encomenda');
        var_dump($id_encomenda);

        //apresentar detalhe da encomenda XPTO
        die();
    }
}