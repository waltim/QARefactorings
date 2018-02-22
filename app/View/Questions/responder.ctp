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
					<div class="form-group col-md-12 div-borda">
					<h4>Código anterior</h4>
					<code id="codigo1" class="<?=$question['Result']['Transformation']['Language']['brush'];?>">
						<?php echo str_replace("&nbsp; }","}",$question['Result']['Transformation']['code_before']);?>
					</code>
					</div>
					<div class="form-group col-md-12 div-borda">
					<h4>Código transformado</h4>
					<code id="codigo2" class="<?=$question['Result']['Transformation']['Language']['brush'];?>">
							<?php echo str_replace("&nbsp; }","}",$question['Result']['Transformation']['code_after']);?>
					</code>
					</div>
					<div class="form-group">
						<label>(Opcional) Justificativa</label>
						<textarea rows="5" maxlength="200" name="data[Answer][justify]" class="form-control" placeholder="Detalhe sua escolha aqui."></textarea>
					</div>
					<input type="hidden" name="data[Answer][question_id]" value="<?=$question['Question']['id'];?>">
					<div class="form-group text-center">
						<a href="<?=$this->webroot?>" class="pull-left"><button value="sair" name="data[Answer][choice]" class="btn btn-raised btn-default">Sair</button></a>
						<button id="DP" name="data[Answer][choice]" value="1" class="btn btn-raised btn-default" type="submit">Discordo plenamente</button>
						<button id="D" name="data[Answer][choice]" value="2" class="btn btn-raised btn-default" type="submit">Discordo</button>
						<button id="NDNC" name="data[Answer][choice]" value="3" class="btn btn-raised btn-default" type="submit">Não discordo nem concordo</button>
						<button id="C" name="data[Answer][choice]" value="4" class="btn btn-raised btn-default" type="submit">Concordo</button>
						<button id="CP" name="data[Answer][choice]" value="5" class="btn btn-raised btn-default" type="submit">Concordo plenamente</button>
						<a href="<?=$this->webroot?>questions/responder" class="pull-right"><button value="pular" name="data[Answer][choice]" class="btn btn-raised btn-primary">Pular questão</button></a>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
