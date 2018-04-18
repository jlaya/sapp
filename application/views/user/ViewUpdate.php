<?php echo validation_errors(); ?>
<?php
if (isset($_GET['ver'])) {
    $preliminar = $_GET['ver'];
} else {
    $preliminar = "2";
}
?>

<script type="text/javascript">
    $(document).ready(function () {
        if (<?php echo $preliminar; ?> == 1) {
            $("input,textarea,select").prop('disabled', true);
        }
        $("select").select2();
        $('#cedula').numeric(); //Valida solo valores tipo texto
        $('#first_name,#last_name').alpha({allow: " "}); //Valida solo valores tipo texto
        $("#ente").select2('val', parseInt($("#id_ente").val()));

        $("#cedula").change(function (event) {
            var cedula = $('#cedula').val();
            //var hosting = $('#id_hosting').val(); // Captura del hosting (dominio)
            var hosting = "consultaelectoral.bva.org.ve/cedula="
            if (hosting) {
                $.get("http://" + hosting + cedula, function (data) {
                    var option = "";
                    $.each(data, function (i) {
                        $("#first_name").val(data[i].p_nombre + " " + data[i].s_nombre + " " + data[i].p_apellido + " " + data[i].s_apellido)
                    });
                    // Proceso para validar con la clase error 404 Not Found
                }, 'json');
            }
        });

        $("span.foto").click(function () {
            $('div#div_foto').modal('show');
        });

        $("#foto").fileinput({
            browseClass: "btn btn-success btn-block",
            showCaption: false,
            showRemove: false,
            showUpload: false,
            browseLabel: "Imagen",
            maxFileSize: 1024,
            allowedFileExtensions: ["jpg", "png", 'jpeg'],
            elErrorContainer: "#errorBlock",
            msgSizeTooLarge: 'Archivo muy pesado "{name}". (<b>{size} KB</b>) excede el tamaño máximo que es de <b>{maxSize} KB',
            msgInvalidFileExtension: 'Extensiones invalidad "{name}". Solo admite archivos"{extensions}".',
            initialPreview: [
                "<img src=<?php echo base_url("assets/foto/usuario/$detalles_lista->foto"); ?> style='width:250px;height:145px;' class='file-preview-image' alt='The Moon' title='The Moon'>",
            ],
        });

        // Validamos los campos del formulario
        $("#registrar").click(function (e) {
            e.preventDefault();  // Para evitar que se envíe por defecto
            var is_superuser = $("#is_superuser").is(':checked');
            var is_staff = $("#is_staff").is(':checked');
            var formData = new FormData(document.getElementById("form_usuario_user"));

            if ($('#ente').val().trim() == '') {

                bootbox.alert("Seleccione el Órgano", function () {
                }).on('hidden.bs.modal', function (event) {
                    $("#ente").parent('div').addClass('has-error')
                    $('#ente').select2('open');
                });

            } else if ($('#cedula').val().trim() == '' || $('#cedula').val().trim() == 0) {

                bootbox.alert("Rellene el campo de cédula", function () {
                }).on('hidden.bs.modal', function (event) {
                    $("#cedula").parent('div').addClass('has-error')
                    $('#cedula').val('')
                    $("#cedula").focus();
                });

            } else if ($('#cedula').val().length < 6) {


                bootbox.alert("La cédula está incompleta", function () {
                }).on('hidden.bs.modal', function (event) {
                    $("#cedula").parent('div').addClass('has-error')
                    $('#cedula').val('')
                    $("#cedula").focus();
                });

            } else if ($('#first_name').val().trim() == '') {

                bootbox.alert("Rellene el campo de nombres", function () {
                }).on('hidden.bs.modal', function (event) {
                    $("#first_name").parent('div').addClass('has-error')
                    $('#first_name').val('')
                    $("#first_name").focus();
                });

            } else if ($('#username_id').val().trim() == '') {

                bootbox.alert("Rellene el campo de usuario", function () {
                }).on('hidden.bs.modal', function (event) {
                    $("#username_id").parent('div').addClass('has-error')
                    $('#username_id').val('')
                    $("#username_id").focus();
                });

            } else if ($('#password').val() == '') {

                bootbox.alert("El campo contraseña no puede estar en blanco", function () {
                }).on('hidden.bs.modal', function (event) {
                    $("#password").parent('div').addClass('has-error')
                    $('#password').val('')
                    $("#password").focus();
                });

            } else if (($('#is_superuser,#is_staff').is(':checked') != true)) {
                bootbox.alert("Indique si es Administrador o Usuario", function () {
                    $('.nav-tabs a[href=#tabs_B]').tab('show');
                });
            } else {

                $.ajax({
                    url: "<?php echo base_url('ControllersUser/guardar'); ?>",
                    type: "post",
                    dataType: "html",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false
                }).done(function (response) {
                    if (response == 'existe') {
                        bootbox.alert("Disculpe, ya existe el usuario " + $("#username_id").val() + ", verifique los datos ", function () {
                        }).on('hidden.bs.modal', function (event) {
                            $("#username_id").parent('div').addClass('has-error');
                            $("#username_id").focus();
                        });
                    } else {
                        bootbox.alert("Se actualizo con exito", function () {
                        }).on('hidden.bs.modal', function (event) {
                            url = '<?php echo base_url(); ?>ControllersUser/listar'
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
                <label style="float: left" class="panel-title " ><a  href="<?php echo base_url(); ?>ControllersUser/listar" >Gestión de Usuarios</a>
                    > Actualizar Usuarios</label>
                <br>
            </div>
            <fieldset><legend class="titulo text-center">Datos Principales</legend></fieldset>
            <div class="panel-body">
                <div class='form-inline'>
                    <div class="form-inline">
                        <div class="form-group col-xs-12">
                            <label>Organismo</label>
                            <select id='ente' name='ente' style='width: 89.4%;'>
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
                    <br/><br/><br/>
                </div>
                <div class="form-inline">
                    <div class="form-group col-xs-6">
                        <label>Cédula&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                        <div class="input-group">
                            <input type="text" id="cedula" name="cedula" class="form-control" style='width: 100%' maxlength="9" autofocus='true' value='<?= $detalles_lista->cedula ?>'/>
                            <span class="input-group-addon btn btn-success foto" id="basic-addon2" style="cursor:pointer;" title="Click para agregar foto">Foto <span class='fa fa-upload'></span></span>
                            <input type='hidden' name='id' value='<?php echo $detalles_lista->id; ?>'/>
                        </div>                          
                    </div>
                    <div class="form-group col-xs-6">
                        <label>&nbsp;&nbsp;Nombres&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                        <input class="form-control" style="width:81%" type='text' placeholder="Nombres" id="first_name" name="first_name" value='<?= $detalles_lista->first_name ?>'/>                           
                    </div>
                </div>
                <br/><br/><br/>
                <div class="form-inline">
                    <div class="form-group col-xs-6">
                        <label>Usuario&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                        <input class="form-control" style="width:80%" type='text' placeholder="Usuario" id="username_id" name="username" value='<?= $detalles_lista->username ?>'/>
                    </div>
                    <div class="form-group col-xs-6">
                        <label>Contraseña&nbsp;&nbsp;&nbsp;</label>
                        <input class="form-control" style="width:80%" type='password' placeholder="Contraseña" id="password" name="password"/>
                    </div>
                </div>
                <br/><br/><br/>
                <div class="form-inline"

                     <?php
                     if (($this->session->userdata['logged_in']['ver']) == 'f') {
                         ?>
                         hidden='hidden'
                         <?php
                     }
                     ?>


                     >
                    <div class="form-group col-xs-2" id='' style=''>
                        <label>&nbsp;&nbsp;Estátus&nbsp;&nbsp;&nbsp;</label>
                        <input type="checkbox" id="is_active" name="is_active" style='cursor:pointer;'
                        <?php if ($detalles_lista->is_active == 't') {
                            ?>
                                   checked='checked'
                               <?php } ?>
                               />
                    </div>
                    <div class="form-group col-xs-2" id='' >
                        <label>Administrador&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                        <input type="checkbox" id="is_superuser" name="is_superuser" style='cursor:pointer;'
                        <?php if ($detalles_lista->is_superuser == 't') {
                            ?>
                                   checked='checked'
                               <?php } ?>
                               />
                    </div>
                    <div class="form-group col-xs-2" id='' style='margin-left:6%'>
                        <label>Usuario&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                        <input type="checkbox" id="is_staff" name="is_staff" style='cursor:pointer;'
                        <?php if ($detalles_lista->is_staff == 't') {
                            ?>
                                   checked='checked'
                               <?php } ?>
                               />
                    </div>
                </div>
                <br/><br/><br/>
                <div class='div_button'>
                    <div class="form-group col-xs-12 text-center">
                        <a href="<?php echo base_url('ControllersUser/listar'); ?>">
                            <button type="button" id="volver" style="font-weight: bold;font-size: 13px" class="btn btn-warning " >
                                &nbsp;<span class="glyphicon glyphicon-chevron-left"></span>&nbsp;Volver
                            </button>
                        </a>
                        <?php if ($preliminar != 1) { ?>
                            <button type="button" id="registrar" style="font-weight: bold;font-size: 13px" class="btn btn-success"/>
                            &nbsp;<span class="glyphicon glyphicon-floppy-disk"></span>&nbsp;Guardar cambios
                            </button>
                            <button type="reset" id="limpiar" style="font-weight: bold;font-size: 13px; background: -moz-linear-gradient(#f4eb2f, #e5a32d); color: white " class="btn"/>
                            &nbsp;<span class="glyphicon glyphicon-retweet"></span>&nbsp;&nbsp;Limpiar
                            </button>
                        <?php } ?>
                    </div>
                </div>
                <div class="modal fade" id="div_foto" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
                    <div class="modal-dialog" style="width: 50%;">
                        <div class="modal-content form-horizontal">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                    <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                                </button>
                                <div id="Heading"></div>
                                <div class="titulo" id='div_name'>Adjuntar Foto</div>
                            </div>
                            <div class="modal-body">
                                <input id="foto" name="foto" type="file">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <br/>
        <br/>
        <br/>
    </div>
</form>
<input type='hidden' id='id_ente' value='<?= $detalles_lista->ente ?>'/>
