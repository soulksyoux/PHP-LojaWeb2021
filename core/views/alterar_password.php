
<div class="container-fluid">
    <div class="row my-5">
        <div class="col-sm-6 offset-sm-3 mb-5">
            <h3 class="text-center"><?= "Alterar password"; ?></h3>

            <form action="?a=gravar_password" method="post">

                <!-- Password Atual -->
                <div class="my-3">
                    <label for="text_password_atual">Password</label>
                    <input type="password" maxlength="30" name="text_password_atual" id="text_password_atual" placeholder="Password Atual" class="form-control" required>
                </div>

                <!-- Password Nova -->
                <div class="my-3">
                    <label for="text_password">Nova Password</label>
                    <input type="password" maxlength="30" name="text_password" id="text_password" placeholder="Nova Password" class="form-control" required>
                </div>

                <!-- Password Confirm -->
                <div class="my-3">
                    <label for="text_password2">Confirmar Password</label>
                    <input type="password" maxlength="30" name="text_password2" id="text_password2" placeholder="Confirmar Password" class="form-control" required>
                </div>

                <!-- Summit -->
                <div class="my-4">
                    <input type="submit" value="Gravar password" class="btn btn-primary">
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
