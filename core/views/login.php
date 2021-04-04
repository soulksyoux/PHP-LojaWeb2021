<div class="container-fluid">
    <div class="row my-5">
        <div class="col-6 offset-3">
            <h3 class="text-center"><?= "Efetuar Login"; ?></h3>

            <form action="?a=login_user" method="post">

                <!-- Email -->
                <div class="my-3">
                    <label for="text_email">Email</label>
                    <input type="email" name="text_email" id="text_email" placeholder="Email" class="form-control" required>
                </div>


                <!-- Senha1 -->
                <div class="my-3">
                    <label for="text_senha_1">Senha</label>
                    <input type="password" name="text_senha_1" id="text_senha_1" placeholder="Senha" class="form-control" required>
                </div>


                <!-- Summit -->
                <div class="my-4">
                    <input type="submit" value="Login" class="btn btn-primary">
                </div>

            </form>

            <?php if(!empty($_SESSION["erro"])): ?>
                <div class="alert alert-danger text-center p-2">
                    <?= $_SESSION["erro"] ?>
                    <?php unset($_SESSION["erro"]); ?>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>
