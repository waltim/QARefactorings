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
                    foreach ($question['Result']['ResultQuestion'] as $questoes) { //pr($questoes);exit(); ?>
                        <?php if ($questoes['Question']['id'] == 1) { ?>
                            <div class="form-group text-center">
                                <h3>
                                    <?= $questoes['Question']['description']; ?>
                                </h3>
                            </div>
                            <input type="hidden" name="data[Answer][result_question_id]"
                                   value="<?= $question['ResultQuestion']['id']; ?>">
                            <input type="hidden" name="data[Answer][start_time]" value="<?= $tempo = date('H:i:s'); ?>">
                            <div class="form-group">
                                <label>Justificativa</label>
                                <textarea id="text-justifique" rows="5" maxlength="200" name="data[Answer][justify][]"
                                          class="form-control"
                                          placeholder="Detalhe sua escolha aqui."></textarea>
                            </div>
                            <div class="form-group text-center">
                                <input type="radio" value="N" name="check" id="check">NÃO
                                </input>
                                <input type="radio" name="check" id="check1" value="S" checked="checked">SIM
                                </input>
                            </div>
                        <?php } else { ?>
                            <div id="questao-<?= $z ?>">
                                <div class="form-group text-center">
                                    <h3>
                                        <?= $questoes['Question']['description']; ?>
                                    </h3>
                                </div>
                                <input type="hidden" name="data[Answer][result_question_id]"
                                       value="<?= $question['ResultQuestion']['id']; ?>">
                                <input type="hidden" name="data[Answer][start_time]"
                                       value="<?= $tempo = date('H:i:s'); ?>">
                                <div class="form-group">
                                    <label>(Opcional) Justificativa</label>
                                    <textarea rows="5" maxlength="200" name="data[Answer][justify][]"
                                              class="form-control"
                                              placeholder="Detalhe sua escolha aqui."></textarea>
                                </div>
                                <div class="form-group text-center">
                                    <input type="radio" id="DP<?= $z ?>" name="data[Answer][choice][<?= $z ?>]" value="1"
                                           class="btn btn-raised btn-default" type="submit">Discordo plenamente
                                    </input>
                                    <input type="radio" id="D<?= $z ?>" name="data[Answer][choice][<?= $z ?>]" value="2"
                                           class="btn btn-raised btn-default" type="submit">Discordo
                                    </input>
                                    <input type="radio" id="NDNC<?= $z ?>" name="data[Answer][choice][<?= $z ?>]" value="3"
                                           class="btn btn-raised btn-default" type="submit">Não discordo nem concordo
                                    </input>
                                    <input type="radio" id="C<?= $z ?>" name="data[Answer][choice][<?= $z ?>]" value="4"
                                           class="btn btn-raised btn-default" type="submit">Concordo
                                    </input>
                                    <input type="radio" id="CP<?= $z ?>" name="data[Answer][choice][<?= $z ?>]" value="5"
                                           class="btn btn-raised btn-default" type="submit">Concordo plenamente
                                    </input>
                                </div>
                            </div>
                        <?php } ?>
                        <?php $z++;
                    } ?>
                    <a href="<?= $this->webroot ?>" class="pull-left">
                        <button value="sair" name="data[Answer][choice][]" class="btn btn-raised btn-default">Sair
                        </button>
                    </a>
                    <a href="<?= $this->webroot ?>questions/responder" style="margin-left: 40%;">
                        <button class="btn btn-raised btn-primary">Responder</button>
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
