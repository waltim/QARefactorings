      <div class="row">
        <div class="col-xs-12">
          <div class="box">
          <div class="box-header">
                <h3 class="box-title">Tabela de respostas</h3>
                <a href="/answers/respostas/<?=$pesquisa?>">
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
                  <th>Questão</th>
                  <th>Escolha</th>
                  <th>Justificativa</th>
                  <th>Linguagem</th>
                  <th>Tipo da transformação</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($answers as $answer){ //pr($answer);exit(); ?>
                <tr>
                  <td><?='P'.$answer['User']['id']?></td>
                  <td><?=$answer['User']['sex']?></td>
                  <td><?=$answer['User']['formation']?></td>
                  <td><?=$answer['User']['profession']?></td>
                  <td>
                  <?='Q'.$answer['ResultQuestion']['Question']['id']?>
                  </td>
                  <td>
                    <?php
                    if($answer['Answer']['choice'] == 'N/A'){
                      echo $answer['Answer']['choice'];
                    }else{
                      echo "OP".$answer['Answer']['choice'];
                    }
                    ?>
                  </td>
                  <td>
                    <?php
                      if($answer['Answer']['justify'] == 'N/A'){
                        echo "no reply";
                      }else{
                        echo "R = ".$answer['Answer']['justify'];
                      }
                    ?>
                  </td>
                  <td><?=$answer['ResultQuestion']['Result']['Transformation']['Language']['description']?></td>
                  <td><?='T'.$answer['ResultQuestion']['Result']['Transformation']['TransformationType']['id']?></td>
                </tr>
                <?php } ?>
                </tbody>
                <tfoot>
                <tr>
                  <th>Participante</th>
                  <th>Sexo</th>
                  <th>Formação</th>
                  <th>Profissão</th>
                  <th>Questão</th>
                  <th>Escolha</th>
                  <th>Justificativa</th>
                  <th>Linguagem</th>
                  <th>Tipo da transformação</th>
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
