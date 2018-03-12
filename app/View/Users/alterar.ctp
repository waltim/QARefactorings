<div class="row">
<div class="col-md-12">
<!-- general form elements -->
<div class="box box-primary">
<!-- Horizontal Form -->
<div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Atualizando dados do usuário</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" method="post" action="<?=$this->webroot?>users/alterar">
              <div class="box-body">
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Nome e Sobrenome</label>
                  <div class="col-sm-10">
                    <input type="text" name="data[User][name]" value="<?=$this->Session->read('Auth.User.name');?>" class="form-control" id="inputEmail3" placeholder="Nome e Sobrenome">
                  </div>
								</div>
								<div class="form-group">
										<label for="inputEmail3" class="col-sm-2 control-label">Sexo</label>
									<div class="col-sm-10">
										<?php echo $this->Form->input('User.sex', array(
										'type'=>'select',
										'label'=>false,
										'options'=> array('Masculino' => 'Masculino', 'Feminino'=>'Feminino', 'Não informado'=>'Não informar'),
										'default'=>$this->Session->read('Auth.User.sex'),
										'class' => 'form-control'
										)); ?>
									</div>
								</div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Senha</label>
                  <div class="col-sm-10">
                    <input type="password" name="data[User][password]" class="form-control" id="inputPassword3" placeholder="Nova senha">
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" name="data[User][funcao]" value="cancelar" class="btn btn-default">Cancelar</button>
                <button type="submit" name="data[User][funcao]" value="alterar" class="btn btn-info pull-right">Atualizar</button>
              </div>
              <!-- /.box-footer -->
            </form>
</div>
</div>
<!-- /.col-->
</div>
