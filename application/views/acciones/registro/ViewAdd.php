<?php
if (isset($this->session->userdata['logged_in'])) {
    $username = ($this->session->userdata['logged_in']['username']);
    $id       = ($this->session->userdata['logged_in']['id']);
} else {
    $header = base_url();
    header("location: " . $header);
}
?>
<script>
    $(document).ready(function () {

        $("select").select2();
        var fecha = new Date();
        var ano = fecha.getFullYear();

        var $organo = <?=$this->session->userdata['logged_in']['pk'];?>;
        //alert($organo);

//        $("#ano_fiscal").select2('val', ano);

        $('#plan_patria').alphanumeric({allow: " -.,"});
        $('#codigo').alphanumeric({allow: "-."});
        $('#m_autoridad,#cargo').alpha({allow: " "});
        $('#cedula').numeric({allow: ""});
        $('#tlf').numeric({allow: "/"});
        $('#correo').alphanumeric({allow: "@."});
        $("#registrar").click(function (e) {
            var bandera = $(this).data('bandera');

            e.preventDefault();  // Para evitar que se envíe por defecto
            var regex = /[\w-\.]{2,}([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;

            if ($('#reg_registro').val().trim() == '') {

                bootbox.alert("Seleccione el registrado", function () {
                }).on('hidden.bs.modal', function (event) {
                    $("#reg_registro").parent('div').addClass('has-error');
                    $("#reg_registro").select2('open');
                });

            } else if ($('#ano_fiscal').val().trim() == '') {
                bootbox.alert("Seleccione el Año Fiscal", function () {
                    $('.nav-tabs a[href=#tabs_identificacion]').tab('show');
                }).on('hidden.bs.modal', function (event) {
                    $("#ano_fiscal").parent('div').addClass('has-error');
                    $("#ano_fiscal").select2('open');
                });
            } else if ($('#ente').val().trim() == '') {
                bootbox.alert("Seleccione el Organismo/Ente/Empresa", function () {
                    $('.nav-tabs a[href=#tabs_identificacion]').tab('show');
                }).on('hidden.bs.modal', function (event) {
                    $("#ente").parent('div').addClass('has-error');
                    $("#ente").select2('open');
                });
            } else if ($('#m_autoridad').val().trim() == '') {
                bootbox.alert("Ingrese el Nombre de la Maxima Autoridad de la Institución", function () {
                    $('.nav-tabs a[href=#tabs_identificacion]').tab('show');
                }).on('hidden.bs.modal', function (event) {
                    $("#m_autoridad").parent('div').addClass('has-error');
                    $("#m_autoridad").focus();
                });
            } else if ($('#cedula').val().trim() == '') {
                bootbox.alert("Ingrese la Cédula", function () {
                    $('.nav-tabs a[href=#tabs_identificacion]').tab('show');
                }).on('hidden.bs.modal', function (event) {
                    $("#cedula").parent('div').addClass('has-error');
                    $("#cedula").focus();
                });
            } else if ($('#cargo_b').val().trim() == '') {
                bootbox.alert("Ingrese el Cargo", function () {
                    $('.nav-tabs a[href=#tabs_identificacion]').tab('show');
                }).on('hidden.bs.modal', function (event) {
                    $("#cargo_b").parent('div').addClass('has-error');
                    $("#cargo_b").focus();
                });
            } else if ($('#tlf_b').val().trim() == '') {
                bootbox.alert("Ingrese el Teléfono", function () {
                    $('.nav-tabs a[href=#tabs_identificacion]').tab('show');
                }).on('hidden.bs.modal', function (event) {
                    $("#tlf_b").parent('div').addClass('has-error');
                    $("#tlf_b").focus();
                });
            } else if (regex.test($('#correo_b').val().trim()) == "") {

                //Se utiliza la funcion test() nativa de JavaScript
                if (regex.test($('#correo_b').val().trim())) {
                    
                    return false;
                
                } else {
        
                    bootbox.alert("Dirección de correo no es valida", function () {
                        $('.nav-tabs a[href=#tabs_identificacion]').tab('show');
                    }).on('hidden.bs.modal', function (event) {
                        $('.nav-tabs a[href=#tabs_B]').tab('show');
                        $('#correo_b').parent('div').addClass('has-error');
                        $("#correo_b").focus()
                    });
                }

            } else if ($('#politica_presupuestaria').val().trim() == '') {
                bootbox.alert("Por favor describa de forma breve la política presupuestaria con la que trabajará", function () {
                    $('.nav-tabs a[href=#tabs_politica_accion]').tab('show');
                }).on('hidden.bs.modal', function (event) {
                    $("#politica_presupuestaria").parent('div').addClass('has-error');
                    $("#politica_presupuestaria").focus();
                });
            } else if ($('#acc_centralizada').val().trim() == '') {
                bootbox.alert("Seleccione la Acción Centralizada", function () {
                    $('.nav-tabs a[href=#tabs_politica_accion]').tab('show');
                }).on('hidden.bs.modal', function (event) {
                    $("#acc_centralizada").parent('div').addClass('has-error');
                    $("#acc_centralizada").select2('open');
                });
            } else {
                $("#codigo").val().trim();
                /*var fecha = new Date();
                var fecha_actual = fecha.getFullYear() + "-" + fecha.getMonth() + 1 + "-" + fecha.getDate()
                $("#fecha_elaboracion").val();*/
                
                $.post('<?php echo base_url(); ?>acciones/registro/ControllersRegistro/guardar', $('#form_reg_acc').serialize(), function (response) {

                    if (response == '1') {

                        bootbox.alert("Disculpe, ya existe un código o Plan de la Patria registrado, verifique los datos ", function () {
                        }).on('hidden.bs.modal', function (event) {
                            $("#plan_patria").parent('div').addClass('has-error');
                            $("#plan_patria").focus();
                        });

                    } else {
                        /*$.post('<?php echo base_url(); ?>acciones/registro/ControllersRegistro/ultimo_id', function (response) {
                                if (response !="") {
                                    $("#codigo").val(response);
                                }else{
                                    $("#codigo").val("00001");
                                }
                            },'json');*/
                        bootbox.alert("Se registro con exito", function () {
                        }).on('hidden.bs.modal', function (event) {
                            if(bandera == 1){
                                url_bandera = "?ingreso=1";
                            }else{
                                url_bandera = "";
                            }
                            url = '<?php echo base_url(); ?>acciones/registro/ControllersRegistro'+url_bandera;
                            //var url = window.location.href;
                            window.location = url;
                        });
                    }
                });
            }
        });
        
        
        
        /*$("#reg_registro").change(function () {*/
            $("#reg_registro").select2('val',parseInt($organo));
        	$("#ente").select2('val',parseInt($("#reg_registro").val()));
        	//var ente = $(this).val();
            $.post('<?php echo base_url(); ?>acciones/registro/ControllersRegistro/search_table/id/organos_entes/' + $organo + '', function (response) {
                $("#cargo_b").val(response[0]['cargo']);
                $("#m_autoridad").val(response[0]['nom_resp']);
                $("#tlf_b").val(response[0]['tlf']);
                $("#cedula").val(response[0]['cedula']);
                $("#correo_b").val(response[0]['correo']);
            }, 'json');
        /*});*/
        
        
        $("#ente").change(function () {
            var ente = $(this).val();
            $.post('<?php echo base_url(); ?>acciones/registro/ControllersRegistro/search_table/id/organos_entes/' + ente + '', function (response) {
               
                $("#cargo_b").val(response[0]['cargo']);
                $("#m_autoridad").val(response[0]['nom_resp']);
                $("#tlf_b").val(response[0]['tlf']);
                $("#cedula").val(response[0]['cedula']);
                $("#correo_b").val(response[0]['correo']);
                 console.log(response[0]['correo']);
            }, 'json');
        });

        // Validacion ajax para reflejar los datos en formato json para las Acciones Especifica
        $("#acc_centralizada").change(function (e) {

            var acc_centralizada = $(this).val();

            $('#nom_especifica').val("");
            $.post('<?php echo base_url(); ?>acciones/registro/ControllersRegistro/ajax_search/' + acc_centralizada + '', function (response) {
                var option = "";
                $.each(response, function (i) {
                    option += "->"+response[i]['accion_especifica'] + "\n";
                });
                $('#nom_especifica').val(option);
            }, 'json');
        });

        /*var fecha = new Date();
        var fecha_actual = fecha.getDate() + "/" + fecha.getMonth() + 1 + "/" + fecha.getFullYear()
        $("#fecha_elaboracion").val(fecha_actual);*/
       /* setInterval(function(){
            //alert("EPQ")
            $.post('<?php echo base_url(); ?>acciones/registro/ControllersRegistro/ultimo_id', function (response) {
                
                if (response !="") {
                    $("#codigo").val(response);
                }else{
                    $("#codigo").val("00001");
                }
            },'json');
        }, 2000);*/
    });

</script>
<br/>
<br/>
<br/>
<br/>

<form id='form_reg_acc' action="" method="POST">
    <div style="width: 95%;text-transform:uppercase;box-shadow: 0 1px 5px rgba(0,0,0,.85);margin: auto;" class="panel panel-default">
        <div class="panel-heading" style='background: linear-gradient(#2F9292, #3B7272);color:#FFFFFF;'>
            <label style="float: left" class="panel-title " ><!--<a href="<?php echo base_url(); ?>acciones/registro/ControllersRegistro" >Configuraciones</a>-->
                Registrar Acción</label>
            <br>
        </div>
        <fieldset><legend class="titulo text-center">Datos de la Acción</legend></fieldset>
        <br/>
        <div class="panel-body">
            <div class="col-xs-2" hidden='hidden'>ID</div>
            <div class="col-xs-4" hidden='hidden'>
                <input readonly="" value=''  id="codigo" style="width: 25%;text-transform:uppercase;" onblur="javascript:this.value = this.value.toUpperCase();" placeholder="" name="codigo" type="text" class="form-control" />
            </div>
            <div class="col-xs-2" style="" hidden='hidden'>Elaboración</div>
            <div class="col-xs-2" hidden='hidden'>
                <input readonly="" value="<?=date('d-m-Y',now())?>" style="width: 80%;text-transform:uppercase;" onblur="javascript:this.value = this.value.toUpperCase();" placeholder="" type="text" class="form-control" />
                <input readonly="" value="<?=date('Y-m-d',now())?>" style="width: 80%;text-transform:uppercase;" onblur="javascript:this.value = this.value.toUpperCase();" placeholder="" name="fecha_elaboracion" type="hidden" class="form-control" />
            </div>
        </div>
        <div class="panel-body">
            <div class="col-xs-2">Registrado por</div>
            <div class="col-xs-10">
                <select id='reg_registro' name='reg_registro' style='width: 65%;'>
                    <option value=''>Seleccione</option>
                    <?php
                    foreach ($organos as $value) {
                        ?>
                        <option value="<?php echo $value->id; ?>">

                            <?php
                            if ($value->tipo_ins == 1) {
                                $ins = "Órgano";
                            } elseif ($value->tipo_ins == 2) {
                                $ins = "Ente";
                            } elseif ($value->tipo_ins == 3) {
                                $ins = "Empresa";
                            } elseif ($value->tipo_ins == 4) {
                                $ins = "Unidad de Apoyo";
                            }

                            echo $ins . " - " . $value->nom_ins;
                            ?>
                        </option>
                        <?php
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="panel-body">
            <div class="col-xs-2">Estátus</div>
            <div class="col-xs-10">
                <span class="label label-success" style='width: 65%;color: #FFFFFF;'>
                    <?php
                        $ingresos_propios = $this->input->get('ingreso');
                        if ($ingresos_propios == 1) { $bandera = "?ingreso=1"; $estatus = 5; echo "Ingresos Propios"; }else{ $estatus = 1; echo "Revisando"; }?>
                </span>
                <input type="hidden" id="estatus" name="estatus" value="<?php echo $estatus;?>"/>
            </div>
        </div>
        <!-- Apertura de Tabs (Secciones) -->
        <ul class="nav nav-tabs">
            <li class="active" data-toggle="popover" data-trigger="focus" title="Identificación" data-placement="top">
                <a data-toggle="tab" href="#tabs_identificacion">Identificación</a>
            </li>
            <li id="#tabs_2" data-toggle="popover" data-trigger="focus" title="Política y Acción" data-placement="top">
                <a data-toggle="tab" href="#tabs_politica_accion">Política y Acción</a>
            </li>
        </ul>
        <br>
        <div class="tab-content">
            <div id="tabs_identificacion" class="tab-pane fade in active">
                <div class="panel-body">
                    <fieldset>1. Identificación del proponente</fieldset>
                    <br/>
                    <div class="col-xs-2">Año Fiscal</div>
                    <div class="col-xs-10">
                        <select id='ano_fiscal' name='ano_fiscal' style='width: 10%;'>
                            <option value=''>Año</option>
                            <?php
                            foreach (range(2013, 2045) as $número) {
                                ?>
                                <option value="<?php echo $número; ?>"><?php echo $número; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="col-xs-2" >1.1 Organismo/Ente/Empresa</div>
                    <div class="col-xs-4">
                        <select id='ente' name='ente' style='width: 100%;'>
                            <option value=''>Seleccione</option>
                            <?php
                            foreach ($organos as $value) {
                                ?>
                                <option value="<?php echo $value->id; ?>">

                                    <?php
                                    if ($value->tipo_ins == 1) {
                                        $ins = "Órgano";
                                    } elseif ($value->tipo_ins == 2) {
                                        $ins = "Ente";
                                    } elseif ($value->tipo_ins == 3) {
                                        $ins = "Empresa";
                                    } elseif ($value->tipo_ins == 4) {
                                        $ins = "Unidad de Apoyo";
                                    }

                                    echo $ins . " - " . $value->nom_ins;
                                    ?>

                                </option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-xs-1">1.4 Cargo</div>
                    <div class="col-xs-4">
                        <input maxlength="20" id="cargo_b" readonly style="width: 65%;text-transform:uppercase;" onblur="javascript:this.value = this.value.toUpperCase();" placeholder="Ingrese el cargo" name="cargo" type="text" class="form-control" />
                    </div>
                </div>
                <div class="panel-body">
                    <div class="col-xs-2" >1.2 Nombre de la Maxima Autoridad de la Institución</div>
                    <div class="col-xs-4">
                        <input maxlength="30" id="m_autoridad" readonly='' style="width: 100%;text-transform:uppercase;" onblur="javascript:this.value = this.value.toUpperCase();" placeholder="Ingrese la Maxima Autoridad" name="m_autoridad" type="text" class="form-control" />
                    </div>
                    <div class="col-xs-1">1.5 Teléfono</div>
                    <div class="col-xs-4">
                        <input maxlength="15" id="tlf_b" name="tlf" readonly style="width: 65%;text-transform:uppercase;" onblur="javascript:this.value = this.value.toUpperCase();" placeholder="Ingrese el teléfono" name="tlf" type="text" class="form-control" />
                    </div>
                </div>
                <div class="panel-body">
                    <div class="col-xs-2" >1.3 Cédula</div>
                    <div class="col-xs-4">
                        <input maxlength="9" readonly id="cedula" style="width: 25%;text-transform:uppercase;" onblur="javascript:this.value = this.value.toUpperCase();" placeholder="Cédula" name="cedula" type="text" class="form-control" />
                    </div>
                    <div class="col-xs-1">1.6 Correo</div>
                    <div class="col-xs-4">
                        <input maxlength="30" id="correo_b" readonly style="width: 65%;" placeholder="Ingrese el correo" name="correo" type="text" class="form-control" />
                    </div>
                </div>
            </div>
            <div id="tabs_politica_accion" class="tab-pane fade">
                <div class="panel-body">
                    <div class="col-xs-3">3.1 Nombre de la Acción Centralizada</div>
                    <div class="col-xs-7">
                        <select id='acc_centralizada' name='acc_centralizada' style='width: 80%;'>
                            <option value=''>Seleccione</option>
                            <?php
                            foreach ($acc_centralizada as $value) {
                                ?>
                                <option value="<?php echo $value->id; ?>"><?php echo $value->accion_centralizada; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="panel-body">                    
                    <div class="col-xs-6">
                        <fieldset style="margin-left: 1%">2. Política Presupuestaria</fieldset>
                        <textarea maxlength='600' id="politica_presupuestaria" name="politica_presupuestaria" cols="2" rows="10" style="width: 60%;text-transform:uppercase" onblur="javascript:this.value = this.value.toUpperCase();" placeholder="Por favor describa de forma breve la política presupuestaria con la que trabajará" class="form-control"></textarea>
                    </div>
                    <div class="col-xs-6" style="margin-left: -9%">
                        <fieldset style="margin-left: 1%">Acciones Específicas</fieldset>
                        <textarea id="nom_especifica" cols="2" rows="10" style="width: 60%;width: 60%;text-transform:uppercase" onblur="javascript:this.value = this.value.toUpperCase();" readonly="" placeholder="3.2 Nombre de la Acción Específica" class="form-control"></textarea>
                    </div>
                </div>
            </div>
        </div>
        <br/>
        <br/>
        <div class="row" style="text-align: center">
            <a href='<?php echo base_url("acciones/registro/ControllersRegistro$bandera"); ?>'>
                <button type="button" id="volver" style="font-weight: bold;font-size: 13px" class="btn btn-warning " >
                    &nbsp;<span class="glyphicon glyphicon-chevron-left"></span>&nbsp;Volver
                </button>
            </a>
            <?php
                if($this->input->get('ingreso') == 1){
                    $data_bandera = 1;
                    $bandera = "?ingreso=1";
                }else{
                    $data_bandera = "";
                    $bandera = "";
                }
             ?>
            <input data-bandera="<?php echo $data_bandera;?>" data-href="<?php echo base_url("acciones/registro/ControllersRegistro$bandera"); ?>" type="submit" id="registrar" style="font-weight: bold;font-size: 13px" class="btn btn-success" value="Guardar cambios"/>
            <button type="reset" id="limpiar" style="font-weight: bold;font-size: 13px; background: -moz-linear-gradient(#f4eb2f, #e5a32d); color: white " class="btn"/>
            &nbsp;<span class="glyphicon glyphicon-retweet"></span>&nbsp;&nbsp;Limpiar
            </button>
        </div>
        <br/>
    </div>

</form>
