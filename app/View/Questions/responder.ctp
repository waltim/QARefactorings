<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="panel panel-danger">
            <div class="panel-body">
                <form id="reused_form" method="post" action="<?= $this->webroot ?>questions/responder">
                    <div class="form-group text-center">
                        <h3>
                            <?= $question['Result']['Transformation']['SearchEvent']['title']; ?>
                        </h3>
                    </div>
                    <div id="codigo-antes" class="form-group">
                        <h4>Código anterior</h4>
                        <?php
                        $codigoAntigo = str_replace("&nbsp; }", "}", $question['Result']['Transformation']['code_before']);
                        $codigoAntigo = strip_tags($codigoAntigo, '<br>');
                        ?>
                        <code id="codigo1" class="brush: diff"><?php echo $codigoAntigo; ?></code>
                    </div>
                    <div id="codigo-depois" class="form-group">
                        <h4>Código transformado</h4>
                        <?php
                        $codigoDepois = str_replace("&nbsp; }", "}", $question['Result']['Transformation']['code_after']);
                        $codigoDepois = strip_tags($codigoDepois, '<br>');
                        ?>
                        <code id="codigo2" class="brush: diff"><?php echo $codigoDepois; ?></code>
                    </div>
                    <div class="clearfix"></div>
                    <?php $z = 1;
                    foreach ($question['Result']['ResultQuestion'] as $questoes) { ?>
                        <div class="form-group text-center">
                            <h3>
                                <?= $questoes['Question']['description']; ?>
                            </h3>
                        </div>
                        <div class="form-group">
                            <label>(Opcional) Justificativa</label>
                            <textarea rows="5" maxlength="200" name="data[Answer][justify][]" class="form-control"
                                      placeholder="Detalhe sua escolha aqui."></textarea>
                        </div>
                        <input type="hidden" name="data[Answer][result_question_id]"
                               value="<?= $question['ResultQuestion']['id']; ?>">
                        <input type="hidden" name="data[Answer][start_time]" value="<?= $tempo = date('H:i:s'); ?>">

                        <div class="form-group text-center">
                            <input id="DP<?= $z ?>" name="data[Answer][choice][]" value="0"
                                   class="btn btn-raised btn-default" autocomplete="off"
                                   type="checkbox">1
                            </input>
                            <input id="D<?= $z ?>" name="data[Answer][choice][]" value="1"
                                   class="btn btn-raised btn-default" autocomplete="off"
                                   type="checkbox">2
                            </input>
                            <input id="NDNC<?= $z ?>" name="data[Answer][choice][]" value="2"
                                   class="btn btn-raised btn-default" autocomplete="off"
                                   type="checkbox">3
                            </input>
                            <input id="C<?= $z ?>" name="data[Answer][choice][]" value="3"
                                   class="btn btn-raised btn-default" autocomplete="off"
                                   type="checkbox">4
                            </input>
                            <input id="CP<?= $z ?>" name="data[Answer][choice][]" value="4"
                                   class="btn btn-raised btn-default" autocomplete="off"
                                   type="checkbox">5
                            </input>
                            <input id="<?= $z ?>DP" name="data[Answer][choice][]" value="5"
                                   class="btn btn-raised btn-default" autocomplete="off"
                                   type="checkbox">6
                            </input>
                            <input id="<?= $z ?>D" name="data[Answer][choice][]" value="6"
                                   class="btn btn-raised btn-default" autocomplete="off"
                                   type="checkbox">7
                            </input>
                            <input id="<?= $z ?>NDNC" name="data[Answer][choice][]" value="7"
                                   class="btn btn-raised btn-default" autocomplete="off"
                                   type="checkbox">8
                            </input>
                            <input id="<?= $z ?>C" name="data[Answer][choice][]" value="8"
                                   class="btn btn-raised btn-default" autocomplete="off"
                                   type="checkbox">9
                            </input>
                            <input id="<?= $z ?>CP" name="data[Answer][choice][]" value="9"
                                   class="btn btn-raised btn-default" autocomplete="off"
                                   type="checkbox">10
                            </input>
                        </div>
                        <?php $z++;
                    } ?>
                    <a href="<?= $this->webroot ?>" class="pull-left">
                        <button value="sair" name="data[Answer][choice][]" class="btn btn-raised btn-default">Sair
                        </button>
                    </a>
                    <a href="<?= $this->webroot ?>questions/responder" style="margin-left: 40%;">
                        <button value="responder" name="data[Answer][choice][]" class="btn btn-raised btn-primary">Responder</button>
                    </a>
                    <a href="<?= $this->webroot ?>questions/responder" class="pull-right">
                        <button value="pular" name="data[Answer][choice][]" class="btn btn-raised btn-primary">Pular
                            questão
                        </button>
                    </a>
                </form>
            </div>
        </div>
    </div>
</div>
