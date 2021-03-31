<?php

//coleção de rotas
$rotas = [
    "inicio" => "main@index",
    "loja" => "main@loja",
    "carrinho" => "main@carrinho"
];

//define ação por padrão
$acao = "inicio";

//verifica se existe a acao na query string
if(isset($_GET['a'])) {
    //verifica se a acao existe nas rotas
    if(!key_exists($_GET["a"], $rotas)) {
        $acao = "inicio";
    }else {
        $acao = $_GET["a"];
    }
}


//trata a definicao de rota
$partes = explode("@", $rotas[$acao]);
$controlador = 'core\\controladores\\' . ucfirst($partes[0]);
$metodo = $partes[1];

$controlador = new $controlador();
$controlador->$metodo();





