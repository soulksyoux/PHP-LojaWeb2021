<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1>Carrinho de compras</h1>
            <?php var_dump($_SESSION); ?>
            <?php if(!empty($_SESSION["carrinho"])): ?>
                <ul>
                <?php foreach ($_SESSION["carrinho"] as $produto): ?>
                    <?php if(!empty($produto->id_produto)): ?>
                        <li>

                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</div>
