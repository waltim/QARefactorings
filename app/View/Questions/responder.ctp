<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="panel panel-danger">
			<div class="panel-body">
				<form id="reused_form" method="post" action="<?=$this->webroot?>questions/responder">
					<div class="form-group text-center">
						<h3 >
							<?=$question['Question']['description'];?>
						</h3>
					</div>
						<div id="codigo-antes" class="form-group">
						<h4>Código anterior</h4>
						<?php
						$codigoAntigo = str_replace("&nbsp; }","}",$question['Result']['Transformation']['code_before']);
						$codigoAntigo = strip_tags($codigoAntigo, '<br>');
						?>
						<code id="codigo1" class="brush: diff"><?php echo $codigoAntigo; ?></code>
						</div>
						<div id="codigo-depois" class="form-group">
						<h4>Código transformado</h4>
						<?php
						$codigoDepois = str_replace("&nbsp; }","}",$question['Result']['Transformation']['code_after']);
						$codigoDepois = strip_tags($codigoDepois, '<br>');
						?>
						<code id="codigo2" class="brush: diff"><?php echo $codigoDepois;?></code>
						</div>
						<div class="clearfix"></div>
					<div class="form-group">
						<label>(Opcional) Justificativa</label>
						<textarea rows="5" maxlength="200" name="data[Answer][justify]" class="form-control" placeholder="Detalhe sua escolha aqui."></textarea>
					</div>
					<input type="hidden" name="data[Answer][result_question_id]" value="<?=$question['ResultQuestion']['id'];?>">
					<input type="hidden" name="data[Answer][start_time]" value="<?=$tempo = date('H:i:s');?>">
					<div class="form-group text-center">
						<a href="<?=$this->webroot?>" class="pull-left"><button value="sair" name="data[Answer][choice]" class="btn btn-raised btn-default">Sair</button></a>
						<button id="DP" name="data[Answer][choice]" value="0" class="btn btn-raised btn-default" type="submit">1</button>
						<button id="D" name="data[Answer][choice]" value="1" class="btn btn-raised btn-default" type="submit">2</button>
						<button id="NDNC" name="data[Answer][choice]" value="2" class="btn btn-raised btn-default" type="submit">3</button>
						<button id="C" name="data[Answer][choice]" value="3" class="btn btn-raised btn-default" type="submit">4</button>
						<button id="CP" name="data[Answer][choice]" value="4" class="btn btn-raised btn-default" type="submit">5</button>
                        <button id="DP" name="data[Answer][choice]" value="5" class="btn btn-raised btn-default" type="submit">6</button>
                        <button id="D" name="data[Answer][choice]" value="6" class="btn btn-raised btn-default" type="submit">7</button>
                        <button id="NDNC" name="data[Answer][choice]" value="7" class="btn btn-raised btn-default" type="submit">8</button>
                        <button id="C" name="data[Answer][choice]" value="8" class="btn btn-raised btn-default" type="submit">9</button>
                        <button id="CP" name="data[Answer][choice]" value="9" class="btn btn-raised btn-default" type="submit">10</button>
						<a href="<?=$this->webroot?>questions/responder" class="pull-right"><button value="pular" name="data[Answer][choice]" class="btn btn-raised btn-primary">Pular questão</button></a>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
