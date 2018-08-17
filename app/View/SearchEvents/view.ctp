<?php echo $this->Html->css(array(
    'styles.css',
));
?>
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">PHP LibDiff - Examples</h3>
            </div>
            <div class="clearfix"></div>
            <!-- /.box-header -->
            <div class="box-body">
                <?php

                // Include the diff class
                require_once ROOT . DS . 'app' . DS . 'Vendor' . DS . 'php-diff/lib/Diff.php';

                // Include two sample files for comparison
                $a = explode("\n", file_get_contents(ROOT . DS . 'app' . DS . 'Vendor' . DS . 'php-diff/example/a.txt'));
                $b = explode("\n", file_get_contents(ROOT . DS . 'app' . DS . 'Vendor' . DS . 'php-diff/example/b.txt'));

                // Options for generating the diff
                $options = array(
                    //'ignoreWhitespace' => true,
                    //'ignoreCase' => true,
                );

                // Initialize the diff class
                $diff = new Diff($a, $b, $options);

                ?>
                <h2>Side by Side Diff</h2>
                <?php

                // Generate a side by side diff
                require_once ROOT . DS . 'app' . DS . 'Vendor' . DS . 'php-diff/lib/Diff/Renderer/Html/SideBySide.php';
                $renderer = new Diff_Renderer_Html_SideBySide;
                echo $diff->Render($renderer);

                ?>
                <!-- <h2>Inline Diff</h2> -->
                <?php
                // Generate an inline diff
                // require_once ROOT . DS . 'app' . DS . 'Vendor' . DS . 'php-diff/lib/Diff/Renderer/Html/Inline.php';
                // $renderer = new Diff_Renderer_Html_Inline;
                // echo $diff->render($renderer);
                ?>
                <!-- <h2>Unified Diff</h2>
                <pre><?php

                    // Generate a unified diff
                    // require_once ROOT . DS . 'app' . DS . 'Vendor' . DS . 'php-diff/lib/Diff/Renderer/Text/Unified.php';
                    // $renderer = new Diff_Renderer_Text_Unified;
                    // echo htmlspecialchars($diff->render($renderer));

                    ?>
                </pre> -->
                <!-- <h2>Context Diff</h2> -->
                <!-- <pre><?php

                    // Generate a context diff
                //     require_once ROOT . DS . 'app' . DS . 'Vendor' . DS . 'php-diff/lib/Diff/Renderer/Text/Context.php';
                //     $renderer = new Diff_Renderer_Text_Context;
                //    echo htmlspecialchars($diff->render($renderer));
                //    ?>
		</pre> -->
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col -->
    <div class="col-xs-12">
        <div class="questionario-estilizado">
            <div class=" sombra-div">

            </div>
        </div>
    </div>
</div>