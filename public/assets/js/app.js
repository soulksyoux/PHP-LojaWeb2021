function adicionarItemCarrinho(id_prod) {
    //axios.defaults.widthCredentials = true;
    axios.get("?a=adicionar_carrinho&id_produto=" + id_prod).then(function(res) {
        console.log(res.data);
    })

}

const adicionarItemCarrinho1 = async (id_prod) => {

    try{
        if(id_prod) {
            const res = await axios.get("?a=adicionar_carrinho&id_produto=" + id_prod);
            $(".badge.bg-info").html(res.data);
        }

    } catch (err) {
        console.log(err);
    }
}

const limparCarrinho = async () => {
    try{
        const res = await axios.get("?a=limpar_carrinho");
        $(".badge.bg-info").html(res.data == 0 ? "" : res.data);
    } catch (err) {
        console.log(err);
    }
}

//utilizando o fetch para chamada asincrona com promises
function adicionarItemCarrinho2(id_prod) {
    var Headers = {
        contentType: "text/html; charset=windows-1251"
    };

    fetch("?a=adicionar_carrinho&id_produto=" + id_prod, Headers)
        .then(res => res.text())
        .then(data => {
            console.log(data);
        }).catch(err => {
            console.log(err);
    })
}

//utilizando o fetch para chamada asincrona com sugar sintaxe async await
async function adicionarItemCarrinho3(id_prod) {

    try{
        const response = await fetch("?a=adicionar_carrinho&id_produto=" + id_prod);
        const data = await response.text();
        console.log(data);
    }catch (erro) {
        console.log(erro);
    }
}

//utilizando jquery / ajax
function adicionarItemCarrinho4(id_prod) {
    $.ajax({
        type: "GET",
        url: "?a=adicionar_carrinho&id_produto=" + id_prod,
        success: function(res) {
            console.log(res);
        }
    });
}

async function diminuir_qtd_item_carrinho(id_prod) {
    try{
        if(id_prod) {
            const res = await axios.get("?a=diminuir_qtd_item&id_produto=" + id_prod);
            //console.log(res.data);

            if(res.data.quantidade > 0) {
                $(".badge.bg-info").html(res.data.quantidade);
                carrinho = res.data.carrinho;

                //atualizar a quantidade prod
                $("#quant_id" + id_prod).html(carrinho[id_prod]);


                preco_unitario = $("#precounitario_id_" + id_prod).html();
                if(preco_unitario) {
                    preco_unitario = preco_unitario.replace(" $", "");
                }


                //atualizar o sub total
                if(carrinho[id_prod] >= 1) {
                    quant = $("#quant_id" + id_prod).html();
                    subtotal = preco_unitario * quant;
                    subtotal = subtotal.toFixed(2);

                    $("#subtotal_id_" + id_prod).html(subtotal + " $");
                }

                //atualizar o total o carrinho
                total = $("#carrinho_total").html();
                total = total.replace(" $", "");
                total = total - preco_unitario;
                total = total.toFixed(2);
                $("#carrinho_total").html(total + " $");

                //atualizar o subtotal
                if(carrinho[id_prod] <= 0) {
                    $("#linha_carrinho_" + id_prod).remove();
                }

            }

            else if(res.data.quantidade <= 0) {
                html = `
                    <div class="alert alert-warning mt-4" role="alert">
                        Carrinho Vazio!!!
                    </div>
    
                    <div class="row">
                        <div class="col text-center">
                            <a href="?a=loja" class="btn btn-primary">Ir para a loja</a>
                        </div>
                    </div>
                `
                $("#carrinho_container").html(html);
            }

        }

    } catch (err) {
        console.log(err);
    }
}


function confirmar_limpar_carrinho() {
    $("#confirm_limpa_carrrinho_box").removeAttr('hidden');
}

function nao_limpar_carrinho() {
    $("#confirm_limpa_carrrinho_box").attr('hidden', 'true');
}



