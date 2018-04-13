<?php
if (isset($this->session->userdata['logged_in'])) {
  $username = ($this->session->userdata['logged_in']['username']);
  $id = ($this->session->userdata['logged_in']['id']);
} else {
  $header = base_url();
  header("location: " . $header);
}
?>
<br/>
<br/>
<br/>
<br/>

<form class="frmproy" method="POST">
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
        <li id="#tabs_2" data-toggle="popover" data-trigger="focus" title="Política y Acción" data-placement="top">
          <a data-toggle="tab" href="#tabs_politica_accion">Proyecto</a>
        </li>
      </ul>
      <br>
      <div class="tab-content">
        <div id="tabs_identificacion" class="tab-pane fade in active">
          <div class="panel-body">
            <div class="form-inline jumbotron">
              <div class="form-group col-xs-2">
                <select class="form-control search" id='nom_acc' name='nom_acc' style='width: 100%;'>
                  <option value='0'>Seleccione</option>
                  <?php
                  foreach ($busqueda_acc as $value) {
                    ?>
                    <option value="<?php echo $value->id; ?>"><?php echo trim($value->codigo); ?></option>
                    <?php
                  }
                  ?>
                </select>
              </div>
              <div class="form-group col-xs-6">
                <input type="text" class="form-control " id='acc_c' name='acc_c' disabled="disabled" style='width: 100%;'/>
              </div>
              <div class="form-group col-xs-2">
                <span class="input-group-addon open_report btn-info" style="cursor: pointer;" title="Imprimir">IMPRIMIR &nbsp;<span class="glyphicon glyphicon-print"></span></span>
              </div>
              <div class="form-group col-xs-2">
                <span class="input-group-addon open_report_email btn-info" style="cursor: pointer;" title="Reportar">REPORTAR &nbsp;<span class="glyphicon glyphicon-circle-arrow-down"></span></span>
              </div>
              <br/>
            </div>
          </div>
          <!-- EJECUCIÓN FISICA DE LA GESTIÓN -->
          <div class="panel-body">
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
          </div>
          <!-- EJECUCIÓN FINANCIERA DE LA GESTIÓN -->
          <div class="panel-body">
                <div class="form-group col-xs-12 jumbotron">
                    <div class="object-accion"></div>
                </div>
          </div>
          </div>
            <div id="tabs_politica_accion" class="tab-pane fade">
              <div class="panel-body">
              <div class="form-group col-xs-12">
              <input type="hidden" id="id" name="id" />
                <!--<div class="col-xs-6 col-md-6">Proyectos</div>-->
                  <div class="col-xs-12 col-sm-6 col-md-12" style="padding: 1%;">
                    <button type="button" class="btn btn-primary send-proy">Procesar</button>
                  </div>
                  <div class="col-xs-12 col-sm-6 col-md-12">
                    <select id='proyecto_id' name='proyecto_id' style='width: 100%;' class="search_proy">
                      <option value="0">Seleccione</option>
                      <?php
                      foreach ($busqueda_proy as $value) {
                        ?>
                        <option value="<?php echo $value->id; ?>"><?php echo "Código (" . trim($value->codigo) . ")"; ?></option>
                        <?php
                      }
                      ?>
                    </select>
                  </div>
                  </div>
                <div class="form-group col-xs-6">
                  <div class="col-xs-6 col-md-6">Población beneficiada:</div>
                  <div class="col-xs-6 col-md-6" style="width: 100%;">
                    <input type="number" class="form-control number" id="beneficiario" name="beneficiario">
                  </div>
                </div>
                <div class="form-group col-xs-6">
                  <div class="col-xs-6 col-md-6">Avance físico del proyecto:</div>
                  <div class="col-xs-6 col-md-6" style="width: 100%;">
                    <input type="text" class="range" id="porcentaje" name="avance_fisico" id="avance_fisico" />
                  </div>
                </div>
                <div class="form-group col-xs-12">
                  <div class="col-xs-6 col-md-12">Municipios beneficiados:</div>
                  <div class="col-xs-6 col-md-12" id="div_mun">
                    <input type="text" class="form-control text" id="mun">
                  </div>
                  <br/>
                  <br/>
                  <br/>
                  <br/>
                  <div class="col-xs-12"> <!-- required for floating -->
                      <!-- Nav tabs -->
                      <ul class="nav nav-tabs tabs-left"><!-- 'tabs-right' for right tabs -->
                        <li class="active"><a href="#content-proy" data-toggle="tab">Proyecto</a></li>
                        <li><a href="#content-pre" data-toggle="tab">Preliminares</a></li>
                      </ul>
                  </div>
                  <div class="col-xs-12">
                        <!-- Tab panes -->
                        <div class="panel-body">
                          <div class="tab-content">
                            <div class="tab-pane active" id="content-proy">
                                <!-- EJECUCIÓN FISICA DE LA GESTIÓN -->
                                <div class="form-inline">
                                  <div class="form-group col-xs-12 jumbotron">
                                    <fieldset>
                                      <legend>EJECUCIÓN FISICA</legend>
                                        <table id="table-proy" class="table-gestion table-bordered table-striped table-hover table-condensed dt-responsive table-responsive" style="width: 100%;">
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
                                <!-- EJECUCIÓN FINANCIERA DE LA GESTIÓN -->
                                <div class="form-group col-xs-12 jumbotron">
                                    <div class="object-proy"></div>
                                </div>
                            </div>
                            <div class="tab-pane" id="content-pre">
                              
                              <div class="col-xs-6 col-md-4">Resumen:</div>
                              <div class="col-xs-6 col-md-12">
                                <textarea class="form-control" id="resumen" name="resumen" rows="7"></textarea>
                              </div>
                              <div class="col-xs-6 col-md-4">Cuadros Gráficos:</div>
                              <div class="col-xs-6 col-md-12">
                                <textarea class="form-control" id="avatar_grafico" name="avatar_grafico" rows="7"></textarea>
                              </div>
                              <div class="col-xs-6 col-md-4">Fotografias:</div>
                              <div class="col-xs-6 col-md-12">
                                <textarea class="form-control" id="avatar_foto" name="avatar_foto" rows="7"></textarea>
                              </div>
                              <div class="col-xs-6 col-md-4">Indicadores:</div>
                              <div class="col-xs-6 col-md-12">
                                <textarea class="form-control" id="indicador" name="indicador" rows="7"></textarea>
                              </div>

                            </div>
                          </div>
                        </div>
                  </div>
                </div>
              </div>
            </div>
        </div>
        <br/>
      </div>


    <div id='table_mun' action="" method="POST" style='display: none;'>
     <div style="width:100%;text-transform:uppercase;box-shadow: 0 1px 5px rgba(0,0,0,.85);margin: auto;" class="panel panel-default">
       <div class="panel-heading" style='background: linear-gradient(#2F9292, #3B7272);color:#FFFFFF;'>
         <label>Municipios beneficiados</label>
         <br>
       </div>
       <div style="width: 95%;margin-right: auto;margin-left: auto;padding-top: 3%">
         <div class="row" style="text-align: center">
           <input type="submit" id="seleccionar_mun" style="font-weight: bold;font-size: 13px" class="btn btn-success" value="Aplicar"/>
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
            foreach ($municipios as $municipio) {
              ?>
              <tr>
                <td><input type="checkbox" class="check" name="" id="<?php echo $municipio->id?>"></td>
                <td><?php echo $municipio->municipio?></td>
              </tr>

              <?php
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  </form>
  <script src="<?php echo base_url('assets/js/gestion.js'); ?>"></script>
