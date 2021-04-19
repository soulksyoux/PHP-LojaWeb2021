<div class="container-fluid">
    <div class="row my-5">
        <div class="col-sm-4 offset-sm-4 mb-5">
            <h3 class="text-center mb-4"><?= "Gerir a conta"; ?></h3>

            <div class="d-grid gap-2">
                <a href="?a=alterar_dados_pessoais" class="btn btn-primary text-center">Alterar dados pessoais</a>
                <a href="" class="btn btn-primary text-center">Alterar password</a>
                <a href="" class="btn btn-primary text-center">Ver todas as encomendas</a>
                <a href="" class="btn btn-primary text-center">Ir para a loja</a>
            </div>

            <?php if(!empty($_SESSION["erro"])): ?>
                <div class="alert alert-danger text-center p-2">
                    <?= $_SESSION["erro"] ?>
                    <?php unset($_SESSION["erro"]); ?>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>
