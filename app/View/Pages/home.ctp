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
          <?= (($transformations*$questions)-$answers)/$questions ?>
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
							foreach ($ranking as $user) { ?>
          <tr>
            <td>
              <?= $position ?>.</td>
            <td>
              <?= $user['User']['email']; ?>
            </td>
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
            <td><span class="badge bg-light-blue">
                <?= $user['User']['trophy']; ?></span></td>
          </tr>
          <?php $position++;
						} ?>
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
										if($calculo > 100){
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
        <h3 class="box-title">Arrecadação de fundos para o Projeto Educar Capoeira</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body no-padding">
        <p style="text-align:justify; font-weight: 600; font-size: 16px;">
          Além da contribuição acadêmica através do projeto de pesquisa,
          Os pesquisadores responsáveis decidiram realizar a doação de um valor (quantia em dinheiro)
          arrecadada durante a execução do Survey. Foi decidido que será doado ao Projeto Educar Capoeira R$ 10,00
          para cada participante que responder as questões do Survey até o final.
        </p>
        <!-- /.box-body -->
      </div>
    </div>
  </div>
  <div class="col-md-12">
    <div class="box">
      <div class="box-header">
        <h3 class="box-title">Projeto Educar Capoeira</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body no-padding">
        <p style="text-align:justify;">
          A Associação Sociocultural e Desportiva Arte do Saber - ASDAS, cujo nome fantasia é Grupo Arte Luta Brasil de
          Capoeira, fundada em 09/12/2012, porém em atividade desde 2002, inscrita no CNPJ.: 17.375.468/0001-63, com
          sede em Brasília, é uma entidade não governamental e sem fins lucrativos e econômicos. A associação tem como
          propósito, contribuir com a melhoria da qualidade de vida e dignidade de
          crianças, adolescentes, jovens, adultos através de suas ações e projetos, proporcionando com o desenvolvimento da igualdade,
          oportunidades e valorização humana, onde os alunos assistidos, familiares e comunidade em geral têm a
          oportunidade de praticar atividade física de forma saudável.
        </p>
        <p style="text-align:justify;">
          A principal atividade da Associação é o Projeto Educar Capoeira. A Capoeira é uma arte/luta/esporte incluído no
          nosso folclore, surgida entre os escravos procedentes de Angola, em meados dos séculos XVII e XVIII, que a
          partir dela reuniam-se e ganhavam perspectivas de se organizarem como grupo social. Essa pratica
          proporcionava-lhes melhora na autoestima e força para romper o ciclo da escravidão. Luta, dança, ritmo,
          vigor físico, os negros criaram a Capoeira tanto para servir ao prazer quanto ao combate. Realizaram na
          própria carne essa imagem de vida, fundamental até hoje.
        </p>
        <p style="text-align:justify; text-indent:4em; font-weight: 600;">
          “A capoeira é atitude brasileira que reconhece uma história escrita pelo corpo, pelo ritmo e pela imensa
          natureza libertária do homem frente à intolerância”. (GIL, 2004).
        </p>
        <p style="text-align:justify;">
          A capoeira tem provado sua importância e seu peso histórico brasileiro, uma vez reconhecido pela
          Constituição de 1988 e PCN- Parâmetro Curriculares Nacionais, sendo este esporte/luta parte integrante do
          folclore nacional e considerada patrimônio cultural em 2008 pelo IPHAN –Instituto do Patrimônio Histórico e
          Artístico Nacional.
        </p>
        <div class="col-md-10 col-md-offset-1">
          <a id="single_image" href="<?=$this->webroot?>images/WhatsApp Image 2018-12-12 at 08.59.21.jpeg">
            <img style="max-width:200px; height: 179px;" src="<?=$this->webroot?>images/WhatsApp Image 2018-12-12 at 08.59.21.jpeg" alt="" /></a>
          <a id="single_image" href="<?=$this->webroot?>images/WhatsApp Image 2018-12-12 at 08.59.20.jpeg">
            <img style="max-width:200px; height: 179px;" src="<?=$this->webroot?>images/WhatsApp Image 2018-12-12 at 08.59.20.jpeg" alt="" /></a>
          <a id="single_image" href="<?=$this->webroot?>images/WhatsApp Image 2018-12-12 at 08.59.26.jpeg">
            <img style="max-width:200px; height: 179px;" src="<?=$this->webroot?>images/WhatsApp Image 2018-12-12 at 08.59.26.jpeg" alt="" /></a>
          <a id="single_image" href="<?=$this->webroot?>images/WhatsApp Image 2018-12-12 at 10.45.30.jpeg">
            <img style="max-width:200px; height: 179px;" src="<?=$this->webroot?>images/WhatsApp Image 2018-12-12 at 10.45.30.jpeg" alt="" /></a>
          <a id="single_image" href="<?=$this->webroot?>images/45333789_1738048686341629_1514006010841268224_o.jpg">
            <img style="max-width:200px; height: 179px;" src="<?=$this->webroot?>images/45333789_1738048686341629_1514006010841268224_o.jpg"
              alt="" /></a>
        </div>
        <div class="clearfix"></div>
        <br><br>
        <p>
          Instagram: <a href="https://www.instagram.com/projeto_educar_capoeira/" target="_blank">
            https://www.instagram.com/projeto_educar_capoeira/
          </a>
          <br>
          Brasil Cnpj: <a href="https://www.brasilcnpj.com/empresa/associacao-socio-cultural-e-desportiva-arte-do-saber-asdas/cauKnfvAB"
            target="_blank">
            https://www.brasilcnpj.com/empresa/associacao-socio-cultural-e-desportiva-arte-do-saber-asdas/cauKnfvAB
          </a>
        </p>
      </div>
      <!-- /.box-body -->
    </div>
  </div>
  <!-- /.box -->
  <!-- ./col -->
</div>