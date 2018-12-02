      <div class="row">
        <div class="col-xs-12">
          <div class="box">
          <div class="box-header">
                <h3 class="box-title">Tabela de trechos de código</h3>
                <a href="/answers/respostas/<?=$pesquisa?>">
                    <button type="button" class="btn btn-primary pull-right">Respostas</button>
                </a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>Pesquisa</th>
                  <th>Url do Commit</th>
                  <th>Linha de ínicio</th>
                  <th>Linha fim</th>
                  <th>Linguagem</th>
                  <th>Tipo da transformação</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($transformations as $transformation){ //pr($transformation);exit(); ?>
                <tr>
                  <td><?=$transformation['SearchEvent']['title']?></td>
                  <td>
                    <a href="<?=$transformation['Transformation']['site_link'].$transformation['Transformation']['line_start']?>" 
                    target="_blank">
                    Github
                    </a>
                  </td>
                  <td><?=$transformation['Transformation']['line_start']?></td>
                  <td><?=$transformation['Transformation']['line_end']?></td>
                  <td><?=$transformation['Language']['description']?></td>
                  <td><?=$transformation['TransformationType']['description']?></td>
                </tr>
                <?php } ?>
                </tbody>
                <tfoot>
                <tr>
                <th>Pesquisa</th>
                <th>Url do Commit</th>
                <th>Linha de ínicio</th>
                <th>Linha fim</th>
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
