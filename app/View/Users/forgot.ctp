<div class="login-box-body">
    <p class="login-box-msg">informe seu e-mail para receber uma nova senha.</p>

    <form action="../../index2.html" method="post">
      <div class="form-group has-feedback">
        <input type="email" class="form-control" placeholder="Email">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
			</div>

      <div class="row">
				<!-- /.col -->
				<div class="col-xs-8">
				<div class="checkbox icheck">
            <label>
              <!-- <input type="checkbox"> Remember Me -->
            </label>
          </div>
        </div>
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Solicitar</button>
        </div>
        <!-- /.col -->
      </div>
    </form>
	<?php
echo $this->Html->link(
	'Já possuo um cadastro',
	array(
		'controller' => 'Users',
		'action' => 'login',
				//'ext' => 'html'
	),
	array(
		'class' => 'btn btn-block btn-social btn-facebook btn-flat'
	)
);
?>

  </div>
