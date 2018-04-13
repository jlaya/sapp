<?php echo validation_errors(); ?>

<script type="text/javascript">
    $(document).ready(function () {

        // Change colorpicker
        $('.colorpicker-element').colorpicker().on('changeColor', function(ev){
           id = $(this).attr('id');
           ev.backgroundColor = ev.color.toHex();
           if(id == "panel_p"){
               $("nav.navbar, div.panel-heading").css("background-image","linear-gradient(to bottom, "+ev.backgroundColor+" 0%, "+ev.backgroundColor+" 100%)");
           } else if(id == "panel_s"){
               $("div.list-group-item-info").css("background-image","linear-gradient(to bottom, "+ev.backgroundColor+" 0%, "+ev.backgroundColor+" 100%)");
           }
       });

        $("select").select2();
        var image = "<?php echo base_url() ?>";
        var avatar = "<?php echo isset($row->avatar) ? $row->avatar: "camera.png"; ?>"
        var avatar_login = "<?php echo isset($row->avatar_login) ? $row->avatar_login: "camera.png"; ?>"
        var url_avatar = image + "assets/foto/"+avatar;
        var url_avatar_login = image + "assets/foto/"+avatar_login;
        $("#foto").fileinput({
            browseClass: "btn btn-success btn-block",
            showCaption: false,
            showRemove: false,
            showUpload: false,
            browseLabel: "Imagen",
            maxFileSize: 2917,
            allowedFileExtensions: ["jpg", "png", 'jpeg','JPG'],
            elErrorContainer: "#errorBlock",
            msgSizeTooLarge: 'Archivo muy pesado "{name}". (<b>{size} KB</b>) excede el tamaño máximo que es de <b>{maxSize} KB',
            msgInvalidFileExtension: 'Extensiones invalidad "{name}". Solo admite archivos"{extensions}".',
            initialPreview: [
            "<img src="+url_avatar+" style='width:1024px;height:450px;cursor:pointer;' class='file-preview-image' alt='Adjuntar imagen' title='Imagen principal'>",
            ],
        });

        $("#picture-panel-login").fileinput({
            browseClass: "btn btn-success btn-block",
            showCaption: false,
            showRemove: false,
            showUpload: false,
            browseLabel: "Imagen",
            maxFileSize: 2917,
            allowedFileExtensions: ["jpg", "png", 'jpeg','JPG'],
            elErrorContainer: "#errorBlock",
            msgSizeTooLarge: 'Archivo muy pesado "{name}". (<b>{size} KB</b>) excede el tamaño máximo que es de <b>{maxSize} KB',
            msgInvalidFileExtension: 'Extensiones invalidad "{name}". Solo admite archivos"{extensions}".',
            initialPreview: [
            "<img src="+url_avatar_login+" style='width:1024px;height:450px;cursor:pointer;' class='file-preview-image' alt='Adjuntar imagen' title='Imagen  inicio de sesión'>",
            ],
        });

        $(".detail").change(function (e) {
            var id = $(this).val();
            var base_url         = "<?php echo base_url(); ?>";
            var url              = base_url + "ControllersUser/add_image/"+id;
            window.location.href = url;
        });

        // Validamos los campos del formulario
        $("#registrar").click(function (e) {
            e.preventDefault();  // Para evitar que se envíe por defecto
            $this = $(this);
            var is_checked_status = $("#status").is(':checked');
            var formData = new FormData(document.getElementById("frmimage"));
            
            if ($('#foto').attr('value') == '' && $('#picture-panel-login').attr('value') == '') {

                bootbox.alert("Seleccione una imagen", function () {
                }).on('hidden.bs.modal', function (event) {
                    $("#foto, #picture-panel-login").parent('div').addClass('has-error')
                });

            } else if ($('#titulo').val().trim() == '') {

                bootbox.alert("Ingrese un título", function () {
                }).on('hidden.bs.modal', function (event) {
                    $("#titulo").parent('div').addClass('has-error').val();
                });

            } else {
                var $url = "<?php echo base_url(); ?>"+"ControllersUser"+'/'+$this.data('accion');
                $.ajax({
                    url: $url,
                    type: "post",
                    dataType: "html",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false
                }).done(function (response) {
                    if (response == 'existe') {
                        bootbox.alert("Disculpe, ya se encuentra una imagen con esas especificaciones, verifique los datos ", function () {
                        }).on('hidden.bs.modal', function (event) {
                            $("#username_id").parent('div').addClass('has-error');
                            $("#username_id").focus();
                        });
                    } else {
                        bootbox.alert("Se registro con exito", function () {
                        }).on('hidden.bs.modal', function (event) {
                            url = '<?php echo base_url(); ?>ControllersUser/add_image'
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
    <style type="text/css" media="screen">
        .file-preview-frame {
            position: relative;
            display: table;
            margin: 8px;
            height: 450px;
            border: 1px solid #ddd;
            box-shadow: 1px 1px 5px 0 #a2958a;
            padding: 6px;
            float: left;
            width: 512px;
        }

        .file-preview-image {
            vertical-align: middle;
            position: relative;
            display: table;
            margin: 8px;
            height: 450px !important;
            border: 1px solid #ddd;
            box-shadow: 1px 1px 5px 0 #a2958a;
            padding: 6px;
            float: left;
            width: 512px !important;
        }
    </style>
    <form method="post" action="" id="frmimage" class="form-horizontal">
        <input type="hidden" name="id" id="id" value="<?php echo isset($row->id) ? $row->id: ""; ?>" />
        <div style="width: 95%;text-transform:uppercase;box-shadow: 0 1px 5px rgba(0,0,0,.85);margin: auto;" class="panel panel-default">
            <div class="panel-heading" style='background-image: linear-gradient(to bottom, #358080 0%, #358080 100%);color:#FFFFFF;' >
              <label style="float: left" class="panel-title " ><a  href="<?php echo base_url(); ?>ControllersUser/listar" >Gestión de Usuarios</a>
                > Panel de configuración</label>
                <br>
            </div>
            <div class="panel-body">
                <div class="form-inline">
                    <div class="form-group col-xs-12">
                        <label for="detail">Imagenes</label>
                        <select class="form-control detail" id="detail" style="width: 100%;">
                            <option value='0'>Seleccione</option>
                            <?php foreach ($avatar_result as $value) { ?>
                            <option value="<?php echo $value->id; ?>"><?php echo $value->titulo ?></option>
                            <?php } ?>
                        </select>                      
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <div class="form-inline">
                    <div class="form-group col-xs-3">
                        <label for="titulo">Estátus</label>
                        <input <?php if((int)$row->status == 1){ ?> checked = 'checked' <?php } ?> type="checkbox" class="form-control" id="status" name="status">                  
                    </div>
                    <div class="form-group col-xs-3">
                        <label for="panel_p"> Color Panel principal</label>
                        <input id="panel_p" name="panel_p" type="text" class="form-control" value="<?php echo isset($row->panel_p) ? $row->panel_p: "#358080"; ?>" />
                    </div>
                    <div class="form-group col-xs-3">
                        <label for="panel_s"> Color Panel secundario</label>
                        <input id="panel_s" name="panel_s" type="text" class="form-control" value="<?php echo isset($row->panel_s) ? $row->panel_s: "#263238"; ?>"/>
                    </div>
                    <div class="form-group col-xs-3">
                        <label for="panel_d"> Color menu desplegable </label>
                        <input id="panel_d" name="panel_d" type="text" class="form-control" value="<?php echo isset($row->panel_d) ? $row->panel_d: "#86CBCB"; ?>" style="width: 100%" />
                    </div>
                </div>
                <div class="form-inline">
                    <div class="form-group col-xs-12">
                        <label for="titulo">Título</label>
                        <textarea class="form-control" id="titulo" name="titulo" style="width: 100%;text-transform:uppercase;" onblur="javascript:this.value = this.value.toUpperCase();"><?php echo isset($row->titulo) ? $row->titulo: ""; ?></textarea>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <div class="form-inline">
                    <div class="form-group col-xs-6" style="text-align: center;">
                        <input id="foto" name="avatar" type="file">
                    </div>
                </div>
                <div class="form-inline">
                    <div class="form-group col-xs-6" style="text-align: center;">
                        <input name="avatar_login" id="picture-panel-login" type="file">
                    </div>
                </div>
                <br/>
                <div class='div_button' style="margin-top: 50%;">
                    <div class="form-group col-xs-12 text-center">
                        <button data-accion='guardar_image' type="button" id="registrar" style="font-weight: bold;font-size: 13px" class="btn btn-success"/>
                        &nbsp;<span class="glyphicon glyphicon-floppy-disk"></span>&nbsp;Guardar cambios
                    </button>
                    <input type="reset" id="limpiar" style="font-weight: bold;font-size: 13px; background: -moz-linear-gradient(#f4eb2f, #e5a32d); color: white " class="btn" value="Limpiar" />
                </div>
            </div>
        </div>
    </div>
    <br/>
    <br/>
    <br/>
</div>
</form>
