<script>
    $(document).ready(function () {

        var TPP = $('#tabla_registro_proyecto').dataTable({
            "iDisplayLength": 10,
            "iDisplayStart": 0,
            "sPaginationType": "full_numbers",
            "aLengthMenu": [25, 50, 75, 100],
            "oLanguage": {"sUrl": "<?php echo base_url(); ?>assets/js/es.txt"},
            //"order": [[1, "asc"]],
            "aoColumns": [
                {"sClass": "registro center", "sWidth": "1%"},
                {"sClass": "registro center", "sWidth": "1%"},
                {"sClass": "registro center", "sWidth": "1%"},
                {"sClass": "registro center", "sWidth": "20%"},
                {"sClass": "registro center", "sWidth": "1%"},
                {"sClass": "registro center", "sWidth": "1%"},
                {"sWidth": "1%", "bSortable": false, "sClass": "center sorting_false", "bSearchable": false},
                {"sWidth": "1%", "bSortable": false, "sClass": "center sorting_false", "bSearchable": false}
            ]
        });

        $("#ano_fiscal").on('change', function (e) {
            var ano_fiscal = $(this).val();
            var url = "<?php echo base_url('acciones/proyecto/ControllersProyecto?ano_fiscal="+ano_fiscal+"'); ?>";
            location.href = url;
        });

        // Validacion para borrar
        $("table#tabla_registro_proyecto").on('click', 'img.borrar', function (e) {
            e.preventDefault();
            var id = this.getAttribute('id');


            bootbox.dialog({
                message: "¿Esta seguro de eliminar el registro?",
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
                            $.post('<?php echo base_url(); ?>acciones/proyecto/ControllersProyecto/delete/' + id + '', function (response) {

                                if (response == "existe") {

                                    bootbox.alert("Disculpe, no puede borrar el proyecto, se encuentra en estátus Aprobado", function () {
                                    }).on('hidden.bs.modal', function (event) {
                                    });

                                } else if (response == "ok") {
                                    bootbox.alert("Se elimino con exito", function () {
                                    }).on('hidden.bs.modal', function (event) {
                                        //url = '<?php echo base_url(); ?>acciones/proyecto/ControllersProyecto'
                                        url = window.location.href;
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
        <?php
        $ingresos_propios = $this->input->get('ingreso');
        $is_super_user = $this->session->userdata['logged_in']['is_superuser'];
        
        if($ingresos_propios == 1){
            $bandera = "?ingreso=1";
            $accion = 'Ingresos Propios / Proyecto';
            $disabled = "disabled=''";
        }else{
            $bandera = "";
            $accion = "Ante Proyecto";
            $disabled = "";
        }

        if($is_super_user == 'f'){
            $disabled = "disabled=''";
        }else{
            $disabled = "";
        }

        ?>
        <div style='float:left;'>
            <a href='<?php echo base_url("acciones/proyecto/ControllersProyecto/nuevo$bandera"); ?>'>
                <button role="button" class="btn btn-default" style="font-weight: bold;font-size: 13px" id="enviar" >
                    &nbsp;<span class="glyphicon glyphicon-plus"></span>&nbsp;
                    Agregar <?php echo $accion; ?>
                </button>
            </a>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        </div>
        <div style='float:rigth;'>
            <select style='width:20%;' class='form-control' id='ano_fiscal' name='ano_fiscal' <?php echo $disabled;?>>
                <option value='0'>Año fiscal</option>
                <?php foreach (range(2016,2030) as $value) { ?>
                    <option value='<?php echo $value;?>'><?php echo $value;?></option>
                <?php } ?>
            </select>
        </div>
        </br>
        <div style="font-weight:bold; color: #000000;" class="alert alert-danger">Nota: Para agilizar la consulta del registro, realize la busqueda por Organo u Ente</div>
        <table style="width:100%;" border="0" align="center" cellspacing="1" id="tabla_registro_proyecto" align="center"
               class="table table-bordered table-striped table-hover table-condensed dt-responsive table-responsive" style="width:30%">
            <thead style="font-size: 16px">
                <tr style="background-color: #263238">
                    <th style='text-align: center;color: white' colspan="15">Listado de Ante Proyectos</th>
                </tr>
                <tr style="background-color: #8BA8A7">
                    <th style='text-align: center'>Item</th>
                    <th style='text-align: center'>Año fiscal</th>
                    <th style='text-align: center'>Código</th>
                    <th style='text-align: center'>Organo /Ente</th>
                    <th style='text-align: center'>Estátus</th>
                    <th style='text-align: center'>Estado</th>
                    <th style='text-align: center'>Editar</th>
                    <th style='text-align: center'>Eliminar</th>
                </tr>
            </thead>
            <tbody>

                <?php
                $i = 1;
                foreach ($list_proy_registro as $value) {
                    
                        ?>
                        <tr style="font-size: 16px" class="{% cycle 'impar' 'par' %}">
                            <td><?php echo $i; ?></td>
                            <td><?php echo $value->ano_fiscal; ?></td>
                            <td><?php echo $value->codigo; ?></td>
                            <td>
                                <a href="<?php echo base_url('acciones/proyecto/ControllersProyecto/procesar_list/' . trim($value->codigo) . "?ver=1"); ?>" style="text-decoration: none;cursor: pointer;" title="Ver información preliminar">
                                    <?php echo $value->nom_ins; ?>
                                </a>
                            </td>
                            <!--<td><?php echo $value->nom_proyecto; ?></td>--> 
                            <td>
                                <?php
                                if ($value->estatus == 1) {
                                    echo "Revisando";
                                } else if ($value->estatus == 2) {
                                    echo "Rechazado";
                                } else if ($value->estatus == 3) {
                                    echo "Para Ajuste";
                                } else if ($value->estatus == 4) {
                                    echo "Aprobado";
                                } else if ($value->estatus == 5) {
                                    echo "Ingresos Propios";
                                }
                                ?>
                            </td>
                            <td
                            <?php
                            if ($value->accion == 1) {
                                ?>
                                    style="background-color: #DB9B9B;color: #000000;"
                                    <?php
                                } else {
                                    ?>
                                    style="background-color: #BADCD2;color: #000000;"
                                    <?php
                                }
                                ?>
                                >
                                    <?php
                                    if ($value->accion == 1) {
                                        echo "En Proceso";
                                    } else {
                                        echo "Ejecutado";
                                    }
                                    ?>
                            </td>
                            <td style='text-align: center'>
                                <?php if ($value->estatus == 1 or $value->estatus == 3) { ?>
                                    <a href="<?php echo base_url('acciones/proyecto/ControllersProyecto/procesar_list/' . trim($value->codigo).$bandera); ?>">
                                        <img style="width:25px;height: 25px" src="<?php echo base_url("assets/image/editar.png"); ?>"/>   
                                    </a>
                                <?php } else { ?>
                                    <a style="text-decoration:none" href="<?php echo base_url('acciones/proyecto/ControllersProyecto/procesar_list/' . trim($value->codigo).$bandera); ?>">
                                        <img style="width:25px;height: 25px" src="<?php echo base_url("assets/image/detalles.png"); ?>"/>
                                    </a>
                                <?php } ?>
                            </td>
                            <td style='text-align: center'>
                                
                            <?php if ($value->estatus == 1 or $value->estatus == 3 or $value->estatus == 5) { ?>
                                        <img class='borrar' id='<?php echo $value->id; ?>'  style="width:25px;height: 25px" src="<?php echo base_url("assets/image/eliminar.png"); ?>"/>
                            <?php } else { ?>
                                        <img style="width:25px;height: 25px" src="<?php echo base_url("assets/image/block.png"); ?>"/>
                            <?php } ?>
                                
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


