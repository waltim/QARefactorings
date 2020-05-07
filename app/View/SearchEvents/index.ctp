<div class="row">
	<div class="col-xs-12">
		<div class="box">
			<div class="box-header">
				<h3 class="box-title">Tabela de transformações</h3>
				<a href="/searchEvents/add">
					<button type="button" class="btn btn-primary pull-right">Adicionar pesquisa</button>
				</a>
			</div>
			<!-- /.box-header -->
			<div class="box-body">
				<table id="example2" class="table table-bordered table-hover">
					<thead>
					<tr>
						<th>Título</th>
						<th>Universidade</th>
						<th>Ações</th>
					</tr>
					</thead>
					<tbody>
					<?php foreach ($pesquisas as $pesquisas) { ?>
						<tr>
							<td>
								<?= $pesquisas['SearchEvent']['title']; ?>
							</td>
							<td>
								<?= $pesquisas['SearchEvent']['school']; ?>
							</td>
							<td>
								<a href="<?= $this->webroot ?>Transformations/index/<?= $pesquisas['SearchEvent']['id'] ?>" title="Transformações">
									<i class="fa fa-television fa-lg"></i>
								</a>
								|
								<a href="<?= $this->webroot ?>Questions/cadastrar/<?= $pesquisas['SearchEvent']['id'] ?>" title="Cadastrar Questões">
									<i class="fa fa-text-width fa-lg"></i>
								</a>
								|
								<a href="<?= $this->webroot ?>Questions/survey/<?= $pesquisas['SearchEvent']['id'] ?>" title="Gerar Survey">
									<i class="fa fa-list-alt fa-lg"></i>
								</a>
								|
								<a href="<?= $this->webroot ?>answers/relatorios/<?= $pesquisas['SearchEvent']['id'] ?>" title="Relatórios da pesquisa">
									<i class="fa fa-television fa-lg"></i>
								</a>
							</td>
						</tr>
					<?php } ?>
					</tbody>
					<tfoot>
					<tr>
						<th>Título</th>
						<th>Universidade</th>
						<th>Ações</th>
					</tr>
					</tfoot>
				</table>
			</div>
			<!-- /.box-body -->
		</div>
		<!-- /.box -->
	</div>
	<!-- /.col -->
</div>
