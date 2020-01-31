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
                    <!-- /.navbar-collapse -->
                    <!-- Navbar Right Menu -->
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
<!--                            <li style="margin-top: 4%;">-->
<!--                                <div id="google_translate_element"></div>-->
<!--                            </li>-->
                            <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <?php if ($this->Session->read('Auth.User.sex') == 'Masculino') {?>
                                    <img src="<?=$this->webroot?>dist/img/male.jpg" class="user-image" alt="User Image">
                                    <?php } else {?>
                                    <img src="<?=$this->webroot?>dist/img/female.jpg" class="user-image" alt="User Image">
                                    <?php }?>
                                    <span class="hidden-xs">
                                        <?=$this->Session->read('Auth.User.email')?></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <!-- User image -->
                                    <li class="user-header">
                                        <?php if ($this->Session->read('Auth.User.sex') == 'Masculino') {?>
                                        <img src="<?=$this->webroot?>dist/img/male.jpg" class="img-circle" alt="User Image">
                                        <?php } else {?>
                                        <img src="<?=$this->webroot?>dist/img/female.jpg" class="img-circle" alt="User Image">
                                        <?php }?>
                                        <p>
                                            <?=$this->Session->read('Auth.User.name')?>
                                            <small>
                                                <?=date('d/m/Y', strtotime($this->Session->read('Auth.User.created')));?></small>
                                        </p>
                                    </li>
                                    <li class="user-footer">
                                        <div class="pull-right">
                                            <a href="<?=$this->webroot?>users/logout" class="btn btn-default btn-flat">Sair</a>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                        </ul>
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
));
?>
    <!-- jQuery 3 -->
    <!-- <script src="../../bower_components/jquery/dist/jquery.min.js"></script> -->
    <!-- Bootstrap 3.3.7 -->
    <!-- <script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script> -->
    <!-- SlimScroll -->
    <!-- <script src="../../bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script> -->
    <!-- FastClick -->
    <!-- <script src="../../bower_components/fastclick/lib/fastclick.js"></script> -->
    <!-- AdminLTE App -->
    <!-- <script src="../../dist/js/adminlte.min.js"></script> -->
    <!-- AdminLTE for demo purposes -->
    <!-- <script src="../../dist/js/demo.js"></script> -->
</body>

</html>

