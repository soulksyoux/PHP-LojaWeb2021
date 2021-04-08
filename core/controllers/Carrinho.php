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
        //capturar o carrinho
        $carrinho = [];

        if(empty($_SESSION["carrinho"])) {
            $_SESSION["total"] = 0;
        }

        if(!empty($_SESSION["carrinho"])) {
            $carrinho = $_SESSION["carrinho"];
        }


        if(!empty($_GET["id_produto"])) {
            $id_produto = $_GET["id_produto"];
            if(empty($carrinho[$id_produto])) {
                $carrinho[$id_produto] = 1;
            }elseif($carrinho[$id_produto] >= 1) {
                $carrinho[$id_produto]++;
            }
        }

        $total = 0;
        foreach ($carrinho as $produto_qtd) {
            $total += $produto_qtd;
        }

        $_SESSION["carrinho"] = $carrinho;
        echo $total;
    }
}