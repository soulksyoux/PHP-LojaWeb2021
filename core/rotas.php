<?php


//coleção de rotas
$rotas = [
    "inicio" => "main@index",
    "loja" => "main@loja",
    "loja" => "main@loja",
    "novo-cliente" => "main@novoCliente",

    "carrinho" => "carrinho@carrinho",
    "adicionar_carrinho" => "carrinho@adicionarCarrinho",
    "limpar_carrinho" => "carrinho@limparCarrinho",
    "diminuir_qtd_item" => "carrinho@diminuirQtdItem",

    "registar_user" => "auth@registarUser",
    "confirmar_email" => "auth@confirmarEmail",
    "login" => "auth@login",
    "login_user" => "auth@validarLogin",
    "logout" => "auth@logout",
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
$controlador = 'core\\controllers\\' . ucfirst($partes[0]);
$metodo = $partes[1];



$controlador = new $controlador();
$controlador->$metodo();






