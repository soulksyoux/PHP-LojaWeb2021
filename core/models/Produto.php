<?php


namespace core\models;

use core\classes\DataBase;
use core\classes\Store;

class Produto
{
    public function lista_produtos(string $categoria = 'todos'): ?array
    {
        $db = new DataBase();

        if($categoria != 'todos') {
            $params = ["categoria" => $categoria];
            $categoria = "AND categoria = :categoria";
        }else{
            $params = null;
            $categoria = "";
        }

        try {
            $produtos = $db->select("SELECT * FROM produtos WHERE visivel = 1 AND delected_at IS NULL " . $categoria, $params);
        } catch (\Exception $e) {
            echo "Erro ao recuperar produtos da bd";
            return null;
        }

        if(!count($produtos) > 0) {
            return null;
        }

        return $produtos;
    }

    public function lista_categorias(): array
    {
        $db = new DataBase();
        $find = $db->select("SELECT DISTINCT categoria FROM produtos");

        if(empty($find) || count($find) <= 0) {
            return [];
        }

        $categorias = [];
        foreach ($find as $categoria) {
            $categorias[] = $categoria->categoria;
        }

        return $categorias;
    }

    public function get_produto_by_id(int $id): ?\stdClass {

        if(empty($id)) {
            return null;
        }

        $db = new DataBase();
        $params = ["id" => $id];
        $find = $db->select("SELECT * FROM produtos WHERE id_produto = :id AND visivel = 1 AND delected_at IS NULL", $params);

        if(empty($find) || count($find) != 1) {
            return null;
        }

        return $find[0];
    }

    public function validar_stock(int $id): bool
    {
        $db = new DataBase();
        $params = ["id" => $id];

        $find = $db->select("SELECT * FROM produtos WHERE id_produto = :id AND visivel = 1 AND stock > 0 AND delected_at IS NULL", $params);
        if(empty($find)) {
            return false;
        }

        return true;
    }

    public function lista_produtos_de_encomenda($id_encomenda): ?array {

        $params = [
            "id_encomenda" => $id_encomenda,
        ];

        $db = new DataBase();
        $produtos = $db->select("SELECT * FROM encomenda_produto WHERE id_encomenda = :id_encomenda", $params);

        return $produtos;
    }


    
}