<?php


namespace core\controllers;
use core\classes\PDF;
use core\classes\Store;
use core\models\Administrador;
use core\models\Cliente;
use core\models\Encomenda;
use core\models\Produto;

class Admin
{
    public function index()
    {

        if(!Store::adminLogado()) {
            Store::redirect("admin-login", true);
            return;
        }

        //obter encomendas com estado pendente
        $encomenda_model = new Encomenda();
        $encomendas = $encomenda_model->obter_encomendas("pendente");
        $total_encomendas_pendentes = $encomenda_model->total_encomendas_por_estado("pendente");
        $total_encomendas_processamento = $encomenda_model->total_encomendas_por_estado("processamento");

        $data = [
            "total_encomendas_pendentes" => $total_encomendas_pendentes,
            "total_encomendas_processamento" => $total_encomendas_processamento,
        ];

        $layouts = [
            "admin/layouts/htmlHeader",
            "admin/layouts/header",
            "admin/home",
            "admin/layouts/footer",
            "admin/layouts/htmlFooter",
        ];

        Store::carregarView($layouts, $data);
    }

    public function adminLogin()
    {
        if(Store::adminLogado()) {
            Store::redirect("inicio", true);
            return;
        }


        $layouts = [
            "admin/layouts/htmlHeader",
            "admin/layouts/header",
            "admin/login",
            "admin/layouts/footer",
            "admin/layouts/htmlFooter",
        ];

        Store::carregarView($layouts);
    }

    public function submeterLoginAdmin() {

        if(empty($_POST)) {
            $_SESSION["erro"] = "dados invalidos";
            Store::redirect("admin-login", true);
            return;
        }

        //validar se o post password 1 e 2 não estão vazios
        if(empty($_POST["text_email_admin"]) || empty($_POST["text_senha"])) {
            $_SESSION["erro"] = "os dados tem de estar preenchidos";
            Store::redirect("admin-login", true);
            return;
        }

        $email = trim(strtolower($_POST["text_email_admin"]));
        $password = trim($_POST["text_senha"]);

        //validar se o email é válido
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION["erro"] = "o email é invalido";
            Store::redirect("admin-login", true);
            return;
        }

        //validar se a senha tem mais de 3 caracteres
        if(mb_strlen($password) < 4) {
            $_SESSION["erro"] = "A senha tem de ter mais de 3 caracteres";
            Store::redirect("admin-login", true);
            return;
        }

        $admin_model = new Administrador();
        $admin = $admin_model->obterAdminPorEmail($email);

        //validar se o email existe na BD

        if(!$admin) {
            $_SESSION["erro"] = "administrador não registado na bd";
            Store::redirect("admin-login", true);
            return;
        }

        //validar se password é valida

        if(!password_verify($password, $admin->senha)) {
            $_SESSION["erro"] = "senha de administrador invalida";
            Store::redirect("admin-login", true);
            return;
        }

        //gravar na sessao o admin
        $_SESSION["admin_id"] = $admin->id_administrador;
        $_SESSION["admin_user"] = $admin->utilizador;

