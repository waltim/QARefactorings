<?php echo $this->Html->css(array(
    'styles.css',
));
?>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="">
            <div class="panel-body">
                <form id="reused_form" method="post" action="<?= $this->webroot ?>questions/responder" class="sombra-div">
                    <div class="form-group text-center">
                        <h3>
                            <strong>Pesquisa:</strong>
                            <?= $question['Result']['Transformation']['SearchEvent']['title']; ?>
                        </h3>
                    </div>
                    <div class="clearfix"></div>
                    <a class="assaltante" target="_blank" href="<?= $question['Result']['Transformation']['site_link'] ?>">Abrir código no GitHub</a>
                    <div class="clearfix"></div>
                    <?php

                // Include the diff class
                require_once ROOT . DS . 'app' . DS . 'Vendor' . DS . 'php-diff/lib/Diff.php';

                // Include two sample files for comparison
                $a = explode("\n", file_get_contents(ROOT . DS . 'app' . DS . 'webroot' . DS . 'files/'.$question['Result']['Transformation']['diff_id'].'/a.txt'));
                $b = explode("\n", file_get_contents(ROOT . DS . 'app' . DS . 'webroot' . DS . 'files/'.$question['Result']['Transformation']['diff_id'].'/b.txt'));
                foreach($a as $key => $value){
                $a[$key] = html_entity_decode($value);
                }
                foreach($b as $key => $value){
                $b[$key] = html_entity_decode($value);
                }
                // pr($a);
                // pr($b);
                // exit();
                // html_entity_decode($str);
                // Options for generating the diff
                $options = array(
                    //'ignoreWhitespace' => true,
                    //'ignoreCase' => true,
                );

                // Initialize the diff class
                $diff = new Diff($a, $b, $options);
                ?>
                    <div style="background-color: white; color: black;">
                        <?php
                    // Generate a side by side diff
                    require_once ROOT . DS . 'app' . DS . 'Vendor' . DS . 'php-diff/lib/Diff/Renderer/Html/SideBySide.php';
                    $renderer = new Diff_Renderer_Html_SideBySide;
                    echo $diff->Render($renderer);
                    // Generate an inline diff
                    // require_once ROOT . DS . 'app' . DS . 'Vendor' . DS . 'php-diff/lib/Diff/Renderer/Html/Inline.php';
                    // $renderer = new Diff_Renderer_Html_Inline;
                    // echo $diff->render($renderer);
                    ?>
                    </div>
                    <!-- <div id="codigo-antes" class="form-group">
                        <h4>Código anterior</h4>
                        <?php
                        $codigoAntigo = str_replace("&nbsp; }", "}", $question['Result']['Transformation']['code_before']);
                        $codigoAntigo = strip_tags($codigoAntigo, '<br/>');
                        ?>
                        <code id="codigo1" class="brush: diff"><?php echo $codigoAntigo; ?></code>
                    </div>
                    <div id="codigo-depois" class="form-group">
                        <h4>Código transformado</h4>
                        <?php
                        $codigoDepois = str_replace("&nbsp; }", "}", $question['Result']['Transformation']['code_after']);
                        $codigoDepois = strip_tags($codigoDepois, '<br/>');
                        ?>
                        <code id="codigo2" class="brush: diff"><?php echo $codigoDepois; ?></code>
                    </div> -->
                    <div class="clearfix"></div>
                    <input type="hidden" name="data[Answer][start_time]" value="<?= $tempo = date('H:i:s'); ?>">
                    <?php $z = 1;
                    foreach ($question['Result']['ResultQuestion'] as $key => $questoes) { ?>
                    <?php if ($questoes['Question']['id'] == 1) { ?>
                    <input type="hidden" id="result-<?= $z ?>" name="data[Answer][result_question_id][]" value="<?= $question['Result']['ResultQuestion'][$key]['id']; ?>">
                    <div class="form-group text-center">
                        <h3>
                            <?= $questoes['Question']['description']; ?>
                        </h3>
                    </div>
                    <div class="form-group">
                        <label>Justificativa</label>
                        <textarea id="text-justifique" rows="5" maxlength="200" name="data[Answer][justify][]" class="form-control" placeholder="Detalhe sua escolha aqui."></textarea>
                    </div>
                    <div class="form-group text-center">
                        <input type="radio" value="N" name="check" id="check">NÃO
                        <input type="radio" name="check" id="check1" value="S" checked="checked">SIM
                    </div>
                    <?php } else { ?>
                    <input type="hidden" id="result-<?= $z ?>" name="data[Answer][result_question_id][]" value="<?= $question['Result']['ResultQuestion'][$key]['id']; ?>">
                    <div id="questao-<?= $z ?>">
                        <div class="form-group text-center">
                            <h3>
                                <?= $questoes['Question']['description']; ?>
                            </h3>
                        </div>
                        <div class="form-group text-center" style="font-size: 18px;">
                            <div class="borda-radio">
                                <input type="radio" id="DP<?= $z ?>" required="required" name="data[Answer][choice][<?= $z ?>]" value="1" class="btn btn-raised btn-default flat-red"
                                       type="submit">Discordo plenamente</div>
                            <div class="borda-radio">
                                <input type="radio" id="D<?= $z ?>" name="data[Answer][choice][<?= $z ?>]" value="2" class="btn btn-raised btn-default flat-red"
                                       type="submit">Discordo</div>
                            <div class="borda-radio">
                                <input type="radio" id="NDNC<?= $z ?>" name="data[Answer][choice][<?= $z ?>]" value="3" class="btn btn-raised btn-default flat-red"
                                    type="submit">Não discordo nem concordo</div>
                            <div class="borda-radio">
                                <input type="radio" id="C<?= $z ?>" name="data[Answer][choice][<?= $z ?>]" value="4" class="btn btn-raised btn-default flat-red"
                                       type="submit">Concordo</div>
                            <div class="borda-radio">
                                <input type="radio" id="CP<?= $z ?>" name="data[Answer][choice][<?= $z ?>]" value="5" class="btn btn-raised btn-default flat-red"
                                       type="submit">Concordo plenamente</div>
                        </div>
                        <div class="form-group">
                            <label>(Opcional) Justificativa</label>
                            <textarea rows="5" maxlength="1200" name="data[Answer][justify][]" class="form-control" placeholder="Detalhe sua escolha aqui."></textarea>
                        </div>
                    </div>
                    <?php } ?>
                    <?php $z++;
                    } ?>
                    <a href="<?= $this->webroot ?>" class="pull-left">
                        <button value="sair" formnovalidate name="data[Answer][botao]" class="btn btn-raised btn-default">Sair
                        </button>
                    </a>
                    <a href="<?= $this->webroot ?>questions/responder" style="margin-left: 40%;">
                        <button class="btn btn-raised btn-primary" value="responder" name="data[Answer][botao]">
                            Responder
                        </button>
                    </a>
                    <a href="<?= $this->webroot ?>questions/responder" class="pull-right">
                        <button value="pular" formnovalidate name="data[Answer][botao]" class="btn btn-raised btn-default">Pular questão
                        </button>
                    </a>
                </form>
            </div>
        </div>
    </div>
</div>