<div class="container-fluid">
    <div class="row my-5">
        <div class="col-6 offset-3">
            <h3 class="text-center"><?= "Backoffice Login"; ?></h3>

            <form action="?a=submeter_login_admin" method="post">

                <!-- Email -->
                <div class="my-3">
                    <label for="text_email">Admin Email</label>
                    <input type="email" name="text_email_admin" id="text_email_admin" placeholder="Email Admin" class="form-control" required>
                </div>


                <!-- Senha1 -->
                <div class="my-3">
                    <label for="text_senha_1">Senha</label>
                    <input type="password" name="text_senha" id="text_senha" placeholder="Senha" class="form-control" required>
                </div>


                <!-- Summit -->
                <div class="my-4 text-center">
                    <input type="submit" value="Login" class="btn btn-primary px-4">
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
