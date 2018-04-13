
<br/>
<br/>
<br/>
<br/>

  <div style="width: 95%;text-transform:uppercase;box-shadow: 0 1px 5px rgba(0,0,0,.85);margin: auto;" class="panel panel-default">
    <div class="panel-heading" style='background: linear-gradient(#2F9292, #3B7272);color:#FFFFFF;'>
      <label style="float: left" class="panel-title "><!--<a href="<?php echo base_url(); ?>acciones/registro/ControllersRegistro" >Configuraciones</a>-->
        Gestión de Control</label>
        <br>
      </div>
      <br/>
      <!-- Apertura de Tabs (Secciones) -->
      <ul class="nav nav-tabs">
        <li class="active" data-toggle="popover" data-trigger="focus" title="Identificación" data-placement="top">
          <a data-toggle="tab" href="#tabs_identificacion">Acción</a>
        </li>
      </ul>
      <br>
      <div class="tab-content">
        <div id="tabs_identificacion" class="tab-pane fade in active">
          <div class="panel-body">
            <div class="form-inline jumbotron">
			<div class="col-xs-2">
				<label for='ano_fiscal'>Año fiscal</label>
				<select id='ano_fiscal' style='width: 100%;' class="search-acc">
					<option value=''>Año</option>
					<?php
					foreach (range(2013, 2045) as $numero) {
						?>
						<?php if($numero == date('Y', now())){?>
							<option selected value="<?php echo $numero; ?>"><?php echo $numero; ?></option>
						<?php }else{?>
							<option value="<?php echo $numero; ?>"><?php echo $numero; ?></option>
						<?php }?>
						<?php
					}
					?>
				</select>
			</div>
              <div class="form-group col-xs-8">
				<label for='nom_acc'>Acciones</label>
                <select class="form-control search-acc" id='nom_acc' name='nom_acc' style='width: 100%;'>
                  <option value='0'>Seleccione</option>
                  <?php
                    foreach ($busqueda_acc as $value) {
                      ?>
                      <?php if($value->id == $id_org){ $selected ='selected';}else{$selected ='';}?>

                      <option <?php echo $selected; ?> value="<?php echo $value->id; ?>">
						(<?php echo trim($value->codigo); ?>)&nbsp;
						<?php echo trim($value->nom_ins); ?>
                      </option>

                      <?php
                    }
                    ?>
                </select>
              </div>
              <div class="form-group col-xs-2">
              	<label for='trimestres'></label>
              	<select id="trimestres" class="form-control" style="margin-top: 11%;">
              		<option value="1">I</option>
              		<option value="2">II</option>
              		<option value="3">III</option>
              		<option value="4">IV</option>
              	</select>
              	<label for='pdf'></label>
              	<button <?php if($this->session->userdata['logged_in']['is_superuser'] == 'f'){?> disabled <?php } ?> title="Clic para ver informe..." style="margin-top: 11%;cursor: pointer;" class="btn btn-info generar_pdf">Imprimir</button>
              </div>
              <br/>
              <!--<div class="form-group col-xs-8">
                <input type="text" class="form-control " value='<?php if(isset($obj_org->nom_ins) == ""){echo "Seleccione la Acción a buscar...";}else{echo $obj_org->nom_ins;}?>' disabled='' id='nom_org' style='width: 100%;'/>
              </div>-->
              <!--<div class="form-group col-xs-1">
                <span class="input-group-addon open_report btn-info" style="cursor: pointer;" title="Imprimir">IMPRIMIR &nbsp;<span class="glyphicon glyphicon-print"></span></span>
              </div>
              <div class="form-group col-xs-1">
                <span class="input-group-addon open_report_email btn-info" style="cursor: pointer;" title="Reportar">REPORTAR &nbsp;<span class="glyphicon glyphicon-circle-arrow-down"></span></span>
              </div>-->
              <br/>
            </div>
                <div class="form-inline">
                  <div class="form-group col-xs-12 jumbotron">
					<div class='alert alert-info' style='color: #000000;'>Clic en la celda para abrir el formulario e ingresar los datos para la Ejecución Física.</div>
                    <fieldset>
                      <legend>EJECUCIÓN FISICA</legend>
                        <table id="table-gestion-acc" class="table-gestion-acc table-bordered table-striped table-hover table-condensed dt-responsive table-responsive" style="width: 100%;">
                          <thead>
                            <tr>
                              <th>Actividad</th>
                              <th>Unidad de medida</th>
                              <th>Programado</th>
                              <th>Semaforo</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php foreach ($act_acc as $key => $value) { ?>
                              <tr title='Clic para ingresar los datos de la ejecución Física' class='row-detail' style='cursor:pointer;' data-id='<?php echo $value->id;?>'  data-I='<?php echo $value->i;?>' data-II='<?php echo $value->ii;?>' data-III='<?php echo $value->iii;?>' data-IV='<?php echo $value->iv;?>' data-trimestre_i='<?php echo $value->trimestre_i;?>' data-trimestre_ii='<?php echo $value->trimestre_ii;?>' data-trimestre_iii='<?php echo $value->trimestre_iii;?>' data-trimestre_iv='<?php echo $value->trimestre_iv;?>'>
                                <td style='width:60% !important;'><?php echo $value->actividad;?></td>
                                <td style='width:30% !important;'><?php echo $value->unidad_medida;?></td>
                                <td><?php echo $value->cantidad;?></td>
                                <td>
                                	<?php if((float)$value->porcentaje < 50){ ?>
                                		<img title="En proceso" width="50px;" src="<?php echo base_url("assets/image/yellow.png");?>">
                                	<?php } else if((float)$value->porcentaje == 50){?>
                                		<img title="Regular" width="50px;" src="<?php echo base_url("assets/image/red.png");?>">
                                	<?php } else if((float)$value->porcentaje > 50){?>
                                		<img title="Bueno" width="50px;" src="<?php echo base_url("assets/image/green.png");?>">
                                	<?php }?>
                                </td>
                              </tr>
                            <?php }?>
                          </tbody>
                        </table>
                    </fieldset>
                    <br/><br/><br/>
                    <!--<object type="application/php" data="<?php echo base_url("/gestion/GestionControllers/lista/$id_org/1");?>" style="width:100%; height:400px;"></object>-->
                    <object type="application/php" data='<?php echo base_url("/gestion/GestionControllers/lista/$id_org/1");?>'  style="width:100%; height:600px;">
					  <embed src='<?php echo base_url("/gestion/GestionControllers/lista/$id_org/1");?>'  style="width:100%; height:600px;" frameborder="0" style="border:0;">
					</object>
                    <div class='alert alert-info' id='show-contenido'> 
						<img id='show-contenido' style='cursor:pointer;' title='Ejecución Financiera Original' width='50px;' src="<?php echo base_url("assets/image/money.png");?>">
                    </div>
                  </div>
              </div>
          </div>
          <!-- EJECUCIÓN FISICA DE LA GESTIÓN -->
          <!--<div class="panel-body">
            <div class="form-inline">
              <div class="form-group col-xs-12 jumbotron">
                <fieldset>
                  <legend>EJECUCIÓN FISICA</legend>
                    <table id="table-gestion" class="table-gestion table-bordered table-striped table-hover table-condensed dt-responsive table-responsive" style="width: 100%;">
                      <thead>
                        <tr>
                          <th>Actividad</th>
                          <th>Unidad de medida</th>
                          <th>Programado</th>
                          <th>Cumplido</th>
                          <th>%</th>
                          <th>Programada</th>
                          <th>Ejecutada</th>
                        </tr>
                      </thead>
                      <tbody>
                      </tbody>
                    </table>
                </fieldset>
              </div>
            </div>
          </div>-->
          <!-- EJECUCIÓN FINANCIERA DE LA GESTIÓN -->
          <!--<div class="panel-body">
                <div class="form-group col-xs-12 jumbotron">
                    <div class="object-accion"></div>
                </div>
          </div>-->
          </div>
        </div>
        <br/>
      </div>
  </div>

  
    
    <!-- Panel de ingreso -->

