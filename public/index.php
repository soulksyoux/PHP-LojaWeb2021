<?php

    //uses para os namespaces
    use \core\classes\DataBase;
    use core\classes\Store;


//abrir a sessao
    session_start();


    //carregar o autoload
    require_once "../vendor/autoload.php";

    //$db = new DataBase();
    //$clientes = $db->select("SELECT * FROM clientes");
    //var_dump($clientes[0]-

    /*
    if($db->insert("INSERT INTO clientes (nome) VALUES (:nome);", ["nome" => "Joana"])) {
        echo "Cliente inserido com sucesso!";
    }
    */

    /*
    if($update = $db->update("UPDATE clientes SET nome = :nome1 WHERE nome LIKE '%Ma%'", ["nome1" => "Manuel"])) {
        echo "Foram atualizados: $update registos.";
    };
    */

    /*
    if($delete = $db->delete("DELETE FROM clientes WHERE nome = :nome", ["nome" => "Manuel"])) {
        var_dump($delete);
    }
    */

    //$stmt = $db->statement("TRUNCATE clientes");



    //Carregar o sistema de rotas
    require_once "../core/rotas.php";



?>