<?php
    if(isset($_GET['ver'])){
        $preliminar = $_GET['ver'];
    }else{
        $preliminar = "2";
    }
?>
<script>
    $(document).ready(function () {
        if(<?php echo $preliminar;?> == 1){
            $("input,textarea,select").prop('disabled',true);
        }
        $("select").select2();
        $("#plan_patria").select2('val',$("#id_plan_patria").val());
        $('#objetivo_historico').alphanumeric({allow: ' -.,#:"'});
        
        $("#registrar").click(function (e) {

            e.preventDefault();  // Para evitar que se envíe por defecto

            if ($('#plan_patria').val().trim() == '') {

                bootbox.alert("Seleccione un Plan de la Patria", function () {
                }).on('hidden.bs.modal', function (event) {
                    $("#plan_patria").parent('div').addClass('has-error');
                    $("#plan_patria").select2('open');
                });

            } else if ($('#objetivo_historico').val().trim() == '') {
                bootbox.alert("Rellene el campo Objetivo Histórico", function () {
                }).on('hidden.bs.modal', function (event) {
                    $("#objetivo_historico").parent('div').addClass('has-error');
                    $("#objetivo_historico").focus();
                });
            } else {

                $.post('<?php echo base_url(); ?>objetivo_historico/ControllersObjH/modificar', $('#form_objetivo_historico').serialize(), function (response) {

                    if (response == '1') {

                        bootbox.alert("Disculpe, ya existe un Plan de la Patria asociado a un Objetivo Histórico registrado, verifique los datos ", function () {
                        }).on('hidden.bs.modal', function (event) {
                            $("#objetivo_historico").parent('div').addClass('has-error');
                            $("#objetivo_historico").focus();
                        });

                    } else {
                        bootbox.alert("Se actualizo con exito", function () {
                        }).on('hidden.bs.modal', function (event) {
                            url = '<?php echo base_url(); ?>objetivo_historico/ControllersObjH'
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
<form id="form_objetivo_historico" action="" method="POST">
    <div style="width: 95%;text-transform:uppercase;box-shadow: 0 1px 5px rgba(0,0,0,.85);margin: auto;" class="panel panel-default">
        <div class="panel-heading" style='background: linear-gradient(#2F9292, #3B7272);color:#FFFFFF;' >
            <label style="float: left" class="panel-title " ><a  href="<?php echo base_url(); ?>objetivo_historico/ControllersObjH" >Configuraciones</a>
                > Registrar Objetivo Histórico</label>
            <br>
        </div>
        <fieldset><legend class="titulo text-center">Datos del Objetivo Histórico</legend></fieldset>
        <div class="panel-body">
            <div class="col-xs-2" >Plan de la Patria</div>
            <div class="col-xs-9">
                <select id='plan_patria' name="plan_patria" class="form-control" style="width: 100%">
                    <option value="">Seleccione</option>
                    <?php
                    foreach ($lista_plan_patria as $value) {
                        ?>
                        <option value="<?php echo $value->id; ?>"><?php echo $value->codigo . " / ";
                    echo $value->plan_patria; ?></option>
                        <?php
                    }
                    ?>
                </select>
                <input type="hidden" name="id" value="<?php echo $this->uri->rsegment(3) ?>" />
            </div>
        </div>
        <div class="panel-body">
            <div class="col-xs-2" >Objetivo Histórico</div>
            <div class="col-xs-9">
                <textarea id="objetivo_historico" rows='5' style="width: 100%;text-transform:uppercase;" onblur="javascript:this.value = this.value.toUpperCase();" placeholder="Ingrese el Objetivo Histórico" name="objetivo_historico" type="text" class="form-control"><?php echo $detalles_lista->objetivo_historico;?></textarea>
            </div>
        </div>
        <br/>
        <div class="row" style="text-align: center">
            <a href="<?php echo base_url('objetivo_historico/ControllersObjH'); ?>">
                <button type="button" id="volver" style="font-weight: bold;font-size: 13px" class="btn btn-warning " >
                    &nbsp;<span class="glyphicon glyphicon-chevron-left"></span>&nbsp;Volver
                </button>
            </a>
            <?php if($preliminar !=1){?>
                <input type="submit" id="registrar" style="font-weight: bold;font-size: 13px" class="btn btn-success" value="Guardar cambios"/>
                <button type="reset" id="limpiar" style="font-weight: bold;font-size: 13px; background: -moz-linear-gradient(#f4eb2f, #e5a32d); color: white " class="btn"/>
                &nbsp;<span class="glyphicon glyphicon-retweet"></span>&nbsp;&nbsp;Limpiar
                </button>
            <?php }?>
        </div>
        <br/>
    </div>
    <input type="hidden" id="id_plan_patria" value="<?php echo $detalles_lista->plan_patria; ?>" />
</form>

