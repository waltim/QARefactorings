<div class="login-box-body">
    <p class="login-box-msg">Enter your email to start the survey</p>

    <form action="<?= $this->webroot ?>Users/login" method="post">
      <div class="form-group has-feedback">
        <input name="data[User][email]" required type="email" class="form-control" placeholder="Email">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input name="data[User][password]" required type="password" class="form-control" placeholder="Senha">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
              <!-- <input type="checkbox">Lembrar dados -->
            </label>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Start</button>
        </div>
        <!-- /.col -->
      </div>
    </form>

    <!-- <div class="social-auth-links text-center">
      <p>- OR -</p>
      <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using
        Facebook</a>
      <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign in using
        Google+</a>
    </div> -->
    <!-- /.social-auth-links -->

		<!-- <a href="#">I forgot my password</a><br> -->
		<!-- <?php
	echo $this->Html->link(
		'Esqueci minha senha',
		array(
			'controller' => 'Users',
			'action' => 'forgot',
				//'ext' => 'html'
		),
		array(
      'class' => 'btn btn-block btn-social btn-google btn-flat',
      'style' => 'text-align: center; padding-left: 15px;'
		)
	);
	?>

	<?php
echo $this->Html->link(
	'Sou um usuário novo',
	array(
		'controller' => 'Users',
		'action' => 'register',
				//'ext' => 'html'
	),
	array(
    'class' => 'btn btn-block btn-social btn-facebook btn-flat',
    'style' => 'text-align: center; padding-left: 15px;'
	)
);
?>
-->
  </div>
