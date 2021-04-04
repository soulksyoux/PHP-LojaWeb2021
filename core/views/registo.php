<div class="container-fluid">
    <div class="row my-5">
        <div class="col-sm-6 offset-sm-3">
            <h3 class="text-center"><?= "Registar novo user"; ?></h3>

            <form action="?a=registar_user" method="post">

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

                <!-- Senha2 -->
                <div class="my-3">
                    <label for="text_senha_2">Confirmar senha</label>
                    <input type="password" name="text_senha_2" id="text_senha_2" placeholder="Confirme a Senha" class="form-control" required>
                </div>

                <!-- Nome completo -->
                <div class="my-3">
                    <label for="text_nome_completo">Nome completo</label>
                    <input type="text" name="text_nome_completo" id="text_nome_completo" placeholder="Nome completo" class="form-control" required>
                </div>

                <!-- Morada -->
                <div class="my-3">
                    <label for="text_morada">Morada</label>
                    <input type="text" name="text_morada" id="text_morada" placeholder="Morada" class="form-control" required>
                </div>

                <!-- Cidade -->
                <div class="my-3">
                    <label for="text_cidade">Cidade</label>
                    <input type="text" name="text_cidade" id="text_cidade" placeholder="Cidade" class="form-control" required>
                </div>

                <!-- Telefone -->
                <div class="my-3">
                    <label for="text_telefone">Telefone</label>
                    <input type="text" name="text_telefone" id="text_telefone" placeholder="Telefone" class="form-control">
                </div>

                <!-- Summit -->
                <div class="my-4">
                    <input type="submit" value="Criar conta" class="btn btn-primary">
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
