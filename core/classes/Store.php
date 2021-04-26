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
        if (!is_array($layouts)) {
            throw new \Exception("O primeiro argummento da funcao tem de ser um array");
        }

        if (!empty($dados)) {
            extract($dados);
        }

        foreach ($layouts as $layout) {
            include(__DIR__ . "/../views/$layout.php");
        }
    }

    /**
     * @return bool
     */
    public static function clienteLogado(): bool
    {
        return isset($_SESSION["cliente"]);
    }

    /**
     * @return bool
     */
    public static function adminLogado(): bool
    {
        return isset($_SESSION["admin_id"]);
    }

    /**
     * @param int $numCaracteres
     * @return string
     */
    public static function criarHash(int $numCaracteres = 12): string
    {
        $chars = "0123456789qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM0123456789qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM";
        $hash = str_shuffle($chars);
        $offset = rand(0, mb_strlen($hash) - ($numCaracteres + 1));
        $hash = substr($hash, $offset, $numCaracteres);
        return $hash;
    }


    /**
     * @param string $rota
     * @param bool $admin
     */
    public static function redirect(string $rota = "", bool $admin = false): void
    {
        $rota = empty($rota) ? "" : "?a=$rota";
        if(!$admin) {
            header("Location: " . APP_BASE_URL . $rota);
        }else{
            header("Location: " . APP_BASE_URL . "admin/" . $rota);
        }
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public static function valida_user_em_sessao(): bool
    {
        if (!self::clienteLogado()) {
            return false;
        }

        $db = new DataBase();
        $cliente = $db->select("SELECT id_cliente FROM clientes WHERE id_cliente = :id_cliente",
            ["id_cliente" => $_SESSION["cliente"]]);
        if (count($cliente) != 1) {
            return false;
        }

        return true;
    }

    /**
     * @return string
     */
    public static function gerar_codigo_encomenda(): string
    {
        $chars = "QWERTYUIOPASDFGHJKLZXCVBNMQWERTYUIOPASDFGHJKLZXCVBNMQWERTYUIOPASDFGHJKLZXCVBNM";

        $codigo = str_shuffle($chars);
        $codigo = substr($codigo, 0, 2);

        $codigo .= rand(100000, 999999);

        return $codigo;
    }

    /**
     * @param $valor
     * @return string
     */
    public static function aesEncriptar($valor): string
    {
        $valor_encriptado = bin2hex(openssl_encrypt($valor, "aes-256-cbc", APP_AES_KEY, OPENSSL_RAW_DATA, APP_AES_IV));
        return $valor_encriptado;
    }

    /**
     * @param $valor
     * @return string
     */
    public static function aesDesencriptar($valor): string
    {
        $valor_desencriptado = openssl_decrypt(hex2bin($valor), "aes-256-cbc", APP_AES_KEY, OPENSSL_RAW_DATA, APP_AES_IV);
        return $valor_desencriptado;
    }

}