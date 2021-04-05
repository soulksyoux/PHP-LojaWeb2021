<?php


namespace core\models;

use core\classes\DataBase;
use core\classes\Store;

class Produto
{
    public function lista_produtos(): ?array
    {
        $db = new DataBase();

        try {
            $produtos = $db->select("SELECT * FROM produtos WHERE visivel = 1 AND stock > 0 AND delected_at IS NULL");
        } catch (\Exception $e) {
            echo "Erro ao recuperar produtos da bd";
            return null;
        }

        if(!count($produtos) > 0) {
            return null;
        }

        return $produtos;
    }
    
}