<div class="form-group col-xs-12 jumbotron" id='div-contenido' style='display:none;'>
	<fieldset>
	<legend>EJECUCIÓN FINANCIERA GENERAL</legend>
		<form id='frm-acc-ej-original' action='' method='POST'>
			<table class='table-bordered table-striped table-hover table-condensed dt-responsive table-responsive'>
				<thead>
				<tr>
					<th>Presupuesto Original</th>
					<th>Aumento</th>
					<th>Acordado</th>
					<th>Causado</th>
					<th id='content-porcentaje'>
						<?php if(isset($obj_acc->porcentaje) == 0.00){echo "0.00%";}else{echo $obj_acc->porcentaje;}?>
					</th>
				</tr>
				</thead>
				<tbody>
				<tr>
					<td>
						<input type="hidden" class='form-control' id='id' name='id' value='<?php if(isset($obj_acc->id) == 0){echo 0;}else{echo $obj_acc->id;}?>'>
						<input type="hidden" class='form-control' id='pk_accion' name='pk_accion' value='<?php echo $id_org;?>'>
						<input type="text" class='form-control number send-value-mount' id='presupuesto_original' name='presupuesto_original' value='<?php if(isset($obj_acc->presupuesto_original) == 0.00){echo 0;}else{echo $obj_acc->presupuesto_original;}?>'>
					</td>
					<td><input type="text" class='form-control number send-value-mount' id='aumentado' name='aumentado' value='<?php if(isset($obj_acc->aumentado) == 0.00){echo 0;}else{echo $obj_acc->aumentado;}?>'></td>
					<td><input type="text" class='form-control number send-value-mount' id='acordado'name='acordado' readonly='' value='<?php if(isset($obj_acc->acordado) == 0.00){echo 0;}else{echo $obj_acc->acordado;}?>'></td>
					<td><input type="text" class='form-control number send-value-mount' id='causado' name='causado' value='<?php if(isset($obj_acc->causado) == 0.00){echo 0;}else{echo $obj_acc->causado;}?>'></td>
					<td style='text-align:center;' id='content-img'>
						<?php if(isset($obj_acc->porcentaje_real) < 50) {?> <img title='En proceso' width='50px;' src="<?php echo base_url("assets/image/yellow.png");?>"> <?php }?>
					    <?php if(isset($obj_acc->porcentaje_real) == 50) {?> <img title='Regular' width='50px;' src="<?php echo base_url("assets/image/red.png");?>"> <?php }?>
					    <?php if(isset($obj_acc->porcentaje_real) > 50) {?> <img title='Bueno' width='50px;' src="<?php echo base_url("assets/image/green.png");?>"> <?php }?>
					</td>
				</tr>
				</tbody>
			</table>
		</form>
		<button style='margin-left: 85.5%;' class='btn btn-info send-value-mount'>
			<span class="glyphicon glyphicon-send"></span>
			Guardar
		</button>
	</fieldset>
