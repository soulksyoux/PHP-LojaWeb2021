<?php
    use core\classes\Store;
    $_SESSION["cliente"] = "andre";
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


<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="?a=inicio"><h3><?= APP_NAME ?></h3></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav w-100 justify-content-end">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="?a=inicio">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="?a=loja">Loja</a>
                </li>
                <?php if(Store::clienteLogado()): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Ver Conta</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Logout</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Criar Conta</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Login</a>
                    </li>
                <?php endif; ?>
                <li class="nav-item d-flex align-items-center mt-1">
                    <a href="?a=carrinho"><i class="fas fa-shopping-cart"></i></a>
                    <span class="badge bg-info m-1">3</span>
                </li>
            </ul>
        </div>

    </div>
</nav>
