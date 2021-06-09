<?php


//coleção de rotas
$rotas = [
    "inicio" => "admin@index",
    "admin-login" => "admin@adminLogin",
    "submeter_login_admin" => "admin@submeterLoginAdmin",
    "lista-clientes" => "admin@listaClientes",
    "logout-admin" => "admin@logoutAdmin",

    //encomendas
    "lista-encomendas" => "admin@listaEncomendas",
    "filtrar-status" => "admin@filtrarStatus",
    "ver-encomendas-cliente" => "admin@verEncomendasCliente",
    "detalhe_encomenda" => "admin@detalheEncomenda",
    "alterar_estado_encomenda" => "admin@alterarEstadoEncomenda",
    "imprimir_pdf" => "admin@imprimir_pdf",

    //clientes
    "lista-clientes" => "admin@listaClientes",
    "detalhe-cliente" => "admin@detalheCliente",

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






