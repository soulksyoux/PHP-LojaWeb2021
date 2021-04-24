<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1>Página inicial</h1>
        </div>
        <?php if(!empty($_SESSION["erro"])): ?>
            <div class="alert alert-danger text-center p-2">
                <?= $_SESSION["erro"] ?>
                <?php unset($_SESSION["erro"]); ?>
            </div>
        <?php endif; ?>
    </div>
</div>