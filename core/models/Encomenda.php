<?php

namespace core\models;

use core\classes\DataBase;

class Encomenda
{
    public function gravar_encomenda($dados_encomenda, $produtos_carrinho)
    {
        $db = new DataBase();

        var_dump($dados_encomenda);


        $encomenda = $db->insert("INSERT INTO 
            encomendas 
            (id_cliente, morada, cidade, telefone, cod_encomenda, status, mensagem) 
            VALUES (:id_cliente, :morada, :cidade, :telefone, :cod_encomenda, :status, :mensagem)", $dados_encomenda);

        $encomenda_lastId = $db->getLastId();

        foreach ($produtos_carrinho as $produto) {

            $params = [
                "id_encomenda" => $encomenda_lastId,
                "designacao_produto" => $produto["nome_produto"],
                "preco_unitario" => $produto["preco"],
                "quantidade" => $produto["quantidade"],
            ];


            $encomenda_produto = $db->insert("INSERT INTO
                        encomenda_produto
                        (id_encomenda, designacao_produto, preco_unitario, quantidade) 
                        VALUES (:id_encomenda, :designacao_produto, :preco_unitario, :quantidade)", $params);
        }


        die();

    }
}