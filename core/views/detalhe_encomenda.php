<div class="container-fluid">
    <div class="row my-5">
        <?php if($encomenda == []): ?>
            <h5>Encomenda vazia</h5>
        <?php else: ?>
            <div class="col-sm-4 offset-sm-4 mb-5">
                <h3 class="text-center mb-4"><?= "Detalhe da encomenda " . $encomenda->cod_encomenda; ?></h3>
                <div class="border p-3">
                    <div><strong>Data: </strong><?= $encomenda->data_encomenda; ?></div>
                    <div><strong>Status: </strong><?= $encomenda->status; ?></div>
                    <div><strong>Mensagem: </strong><?= $encomenda->mensagem; ?></div>
                    <h5 class="mt-3"><strong>Dados de envio:</strong></h5>
                    <div><strong>Morada: </strong><?= $encomenda->morada; ?></div>
                    <div><strong>Cidade: </strong><?= $encomenda->cidade; ?></div>
                    <div><strong>Telefone: </strong><?= $encomenda->telefone; ?></div>
                    <h5 class="mt-3"><strong>Total: </strong><?= number_format($encomenda->total, "2", "," , ",") . "$"; ?></h5>
                </div>
            </div>
            <div class="col-sm-8 offset-sm-2">
                <h4>Lista de produtos:</h4>

                <table class="table">
                    <thead>
                        <tr>
                            <th>Designação</th>
                            <th>Quantidade</th>
                            <th>Preço unitário</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($produtos_encomenda as $produto): ?>
                            <tr>
                                <td><?= $produto->designacao_produto; ?></td>
                                <td><?= $produto->quantidade; ?></td>
                                <td><?= number_format($produto->preco_unitario, "2", ",", ".") . "$";?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="col-sm-4 offset-sm-4 my-5">
                <div class="text-center">
                    <a href="?a=ver_encomendas" class="btn btn-primary">Voltar para encomendas</a>
                </div>
            </div>
        <?php endif; ?>

        <?php if(!empty($_SESSION["erro"])): ?>
            <div class="alert alert-danger text-center p-2">
                <?= $_SESSION["erro"] ?>
                <?php unset($_SESSION["erro"]); ?>
            </div>
        <?php endif; ?>
    </div>
</div>
