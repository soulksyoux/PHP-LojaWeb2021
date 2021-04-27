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
        $encomendas = $db->select("SELECT * FROM encomendas WHERE id_cliente = :id_cliente ORDER BY data_encomenda DESC", $params);

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

    public function obter_encomenda_por_cod($cod_encomenda): ?array {
        $params = [
            "cod_encomenda" => $cod_encomenda
        ];

        $db = new DataBase();
        $encomenda = $db->select("SELECT * FROM encomendas WHERE cod_encomenda = :cod_encomenda", $params);

        return $encomenda;
    }

    public function update_estado_encomenda(string $cod_encomenda, string $estado): bool
    {
        $params = [
            "cod_encomenda" => $cod_encomenda,
            "status" => $estado,
        ];

        $db = new DataBase();
        $encomenda = $db->update("UPDATE encomendas SET status = :status WHERE cod_encomenda = :cod_encomenda", $params);

        if(!$encomenda) {
            return false;
        }

        return true;

    }

    public function obter_encomendas_por_estado(string $estado): ?array
    {
        $params = [
            "status" => $estado
        ];

        $db = new DataBase();
        $encomendas = $db->select("SELECT * FROM encomendas WHERE status = :status", $params);


        if(count($encomendas) <= 0) {
            return null;
        }

        return $encomendas;

    }


}