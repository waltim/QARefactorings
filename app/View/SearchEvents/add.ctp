<!-- <?php// pr($languages);exit();?> -->
<div class="row">
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Cadastro de pesquisa</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" method="post" action="/SearchEvents/add">
                <div class="box-body">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Métricas</label>
                            <?php echo $this->Form->input('SearchEvent.linguages', array(
                                'options' => $languages,
                                'empty' => 'Selecione as linguagens',
                                'class' => 'form-control select2',
                                'label' => false,
                                'multiple' => 'multiple',
                                'data-placeholder' => 'Selecione as linguagens',
                                'style' => 'width: 100%;'
                            )); ?>
                        </div>
                    </div>
                    <div class="col-sm-10">
                        <div class="form-group">
                        <label>Título</label>
                            <input type="text" name="data[SearchEvent][title]" required="required" class="form-control" id="inputEmail3" placeholder="Título da pesquisa">
                        </div>
                    </div>
                    <div class="col-sm-10">
                        <div class="form-group">
                        <label>Universidade</label>
                            <input type="text" name="data[SearchEvent][school]" class="form-control" id="asdsad" placeholder="Universidade">
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Cadastrar</button>
                    <a href="/SearchEvents/index">
                        <button type="button" class="btn btn-default">Cancelar</button>
                    </a>
                </div>
            </form>
        </div>
    </div>
    <!-- /.col-->
</div>