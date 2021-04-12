<?php


namespace core\controllers;

use core\classes\Store;
use core\models\Produto;

class Carrinho
{
    /**
     * @throws \Exception
     */
    public function carrinho() {

        //montar carrinho com dados apartir da bd

        $carrinho = [];

        if(!empty($_SESSION["carrinho"])) {
            foreach ($_SESSION["carrinho"] as $key => $qtd) {

                $produtos = new Produto();
                $find = $produtos->get_produto_by_id($key);

                if(!empty($find) && $qtd >= 1) {
                    array_push($carrinho, [
                        "id_produto" => $find->id_produto,
                        "nome_produto" => $find->nome_produto,
                        "preco" => $find->preco,
                        "imagem" => $find->imagem,
                        "quantidade" => $_SESSION["carrinho"][$key]
                    ]);
                }
            }
        }

        $layouts = [
            "layouts/htmlHeader",
            "layouts/header",
            "carrinho",
            "layouts/footer",
            "layouts/htmlFooter",
        ];

        Store::carregarView($layouts, ["carrinho" => $carrinho]);
    }


    public function adicionarCarrinho()
    {

        $id_produto = $_GET['id_produto'];

        $produtos = new Produto();
        $resultado = $produtos->validar_stock($id_produto);
        if(!$resultado) {
            $total_aux = 0;
            if(!empty($_SESSION["carrinho"])) {
                foreach ($_SESSION["carrinho"] as $qtd) {
                    $total_aux += $qtd;
                }
            }
            echo $total_aux == 0 ? "" : $total_aux;
            return;
        }

        // adiciona/gestão da variável de SESSAO do carrinho
        $carrinho = [];

        if(isset($_SESSION['carrinho'])){
            $carrinho = $_SESSION['carrinho'];
        }

        // adicionar o produto ao carrinho
        if(key_exists($id_produto, $carrinho)){

            // já existe o produto. Acrescenta mais uma unidade
            $carrinho[$id_produto]++;

        } else {

            // adicionar novo produto ao carrinho
            $carrinho[$id_produto] = 1;
        }

        // atualiza os dados do carrinho na sessão
        $_SESSION['carrinho'] = $carrinho;

        // devolve a resposta (número de produtos do carrinho)
        $total_produtos = 0;
        foreach($carrinho as $quantidade){
            $total_produtos += $quantidade;
        }
        echo $total_produtos;
    }

    public function diminuirQtdItem()
    {
        if(empty($_GET["id_produto"])) {
            return;
        }

        $id_produto = $_GET["id_produto"];

        //diminuir a quantidade em 1 na session correspondente ao id do produto passado
        if(!empty($_SESSION["carrinho"][$id_produto]) && $_SESSION["carrinho"][$id_produto] > 0) {
            $_SESSION["carrinho"][$id_produto]--;
        }

        $quantidade = 0;
        if(!empty($_SESSION["carrinho"])) {
            foreach ($_SESSION["carrinho"] as $qtd) {
                $quantidade += $qtd;
            }
        }

        echo json_encode(["carrinho" => $_SESSION["carrinho"], "quantidade" => $quantidade]);

    }

    public function aumentarQtdItemCarrinho()
    {

        if(empty($_GET["id_produto"])) {
            return;
        }

        $id_produto = $_GET["id_produto"];


        if(empty($_SESSION["carrinho"][$id_produto])) {
            return;
        }

        $_SESSION["carrinho"][$id_produto]++;

        header("Location: " . APP_BASE_URL . "?a=carrinho");
    }

    public function limparCarrinho() {
        unset($_SESSION["carrinho"]);
        $this->carrinho();
    }



}