<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Quality analysis of Refactoring of code | Questions</title>
    <?php echo $this->Html->css(array(
        '../bower_components/bootstrap/dist/css/bootstrap.min.css',
        '../bower_components/font-awesome/css/font-awesome.min.css',
        '../bower_components/Ionicons/css/ionicons.min.css',
        '../dist/css/AdminLTE.min.css',
        '../php-form/form.css',
        '../syntaxhighlighter/styles/shCoreDefault.css',
    ));
    ?>
</head>
<body>
<?php echo $this->Session->flash(); ?>
<div class="container-fluid">
    <div class="container-fluid form-top">
        <?php echo $this->Flash->render(); ?>
        <?php echo $this->fetch('content'); ?>
    </div>
</div>
</body>
</html>
<?php echo $this->Html->script(array(
    '../bower_components/jquery/dist/jquery.min.js',
    '../bower_components/bootstrap/dist/js/bootstrap.min.js',
    '../bower_components/fastclick/lib/fastclick.js',
    '../dist/js/adminlte.min.js',
    '../dist/js/demo.js',
    '../syntaxhighlighter/scripts/XRegExp.js',
    '../syntaxhighlighter/scripts/shCore.js',
    '../syntaxhighlighter/scripts/shBrushXml.js',
));
?>
<!--<script type="text/javascript"-->
<!--        src="--><?//= $this->webroot; ?><!--syntaxhighlighter/scripts/shBrush--><?//= $question['Result']['Transformation']['Language']['description']; ?><!--.js"></script>-->
<script
        type="text/javascript"
        src="<?= $this->webroot; ?>syntaxhighlighter/scripts/BrushDiff.js"></script>
<script>
    SyntaxHighlighter.config.tagName = "code";
    SyntaxHighlighter.defaults['gutter'] = false;
    SyntaxHighlighter.defaults['toolbar'] = false;
    SyntaxHighlighter.config.bloggerMode = true;
    var element1 = document.getElementById('codigo1');
    var element2 = document.getElementById('codigo2');
    SyntaxHighlighter.defaults['highlight'] = [<?=$question['Result']['Transformation']['deletions']?>];
    SyntaxHighlighter.highlight(undefined, element1);
    SyntaxHighlighter.defaults['highlight'] = [<?=$question['Result']['Transformation']['additions']?>];
    SyntaxHighlighter.highlight(undefined, element2);
    $("#codigo-antes").addClass('col-md-6')
    $("#codigo-depois").addClass('col-md-6')
</script>
