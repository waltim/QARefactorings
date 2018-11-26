<div class="row">
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Cadastro de transformação</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" method="post" action="/transformations/add/<?= $pesquisa ?>">
                <div class="box-body">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Linguagem</label>
                            <?php echo $this->Form->input('Transformation.language_id', array(
                                'options' => $languages,
                                'empty' => 'Selecione a linguagem',
                                'class' => 'form-control',
                                'label' => false
                            )); ?>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Tipo de transformação</label>
                            <?php echo $this->Form->input('Transformation.transformation_type_id', array(
                                'options' => $types,
                                'empty' => 'Selecione o tipo',
                                'class' => 'form-control',
                                'label' => false
                            )); ?>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Métricas</label>
                            <?php echo $this->Form->input('Transformation.metricas', array(
                                'options' => $metrics,
                                'empty' => 'Selecione as métricas',
                                'class' => 'form-control select2',
                                'label' => false,
                                'multiple' => 'multiple',
                                'data-placeholder' => 'Seleciona as métricas',
                                'style' => 'width: 100%;'
                            )); ?>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="box">
                            <div class="box-header">
                                <h3 class="box-title">Trecho de Código
                                </h3>
                            </div>
                            <div class="box-body pad">
                                <textarea class="textarea" name="data[Transformation][conteudo]" placeholder="Cole o código aqui" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="col-md-6">
                        <div class="box">
                            <div class="box-header">
                                <h3 class="box-title">Código Anterior
                                </h3>
                            </div>
                            <div class="box-body pad">
                                <textarea class="textarea" name="data[Transformation][code_before]" placeholder="Cole o código aqui" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="box">
                            <div class="box-header">
                                <h3 class="box-title"> Código Transformado
                                </h3>
                            </div>
                            <div class="box-body pad">
                                <textarea class="textarea" name="data[Transformation][code_after]" placeholder="Cole o código aqui" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                            </div>
                        </div>
                    </div> -->
                    <div class="col-md-10">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Link da transformação</label>
                        <input type="text" name="data[Transformation][site_link]" class="form-control" id="siteLink" placeholder="Ex: https://github.com/NomeProjeto/xxx">
                    </div>
                    </div>
                    <div class="col-md-1">
                    <div class="form-group">
                        <label for="exampleInputEmail1">L. início</label>
                        <input type="text" name="data[Transformation][line_start]" class="form-control" id="linestart" placeholder="Ex: L56">
                    </div>
                    </div>
                    <div class="col-md-1">
                    <div class="form-group">
                        <label for="exampleInputEmail1">L. fim</label>
                        <input type="text" name="data[Transformation][line_end]" class="form-control" id="lineend" placeholder="Ex: R85">
                    </div>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Cadastrar</button>
                    <a href="/transformations/index/<?= $pesquisa ?>">
                        <button type="button" class="btn btn-default">Cancelar</button>
                    </a>
                </div>
            </form>
        </div>
    </div>
    <!-- /.col-->
</div>