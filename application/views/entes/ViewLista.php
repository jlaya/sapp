
<script>
    $(document).ready(function () {

        var TSectores = $('#tab_organos').dataTable({
            "iDisplayLength": 10,
            "iDisplayStart": 0,
            "sPaginationType": "full_numbers",
            "aLengthMenu": [25, 50, 75, 100],
            "oLanguage": {"sUrl": "<?php echo base_url();?>/assets/js/es.txt"},
            //"order": [[1, "asc"]],
            "aoColumns": [
                {"sClass": "control", "sWidth": "1%"},
                {"sClass": "registro center", "sWidth": "3%"},
                {"sClass": "registro center", "sWidth": "5%"},
                {"sClass": "registro center", "sWidth": "30%"},
                {"sClass": "registro center", "sWidth": "7%"},
                {"sWidth": "3%", "bSortable": false, "sClass": "center sorting_false", "bSearchable": false},
                {"sWidth": "3%", "bSortable": false, "sClass": "center sorting_false", "bSearchable": false}

            ]
        });

        // Validacion para borrar
        $("table#tab_organos").on('click', 'img.borrar', function (e) {
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
                            $.post('<?php echo base_url(); ?>entes/ControllersEntes/delete/' + id + '', function (response) {

                                bootbox.alert("Se elimino con exito", function () {
                                }).on('hidden.bs.modal', function (event) {
                                    url = '<?php echo base_url(); ?>entes/ControllersEntes'
                                    window.location = url
                                });

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
        <a href="<?php echo base_url('entes/ControllersEntes/nuevo'); ?>">
            <button role="button" class="btn btn-default" style="font-weight: bold;font-size: 13px" id="enviar" >
                &nbsp;<span class="glyphicon glyphicon-plus"></span>&nbsp;
                Agregar Organos / Entes
            </button>
        </a>
        </br>
        </br>
        <table style="width:100%;" border="0" align="center" cellspacing="1" id="tab_organos" align="center"
               class="table table-bordered table-striped table-hover table-condensed dt-responsive table-responsive" style="width:30%">
            <thead style="font-size: 16px">
                <tr style="background-color: silver;">
                    <th style='text-align: center;color: white' colspan="15">Listado de Organos / Entes</th>
                </tr>
                <tr style="background-color: #8BA8A7">
                    <th></th>
                    <th style='text-align: center'>Item</th>
                    <th style='text-align: center'>Tipo Institución</th>
                    <th style='text-align: center'>Institución</th>
                    <th style='text-align: center'>Siglas</th>
                    <th style='text-align: center'>Editar</th>
                    <th style='text-align: center'>Borrar</th>
                </tr>
            </thead>
            <tbody>

                <?php
                $i = 1;
                foreach ($lista_organos as $value) {
                    ?>

                    <tr style="font-size: 16px" class="{% cycle 'impar' 'par' %}">
                        <td></td>
                        <td><?php echo $i;?></td>
                        <td>
                        <?php
                            if($value->tipo_ins == 1): echo "ÓRGANO"; 
                            elseif($value->tipo_ins == 2): echo "ENTE"; 
                            elseif($value->tipo_ins == 3): echo "EMPRESA";
                            elseif($value->tipo_ins == 4): echo "UNIDAD DE APOYO";
                            endif
                        ?>
                        </td>
                        <td>
                            <a href="<?php echo base_url('entes/ControllersEntes/procesar/' . $value->id. "?ver=1"); ?>" style="cursor: pointer;text-decoration: none;" title="Ver Información preliminar">
                                <?php echo $value->nom_ins; ?>
                            </a>
                        </td>
                        <td><?php echo $value->siglas; ?></td> 
                        <td style='text-align: center'>
                            <a href="<?php echo base_url('entes/ControllersEntes/procesar/' . $value->id); ?>">
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
                    $i = $i +1;
                }
                ?>
            </tbody>
        </table>
    </div>
</div>


