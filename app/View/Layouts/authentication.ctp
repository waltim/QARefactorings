<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>QAR | Log in</title>
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
<!--<div id="google_translate_element"></div>-->
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="<?= $this->webroot ?>"><b>QAR</b>efactorings</a>
	</div>
	    <?php echo $this->Session->flash(); ?>
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

<script type="text/javascript">
    function googleTranslateElementInit() {
        new google.translate.TranslateElement({
            pageLanguage: 'pt',
            layout: google.translate.TranslateElement.InlineLayout.SIMPLE
        }, 'google_translate_element');
    }
</script>
<script type="text/javascript"
        src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
</body>
</html>
