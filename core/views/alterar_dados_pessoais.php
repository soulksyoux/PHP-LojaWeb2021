
<div class="container-fluid">
    <div class="row my-5">
        <div class="col-sm-6 offset-sm-3 mb-5">
            <h3 class="text-center"><?= "Alterar dados pesssoais"; ?></h3>

            <form action="?a=gravar_dados_pessoais" method="post">

                <!-- Email -->
                <div class="my-3">
                    <label for="text_email">Email</label>
                    <input type="email" maxlength="100" name="text_email" id="text_email" placeholder="Email" class="form-control" value="<?= $cliente->email; ?>" required>
                </div>

                <!-- Nome completo -->
                <div class="my-3">
                    <label for="text_nome_completo">Nome completo</label>
                    <input type="text" maxlength="255" name="text_nome_completo" id="text_nome_completo" placeholder="Nome completo" class="form-control" value="<?= $cliente->nome ?>"required>
                </div>

                <!-- Morada -->
                <div class="my-3">
                    <label for="text_morada">Morada</label>
                    <input type="text" maxlength="255" name="text_morada" id="text_morada" placeholder="Morada" class="form-control" value="<?= $cliente->morada ?>"required>
                </div>

                <!-- Cidade -->
                <div class="my-3">
                    <label for="text_cidade">Cidade</label>
                    <input type="text" maxlength="80" name="text_cidade" id="text_cidade" placeholder="Cidade" class="form-control" value="<?= $cliente->cidade ?>" required>
                </div>

                <!-- Telefone -->
                <div class="my-3">
                    <label for="text_telefone">Telefone</label>
                    <input type="text" maxlength="50" name="text_telefone" id="text_telefone" placeholder="Telefone" class="form-control" value="<?= $cliente->telefone ?>">
                </div>

                <!-- Summit -->
                <div class="my-4">
                    <input type="submit" value="Gravar dados" class="btn btn-primary">
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
