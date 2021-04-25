<div class="container-fluid">
    <div class="row my-5">
        <div class="col-sm-6 offset-sm-3">
            <h3 class="text-center"><?= "Pagamento da encomenda realizada com sucesso!!!"; ?></h3>
        </div>
    </div>
</div>

<?php if(!empty($_SESSION["erro"])): ?>
    <div class="alert alert-danger text-center p-2">
        <?= $_SESSION["erro"] ?>
        <?php unset($_SESSION["erro"]); ?>
    </div>
<?php endif; ?>