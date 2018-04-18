<?php
    if (isset($this->session->userdata['logged_in'])) {
        $username = ($this->session->userdata['logged_in']['username']);
        $id = ($this->session->userdata['logged_in']['id']);
    } else {
        $header = base_url();
        header("location: ".$header);
    }
?>
<script>
    $(document).ready(function () {
        $('#estructura').alpha({allow:" -.,"});
        $('#codigo').alphanumeric({allow:"-."});
        $("#registrar").click(function (e) {

            e.preventDefault();  // Para evitar que se envíe por defecto

            if ($('#codigo').val().trim() == '') {

                bootbox.alert("Rellene el campo de Código", function () {
                }).on('hidden.bs.modal', function (event) {
                    $("#codigo").parent('div').addClass('has-error');
                    $("#codigo").focus();
                });

            } else if ($('#estructura').val().trim() == '') {
                bootbox.alert("Rellene el campo de Tipo de Estructura", function () {
                }).on('hidden.bs.modal', function (event) {
                    $("#estructura").parent('div').addClass('has-error');
                    $("#estructura").focus();
                });
            } else {

                $.post('<?php echo base_url(); ?>estructura/ControllersEstructura/guardar', $('#form_estructura').serialize(), function (response) {
                    
                    if (response == '1') {
                        
                        bootbox.alert("Disculpe, ya existe un código o estructura registrado, verifique los datos ", function () {
                        }).on('hidden.bs.modal', function (event) {
                            $("#estructura").parent('div').addClass('has-error');
                            $("#estructura").focus();
                        });
                        
                    }else{
                        bootbox.alert("Se registro con exito", function () {
                        }).on('hidden.bs.modal', function (event) {
                            url = '<?php echo base_url(); ?>estructura/ControllersEstructura'
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
<form id='form_estructura' action="" method="POST">
    <div style="width: 95%;text-transform:uppercase;box-shadow: 0 1px 5px rgba(0,0,0,.85);margin: auto;" class="panel panel-default">
        <div class="panel-heading" style='background: linear-gradient(#2F9292, #3B7272);color:#FFFFFF;' >
            <label style="float: left" class="panel-title " ><a  href="<?php echo base_url();?>estructura/ControllersEstructura" >Configuraciones</a>
                > Registrar Tipo de Estructura Presupuestaria</label>
            <br>
        </div>
        <fieldset><legend class="titulo text-center">Datos de la Estructura</legend></fieldset>
        <div class="panel-body">
            <div class="col-xs-12">
                <div class="col-xs-1" >Estructura</div>
                <div class="col-xs-2">
                    <select id='padre' name="padre" style='width: 50%;' class="form-control select2">
                        <?php
                        foreach (range(0, 99) as $row) {
                            ?>
                                <option value="<?php echo $row; ?>"><?php echo $row; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="col-xs-2">
                    <select id='partida' name="partida" style='width: 50%;margin-left: -46%;' class="form-control select2">
                        <?php
                        foreach (range(0, 99) as $row) {
                            ?>
                                <option value="<?php echo $row; ?>"><?php echo $row; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="col-xs-2">
                    <select id='generica' name="generica" style='width: 50%;margin-left: -96%;' class="form-control select2">
                        <?php
                        foreach (range(0, 99) as $row) {
                            ?>
                                <option value="<?php echo $row; ?>"><?php echo $row; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="col-xs-2">
                    <select id='especifica' name="especifica" style='width: 50%;margin-left: -141%;' class="form-control select2">
                        <?php
                        foreach (range(0, 99) as $row) {
                            ?>
                                <option value="<?php echo $row; ?>"><?php echo $row; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="col-xs-2">
                    <select id='sub_especifica' name="sub_especifica" style='width: 50%;margin-left: -185%;' class="form-control select2">
                        <?php
                        foreach (range(0, 99) as $row) {
                            ?>
                                <option value="<?php echo $row; ?>"><?php echo $row; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-xs-12">
                <div class="col-xs-1" >Descripción</div>
                <div class="col-xs-11">
                    <select id='padre' name="padre" style='width: 100%;' class="form-control select2">
                        <?php
                        foreach (range(0, 99) as $row) {
                            ?>
                                <option value="<?php echo $row; ?>"><?php echo $row; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
            </div>
        </div>
        <br/>
        <div class="row" style="text-align: center">
            <a href="<?php echo base_url('estructura/ControllersEstructura'); ?>">
                <button type="button" id="volver" style="font-weight: bold;font-size: 13px" class="btn btn-warning " >
                    &nbsp;<span class="glyphicon glyphicon-chevron-left"></span>&nbsp;Volver
                </button>
            </a>
            <input type="submit" id="registrar" style="font-weight: bold;font-size: 13px" class="btn btn-success" value="Guardar cambios"/>
            <button type="reset" id="limpiar" style="font-weight: bold;font-size: 13px; background: -moz-linear-gradient(#f4eb2f, #e5a32d); color: white " class="btn"/>
            &nbsp;<span class="glyphicon glyphicon-retweet"></span>&nbsp;&nbsp;Limpiar
            </button>
            
        </div>
        <br/>
    </div>
</form>
