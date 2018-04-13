
<script>
    $(document).ready(function () {

        var TUser = $('#tab_user').dataTable({
            "iDisplayLength": 10,
            "iDisplayStart": 0,
            "sPaginationType": "full_numbers",
            "aLengthMenu": [25, 50, 75, 100],
            "oLanguage": {"sUrl": "<?php echo base_url(); ?>/assets/js/es.txt"},
            //"order": [[2, "asc"]],
            "aoColumns": [
                {"sClass": "control", "sWidth": "1%"},
                {"sClass": "registro center", "sWidth": "1%"},
                {"sClass": "registro center", "sWidth": "15%"},
                {"sClass": "registro center", "sWidth": "15%"},
                {"sWidth": "3%", "bSortable": false, "sClass": "center sorting_false", "bSearchable": false}
            ]
        });

        // Validacion para borrar
        $("table#tab_user").on('click', 'img.borrar', function (e) {
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
                            $.post('<?php echo base_url(); ?>sectores/ControllersSectores/delete/' + id + '', function (response) {

                                if (response == "existe") {

                                    bootbox.alert("Disculpe, Se encuentra asociado a un Organo u Ente", function () {
                                    }).on('hidden.bs.modal', function (event) {
                                    });

                                } else {
                                    bootbox.alert("Se elimino con exito", function () {
                                    }).on('hidden.bs.modal', function (event) {
                                        url = '<?php echo base_url(); ?>sectores/ControllersSectores'
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
        <a href="<?php echo base_url('ControllersUser/nuevo_acceso'); ?>">
            <button role="button" class="btn btn-default" style="font-weight: bold;font-size: 13px" id="enviar" >
                &nbsp;<span class="glyphicon glyphicon-plus"></span>&nbsp;
                Agregar Permiso
            </button>
        </a>
        <table style="width:100%;" border="0" align="center" cellspacing="1" id="tab_user" align="center"
               class="table table-bordered table-striped table-hover table-condensed dt-responsive table-responsive" style="width:30%">
            <thead style="font-size: 16px">
                <tr style="background-color: #263238">
                    <th style='text-align: center;color: white' colspan="15">Listado de Permiso de Acceso</th>
                </tr>
                <tr style="background-color: #8BA8A7">
                    <th></th>
                    <th style='text-align: center'>Item</th>
                    <th style='text-align: center'>Órganismo</th>
                    <th style='text-align: center'>Usuario(S)</th>
                    <th style='text-align: center'>Editar</th>
                </tr>
            </thead>
            <tbody>

                <?php
                $i= 1;
                foreach ($list_acceso as $value) {
                    ?>

                    <tr style="font-size: 16px" class="{% cycle 'impar' 'par' %}">
                        <td></td>
                        <td><?php echo $i;?></td>
                        <td>
                            <?php
                            $list_org = $this->ModelStandard->search_in('id', 'organos_entes', $value->id_org);
                            foreach($list_org AS $row){
                                
                            ?>
                            <a href="<?php echo base_url('ControllersUser/actualizacion/' . $value->id. "?ver=1"); ?>" style="cursor: pointer;text-decoration: none;" title="Ver Información preliminar">
                                <?=$row->nom_ins?>
                                </a>
                            <?php
                                
                            }
                            ?>
                        </td>
                        <td>
                            <?php
                            $id_user    = $this->ModelStandard->replace_string('-', ',', $value->id_user);
                            $list_user = $this->ModelStandard->search_in('id', 'auth_user', $id_user);
                            foreach($list_user AS $row){
                            ?>
                                <?="<span style='color:red;'>|</span> ".$row->username." <span style='color:red;'>|</span>"?>
                            <?php
                            }
                            ?>
                        </td>
                        <td style='text-align: center'>
                            <a href="<?php echo base_url('ControllersUser/actualizacion/' . $value->id); ?>">
                                <img style="width:25px;height: 25px" src="<?php echo base_url("assets/image/editar.png"); ?>"/>   
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


