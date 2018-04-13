<?php
if (isset($this->session->userdata['logged_in'])) {
    // Variables de Sessión
    $modulo           = ($this->session->userdata['logged_in']['modulo']);
    $sub_modulo       = ($this->session->userdata['logged_in']['sub_modulo']);
    // Permiso de Acceso para los Módulos
    $id_modulo        = $this->ModelStandard->replace_string('-', ',', $modulo);
    $lista_modulo     = $this->ModelStandard->search_in('id', 'modulo', $id_modulo);
    // Permiso de Acceso para los Sub Módulos
    $id_sub_modulo    = $this->ModelStandard->replace_string('-', ',', $sub_modulo);
    $lista_sub_modulo = $this->ModelStandard->search_in('id', 'sub_modulo', $id_sub_modulo);
    $panel_p          = $this->session->userdata['logged_in']['panel_p'];
    $panel_s          = $this->session->userdata['logged_in']['panel_s'];
    $panel_d          = $this->session->userdata['logged_in']['panel_d'];
} else {
    $header = base_url() . "?error=1";
    header("location: " . $header);
}
?>
<html>
<title>SAPP <?= date('Y', now()) ?></title>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<!--SCRIPT CSS-->
<head>
    <link rel="icon" type="image/png" href="<?php echo base_url('assets/image/Home.png'); ?>" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap-select.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/pnotify.custom.min.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap.theme.css'); ?>">   
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/select2.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/select2-bootstrap.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/dataTables.responsive.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/dataTables.bootstrap.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/fancybox/jquery.fancybox.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/apprise.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap-datepicker.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/tooltips.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/fileinput.min.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap-colorpicker.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/datatable-edit/jquery.dataTables.min.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/datatable-edit/buttons.dataTables.min.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/datatable-edit/select.dataTables.min.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/datatable-edit/editor.dataTables.min.css'); ?>">

    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/normalize.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/ion.rangeSlider.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/ion.rangeSlider.skinFlat.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap-slider'); ?>">

    <!--SCRIPT JS-->
    <script src="<?php echo base_url('assets/js/jquery-1.11.2.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/bootstrap-select.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/pnotify.custom.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/jquery.blockUI.js'); ?>"></script>

    <script src="<?php echo base_url('assets/js/highcharts/highcharts.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/highcharts/highcharts-3d.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/highcharts/exporting.js'); ?>"></script>

    <script src="<?php echo base_url('assets/js/bootstrap.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/dataTables.responsive.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/datatable-edit/jquery.dataTables.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/datatable-edit/dataTables.buttons.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/datatable-edit/dataTables.select.min.js'); ?>"></script>
    <!--<script src="<?php echo base_url('assets/js/datatable-edit/dataTables.editor.min.js'); ?>"></script>-->
    <script src="<?php echo base_url('assets/js/fancybox/jquery.fancybox.js'); ?>"></script> 
    <script src="<?php echo base_url('assets/js/bootbox.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/apprise.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/json_response.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/alphanumeric.js'); ?>"></script>
    <!--<script src="<?php echo base_url('assets/js/validaciones.js'); ?>"></script>-->
    <script src="<?php echo base_url('assets/js/script.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/select2.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/select2_locale_es.js'); ?>"></script>


    <script src="<?php echo base_url('assets/js/bootstrap-datepicker.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/bootstrap-datepicker.es.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/dataTables.bootstrap.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/maskedinput.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/tooltips.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/fileinput.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/bootstrap-colorpicker.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/url.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/librerias.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/ion.rangeSlider.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/bootstrap-slider.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/jquery.number.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/ion.sound.js'); ?>"></script>
    <script>
        $(function () {
			// Validacion para autocompletar un guion (-) por cada 2 digitos
        $(".estructura").keyup(function () {
				var nums = new Array();
				var simb = "-"; //Éste es el separador
				var valor = $(this).val();
				valor = valor.toString();
				valor = valor.replace(/\D/g, "");   //Ésta expresión regular solo permitira ingresar números
				nums = valor.split(""); //Se vacia el valor en un arreglo
				var long = nums.length - 1; // Se saca la longitud del arreglo
				var patron = 2; //Indica cada cuanto se ponen las comas
				var prox = 1; // Indica en que lugar se debe insertar la siguiente coma
				var res = "";

				while (long > prox) {
					nums.splice((long - prox), 0, simb); //Se agrega la coma
					prox += patron; //Se incrementa la posición próxima para colocar la coma
				}

				for (var i = 0; i <= nums.length - 1; i++) {
					res += nums[i]; //Se crea la nueva cadena para devolver el valor formateado
				}

				$(this).val(res).attr('maxlength', 11);
			});
        
            $("li[title]").tooltips();
            $('#panel_p, #panel_s, #panel_d').colorpicker();
            $("nav.navbar, div.panel-heading").css("background-image","linear-gradient(to bottom, <?php echo $panel_p; ?> 0%, <?php echo $panel_p; ?> 100%)");
            $(".table tr:first").addClass('background-first');
            $( ".table tr:nth-child(2)" ).addClass('background-child-two');
            
            $("div.list-group-item-info, tr.background-first").css("background-image","linear-gradient(to bottom, <?php echo $panel_s; ?> 0%, <?php echo $panel_s; ?> 100%)");
            $("table#tabla_imputacion_presupuestaria").css("background-image","linear-gradient(to bottom, <?php echo $panel_s; ?> 0%, <?php echo $panel_s; ?> 100%)");


            $("div.modal-header, font").css("background-image","linear-gradient(to bottom, <?php echo $panel_s; ?> 0%, <?php echo $panel_s; ?> 100%)");
            $("tr.background-child-two").css("background-image","linear-gradient(to bottom, #d6e1e7 0%, #d6e1e7 100%)");

            $(".range").ionRangeSlider({
                hide_min_max: true,
                keyboard: true,
                min: 0,
                from: 0,
                to: 100,
                type: 'double',
                step: 1,
                prefix: "%",
                grid: true
            });
        });
    </script>
    <style>
		
		label{
			font-weight:bold;
		}

        td.details-control {
            background: url(<?php echo base_url('assets/image/details_open.png');?>) no-repeat center center;
            cursor: pointer;
        }
        tr.shown td.details-control {
            background: url(<?php echo base_url('assets/image/details_close.png');?>) no-repeat center center;
        }

        .nav > li > a:hover, .nav > li > a:focus  {
            text-decoration: none;
            background-color: <?php echo $panel_p; ?> !important;
            color: #FFFFFF !important;
            font-weight: bold;
        }

        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: <?php echo $panel_p; ?> !important;
            color: white;
        }



        .fondo_trans {
            background-image: url("<?php echo base_url('assets/image/background.jpg'); ?>");
            background-repeat: no-repeat;
            background-size: 100% auto;
        }
        
        /*.navbar-default .navbar-nav > li > a:hover, .navbar-default .navbar-nav > li > a:focus {
            background: linear-gradient(<?php echo $panel_d; ?>, <?php echo $panel_d; ?>) !important;
        }*/
        /*.navbar-default .navbar-nav > li > a:hover, .navbar-default .navbar-nav > li > a:focus {
            background-color: red !important;
        }*/
        .nav-tabs > li > a:hover {
            border-color: #eeeeee #e7e7e7;
        }
        .tooltip, .arrow:after {
            background: #012923;
            border: 2px solid white;
        }

        .form-control[disabled], .form-control[readonly], fieldset[disabled] .form-control {
            background-color: #FFFFFF;
            opacity: 1;
        }

        .list-group-item-info {
            background-color: <?php echo $panel_s; ?>;
            color: #ffffff;
        }
        .modal {
            bottom: 0;
            display: none;
            left: 0;
            outline: 0 none;
            overflow: hidden;
            position: fixed;
            right: 0;
            top: 17%;
            z-index: 1050;
        }

        .select2-results .select2-highlighted {
            color: #FFF;
            background-color: #75C0B0;
        }
        
        .site_title {
            background-color: #374a5e;
            color: #ecf0f1 !important;
            display: block;
            font-size: 22px;
            font-weight: 400;
            height: 55px;
            line-height: 59px;
            margin-bottom: 0;
            margin-left: 0 !important;
            margin-right: 0;
            overflow: hidden;
            padding-left: 10px;
            text-overflow: ellipsis;
            width: 100%;
        }

        .input-group-addon {
            padding: 7px 12px;
            font-size: 14px;
            font-weight: normal;
            line-height: 1;
            color: #fff;
            text-align: center;
            background-color: #eeeeee;
            border: 1px solid #e7e7e7;
            border-top-color: rgb(231, 231, 231);
            border-right-color: rgb(231, 231, 231);
            border-bottom-color: rgb(231, 231, 231);
            border-left-color: rgb(231, 231, 231);
            border-radius: 4px;
        }

        .panel {
            -webkit-box-shadow: 0 1px 2px rgba(0, 0, 0, .05);
            box-shadow: 0 1px 2px rgba(0, 0, 0, .05);
            background-color: #F1F1F1 !important;
        }

    </style>
    <script src="<?php echo base_url('assets/js/footerfijo.js'); ?>"></script>
    <script>
        $(document).ready(function () {

            $("form").keypress(function (e) {
                if (e.which == 13) {
                    return false;
                }
            });

            jQuery('.number').keyup(function () { 
                this.value = this.value.replace(/[^0-9\.]/g,'');
            });

            jQuery('.text').keyup(function () { 
                this.value = this.value.replace(/[^a-z\.]/g,'');
            });

            

            var change_id = '<?php echo $this->session->userdata['logged_in']['change_id']; ?>';
            
            //if (change_id == "" || change_id == "f") {
            //    $('div#div_cambio_user').modal({backdrop: 'static', keyboard: false});
            //}
            
            $(".cambio_password").click(function () {
				$('div#div_cambio_user').modal({backdrop: 'static', keyboard: false});
			});

            $(".actualizar_passwd").click(function () {
                var $password = $("#password_f");
                var $password_new = $("#password_new");
                var $password_new_r = $("#password_new_r");
                var formData = new FormData(document.getElementById("frmpassword"));
                if ($password.val() == "") {
                    bootbox.alert("Debe ingresar su contraseña anterior", function () {
                    }).on('hidden.bs.modal', function (event) {
                        $password.parent('div').addClass('has-error');
                        $password.focus();
                    });

                } else if ($password_new.val() == "") {
                    bootbox.alert("Debe ingresar su contraseña nueva", function () {
                    }).on('hidden.bs.modal', function (event) {
                        $password_new.parent('div').addClass('has-error');
                        $password_new.focus();
                    });

                } else if ($password_new_r.val() == "") {
                 bootbox.alert("Ingrese de nuevo su contraseña", function () {
                 }).on('hidden.bs.modal', function (event) {
                    $password_new_r.parent('div').addClass('has-error');
                    $password_new_r.focus();
                });

                 } else if ($password_new.val() != $password_new_r.val()) {
                    bootbox.alert("Disculpe, las contraseñas no coinciden", function () {
                    }).on('hidden.bs.modal', function (event) {
                        $password_new.parent('div').addClass('has-error');
                        $password_new_r.parent('div').addClass('has-error');
                        $password_new.focus();
                        $password_new_r.focus();
                    });

                } else {

                    bootbox.confirm("¿Está seguro de procesar la información?", function (result) {
                        if (result == true) {

                            $.post('<?php echo base_url(); ?>ControllersUser/cambio_password',$("#frmpassword").serialize(), function (response) {
                                if (response == 1) {
                                    bootbox.alert("Registro actualizado...");
                                    $.post('<?php echo base_url(); ?>ControllersUser/close_session', function (data) {
                                        window.location = '<?php echo base_url(); ?>';
                                    });
                                }else if (response == 2) {
                                    bootbox.alert("Disculpe, las contraseñas anterior no es correcta");
                                }
                            });
                        }
                    });
                }
            });

                // Proceso de Validacion para la captura de los Datos del Organismo
                $("a.myModal").click(function () {
                    var $org = <?= $this->session->userdata['logged_in']['pk'] ?>;
                    $.post('<?php echo base_url(); ?>acciones/proyecto/ControllersProyecto/search_table/id/organos_entes/' + $org + '', function (response) {
                        $("span#nom_ins").text("(" + response[0]['siglas'] + ") " + response[0]['nom_ins']);
                        $("#cargo").text(response[0]['cargo']);
                        $("#tlf").text(response[0]['tlf']);
                        $("#responsable").text(response[0]['nom_resp']);
                        $("#correo").text(response[0]['correo']);
                        $("#direccion").text(response[0]['direccion']);

                    }, 'json');
                });



                $("button.cierre_ano").click(function (e) {
                    e.preventDefault();  // Para evitar que se envíe por defecto

                    bootbox.dialog({
                        message: "<span style='color:red;'>Advertencia:</span> ¿Está usted seguro de realizar el cierre del Año fiscal <?= date('Y', now()) ?> ?, considerando que una vez que usted haya sido el cierre del año fiscal, no podrá revertir los cambios por ninguna razón agena a su voluntad. de lo contrario contacte al Administrador del Sistema.",
                        title: "Año Fiscal <?= date('Y', now()) ?>",
                        buttons: {
                            success: {
                                label: "Descartar",
                                className: "btn-primary",
                                callback: function () {

                                }
                            },
                            danger: {
                                label: "Cerrar Año Fiscal <?= date('Y', now()) ?>",
                                className: "btn-warning",
                                callback: function () {
                                    //alert(id)
                                    $.post('<?php echo base_url(); ?>cierre/ControllersCierre/close_ano', function (response) {
                                        bootbox.alert("Se ha cerrado el Año Fiscal <?= date('Y', now()) ?>", function () {
                                        }).on('hidden.bs.modal', function (event) {
                                        });
                                    });
                                }
                            }
                        }
                    });
                });

                $('input.capturar_item').numeric({allow: "."});
                $('textarea.numeric').numeric({allow: "."});

                $("input,select,textarea").change(function () {
                    $('input,select,textarea').parent('div').removeClass('has-error');
                });

                $(".logout").click(function (e) {
                    e.preventDefault();  // Para evitar que se envíe por defecto

                    bootbox.dialog({
                        message: "<span style='color:#015FA4;'>¿Desea salir del sistema SAPP?</span>",
                        //title: "<span style='color:#000000 ;'><?php echo $this->session->userdata['logged_in']['org_id'] ?></span>",
                        buttons: {
                            success: {
                                label: "Descartar",
                                className: "btn-primary",
                                callback: function () {

                                }
                            },
                            danger: {
                                label: "Cerrar",
                                className: "btn-warning",
                                callback: function () {
                                    //alert(id)
                                    $.post('<?php echo base_url(); ?>ControllersUser/close_session', function (response) {

                                        url = '<?php echo base_url(); ?>'
                                        window.location = url

                                    });
                                }
                            }
                        }
                    });
                });
            });
        </script>
        <style>
            .navbar-default .navbar-nav > li > a:hover, .navbar-default .navbar-nav > li > a:focus {
                background: linear-gradient(#64BCBC, #8CCECE);
            }
            .nav-tabs > li > a:hover {
                border-color: red #eeeeee #e7e7e7;
            }
            .tooltip, .arrow:after {
                background: #012923;
                border: 2px solid white;
            }

            .form-control[disabled], .form-control[readonly], fieldset[disabled] .form-control {
                background-color: #FFFFFF;
                opacity: 1;
            }

        </style>
    </head>

    <!-- Button trigger modal -->
    <!-- MODULO DINAMICO -->
    <nav class="navbar navbar-default" style="background: linear-gradient(<?php echo $panel_p; ?>, <?php echo $panel_p; ?>);height:54.4px;">
        <div id="navbar" class="navbar-collapse collapse">
            <?php
            $ver = $this->session->userdata['logged_in']['ver'];
            foreach ($lista_modulo as $value) {
                if ($value->desplegable == "t" AND $value->activo == "t") {
                    ?>
                    <ul class="nav navbar-nav" style="float:left; font-size: 16px">
                        <li id='id_inicio'>
                            <a style='color:#FFFFFF;' href='<?php echo base_url(); ?><?php echo $value->url ?>'><span class=""></span>&nbsp;&nbsp;<?php echo $value->modulo; ?></a>
                        </li>
                    </ul>
                    <?php
                }
            }
            ?>
            <?php
            foreach ($lista_modulo as $value) {
                if ($value->desplegable == "f") {
                    ?>
                    <ul class="nav navbar-nav" style="float:left; font-size: 16px">
                        <li class="dropdown">
                            <a style='color:#FFFFFF;' href="#" style="font-weight: bold" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i></i>&nbsp; <?php echo $value->modulo; ?> <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu" style="font-size: 16px">
                                <?php
                                foreach ($lista_sub_modulo as $value_s) {
                                    if ($value->id == $value_s->id_modulo AND $value_s->activo == "t") {
                                        ?>
                                        <li><a href='<?php echo base_url() ?><?php echo $value_s->url ?>'><i class=""></i>&nbsp;<?php echo $value_s->sub_modulo ?></button></a></li>
                                        <?php
                                    }
                                }
                                ?>
                            </ul>
                        </li>
                    </ul>
                    <?php
                }
            }
            ?>
            <!--<ul class="nav navbar-nav" style="float:left; font-size: 16px" <?php if($this->session->userdata['logged_in']['ver'] != 't'){?> hidden <?php } ?>>
                <li class="dropdown">
                    <a style='color:#FFFFFF;' href="#" style="font-weight: bold" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i></i>&nbsp; GESTIÓN <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu" style="font-size: 16px">
                        <li>
                            <a href='<?php echo base_url("/gestion/acc/0")?>'>
                                <i class=""></i>&nbsp;
                                ACCIÓN
                                </button>
                            </a>
                            <a href='<?php echo base_url("/gestion/proy/0")?>'>
                                <i class=""></i>&nbsp;
                                PROYECTO
                                </button>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul> -->

            <ul class="nav navbar-nav navbar-right" style="font-size: 16px">
				<?php if($this->session->userdata['logged_in']['change_id'] == "t"){?>
                <li style='display:none;'>
					<a style='color:#FFFFFF;' class="cambio_password" style="font-weight: bold;">
						Cambiar contraseña
					</a>
                </li>
                <?php }?>
                <li><a style='color:#FFFFFF;' class="logout" href="" title="Salir del sistema como usuario: <?php echo $this->session->userdata['logged_in']['username']; ?>" style="font-weight: bold"><span class='' style="color: white;"></span>&nbsp;&nbsp;&nbsp;<img class='borrar' id='<?php echo $value->id; ?>'  style="width:20px;height: 20px" src="<?php echo base_url("assets/image/login-128.png"); ?>"/> Salir del sistema</a></li>
            </ul>

        </div>

        <div style="text-align:center;cursor: pointer;" class="list-group-item list-group-item-info" title="Panel de Información">
            <img style="width:27px;height: 27px" src="<?php echo base_url("assets/image/organo.png"); ?>"/>   
            &nbsp;&nbsp;
            <span data-toggle="modal" data-target="#myModal">
                <?php echo $this->session->userdata['logged_in']['org_id'] ?>
            </span>
        </div>
    </nav>
    <!-- FIN DINAMICO -->

    <div style="float: right;margin: 15px;margin-top: -3%;position: relative;">
        <br/>
        <!-- <span style="font-weight: bold;">Usuario:</span> -->
        <?php
                //echo $this->session->userdata['logged_in']['first_name'];
        ?>
        <br/>
        
        <br/><br/>

        <?php
        //$datestring = "01/02/2016";
        //$time       = "%h:%i %a";
        #echo date('Y',now())
        #echo $this->db->last_query();
        #echo $_SERVER['REMOTE_ADDR'];
        #echo mdate($datestring);
        #echo mdate($time);
        //$fecha = explode('/', $datestring);
        //echo $fecha[2]."-".$fecha[1]."-".$fecha[0];
        ?>

    </div>
    <!--    <div id="footer" style="text-align:center;margin-bottom: -18px; margin-left: 0px">
            <img style="width: 100%;" src="<?php echo base_url() ?>assets/image/footer.png"/>
        </div>-->
        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="background-color:#050b24;">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <span class="modal-title" id="myModalLabel" style="background-color:#050b24;"><?= $this->session->userdata['logged_in']['org_id']; ?></span>
                    </div>
                    <div class="modal-body">
                        <ul>
                            <span style="color:#1A242F;font-weight: bold;">Órgano:&nbsp;&nbsp; </span><span id="nom_ins"></span>
                        </ul>
                        <ul>
                            <span style="color:#1A242F;font-weight: bold;">Responsable:&nbsp;&nbsp; </span><span id="responsable"></span>
                        </ul>
                        <ul>
                            <span style="color:#1A242F;font-weight: bold;">Teléfono:&nbsp;&nbsp; </span><span id="tlf"></span>
                        </ul>
                        <ul>
                            <span style="color:#1A242F;font-weight: bold;">Cargo:&nbsp;&nbsp; </span><span id="cargo"></span>
                        </ul>
                        <ul>
                            <span style="color:#1A242F;font-weight: bold;">Correo:&nbsp;&nbsp; </span><span id="correo"></span>
                        </ul>
                        <ul>
                            <span style="color:#1A242F;font-weight: bold;">Dirección:&nbsp;&nbsp; </span><span id="direccion"></span>
                        </ul>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-info" data-dismiss="modal">Cerrar Panel de Información</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="div_cambio_user" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <form method="post" enctype="multipart/form-data" id="frmpassword">
                            <div class="col-xs-12">
                                <div class="form-group col-xs-6" style="margin:auto;">
                                    <label>Contraseña anterior</label>
                                    <input style="text-transform: lowercase;" type="password" id='password_f' name='password_f' class="form-control" placeholder="Contraseña anterior" autofocus='autofocus'/>
                                </div>
                                <div class="form-group col-xs-6" style="margin:auto;">
                                    <label>Contraseña nueva</label>
                                    <input style="text-transform: lowercase;" type="password" id='password_new' name='password' class="form-control" placeholder="Contraseña nueva"/>
                                </div>
                            </div>
                            <div class="col-xs-12">
                                <div class="form-group col-xs-12">
                                    <label>Ingrese de nuevo la contraseña</label>
                                    <input style="text-transform: lowercase;" type="password" id='password_new_r' class="form-control" placeholder="Repita su contraseña"/>
                                    <input type="hidden" name='id' value="<?php echo $this->session->userdata['logged_in']['id']; ?>"/>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success actualizar_passwd">Cambiar</button>
                        <?php if($this->session->userdata['logged_in']['change_id'] == "t"){?>
                        <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Cerrar</button>
                        <?php }?>
                    </div>
                </div>
            </div>
        </div>
        <!-- FIN DE FORMULARIO -->

        <body>





