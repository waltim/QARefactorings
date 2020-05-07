<div class="row">
	<div class="col-xs-12">
		<div class="box">
			<div class="box-header">
				<h3 class="box-title">Codificações abertas e axial</h3>
			</div>
			<!-- /.box-header -->
			<div class="box-body">
				<table id="example2" class="table table-bordered table-hover">
					<thead>
					<tr>
						<th>ID</th>
						<th>Answers</th>
						<th>Open Coding</th>
						<th>Polarity</th>
						<th>Categories</th>
						<th>Subcategories</th>
						<th>Observation</th>
					</tr>
					</thead>
					<tbody>
					<?php foreach ($data as $evaluatings) { ?>
						<tr>
							<td>
								<?= $evaluatings[0]; ?>
							</td>
							<td>
								<?= $evaluatings[1]; ?>
							</td>
							<td>
								<?= $evaluatings[2]; ?>
							</td>
							<td>
								<?= $evaluatings[3]; ?>
							</td>
							<td>
								<?= $evaluatings[4]; ?>
							</td>
							<td>
								<?= $evaluatings[5]; ?>
							</td>
							<td>
								<?= $evaluatings[6]; ?>
							</td>
						</tr>
					<?php } ?>
					</tbody>
					<tfoot>
					<tr>
						<th>ID</th>
						<th>Answers</th>
						<th>Open Coding</th>
						<th>Polarity</th>
						<th>Categories</th>
						<th>Subcategories</th>
						<th>Observation</th>
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
