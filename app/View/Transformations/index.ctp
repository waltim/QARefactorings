<section class="content-header">
      <h1>
        Data Tables
        <small>advanced tables</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Tables</a></li>
        <li class="active">Data tables</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Hover Data Table</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>Linguagem</th>
                  <th>Tipo</th>
                  <th>Transformação</th>
                  <th>Ações</th>
                </tr>
                </thead>
                <tbody>
								<?php foreach($transformations as $transformation){ ?>
                <tr>
                  <td><?=$transformation['Language']['description'];?></td>
                  <td><?=$transformation['TransformationType']['description'];?></td>
                  <td> <?=$transformation['Transformation']['code_after'];?></td>
                  <td>
									<a href="<?= $this->webroot ?>transformations/view/<?=$transformation['Transformation']['id']?>" title="Visualizar">
										<i class="fa fa-television fa-lg"></i>
									</a>
									<a href="<?= $this->webroot ?>transformations/edit/<?=$transformation['Transformation']['id']?>" title="Editar">
										<i class="fa fa-edit fa-lg"></i>
									</a>
									<a href="<?= $this->webroot ?>transformations/delete/<?=$transformation['Transformation']['id']?>"
										 onclick="return confirm('Tem certeza?')" title="Deletar">
										<i class="fa fa-eraser fa-lg"></i>
									</a>
									</td>
								</tr>
								<?php } ?>
                </tbody>
                <tfoot>
                <tr>
                  <th>Linguagem</th>
                  <th>Tipo</th>
                  <th>Transformação</th>
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
      <!-- /.row -->
    </section>
    <!-- /.content -->
