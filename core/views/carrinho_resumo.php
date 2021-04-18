<?php var_dump($_SESSION); ?>

<div class="container-fluid">
    <div style="margin-bottom: 100px; padding: 20px;" class="row">
        <div id="carrinho_container" class="col-12">



            <h2 class="my-4">Resumo da sua encomenda:</h2>

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



                <h3 class="my-4 bg-dark text-light p-1">Dados de pagamento:</h3>
                <div class="row align-items-center input-group input-group-sm">
                    <div class="col-auto">
                        <label for="inputPassword6" class="col-form-label">Código de Encomenda:</label>
                    </div>
                    <div class="col-5">
                        <span><?= $_SESSION["cod_encomenda"]; ?></span>

                    </div>
                </div>
                <div class="row align-items-center input-group input-group-sm">
                    <div class="col-auto">
                        <label for="inputPassword6" class="col-form-label">Valor total:</label>
                    </div>
                    <div class="col-5">
                        <span><?= number_format($total, 2, '.', ''); ?> $</span>
                    </div>
                </div>


                <h3 class="my-4 bg-dark text-light p-1">Dados do cliente:</h3>
                <div class="row">
                    <div class="col">
                        <ul>
                            <li><strong>Nome:</strong> <?= $cliente->nome ?></li>
                            <li><strong>Email:</strong> <?= $cliente->email ?></li>
                            <li><strong>Morada:</strong> <?= $cliente->morada ?></li>
                            <li><strong>Cidade:</strong> <?= $cliente->cidade ?></li>
                            <li><strong>Telefone:</strong> <?= $cliente->telefone ?></li>
                        </ul>
                    </div>

                    <div class="col" id="novos_dados_envio" hidden>
                        <ul>
                            <li>
                                <div class="input-group input-group-sm mb-2">
                                    <span class="input-group-text" id="inputGroup-sizing-sm">Morada</span>
                                    <input id="morada_alternativa" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                                </div>
                            </li>
                            <li>
                                <div class="input-group input-group-sm mb-2">
                                    <span class="input-group-text" id="inputGroup-sizing-sm">Cidade</span>
                                    <input id="cidade_alternativa" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                                </div>
                            </li>
                            <li>
                                <div class="input-group input-group-sm mb-2">
                                    <span class="input-group-text" id="inputGroup-sizing-sm">Telefone</span>
                                    <input id="telefone_alternativo" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>


                <div class="form-check">
                    <input onchange="testex()" class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                    <label class="form-check-label" for="flexCheckDefault">
                        Alterar dados de envio
                    </label>
                </div>



                <div class="row mt-5">
                    <div class="col text-start">
                        <a href="?a=loja" class="btn btn-danger btn-sm">Cancelar a compra</a>
                    </div>
                    <div class="col text-end">
                        <a id="confirm_compra_btn" onclick="confirmar_finalizar_compra()" class="btn btn-primary btn-sm">Finalizar encomenda</a>
                        <span id="confirm_compra_box" hidden class="ms-2">
                            <span>Tem a certeza?</span>
                            <a href="?a=terminar_encomenda" onclick="morada_alternativa()" class="">Sim</a>
                            <a href="#" onclick="nao_confirma_compra()" class="">Não</a>
                        </span>
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
