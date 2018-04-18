
    <script>
        $(document).ready(function () {
    		
    		$.sonido("mensaje"); // Seteamos los contenedores para los mensajes a emitir

            // Busqueda de registro de Accion
            $("#ano_fiscal, #accion").change(function () {
                var accion     = $("#accion").val();
                var ano_fiscal = $("#ano_fiscal").val();
                var url = base_url("/configuracion?ano_fiscal=" + ano_fiscal+"&accion="+accion);
                window.location = url;
            });
    		         
             $("button.send-data-cierre").on('click', function (e) {
                var title = $("#accion").val();

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
                                $.post('<?php echo base_url("configuracion/CConfiguracion/save"); ?>', $('#frmaccproy').serialize(), function (res) {
                                     if(res.success == "ok" ){
                                         
                                         ion.sound.play("mensaje"); // Accion para notificar un mensaje de voz para el envio de mensajes
                                         
                                         bootbox.alert("configuracion guardado con exito", function () {
                                            }).on('hidden.bs.modal', function (event) {
                                                url = $(location).attr('href');
                                                window.location = url;
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
    <br/>
    <br/>
    <br/>
    <br/>
    <div class="row-fluid" >
        <div class="form-group col-xs-6">
            <div class="panel panel-primary">
                <div class="panel-heading">Cierre Año Fiscal</div>
                <div class="panel-body">
                    <button type="button" class="btn btn-danger cierre_ano">Cerrar Año Fiscal <?= date('Y', now()) ?>
                        
                    </button>
                </div>
            </div>
        </div>
        <div class="form-group col-xs-6">
            <div class="panel panel-primary">
                <div class="panel-heading">Segmento trimestral</div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-6 col-md-6" style="width: 100%;">
                            <form class="navbar-form navbar-left" role="search">
                                <div class="form-group">
                                  <select class="selectpicker" multiple data-live-search="true" data-live-search-placeholder="Search" data-actions-box="true">
                                    <optgroup label="Trimestres">
                                      <option value="i">I</option>
                                      <option value="ii">II</option>
                                      <option value="iii">III</option>
                                      <option value="iv">IV</option>
                                    </optgroup>
                                  </select>
                                </div>

                                <div class="input-group">
                                  <div class="input-group-btn">
                                    <button class="btn btn-default" type="button"><i class="glyphicon glyphicon-search"></i></button>
                                  </div>
                                </div>
                              </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group col-xs-12">
            <div class="panel panel-primary">
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


