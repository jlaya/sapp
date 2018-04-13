<?php
if (isset($_GET['ver'])) {
    $preliminar = $_GET['ver'];
} else {
    $preliminar = "2";
}
?>
<script>
    $(document).ready(function () {
        $("select").select2();
        if (<?php echo $preliminar; ?> == 1) {
            $("input,textarea,select").prop('disabled', true);
        }

        $('#partida_presupuestaria').alpha({allow: " -.,"});

        /*if ($("#id_partida_padre").val() != 0) {
         $("#partida_padre").select2('val',parseInt($("#id_partida_padre").val()));
         }else{
         $("#partida_padre").select2('val',0);
         }*/

        $("#registrar").click(function (e) {

            e.preventDefault();  // Para evitar que se envíe por defecto

            if ($('#codigo').val().trim() == '') {

                bootbox.alert("Rellene el campo de Código", function () {
                }).on('hidden.bs.modal', function (event) {
                    $("#codigo").parent('div').addClass('has-error');
                    $("#codigo").focus();
                });

            } else if ($('#partida_presupuestaria').val().trim() == '') {
                bootbox.alert("Rellene la Partida Presupuestaria", function () {
                }).on('hidden.bs.modal', function (event) {
                    $("#partida_presupuestaria").parent('div').addClass('has-error');
                    $("#partida_presupuestaria").focus();
                });
            } else {

                $.post('<?php echo base_url(); ?>partida_presupuestaria/ControllersPartidaPresupuestaria/modificar', $('#form_partida_presupuestaria').serialize(), function (response) {

                    if (response == '1') {

                        bootbox.alert("Disculpe, ya existe un código o una partida Presupuestaria registrado, verifique los datos ", function () {
                        }).on('hidden.bs.modal', function (event) {
                            $("#partida_presupuestaria,#codigo").parent('div').addClass('has-error');
                            $("#partida_presupuestaria,#codigo").focus();
                        });

                    } else {
                        bootbox.alert("Se actualizo con exito", function () {
                        }).on('hidden.bs.modal', function (event) {
                            url = '<?php echo base_url(); ?>partida_presupuestaria/ControllersPartidaPresupuestaria'
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
<form id="form_partida_presupuestaria" action="" method="POST">
    <div style="width: 95%;text-transform:uppercase;box-shadow: 0 1px 5px rgba(0,0,0,.85);margin: auto;" class="panel panel-default">
        <div class="panel-heading" style='background: linear-gradient(#2F9292, #3B7272);color:#FFFFFF;' >
            <label style="float: left" class="panel-title " ><a  href="<?php echo base_url(); ?>partida_presupuestaria/ControllersPartidaPresupuestaria" >Configuraciones</a>
                > Modificar Partida Presupuestaria</label>
            <br>
        </div>
        <fieldset><legend class="titulo text-center">Datos de la Partida Presupuestaria</legend></fieldset>
        <div class="panel-body">
            <div class="col-xs-1" >Código</div>
            <div class="col-xs-4">
                <input id="codigo"  value="<?php echo $detalles_lista->codigo ?>" style="width: 100%;text-transform:uppercase;" onblur="javascript:this.value = this.value.toUpperCase();" placeholder="Ingrese el código" name="codigo" type="text" class="form-control" />
            </div>
            <div class="col-xs-2" >Partida Presupuestaria</div>
            <div class="col-xs-4">
                <input id="partida_presupuestaria" value="<?php echo $detalles_lista->partida_presupuestaria ?>" style="width: 100%;text-transform:uppercase;" onblur="javascript:this.value = this.value.toUpperCase();" placeholder="Ingrese la Partida Presupuestaria" name="partida_presupuestaria" type="text" class="form-control" />
                <input type="hidden" name="id" value="<?php echo $this->uri->rsegment(3) ?>" />
                <input type='hidden' id='id_partida_padre' value='<?php echo $detalles_lista->partida_padre ?>'/>
            </div>
        </div>
        <br/>
        <div class="row" style="text-align: center">
            <a href="<?php echo base_url('partida_presupuestaria/ControllersPartidaPresupuestaria'); ?>">
                <button type="button" id="volver" style="font-weight: bold;font-size: 13px" class="btn btn-warning " >
                    &nbsp;<span class="glyphicon glyphicon-chevron-left"></span>&nbsp;Volver
                </button>
            </a>
            <?php if ($preliminar != 1) { ?>
                <input type="submit" id="registrar" style="font-weight: bold;font-size: 13px" class="btn btn-success" value="Guardar cambios"/>
                <button type="reset" id="limpiar" style="font-weight: bold;font-size: 13px; background: -moz-linear-gradient(#f4eb2f, #e5a32d); color: white " class="btn"/>
                &nbsp;<span class="glyphicon glyphicon-retweet"></span>&nbsp;&nbsp;Limpiar
                </button>
            <?php } ?>
        </div>
        <br/>
    </div>
</form>