        Store::redirect("inicio", true);
    }

    public function logoutAdmin()
    {
        unset($_SESSION["admin_id"]);
        unset($_SESSION["admin_user"]);
        Store::redirect("admin-login", true);
    }

    public function listaEncomendas() {

        if(!Store::adminLogado()) {
            Store::redirect("login", true);
            return;
        }

        $entradas_filtro = ["pendente" , "processamento", "cancelada", "enviada", "concluida"];

        $filtro = "";
        if(!empty($_GET["f"])) {
            if(in_array($_GET["f"], $entradas_filtro)) {
                $filtro = $_GET["f"];
            }
        }

        $id_cliente = "";
        if(!empty($_GET["id"]) && strlen($_GET["id"]) == 32) {
            $id_cliente = Store::aesDesencriptar($_GET["id"]);
        }

        //obter encomendas da base de dados baseadas no filtro
        $encomenda_model = new Encomenda();
        $encomendas = $encomenda_model->obter_encomendas($filtro, $id_cliente);

        $dados = [
            "encomendas" => $encomendas,
            "filtro" => $filtro,
        ];

        $layouts = [
            "admin/layouts/htmlHeader",
            "admin/layouts/header",
            "admin/encomendas",
            "admin/layouts/footer",
            "admin/layouts/htmlFooter",
        ];

        Store::carregarView($layouts, $dados);
    }

    public function listaClientes()
    {
        if(!Store::adminLogado()) {
            Store::redirect("login", true);
            return;
        }

        // recuperar os clientes
        $cliente_model = new Cliente();
        $clientes = $cliente_model->recuperarClientes();


        $dados = ["clientes" => $clientes];

        $layouts = [
            "admin/layouts/htmlHeader",
            "admin/layouts/header",
            "admin/clientes",
            "admin/layouts/footer",
            "admin/layouts/htmlFooter",
        ];

        Store::carregarView($layouts, $dados);

    }

    public function detalheCliente()
    {
        if(!Store::adminLogado()) {
            Store::redirect("login", true);
            return;
        }

        if(empty($_GET["i"])) {
            Store::redirect("lista-clientes", true);
            return;
        }

        $id_cliente = $_GET["i"];

        $cliente_model = new Cliente();
        $cliente = $cliente_model->recuperaClienteById($id_cliente);


        if(empty($cliente)) {
            Store::redirect("lista-clientes", true);
            return;
        }

        //recupera as encomendas do cliente
        $encomendas_model = new Encomenda();
        $total_encomendas_cliente = $encomendas_model->total_encomendas_por_cliente($cliente->id_cliente);

        $dados = [
            "cliente" => $cliente,
            "encomendas_cliente" => $total_encomendas_cliente,
        ];

        $layouts = [
            "admin/layouts/htmlHeader",
            "admin/layouts/header",
            "admin/detalhe_cliente",
            "admin/layouts/footer",
            "admin/layouts/htmlFooter",
        ];

        Store::carregarView($layouts, $dados);

    }

    public function verEncomendasCliente()
    {
        if(!Store::adminLogado()) {
            Store::redirect("login", true);
            return;
        }

        if(empty($_GET["id"])) {
            Store::redirect("inicio", true);
            return;
        }

        if(strlen($_GET["id"]) != 32) {
            Store::redirect("inicio", true);
            return;
        }

        $id_cliente = Store::aesDesencriptar($_GET["id"]);

        $cliente_model = new Cliente();
        $cliente = $cliente_model->recuperaClienteById($id_cliente);

        if(empty($cliente)) {
            Store::redirect("lista-clientes", true);
            return;
        }

        //recupera as encomendas do cliente
        $encomendas_model = new Encomenda();
        $encomendas_cliente = $encomendas_model->obter_encomendas_cliente($cliente->id_cliente);



        $dados = [
            "cliente" => $cliente,
            "encomendas_cliente" => $encomendas_cliente
        ];

        $layouts = [
            "admin/layouts/htmlHeader",
            "admin/layouts/header",
            "admin/cliente_encomendas",
            "admin/layouts/footer",
            "admin/layouts/htmlFooter",
        ];

        Store::carregarView($layouts, $dados);

    }

    public function detalheEncomenda()
    {
        if(!Store::adminLogado()) {
            Store::redirect("login", true);
            return;
        }

        if(empty($_GET["k"])) {
            Store::redirect("inicio", true);
            return;
        }

        if(strlen($_GET["k"]) != 32) {
            Store::redirect("inicio", true);
            return;
        }

        $id_encomenda = Store::aesDesencriptar($_GET["k"]);

        $id_encomenda_model = new Encomenda();
        $encomenda = $id_encomenda_model->obter_encomenda_por_id($id_encomenda)[0];

        if(empty($encomenda)) {
            Store::redirect("inicio", true);
            return;
        }

        $produto_model = new Produto();
        $lista_produtos_encomenda = $produto_model->lista_produtos_de_encomenda($id_encomenda);


        if(empty($lista_produtos_encomenda)) {
            Store::redirect("inicio", true);
            return;
        }


        $dados = [
            "encomenda" => $encomenda,
            "lista_produtos_encomenda" => $lista_produtos_encomenda,
        ];

        $layouts = [
            "admin/layouts/htmlHeader",
            "admin/layouts/header",
            "admin/detalhe_encomenda",
            "admin/layouts/footer",
            "admin/layouts/htmlFooter",
        ];

        Store::carregarView($layouts, $dados);

    }

    public function alterarEstadoEncomenda()
    {
        if(!Store::adminLogado()) {
            Store::redirect("login", true);
            return;
        }

        if(empty($_GET["i"])) {
            Store::redirect("inicio", true);
            return;
        }

        if(strlen($_GET["i"]) != 32) {
            Store::redirect("inicio", true);
            return;
        }

        if(empty($_GET["e"])) {
            Store::redirect("inicio", true);
            return;
        }

        if(!in_array($_GET["e"], STATUS)) {
            Store::redirect("inicio", true);
            return;
        }

        $cod_encomenda = Store::aesDesencriptar($_GET["i"]);
        $estado = mb_strtolower($_GET["e"]);

        $encomenda_model = new Encomenda();
        $encomenda_model->update_estado_encomenda($cod_encomenda, $estado);

        $encomenda = $encomenda_model->obter_encomenda_por_cod($cod_encomenda)[0];

        if(empty($encomenda)) {
            Store::redirect("inicio", true);
            return;
        }

        $produto_model = new Produto();
        $lista_produtos_encomenda = $produto_model->lista_produtos_de_encomenda($encomenda->id_encomenda);

        if(empty($lista_produtos_encomenda)) {
            Store::redirect("inicio", true);
            return;
        }


        //regras quando muda estado
        switch ($estado) {
            case "pendente":
                echo "pendente lol";
                break;
            case "processamento":
                echo "processamento lol";
                break;
            case "cancelada":
                echo "cancelada lol";
                break;
            case "enviada":
                //enviar email com notificacao
                $this->enviar_email_encomenda_enviada($encomenda->id_encomenda);
                echo "enviada lol";
                break;
            case "concluida":
                echo "concluida lol";
                break;
            default:
                break;
        }



        $dados = [
            "encomenda" => $encomenda,
            "lista_produtos_encomenda" => $lista_produtos_encomenda,
        ];

        $layouts = [
            "admin/layouts/htmlHeader",
            "admin/layouts/header",
            "admin/detalhe_encomenda",
            "admin/layouts/footer",
            "admin/layouts/htmlFooter",
        ];

        Store::carregarView($layouts, $dados);

    }

    public function imprimir_pdf()
    {
        if(!Store::adminLogado()) {
            Store::redirect("login", true);
            return;
        }

        if(empty($_GET["i"])) {
            Store::redirect("inicio", true);
            return;
        }

        if(strlen($_GET["i"]) != 32) {
            Store::redirect("inicio", true);
            return;
        }

        $id_encomenda = Store::aesDesencriptar($_GET["i"]);

        $encomenda_model = new Encomenda();
        $encomenda = $encomenda_model->obter_encomenda_por_id($id_encomenda)[0];

        if(empty($encomenda)) {
            Store::redirect("inicio", true);
            return;
        }

        $cliente_model = new Cliente();
        $cliente = $cliente_model->recuperaClienteById($encomenda->id_cliente);

        if(empty($cliente)) {
            Store::redirect("inicio", true);
            return;
        }

        $produto_model = new Produto();
        $produtos = $produto_model->lista_produtos_de_encomenda($id_encomenda);



        //get dados

        $date = date_create($encomenda->data_encomenda);
        $data_encomenda = date_format($date,"d/m/Y");

        $cod_encomenda = $encomenda->cod_encomenda;

        $nome_cliente = $cliente->nome;
        $email_cliente = $cliente->email;
        $morada_cliente = $encomenda->morada;
        $cidade_cliente = $encomenda->cidade;
        $tel_cliente = $encomenda->telefone;


        $pdf = new PDF();
        $pdf->set_template(getcwd() . "/assets/templates/template.pdf");

        //data enc
        $pdf->dimensao("100", "30");
        $pdf->posicao("230", "190");
        $pdf->set_tamanho("14px");
        $pdf->familia_letra("arial");
        $pdf->escrever_pdf("<p>$data_encomenda</p>");

        //cod enc
        $pdf->dimensao("120", "30");
        $pdf->posicao("560", "190");
        $pdf->set_tamanho("14px");
        $pdf->familia_letra("arial");
        $pdf->escrever_pdf("<p>$cod_encomenda</p>");

        //dados cliente
        $pdf->dimensao("420", "90");
        $pdf->posicao("70", "250");
        $pdf->set_tamanho("12px");
        $pdf->familia_letra("arial");
        $pdf->escrever_pdf("<div>
            <p>$nome_cliente</p>
            <p>$email_cliente</p>
            <p>$morada_cliente - $cidade_cliente</p>
            <p>$tel_cliente</p>
        </div>");

        //produtos

        $y = 320;
        $avanco = 80;
        $total = 0;

        foreach ($produtos as $produto) {
            $designacao = $produto->designacao_produto;
            $quantidade = $produto->quantidade;
            $preco = $produto->preco_unitario;

            $pdf->dimensao("420", "70");
            $y += $avanco;
            $pdf->posicao("70", $y);
            $pdf->alinhamento("left");
            $pdf->set_tamanho("12px");
            $pdf->familia_letra("arial");
            $pdf->escrever_pdf("<div>
                <p>Designação: $designacao</p>
                <p>Quantidade: $quantidade</p>
                <p>Preço unitário: $preco Euros</p>
            </div>");

            $pdf->dimensao("180", "70");
            $pdf->posicao("530", $y);
            $pdf->alinhamento("right");
            $pdf->set_tamanho("12px");
            $pdf->familia_letra("arial");
            $subtotal = $preco * $quantidade;
            $pdf->escrever_pdf("<div>
                <br>
                <br>
                <p>Sub-total: $subtotal Euros</p>
            </div>");


            $total += $produto->quantidade * $produto->preco_unitario;
        }


        $pdf->dimensao("120", "30");
        $pdf->posicao("600", "780");
        $pdf->set_tamanho("14px");
        $pdf->familia_letra("arial");
        $pdf->escrever_pdf("<p>Total: <strong>$total</strong> Euros</p>");


        $pdf->apresentar_pdf();

    }




    /**
     * Funcoes privadas para lidar com a mudanca de estado
     */

    private function enviar_email_encomenda_enviada($id_encomenda)
    {
        echo "Email enviado!";
    }
}