</div>
<!-- Fin Panel de ingreso -->

<!-- Form de distribucion especifica de Proyecto-->
    <div id='table_es_ej' action="" method="POST" style='display: none;'>
     <div style="width:100%;text-transform:uppercase;box-shadow: 0 1px 5px rgba(0,0,0,.85);margin: auto;" class="panel panel-default">
       <div class="panel-heading" style='background: linear-gradient(#2F9292, #3B7272);color:#FFFFFF;'>
         <label>Ejecución Física</label>
         <br>
       </div>
       <div style="width: 100%;margin-right: auto;margin-left: auto;">
            <div class="panel-body">
                <div class="form-group col-xs-12">
                  <div class='alert alert-info actividad' style='color:black'>&nbsp;</div>
                  <span class="label label-success" style='padding:1%;'>
					Programado
					<span class="badge programado" style='background-color: #FFFFFF !important;color: #000000 !important;'>0</span>
				  </span>
				  <br/>
				  <br/>
				  <form method="POST" id="frmtrimestre">
					  <input type='hidden' id='id_acc' name='id_acc'/>
					  <input type="hidden" class='form-control' value='distribucion_actividad' name='table'>
					  <table style='width:70%;'>
						<tr>
							<td>
								<span class="label label-success" style='padding:5%;'>
									Trimestre I &nbsp;&nbsp;
								<span class="badge trimestre_I" style='background-color: #FFFFFF !important;color: #000000 !important;'>0</span>
								</span>
							</td>
							<td>
								<input type='number' class='form-control number I' style='margin-left: 6%; width: 88%;<?php if($get_config_sistem->i == 'f'){ ?> background-color: #F97E7E; <?php }?>' name='I' value="0" <?php if($get_config_sistem->i == 'f'){ ?> readonly="" <?php }?> />
							</td>
							<td>
								<span class="label label-success" style='padding:5%;margin-left: 20%;'>
									Porcentaje
								<span class="badge porcentaje_I" style='background-color: #FFFFFF !important;color: #000000 !important;'>0%</span>
								</span>
							</td>
						</tr>
						<tr>
							<td>
								<span class="label label-success" style='padding:5%;'>
									Trimestre II&nbsp;&nbsp;
								<span class="badge trimestre_II" style='background-color: #FFFFFF !important;color: #000000 !important;'>0</span>
								</span>
							</td>
							<td>
								<input type='number' class='form-control number II' style='margin-left: 6%; width: 88%;<?php if($get_config_sistem->ii == 'f'){ ?> background-color: #F97E7E; <?php }?>' name='II' value="0" <?php if($get_config_sistem->ii == 'f'){ ?> readonly="" <?php }?> />
							</td>
							<td>
								<span class="label label-success" style='padding:5%;margin-left: 20%;'>
									Porcentaje
								<span class="badge porcentaje_II" style='background-color: #FFFFFF !important;color: #000000 !important;'>0%</span>
								</span>
							</td>
						</tr>
						<tr>
							<td>
								<span class="label label-success" style='padding:5%;'>
									Trimestre III&nbsp;&nbsp;
								<span class="badge trimestre_III" style='background-color: #FFFFFF !important;color: #000000 !important;'>0</span>
								</span>
							</td>
							<td>
								<input type='number' class='form-control number III' style='margin-left: 6%; width: 88%;<?php if($get_config_sistem->iii == 'f'){ ?> background-color: #F97E7E; <?php }?>' name='III' value="0" <?php if($get_config_sistem->iii == 'f'){ ?> readonly="" <?php }?> />
							</td>
							<td>
								<span class="label label-success" style='padding:5%;margin-left: 20%;'>
									Porcentaje
								<span class="badge porcentaje_III" style='background-color: #FFFFFF !important;color: #000000 !important;'>0%</span>
								</span>
							</td>
						</tr>
						<tr>
							<td>
								<span class="label label-success" style='padding:5%;'>
									Trimestre IV&nbsp;&nbsp;
								<span class="badge trimestre_IV" style='background-color: #FFFFFF !important;color: #000000 !important;'>0</span>
								</span>
							</td>
							<td>
								<input type='number' class='form-control number IV' style='margin-left: 6%; width: 88%;<?php if($get_config_sistem->iv == 'f'){ ?> background-color: #F97E7E; <?php }?>' name='IV' value="0" <?php if($get_config_sistem->iv == 'f'){ ?> readonly="" <?php }?> />
							</td>
							<td>
								<span class="label label-success" style='padding:5%;margin-left: 20%;'>
									Porcentaje
								<span class="badge porcentaje_IV" style='background-color: #FFFFFF !important;color: #000000 !important;'>0%</span>
								</span>
							</td>
						</tr>
						<tr>
							<td>
								<button type="button" class="btn btn-info send-acc-ej">
									<span class="glyphicon glyphicon-send"></span>
									Guardar
								</button>
							</td>
						</tr>
					  </table>
                  </form>
                </div>
            </div>
      </div>
    </div>

  <script src="<?php echo base_url('assets/js/gestion.js'); ?>"></script>
  <script>
	  
	if($("#nom_acc").val()> 0){
		 $("#show-contenido").show(500);
	}else{
		$("#show-contenido").hide(500);
	}

	$(".generar_pdf").click(function (e) {
		e.preventDefault();  // Para evitar que se envíe por defecto
		var id = $("#nom_acc").val();
		var ano_fiscal = $("#ano_fiscal").val();
		var trimestres = $("#trimestres").val();
        URL = '<?php echo base_url(); ?>accion_pdf/' + id + '/'+ano_fiscal+"/"+trimestres;
        $.fancybox.open({padding: 0, href: URL, type: 'iframe', width: 2000, height: 1024, });
    });
	  
	$('img#show-contenido').on('click', function () {
		$.fancybox.open({
			'autoScale': false,
			'href': '#div-contenido',
			'type': 'inline',
			'hideOnContentClick': false,
			'transitionIn': 'fade',
			'transitionOut': 'fade',
			'openSpeed': 1000,
			'closeSpeed': 1000,
			'width': '960px',
			'height': '400px',
			'autoSize': false,
			helpers: {
				overlay: {
					closeClick: false
				} // prevents closing when clicking OUTSIDE fancybox
			}
		});
	});
	
	$('input.send-value-mount').on('keyup', function (e) {
		
		e.preventDefault();
		
		var acordado = $("#acordado").val();
        var causado  = $("#causado").val();
        
        var porcentaje = (causado/acordado)*100;
        
        if(parseFloat(porcentaje.toFixed(2)) < 50.00){
			var src_image = '<img title="En proceso" width="50px;" src="<?php echo base_url("assets/image/yellow.png");?>">';
		}else if(parseFloat(porcentaje.toFixed(2)) == 50.00){
			var src_image    = '<img title="Regular" width="50px;" src="<?php echo base_url("assets/image/red.png");?>">';
		}else if(parseFloat(porcentaje.toFixed(2)) > 50.00){
			var src_image  = '<img title="Bueno" width="50px;" src="<?php echo base_url("assets/image/green.png");?>">';
		}
		
		$("th#content-porcentaje").html(porcentaje.toFixed(2) + "%");
		$("td#content-img").html(src_image);
	
	});
	  
	// Procesar la informacion de la Ejecucion Fisica (Accion)
    $('button.send-value-mount').on('click', function (e) {
        e.preventDefault();
        
        $.post(base_url('/gestion/ejecucion_fin_original'), $("#frm-acc-ej-original").serialize(), function (response) {
            if (response.success == "ok") {
                new PNotify({
                    title: 'Gestión de Control',
                    text: "Se ha procesado la información...",
                    type: 'info',
                });
            }

        }).then(function () {
			$.fancybox.close();
            setTimeout(function () {
                window.location.reload(1);
            }, 3000);
        });
    });
    // Operacion
    $('#presupuesto_original, #aumentado').on('change', function (e) {
		var presupuesto_original = $("#presupuesto_original").val();
		var aumentado            = $("#aumentado").val();
		var sum_acordado         =  parseFloat(presupuesto_original) + parseFloat(aumentado);
		$("#acordado").val(sum_acordado);
		
	});
	
	
  </script>
