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
                <li style="margin-top: 4%;"><div id="google_translate_element"></div></li>
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <?php if ($this->Session->read('Auth.User.sex') == 'Masculino') { ?>
                            <img src="<?= $this->webroot ?>dist/img/male.jpg" class="user-image" alt="User Image">
                        <?php } else { ?>
                            <img src="<?= $this->webroot ?>dist/img/female.jpg" class="user-image" alt="User Image">
                        <?php } ?>
                        <span class="hidden-xs"><?= $this->Session->read('Auth.User.email') ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <?php if ($this->Session->read('Auth.User.sex') == 'Masculino') { ?>
                                <img src="<?= $this->webroot ?>dist/img/male.jpg" class="img-circle" alt="User Image">
                            <?php } else { ?>
                                <img src="<?= $this->webroot ?>dist/img/female.jpg" class="img-circle" alt="User Image">
                            <?php } ?>
                            <p>
                                <?= $this->Session->read('Auth.User.name') ?>
                                <small><?= date('d/m/Y', strtotime($this->Session->read('Auth.User.created'))); ?></small>
                            </p>
                        </li>
                        <!-- Menu Body -->
                        <!-- <li class="user-body">
                          <div class="row">
                            <div class="col-xs-4 text-center">
                              <a href="#">Followers</a>
                            </div>
                            <div class="col-xs-4 text-center">
                              <a href="#">Sales</a>
                            </div>
                            <div class="col-xs-4 text-center">
                              <a href="#">Friends</a>
                            </div>
                          </div>
                        </li> -->
                        <!-- Menu Footer-->
                        <li class="user-footer">
						<?php if($this->Session->check('Auth.User')){ ?>
                            <div class="pull-right">
                                <a href="<?= $this->webroot ?>users/logout" class="btn btn-default btn-flat">Sair</a>
                            </div>
						<?php } ?>
						</li>
                    </ul>
                </li>
                <!-- Control Sidebar Toggle Button -->
                <!-- <li>
                  <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                </li> -->
            </ul>
        </div>
    </nav>
</header>
