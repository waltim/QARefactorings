<div class="row">
    <div class="col-md-12">
        <!-- The time line -->
        <ul class="timeline">
            <!-- timeline time label -->
            <li class="time-label">
                  <span class="bg-blue">
                    Dados da transformação
                  </span>
            </li>
            <!-- /.timeline-label -->
            <!-- timeline item -->
            <li>
                <i class="fa fa-code bg-aqua"></i>

                <div class="timeline-item">
                    <!-- <span class="time"><i class="fa fa-clock-o"></i> 12:05</span> -->

                    <h3 class="timeline-header"><a><?= $transformation['Language']['description'] ?></a></h3>

                    <div class="timeline-body">
                        <p><b>Pesquisa:</b> <?= $transformation['SearchEvent']['title'] ?></p>
                        <p><b>Tipo de transformação:</b> <?= $transformation['TransformationType']['description'] ?></p>
                        <p><b>Data
                                cadastro:</b> <?= date('d/m/Y', strtotime($transformation['Transformation']['created'])); ?>
                        </p>
                    </div>
                    <div class="timeline-footer">
                        <!-- <a class="btn btn-primary btn-xs">editar</a>
                                          <a class="btn btn-danger btn-xs">deletar</a> -->
                        .
                    </div>
                </div>
            </li>
            <!-- END timeline item -->
            <!-- timeline item -->
            <li>
                <i class="fa fa-code bg-blue"></i>

                <div class="timeline-item">
                    <!-- <span class="time"><i class="fa fa-clock-o"></i> 5 mins ago</span> -->

                    <h3 class="timeline-header no-border"><a>Códigos</a></h3>
                    <div class="timeline-body">
                        <div class="col-md-12">
                            <h3>Código anterior</h3>
                            <?php
                            $codigoAntigo = str_replace("&nbsp; }", "}", $transformation['Transformation']['code_before']);
                            $codigoAntigo = strip_tags($codigoAntigo, '<br>');
                            ?>
                            <code id="codigo1"
                                  class="brush: <?= $transformation['Language']['brush']; ?>"><?php echo $codigoAntigo; ?></code>
                            <form class="form-horizontal" method="post"
                                  action="<?= $this->webroot ?>transformations/view/<?= $transformation['Transformation']['id']; ?>">
                                <div class="box-body">
                                    <div class="form-group">
                                        <input name="data[Transformation][deletions]"
                                               value="<?= $transformation['Transformation']['deletions'] ?>" required
                                               type="text" class="form-control"
                                               placeholder="Destacar uma linha, ex: 1 ou para varias linhas, ex: 1,2,3...n">
                                        <button type="submit" class="btn btn-info">Atualizar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-12">
                            <h3>Código transformado</h3>
                            <?php
                            $codigoDepois = str_replace("&nbsp; }", "}", $transformation['Transformation']['code_after']);
                            $codigoDepois = strip_tags($codigoDepois, '<br>');
                            ?>
                            <code id="codigo2"
                                  class="brush: <?= $transformation['Language']['brush']; ?>"><?php echo $codigoDepois; ?></code>
                            <form class="form-horizontal" method="post"
                                  action="<?= $this->webroot ?>transformations/view/<?= $transformation['Transformation']['id']; ?>">
                                <div class="box-body">
                                    <div class="form-group">
                                        <input name="data[Transformation][additions]"
                                               value="<?= $transformation['Transformation']['additions'] ?>" required
                                               type="text" class="form-control"
                                               placeholder="Destacar uma linha, ex: 1 ou para varias linhas, ex: 1,2,3...n">
                                        <button type="submit" class="btn btn-info">Atualizar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="timeline-footer">
                        .
                    </div>
                </div>
            </li>
            <!-- END timeline item -->
            <!-- timeline item -->
            <!-- <li>
              <i class="fa fa-comments bg-yellow"></i>

              <div class="timeline-item">
                <span class="time"><i class="fa fa-clock-o"></i> 27 mins ago</span>

                <h3 class="timeline-header"><a href="#">Jay White</a> commented on your post</h3>

                <div class="timeline-body">
                  Take me to your leader!
                  Switzerland is small and neutral!
                  We are more like Germany, ambitious and misunderstood!
                </div>
                <div class="timeline-footer">
                  <a class="btn btn-warning btn-flat btn-xs">View comment</a>
                </div>
              </div>
            </li> -->
            <!-- END timeline item -->
            <!-- timeline time label -->
            <li class="time-label">
                  <span class="bg-blue">
                    Métricas Quantitativas
                  </span>
            </li>
            <!-- /.timeline-label -->
            <!-- timeline item -->
            <li>
                <i class="fa fa-pie-chart bg-purple"></i>

                <div class="timeline-item">
                    <!-- <span class="time"><i class="fa fa-clock-o"></i> 2 days ago</span> -->

                    <h3 class="timeline-header"><a>Detalhe e resultados</a></h3>

                    <div class="timeline-body">
                        <?php foreach ($quantitativas as $key => $metrica) { ?>
                            <p><b><?= $metrica['Metric']['acronym'] ?>:</b> <?= $metrica['Metric']['description'] ?></p>
                            <b>Resultados</b> --> <b>Antes:</b> <?= $metrica['Result']['before']; ?> |
                            <b>Depois:</b> <?= $metrica['Result']['after']; ?>
                        <?php } ?>
                    </div>
                    <div class="timeline-footer">
                        .
                    </div>
                </div>
            </li>
            <li class="time-label">
                  <span class="bg-blue">
                    Métricas Qualitativas
                  </span>
            </li>
            <!-- /.timeline-label -->
            <!-- timeline item -->
            <li>
                <i class="fa fa-pie-chart bg-purple"></i>

                <div class="timeline-item">
                    <!-- <span class="time"><i class="fa fa-clock-o"></i> 2 days ago</span> -->

                    <h3 class="timeline-header"><a>Detalhe e respostas</a></h3>

                    <div class="timeline-body">
                        <?php foreach ($qualitativas as $key => $metrica) { ?>
                            <p><b><?= $metrica['Metric']['acronym'] ?>:</b> <?= $metrica['Metric']['description'] ?></p>
                        <?php } ?>
                    </div>
                    <div class="timeline-footer">
                        .
                    </div>
                </div>
            </li>
            <!-- <li>
  <i class="fa fa-camera bg-purple"></i>

  <div class="timeline-item">
    <span class="time"><i class="fa fa-clock-o"></i> 2 days ago</span>

    <h3 class="timeline-header"><a href="#">Mina Lee</a> uploaded new photos</h3>

    <div class="timeline-body">
      <img src="http://placehold.it/150x100" alt="..." class="margin">
      <img src="http://placehold.it/150x100" alt="..." class="margin">
      <img src="http://placehold.it/150x100" alt="..." class="margin">
      <img src="http://placehold.it/150x100" alt="..." class="margin">
    </div>
  </div>
