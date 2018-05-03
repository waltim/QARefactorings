<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">editando pesquisa</h3>
            </div>
            <form role="form" method="post" action="/searchEvents/edit/<?= $pesquisa ?>">
                <div class="box-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Titulo da pesquisa</label>
                        <input type="text" required name="data[SearchEvent][title]" class="form-control" value="<?= $search['SearchEvent']['title']?>"
                               id="exampleInputEmail1" placeholder="Ex: investigando refatorações em JAVA">
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Linguagens</label>
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
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Universidade</label>
                            <input type="text" name="data[SearchEvent][school]" class="form-control" value="<?= $search['SearchEvent']['school']?>"
                                   id="exampleInputEmail1"
                                   placeholder="Qual nome da sua universidade?">
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Cadastrar</button>
                </div>
            </form>
        </div>
    </div>
</div>
