<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="<?php echo assets_url('css/bootstrap.css'); ?>">
    <link rel="stylesheet" href="<?php echo assets_url('css/bootstrap-theme.css'); ?>">
    <link rel="stylesheet" href="<?php echo assets_url('css/dataTables.bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo assets_url('css/dataTables.responsive.css'); ?>">
    <link rel="stylesheet" href="<?php echo assets_url('css/animate.css'); ?>">
    <link rel="stylesheet" href="<?php echo assets_url('css/select2.css'); ?>">
    <link rel="stylesheet" href="<?php echo assets_url('css/select2-bootstrap.css'); ?>">
    <link rel="stylesheet" href="<?php echo assets_url('css/font-awesome.css'); ?>">
    <link rel="stylesheet" href="<?php echo assets_url('css/style.css'); ?>">
    <link rel="stylesheet" href="<?php echo assets_url('css/menu/style.css'); ?>">
    <link rel="stylesheet" href="<?php echo assets_url('css/font-awesome.css'); ?>">
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Roboto'>

    <script src="<?php echo assets_url('js/jquery.js') ?>" type="text/javascript" charset="utf-8" ></script>
    <script src="<?php echo assets_url('js/funciones.js') ?>" type="text/javascript" charset="utf-8" ></script>
    <script src="<?php echo assets_url('js/librerias.js') ?>" type="text/javascript" charset="utf-8" ></script>
    <script src="<?php echo assets_url('js/bootstrap.js'); ?>" type="text/javascript" charset="utf-8" ></script>
    <script src="<?php echo assets_url('js/jquery.dataTables.min.js'); ?>" type="text/javascript" charset="utf-8" ></script>
    <script src="<?php echo assets_url('js/dataTables.bootstrap.min.js'); ?>" type="text/javascript" charset="utf-8" ></script>
    <script src="<?php echo assets_url('js/bootbox.min.js'); ?>" type="text/javascript" charset="utf-8" ></script>
    <script src="<?php echo assets_url('js/jquery.mask.js'); ?>" type="text/javascript" charset="utf-8" ></script>
    <script src="<?php echo assets_url('js/select2.js'); ?>" type="text/javascript" charset="utf-8" ></script>
    <script src="<?php echo assets_url('js/select2_locale_es.js'); ?>" type="text/javascript" charset="utf-8" ></script>
    <script src="<?php echo assets_url('js/modal.js'); ?>" type="text/javascript" charset="utf-8" ></script>
    <script src="<?php echo assets_url('js/tooltip.js'); ?>" type="text/javascript" charset="utf-8" ></script>
    <script src="<?php echo assets_url('js/urls.js'); ?>" type="text/javascript" charset="utf-8" ></script>
    <title> <?php echo $title; ?> </title>
    <style type="text/css">
        html {
            position: relative;
            min-height: 100%;
        }
        body {
            /* Margin bottom by footer height */
            margin-bottom: 50px;
        }
        /*body{background-image:  url(<?php echo assets_url('css/menu/Background.png'); ?>);background-attachment: fixed;}*/
       /* body {
            width: 100%;
            height: 100%;
            position: absolute;
            background: url(<?php echo assets_url('css/menu/Background.png'); ?>) no-repeat fixed;
            background-size: cover;
            background-position: 50%;
        }*/

        .footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            /* Set the fixed height of the footer here */
            height: 55px;
            background-color: #f5f5f5;
        }
        body > .container {
            padding: 0 15px 15px 15px;
            /*background-color: red !important;*/
        }
        #content{
            -moz-animation-duration: 5s;
            -webkit-animation-duration: 5s;
            -o-animation-duration: 5s;
        }
        .panel-heading {
            background-color: #ffffff !important;
            border-bottom: 1px solid #e5e5e5 !important;
            border-top-left-radius: 3px;
            border-top-right-radius: 3px;
            padding: 10px 15px;
        }
        .letra-module{
            color: #428bca !important;
        }
        .container{
            margin:10px;
        }
        .navbar-nav > li > a, .navbar-brand {
            padding-top:10px !important;
            padding-bottom:10 !important;
            height: 30px;
            font-size: 13px;
        }
        .navbar {min-height:40px !important;}
        .sidebar-nav {
            padding: 9px 0;
        }
        .modal {
            outline: none;
            position: absolute;
            margin-top: 0;
            top: 20%;
            overflow: visible;
        }
        .dropdown-menu{
            font-size: 12px;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function($) {
            showClock();
            $('#logout').click(function(event) {
                event.preventDefault();
                var url = $(this).attr('href');
                bootbox.confirm({
                    size: 'small',
                    closeButton :false,
                    message: '<div style="text-align: center" class="text-danger">¿Desea cerrar la session?</div>',
                    callback: function(result){
                        if(result){
                            ulr = base_url(url);
                            window.location = url;
                        }
                    }
                });
            });

            $('#cp_menu').click(function(event){
                event.preventDefault();
                $('#cerrar').css('display','inline');
                $('#change').modal('show');
                console.log('asdffs');
            });

            if ( $("#hdcambio").val() === 0 ) {
                $('#change').modal('show');
            }
            $('#change_password').click(function(event) {
                var data_send = $('#frmcambio').serialize();
                $.post(base_url('seguridad/users/changepassword'), data_send, function(data, textStatus, xhr) {
                    if(data.success == 'ok' ){
                        bootbox.confirm({
                            closeButton :false,
                            message: '<div style="text-align: center">Cambio de clave exitoso,<span class="text-danger"> La aplicaci&oacute;n se actualizara para realizar los cambios</span></div>',
                            callback: function(result){
                                if(result){
                                    window.location = base_url();
                                }
                            }
                        });
                    }
                },'json');
            });

            // $( document ).on( "mousemove", function( event ) {
            //     console.log( "pageX: " + event.pageX + ", pageY: " + event.pageY );
            // });

        });

        var showClock = function(path){
            var Digital  = new Date();
            var anio     = Digital.getFullYear();
            var mes      = Digital.getMonth()+1;
            var dia      = Digital.getDate();
            var hora     = Digital.getHours();
            var minutos  = Digital.getMinutes();
            var segundos = Digital.getSeconds();
            var dn="AM";
            if (hora>12){ dn="PM"; hora=hora-12; }
            if (hora===0){ hora=12; }
            if (dia<=9){ dia="0"+dia; }
            if (mes<=9){ mes="0"+mes; }
            if (hora<=9){ hora="0"+hora; }
            if (minutos<=9){ minutos="0"+minutos; }
            if (segundos<=9){ segundos="0"+segundos; }
            var fecha        = "Fecha: "+dia+'/'+mes+'/'+anio;
            var tiempo       = " "+hora+":"+minutos+":"+segundos+" "+dn;
            var fecha_actual = fecha+tiempo;
            $('#fecha').text(fecha_actual);
            setTimeout("showClock()",1000);
        };
    </script>
