<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Tabela de respostas</h3>
                <a href="/answers/respostas/<?= $pesquisa ?>">
                    <button type="button" class="btn btn-primary pull-right">Respostas</button>
                </a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <table id="example2" class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>Participante</th>
                        <th>Sexo</th>
                        <th>Formação</th>
                        <th>Profissão</th>
                        <th>Experiência em anos</th>
                        <th>Código da Transformação</th>
                        <th>Tipo da transformação</th>
                        <th>Questão</th>
                        <th>Opção escolhida</th>
                        <th>Justificativa</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($answers as $answer) { //pr($answer);exit(); ?>
                        <tr>
                            <td><?= 'P' . $answer['User']['id'] ?></td>
                            <td><?= $answer['User']['sex'] ?></td>
                            <td><?= $answer['User']['formation'] ?></td>
                            <td><?= $answer['User']['profession'] ?></td>
                            <td><?= $answer['User']['UserLanguage']['experience'] ?></td>
                            <td><?= $answer['ResultQuestion']['Result']['Transformation']['id'] ?></td>
                            <td><?= 'T' . $answer['ResultQuestion']['Result']['Transformation']['TransformationType']['id'] ?></td>
                            <td>
                                <?= 'Q' . $answer['ResultQuestion']['Question']['id'] ?>
                            </td>
                            <td>
                                <?php
                                echo $answer['Answer']['choice'];
                                ?>
                            </td>
                            <td>
                                <?php
                                if ($answer['Answer']['justify'] == 'N/A') {
                                    echo "no reply";
                                } else {
                                    echo $answer['Answer']['justify'];
                                }
                                ?>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>Participante</th>
                        <th>Sexo</th>
                        <th>Formação</th>
                        <th>Profissão</th>
                        <th>Experiência em anos</th>
                        <th>Código da Transformação</th>
                        <th>Tipo da transformação</th>
                        <th>Questão</th>
                        <th>Opção escolhida</th>
                        <th>Justificativa</th>
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
