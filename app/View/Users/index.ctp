      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Tabela de usuários</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>Nome</th>
                  <th>email</th>
                  <th>Tipo de usuário</th>
									<th>Data cadastro</th>
									<th>Status</th>
                  <th>Ações</th>
                </tr>
                </thead>
                <tbody>
									<?php foreach($usuarios as $usuario){ ?>
                <tr>
                  <td><?=$usuario['User']['name'];?></td>
                  <td><?=$usuario['User']['email'];?></td>
                  <td><?=$usuario['UserType']['description'];?></td>
									<td><?= date('d/m/Y', strtotime($usuario['User']['created']));?></td>
									<td>
										<?php
										if($usuario['User']['status'] == 0){
										echo "<i class='fa fa-ban fa-lg bg-red'></i>";
										}else{
											echo "<i class='fa fa-check-circle-o fa-lg bg-green'></i>";
										}
										?>
									</td>
                  <td>
									<a href="<?= $this->webroot ?>users/view/<?=$usuario['User']['id']?>" title="Visualizar">
										<i class="fa fa-television fa-lg"></i>
									</a>
									<a href="<?= $this->webroot ?>users/edit/<?=$usuario['User']['id']?>" title="Editar">
										<i class="fa fa-edit fa-lg"></i>
									</a>
									<?php
										if($usuario['User']['status'] == 0){
										echo "
										<a href='".$this->webroot."users/status/".$usuario['User']['id']."'
											onclick='return confirm('Tem certeza?')' title='Liberar'>
											<i class='fa fa-check-circle-o fa-lg'></i>
										</a>
										";
										}else{
											echo "
										<a href='".$this->webroot."users/status/".$usuario['User']['id']."'
											onclick='return confirm('Tem certeza?')' title='Bloquear'>
											<i class='fa fa-ban fa-lg'></i>
										</a>
										";
										}
										?>
									</td>
								</tr>
									<?php } ?>
                </tbody>
                <tfoot>
                <tr>
									<th>Nome</th>
                  <th>email</th>
                  <th>Tipo de usuário</th>
									<th>Data cadastro</th>
									<th>Status</th>
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
