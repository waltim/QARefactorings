<?php
$variable = new TransformationsController();
?>
      <div class="row">
        <div class="col-md-12">
          <!-- The time line -->
          <ul class="timeline">
            <!-- timeline time label -->
            <li class="time-label">
                  <span class="bg-red">
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
								 <p><b>Responsável:</b> <?= $transformation['User']['email'] ?></p>
								 <p><b>Tipo de transformação:</b> <?= $transformation['TransformationType']['description'] ?></p>
								 <p><b>Data cadastro:</b> <?= date('d/m/Y', strtotime($transformation['Transformation']['created'])); ?></p>
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
									$i = 0;
									$contador = count($variable->identCode($transformation['Transformation']['code_before']));
									foreach ($variable->identCode($transformation['Transformation']['code_before']) as $linha) {
										$final = substr($linha, -1);
										if ($i == 0) {
											echo "<pre class='brush: java;'>";
										}
										if($final == "{" || $final == "}"){
											echo $linha;
											echo "\n";
										}else{
											echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$linha;
											echo "\n";
										}
										if ($i == ($contador - 1)) {
											echo "</pre>";
										}
										$i++;
									}
									?>
									</div>
										<div class="col-md-12">
										<h3>Código transformado</h3>
											<?php
										$i = 0;
										$contador = count($variable->identCode($transformation['Transformation']['code_after']));
										foreach ($variable->identCode($transformation['Transformation']['code_after']) as $linha) {
											$final = substr($linha, -1);
										if ($i == 0) {
											echo "<pre class='brush: java;'>";
										}
										if($final == "{" || $final == "}"){
											echo $linha;
											echo "\n";
										}else{
											echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$linha;
											echo "\n";
										}
										if ($i == ($contador - 1)) {
											echo "</pre>";
										}
										$i++;
										}
										?>
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
                  <span class="bg-green">
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
								<?php foreach($quantitativas as $key => $metrica){ ?>
										<p><b><?= $metrica['Metric']['acronym'] ?>:</b> <?= $metrica['Metric']['description'] ?></p>
										<b>Resultados</b> --> <b>Antes:</b> <?= $metrica['Result']['before'];?> | <b>Depois:</b> <?= $metrica['Result']['after']; ?>
								 <?php } ?>
								</div>
								<div class="timeline-footer">
									.
                </div>
              </div>
						</li>
						<li class="time-label">
                  <span class="bg-yellow">
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
								<?php foreach($qualitativas as $key => $metrica){ ?>
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

      <div class="row" style="margin-top: 10px;">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title"><i class="fa fa-check-circle-o"></i> Tabela de respostas</h3>
            </div>
            <div class="box-body">

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
