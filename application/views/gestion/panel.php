
<head>
<link rel="icon" type="image/png" href="<?php echo base_url('assets/image/Home.png'); ?>" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/pnotify.custom.min.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap.theme.css'); ?>">   
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/select2.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/select2-bootstrap.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/dataTables.responsive.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/dataTables.bootstrap.css'); ?>">
<style>

.text-decoration{
    text-decoration: none !important;
}

.div-panel {
    height: 200px;
    font-size: 17px;
    text-align: justify;
    padding: 5%;
    cursor: pointer;
    border-radius: 42px 42px 42px 42px;
    -moz-border-radius: 42px 42px 42px 42px;
    -webkit-border-radius: 42px 42px 42px 42px;
    border: 0px solid #000000;
    color: black;
}

label {
	font-weight: normal;
	background-color: #b75050 !important;
	height: 44px !important;
	padding: 1% !important;
}

.form-control {
	display: inline-block;
	width: auto;
	vertical-align: middle;
	height: 46px !important;
}


}
</style>
</head>
<div class="row-fluid" >
    <div class="form-group col-xs-6">
        <div class="panel panel-default">
            <div class="panel-heading">Cierre Año Fiscal</div>
            <div class="panel-body">
                <button type="button" class="btn btn-danger cierre_ano">Cerrar Año Fiscal <?= date('Y', now()) ?>
                    
                </button>
            </div>
        </div>
    </div>
    <div class="form-group col-xs-6">
        <div class="panel panel-default">
            <div class="panel-heading">Habilitar proceso trimestral</div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-6 col-md-6" style="width: 100%;">
                        <form class="navbar-form navbar-left" role="search" id="frmtrimestre">
                            <input type="hidden" name="id" value="<?php echo $get_config_sistem->id?>">
                            <div class="form-group">
                              <select class="selectpicker" multiple data-live-search="true" data-live-search-placeholder="Search" data-actions-box="true" id="ids_trimestre" name="ids_trimestre[]">
                                <optgroup label="Trimestres">
                                  <option value="0">--------</option>
                                  <option value="1" <?php if($get_config_sistem->i == 't'){?> selected="" <?php }?>>I</option>
                                  <option value="2" <?php if($get_config_sistem->ii == 't'){?> selected="" <?php }?>>II</option>
                                  <option value="3" <?php if($get_config_sistem->iii == 't'){?> selected="" <?php }?>>III</option>
                                  <option value="4" <?php if($get_config_sistem->iv == 't'){?> selected="" <?php }?>>IV</option>
                                </optgroup>
                              </select>
                            </div>

                            <div class="input-group">
                              <div class="input-group-btn">
                                <button class="btn btn-success send-data-trimestre" type="button">
                                    <i class="glyphicon glyphicon-save"></i>
                                    Habilitar
                                </button>
                              </div>
                            </div>
                          </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">Apertura o Cierre</div>
            <div class="panel-body">
                <div class="row">
                    <div class="alert alert-danger" style="font-weight: bold;color: #000000;">Indentifique con el código de Acción Centralizada o Proyecto para buscar</div>
                    <div class="col-xs-6 col-md-6" style="width: 100%;">
                        <form class="navbar-form navbar-left" role="search" id="frmaccproy">
                            <div class="form-group">
                              <select class="form-control" id="ano_fiscal">
                                    <option value="0">Seleccione</option>
                                  <?php foreach (range(2013, 2045) as $numero) { ?>
                                        <?php if($numero == $ano_fiscal){?>
                                            <option selected value="<?php echo $numero; ?>"><?php echo $numero; ?></option>
                                        <?php }else{?>
                                            <option value="<?php echo $numero; ?>"><?php echo $numero; ?></option>
                                        <?php }?>
                                        <?php
                                    }
                                    ?>
                              </select>
                            </div>
                            <div class="form-group">
                                <input type="hidden" id='cierre' name="cierre">
                              <select class="form-control" id="accion">
                                <?php if($acc == 1){?>
                                    <option selected="" value="1">Apertura</option>
                                <?php }else{?>
                                    <option value="1">Apertura</option>
                                <?php }?>
                                <?php if($acc == 2){?>
                                    <option selected="" value="2">Cierre</option>
                                <?php }else{?>
                                    <option value="2">Cierre</option>
                                <?php }?>
                              </select>
                            </div>
                            <div class="form-group">
                              <select class="selectpicker" multiple data-live-search="true" data-live-search-placeholder="Buscar" data-actions-box="true" id="ids_accion" name="ids_accion[]">
                                <optgroup label="Acciones">
                                    <?php foreach ($accion as $key => $value) {?>
                                        <option value="<?php echo $value->id?>"><?php echo $value->codigo?></option>
                                    <?php }?>
                                  
                                </optgroup>
                              </select>
                            </div>
                            <div class="form-group">
                              <select class="selectpicker" multiple data-live-search="true" data-live-search-placeholder="Buscar" data-actions-box="true" id="ids_proyecto" name="ids_proyecto[]">
                                <optgroup label="Proyectos">
                                    <?php foreach ($proyecto as $key => $value) {?>
                                        <option value="<?php echo $value->id?>"><?php echo $value->codigo?></option>
                                    <?php }?>
                                  
                                </optgroup>
                              </select>
                            </div>
                            <div class="input-group">
                              <div class="input-group-btn">
                                <button class="btn btn-success send-data-cierre" type="button">
                                    <i class="glyphicon glyphicon-save"></i>
                                    Guardar
                                </button>
                              </div>
                            </div>
                          </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class='alert alert-info'>
			          <div class='row'>
			            <div class="col-sm-2 col-lg-12">
			              <label for='tabla_consulta'>Año</label>
			              <select class='form-control' id='ano_fiscal' style='width:10%;'>
			                <?php foreach (range(2013, 2045) as $numero) { ?>
			                  <?php if($numero == date('Y', now())){?>
			                    <option selected="" value="<?php echo $numero; ?>"><?php echo $numero; ?></option>
			                  <?php }else{?>
			                    <option value="<?php echo $numero; ?>"><?php echo $numero; ?></option>
			                  <?php }?>
			                <?php }?>
			              </select>
			              <label for='tabla_consulta'>Consulta</label>
			              <select class='form-control' id='tabla_consulta' style='width:25%;'>
			                <option value='acciones_registro'>Acción</option>
			                <option value='proyecto_registro'>Proyecto</option>
			              </select>
			              <label for='tipo_grafico'>Gráfico</label>
			              <select class='form-control' id='tipo_grafico' style='width:25%;'>
			                <option value='pie'>Torta</option>
			                <option value='bar'>Columna</option>
			              </select>
			              <label for='trimestre'>Trimestre</label>
			              <select class='form-control' id='trimestre' style='width:10%;'>
			                <option value='1,2,3'>I</option>
			                <option value='4,5,6'>II</option>
			                <option value='7,8,9'>III</option>
			                <option value='10,11,12'>IV</option>
			              </select>
			              
			            </div>
			          </div>
			        </div>
