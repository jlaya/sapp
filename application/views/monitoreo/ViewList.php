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
        var Planificadas = $('#tab_actividad_planificada').dataTable({
            "iDisplayLength": 10,
            "iDisplayStart": 0,
            "sPaginationType": "full_numbers",
            "aLengthMenu": [5, 10, 15, 20, 25, 30, 35, 40, 45, 50, 55, 60, 65, 70, 75, 80, 85, 90, 100],
            "oLanguage": {"sUrl": "<?php echo base_url(); ?>assets/js/es.txt"},
            "order": [[2, "desc"]],
            "aoColumns": [
                {"sClass": "control", "sWidth": "1%"},
                {"sClass": "registro center", "sWidth": "15%"},
                {"sClass": "registro center", "sWidth": "2%"},
                {"sClass": "registro center", "sWidth": "2%"},
                {"sClass": "registro center", "sWidth": "2%"},
                {"sClass": "registro center", "sWidth": "2%"},
            ]
        });

        var Ejecutadas = $('#tab_actividad_ejecutada').dataTable({
            "iDisplayLength": 10,
            "iDisplayStart": 0,
            "sPaginationType": "full_numbers",
            "aLengthMenu": [5, 10, 15, 20, 25, 30, 35, 40, 45, 50, 55, 60, 65, 70, 75, 80, 85, 90, 100],
            "oLanguage": {"sUrl": "<?php echo base_url(); ?>assets/js/es.txt"},
            "order": [[2, "desc"]],
            "aoColumns": [
                {"sClass": "control", "sWidth": "1%"},
                {"sClass": "registro center", "sWidth": "15%"},
                {"sClass": "registro center", "sWidth": "2%"},
                {"sClass": "registro center", "sWidth": "2%"},
                {"sClass": "registro center", "sWidth": "2%"},
                {"sClass": "registro center", "sWidth": "2%"},
            ]
        });

        // Proceso de Organos
        $("#organo").click(function () {
            var organo = $(this).val();
            
            $('#id_accion_act').find('option:gt(0)').remove().end().select2('val', "");
            $.post('<?php echo base_url(); ?>acciones/observaciones/ControllersObservaciones/ajax_search/' + organo + '', function (response) {
                if (response.length != 0) {
                    var option = "";
                    $.each(response, function (i) {
                        if (response[i]['estatus'] == 4) {

                            option += "<option value=" + response[i]['id'] + ">" + response[i]['codigo'] + "</option>";
                        }
                    });
                    $('#id_accion_act').append(option);
                } else {
                    bootbox.alert("No existen datos asociados...", function () {
                    }).on('hidden.bs.modal', function (event) {
                    });
                }
            }, 'json').fail(function (jqXHR, textStatus, errorThrown) {
                
                if (jqXHR.status === 0) {

                    bootbox.alert("Error de Conexión, Verifique la Red...", function () {
                    }).on('hidden.bs.modal', function (event) {
                    });

                } else if (jqXHR.status == 404) {
                    bootbox.alert("página solicitada no se encuentra [ 404 ]...", function () {
                    }).on('hidden.bs.modal', function (event) {
                    });

                } else if (jqXHR.status == 500) {

                    bootbox.alert("Error interno del servidor [ 500]...", function () {
                    }).on('hidden.bs.modal', function (event) {
                    });

                } else if (textStatus === 'parsererror') {

                    bootbox.alert("Solicitud de JSON fallida...", function () {
                    }).on('hidden.bs.modal', function (event) {
                    });

                } else if (textStatus === 'timeout') {

                    bootbox.alert("Error de tiempo de espera...", function () {
                    }).on('hidden.bs.modal', function (event) {
                    });

                } else if (textStatus === 'abort') {

                    bootbox.alert("Petición Ajax abortado...", function () {
                    }).on('hidden.bs.modal', function (event) {
                    });

                } else {

                    bootbox.alert("Error no capturado..."+ jqXHR.responseText, function () {
                    }).on('hidden.bs.modal', function (event) {
                    });

                }

            });
        });

        $("#id_accion_act").change(function () {
            var id_accion_act = $(this).val();
            alert(id_accion_act)
        });



    });

</script>
<br/>
<br/>
<br/>
<br/>
<form id='form_sectores' action="" method="POST">
    <div style="width: 95%;text-transform:uppercase;box-shadow: 0 1px 5px rgba(0,0,0,.85);margin: auto;" class="panel panel-default">
        <div class="panel-heading" style='background: linear-gradient(#2F9292, #3B7272);color:#FFFFFF;' >
            <label style="float: left" class="panel-title " >Monitor / Actividad</label>
            <br>
        </div>
        <br/>
        <div class="panel-body" style="margin-left: 3%">
            <div class="col-xs-2">Órgamo/Ente/Empresa</div>
            <div class="col-md-10">
                <select id="organo" style="width: 85.5%;" class="form-control">
                    <option value="">Seleccione</option>
                    <?php
                    foreach ($organo as $row) {
                        ?>
                        <option value="<?php echo $row->id; ?>"><?php echo $row->nom_ins; ?></option>
                        <?php
                    }
                    ?>
                </select>
                <select id='id_accion_act' style="width: 10%;" class="form-control">
                    <option value="">ID</option>
                </select>
            </div>
        </div>
        <!-- ACTIVIDADES PLANIFICADAS -->
        <div style='width: 90%;margin: auto;'>
            <table style="width:100%;" border="0" align="center" cellspacing="1" id="tab_actividad_planificada" align="center"
                   class="table table-bordered table-striped table-hover table-condensed dt-responsive table-responsive" style="width:20%">
                <thead style="font-size: 16px">
                    <tr style="background-color: #263238">
                        <th style='text-align: center;color: white' colspan="15">Planificadas <?= date('Y', now()) ?></th>
                    </tr>
                    <tr style="background-color: #8BA8A7">
                        <th></th>
                        <th style='text-align: center'>Actividad</th>
                        <th style='text-align: center'>I Trimestre</th>
                        <th style='text-align: center'>II Trimestre</th>
                        <th style='text-align: center'>III Trimestre</th>
                        <th style='text-align: center'>IV Trimestre</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>

        <!-- ACTIVIDADES EJECUTADAS -->
        <div style='width: 90%;margin: auto;'>
            <table style="width:100%;" border="0" align="center" cellspacing="1" id="tab_actividad_ejecutada" align="center"
                   class="table table-bordered table-striped table-hover table-condensed dt-responsive table-responsive" style="width:20%">
                <thead style="font-size: 16px">
                    <tr style="background-color: #263238">
                        <th style='text-align: center;color: white' colspan="15">Ejecutadas <?= date('Y', now()) ?></th>
                    </tr>
                    <tr style="background-color: #8BA8A7">
                        <th></th>
                        <th style='text-align: center'>Actividad</th>
                        <th style='text-align: center'>I Trimestre</th>
                        <th style='text-align: center'>II Trimestre</th>
                        <th style='text-align: center'>III Trimestre</th>
                        <th style='text-align: center'>IV Trimestre</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>

    </div>
</form>
