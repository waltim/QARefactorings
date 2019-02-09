<!-- Small boxes (Stat box) -->
<div class="row">
  <?php if ($this->Session->read('Auth.User.UserType.description') != 'candidato') { ?>
  <div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-blue">
      <div class="inner">
        <h3>
          <?= $transformations ?><sup style="font-size: 20px"></sup></h3>
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
        <h3>
          <?= $users ?>
        </h3>

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
    <?php if ($this->Session->read('Auth.User.UserType.description') == 'candidato') { ?>
      <div class="inner">
        <h3>
          <?= ((($transformations*$questions)-$answers)/$questions)-9 ?>
        </h3>

        <p>Transformações a serem avaliadas </p>
      </div>
      <?php
		  }else{ ?>
      <div class="inner">
        <h3>
          <?= $answers ?>
        </h3>

        <p>Respostas</p>
      </div>
      <?php
		  } ?>
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
        <h3>
          <?= $questions ?>
        </h3>
        <?php if ($this->Session->read('Auth.User.UserType.description') == 'candidato') { ?>
        <p>Questões por transformação</p>
        <?php }elseif($this->Session->read('Auth.User.UserType.description') == 'pesquisador'){ ?>
        <p>Minhas questões</p>
        <?php }else{ ?>
        <p>Questões</p>
        <?php }?>
      </div>
      <div class="icon">
        <i class="ion ion-stats-bars"></i>
      </div>
    </div>
  </div>
  <?php if($totalQuestions > 0 && $this->Session->read('Auth.User.UserType.description') == 'administrador'){ ?>
  <div class="col-md-6 pull-right">
    <div class="box">
      <div class="box-header">
        <h3 class="box-title">Progresso de usuários por questões respondidas</h3>
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
							foreach ($ranking as $user) { if($user['User']['trophy'] > 0){ ?>
          <tr>
            <td>
              <?= $position ?>.</td>
            <td>
              <?= $user['User']['email']; ?>
            </td>
            <td>
              <?php
										$calculo = ceil(($user['User']['trophy'] * 100) / ($totalQuestions/2));
										if($calculo > 66){
											$calculo = 100;
										}
										?>
              <?= $calculo ?>%
              <div class="progress progress-xs progress-striped active">
                <div class="progress-bar progress-bar-primary" style="width: <?= $calculo ?>%"></div>
              </div>
            </td>
            <td><span class="badge bg-light-blue">
                <?= $user['User']['trophy']; ?></span></td>
          </tr>
          <?php $position++;
						}} ?>
        </table>
      </div>
      <!-- /.box-body -->
    </div>
  </div>
  <?php } ?>

  <?php if($totalQuestions > 0 && $this->Session->read('Auth.User.UserType.description') == 'candidato'){ ?>
  <div class="col-md-6 pull-right">
    <div class="box">
      <div class="box-header">
        <h3 class="box-title">Progresso por questões respondidas</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body no-padding">
        <table class="table table-condensed">
          <tr>
            <th>Usuário</th>
            <th>Progresso</th>
            <th style="width: 40px">Total</th>
          </tr>
          <tr>
            <td>
              <?= $ranking2['User']['email']; ?>
            </td>
            <td>
              <?php
				$calculo = ceil(($ranking2['User']['trophy'] * 100) / $totalQuestions);
				if($calculo > 100 || $ranking2['User']['trophy'] == 66){
					$calculo = 100;
				}
			  ?>
              <?= $calculo ?>%
              <div class="progress progress-xs progress-striped active">
                <div class="progress-bar progress-bar-primary" style="width: <?= $calculo ?>%"></div>
              </div>
            </td>
            <td><span class="badge bg-light-blue">
                <?= $ranking2['User']['trophy']; ?></span></td>
          </tr>
        </table>
      </div>
      <!-- /.box-body -->
    </div>
  </div>
  <?php } ?>
  <div class="col-md-12">
    <div class="box">
      <div class="box-header">
        <h1 class="box-title" style="font-size: 30px!important">OBRIGADO PELA CONTRIBUIÇÃO! =)</h1>
      </div>
      <!-- /.box-header -->
      <div class="box-body no-padding">
        <p style="text-align:justify; font-weight: 600; font-size: 16px;">
          Além da contribuição acadêmica através do projeto de pesquisa,
          Os pesquisadores responsáveis decidiram realizar a doação de um valor (quantia em dinheiro)
          arrecadada durante a execução do Survey. Foi decidido que será doado ao Projeto Educar Capoeira R$ 500,00 (quinhentos reais)
          ao fim da execução do Survey.
        </p>
        <!-- /.box-body -->
      </div>
    </div>
  </div>
  <!-- /.box -->
  <!-- ./col -->
</div>