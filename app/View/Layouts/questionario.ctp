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
    <div class="container-fluid questionario-estilizado">
        <?php echo $this->Flash->render(); ?>
        <?php echo $this->fetch('content'); ?>
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
<script>
    $("#questao-2").show();
    $("#questao-3").show();
    $("#questao-4").show();
    $("#questao-5").show();
    $("#questao-6").show();
    $("#questao-7").show();
    $("#questao-8").show();
    $("#questao-9").show();
    $("#questao-10").show();
    $("#questao-11").show();
   
    $("#check").click(function () {
        if ($(this).val() == "N") {
            $("#questao-2").hide();
            $("#questao-3").hide();
            $("#questao-4").hide();
            $("#questao-5").hide();
            $("#questao-6").hide();
            $("#questao-7").hide();
            $("#questao-8").hide();
            $("#questao-9").hide();
            $("#questao-10").hide();
            $("#questao-11").hide();
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
            var dp4 = document.getElementById('DP5');
            dp4.removeAttribute('required', 'required');
            var dp5 = document.getElementById('DP6');
            dp5.removeAttribute('required', 'required');
            var dp6 = document.getElementById('DP7');
            dp6.removeAttribute('required', 'required');
            var dp7 = document.getElementById('DP8');
            dp7.removeAttribute('required', 'required');
            var dp8 = document.getElementById('DP9');
            dp8.removeAttribute('required', 'required');
            var dp9 = document.getElementById('DP10');
            dp9.removeAttribute('required', 'required');
            var dp10 = document.getElementById('DP11');
            dp10.removeAttribute('required', 'required');

            var ndnc1 = document.getElementById('NDNC2');
            ndnc1.setAttribute('checked', 'checked');
            var ndnc2 = document.getElementById('NDNC3');
            ndnc2.setAttribute('checked', 'checked');
            var ndnc3 = document.getElementById('NDNC4');
            ndnc3.setAttribute('checked', 'checked');
            var ndnc4 = document.getElementById('NDNC5');
            ndnc4.setAttribute('checked', 'checked');
            var ndnc5 = document.getElementById('NDNC6');
            ndnc5.setAttribute('checked', 'checked');
            var ndnc6 = document.getElementById('NDNC7');
            ndnc6.setAttribute('checked', 'checked');
            var ndnc7 = document.getElementById('NDNC8');
            ndnc7.setAttribute('checked', 'checked');
            var ndnc8 = document.getElementById('NDNC9');
            ndnc8.setAttribute('checked', 'checked');
            var ndnc9 = document.getElementById('NDNC10');
            ndnc9.setAttribute('checked', 'checked');
            var ndnc10 = document.getElementById('NDNC11');
            ndnc10.setAttribute('checked', 'checked');
        }
    });
    $("#check1").click(function () {
        if ($(this).val() == "S") {
            $("#questao-2").show();
            $("#questao-3").show();
            $("#questao-4").show();
            $("#questao-5").show();
            $("#questao-6").show();
            $("#questao-7").show();
            $("#questao-8").show();
            $("#questao-9").show();
            $("#questao-10").show();
            $("#questao-11").show();
            var obgJustificar = document.getElementById('text-justifique');
            obgJustificar.removeAttribute('required', 'required');
            var dp1 = document.getElementById('DP2');
            dp1.setAttribute('required', 'required');
            var dp2 = document.getElementById('DP3');
            dp2.setAttribute('required', 'required');
            var dp3 = document.getElementById('DP4');
            dp3.setAttribute('required', 'required');
            var dp4 = document.getElementById('DP5');
            dp4.setAttribute('required', 'required');
            var dp5 = document.getElementById('DP6');
            dp5.setAttribute('required', 'required');
            var dp6 = document.getElementById('DP7');
            dp6.setAttribute('required', 'required');
            var dp7 = document.getElementById('DP8');
            dp7.setAttribute('required', 'required');
            var dp8 = document.getElementById('DP9');
            dp8.setAttribute('required', 'required');
            var dp9 = document.getElementById('DP10');
            dp9.setAttribute('required', 'required');
            var dp10 = document.getElementById('DP11');
            dp10.setAttribute('required', 'required');

            var ndnc1 = document.getElementById('NDNC2');
            ndnc1.removeAttribute('checked', 'checked');
            var ndnc2 = document.getElementById('NDNC3');
            ndnc2.removeAttribute('checked', 'checked');
            var ndnc3 = document.getElementById('NDNC4');
            ndnc3.removeAttribute('checked', 'checked');
            var ndnc4 = document.getElementById('NDNC5');
            ndnc4.removeAttribute('checked', 'checked');
            var ndnc5 = document.getElementById('NDNC6');
            ndnc5.removeAttribute('checked', 'checked');
            var ndnc6 = document.getElementById('NDNC7');
            ndnc6.removeAttribute('checked', 'checked');
            var ndnc7 = document.getElementById('NDNC8');
            ndnc7.removeAttribute('checked', 'checked');
            var ndnc8 = document.getElementById('NDNC9');
            ndnc8.removeAttribute('checked', 'checked');
            var ndnc9 = document.getElementById('NDNC10');
            ndnc9.removeAttribute('checked', 'checked');
            var ndnc10 = document.getElementById('NDNC11');
            ndnc10.removeAttribute('checked', 'checked');
        }
    });
$(function () {
    // //iCheck for checkbox and radio inputs
    // $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
    //   checkboxClass: 'icheckbox_minimal-blue',
    //   radioClass   : 'iradio_minimal-blue'
    // })
    // //Red color scheme for iCheck
    // $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
    //   checkboxClass: 'icheckbox_minimal-red',
    //   radioClass   : 'iradio_minimal-red'
    // })
    // //Flat red color scheme for iCheck
    // $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
    //   checkboxClass: 'icheckbox_flat-green',
    //   radioClass   : 'iradio_flat-green'
    // })
})
</script>