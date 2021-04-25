<div class="container-fluid">
    <div class="row my-5">
        <div class="col-6 offset-3">
            <h3 class="text-center"><?= "Backoffice Home"; ?></h3>



            <?php if(!empty($_SESSION["erro"])): ?>
                <div class="alert alert-danger text-center p-2">
                    <?= $_SESSION["erro"] ?>
                    <?php unset($_SESSION["erro"]); ?>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>