</li> -->
            <!-- END timeline item -->
            <!-- timeline item -->
            <!-- <li>
              <i class="fa fa-video-camera bg-maroon"></i>

              <div class="timeline-item">
                <span class="time"><i class="fa fa-clock-o"></i> 5 days ago</span>

                <h3 class="timeline-header"><a href="#">Mr. Doe</a> shared a video</h3>

                <div class="timeline-body">
                  <div class="embed-responsive embed-responsive-16by9">
                    <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/tMWkeBIohBs"
                            frameborder="0" allowfullscreen></iframe>
                  </div>
                </div>
                <div class="timeline-footer">
                  <a href="#" class="btn btn-xs bg-maroon">See comments</a>
                </div>
              </div>
            </li> -->
            <!-- END timeline item -->
            <li>
                <i class="fa fa-clock-o bg-gray"></i>
            </li>
        </ul>
    </div>
    <!-- /.col -->
</div>
<!-- /.row -->
<?php if (isset($respostas)) { ?>
    <div class="row" style="margin-top: 10px;">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title"><i class="fa fa-check-circle-o"></i> Tabela de respostas</h3>
                </div>
                <div class="box-body">
                    <table id="example2" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>Usuário</th>
                            <th>Questão</th>
                            <th>Escolha</th>
                            <th>Justificativa</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($respostas as $resp) { ?>
                            <tr>
                                <td><?= $resp['User']['email'] ?></td>
                                <td><?= $resp['ResultQuestion']['question_id'] ?></td>
                                <td><?= $resp['Answer']['choice'] ?></td>
                                <td><?= $resp['Answer']['justify'] ?></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>Usuário</th>
                            <th>Questão</th>
                            <th>Escolha</th>
                            <th>Justificativa</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="timeline-footer">
                    .
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
<?php } ?>