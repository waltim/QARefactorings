<section class="content">
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Carregar refatorações</h3>
                </div>
                <form role="form" method="post" enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="exampleInputFile">Selecione um arquivo</label>
                            <input type="file" name="data[file]" id="exampleInputFile">

                            <p class="help-block">Selecione o arquivo .csv com os dados para serem processados.</p>
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">enviar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>