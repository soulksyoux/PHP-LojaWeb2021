<div class="container-fluid">
    <div style="margin-bottom: 100px; padding: 20px;" class="row">
        <div id="carrinho_container" class="col-12">
            <h2 class="my-4">A sua encomenda:</h2>

            <?php if(!empty($carrinho)): ?>


                <table class="table">
                    <thead>
                    <tr>
                        <th class="center" scope="col">#</th>
                        <th scope="col">Imagem</th>
                        <th scope="col">Designação</th>
                        <th scope="col">Quantidade</th>
                        <th class="text-end" scope="col">Preço unitário</th>
                        <th class="text-end" scope="col">Sub-total</th>
                        <th class="text-center" scope="col">Ações</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php $total = 0; ?>
                    <?php foreach ($carrinho as $key => $produto): ?>

                    <tr id="linha_carrinho_<?= $produto['id_produto']; ?>">
                        <th scope="row"><?= $key + 1  ?></th>
                        <td><img width="80" src="assets/images/produtos/<?= $produto['imagem'] ?>" alt="t-shirt vermelha"
                                 class="img-fluid"></td>
                        <td><?= $produto["nome_produto"] ?></td>
                        <td id="quant_id<?= $produto['id_produto']; ?>"><?= $produto["quantidade"] ?></td>
                        <td id="precounitario_id_<?= $produto['id_produto']; ?>" class="text-end"><?= number_format($produto["preco"], 2, '.', ''); ?> $</td>
                        <td id="subtotal_id_<?= $produto['id_produto']; ?>" class="text-end"><?= number_format(($produto['preco'] * $produto['quantidade']), 2, '.', ''); ?> $</td>
                        <td class="text-center" >
                            <a href="?a=aumentar_qtd_item_carrinho&id_produto=<?= $produto['id_produto']; ?>"><i class="fas fa-plus me-2 text-success"></i></a>
                            <a href="#" onclick="diminuir_qtd_item_carrinho(<?= $produto['id_produto']; ?>)"><i class="fas fa-minus text-danger"></i></a>
                        </td>
                    </tr>

                    <?php $total += ($produto['preco'] * $produto['quantidade']) ?>
                    <?php endforeach; ?>

                    <tr>
                        <td colspan="4"></td>
                        <td class="fw-bold text-end">Total:</td>
                        <td id="carrinho_total" class="text-end"><?= number_format($total, 2, '.', ''); ?> $</td>
                        <td></td>
                    </tr>


                    </tbody>
                </table>

                <div class="row">
                    <div class="col">
                        <a href="#" id="confirm_limpa_carrrinho_btn" onclick="confirmar_limpar_carrinho()" class="btn btn-primary btn-sm">Limpar carrinho</a>
                        <span id="confirm_limpa_carrrinho_box" hidden class="ms-2">
                            <span>Tem a certeza?</span>
                            <a href="?a=limpar_carrinho" class="">Sim</a>
                            <a href="#" onclick="nao_limpar_carrinho()" class="">Não</a>
                        </span>
                    </div>
                    <div class="col text-end">
                        <a href="?a=loja" class="btn btn-primary btn-sm">Continuar a comprar</a>
                        <a href="?a=finalizar_encomenda" class="btn btn-primary btn-sm">Finalizar encomenda</a>
                    </div>
                </div>


            <?php else: ?>
                <div class="alert alert-warning mt-4" role="alert">
                    Carrinho Vazio!!!
                </div>

                <div class="row">
                    <div class="col text-center">
                        <a href="?a=loja" class="btn btn-primary">Ir para a loja</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
