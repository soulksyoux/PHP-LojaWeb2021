<div class="container-fluid">
    <div class="row mt-3">
        <div class="col-md-2"><?php include(__DIR__ . "/layouts/side-menu-admin.php"); ?></div>
        <div class="col-md-10 pe-5">

            <h3>Lista de encomendas<?= (!empty($filtro)) ? " - " . ucfirst($filtro) : "";  ?>:</h3>

            <hr>


                <div class="d-flex justify-content-between">
                    <div>
                        <a href="?a=lista-encomendas" class="btn btn-primary btn-sm">Ver todas encomendas</a>
                    </div>
                        <div class="d-inline-flex">
                            <small class="w-100 me-2">Escolher o estado:</small>
                            <select onchange="filtrarStatus()" class="form-select form-select-sm" aria-label="Default select example" id="combo-status">
                                <option <?= (empty($filtro)) ? "selected" : "" ?>></option>
                                <option <?= ($filtro == 'pendente') ? "selected" : "" ?> value="pendente">Pendente</option>
                                <option <?= ($filtro == 'processamento') ? "selected" : "" ?> value="processamento">Em processamento</option>
                                <option <?= ($filtro == 'enviada') ? "selected" : "" ?> value="enviada">Enviada</option>
                                <option <?= ($filtro == 'cancelada') ? "selected" : "" ?> value="cancelada">Cancelada</option>
                                <option <?= ($filtro == 'finalizada') ? "selected" : "" ?> value="finalizada">Finalizado</option>
                            </select>
                        </div>

                </div>

            <hr>

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
