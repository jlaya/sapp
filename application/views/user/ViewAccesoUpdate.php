

<script type="text/javascript">
    $(document).ready(function () {
        $("select").select2();
        $('#id_grupo').numeric(); //Valida solo valores tipo texto
        $('#first_name,#last_name').alpha({allow: " "}); //Valida solo valores tipo texto
        $("#id_org").select2('val', parseInt($("#id_orgs").val()));
        
        // Proceso de validacion para la captura de los valores de los modulos vinculados a los usuarios (Permiso de Acceso a Módulos)
        var mod_access = $("#modulo_ids").val().split('-');
        $.each(mod_access, function(key) { 
            //alert(substr [i]);
            $('input[name="id_modulo"][value="' + mod_access [key] + '"]').prop('checked', true);
        });
        
        // Proceso de validacion para la captura de los valores de los sub modulos vinculados a los usuarios (Permiso de Acceso a Sub Módulos)
        var sub_access = $("#sub_modulo_ids").val().split('-');
        $.each(sub_access, function(key) { 
            //alert(sub_access [key]);
            $('input[name="id_sub_modulo"][value="' + sub_access [key] + '"]').prop('checked', true).prop('disabled', false);
        });
        
        
        $("#id_org").change(function (e) {

            var id_org = $(this).val();

            $('#id_user').find('option:gt(0)').remove().end().select2('val', '');
            $.post('<?php echo base_url(); ?>ControllersUser/ajax_search/' + id_org + '', function (response) {
                var option = "";
                $.each(response, function (i) {
                    option += "<option value=" + response[i]['id'] + ">" + response[i]['username'] + "</option>";
                });
                $('#id_user').append(option);
            }, 'json');
        });
        
        var id_org = $("#id_org").val();
        $('#id_user').find('option:gt(0)').remove().end().select2('val', '');
        $.post('<?php echo base_url(); ?>ControllersUser/ajax_search/' + id_org + '', function (response) {
            var option = "";
            $.each(response, function (i) {
                option += "<option value=" + response[i]['id'] + ">" + response[i]['username'] + "</option>";
            });
            $('#id_user').append(option);
            $("select").select2();
             var user_ids = $("#user_ids").val();
             var $valores = user_ids.split(",");
             $("#id_user").select2("val", $valores);
            //$('#id_user').select2('val',parseInt($("#user_ids").val()));

        }, 'json');

        $("#id_user").change(function () {
            $("#user_ids").val(String($("#id_user").val()));
        });

        // Validacion para la captura de los checkbox dinamicos para los Módulos (Validacion 1)
        $("input[name='id_modulo']").change(function () {
            var $id_modulo = ''
            $("input[name='id_modulo']:checked").each(function () {
                $id_modulo += $(this).val() + '-';
            });
            $id_modulo = $id_modulo.substring(0, $id_modulo.length - 1);
            $('#modulo_ids').val($id_modulo);
        });

        // Validacion para la captura de los checkbox dinamicos para los Sub Módulos (Validacion 2)
        $("input[name='id_sub_modulo']").change(function () {
            var $id_sub_modulo = ''
            $("input[name='id_sub_modulo']:checked").each(function () {
                $id_sub_modulo += $(this).val() + '-';
            });
            $id_sub_modulo = $id_sub_modulo.substring(0, $id_sub_modulo.length - 1);
            $('#sub_modulo_ids').val($id_sub_modulo);
        });

        // Validacion para la captura de los checkbox dinamicos para los Sub Módulos Asociados a los Módulos
        $("input[name='id_modulo']").change(function (e) {
            // Id de los modulos elegidos
            var id_modulo = $("#modulo_ids").val();

            $('input[name="id_sub_modulo"]').prop('disabled', true);
            $.post('<?php echo base_url(); ?>ControllersUser/ajax_search_sub/' + id_modulo + '', function (response) {
                var option = "";
                // Captura de los valores en la db tabla sub_modulo
                $.each(response, function (i, obj) {
                    console.log(obj.id); // Revisar aqui
                    //alert($('input[name="id_sub_modulo"][value="'+obj.id+'"]').is(':checked'))
                    $('input[name="id_sub_modulo"][value="' + obj.id + '"]').prop('disabled', false);
                });
            }, 'json');
        });

        // Validamos los campos del formulario
        $("#registrar").click(function (e) {
            e.preventDefault();  // Para evitar que se envíe por defecto
            var is_superuser = $("#is_superuser").is(':checked');
            var is_staff = $("#is_staff").is(':checked');

            if ($('#id_org').val().trim() == '') {

                bootbox.alert("Seleccione el Organo", function () {
                }).on('hidden.bs.modal', function (event) {
                    $("#id_org").parent('div').addClass('has-error')
                    $('#id_org').select2('open');
                });

            } else if ($('#id_user').val() == '') {

                bootbox.alert("Seleccione los Usuarios", function () {
                }).on('hidden.bs.modal', function (event) {
                    $("#id_user").parent('div').addClass('has-error')
                    $('#id_user').select2('open');
                });

            } else if ($('#modulo_ids').val() == "") {
                bootbox.alert("Indique Uno de los Módulos", function () {
                });
            } else if ($('#sub_modulo_ids').val() == "") {
                bootbox.alert("Indique Uno de los Sub Módulos", function () {
                });
            } else if (($('#agregar,#modificar,#eliminar,#ver').is(':checked') != true)) {
                bootbox.alert("Indique una opción para los permiso de Acceso", function () {
                });
            } else {

                $.post("<?php echo base_url(); ?>ControllersUser/guardar_acceso", $('#form_usuario_user').serialize(), function (response) {

                    if (response == 'existe') {

                        bootbox.alert("<span style='color:red;'>Advertencia:</span> , el Órgano " + $("#id_org").find('option').filter(':selected').text() + ",  ya cumple con una permisoligía correspondiente, verifique los datos ", function () {
                        }).on('hidden.bs.modal', function (event) {
                            $("#username_id").parent('div').addClass('has-error');
                            $("#username_id").focus();
                        });

                    } else {

                        bootbox.alert("Se actualizo con exito", function () {
                        }).on('hidden.bs.modal', function (event) {
                            url = '<?php echo base_url(); ?>ControllersUser/acceso'
                            window.location = url
                        });
                    }

                });
            }
        });

    });
