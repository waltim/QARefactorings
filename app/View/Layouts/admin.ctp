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
		//'../dist/css/AdminLTE.min.css',
	'../dist/css/skins/_all-skins.min.css',
		//'../bower_components/morris.js/morris.css',
		//'../bower_components/jvectormap/jquery-jvectormap.css',
		//'../bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css',
		//'../bower_components/bootstrap-daterangepicker/daterangepicker.css',
		//'../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css',
));
?>

	<?php if ($this->request->params['action'] == 'edit' || $this->request->params['action'] == 'add') { ?>
		<?php echo $this->Html->css(array(
		'../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css',
		'../bower_components/select2/dist/css/select2.min.css',
		'../dist/css/AdminLTE.min.css',
	));
	?>
	<?php
} elseif ($this->request->params['action'] == 'index') { ?>
		<?php echo $this->Html->css(array(
		'../bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css',
		'../dist/css/AdminLTE.min.css'
	));
	?>
	<?php
} else { ?>
		<?php echo $this->Html->css(array(
		'../dist/css/AdminLTE.min.css',
	));
	?>
	<?php
} ?>
	<?php if ($this->request->params['controller'] == 'transformations' && $this->request->params['action'] == 'view') { ?>
		<?php echo $this->Html->css(array(
		'../syntaxhighlighter/styles/shCoreDefault.css',
	));
	?>
	<?php
} ?>
  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="sidebar-mini skin-red-light">
<div class="wrapper">
<?php echo $this->element('admin/main-header'); ?>
<?php echo $this->element('admin/main-sidebar'); ?>
<div class="content-wrapper">
<section class="content">
<?php echo $this->Session->flash(); ?>
<?php echo $this->fetch('content'); ?>
</section>
</div>
<?php echo $this->element('admin/main-footer'); ?>

  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->
<?php echo $this->Html->script(array(
	'../bower_components/jquery/dist/jquery.min.js',
	'../bower_components/bootstrap/dist/js/bootstrap.min.js',
	'../bower_components/fastclick/lib/fastclick.js',
	'../dist/js/adminlte.min.js',
	'../dist/js/demo.js',
	// '../bower_components/jquery-ui/jquery-ui.min.js',
	// '../bower_components/raphael/raphael.min.js',
	// '../bower_components/morris.js/morris.min.js',
	// '../bower_components/jquery-sparkline/dist/jquery.sparkline.min.js',
	// '../plugins/jvectormap/jquery-jvectormap-1.2.2.min.js',
	// '../plugins/jvectormap/jquery-jvectormap-world-mill-en.js',
	// '../bower_components/jquery-knob/dist/jquery.knob.min.js',
	// '../bower_components/moment/min/moment.min.js',
	// '../bower_components/bootstrap-daterangepicker/daterangepicker.js',
	// '../bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js',
	//'../bower_components/jquery-slimscroll/jquery.slimscroll.min.js',
	//'../dist/js/pages/dashboard.js'
));
?>
<?php if ($this->request->params['action'] == 'edit' || $this->request->params['action'] == 'add') { ?>
<?php echo $this->Html->script(array(
	'../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js',
	'../bower_components/select2/dist/js/select2.full.min.js'
));
?>
<script>
  $(function () {
    $('.textarea').wysihtml5()
  })
	$(function () {
		$('.select2').select2()
  })
</script>
<?php
} elseif ($this->request->params['action'] == 'index') { ?>
	<?php echo $this->Html->script(array(
	'../bower_components/datatables.net/js/jquery.dataTables.min.js',
	'../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js'
));
?>
	<script>
  $(function () {
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : true
    })
  })
</script>
	<?php
} ?>
	<?php if ($this->request->params['controller'] == 'transformations' && $this->request->params['action'] == 'view') { ?>
	<?php echo $this->Html->script(array(
	'../syntaxhighlighter/scripts/XRegExp.js',
	'../syntaxhighlighter/scripts/shCore.js',
	'../syntaxhighlighter/scripts/shBrushJava.js',
));
?>
<script type="text/javascript">
	SyntaxHighlighter.config.bloggerMode = false;
	SyntaxHighlighter.defaults['toolbar'] = false;
  SyntaxHighlighter.all();
</script>
	<?php
} ?>
</body>
</html>
