<div class="container-fluid">
    <div class="row my-5">
        <div class="col-md-3"><?php include(__DIR__ . "/layouts/side-menu-admin.php"); ?></div>
        <?php if($encomenda == []): ?>
            <h5>Encomenda vazia</h5>
        <?php else: ?>



            <div class="col-sm-6">
                <!-- Modal -->
                <div class="modal fade" id="estados_modal" tabindex="-1" aria-labelledby="estados_modal_label" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="estados_modal_label">Estados Encomenda:</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <ul>
                                    <?php foreach (STATUS as $estado): ?>
                                        <li>
                                            <?php if($encomenda->status != mb_strtolower($estado)): ?>
                                                <a href='?a=alterar_estado_encomenda&i=<?= \core\classes\Store::aesEncriptar($encomenda->cod_encomenda)?>&e=<?= $estado ?>' class='text-decoration-none'><?= $estado; ?></a>
                                            <?php else: ?>
                                                <?= $estado ?>
                                            <?php endif; ?>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            </div>
                        </div>
                    </div>
                </div>

                <h3 class="text-center mb-4"><?= "Detalhe do encomenda Cod: " . $encomenda->cod_encomenda; ?></h3>
                <div class="border p-3">
                    <div><strong>Id Cliente: </strong><?= $encomenda->id_cliente; ?></div>
                    <div><strong>Data: </strong><?= $encomenda->data_encomenda ?></div>
                    <div><strong>Morada: </strong><?= $encomenda->morada; ?></div>
                    <div><strong>Telefone: </strong><?= $encomenda->telefone; ?></div>
                    <div><strong>Cidade: </strong><?= $encomenda->cidade; ?></div>
                    <div><strong>Mensagem: </strong><?= $encomenda->mensagem; ?></div>
                    <div><strong>Status: </strong><?= $encomenda->status; ?></div>
                    <div><strong>Atualizado em: </strong><?= $encomenda->updated_at; ?></div>

                </div>
            </div>

            <div class="col-sm-3 text-center">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#estados_modal">
                    Alterar Estado
                </button>
            </div>


            <div class="offset-3 col-6 mt-4">
                <table id="table_encomenda_produtos" class="table table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>Produto</th>
                            <th>Preco</th>
                            <th>Quantidade</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($lista_produtos_encomenda as $produto): ?>
                            <tr>
                                <td><?= $produto->designacao_produto; ?></td>
                                <td><?= $produto->preco_unitario; ?></td>
                                <td><?= $produto->quantidade; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>


            <div class="row my-5">
                <div class="text-center">
                    <a href="?a=encomendas" class="btn btn-primary">Voltar para Encomendas</a>
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
