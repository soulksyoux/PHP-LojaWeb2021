<div class="container-fluid">
    <div class="row my-5">
        <?php if($cliente == []): ?>
            <h5>Cliente nulo</h5>
        <?php else: ?>
            <div class="col-sm-4 offset-sm-4 mb-5">
                <h3 class="text-center mb-4"><?= "Detalhe do cliente ID: " . $cliente->id_cliente; ?></h3>
                <div class="border p-3">
                    <div><strong>Nome: </strong><?= $cliente->nome; ?></div>
                    <div><strong>Email: </strong><?= "<a href='mailto:$cliente->email'>$cliente->email</a>" ?></div>
                    <div><strong>Morada: </strong><?= $cliente->morada; ?></div>
                    <div><strong>Telefone: </strong><?= $cliente->telefone; ?></div>
                    <div><strong>Cidade: </strong><?= $cliente->cidade; ?></div>
                    <div><strong>Estado: </strong><?= ($cliente->ativo == 1) ? "<span class='text-success'>Ativo</span>" : "<span class='text-danger'>Inativo</span>" ?></div>
                    <div><strong>Criado em: </strong><?= $cliente->created_at; ?></div>
                    <div><strong>Atualizado em: </strong><?= $cliente->updated_at; ?></div>
                    <div><strong>Eliminado em: </strong><?= $cliente->deleted_at; ?></div>
                </div>
            </div>

            <?php if(empty($encomendas_cliente)): ?>
            <div class="text-muted text-center m-0">Cliente ainda sem encomendas</div>
            <?php endif; ?>

            <div class="col-sm-6 offset-sm-3 my-5">
                <div class="text-center">
                    <?php if(!empty($encomendas_cliente)): ?>
                        <a href="?a=ver-encomendas-cliente&id=<?= \core\classes\Store::aesEncriptar($cliente->id_cliente) ?>" class="btn btn-primary">Ver encomendas</a>
                    <?php endif; ?>
                    <a href="?a=lista-clientes" class="btn btn-primary">Voltar para clientes</a>
                </div>
            </div>
        <?php endif; ?>

        <?php if(!empty($_SESSION["erro"])): ?>
            <div class="alert alert-danger text-center p-2">
                <?= $_SESSION["erro"] ?>
                <?php unset($_SESSION["erro"]); ?>
            </div>
        <?php endif; ?>
    </div>
</div>
