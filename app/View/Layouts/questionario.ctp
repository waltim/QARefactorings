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
        '../plugins/iCheck/all.css',
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
    '../plugins/iCheck/icheck.min.js'
));
?>
<script
        type="text/javascript"
        src="<?= $this->webroot; ?>syntaxhighlighter/scripts/shBrushDiff.js"></script>
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
    $("#questao-2").show();
    $("#questao-3").show();
    $("#questao-4").show();
    $("#check").click(function () {
        if ($(this).val() == "N") {
            $("#questao-2").hide();
            $("#questao-3").hide();
            $("#questao-4").hide();
            var obgJustificar = document.getElementById('text-justifique');
            obgJustificar.setAttribute('required', 'required');
            var selecionado = document.getElementById('check');
            selecionado.removeAttribute('checked', 'checked');
            var dp1 = document.getElementById('DP2');
            dp1.removeAttribute('required', 'required');
            var dp2 = document.getElementById('DP3');
            dp2.removeAttribute('required', 'required');
            var dp3 = document.getElementById('DP4');
            dp3.removeAttribute('required', 'required');
        }
    });
    $("#check1").click(function () {
        if ($(this).val() == "S") {
            $("#questao-2").show();
            $("#questao-3").show();
            $("#questao-4").show();
            var obgJustificar = document.getElementById('text-justifique');
            obgJustificar.removeAttribute('required', 'required');
            var dp1 = document.getElementById('DP2');
            dp1.setAttribute('required', 'required');
            var dp2 = document.getElementById('DP3');
            dp2.setAttribute('required', 'required');
            var dp3 = document.getElementById('DP4');
            dp3.setAttribute('required', 'required');
        }
    });
$(function () {
    //iCheck for checkbox and radio inputs
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass   : 'iradio_minimal-blue'
    })
    //Red color scheme for iCheck
    $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
      checkboxClass: 'icheckbox_minimal-red',
      radioClass   : 'iradio_minimal-red'
    })
    //Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-green',
      radioClass   : 'iradio_flat-green'
    })
})
</script>
