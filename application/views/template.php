<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>SISTEMA DE RESEÑA</title>

        <!-- Bootstrap -->

        <link href="<?php echo assets_url('vendors/bootstrap/dist/css/bootstrap.css'); ?>" rel="stylesheet" />
        <link href="<?php echo assets_url('vendors/bootstrap/dist/css/bootstrap-theme.css'); ?>" rel="stylesheet" />
        <link href="<?php echo assets_url('vendors/font-awesome/css/font-awesome.min.css'); ?>" rel="stylesheet" />
        <link href="<?php echo assets_url('vendors/nprogress/nprogress.css'); ?>" rel="stylesheet" />
        <link href="<?php echo assets_url('vendors/select2/dist/css/select2.min.css'); ?>" rel="stylesheet" />

        <link href="<?php echo assets_url('vendors/datatables.net-bs/css/dataTables.bootstrap.css'); ?>" rel="stylesheet" />
        <link href="<?php echo assets_url('vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css'); ?>" rel="stylesheet" />

        <link href="<?php echo assets_url('vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css'); ?>" rel="stylesheet" />
        <link href="<?php echo assets_url('vendors/pnotify/dist/pnotify.css'); ?>" rel="stylesheet">
        <link href="<?php echo assets_url('vendors/pnotify/dist/pnotify.buttons.css'); ?>" rel="stylesheet">
        <link href="<?php echo assets_url('vendors/pnotify/dist/pnotify.nonblock.css'); ?>" rel="stylesheet">
        <link href="<?php echo assets_url('vendors/iCheck/skins/flat/green.css'); ?>" rel="stylesheet">

        <link href="<?php echo assets_url('build/css/custom.min.css'); ?>" rel="stylesheet" />
        <link href="<?php echo assets_url('css/animate.css'); ?>" rel="stylesheet" />
        <link href="<?php echo assets_url('css/datepicker3.css'); ?>" rel="stylesheet" />
        <link href="<?php echo assets_url('css/fileinput.css'); ?>" rel="stylesheet" />
        
        <!--<link href="<?php echo assets_url('css/fancybox/jquery.fancybox.css'); ?>" rel="stylesheet" />-->

        <script src="<?php echo assets_url('vendors/jquery/dist/jquery.min.js'); ?>"></script>
        <script src="<?php echo assets_url('vendors/bootstrap/dist/js/bootstrap.min.js'); ?>"></script>
        <script src="<?php echo assets_url('vendors/nprogress/nprogress.js'); ?>"></script>

        <script src="<?php echo assets_url('js/bootbox.min.js'); ?>"></script>
        <script src="<?php echo assets_url('js/fileinput.js'); ?>"></script>

        <script src="<?php echo assets_url('vendors/datatables.net/js/jquery.dataTables.min.js'); ?>"></script>
        <script src="<?php echo assets_url('vendors/datatables.net-bs/js/dataTables.bootstrap.min.js'); ?>"></script>
        <script src="<?php echo assets_url('vendors/datatables.net-buttons/js/dataTables.buttons.min.js'); ?>"></script>
        <script src="<?php echo assets_url('vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js'); ?>"></script>
        <script src="<?php echo assets_url('vendors/datatables.net-buttons/js/buttons.html5.js'); ?>"></script>
        <script src="<?php echo assets_url('vendors/datatables.net-buttons/js/buttons.print.js'); ?>"></script>
        <script src="<?php echo assets_url('vendors/datatables.net-buttons/js/buttons.flash.min.js'); ?>"></script>

        <script src="<?php echo assets_url('js/jquery.mask.js'); ?>"></script>
        <script src="<?php echo assets_url('js/bootstrap-datepicker.js'); ?>"></script>
        <script src="<?php echo assets_url('js/bootstrap-datepicker.es.js'); ?>"></script>

        <script src="<?php echo assets_url('vendors/select2/dist/js/select2.full.min.js'); ?>"></script>

        <script src="<?php echo assets_url('vendors/pnotify/dist/pnotify.js'); ?>"></script>
        <script src="<?php echo assets_url('vendors/pnotify/dist/pnotify.buttons.js'); ?>"></script>
        <script src="<?php echo assets_url('vendors/pnotify/dist/pnotify.nonblock.js'); ?>"></script>
        <script src="<?php echo assets_url('vendors/iCheck/icheck.min.js'); ?>"></script>
        <script src="<?php echo assets_url('vendors/jQuery-Smart-Wizard/js/jquery.smartWizard.js'); ?>"></script>

        <script src="<?php echo assets_url('js/select2_locale_es.js'); ?>"></script>
        <script src="<?php echo assets_url('js/funciones.js'); ?>"></script>
        <script src="<?php echo assets_url('js/librerias.js'); ?>"></script>
        <script src="<?php echo assets_url('js/validarcampos.js'); ?>"></script>
        <script src="<?php echo assets_url('js/jquery.numeric.js') ?>" type="text/javascript" charset="utf-8" ></script>
        <!--<script src="<?php echo assets_url('js/fancybox/jquery.fancybox.js'); ?>"></script>-->
        
        
        <style type="text/css" media="screen">
            .cursor{
                cursor: pointer;
            }
        </style>
    </head>
    <body class="nav-md">
        <div class="container body">
            <div class="main_container">
                <div class="col-md-3 left_col">
                    <div class="left_col scroll-view">
                        <div class="navbar nav_title" style="border: 0;">
                            <a href="<?php echo base_url(); ?>" class="site_title">
                                <i class="fa fa-user"></i>
                                <span>
                                    <?php echo $this->config->item('project_name'); ?>
                                </span>
                            </a>
                        </div>
                        <div class="clearfix"></div>
                        <!-- menu profile quick info -->
                        <div class="profile">
                            <div class="profile_pic">
                                <img src="<?php echo assets_url('img/profile/default.gif'); ?>" alt="..." class="img-circle profile_img">
                            </div>
                            <div class="profile_info">
                                <span>Bienvenido,</span>
                                <h2><?php echo $this->libreria->getName(); ?></h2>
                            </div>
                        </div>
                        <!-- /menu profile quick info -->

                        <br />

                        <!-- sidebar menu -->
                        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                            <div class="menu_section">
                                <h3>General</h3>
                                <ul class="nav side-menu">
                                    <li>
                                        <a href="<?php echo base_url('consulta'); ?>">
                                            <i class="fa fa-search"></i> CONSULTA
                                            </span>
                                        </a>                                        
                                    </li>
                                    <?php echo menu(); ?>
                                    <!-- <li>
                                        <a  href="<?php echo assets_url('descarga/manual.pdf'); ?>" target="_blank">
                                            <i class="fa fa-file-text-o"></i>
                                            MANUAL
                                        </a>
                                    </li> -->
                                </ul>
                            </div>
                        </div>
                        <!-- /sidebar menu -->
                    </div>
                </div>
                <!-- top navigation -->
                <div class="top_nav">
                    <div class="nav_menu">
                        <nav>
                            <div class="nav toggle">
                                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                            </div>
                            <ul class="nav navbar-nav navbar-right">
                                <li class="">
                                    <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                        <img src="<?php echo assets_url('img/profile/default.gif'); ?>" alt=""><?php echo $this->libreria->getName(); ?>
                                        <span class=" fa fa-angle-down"></span>
                                    </a>
                                    <ul class="dropdown-menu dropdown-usermenu pull-right">
                                        <li><a href="javascript:;"> Perfil</a></li>
                                        <li><a href="<?php echo base_url('index.php/seguridad/users/logout') ?>"><i class="fa fa-sign-out pull-right"></i>Salir</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <!-- /top navigation -->
                <!-- page content -->
                <div class="right_col" role="main">
                    <?php echo $content ?>
                </div>
                <!-- /page content -->
                <!-- footer content -->
                <footer>
                    <div class="pull-right">
                        SISTEMA DE RESEÑA
                    </div>
                    <div class="clearfix"></div>
                </footer>
                <!-- /footer content -->
            </div>
        </div>

        <!-- jQuery -->
        <script src="<?php echo assets_url('build/js/custom.min.js'); ?>"></script>

    </body>
</html>
