
      <!-- Small boxes (Stat box) -->
      <div class="row">
			<?php if ($this->Session->read('Auth.User.UserType.description') != 'candidato') { ?>
				<div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-blue">
            <div class="inner">
							<h3><?= $transformations ?><sup style="font-size: 20px"></sup></h3>
							<?php if ($this->Session->read('Auth.User.UserType.description') != 'pesquisador') { ?>
							<p>Transformações</p>
							<?php }else{ ?>
								<p>Minhas transformações</p>
								<?php } ?>
            </div>
            <div class="icon">
              <i class="ion ion-social-github"></i>
            </div>
          </div>
				</div>
			<?php
	} ?>
        <!-- ./col -->
				<?php if ($this->Session->read('Auth.User.UserType.description') == 'administrador') { ?>
				<div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-gray">
            <div class="inner">
              <h3><?= $users ?></h3>

              <p>Usuários cadastrados</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
          </div>
				</div>
				<?php
		} ?>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-blue">
            <div class="inner">
              <h3><?= $answers ?></h3>

              <p>Respostas</p>
            </div>
            <div class="icon">
              <i class="ion ion-ios-analytics"></i>
            </div>
          </div>
        </div>
				<!-- ./col -->

				<div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-gray">
            <div class="inner">
							<h3><?= $questions ?></h3>
							<?php if ($this->Session->read('Auth.User.UserType.description') != 'pesquisador') { ?>
							<p>Questões</p>
							<?php }else{ ?>
								<p>Minhas questões</p>
								<?php } ?>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
          </div>
				</div>
				<?php if($totalQuestions > 0){ ?>
				<div class="col-md-6 pull-right">
				<div class="box">
            <div class="box-header">
              <h3 class="box-title">Ranking de usuários por questões respondidas</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <table class="table table-condensed">
                <tr>
                  <th style="width: 10px">#</th>
                  <th>Usuário</th>
                  <th>Progresso</th>
                  <th style="width: 40px">Total</th>
								</tr>
								<?php $position = 1;
							foreach ($ranking as $user) { ?>
                <tr>
                  <td><?= $position ?>.</td>
                  <td><?= $user['User']['email']; ?></td>
                  <td>
										<?php
										$calculo = ceil(($user['User']['trophy'] * 100) / $totalQuestions);
										if($calculo > 100){
											$calculo = 100;
										}
										?>
										<?= $calculo ?>%
										<div class="progress progress-xs progress-striped active">
                      <div class="progress-bar progress-bar-primary" style="width: <?= $calculo ?>%"></div>
										</div>
                  </td>
                  <td><span class="badge bg-light-blue"><?= $user['User']['trophy']; ?></span></td>
								</tr>
								<?php $position++;
						} ?>
              </table>
            </div>
            <!-- /.box-body -->
					</div>
					</div>
					<?php } ?>
          <!-- /.box -->
        <!-- ./col -->
      </div>
