<?php $produto = $produtos[0]; ?>

<div class="container-fluid espaco-fundo">
    <div class="row">
        <div class="col-12">
            <h1>Benvindo à loja!</h1>
        </div>
    </div>
    <div class="row">
        <?php if(!empty($produtos)): ?>
            <?php foreach ($produtos as $produto): ?>
                <div class="col-sm-6 col-lg-4">
                    <div class="text-center p-3">
                        <img src="assets/images/produtos/<?= $produto->imagem ?>" alt="t-shirt vermelha" class="img-fluid">
                        <h2><?= $produto->nome_produto; ?></h2>
                        <h3><?= $produto->preco; ?></h3>
                        <p><?= $produto->descricao; ?></p>
                        <div>
                            <button class="btn btn-outline-primary">Adicionar ao carrinho</button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
