<?php echo $this->Html->css(array(
    'styles.css',
));
?>
<style>
	hr {
		display: block;
		height: 1px;
		border: 0;
		margin: 1em 0;
		padding: 0;
		border-top: 2px solid #afafaf;
	}

	.form-control {
		border-color: #222e47!important;
	}

	table.Differences.DifferencesSideBySide {
		background-color: white!important;
	}
</style>
<div class="container">
    <!-- Main content -->
    <section class="content">
        <div class="col-md-12">
            <div id="calcula-height notranslate" style="overflow-x: scroll;">
<!--                <a class="button-piscando" target="_blank"-->
<!--                   href="--><?//= $question['Result']['Transformation']['site_link'] . $question['Result']['Transformation']['line_start'] ?><!--">Open-->
<!--                    code on GitHub</a>-->
                <?php

                // Include the diff class
                require_once ROOT . DS . 'app' . DS . 'Vendor' . DS . 'php-diff/lib/Diff.php';
				//pr(file_get_contents($question['Result']['Transformation']['diff_id'] . '/a.txt'));exit();
                // Include two sample files for comparison
                $a = explode("\n", file_get_contents($question['Result']['Transformation']['diff_id'] . '/a.txt'));
                $b = explode("\n", file_get_contents($question['Result']['Transformation']['diff_id'] . '/b.txt'));
                foreach ($a as $key => $value) {
                    $a[$key] = html_entity_decode($value);
                }
                foreach ($b as $key => $value) {
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
                <div class="notranslate" style="background-color: white; color: black;">
                    <?php
                    // Generate a side by side diff
                    require_once ROOT . DS . 'app' . DS . 'Vendor' . DS . 'php-diff/lib/Diff/Renderer/Html/SideBySide.php';
                    $renderer = new Diff_Renderer_Html_SideBySide;
                    echo $diff->Render($renderer);
                    // Generate an inline diff
//                     require_once ROOT . DS . 'app' . DS . 'Vendor' . DS . 'php-diff/lib/Diff/Renderer/Html/Inline.php';
//                     $renderer = new Diff_Renderer_Html_Inline;
//                     echo $diff->render($renderer);
                    // Generate a unified diff
//                    require_once ROOT . DS . 'app' . DS . 'Vendor' . DS . 'php-diff/lib/Diff/Renderer/Text/Unified.php';
//                    $renderer = new Diff_Renderer_Text_Unified;
//                    echo htmlspecialchars($diff->render($renderer));
                    // Generate a context diff
 //                   require_once ROOT . DS . 'app' . DS . 'Vendor' . DS . 'php-diff/lib/Diff/Renderer/Text/Context.php';
 //                   $renderer = new Diff_Renderer_Text_Context;
//                    echo htmlspecialchars($diff->render($renderer));
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
            </div>
        </div>
        <div class="col-md-12">
            <div id="distancia-medida" style="margin-top: 30px;" class="box box-default">
                <div class="box-body">
                    <form id="reused_form" method="post" action="<?= $this->webroot ?>questions/likert">
                        <input type="hidden" name="data[Answer][start_time]" onkeypress="return event.keyCode != 13;"
                               value="<?= $tempo = date('H:i:s'); ?>">
						<hr>
                        <?php $z = 1;
                        $ww = 1;
                        foreach ($question['Result']['ResultQuestion'] as $key => $questoes) { ?>

                        <?php if ($questoes['Question']['question_type_id'] == 5) { ?>
                            <input type="hidden" onkeypress="return event.keyCode != 13;" id="result-<?= $z ?>"
                                   name="data[Answer][result_question_id][]"
                                   value="<?= $question['Result']['ResultQuestion'][$key]['id']; ?>">
                            <div id="questao-<?= $z ?>">
                                <div class="form-group text-center">
                                    <h3>
										<?php echo $z.') ' ; ?><?= $questoes['Question']['description']; ?>
                                    </h3>
                                </div>
                                <div class="form-group text-center" style="font-size: 18px;">
                                    <div class="borda-radio">
                                        <input onkeypress="return event.keyCode != 13;" type="radio" required="required"
                                               value="OP1" name="check" id="check">
                                        <label for="check">Yes</label>
                                    </div>
                                    <div class="borda-radio">
                                        <input onkeypress="return event.keyCode != 13;" type="radio" name="check"
                                               id="check1" value="OP2">
                                        <label for="check1">No</label>
                                    </div>
                                </div>
                                <!-- <div class="form-group">
                                    <label>Justificativa (Opcional)</label>
                                    <textarea rows="5" id="text-justifique" maxlength="1200" name="data[Answer][justify][]"
                                        class="form-control" placeholder="Detalhe sua escolha aqui."></textarea>
                                </div> -->
                            </div>
                        <?php } elseif ($questoes['Question']['question_type_id'] == 4) { ?>
                            <input type="hidden" onkeypress="return event.keyCode != 13;" id="result-<?= $z ?>"
                                   name="data[Answer][result_question_id][]"
                                   value="<?= $question['Result']['ResultQuestion'][$key]['id']; ?>">
                            <div id="questao-<?= $z ?>">
                                <div class="form-group text-center">
                                    <h3>
										<?php echo $z.') ' ; ?> <?= $questoes['Question']['description']; ?>
                                    </h3>
                                </div>
                                <div class="form-group text-center" style="font-size: 18px;">
                                    <div class="borda-radio">
                                        <input onkeypress="return event.keyCode != 13;" type="radio" id="DP<?= $z ?>"
                                               required="required"
                                               name="data[Answer][choice][<?= $z ?>]"
                                               value="1" class="btn btn-raised btn-default flat-red" type="submit">
                                        <label for="DP<?= $z ?>">Worsened considerably</label>
                                    </div>
                                    <div class="borda-radio">
                                        <input onkeypress="return event.keyCode != 13;" type="radio" id="D<?= $z ?>"
                                               name="data[Answer][choice][<?= $z ?>]"
                                               value="2"
                                               class="btn btn-raised btn-default flat-red" type="submit">
                                        <label for="D<?= $z ?>">Worsened</label>
                                    </div>
                                    <div class="borda-radio">
                                        <input onkeypress="return event.keyCode != 13;" type="radio" id="NDNC<?= $z ?>"
                                               name="data[Answer][choice][<?= $z ?>]"
                                               value="3"
                                               class="btn btn-raised btn-default flat-red" type="submit">
                                        <label for="NDNC<?= $z ?>">Kept</label>
                                    </div>
                                    <div class="borda-radio">
                                        <input onkeypress="return event.keyCode != 13;" type="radio" id="C<?= $z ?>"
                                               name="data[Answer][choice][<?= $z ?>]"
                                               value="4"
                                               class="btn btn-raised btn-default flat-red" type="submit">
                                        <label for="C<?= $z ?>">Improved</label>
                                    </div>
                                    <div class="borda-radio">
                                        <input onkeypress="return event.keyCode != 13;" type="radio" id="CP<?= $z ?>"
                                               name="data[Answer][choice][<?= $z ?>]"
                                               value="5"
                                               class="btn btn-raised btn-default flat-red" type="submit">
                                        <label for="CP<?= $z ?>">Improved considerably</label>
                                    </div>
                                </div>
                                <!-- <div class="form-group">
                                    <label>Justificativa (Opcional)</label>
                                    <textarea rows="5" maxlength="1200" name="data[Answer][justify][]" class="form-control"
                                        placeholder="Detalhe sua escolha aqui."></textarea>
                                </div> -->
                            </div>
                        <?php }
                        elseif ($questoes['Question']['question_type_id'] == 2) { ?>
                        <input type="hidden" id="result-<?= $z ?>" name="data[Answer][result_question_id][]"
                               value="<?= $question['Result']['ResultQuestion'][$key]['id']; ?>">
                        <div id="questao-<?= $z ?>">
                            <div class="form-group text-center">
                                <h3>
									<?php echo $z.') ' ; ?><?= $questoes['Question']['description']; ?>
                                </h3>
                            </div>
                            <div class="form-group text-center" style="font-size: 18px;">
                                <div class="form-group">
<!--                                    <label>(Optional)</label>-->
                                    <textarea rows="5" maxlength="1200" name="data[Answer][justify][<?= $z ?>]"
                                              class="form-control"
                                              placeholder="Write here."></textarea>
                                </div>
                                <input type="hidden" id="asdasd<?= $z ?>" name="data[Answer][choice][<?= $z ?>]"
                                       value="5"
                                       class="btn btn-raised btn-default flat-red" type="submit">
                            </div>
                            <?php } elseif ($questoes['Question']['question_type_id'] == 7) {
                                if ($ww == 1) { ?>
                                    <div class="form-group text-center">
									<h3>
										<?php echo $z.') '; ?><?= $questoes['Question']['description']; ?>
									</h3>
                                <?php } ?>
                                <input type="hidden" onkeypress="return event.keyCode != 13;" id="result-<?= $z ?>"
                                       name="data[Answer][result_question_id][]"
                                       value="<?= $question['Result']['ResultQuestion'][$key]['id']; ?>">
									<div id="questao-<?= $z ?>">
										<div class="form-group text-center" style="font-size: 18px;">
<!--											<div class="borda-radio-likertAgrupada">-->
<!--												<h3>-->
<!--													--><?php //echo $z.') '; ?><!----><?//= $questoes['Question']['description']; ?>
<!--												</h3>-->
<!--											</div>-->
											<div class="borda-radio">
												<input onkeypress="return event.keyCode != 13;" type="radio"
													   id="DP<?= $z ?>" required="required"
													   name="data[Answer][choice][<?= $z ?>]"
													   value="1" class="btn btn-raised btn-default flat-red" type="submit">
												<label for="DP<?= $z ?>">Never</label>
											</div>
											<div class="borda-radio">
												<input onkeypress="return event.keyCode != 13;" type="radio" id="D<?= $z ?>"
													   name="data[Answer][choice][<?= $z ?>]"
													   value="2"
													   class="btn btn-raised btn-default flat-red" type="submit">
												<label for="D<?= $z ?>">Rarely</label>
											</div>
											<div class="borda-radio">
												<input onkeypress="return event.keyCode != 13;" type="radio"
													   id="NDNC<?= $z ?>"
													   name="data[Answer][choice][<?= $z ?>]" value="3"
													   class="btn btn-raised btn-default flat-red" type="submit">
												<label for="NDNC<?= $z ?>">Sometimes</label>
											</div>
											<div class="borda-radio">
												<input onkeypress="return event.keyCode != 13;" type="radio" id="C<?= $z ?>"
													   name="data[Answer][choice][<?= $z ?>]"
													   value="4"
													   class="btn btn-raised btn-default flat-red" type="submit">
												<label for="C<?= $z ?>">Often</label>
											</div>
										</div>
									</div>
                                <?php
                                if ($ww == 4) { ?>
                                    </div>
                                    <?php
                                }
                                ?>
                                <?php $ww++;
                            } ?>
                            <?php $z++;
                            echo '<hr>';
                            } ?>
                            <a href="<?= $this->webroot ?>questions/responder">
                                <button class="btn btn-raised btn-primary" value="responder"
                                        name="data[Answer][botao]">
                                    Submit
                                </button>
                            </a>
                    </form>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </section>
    <!-- /.content -->
</div>
<!-- /.container -->
