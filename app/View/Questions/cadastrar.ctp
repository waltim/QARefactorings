<div class="row">
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
            <!-- Horizontal Form -->
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Cadastrar Questões</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form class="form-horizontal" method="post" action="<?= $this->webroot ?>questions/cadastrar/<?=$pesquisa?>">
                    <div class="box-body">
                        <div id="codigo-antes" class="form-group">
                            <h4>Código anterior</h4>
                            <?php
                            $codigoAntigo = str_replace("&nbsp; }","}",$transformation['Transformation']['code_before']);
                            $codigoAntigo = strip_tags($codigoAntigo, '<br>');
                            ?>
                            <code id="codigo1" class="brush: <?=$transformation['Language']['brush'];?>"><?php echo $codigoAntigo; ?></code>
                        </div>
                        <div id="codigo-depois" class="form-group">
                            <h4>Código transformado</h4>
                            <?php
                            $codigoDepois = str_replace("&nbsp; }","}",$transformation['Transformation']['code_after']);
                            $codigoDepois = strip_tags($codigoDepois, '<br>');
                            ?>
                            <code id="codigo2" class="brush: <?=$transformation['Language']['brush'];?>"><?php echo $codigoDepois;?></code>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-md-12">Qual(is) pergunta(s) você sugeria sobre a refatoração acima?</label>
                            <div class="col-md-12">
                                <textarea rows="5" maxlength="200" name="data[Question][description]" class="form-control" placeholder="Detalhe sua escolha aqui."></textarea>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <button type="submit" class="btn btn-info pull-right">Salvar
                        </button>
                    </div>
                    <!-- /.box-footer -->
                </form>
            </div>
        </div>
        <!-- /.col-->
    </div>
