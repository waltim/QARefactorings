<!DOCTYPE html>
<html>
<style>
.skin-blue .wrapper, .skin-blue .main-sidebar, .skin-blue .left-side {
    background-color: #ecf0f5 !important;
}
</style>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>QARefactorings | Survey</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <!-- <link rel="stylesheet" href="../../bower_components/bootstrap/dist/css/bootstrap.min.css"> -->
    <!-- Font Awesome -->
    <!-- <link rel="stylesheet" href="../../bower_components/font-awesome/css/font-awesome.min.css"> -->
    <!-- Ionicons -->
    <!-- <link rel="stylesheet" href="../../bower_components/Ionicons/css/ionicons.min.css"> -->
    <!-- Theme style -->
    <!-- <link rel="stylesheet" href="../../dist/css/AdminLTE.min.css"> -->
    <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
    <!-- <link rel="stylesheet" href="../../dist/css/skins/_all-skins.min.css"> -->

    <?php echo $this->Html->css(array(
    '../bower_components/bootstrap/dist/css/bootstrap.min.css',
    '../bower_components/font-awesome/css/font-awesome.min.css',
    '../bower_components/Ionicons/css/ionicons.min.css',
    '../dist/css/AdminLTE.min.css',
    '../dist/css/skins/_all-skins.min.css',
    '../php-form/form.css',
	'../syntaxhighlighter/styles/shCoreEclipse.css',
	//'../syntaxhighlighter/styles/shCoreDefault.css',
));
?>

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->

<body class="hold-transition skin-blue layout-top-nav">
    <div class="wrapper">
        <header class="main-header">
            <nav class="navbar navbar-static-top">
                <div class="container">
                    <div class="navbar-header">
                        <a href="<?=$this->webroot?>" class="logo">
                            <!-- mini logo for sidebar mini 50x50 pixels -->
                            <span class="logo-mini"><b>Q</b>AR</span>
                            <!-- logo for regular state and mobile devices -->
                            <span class="logo-lg"><b>QAR</b>efactorings</span>
                        </a>
                    </div>
                    </div>
                    <!-- /.navbar-custom-menu -->
                </div>
                <!-- /.container-fluid -->
            </nav>
        </header>
        <!-- Full Width Column -->
        <?php echo $this->Session->flash(); ?>
        <div class="content-wrapper">
            <?php echo $this->Flash->render(); ?>
            <?php echo $this->fetch('content'); ?>
        </div>
        <!-- /.content-wrapper -->
        <footer class="main-footer">
            <div class="pull-right hidden-xs">
                <b>Version</b> 2.4.0
            </div>
            <strong>Copyright &copy; 2014-2016 <a href="https://adminlte.io">Almsaeed Studio</a>.</strong> All rights
            reserved.
        </footer>
    </div>
    <!-- ./wrapper -->

    <?php echo $this->Html->script(array(
    '../bower_components/jquery/dist/jquery.min.js',
    '../bower_components/bootstrap/dist/js/bootstrap.min.js',
    '../bower_components/jquery-slimscroll/jquery.slimscroll.min.js',
    '../bower_components/fastclick/lib/fastclick.js',
    '../dist/js/adminlte.min.js',
    '../dist/js/demo.js',
	'../syntaxhighlighter/scripts/XRegExp.js',
	'../syntaxhighlighter/scripts/shCore.js',
	'../syntaxhighlighter/scripts/shBrushJava.js',
));
?>
</body>

</html>

<script>
</script>
<script type="text/javascript"
		src="<?=$this->webroot;?>syntaxhighlighter/scripts/shBrushDiff.js"></script>
<script>
	SyntaxHighlighter.config.tagName = "code";
	SyntaxHighlighter.defaults['gutter'] = false;
	SyntaxHighlighter.defaults['toolbar'] = false;
	SyntaxHighlighter.config.bloggerMode = true;
	SyntaxHighlighter.defaults['diff'] = [1, 2.3];
	var element1 = document.getElementById('codigo1');
	var element2 = document.getElementById('codigo2');
	SyntaxHighlighter.defaults['highlight'] = [<?=$question['Result']['Transformation']['deletions']?>];
	SyntaxHighlighter.highlight(undefined, element1);
	SyntaxHighlighter.defaults['highlight'] = [<?=$question['Result']['Transformation']['additions']?>];
	SyntaxHighlighter.highlight(undefined, element2);
</script>
