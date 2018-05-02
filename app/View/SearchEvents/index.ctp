<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Pesquisas</h3>
            </div>
            <div class="text-right" style="margin-right: 1%;">
                <a href="/searchEvents/add">
                    <button type="button" class="btn btn-primary">Nova pesquisa</button>
                </a>
            </div>
            <div class="clearfix"></div>
            <!-- /.box-header -->
            <div class="box-body">
                <table id="example2" class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>Pesquisador</th>
                        <th>Titulo</th>
                        <th>Escola</th>
                        <th>Ações</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($pesquisas as $pesquisa) { ?>
                        <tr>
                            <td><?= $pesquisa['User']['name'] ?></td>
                            <td><?= $pesquisa['SearchEvent']['title'] ?></td>
                            <td>
                                <?= $pesquisa['SearchEvent']['school'] ?>
                            </td>
                            <td>
                                <?php if ($pesquisa['Participant']['participant_type_id'] == 1) { ?>
                                    <a href="<?= $this->webroot ?>searchEvents/edit/<?= $pesquisa['SearchEvent']['id'] ?>"
                                       title="Editar">
                                        <i class="fa fa-edit fa-lg"></i>
                                    </a>
                                    <a href="<?= $this->webroot ?>searchEvents/delete/<?= $pesquisa['SearchEvent']['id'] ?>"
                                       onclick="return confirm('Tem certeza?')" title="Deletar">
                                        <i class="fa fa-eraser fa-lg"></i>
                                    </a>

                                    <a href="<?= $this->webroot ?>transformations/add/<?= $pesquisa['SearchEvent']['id'] ?>"
                                       title="Cadastrar transformações">
                                        <i class="fa fa-save fa-lg"></i>
                                    </a>
                                <?php } else { ?>
                                    <a href="<?= $this->webroot ?>transformations/add/<?= $pesquisa['SearchEvent']['id'] ?>"
                                       title="Cadastrar transformações">
                                        <i class="fa fa-save fa-lg"></i>
                                    </a>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>Pesquisador</th>
                        <th>Titulo</th>
                        <th>Escola</th>
                        <th>Ações</th>
                    </tr>
                    </tfoot>
                </table>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col -->
</div>
