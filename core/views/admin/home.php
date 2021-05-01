<div class="container-fluid">
    <div class="row mt-3">
        <div class="col-md-3"><?php include(__DIR__ . "/layouts/side-menu-admin.php"); ?></div>
        <div class="col-md-9">

            <h3>Encomendas Pendentes:</h3>
            <?php if($total_encomendas_pendentes > 0): ?>
                <div class="alert alert-info" role="alert">
                    <span class="me-2">Existem encomendas pendentes: <?= $total_encomendas_pendentes ?></span><span><a href="?a=lista-encomendas&f=pendentes">Ver</a></span>
                </div>
            <?php else: ?>
                <div class="alert alert-danger" role="alert">
                    Não existem encomendas pendentes.
                </div>
            <?php endif; ?>

            <h3>Encomendas Em Processamento:</h3>
            <?php if($total_encomendas_processamento > 0): ?>
                <div class="alert alert-info" role="alert">
                    <span class="me-2">Existem encomendas em processamento: <?= $total_encomendas_processamento ?></span><span><a href="?a=lista-encomendas&f=processamento">Ver</a></span>
                </div>
            <?php else: ?>
                <div class="alert alert-danger" role="alert">
                    Não existem encomendas processamento.
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>
