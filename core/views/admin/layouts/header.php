<div class="container-fluid navegacao">
    <div class="row">
        <div class="col-6 p-3 align-self-center">
            <a class="text-decoration-none" href="?a=inicio">
                <h3><?= APP_NAME . " - BACKOFFICE"?></h3>
            </a>
        </div>
        <div class="col-6 text-end p-3 align-self-center">
            <?php if(!empty($_SESSION["admin_id"])): ?>
                <a href="" class="me-2 text-light text-decoration-none"><i class="fas fa-user me-2"></i><?= $_SESSION["admin_user"]; ?></a>
                <span class="mx-2 text-light">|</span>
                <a class="navbar-loja-links" href="?a=logout-admin">Logout</a>
            <?php endif; ?>
        </div>
    </div>
</div>