<script>
    //var offsetHeight = document.getElementById('calcula-height').offsetHeight;
    //if (offsetHeight >= 100) {
    //    var element = document.getElementById('calcula-height');
    //    element.style.position = null;
    //    element.style.block = null;
    //    element.style.hidden = null;
    //    document.getElementById('calcula-height').style.width = '99%';
   // } else {
   //     offsetHeight = offsetHeight + 30;
   //     var dm = document.getElementById("distancia-medida").style.marginTop = offsetHeight + "px";
   // }

    // $("#questao-2").show();
    // $("#questao-3").show();
    // $("#questao-4").show();
    // $("#questao-5").show();
    // $("#questao-6").show();
    // $("#questao-7").show();
    // $("#questao-8").show();
    // $("#questao-9").show();
    // $("#questao-10").show();
    // $("#questao-11").show();

    // $("#check").click(function () {
    //     if ($(this).val() == "N") {
    //         $("#questao-2").hide();
    //         $("#questao-3").hide();
    //         $("#questao-4").hide();
    //         $("#questao-5").hide();
    //         $("#questao-6").hide();
    //         $("#questao-7").hide();
    //         $("#questao-8").hide();
    //         $("#questao-9").hide();
    //         $("#questao-10").hide();
    //         $("#questao-11").hide();
    //         var obgJustificar = document.getElementById('text-justifique');
    //         obgJustificar.setAttribute('required', 'required');
    //         var selecionado = document.getElementById('check');
    //         selecionado.removeAttribute('checked', 'checked');
    //         var dp1 = document.getElementById('DP2');
    //         dp1.removeAttribute('required', 'required');
    //         var dp2 = document.getElementById('DP3');
    //         dp2.removeAttribute('required', 'required');
    //         var dp3 = document.getElementById('DP4');
    //         dp3.removeAttribute('required', 'required');
    //         var dp4 = document.getElementById('DP5');
    //         dp4.removeAttribute('required', 'required');
    //         var dp5 = document.getElementById('DP6');
    //         dp5.removeAttribute('required', 'required');
    //         // var dp6 = document.getElementById('DP7');
    //         // dp6.removeAttribute('required', 'required');
    //         // var dp7 = document.getElementById('DP8');
    //         // dp7.removeAttribute('required', 'required');
    //         // var dp8 = document.getElementById('DP9');
    //         // dp8.removeAttribute('required', 'required');
    //         // var dp9 = document.getElementById('DP10');
    //         // dp9.removeAttribute('required', 'required');
    //         // var dp10 = document.getElementById('DP11');
    //         // dp10.removeAttribute('required', 'required');

    //         var ndnc1 = document.getElementById('NDNC2');
    //         ndnc1.setAttribute('checked', 'checked');
    //         var ndnc2 = document.getElementById('NDNC3');
    //         ndnc2.setAttribute('checked', 'checked');
    //         var ndnc3 = document.getElementById('NDNC4');
    //         ndnc3.setAttribute('checked', 'checked');
    //         var ndnc4 = document.getElementById('NDNC5');
    //         ndnc4.setAttribute('checked', 'checked');
    //         var ndnc5 = document.getElementById('NDNC6');
    //         ndnc5.setAttribute('checked', 'checked');
    //         // var ndnc6 = document.getElementById('NDNC7');
    //         // ndnc6.setAttribute('checked', 'checked');
    //         // var ndnc7 = document.getElementById('NDNC8');
    //         // ndnc7.setAttribute('checked', 'checked');
    //         // var ndnc8 = document.getElementById('NDNC9');
    //         // ndnc8.setAttribute('checked', 'checked');
    //         // var ndnc9 = document.getElementById('NDNC10');
    //         // ndnc9.setAttribute('checked', 'checked');
    //         // var ndnc10 = document.getElementById('NDNC11');
    //         // ndnc10.setAttribute('checked', 'checked');
    //     }
    // });
    // $("#check1").click(function () {
    //     if ($(this).val() == "S") {
    //         $("#questao-2").show();
    //         $("#questao-3").show();
    //         $("#questao-4").show();
    //         $("#questao-5").show();
    //         $("#questao-6").show();
    //         $("#questao-7").show();
    //         $("#questao-8").show();
    //         $("#questao-9").show();
    //         $("#questao-10").show();
    //         $("#questao-11").show();
    //         var obgJustificar = document.getElementById('text-justifique');
    //         obgJustificar.removeAttribute('required', 'required');
    //         var dp1 = document.getElementById('DP2');
    //         dp1.setAttribute('required', 'required');
    //         var dp2 = document.getElementById('DP3');
    //         dp2.setAttribute('required', 'required');
    //         var dp3 = document.getElementById('DP4');
    //         dp3.setAttribute('required', 'required');
    //         var dp4 = document.getElementById('DP5');
    //         dp4.setAttribute('required', 'required');
    //         var dp5 = document.getElementById('DP6');
    //         dp5.setAttribute('required', 'required');
    //         // var dp6 = document.getElementById('DP7');
    //         // dp6.setAttribute('required', 'required');
    //         // var dp7 = document.getElementById('DP8');
    //         // dp7.setAttribute('required', 'required');
    //         // var dp8 = document.getElementById('DP9');
    //         // dp8.setAttribute('required', 'required');
    //         // var dp9 = document.getElementById('DP10');
    //         // dp9.setAttribute('required', 'required');
    //         // var dp10 = document.getElementById('DP11');
    //         // dp10.setAttribute('required', 'required');

    //         var ndnc1 = document.getElementById('NDNC2');
    //         ndnc1.removeAttribute('checked', 'checked');
    //         var ndnc2 = document.getElementById('NDNC3');
    //         ndnc2.removeAttribute('checked', 'checked');
    //         var ndnc3 = document.getElementById('NDNC4');
    //         ndnc3.removeAttribute('checked', 'checked');
    //         var ndnc4 = document.getElementById('NDNC5');
    //         ndnc4.removeAttribute('checked', 'checked');
    //         var ndnc5 = document.getElementById('NDNC6');
    //         ndnc5.removeAttribute('checked', 'checked');
    //         // var ndnc6 = document.getElementById('NDNC7');
    //         // ndnc6.removeAttribute('checked', 'checked');
    //         // var ndnc7 = document.getElementById('NDNC8');
    //         // ndnc7.removeAttribute('checked', 'checked');
    //         // var ndnc8 = document.getElementById('NDNC9');
    //         // ndnc8.removeAttribute('checked', 'checked');
    //         // var ndnc9 = document.getElementById('NDNC10');
    //         // ndnc9.removeAttribute('checked', 'checked');
    //         // var ndnc10 = document.getElementById('NDNC11');
    //         // ndnc10.removeAttribute('checked', 'checked');
    //     }
    // });
</script>
<script type="text/javascript">
    function googleTranslateElementInit() {
        new google.translate.TranslateElement({
            pageLanguage: 'pt',
            layout: google.translate.TranslateElement.InlineLayout.SIMPLE
        }, 'google_translate_element');
    }
</script>
<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
