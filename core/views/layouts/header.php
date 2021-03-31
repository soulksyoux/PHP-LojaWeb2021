<?php
    use core\classes\Store;
    //$_SESSION["cliente"] = "andre";
?>


<div class="container-fluid navegacao">
    <div class="row">
        <div class="col-6 p-3">
            <a href="?a=inicio">
                <h3><?= APP_NAME ?></h3>
            </a>
        </div>
        <div class="col-6 text-end p-3">
            <a href="?a=inicio">Inicio</a>
            <a href="?a=loja">Loja</a>
            <?php if(Store::clienteLogado()): ?>
                <a href="">Ver Conta</a>
                <a href="">Logout</a>
            <?php else: ?>
                <a href="">Criar Conta</a>
                <a href="">Login</a>
            <?php endif; ?>
            <a href="?a=carrinho"><i class="fas fa-shopping-cart"></i></a>
            <span class="badge bg-info">3</span>
        </div>
    </div>
</div>
