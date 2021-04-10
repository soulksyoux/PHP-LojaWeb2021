function adicionarItemCarrinho(id_prod) {
    //axios.defaults.widthCredentials = true;
    axios.get("?a=adicionar_carrinho&id_produto=" + id_prod).then(function(res) {
        console.log(res.data);
    })

}

const adicionarItemCarrinho1 = async (id_prod) => {
    try{
        const res = await axios.get("?a=adicionar_carrinho&id_produto=" + id_prod);
        $(".badge.bg-info").html(res.data);
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



