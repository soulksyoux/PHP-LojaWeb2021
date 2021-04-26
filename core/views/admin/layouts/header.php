<?php
    use core\classes\Store;

    $totalCarrinho = 0;
    if(!empty($_SESSION["carrinho"])) {
        foreach ($_SESSION["carrinho"] as $produto) {
            $totalCarrinho += $produto;
        }
    }

?>

<div class="container-fluid navegacao">
    <div class="row">
        <div class="col-6 p-3">
            <a class="text-decoration-none" href="?a=inicio">
                <h3><?= APP_NAME . " - BACKOFFICE"?></h3>
            </a>
        </div>
        <div class="col-6 text-end p-3">
            <a class="navbar-loja-links" href="?a=inicio">Inicio</a>
            <?php if(!empty($_SESSION["admin_id"])): ?>
                <a class="navbar-loja-links" href="?a=logout-admin">Logout</a>
            <?php endif; ?>
        </div>
    </div>
</div>

