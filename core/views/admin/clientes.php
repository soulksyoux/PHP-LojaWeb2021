<div class="container-fluid">
    <div class="row mt-3">
        <div class="col-md-2"><?php include(__DIR__ . "/layouts/side-menu-admin.php"); ?></div>
        <div class="col-md-10 pe-5">

            <h3>Lista de clientes:</h3>

            <hr>

            <?php if(!empty($clientes)): ?>
                <p id="teste">Apresenta os Clientes</p>
                <small>
                    <table class="table table-hover table-striped table-sm" id="tabela-clientes">
                        <thead>
                        <tr class="table-dark">
                            <th>Id</th>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Telefone</th>
                            <th class="text-center">Total Encomendas</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Eliminado em</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($clientes as $cliente): ?>
                            <tr>
                                <td><?= $cliente->id_cliente; ?></td>
                                <td><a class="text-decoration-none" href="?a=detalhe-cliente&i=<?= $cliente->id_cliente; ?>"><?= $cliente->nome; ?></a></td>
                                <td><?= $cliente->email; ?></td>
                                <td><?= $cliente->telefone; ?></td>
                                <td class="text-center"><?= ($cliente->total_encomendas > 0) ? ("<a href='?a=lista-encomendas&id=" . \core\classes\Store::aesEncriptar($cliente->id_cliente) . "' class='text-decoration-none'>" . $cliente->total_encomendas . "</a>") : "-" ?></td>
                                <td class="text-center"><?= ($cliente->ativo == 1) ? "<i class='fas fa-check text-success'></i>" : "<i class='fas fa-times text-danger'></i>" ?></td>
                                <td><?= $cliente->deleted_at; ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </small>
            <?php else: ?>
                <p>Sem clientes para apresentar...</p>
            <?php endif; ?>

        </div>

        <?php if(!empty($_SESSION["erro"])): ?>
            <div class="alert alert-danger text-center p-2">
                <?= $_SESSION["erro"] ?>
                <?php unset($_SESSION["erro"]); ?>
            </div>
        <?php endif; ?>
    </div>
</div>