<div class="row">
    <div class="col-sm-6 col-lg-6">
<div id="container-grafico-1" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
    </div>
    <div class="col-sm-6 col-lg-6">
<div id="container-grafico-2" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
    </div>
</div>
<br/>
<div class="row">
    <div class="col-sm-6 col-lg-12">
<div id="container-grafico-3" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
    </div>
</div>

<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap-select.css'); ?>">

<script src="<?php echo base_url('assets/js/jquery-1.11.2.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/bootstrap-select.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/pnotify.custom.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.blockUI.js'); ?>"></script>

<script src="<?php echo base_url('assets/js/bootstrap.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/highcharts/highcharts.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/highcharts/highcharts-3d.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/highcharts/exporting.js'); ?>"></script>

<script src="<?php echo base_url('assets/js/datatable-edit/jquery.dataTables.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/datatable-edit/dataTables.buttons.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/datatable-edit/dataTables.select.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/bootbox.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/apprise.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/alphanumeric.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/script.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/select2.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/select2_locale_es.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/bootstrap-datepicker.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/bootstrap-datepicker.es.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/dataTables.bootstrap.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/maskedinput.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/tooltips.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/fileinput.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/url.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/librerias.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/panel.js'); ?>"></script>
<script type="text/javascript">
	$(document).ready(function () {
		//$.sonido("mensaje"); // Seteamos los contenedores para los mensajes a emitir

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

        // Busqueda de registro de Accion
        $("#ano_fiscal, #accion").change(function () {
            var accion     = $("#accion").val();
            var ano_fiscal = $("#ano_fiscal").val();
            var url = base_url("/gestion/panel?ano_fiscal=" + ano_fiscal+"&accion="+accion);
            window.location = url;
        });
		         
         $("button.send-data-cierre").on('click', function (e) {
            var title = $("#accion").val();
            var accion     = $("#accion").val();
            var ano_fiscal = $("#ano_fiscal").val();

            if(title == 1){acc = 2; message = "Cierre";}else{acc = 1; message = "Apertura";}
            $("#cierre").val(acc);

            bootbox.dialog({
                message: "<span style='color:red;'>Advertencia:</span> ¿ Está usted de acuerdo en realizar el proceso de "+message,
                title: "",
                buttons: {
                    danger: {
                        label: message,
                        className: "btn-warning",
                        callback: function () {
                            $.post('<?php echo base_url("gestion/GestionControllers/save_config"); ?>', $('#frmaccproy').serialize(), function (res) {
                                 if(res.success == "ok" ){
                                     
                                     //ion.sound.play("mensaje"); // Accion para notificar un mensaje de voz para el envio de mensajes
                                     
                                     bootbox.alert("Guardado con exito", function () {
                                        }).on('hidden.bs.modal', function (event) {
                                            url = base_url("/gestion/panel?ano_fiscal=" + ano_fiscal+"&accion="+accion);
                                            window.location = url;
                                        });
                                 }
                             },'json');
                        }
                    }
                }
            });
         });

         // Habilitar proceso trimestral
         $("button.send-data-trimestre").on('click', function (e) {
            var ids_trimestre = document.getElementById('ids_trimestre').value;
            if(ids_trimestre == 0){
                bootbox.alert("Indentifique algún valor trimestral");
                return true;
            }
            
            bootbox.dialog({
                message: "<span style='color:red;'>Advertencia:</span> ¿ Está usted de acuerdo en habilitar los valores trimestrales?",
                title: "",
                buttons: {
                    success: {
                        label: "Descartar",
                        className: "btn-primary",
                        callback: function () {

                        }
                    },
                    danger: {
                        label: "Trimestre",
                        className: "btn-warning",
                        callback: function () {
                            $.post('<?php echo base_url("gestion/GestionControllers/save_config_sistem"); ?>', $('#frmtrimestre').serialize(), function (res) {
                                 if(res.success == "ok" ){
                                     
                                     //ion.sound.play("mensaje"); // Accion para notificar un mensaje de voz para el envio de mensajes
                                     
                                     bootbox.alert("Guardado con exito", function () {
                                        }).on('hidden.bs.modal', function (event) {
                                            url = base_url("/gestion/panel");
                                            //window.location = url;
                                        });
                                 }
                             },'json');
                        }
                    }
                }
            });
		 });

     });
</script>


