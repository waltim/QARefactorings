<div class="row">
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Atualizar transformações</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" method="post"
                  action="/transformations/edit/<?= $transformation['Transformation']['id']; ?>">
                <div class="box-body">
                    <?php if (!empty($metrics)) { ?>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Linguagem</label>
                                <?php echo $this->Form->input('Transformation.language_id', array(
                                    'options' => $languages,
                                    'empty' => 'Selecione a linguagem',
                                    'class' => 'form-control',
                                    'label' => false,
                                    'value' => $transformation['Transformation']['language_id']
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
                                    'label' => false,
                                    'value' => $transformation['Transformation']['transformation_type_id']
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
                        <?php
                    } else { ?>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Linguagem</label>
                                <?php echo $this->Form->input('Transformation.language_id', array(
                                    'options' => $languages,
                                    'empty' => 'Selecione a linguagem',
                                    'class' => 'form-control',
                                    'label' => false,
                                    'value' => $transformation['Transformation']['language_id']
                                )); ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tipo de transformação</label>
                                <?php echo $this->Form->input('Transformation.transformation_type_id', array(
                                    'options' => $types,
                                    'empty' => 'Selecione o tipo',
                                    'class' => 'form-control',
                                    'label' => false,
                                    'value' => $transformation['Transformation']['transformation_type_id']
                                )); ?>
                            </div>
                        </div>
                        <?php
                    } ?>
                    <!-- /.box -->
                    <div class="col-md-6">
                        <div class="box">
                            <div class="box-header">
                                <h3 class="box-title">Código Anterior
                                </h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body pad">
																	<textarea class="textarea"
                                                                              name="data[Transformation][code_before]"
                                                                              placeholder="Cole o código aqui"
                                                                              style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">
																						<?= $transformation['Transformation']['code_before']; ?>
																					</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="box">
                            <div class="box-header">
                                <h3 class="box-title"> Código Transformado
                                </h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body pad">
												<textarea class="textarea" name="data[Transformation][code_after]"
                                                          placeholder="Cole o código aqui"
                                                          style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">
																<?= $transformation['Transformation']['code_after']; ?>
																</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Link da transformação</label>
                        <input type="text" value="<?= $transformation['Transformation']['site_link']; ?>" name="data[Transformation][site_link]" class="form-control"
                               id="siteLink" placeholder="Ex: https://github.com/NomeProjeto/xxx">
                    </div>
                    <input type="hidden" value="<?= $transformation['Transformation']['id']; ?>"
                           name="data[Transformation][id]"/>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Cadastrar</button>
                    <a href="/transformations/index/<?= $transformation['Transformation']['search_event_id'] ?>">
                        <button type="button" class="btn btn-default">Cancelar</button>
                    </a>
                </div>
            </form>
        </div>
    </div>
    <!-- /.col-->
</div>