</head>
<body>
    <header>
        <nav class="navbar navbar-inverse">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="<?php echo base_url(); ?>"><i class="fa fa-home"></i>&nbsp;<?php echo $this->config->item('project_name');?></a>

                </div>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <?php echo menu(); ?>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a data-hover="dropdown" data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <img class="img-circle pull-left" style='margin-top:-4px;margin-right: 5px;  width: 25px;height:25px;' src="<?php echo assets_url('img/profile/default.gif') ?>"/>
                                <?php echo $this->libreria->getName(); ?><span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu" style="width:100%">
                                <li><a href="">&nbsp;&nbsp;&nbsp;&nbsp;MI CUENTA</a></li>
                                <li><a href="#" id="cp_menu">&nbsp;&nbsp;&nbsp;&nbsp;CAMBIAR CLAVE</a></li>
                                <li><a id="logout" href="<?php echo base_url('seguridad/users/logout')?>"><span class="fa fa-sign-out"></span> CERRAR SESSI&Oacute;N</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <div class="container" style="width: 95%;">
        <div class="panel panel-default">
            <div class="panel-heading" style="font-weight: bold;font-size: 12px;height:35px"><span class="letra-module"><?php echo $module;?></span><span id="fecha" style="font-weight: bold;font-size: 12px;" class="span6 pull-right"></span></div>
            <div id="contents" class="panel-body"><?php echo $content ?></div>
        </div>
    </div>
    <input type="hidden" name="hdcambio" id="hdcambio" value="<?php echo access(); ?>"/>
    <div class="modal fade" style="top:5%" id="change" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Cambiar clave</h4>
                </div>
                <div class="modal-body">
                    <?php
                    $attributes = array('id' => 'frmcambio');
                    echo form_open('seguridad/users/changepassword', $attributes);
                    ?>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group col-xs-12">
                                <label >Clave actual</label>
                                <input type="text" id="clave_act" name="clave_act" class="form-control input-sm" value="">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group col-xs-12">
                                <label >Nueva clave</label>
                                <input type="text" id="clave_new" name="clave_new" class="form-control input-sm" value="">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group col-xs-12">
                                <label >Repetir clave</label>
                                <input type="text" id="clave_rnew" name="clave_rnew" class="form-control input-sm" value="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" id="cerrar" style="display: none" data-dismiss="modal">Cerrar</button>
                    <button type="button" id="change_password" class="btn btn-primary">Cambiar clave</button>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
    <footer class="footer" >
        <img  src="<?php echo assets_url('img/system/footer_1.png') ?>"/>
    </footer>
</body>
</html>