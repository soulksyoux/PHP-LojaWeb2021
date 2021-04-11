<div class="container-fluid">
    <div class="row">
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
                        <th scope="col">Preço unitário</th>
                        <th scope="col">Sub-total</th>
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
                        <td><?= $produto["preco"] ?></td>
                        <td><?= $produto['preco'] * $produto['quantidade'] ?></td>
                    </tr>

                    <?php $total += ($produto['preco'] * $produto['quantidade']) ?>
                    <?php endforeach; ?>

                    <tr>
                        <td colspan="4"></td>
                        <td class="fw-bold">Total:</td>
                        <td><?= $total ?></td>
                    </tr>
                    </tbody>
                </table>

                <div class="position-relative">
                    <a href="?a=limpar_carrinho" class="btn btn-primary btn-sm top-0 start-0">Limpar carrinho</a>
                    <a href="?a=finalizar_compra" class="btn btn-success btn-sm position-absolute top-0 end-0">Finalizar compra</a>

                </div>


            <?php else: ?>
                <div class="alert alert-warning mt-4" role="alert">
                    Carrinho Vazio!!!
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
