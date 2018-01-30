<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | Dashboard</title>

  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <?php echo $this->Html->css(array(
		'../bower_components/bootstrap/dist/css/bootstrap.min.css',
		'../bower_components/font-awesome/css/font-awesome.min.css',
		'../bower_components/Ionicons/css/ionicons.min.css',
		'../dist/css/AdminLTE.min.css',
		'../dist/css/skins/_all-skins.min.css',
		'../bower_components/morris.js/morris.css',
		'../bower_components/jvectormap/jquery-jvectormap.css',
		'../bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css',
		'../bower_components/bootstrap-daterangepicker/daterangepicker.css',
		'../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css',
	));
	?>
  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

<?php echo $this->element('admin/main-header'); ?>
<?php echo $this->element('admin/main-sidebar'); ?>
<?php echo $this->element('admin/content-wrapper'); ?>
<?php echo $this->element('admin/main-footer'); ?>

  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->
<?php echo $this->Html->script(array(
	'../bower_components/jquery/dist/jquery.min.js',
	'../bower_components/jquery-ui/jquery-ui.min.js',
	'../bower_components/bootstrap/dist/js/bootstrap.min.js',
	'../bower_components/raphael/raphael.min.js',
	'../bower_components/morris.js/morris.min.js',
	'../bower_components/jquery-sparkline/dist/jquery.sparkline.min.js',
	'../plugins/jvectormap/jquery-jvectormap-1.2.2.min.js',
	'../plugins/jvectormap/jquery-jvectormap-world-mill-en.js',
	'../bower_components/jquery-knob/dist/jquery.knob.min.js',
	'../bower_components/moment/min/moment.min.js',
	'../bower_components/bootstrap-daterangepicker/daterangepicker.js',
	'../bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js',
	'../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js',
	'../bower_components/jquery-slimscroll/jquery.slimscroll.min.js',
	'../bower_components/fastclick/lib/fastclick.js',
	'../dist/js/adminlte.min.js',
	//'../dist/js/pages/dashboard.js',
	'../dist/js/demo.js'
));
?>

<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>

</body>
</html>