</script>
<br/>
<br/>
<br/>
<br/>
<body>
    <form method="post" action="" id="form_usuario_user" class="form-horizontal">
        <div style="width: 95%;text-transform:uppercase;box-shadow: 0 1px 5px rgba(0,0,0,.85);margin: auto;" class="panel panel-default">
            <div class="panel-heading" style='background: linear-gradient(#2F9292, #3B7272);color:#FFFFFF;' >
                <label style="float: left" class="panel-title " ><a  href="<?php echo base_url(); ?>ControllersUser/listar" >Usuarios</a>
                    > Registrar Permiso</label>
                <br>
            </div>
            <fieldset><legend class="titulo text-center">Datos Principales</legend></fieldset>

            <div class="panel-body">
                <div class="form-inline">
                    <div class="form-group col-xs-12">
                        <label>Organismo&nbsp;&nbsp;</label>
                        <select name="id_org" id='id_org' class="form-control" style="width:90%">
                            <option value="">Seleccione</option>
                            <?php
                            foreach ($list_org as $value) {

                                if ($value->tipo_ins == 1) {
                                    $ins = "ÓRGANO";
                                } elseif ($value->tipo_ins == 2) {
                                    $ins = "ENTE";
                                } elseif ($value->tipo_ins == 3) {
                                    $ins = "EMPRESA";
                                } elseif ($value->tipo_ins == 4) {
                                    $ins = "UNIDAD DE APOYO";
                                }
                                ?>
                                <option value="<?php echo $value->id; ?>"><?php
                                    echo "($value->siglas) ($ins) $value->nom_ins";
                                    ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-inline">
                    <div class="form-group col-xs-12">
                        <label>Usuario&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                        <select name="id_user" id='id_user' class="form-control" style="width:90%" multiple='multiple'>
                            <option value='0'>Seleccione</option>
                        </select>
                        <input id='user_ids' type='hidden' name='user_ids' value="<?= $this->ModelStandard->replace_string('-', ',', $detalles->id_user)?>"/>
                        <input type='hidden' name='id' value="<?=$detalles->id?>"/>
                    </div>
                </div>
                <br/><br/><br/>
                <br/>

                <div class="form-inline">
                    <div class="form-group col-xs-12">
                        <label>Módulo&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                        <?php
                        foreach ($list_modulo as $value) {
                            ?>
                            <span style='font-weight: bold;'><?php echo $value->modulo; ?></span>
                            <input type="checkbox" id="id_modulo" name="id_modulo" value="<?php echo $value->id; ?>" style='cursor:pointer;'/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <?php
                        }
                        ?>
                            <input type='hidden' id='modulo_ids' name='modulo_ids' value="<?=$detalles->id_modulo?>"/>
                    </div>
                </div>
                <br/><br/>
                <fieldset>
                    <legend><label>Sub Módulo</label></legend>
                

                <div style='overflow-y: scroll;text-align: justify;;height: 200px;width: 88%;border: 1px solid #367D7D;border-radius: 2px;margin: auto'>
                    <?php
                    foreach ($list_sub_modulo as $value) {
                        ?>

                        <div>
                            <div class="col-xs-4">
                            <span style='font-weight: bold;'><?php echo $value->sub_modulo; ?></span>
                            <input type="checkbox" disabled='disabled' id="id_sub_modulo" name="id_sub_modulo" value="<?php echo $value->id; ?>" style='cursor:pointer;'/>
                            </div>
                        </div>

                        <?php
                    }
                    ?>
                </div>
                </fieldset>
                <input type='hidden' id='sub_modulo_ids' name='sub_modulo_ids' value="<?=$detalles->id_sub_modulo?>"/>
                <div class="form-inline">
                    <br>
                    <fieldset>
                        <legend>Permiso de acceso</legend>
                    
                    <div class="form-group col-xs-2" id='' style=''>
                        <label>&nbsp;&nbsp;Agregar&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                        <input type="checkbox" id="agregar" name="agregar" style='cursor:pointer;'
                        <?php if($detalles->agregar == 't'){
                         ?>
                         checked='checked'
                        <?php }?>
                        />
                        
                    </div>
                    <div class="form-group col-xs-2" id='' >
                        <label>Modificar&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                        <input type="checkbox" id="modificar" name="modificar" style='cursor:pointer;'
                        <?php if($detalles->modificar == 't'){
                         ?>
                         checked='checked'
                        <?php }?>
                        />
                    </div>
                    <div class="form-group col-xs-2" id=''>
                        <label>Eliminar&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                        <input type="checkbox" id="eliminar" name="eliminar" style='cursor:pointer;'
                        <?php if($detalles->eliminar == 't'){
                         ?>
                         checked='checked'
                        <?php }?>
                        />
                    </div>
                    <div class="form-group col-xs-2" id=''>
                        <label>Ver&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                        <input type="checkbox" id="ver" name="ver" style='cursor:pointer;'
                        <?php if($detalles->ver == 't'){
                         ?>
                         checked='checked'
                        <?php }?>
                        />
                    </div>
                    </fieldset>
                </div>

                <br/><br/><br/>
                <br/><br/><br/>
                <div class='div_button'>
                    <div class="form-group col-xs-12 text-center">
                        <a href="<?php echo base_url('ControllersUser/acceso'); ?>">
                            <button type="button" id="volver" style="font-weight: bold;font-size: 13px" class="btn btn-warning " >
                                &nbsp;<span class="glyphicon glyphicon-chevron-left"></span>&nbsp;Volver
                            </button>
                        </a>
                        <button type="button" id="registrar" style="font-weight: bold;font-size: 13px" class="btn btn-success"/>
                        &nbsp;<span class="glyphicon glyphicon-floppy-disk"></span>&nbsp;Guardar cambios
                        </button>
                        <button type="reset" id="limpiar" style="font-weight: bold;font-size: 13px; background: -moz-linear-gradient(#f4eb2f, #e5a32d); color: white " class="btn"/>
                        &nbsp;<span class="glyphicon glyphicon-retweet"></span>&nbsp;&nbsp;Limpiar
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <br/>
        <br/>
        <br/>
    </div>
</form>
<input type="hidden" id="id_orgs" value="<?= $detalles->id_org ?>"/>

