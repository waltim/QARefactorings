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
		<div class="col-md-12" style="text-align: center">

			<?php if($respondidas == 0) { ?>
			<h3> Page 1 of 5</h3>
			<?php } else { ?>
				<h3> Page <?php echo ($respondidas/7)+1?> of 5</h3>
			<?php } ?>
		</div>
		<div class="timeline-body col-md-12">
			<div class="col-md-12">
				<h3>Old Code</h3>
				<?php
				$codigoAntigo = str_replace("&nbsp; }", "}", $question['Result']['Transformation']['code_before']);
				$codigoAntigo = strip_tags($codigoAntigo, '<br/>');
				?>
				<pre id="codigo1"
					  class="brush: java"><?php echo $codigoAntigo; ?></pre>
			</div>
			<div class="col-md-12">
				<h3>New Code</h3>
				<?php
				$codigoDepois = str_replace("&nbsp; }", "}", $question['Result']['Transformation']['code_after']);
				$codigoDepois = strip_tags($codigoDepois, '<br/>');
				?>
				<pre id="codigo2" class="brush: java"><?php echo $codigoDepois; ?></pre>
			</div>
		</div>
        <div class="col-md-12">
            <div id="distancia-medida" style="margin-top: 30px;" class="box box-default">
                <div class="box-body">
                    <form id="reused_form" method="post" action="<?= $this->webroot ?>questions/likert">
                        <input type="hidden" name="data[Answer][start_time]" onkeypress="return event.keyCode != 13;"
                               value="<?= $tempo = date('H:i:s'); ?>">
						<div class="form-group text-center">
							<h3>
								1) What is your opinion about the following setences:
							</h3>
						</div>
						<hr>
                        <?php
						$z = 1;
                        $ww = 1;
                        foreach ($question['Result']['ResultQuestion'] as $key => $questoes) { ?>

                        <?php if ($questoes['Question']['question_type_id'] == 5) { ?>
                            <input type="hidden" onkeypress="return event.keyCode != 13;" id="result-<?= $z ?>"
                                   name="data[Answer][result_question_id][]"
                                   value="<?= $question['Result']['ResultQuestion'][$key]['id']; ?>">
                            <div id="questao-<?= $z ?>">
                                <div class="form-group text-center">
                                    <h3>
										<?php echo $questoes['Question']['question_label']; ?><?= $questoes['Question']['description']; ?>
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
							<?php if ($questoes['Question']['id'] == 9) { ?>
                            <div id="questao-<?= $z ?>">
                                <div class="form-group text-center">
                                    <h3>
										<?php echo $questoes['Question']['question_label']; ?> <?= $questoes['Question']['description']; ?>
                                    </h3>
                                </div>
                                <div class="form-group text-center" style="font-size: 18px;">
                                    <div class="borda-radio">
                                        <input onkeypress="return event.keyCode != 13;" type="radio" id="DP<?= $z ?>"
                                               required="required"
                                               name="data[Answer][choice][<?= $z ?>]"
                                               value="1" class="btn btn-raised btn-default flat-red" type="submit">
                                        <label for="DP<?= $z ?>">Not important at all</label>
                                    </div>
                                    <div class="borda-radio">
                                        <input onkeypress="return event.keyCode != 13;" type="radio" id="D<?= $z ?>"
                                               name="data[Answer][choice][<?= $z ?>]"
                                               value="2"
                                               class="btn btn-raised btn-default flat-red" type="submit">
                                        <label for="D<?= $z ?>">Low importance</label>
                                    </div>
                                    <div class="borda-radio">
                                        <input onkeypress="return event.keyCode != 13;" type="radio" id="NDNC<?= $z ?>"
                                               name="data[Answer][choice][<?= $z ?>]"
                                               value="3"
                                               class="btn btn-raised btn-default flat-red" type="submit">
                                        <label for="NDNC<?= $z ?>">Neutral</label>
                                    </div>
                                    <div class="borda-radio">
                                        <input onkeypress="return event.keyCode != 13;" type="radio" id="C<?= $z ?>"
                                               name="data[Answer][choice][<?= $z ?>]"
                                               value="4"
                                               class="btn btn-raised btn-default flat-red" type="submit">
                                        <label for="C<?= $z ?>">Moderately important</label>
                                    </div>
                                    <div class="borda-radio">
                                        <input onkeypress="return event.keyCode != 13;" type="radio" id="CP<?= $z ?>"
                                               name="data[Answer][choice][<?= $z ?>]"
                                               value="5"
                                               class="btn btn-raised btn-default flat-red" type="submit">
                                        <label for="CP<?= $z ?>">Very important</label>
                                    </div>
                                </div>
                            </div>
							<?php }else{ ?>
								<div id="questao-<?= $z ?>">
									<div class="form-group text-center">
										<h3>
											<?php echo $questoes['Question']['question_label'].' '; ?> <?= $questoes['Question']['description']; ?>
										</h3>
									</div>
									<div class="form-group text-center" style="font-size: 18px;">
										<div class="borda-radio">
											<input onkeypress="return event.keyCode != 13;" type="radio" id="DP<?= $z ?>"
												   required="required"
												   name="data[Answer][choice][<?= $z ?>]"
												   value="1" class="btn btn-raised btn-default flat-red" type="submit">
											<label for="DP<?= $z ?>">Strongly disagree</label>
										</div>
										<div class="borda-radio">
											<input onkeypress="return event.keyCode != 13;" type="radio" id="D<?= $z ?>"
												   name="data[Answer][choice][<?= $z ?>]"
												   value="2"
												   class="btn btn-raised btn-default flat-red" type="submit">
											<label for="D<?= $z ?>">Disagree</label>
										</div>
										<div class="borda-radio">
											<input onkeypress="return event.keyCode != 13;" type="radio" id="NDNC<?= $z ?>"
												   name="data[Answer][choice][<?= $z ?>]"
												   value="3"
												   class="btn btn-raised btn-default flat-red" type="submit">
											<label for="NDNC<?= $z ?>">Neither agree or disagree</label>
										</div>
										<div class="borda-radio">
											<input onkeypress="return event.keyCode != 13;" type="radio" id="C<?= $z ?>"
												   name="data[Answer][choice][<?= $z ?>]"
												   value="4"
												   class="btn btn-raised btn-default flat-red" type="submit">
											<label for="C<?= $z ?>">Agree</label>
										</div>
										<div class="borda-radio">
											<input onkeypress="return event.keyCode != 13;" type="radio" id="CP<?= $z ?>"
												   name="data[Answer][choice][<?= $z ?>]"
												   value="5"
												   class="btn btn-raised btn-default flat-red" type="submit">
											<label for="CP<?= $z ?>">Strongly agree</label>
										</div>
									</div>
								</div>
							<?php } ?>
                        <?php }
                        elseif ($questoes['Question']['question_type_id'] == 2) { ?>
                        <input type="hidden" id="result-<?= $z ?>" name="data[Answer][result_question_id][]"
                               value="<?= $question['Result']['ResultQuestion'][$key]['id']; ?>">
                        <div id="questao-<?= $z ?>">
                            <div class="form-group text-center">
                                <h3>
									<?php echo $questoes['Question']['question_label'].' '; ?><?= $questoes['Question']['description']; ?>
                                </h3>
                            </div>
                            <div class="form-group text-center" style="font-size: 18px;">
                                <div class="form-group">
                                    <label>(Optional)</label>
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
										<?php echo $questoes['Question']['question_label'].' '; ?><?= $questoes['Question']['description']; ?>
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
											<div class="borda-radio">
												<input onkeypress="return event.keyCode != 13;" type="radio" id="CP<?= $z ?>"
													   name="data[Answer][choice][<?= $z ?>]"
													   value="5"
													   class="btn btn-raised btn-default flat-red" type="submit">
												<label for="CP<?= $z ?>">Always</label>
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
							<div class="box-footer">
								<a href="<?php $this->webroot;?>/languages/languages/1" class="btn btn-info"> Return to survey informations </a>

								<a href="<?= $this->webroot ?>questions/responder">
									<button class="btn btn-raised btn-primary" value="responder"
											name="data[Answer][botao]">
										Submit
									</button>
								</a>
							</div>
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
