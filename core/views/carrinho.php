<div class="container-fluid">
    <div style="margin-bottom: 100px; padding: 20px;" class="row">
        <div class="col-12">
            <h1>Carrinho de compras</h1>

            <?php if(!empty($carrinho)): ?>


                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Imagem</th>
                        <th scope="col">Designação</th>
                        <th scope="col">Quantidade</th>
                        <th class="text-end" scope="col">Preço unitário</th>
                        <th class="text-end" scope="col">Sub-total</th>
                        <th scope="col">Ações</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php $total = 0; ?>
                    <?php foreach ($carrinho as $key => $produto): ?>

                    <tr>
                        <th scope="row"><?= $key + 1  ?></th>
                        <td><img width="80" src="assets/images/produtos/<?= $produto['imagem'] ?>" alt="t-shirt vermelha"
                                 class="img-fluid"></td>
                        <td><?= $produto["nome_produto"] ?></td>
                        <td><?= $produto["quantidade"] ?></td>
                        <td class="text-end"><?= number_format($produto["preco"], 2, '.', ''); ?> $</td>
                        <td class="text-end"><?= number_format(($produto['preco'] * $produto['quantidade']), 2, '.', ''); ?> $</td>
                        <td>
                            <a href=""><i class="fas fa-plus me-2 text-success"></i></a>
                            <a href=""><i class="fas fa-minus text-danger"></i></a>
                        </td>
                    </tr>

                    <?php $total += ($produto['preco'] * $produto['quantidade']) ?>
                    <?php endforeach; ?>

                    <tr>
                        <td colspan="4"></td>
                        <td class="fw-bold text-end">Total:</td>
                        <td class="text-end"><?= number_format($total, 2, '.', ''); ?> $</td>
                        <td></td>
                    </tr>


                    </tbody>
                </table>

                <div class="position-relative">
                    <a href="?a=limpar_carrinho" class="btn btn-primary btn-sm top-0 start-0">Limpar carrinho</a>
                    <a href="?a=finalizar_compra" class="btn btn-success btn-sm position-absolute top-0 end-0 me-2">Finalizar compra</a>

                </div>


            <?php else: ?>
                <div class="alert alert-warning mt-4" role="alert">
                    Carrinho Vazio!!!
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
