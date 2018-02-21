<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Quality analysis of Refactoring of code | Questions</title>
        <!-- Latest compiled and minified CSS -->
        <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" > -->
        <!-- Optional theme -->
        <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css"> -->
		<?php echo $this->Html->css(array(
		'../bower_components/bootstrap/dist/css/bootstrap.min.css',
		'../bower_components/font-awesome/css/font-awesome.min.css',
		'../bower_components/Ionicons/css/ionicons.min.css',
		'../dist/css/AdminLTE.min.css',
		'../php-form/form.css',
		'../highlight/styles/idea.css',
		));
		?>
    </head>
    <body>
		<?php echo $this->Session->flash(); ?>
        <div class="container">
            <div class="container form-top">
			<?php echo $this->Flash->render(); ?>
			<?php echo $this->fetch('content'); ?>
            </div>
        </div>
    </body>
</html>
<?php echo $this->Html->script(array(
	'../bower_components/jquery/dist/jquery.min.js',
	'../highlight/highlight.pack.js',
));
?>
<script>
hljs.configure({useBR: true});
$('div code').each(function(i, block) {
  hljs.highlightBlock(block);
});
</script>

