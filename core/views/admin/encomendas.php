<div class="container-fluid">
    <div class="row mt-3">
        <div class="col-md-2"><?php include(__DIR__ . "/layouts/side-menu-admin.php"); ?></div>
        <div class="col-md-10 pe-5">

            <h3>Lista de encomendas<?= (!empty($filtro)) ? " - " . ucfirst($filtro) : "";  ?>:</h3>

            <?php if(!empty($encomendas)): ?>
                <p id="teste">Apresenta as encomendas</p>
                <small>
                    <table class="table table-hover table-striped table-sm" id="tabela-encomendas">
                        <thead>
                        <tr class="table-dark">
                            <th>Cod</th>
                            <th>Data</th>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Telefone</th>
                            <th>Status</th>
                            <th>Atualizado em</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($encomendas as $encomenda): ?>
                            <tr>
                                <td><?= $encomenda->cod_encomenda; ?></td>
                                <td><?= $encomenda->data_encomenda; ?></td>
                                <td><?= $encomenda->nome; ?></td>
                                <td><?= $encomenda->email; ?></td>
                                <td><?= $encomenda->telefone; ?></td>
                                <td><?= $encomenda->status; ?></td>
                                <td><?= $encomenda->updated_at; ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </small>
            <?php else: ?>
                <p>Sem encomendas para apresentar...</p>
            <?php endif; ?>

        </div>
    </div>
</div>
