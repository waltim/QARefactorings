<div class="row">
<div class="col-md-12">
<!-- general form elements -->
<div class="box box-primary">
<!-- Horizontal Form -->
<div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Linguagem <?=$linguagem['Language']['description'];?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" method="post" action="<?=$this->webroot?>languages/languages">
              <div class="box-body">
								<div class="form-group">
													<label for="inputEmail3" class="col-sm-2 control-label">Tempo de experiência</label>
									<div class="col-sm-10">
								<?php echo $this->Form->input('UserLanguage.experience', array(
								'type'=>'select',
								'label'=>false,
								'options'=> array('1' => '1 ano', '2'=>'2 anos', '3'=>'3 anos','4'=>'4 anos','5'=>'5 anos',
								'6'=>'6 anos','7'=>'7 anos','8'=>'8 anos','9'=>'9 anos','10'=>'10 anos','11'=>'mais de 10 anos'),
								'default' => 5,
								'class' => 'form-control'
								)); ?>
								</div>
								</div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" name="data[UsersLanguage][languages_id]" value="<?=$linguagem['Language']['id'];?>" class="btn btn-info pull-right">Salvar</button>
              </div>
              <!-- /.box-footer -->
            </form>
</div>
</div>
<!-- /.col-->
</div>
