<div class="container espaco-fundo">
    <div class="row">
        <div class="col-12 text-center my-4">
            <?php if(!empty($categorias)): ?>
                <a class="btn btn-outline-secondary btn-sm" href="?a=loja&c=todos">Todos</a>
                <?php foreach ($categorias as $categoria): ?>
                    <a class="btn btn-outline-secondary btn-sm" href="?a=loja&c=<?= $categoria ?>"><?= ucfirst(preg_replace("/\_/", " ", $categoria)) ?></a>
                <?php endforeach; ?>
            <?php endif; ?>
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
                            <?php if($produto->stock > 0): ?>
                                <button class="btn btn-outline-primary" onclick="adicionarItemCarrinho1(<?php echo $produto->id_produto; ?>)">Adicionar ao carrinho</button>
                            <?php else: ?>
                                <button disabled class="btn btn-outline-danger">Sem stock</button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="alert alert-warning" role="alert">
                Não existem produtos disponiveis!
            </div>
        <?php endif; ?>
    </div>
</div>
