<?php


namespace core\controllers;

use core\classes\Email;
use core\classes\Store;
use core\models\Cliente;
use core\models\Encomenda;
use core\models\Produto;

class Carrinho
{
    /**
     * @throws \Exception
     */
    public function carrinho() {

        //montar carrinho com dados apartir da bd

        $carrinho = [];

        if(!empty($_SESSION["carrinho"])) {
            foreach ($_SESSION["carrinho"] as $key => $qtd) {

                $produtos = new Produto();
                $find = $produtos->get_produto_by_id($key);

                if(!empty($find) && $qtd >= 1) {
                    array_push($carrinho, [
                        "id_produto" => $find->id_produto,
                        "nome_produto" => $find->nome_produto,
                        "preco" => $find->preco,
                        "imagem" => $find->imagem,
                        "quantidade" => $_SESSION["carrinho"][$key]
                    ]);
                }
            }
        }

        $layouts = [
            "layouts/htmlHeader",
            "layouts/header",
            "carrinho",
            "layouts/footer",
            "layouts/htmlFooter",
        ];

        Store::carregarView($layouts, ["carrinho" => $carrinho]);
    }


    public function adicionarCarrinho()
    {

        $id_produto = $_GET['id_produto'];

        $produtos = new Produto();
        $resultado = $produtos->validar_stock($id_produto);
        if(!$resultado) {
            $total_aux = 0;
            if(!empty($_SESSION["carrinho"])) {
                foreach ($_SESSION["carrinho"] as $qtd) {
                    $total_aux += $qtd;
                }
            }
            echo $total_aux == 0 ? "" : $total_aux;
            return;
        }

        // adiciona/gestão da variável de SESSAO do carrinho
        $carrinho = [];

        if(isset($_SESSION['carrinho'])){
            $carrinho = $_SESSION['carrinho'];
        }

        // adicionar o produto ao carrinho
        if(key_exists($id_produto, $carrinho)){

            // já existe o produto. Acrescenta mais uma unidade
            $carrinho[$id_produto]++;

        } else {

            // adicionar novo produto ao carrinho
            $carrinho[$id_produto] = 1;
        }

        // atualiza os dados do carrinho na sessão
        $_SESSION['carrinho'] = $carrinho;

        // devolve a resposta (número de produtos do carrinho)
        $total_produtos = 0;
        foreach($carrinho as $quantidade){
            $total_produtos += $quantidade;
        }
        echo $total_produtos;
    }

    public function diminuirQtdItem()
    {
        if(empty($_GET["id_produto"])) {
            return;
        }

        $id_produto = $_GET["id_produto"];

        //diminuir a quantidade em 1 na session correspondente ao id do produto passado
        if(!empty($_SESSION["carrinho"][$id_produto]) && $_SESSION["carrinho"][$id_produto] > 0) {
            $_SESSION["carrinho"][$id_produto]--;
        }

        $quantidade = 0;
        if(!empty($_SESSION["carrinho"])) {
            foreach ($_SESSION["carrinho"] as $qtd) {
                $quantidade += $qtd;
            }
        }

        echo json_encode(["carrinho" => $_SESSION["carrinho"], "quantidade" => $quantidade]);

    }

    public function aumentarQtdItemCarrinho()
    {

        if(empty($_GET["id_produto"])) {
            return;
        }

        $id_produto = $_GET["id_produto"];


        if(empty($_SESSION["carrinho"][$id_produto])) {
            return;
        }

        $_SESSION["carrinho"][$id_produto]++;

        header("Location: " . APP_BASE_URL . "?a=carrinho");
    }

    public function prepararEncomenda()
    {
        //validar se utilizador logado
        if(empty($_SESSION["cliente"])) {
            //user nao logado

            $_SESSION["tmp_carrinho"] = true;
            Store::redirect("login");
            return;
        }

        Store::redirect("preparar_encomenda_resumo");

    }

    public function limparCarrinho() {
        unset($_SESSION["carrinho"]);
        $this->carrinho();
    }


