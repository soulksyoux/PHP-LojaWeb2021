<div class="container-fluid">
    <div class="row my-5">
        <div class="col-sm-12">
            <h3 class="text-center mb-4">Histório de Encomendas</h3>

            <?php if($encomendas == []): ?>
                <h5>Ainda sem encomendas...</h5>
            <?php else: ?>
                <table class="table table-striped table-hover">
                    <thead class="table-warning">
                    <tr>
                        <th>Código</th>
                        <th>Data</th>
                        <th>Status</th>
                        <th>Total</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($encomendas as $encomenda): ?>
                            <tr>
                                <td><?= $encomenda->cod_encomenda; ?></td>
                                <td><?= $encomenda->data_encomenda; ?></td>
                                <td><?= $encomenda->status; ?></td>
                                <td><?= number_format($encomenda->total, "2", ",",  ".") , "$"?></td>
                                <td><a href="?a=ver_detalhe_encomenda&id_encomenda=<?= \core\classes\Store::aesEncriptar($encomenda->id_encomenda); ?>">Ver detalhe</a></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="text-end text-secondary">Total de encomendas: <strong><?= count($encomendas); ?></strong></div>
            <?php endif; ?>



            <?php if(!empty($_SESSION["erro"])): ?>
                <div class="alert alert-danger text-center p-2">
                    <?= $_SESSION["erro"] ?>
                    <?php unset($_SESSION["erro"]); ?>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>
