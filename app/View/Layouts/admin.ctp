<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>QARefactorings | Analyser</title>
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

    <?php if ($this->request->params['action'] == 'edit' || $this->request->params['action'] == 'add' || $this->request->params['action'] == 'loadDataCsv') { ?>
        <?php echo $this->Html->css(array(
            '../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css',
            '../bower_components/select2/dist/css/select2.min.css',
            '../dist/css/AdminLTE.min.css',
        ));
        ?>
        <?php

    } elseif ($this->request->params['action'] == 'index' || $this->request->params['action'] == 'relatorios') { ?>
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
    <?php if ($this->request->params['controller'] == 'transformations' && $this->request->params['action'] == 'view' || $this->request->params['controller'] == 'questions' && $this->request->params['action'] == 'cadastrar') { ?>
        <?php echo $this->Html->css(array(
            '../syntaxhighlighter/styles/shCoreDefault.css',
            'jquery.dataTables.min.css',
            'buttons.dataTables.min.css'
        ));
        ?>
        <?php

    } ?>
    <!-- Google Font -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="sidebar-mini skin-red-light">
<div class="wrapper">
    <?php echo $this->element('admin/main-header'); ?>
    <?php
    if ($this->session->read('Auth.User.UserType.description') === 'administrador') {
        echo $this->element('admin/main-sidebar');
    } elseif ($this->session->read('Auth.User.UserType.description') === 'pesquisador') {
        echo $this->element('admin/main-sidebar-pesquisador');
    } else {
        echo $this->element('admin/main-sidebar-candidato');
    }
    ?>
    <div class="content-wrapper">
        <section class="content">
            <?php echo $this->Session->flash(); ?>
            <?php echo $this->fetch('content'); ?>
        </section>
    </div>
    <?php echo $this->element('admin/main-footer'); ?>
    <div class="control-sidebar-bg"></div>
</div>
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
<?php if ($this->request->params['action'] == 'edit' || $this->request->params['action'] == 'add' || $this->request->params['action'] == 'loadDataCsv') { ?>
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
            var arrayOfValues = ["1", "2", "4"];
            $('.select2').val(arrayOfValues)
            $('.select2').select2()
        })
    </script>
<?php

} elseif ($this->request->params['action'] == 'index' || $this->request->params['action'] == 'relatorios') { ?>
<?php echo $this->Html->script(array(
    '../bower_components/datatables.net/js/jquery.dataTables.min.js',
    '../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js'
));
?>
    <script>
        $(function () {
            $('#example2').DataTable({
                'paging': true,
                'lengthChange': true,
                'searching': true,
                'ordering': true,
                'info': true,
                'autoWidth': true
            })
        })
    </script>
    <?php

} ?>
<?php if ($this->request->params['controller'] == 'transformations' && $this->request->params['action'] == 'view' || $this->request->params['controller'] == 'questions' && $this->request->params['action'] == 'cadastrar') { ?>
    <?php echo $this->Html->script(array(
        'jquery.dataTables.min.js',
        'dataTables.buttons.min.js',
        'jszip.min.js',
        'pdfmake.min.js',
        'vfs_fonts.js',
        'buttons.html5.min.js',
        '../syntaxhighlighter/scripts/XRegExp.js',
        '../syntaxhighlighter/scripts/shCore.js',
        '../syntaxhighlighter/scripts/shBrushXml.js',
    ));
    ?>
    <!--    <script type="text/javascript"-->
    <!--            src="--><? //= $this->webroot; ?><!--syntaxhighlighter/scripts/shBrush--><? //= $transformation['Language']['description']; ?><!--.js"></script>-->
    <script type="text/javascript"
            src="<?= $this->webroot; ?>syntaxhighlighter/scripts/shBrushDiff.js"></script>
    <script>
        SyntaxHighlighter.config.tagName = "code";
        SyntaxHighlighter.defaults['gutter'] = true;
        SyntaxHighlighter.defaults['toolbar'] = false;
        SyntaxHighlighter.config.bloggerMode = true;
        SyntaxHighlighter.defaults['diff'] = [1, 2.3];
        var element1 = document.getElementById('codigo1');
        var element2 = document.getElementById('codigo2');
        SyntaxHighlighter.defaults['highlight'] = [<?=$transformation['Transformation']['deletions']?>];
        SyntaxHighlighter.highlight(undefined, element1);
        SyntaxHighlighter.defaults['highlight'] = [<?=$transformation['Transformation']['additions']?>];
        SyntaxHighlighter.highlight(undefined, element2);

        $(document).ready(function () {
            $('#example2').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copyHtml5',
                    'excelHtml5',
                    'csvHtml5',
                    'pdfHtml5'
                ]
            });
        });
    </script>
    <?php

} ?>
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