    public function prepararEncomendaResumo()
    {
        if(empty($_SESSION["cliente"])) {
            Store::redirect("login");
            return;
        }

        if(empty($_SESSION["carrinho"])) {
            Store::redirect("loja");
            return;
        }

        //dados do carrinho

        $carrinho = [];

        if(!empty($_SESSION["carrinho"])) {
            foreach ($_SESSION["carrinho"] as $key => $qtd) {

                $produtos = new Produto();
                $find = $produtos->get_produto_by_id($key);

                if(!empty($find) && $qtd >= 1) {
                    array_push($carrinho, [
                        "id_produto" => $find->id_produto,
                        "nome_produto" => $find->nome_produto,
                        "preco" => $find->preco,
                        "imagem" => $find->imagem,
                        "quantidade" => $_SESSION["carrinho"][$key]
                    ]);
                }
            }
        }

        //dados do user


        //recupera os dados da bd
        $cliente = new Cliente();
        $cliente = $cliente->recuperaClienteById($_SESSION["cliente"]);


        if(empty($_SESSION["cod_encomenda"])) {
            $_SESSION["cod_encomenda"] = Store::gerar_codigo_encomenda();
        }

        $layouts = [
            "layouts/htmlHeader",
            "layouts/header",
            "carrinho_resumo",
            "layouts/footer",
            "layouts/htmlFooter",
        ];

        Store::carregarView($layouts, ["carrinho" => $carrinho, "cliente" => $cliente]);
    }


    public function moradaAlternativa() {

        //receber dados via ajax - axios
        $post = json_decode(file_get_contents("php://input"), true);


        $_SESSION["dados_morada_alternativos"] = [
            'morada' => $post['moradaAlternativa'],
            'cidade' => $post['cidadeAlternativa'],
            'telefone' => $post['telefoneAlternativo']
        ];

    }

    public function valorTotalSession(){
        //receber dados via ajax - axios
        $post = json_decode(file_get_contents("php://input"), true);

        $_SESSION["valorTotal"] = $post["valorTotal"];
    }


    public function terminarEncomenda()
    {
        if(empty($_SESSION["cliente"])) {
            Store::redirect("login");
            return;
        }

        if(empty($_SESSION["carrinho"])) {
            Store::redirect("loja");
            return;
        }


        //guardar na bd

        $cliente = new Cliente();
        $cliente = $cliente->recuperaClienteById($_SESSION["cliente"]);

        $dados_encomenda = [
            "id_cliente" => $cliente->id_cliente,
            "morada" => !empty($_SESSION["dados_morada_alternativos"]["morada"]) ? $_SESSION["dados_morada_alternativos"]["morada"] : $cliente->morada,
            "cidade" => !empty($_SESSION["dados_morada_alternativos"]["cidade"]) ? $_SESSION["dados_morada_alternativos"]["cidade"] : $cliente->cidade,
            "telefone" => !empty($_SESSION["dados_morada_alternativos"]["telefone"]) ? $_SESSION["dados_morada_alternativos"]["telefone"] : $cliente->telefone,
            "cod_encomenda" => $_SESSION["cod_encomenda"],
            "status" => "pendente",
            "mensagem" => "",
        ];

        $produtos_carrinho = [];

        if(!empty($_SESSION["carrinho"])) {
            foreach ($_SESSION["carrinho"] as $key => $qtd) {

                $produtos = new Produto();
                $find = $produtos->get_produto_by_id($key);

                if(!empty($find) && $qtd >= 1) {
                    array_push($produtos_carrinho, [
                        "id_produto" => $find->id_produto,
                        "nome_produto" => $find->nome_produto,
                        "preco" => $find->preco,
                        "imagem" => $find->imagem,
                        "quantidade" => $_SESSION["carrinho"][$key]
                    ]);
                }
            }
        }

        $encomenda = new Encomenda();
        $encomenda = $encomenda->gravar_encomenda($dados_encomenda, $produtos_carrinho);

        $erro = "";

        if(!$encomenda) {
            $erro = "Problema ao processar a encomenda, tente mais tarde!";
        }

        //enviar email para o cliente

        $toEmail = "andytod80@gmail.com";
        $toName = "AndreGP";
        $subject = "Email de teste";
        $body = "<h2>Encomenda confirmnada. Obrigado pela sua preferencia pela " . APP_NAME . "</h2>";

        $email = new Email();


        //$email = $email->enviar_email($toEmail, $toName, $subject, $body);

        $email = 1;
        if(!$email) {
            $erro = "Erro no envio do email, tente mais tarde";
        }

        $dados = [];

        if($erro == "") {
            $dados["cod_encomenda"] = $_SESSION["cod_encomenda"];
            $dados["valorTotal"] = $_SESSION["valorTotal"];
            $dados["dados_morada_alternativos"] = $_SESSION["dados_morada_alternativos"];

            unset($_SESSION["carrinho"]);
            unset($_SESSION["dados_morada_alternativos"]);
            unset($_SESSION["cod_encomenda"]);
            unset($_SESSION["valorTotal"]);
        }


        $layouts = [
            "layouts/htmlHeader",
            "layouts/header",
            "encomenda_confirmada",
            "layouts/footer",
            "layouts/htmlFooter",
        ];

        Store::carregarView($layouts, ["erro" => $erro, "dados" => $dados]);
    }


}

