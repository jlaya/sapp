
<script>
    $(document).ready(function () {

        var TObjN = $('#tab_obj_N').dataTable({
            "iDisplayLength": 10,
            "iDisplayStart": 0,
            "sPaginationType": "full_numbers",
            "aLengthMenu": [25, 50, 75, 100],
            "oLanguage": {"sUrl": "<?php echo base_url(); ?>assets/js/es.txt"},
            //"order": [[1, "asc"]],
            "aoColumns": [
                {"sClass": "control", "sWidth": "1%"},
                {"sClass": "registro center", "sWidth": "3%"},
                {"sClass": "registro center", "sWidth": "30%"},
                {"sClass": "registro center", "sWidth": "30%"},
                {"sClass": "none", "sWidth": "30%"},
                {"sClass": "none", "sWidth": "30%"},
                {"sClass": "none", "sWidth": "30%"},
                {"sWidth": "3%", "bSortable": false, "sClass": "center sorting_false", "bSearchable": false},
                {"sWidth": "3%", "bSortable": false, "sClass": "center sorting_false", "bSearchable": false}

            ]
        });

        // Validacion para borrar
        $("table#tab_obj_N").on('click', 'img.borrar', function (e) {
            e.preventDefault();
            var id = this.getAttribute('id');

            bootbox.dialog({
                message: "¿Desea manipular la información",
                title: "Borrar registro de bien",
                buttons: {
                    success: {
                        label: "Descartar",
                        className: "btn-primary",
                        callback: function () {

                        }
                    },
                    danger: {
                        label: "Procesar",
                        className: "btn-warning",
                        callback: function () {
                            //alert(id)
                            $.post('<?php echo base_url(); ?>objetivo_general/ControllersObjG/delete/' + id + '', function (response) {

                                if (response == "existe") {

                                    bootbox.alert("Disculpe, Se encuentra asociado a un Organo u Ente", function () {
                                    }).on('hidden.bs.modal', function (event) {
                                    });

                                } else {
                                    bootbox.alert("Se elimino con exito", function () {
                                    }).on('hidden.bs.modal', function (event) {
                                        url = '<?php echo base_url(); ?>objetivo_general/ControllersObjG'
                                        window.location = url
                                    });
                                }
                            });
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
    <div class="container mainbody-section text-center"  style="width:100%;">
        <a href="<?php echo base_url('objetivo_general/ControllersObjG/nuevo'); ?>">
            <button role="button" class="btn btn-default" style="font-weight: bold;font-size: 13px" id="enviar" >
                &nbsp;<span class="glyphicon glyphicon-plus"></span>&nbsp;
                Agregar Objetivo General
            </button>
        </a>
        </br>
        </br>
        <table style="width:100%;" border="0" align="center" cellspacing="1" id="tab_obj_N" align="center"
               class="table table-bordered table-striped table-hover table-condensed dt-responsive table-responsive" style="width:30%">
            <thead style="font-size: 16px">
                <tr style="background-color: #263238">
                    <th style='text-align: center;color: white' colspan="15">Listado de Objetivos Generales</th>
                </tr>
                <tr style="background-color: #8BA8A7">
                    <th></th>
                    <th style='text-align: center'>Item</th>
                    <th style='text-align: center'>Plan de la Patria</th>
                    <th style='text-align: center'>Objetivo Histórico</th>
                    <th style='text-align: center'>Objetivo Nacional</th>
                    <th style='text-align: center'>Objetivo Estratégico</th>
                    <th style='text-align: center'>Objetivo General</th>
                    <th style='text-align: center'>Editar</th>
                    <th style='text-align: center'>Borrar</th>
                </tr>
            </thead>
            <tbody>

                <?php
                $i = 1;
                foreach ($lista_objetivo_general as $value) {
                    ?>

                    <tr style="font-size: 16px" class="{% cycle 'impar' 'par' %}">
                        <td></td>
                        <td><?php echo $i; ?></td>
                        <td>
                            <a href="<?php echo base_url('objetivo_general/ControllersObjG/procesar/' . $value->id. "?ver=1"); ?>" style="cursor: pointer;text-decoration: none;" title="Ver Información preliminar">
                            <?php
                            foreach ($lista_plan_patria as $plan_p) {
                                if ($plan_p->id == $value->plan_patria) {
                                    echo $plan_p->plan_patria;
                                }
                            }
                            ?>
                            </a>
                        </td>
                        <td>
                            <?php
                            foreach ($lista_obj_historico as $obj_hist) {
                                if ($obj_hist->id == $value->objetivo_historico) {
                                    echo $obj_hist->objetivo_historico;
                                }
                            }
                            ?>
                        </td>
                        <td>
                            <?php
                            foreach ($lista_obj_nacional as $obj_n) {
                                if ($obj_n->id == $value->objetivo_nacional) {
                                    echo $obj_n->objetivo_nacional;
                                }
                            }
                            ?>
                        </td>
                        <td>
                            <?php
                            foreach ($lista_obj_estrategico as $est) {
                                if ($est->id == $value->objetivo_estrategico) {
                                    echo $est->objetivo_estrategico;
                                }
                            }
                            ?>
                        </td>
                        <td><?php echo $value->objetivo_general;?></td>
                        <td style='text-align: center'>
                            <a href="<?php echo base_url('objetivo_general/ControllersObjG/procesar/' . $value->id); ?>">
                                <img style="width:25px;height: 25px" src="<?php echo base_url("assets/image/editar.png"); ?>"/>   
                            </a>
                        </td>
                        <td style='text-align: center'>
                            <a href="">
                                <img class='borrar' id='<?php echo $value->id; ?>'  style="width:25px;height: 25px" src="<?php echo base_url("assets/image/eliminar.png"); ?>"/>
                            </a>
                        </td>
                    </tr>
                    <?php
                    $i = $i + 1;
                }
                ?>
            </tbody>
        </table>
    </div>
</div>


