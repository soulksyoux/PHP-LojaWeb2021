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

        $layouts = [
            "layouts/htmlHeader",
            "layouts/header",
            "carrinho",
            "layouts/footer",
            "layouts/htmlFooter",
        ];

        Store::carregarView($layouts);
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


    public function limparCarrinho() {
        unset($_SESSION["carrinho"]);
        $this->carrinho();
    }
}