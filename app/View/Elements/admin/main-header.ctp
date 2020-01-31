<header class="main-header">
    <!-- Logo -->
    <a href="<?= $this->webroot ?>" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>Q</b>AR</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>QAR</b>efactorings</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- User Account: style can be found in dropdown.less -->
<!--                <li style="margin-top: 4%;"><div id="google_translate_element"></div></li>-->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <?php if ($this->Session->read('Auth.User.sex') == 'Masculino') { ?>
                        <?php } else { ?>
                        <?php } ?>
                    </a>

                </li>
                <!-- Control Sidebar Toggle Button -->
                <!-- <li>
                  <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                </li> -->
            </ul>
        </div>
    </nav>
</header>
