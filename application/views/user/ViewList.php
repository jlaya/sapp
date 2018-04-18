
<script>
    $(document).ready(function () {

        /* Formatting function for row details - modify as you need */
        function format ( o ) {
            if(o.is_superuser == "t"){
                var is_superuser = "<input type='checkbox' checked='checked' disabled='disabled' />";
            }else{
                var is_superuser = "<input type='checkbox' disabled='disabled' />";
            }

            if(o.is_staff == "t"){
                var is_staff = "<input type='checkbox' checked='checked' disabled='disabled' />";
            }else{
                var is_staff = "<input type='checkbox' disabled='disabled' />";
            }

            if(o.is_active == "t"){
                is_active = '<a class="cambio" id='+o.id+' name='+o.is_active+' style="text-decoration: none;">';
                    is_active += '<span class="label label-primary" title="Click para activar o desactivar">ACTIVO</span>';
                is_active += '</a>';
            }else{
                is_active = '<a class="cambio" id='+o.id+' name='+o.is_active+' style="text-decoration: none;">';
                    is_active += '<span class="label label-warning" title="Click para activar o desactivar">INACTIVO</span>';
                is_active += '</a>';
            }

            edit = '<a href=<?php echo base_url('ControllersUser/procesar/'); ?>/'+o.id+'>';
                edit += '<img style="width:25px;height: 25px" src="<?php echo base_url("assets/image/editar.png"); ?>"/>';
            edit += '</a>';

            // `o` is the original data object for the row
            return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+
                '<tr>'+
                    '<td>Perfil Administrador:</td>'+
                    '<td>'+is_superuser+'</td>'+
                '</tr>'+
                '<tr>'+
                    '<td>Perfil Usuario:</td>'+
                    '<td>'+is_staff+'</td>'+
                '</tr>'+
                '<tr>'+
                    '<td>Estátus:</td>'+
                    '<td>'+is_active+'</td>'+
                '</tr>'+
                '<tr>'+
                    '<td>Acción:</td>'+
                    '<td>'+edit+'</td>'+
                '</tr>'+
            '</table>';
        }
        
        $(document).ready(function() {
            var table = $('#tab_user').DataTable( {
                "iDisplayLength": 10,
                "iDisplayStart": 0,
                "sPaginationType": "full_numbers",
                "aLengthMenu": [25, 50, 75, 100],
                "oLanguage": {"sUrl": "<?php echo base_url(); ?>/assets/js/es.txt"},
                "ajax": "<?php echo base_url();?>ControllersUser/ajax",
                "columns": [
                    {
                        "className":      'details-control',
                        "orderable":      true,
                        "data":           null,
                        "defaultContent": ''
                    },
                    { "data": "cedula" },
                    { "data": "username"  },
                    { "data": "first_name"  },
                    { "data": "nom_organo"  },
                ],
                "order": [[1, 'asc']]
            } );
            
            // Add event listener for opening and closing details
           $('#tab_user tbody').on('click', 'td.details-control', function () {
                var tr = $(this).closest('tr');
                var row = table.row( tr );
        
                if ( row.child.isShown() ) {
                    // This row is already open - close it
                    row.child.hide();
                    tr.removeClass('shown');
                }
                else {
                    // Open this row
                    row.child( format(row.data()) ).show();
                    tr.addClass('shown');
                }
            } );
        } );

        // Validacion respectiva para la actualizacion de los datos(1)
        $("table#tab_user").on('click', 'a.cambio', function (e) {
            var id = this.getAttribute('id');
            var status = this.getAttribute('name');

            if (status == "t") {
                status = "False";
            } else {
                status = "True";
            }

            bootbox.dialog({
                message: "¿Desea procesar la información",
                title: "Enviar observación",
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

                            $.post('<?php echo base_url(); ?>ControllersUser/status/' + id + '/' + status, function (response) {
                                bootbox.alert("Se actualizo con exito", function () {
                                }).on('hidden.bs.modal', function (event) {
                                    url = '<?php echo base_url(); ?>ControllersUser/listar'
                                    window.location = url;
                                });
                            });
                        }
                    }
                }
            });


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
        <a href="<?php echo base_url('ControllersUser/new_user'); ?>">
            <button role="button" class="btn btn-default" style="font-weight: bold;font-size: 13px" id="enviar" >
                &nbsp;<span class="glyphicon glyphicon-plus"></span>&nbsp;
                Agregar Usuario
            </button>
        </a>
        <table style="width:100%;" border="0" align="center" cellspacing="1" id="tab_user" align="center"
               class="table table-bordered table-striped table-hover table-condensed dt-responsive table-responsive" style="width:30%">
            <thead style="font-size: 16px">
                <tr style="background-color: #263238">
                    <th style='text-align: center;color: white' colspan="15">Listado de Usuarios</th>
                </tr>
                <tr style="background-color: #8BA8A7">
                    <th></th>
                    <th style='text-align: center'>Cédula</th>
                    <th style='text-align: center'>Usuario</th>
                    <th style='text-align: center'>Nombres</th>
                    <th style='text-align: center'>Órgano u Ente</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>


