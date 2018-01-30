<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <?php echo $this->Html->css(array(
		'../bower_components/bootstrap/dist/css/bootstrap.min.css',
		'../bower_components/font-awesome/css/font-awesome.min.css',
		'../bower_components/Ionicons/css/ionicons.min.css',
		'../dist/css/AdminLTE.min.css',
		'../plugins/iCheck/square/blue.css',
	));
	?>

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="../../index2.html"><b>Admin</b>LTE</a>
  </div>
  <!-- /.login-logo -->
			<?php echo $this->Flash->render(); ?>
			<?php echo $this->fetch('content'); ?>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->
<?php echo $this->Html->script(array(
	'../bower_components/jquery/dist/jquery.min.js',
	'../bower_components/bootstrap/dist/js/bootstrap.min.js',
	'../plugins/iCheck/icheck.min.js'
));
?>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script>
</body>
</html>
