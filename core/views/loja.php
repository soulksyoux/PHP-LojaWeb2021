<div class="container espaco-fundo">
    <div class="row">
        <div class="col-12 text-center my-4">
            <a class="btn btn-outline-secondary btn-sm" href="?a=loja&c=todos">Todos</a>
            <a class="btn btn-outline-secondary btn-sm" href="?a=loja&c=homem">Homem</a>
            <a class="btn btn-outline-secondary btn-sm" href="?a=loja&c=mulher">Mulher</a>
        </div>
    </div>
    <div class="row">
        <?php if (!empty($produtos)): ?>
            <?php foreach ($produtos as $produto): ?>
                <div class="col-sm-6 col-lg-4 p-2">
                    <div class="text-center p-3 box-produtos">
                        <img src="assets/images/produtos/<?= $produto->imagem ?>" alt="t-shirt vermelha"
                             class="img-fluid">
                        <h2><?= $produto->nome_produto; ?></h2>
                        <h3><?= $produto->preco; ?></h3>
                        <div>
                            <button class="btn btn-outline-primary">Adicionar ao carrinho</button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
