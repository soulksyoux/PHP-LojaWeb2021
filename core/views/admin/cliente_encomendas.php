<div class="container-fluid">
    <div class="row my-5">
        <div class="col-md-2"><?php include(__DIR__ . "/layouts/side-menu-admin.php"); ?></div>
        <?php if($cliente == []): ?>
            <h5>Cliente nulo</h5>
        <?php else: ?>
            <?php if(!empty($encomendas_cliente)): ?>
                <div class="col-md-10">
                    <h4 class="mb-4" id="teste">Encomendas do utilizador <strong><?= $cliente->nome; ?></strong><span> (<a href="emailto:"><?= $cliente->email; ?></a>)</span></h4>

                    <small>
                        <table class="table table-hover table-striped table-sm" id="tabela-encomendas">
                            <thead>
                            <tr class="table-dark">
                                <th>Cod</th>
                                <th>Data</th>
                                <th>Morada</th>
                                <th>Cidade</th>
                                <th>Telefone</th>
                                <th>Mensagem</th>
                                <th>Status</th>
                                <th>Criado em</th>
                                <th>Atualizado em</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($encomendas_cliente as $encomenda): ?>
                                <tr>
                                    <td><?= $encomenda->cod_encomenda; ?></td>
                                    <td><?= $encomenda->data_encomenda; ?></td>
                                    <td><?= $encomenda->morada; ?></td>
                                    <td><?= $encomenda->cidade; ?></td>
                                    <td><?= $encomenda->telefone; ?></td>
                                    <td><?= $encomenda->mensagem; ?></td>
                                    <td><?= $encomenda->status; ?></td>
                                    <td><?= $encomenda->created_at; ?></td>
                                    <td><?= $encomenda->updated_at; ?></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </small>
                </div>
            <?php else: ?>
                <p>Sem encomendas para apresentar...</p>
            <?php endif; ?>
        <?php endif; ?>
        <div class="offset-2">
            <a href="?a=detalhe-cliente&i=<?= $cliente->id_cliente; ?>">Voltar</a>
        </div>
    </div>

    <?php if(!empty($_SESSION["erro"])): ?>
        <div class="alert alert-danger text-center p-2">
            <?= $_SESSION["erro"] ?>
            <?php unset($_SESSION["erro"]); ?>
        </div>
    <?php endif; ?>
</div>
