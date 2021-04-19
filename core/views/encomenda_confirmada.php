<div class="container">


    <?php if(empty($erro)): ?>

        <div class="row mt-4">
            <div class="col-12">
                <h1 class="bg-success text-center">Sua encomenda está confirmada!!</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <p><strong>Cliente: </strong><span><?= $_SESSION["cliente"]; ?></span></p>

                <p><strong>Código da Encomenda: </strong><span><?= $dados["cod_encomenda"]; ?></span></p>
                <p><strong>Valor a pagar: </strong><span><?= number_format($dados["valorTotal"],"2", ",", ".") . "$"?></span></p>
            </div>
        </div>

        <?php if(!empty($dados["dados_morada_alternativos"])): ?>
            <div class="row">
                <div class="col-12">
                    <h3 class="bg-dark text-center text-light">Dados alternativos de envio:</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <p><strong>Morada: </strong><span><?= $dados["dados_morada_alternativos"]["morada"]; ?></span></p>
                    <p><strong>Cidade: </strong><span><?= $dados["dados_morada_alternativos"]["cidade"]; ?></span></p>
                    <p><strong>Telefone: </strong><span><?= $dados["dados_morada_alternativos"]["telefone"]; ?></span></p>
                </div>
            </div>
        <?php endif; ?>

        <div class="row">
            <div class="text-center">
                <a href="?a=inicio" class="btn-primary btn">Voltar para a loja</a>
            </div>
        </div>
    <?php else: ?>
        <div class="row">
            <div class="col-12">
                <div class="alert alert-warning" role="alert">
                    <?= $erro; ?>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="text-center">
                <a href="?a=preparar_encomenda_resumo" class="btn-primary btn text-center">Voltar para o resumo da encomenda</a>
            </div>
        </div>
    <?php endif; ?>

</div>
