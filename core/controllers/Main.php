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
                $produto_model = new Produto();
                $produtos_encomenda = $produto_model->lista_produtos_de_encomenda($encomenda->id_encomenda);

                $total = $this->getPrecoTotalEncomenda($produtos_encomenda);
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

    private function getPrecoTotalEncomenda(array $produtos_encomenda): int {
        $total = 0;

        foreach ($produtos_encomenda as $produto) {
            $total += $produto->preco_unitario * $produto->quantidade;
        }

        return $total;
    }

    public function verDetalheEncomenda()
    {
        if(!Store::clienteLogado() || !Store::valida_user_em_sessao()) {
            $_SESSION["erro"] = "User tem de estar logado";
            Store::redirect("login");
            return;
        }

        $id_encomenda = $a = filter_input(INPUT_GET, 'id_encomenda');

        if(!empty($id_encomenda) && mb_strlen($id_encomenda) != 32) {
            $_SESSION["erro"] = "Id encomenda invalido";
            Store::redirect("inicio");
            return;
        }

        $id_encomenda = Store::aesDesencriptar($id_encomenda);

        //obter encomenda
        $encomenda_model = new Encomenda();
        $encomenda = $encomenda_model->obter_encomenda_por_id($id_encomenda)[0];

        if(!$encomenda) {
            $_SESSION["erro"] = "Encomenda não existente no sistema";
            Store::redirect("inicio");
            return;
        }

        //validar se a encomenda pertence ao utilizador logado
        if($encomenda->id_cliente != $_SESSION["cliente"]) {
            $_SESSION["erro"] = "Sem permissão de acesso à encomenda, deve se logar com outro user";
            Store::redirect("inicio");
            return;
        }

        $produto_model = new Produto();
        $produtos_encomenda = $produto_model->lista_produtos_de_encomenda($id_encomenda);

        $total = $this->getPrecoTotalEncomenda($produtos_encomenda);
        $encomenda->total = $total;

        //apresentar detalhe da encomenda XPTO
        $layouts = [
            "layouts/htmlHeader",
            "layouts/header",
            "detalhe_encomenda",
            "layouts/footer",
            "layouts/htmlFooter",
        ];

        Store::carregarView($layouts, ["encomenda" => $encomenda, "produtos_encomenda" => $produtos_encomenda]);

    }

    public function pagamento()
    {
        //verificar se vem o código da encomenda
        $cod_encomenda = filter_input(INPUT_GET, 'cod_encomenda');

        if(empty($cod_encomenda)) {
            $_SESSION["erro"] = "Cod de encomenda esta a vazio";
            Store::redirect("inicio");
            return;
        }

        $cod_encomenda = Store::aesDesencriptar($cod_encomenda);

        //verificar se o estado da encomenda esta pendente
        $encomenda_model = new Encomenda();
        $encomenda = $encomenda_model->obter_encomenda_por_cod($cod_encomenda);

        if(empty($encomenda)) {
            $_SESSION["erro"] = "Encomenda n existe";
            Store::redirect("inicio");
            return;
        }

        if($encomenda[0]->status != "iniciada") {
            $_SESSION["erro"] = "Status de encomenda invalido";
            Store::redirect("inicio");
            return;
        }

        //alterar estado da encomenda de pendente para em processamento
        $encomenda_nova = $encomenda_model->update_estado_encomenda($cod_encomenda, "processamento");

        if(!$encomenda_nova) {
            $_SESSION["erro"] = "Problema ao processar o pagamento da encomenda";
            Store::redirect("inicio");
            return;
        }

        $layouts = [
            "layouts/htmlHeader",
            "layouts/header",
            "pagamento_encomenda_sucesso",
            "layouts/footer",
            "layouts/htmlFooter",
        ];

        Store::carregarView($layouts);
    }
}