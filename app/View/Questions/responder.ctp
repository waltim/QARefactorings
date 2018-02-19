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
					<div class="form-group col-md-6">
					<h4>Código anterior</h4>
					<?php
						$i = 0;
						$contador = count($variable->identCode($question['Result']['Transformation']['code_before']));
						foreach ($variable->identCode($question['Result']['Transformation']['code_before']) as $linha) {
							$final = substr($linha, -1);
							if ($i == 0) {
								echo "<pre class='brush: java;'>";
							}
							if($final == "{" || $final == "}"){
								echo $linha;
								echo "\n";
							}else{
								echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$linha;
								echo "\n";
							}
							if ($i == ($contador - 1)) {
								echo "</pre>";
							}
							$i++;
						}
						?>
					</div>
					<div class="form-group col-md-6">
					<h4>Código transformado</h4>
					<?php
						$i = 0;
						$contador = count($variable->identCode($question['Result']['Transformation']['code_after']));
						foreach ($variable->identCode($question['Result']['Transformation']['code_after']) as $linha) {
							$final = substr($linha, -1);
							if ($i == 0) {
								echo "<pre class='brush: java;'>";
							}
							if($final == "{" || $final == "}"){
								echo $linha;
								echo "\n";
							}else{
								echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$linha;
								echo "\n";
							}
							if ($i == ($contador - 1)) {
								echo "</pre>";
							}
							$i++;
						}
						?>
					</div>
					<div class="form-group">
						<label>Justificativa</label>
						<textarea rows="5" maxlength="200" name="data[Answer][justify]" class="form-control" placeholder="Detalhe sua escolha aqui."></textarea>
					</div>
					<input type="hidden" name="data[Answer][question_id]" value="<?=$question['Question']['id'];?>">
					<div class="form-group text-center">
						<button id="DP" name="data[Answer][choice]" value="1" class="btn btn-raised btn-lg btn-success" type="submit">Discordo plenamente</button>
						<button id="D" name="data[Answer][choice]" value="2" class="btn btn-raised btn-lg btn-success" type="submit">Discordo</button>
						<button id="NDNC" name="data[Answer][choice]" value="3" class="btn btn-raised btn-lg btn-success" type="submit">Não discordo nem concordo</button>
						<button id="C" name="data[Answer][choice]" value="4" class="btn btn-raised btn-lg btn-success" type="submit">Concordo</button>
						<button id="CP" name="data[Answer][choice]" value="5" class="btn btn-raised btn-lg btn-success" type="submit">Concordo plenamente</button>
					</div>
				</form>
				<a href="<?=$this->webroot?>" class="pull-left"><button class="btn btn-raised btn-lg btn-warning">Sair</button></a>
				<a href="<?=$this->webroot?>questions/responder" class="pull-right"><button class="btn btn-raised btn-lg btn-primary">Pular questão</button></a>
			</div>
		</div>
	</div>
</div>
