
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
          <a data-toggle="tab" href="#tabs_identificacion">Proyecto</a>
        </li>
      </ul>
      <br>
      <form id='frm-proy-send' action="" method='POST' enctype="multipart/form-data">
        <div class="tab-content">
          <div id="tabs_identificacion" class="tab-pane fade in active">
            <div class="panel-body">
              <div class="jumbotron">
    				  <div class="col-xs-2">
      					<label for='ano_fiscal'>Año fiscal</label>
      					<select id='ano_fiscal' style='width: 100%;'>
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
      					<label for='proyecto_id'>Proyectos</label>
      					<select class="form-control search" id='proyecto_id' name='proyecto_id' style='width: 100%;'>
      					  <option value='0'>Seleccione</option>
      					  <?php
      						foreach ($busqueda_proy as $value) {
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
                <select id="trimestres" class="form-control" style="width: 60px; margin-top: 11%;">
                  <option value="1">I</option>
                  <option value="2">II</option>
                  <option value="3">III</option>
                  <option value="4">IV</option>
                </select>
                <label for='pdf'></label>
                <button <?php if($this->session->userdata['logged_in']['is_superuser'] != 't'){?> disabled <?php } ?> title="Clic para ver informe..." style="margin-top: 11%;cursor: pointer;" class="btn btn-info generar_pdf">Imprimir</button>
              </div>
              </div>
              <br/>
                <!--<div class="form-group col-xs-10" style='width: 83%;'>
                  <input type="text" class="form-control " value='<?php if(isset($obj_org->nom_ins) == ""){echo "Seleccione la Acción a buscar...";}else{echo $obj_org->nom_ins;}?>' disabled='' id='nom_org' style='width: 100%;'/>
                </div>-->
                <div class="form-group col-xs-6">
                  <div class="col-xs-3 col-md-3">Población:</div>
                  <div class="col-xs-3 col-md-3" style="width: 100%;">
                    <input type="number" class="form-control number" id="beneficiario" name="beneficiario" value='<?php echo $obj_proy_other->beneficiario;?>'>
                  </div>
                </div>
                <div class="form-group col-xs-6">
                    <div class="col-xs-6 col-md-6">Avance físico:</div>
                    <div class="col-xs-6 col-md-6" style="width: 100%;">
                      <input type="text" id="avance_fisico" name="avance_fisico" value='<?php if(isset($obj_proy_other->avance_fisico) == ""){echo 0;}else{echo $obj_proy_other->avance_fisico;}?>' data-slider-ticks="[0, 10, 20, 30, 40, 50, 60, 70, 80, 90, 100]" data-slider-ticks-snap-bounds="30" data-slider-ticks-labels="['0','10', '20', '30', '40', '50','60','70','80','90','100']" style='width: 103%;'/>
                    </div>
                </div>
                <div class="form-group col-xs-12">
                    <div class="col-xs-10 col-md-10">Municipios beneficiados:</div>
                    <input type="hidden" class="form-control" id="municipio_ids" name="municipio_ids" value='<?php echo $obj_proy_other->municipio_ids;?>'>
                    <div class="col-xs-10 col-md-10" id="div_mun">
                      <input type="text" class="form-control text" id="mun">
                    </div>
                    <div class="col-xs-12 col-md-2">
                      <button type="button" class="btn btn-primary send-proy">Procesar</button>
                    </div>
                </div>
                <div class="col-xs-12"> <!-- required for floating -->
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs tabs-left"><!-- 'tabs-right' for right tabs -->
                    <li class="active"><a href="#content-proy" data-toggle="tab">Ejecución</a></li>
                      <li><a href="#content-pre" data-toggle="tab">Preliminares</a></li>
                    </ul>
                </div>
                <div class="col-xs-12">
                          <!-- Tab panes -->
                          <div class="panel-body">
                            <div class="tab-content">
                              <div class="tab-pane active" id="content-proy">
                                  <div class="form-inline">
                                    <div class="form-group col-xs-12 jumbotron">
										<div class='alert alert-info' style='color: #000000;'>Clic en la celda para abrir el formulario e ingresar los datos para la Ejecución Física.</div>
                                    <fieldset>
                                        <legend>EJECUCIÓN FISICA</legend>
                                        <table id="table-gestion-proy" class="table-gestion-proy table-bordered table-striped table-hover table-condensed dt-responsive table-responsive" style="width: 100%;">
                                            <thead>
                                            <tr>
                                                <th>Actividad</th>
                                                <th>Unidad de medida</th>
                                                <th>Programado</th>
                                                <th>Semaforo</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php foreach ($act_proy as $key => $value) { ?>
                                                <tr title='Clic para ingresar los datos de la ejecución Física' class='row-detail' style='cursor:pointer;' data-id='<?php echo $value->id;?>'  data-I='<?php echo $value->i;?>' data-II='<?php echo $value->ii;?>' data-III='<?php echo $value->iii;?>' data-IV='<?php echo $value->iv;?>' data-trimestre_i='<?php echo $value->trimestre_i;?>' data-trimestre_ii='<?php echo $value->trimestre_ii;?>' data-trimestre_iii='<?php echo $value->trimestre_iii;?>' data-trimestre_iv='<?php echo $value->trimestre_iv;?>'>
                                                <td style='width:60% !important;'><?php echo $value->acc_esp;?></td>
                                                <td style='width:30% !important;'><?php echo $value->unidad_medida;?></td>
                                                <td><?php echo $value->total;?></ttdh>
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
                                    <div class="col-xs-12 col-md-12">
										<!--<object type="application/php" data="<?php echo base_url("/gestion/GestionControllers/lista/$id_org/4");?>" style="width:100%; height:400px;"></object>-->
                    <object type="application/php" data='<?php echo base_url("/gestion/GestionControllers/lista/$id_org/2");?>'  style="width:100%; height:600px;">
                    <embed src='<?php echo base_url("/gestion/GestionControllers/lista/$id_org/2");?>'  style="width:100%; height:600px;" frameborder="0" style="border:0;">
                  </object>
										<div class='alert alert-info' id='show-contenido'> 
											<img id='show-contenido' style='cursor:pointer;' title='Ejecución Financiera Original' width='50px;' src="<?php echo base_url("assets/image/money.png");?>">
										</div>
                                    </div>
                                    </div>
                                    </div>
                              </div>
                              <div class="tab-pane" id="content-pre">
                                <div class="col-xs-6 col-md-12">
                                  <div class="col-xs-3 col-md-3">
                                    <input type="file" name="avatar_grafico_1" id='avatar_grafico_1'>
                                  </div>
                                  <div class="col-xs-3 col-md-3">
                                    <input type="file" name="avatar_grafico_2" id='avatar_grafico_2'>
                                  </div>
                                  <div class="col-xs-3 col-md-3">
                                    <input type="file" name="avatar_grafico_3" id='avatar_grafico_3'>
                                  </div>
                                  <div class="col-xs-3 col-md-3">
                                    <input type="file" name="avatar_grafico_4" id='avatar_grafico_4'>
                                  </div>
                                </div>
                                <div class="col-xs-6 col-md-12">
                                  <div class="col-xs-3 col-md-3">
                                    <input type="file" name="avatar_foto_1" id='avatar_foto_1'>
                                  </div>
                                  <div class="col-xs-3 col-md-3">
                                    <input type="file" name="avatar_foto_2" id='avatar_foto_2'>
                                  </div>
                                  <div class="col-xs-3 col-md-3">
                                    <input type="file" name="avatar_foto_3" id='avatar_foto_3'>
                                  </div>
                                  <div class="col-xs-3 col-md-3">
                                    <input type="file" name="avatar_foto_4" id='avatar_foto_4'>
                                  </div>
                                </div>
                                <div class="col-xs-6 col-md-4" style='margin-top: 2%;'>Resumen:</div>
                                <div class="col-xs-6 col-md-12" style='margin-top: 1%;'>
                                <input type="hidden" class='form-control' name='id' value='<?php echo $obj_proy_other->id;?>'>
                                  <textarea class="form-control" spellcheck="true" id="resumen" name="resumen" rows="7"><?php if(isset($obj_proy_other->resumen) == ""){echo "";}else{echo trim($obj_proy_other->resumen);}?></textarea>
                                </div>
                                <div class="col-xs-6 col-md-4" style='margin-top: 2%;'>Indicadores:</div>
                                <div class="col-xs-6 col-md-12" style='margin-top: 1%;'>
                                  <textarea class="form-control" spellcheck="true" id="indicador" name="indicador" rows="7"><?php if(isset($obj_proy_other->indicador) == ""){echo "";}else{echo trim($obj_proy_other->indicador);}?></textarea>
                                </div>
                              </div>
                            </div>
                          </div>
                    </div>
                  </div>
                </div>
              </div>
                
                
                <!--<div class="form-group col-xs-1">
                  <span class="input-group-addon open_report btn-info" style="cursor: pointer;" title="Imprimir">IMPRIMIR &nbsp;<span class="glyphicon glyphicon-print"></span></span>
                </div>
                <div class="form-group col-xs-1">
                  <span class="input-group-addon open_report_email btn-info" style="cursor: pointer;" title="Reportar">REPORTAR &nbsp;<span class="glyphicon glyphicon-circle-arrow-down"></span></span>
                </div>-->
                <br/><br/><br/><br/>
              </div>
            </div>
            </div>
          </div>
          <br/>
        </div>
      </form>
  </div>
  
  <!-- Panel de ingreso -->
	<div class="form-group col-xs-12 jumbotron" id='div-contenido' style='display:none;'>
		<fieldset>
		<legend>EJECUCIÓN FINANCIERA GENERAL</legend>
			<form id='frm-proy-ej-original' action='' method='POST'>
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
							<input type="hidden" class='form-control' id='pk_proyecto' name='pk_proyecto' value='<?php echo $id_org;?>'>
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
					<span class="badge programado" style='background-color: #FFFFFF !important;color: #000000 !important;'>4</span>
				  </span>
				  <br/>
				  <br/>
				  <form method="POST" id="frmtrimestre">
					  <input type='hidden' id='id_acc' name='id_acc'/>
					  <input type="hidden" class='form-control' value='distribucion_acc_especifica' name='table'>
					  <table style='width:70%;'>
						<tr>
							<td>
								<span class="label label-success" style='padding:5%;'>
									Trimestre I &nbsp;&nbsp;
								<span class="badge trimestre_I" style='background-color: #FFFFFF !important;color: #000000 !important;'>0</span>
								</span>
							</td>
							<td>
								<input type='number' class='form-control number I' style='margin-left: 6%; width: 88%;<?php if($get_config_sistem->i == 'f'){ ?> background-color: #F97E7E; <?php }?>' name='I' value="0"<?php if($get_config_sistem->i == 'f'){ ?> readonly="" <?php }?> />
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
  
  <!-- Table de lista de municipio-->
  <div id='table_mun' action="" method="POST" style='display: none;'>
     <div style="width:100%;text-transform:uppercase;box-shadow: 0 1px 5px rgba(0,0,0,.85);margin: auto;" class="panel panel-default">
       <div class="panel-heading" style='background: linear-gradient(#2F9292, #3B7272);color:#FFFFFF;'>
         <label>Municipios beneficiados</label>
         <br>
       </div>
       <div style="width: 95%;margin-right: auto;margin-left: auto;padding-top: 3%">
         <div class="row" style="text-align: center">
           <input type="submit" id="seleccionar_mun" style="font-weight: bold;font-size: 13px;margin-left: 88%;margin-top: -7.5%;" class="btn btn-default" value="Aplicar"/>
         </div>
         <table id="table-municipios" class="table-bordered table-striped table-hover table-condensed dt-responsive table-responsive" style="width: 100%;">
           <thead>
             <tr>
               <th>
                 Seleccione
               </th>
               <th>
                 Municipio
               </th>

             </tr>
           </thead>
           <tbody>
            <?php
            foreach ($municipios as $key => $municipio) {
              ?>
              <tr>
                <td>
                  <input type="checkbox" class="check" id="<?php echo $municipio->id?>" 
                   <?php
                   if(isset($obj_proy_other->municipio_ids)){
                      foreach (explode(",", $obj_proy_other->municipio_ids) as $municipio_ids) {
                        if((int)$municipio_ids == (int)$municipio->id){ echo "checked"; }else{ echo ""; }
                      }
                    }
                  ?>
                  >
                </td>
                <td><?php echo $municipio->municipio?></td>
              </tr>
              <?php
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
    
<!-- Fin Panel de ingreso -->
  <script src="<?php echo base_url('assets/js/gestion.js'); ?>"></script>
  <script type="text/javascript">
    $(document).ready(function () {

      $(".generar_pdf").click(function (e) {
          e.preventDefault();  // Para evitar que se envíe por defecto
          var id = $("#proyecto_id").val();
          var ano_fiscal = $("#ano_fiscal").val();
          var trimestres = $("#trimestres").val();
          URL = '<?php echo base_url(); ?>proyecto_pdf/' + id + '/'+ano_fiscal+"/"+trimestres;;
          $.fancybox.open({padding: 0, href: URL, type: 'iframe', width: 2000, height: 1024, });
      });

      var avance_fisico = $("#avance_fisico").val(); 

      if(avance_fisico == 0){
        avance_fisico = 1;
      }else if(avance_fisico > 0){
        avance_fisico = avance_fisico;
      }

      $("#avance_fisico").slider({
          ticks: [0, 10, 20, 30, 40, 50, 60, 70, 80, 90, 100],
          ticks_labels: ['0%','10%', '20%', '30%', '40%', '50%','60%','70%','80%','90%','100%'],
          ticks_snap_bounds: 30,
          value: [0, parseInt(avance_fisico)]
      });



      // File input Foto
      $("#avatar_foto_1").fileinput({
          browseClass: "btn btn-success btn-block",
          showCaption: false,
          showRemove: false,
          showUpload: false,
          browseLabel: "Imagen (1)",
          maxFileSize: 1024,
          allowedFileExtensions: ["jpg", "png", 'jpeg'],
          elErrorContainer: "#errorBlock",
          msgSizeTooLarge: 'Archivo muy pesado "{name}". (<b>{size} KB</b>) excede el tamaño máximo que es de <b>{maxSize} KB',
          msgInvalidFileExtension: 'Extensiones invalidad "{name}". Solo admite archivos"{extensions}".',
          initialPreview: [
              "<img src=<?php echo base_url("assets/$explode_avatar_foto_1"); ?> style='width:212px;height:145px;' class='file-preview-image' alt='The Moon' title='The Moon'>",
          ],
      });

      $("#avatar_foto_2").fileinput({
          browseClass: "btn btn-success btn-block",
          showCaption: false,
          showRemove: false,
          showUpload: false,
          browseLabel: "Imagen (2)",
          maxFileSize: 1024,
          allowedFileExtensions: ["jpg", "png", 'jpeg'],
          elErrorContainer: "#errorBlock",
          msgSizeTooLarge: 'Archivo muy pesado "{name}". (<b>{size} KB</b>) excede el tamaño máximo que es de <b>{maxSize} KB',
          msgInvalidFileExtension: 'Extensiones invalidad "{name}". Solo admite archivos"{extensions}".',
          initialPreview: [
              "<img src=<?php echo base_url("assets/$explode_avatar_foto_2"); ?> style='width:212px;height:145px;' class='file-preview-image' alt='The Moon' title='The Moon'>",
          ],
      });
      $("#avatar_foto_3").fileinput({
          browseClass: "btn btn-success btn-block",
          showCaption: false,
          showRemove: false,
          showUpload: false,
          browseLabel: "Imagen (3)",
          maxFileSize: 1024,
          allowedFileExtensions: ["jpg", "png", 'jpeg'],
          elErrorContainer: "#errorBlock",
          msgSizeTooLarge: 'Archivo muy pesado "{name}". (<b>{size} KB</b>) excede el tamaño máximo que es de <b>{usermaxSize} KB',
          msgInvalidFileExtension: 'Extensiones invalidad "{name}". Solo admite archivos"{extensions}".',
          initialPreview: [
              "<img src=<?php echo base_url("assets/$explode_avatar_foto_3"); ?> style='width:212px;height:145px;' class='file-preview-image' alt='The Moon' title='The Moon'>",
          ],
      });

      $("#avatar_foto_4").fileinput({
          browseClass: "btn btn-success btn-block",
          showCaption: false,
          showRemove: false,
          showUpload: false,
          browseLabel: "Imagen (4)",
          maxFileSize: 1024,
          allowedFileExtensions: ["jpg", "png", 'jpeg'],
          elErrorContainer: "#errorBlock",
          msgSizeTooLarge: 'Archivo muy pesado "{name}". (<b>{size} KB</b>) excede el tamaño máximo que es de <b>{maxSize} KB',
          msgInvalidFileExtension: 'Extensiones invalidad "{name}". Solo admite archivos"{extensions}".',
          initialPreview: [
              "<img src=<?php echo base_url("assets/$explode_avatar_foto_4"); ?> style='width:212px;height:145px;' class='file-preview-image' alt='The Moon' title='The Moon'>",
          ],
      });

      

      // File input Doc Cuadro Grafico
      $("#avatar_grafico_1").fileinput({
          browseClass: "btn btn-success btn-block",
          showCaption: false,
          showRemove: false,
          showUpload: false,
          browseLabel: "Cuadro gráfico (1)",
          maxFileSize: 1024,
          allowedFileExtensions: ["pdf"],
          elErrorContainer: "#errorBlock",
          msgSizeTooLarge: 'Archivo muy pesado "{name}". (<b>{size} KB</b>) excede el tamaño máximo que es de <b>{maxSize} KB',
          msgInvalidFileExtension: 'Extensiones invalidad "{name}". Solo admite archivos"{extensions}".',
          initialPreview: [
              "<object type='application/pdf' data='<?php echo base_url("assets/$explode_avatar_grafico_1"); ?>' style='width:212px;height:145px;' class='file-preview-image'>",
          ],
      });

      $("#avatar_grafico_2").fileinput({
          browseClass: "btn btn-success btn-block",
          showCaption: false,
          showRemove: false,
          showUpload: false,
          browseLabel: "Cuadro gráfico (2)",
          maxFileSize: 1024,
          allowedFileExtensions: ["pdf"],
          elErrorContainer: "#errorBlock",
          msgSizeTooLarge: 'Archivo muy pesado "{name}". (<b>{size} KB</b>) excede el tamaño máximo que es de <b>{maxSize} KB',
          msgInvalidFileExtension: 'Extensiones invalidad "{name}". Solo admite archivos"{extensions}".',
          initialPreview: [
              "<object type='application/pdf' data='<?php echo base_url("assets/$explode_avatar_grafico_2"); ?>' style='width:212px;height:145px;' class='file-preview-image'>",
          ],
      });
      $("#avatar_grafico_3").fileinput({
          browseClass: "btn btn-success btn-block",
          showCaption: false,
          showRemove: false,
          showUpload: false,
          browseLabel: "Cuadro gráfico (3)",
          maxFileSize: 1024,
          allowedFileExtensions: ["pdf"],
          elErrorContainer: "#errorBlock",
          msgSizeTooLarge: 'Archivo muy pesado "{name}". (<b>{size} KB</b>) excede el tamaño máximo que es de <b>{maxSize} KB',
          msgInvalidFileExtension: 'Extensiones invalidad "{name}". Solo admite archivos"{extensions}".',
          initialPreview: [
              "<object type='application/pdf' data='<?php echo base_url("assets/$explode_avatar_grafico_3"); ?>' style='width:212px;height:145px;' class='file-preview-image'>",
          ],
      });

      $("#avatar_grafico_4").fileinput({
          browseClass: "btn btn-success btn-block",
          showCaption: false,
          showRemove: false,
          showUpload: false,
          browseLabel: "Cuadro gráfico (4)",
          maxFileSize: 1024,
          allowedFileExtensions: ["pdf"],
          elErrorContainer: "#errorBlock",
          msgSizeTooLarge: 'Archivo muy pesado "{name}". (<b>{size} KB</b>) excede el tamaño máximo que es de <b>{maxSize} KB',
          msgInvalidFileExtension: 'Extensiones invalidad "{name}". Solo admite archivos"{extensions}".',
          initialPreview: [
              "<object type='application/pdf' data='<?php echo base_url("assets/$explode_avatar_grafico_4"); ?>' style='width:212px;height:145px;' class='file-preview-image'>",
          ],
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
	
	if($("#proyecto_id").val()> 0){
		 $("#show-contenido").show(500);
	}else{
		$("#show-contenido").hide(500);
	}
	
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
        
        $.post(base_url('/gestion/ejecucion_fin_original'), $("#frm-proy-ej-original").serialize(), function (response) {
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

  
    });

  </script>
