<?php

namespace core\models;

use core\classes\DataBase;

class Encomenda
{
    public function gravar_encomenda($dados_encomenda, $produtos_carrinho): bool
    {
        $db = new DataBase();


        $encomenda = $db->insert("INSERT INTO 
            encomendas 
            (id_cliente, morada, cidade, telefone, cod_encomenda, status, mensagem) 
            VALUES (:id_cliente, :morada, :cidade, :telefone, :cod_encomenda, :status, :mensagem)", $dados_encomenda);

        if(!$encomenda) {
            return false;
        }

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

            if(!$encomenda_produto) {
                return false;
            }
        }

        return true;
    }

    public function obter_encomendas_cliente($id_cliente): ?array {

        $params = [
            "id_cliente" => $id_cliente
        ];

        $db = new DataBase();
        $encomendas = $db->select("SELECT * FROM encomendas WHERE id_cliente = :id_cliente", $params);

        return $encomendas;
    }

    public function obter_encomenda_por_id($id_encomenda): ?array {
        $params = [
            "id_encomenda" => $id_encomenda
        ];

        $db = new DataBase();
        $encomenda = $db->select("SELECT * FROM encomendas WHERE id_encomenda = :id_encomenda", $params);

        return $encomenda;
    }


}