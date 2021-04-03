<?php

namespace core\classes;

class Store
{


    /**
     * @param array $layouts
     * @param array|null $dados
     * @throws \Exception
     */
    public static function carregarView(array $layouts, array $dados = null): void
    {
        //valida se estruturas à um array
        if(!is_array($layouts)) {
            throw new \Exception("O primeiro argummento da funcao tem de ser um array");
        }

        if(!empty($dados)) {
            extract($dados);
        }

        foreach ($layouts as $layout) {
            include (__DIR__ . "/../views/$layout.php");
        }
    }

    /**
     * @return bool
     */
    public static function clienteLogado(): bool {
        return isset($_SESSION["cliente"]);
    }

    /**
     * @param int $numCaracteres
     * @return string
     */
    public static function criarHash(int $numCaracteres = 12): string {
        $chars = "0123456789qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM0123456789qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM!#$%&?!#$%&?";
        $hash = str_shuffle($chars);
        $offset = rand(0, mb_strlen($hash) - ($numCaracteres + 1));
        $hash = substr($hash,$offset, $numCaracteres);
        return $hash;
    }

}