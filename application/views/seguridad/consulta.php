
<h1 style="text-align: center">
    Bienvenido al sistema de la policia del estado aragua
</h1>
<h3 style="text-align: center">Sistema de Reseña de La Policia del estado Aragua</h1>
<!--VENTANA MODAL PARA REFLEJAR LA CONSULTA DE LAS PERSONAS-->


<div style="width: 100%;"class="row x_panel">
    <div class="form-horizontal">
        <div class="modal-header">
            <div id="Heading"></div>
            <div class="titulo">Consulta</div>
        </div>
        <div class="modal-body">
            <div><span style="font-weight: bold;">Nota:</span> El código resaltado en color indica la identificación de la reseña en caso de que no posea cédula de identidad</div>
            <table id="tblconsulta" class="tabla table dataTable table-striped table-bordered dt-responsive nowrap jambo_table bulk_action"  cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Foto</th>
                        <th>Cédula</th>
                        <th>Nombres y Apellidos</th>
                        <th>Apodo</th>
                        <th>Consulta</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th style="color:white;">Foto</th>
                        <th>Cédula</th>
                        <th>Nombres y Apellidos</th>
                        <th>Apodo</th>
                        <th style="color:white;">Consulta</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php
                    $i = 1;
                    foreach ($lista_resena as $lista) {
                        ?>
                        <tr id="<?php echo $lista->id ?>">
                            <td>
                                <?php
               
                                if (isset($lista->ruta_file)) {
                                    
                                    ?>
                                <a class="ejemplo_1" href="<?php echo base_url() . "assets/$lista->ruta_file"; ?>" title="<?php echo $lista->nombres . ' ' . $lista->apellidos." N° de indentificación: ".$lista->codigo ?>">
                                        <img src="<?php echo base_url() . "assets/$lista->ruta_file"; ?>" width="35px" style="text-align: center;"/>
                                    </a> 
                                   
                                <?php } else { ?>
                                
                                     <img title="No posee imagen de perfil..." src="<?php echo base_url() . "assets/images/default_avatar_male.jpg"; ?>" width="35px" style="text-align: center;cursor: pointer;"/>
                                <?php } ?>
                            </td>
                            <td>
                                <?php if ($lista->ci == $lista->codigo) { ?>
                                    <span class="label label-warning" style="font-weight: bold;"><?php echo $lista->ci ?></span>
                                <?php } else { ?>
                                    <?php echo $lista->ci ?>
                                <?php } ?>
                            </td>
                            <td><?php echo $lista->nombres . ' ' . $lista->apellidos ?></td>
                            <td><?php echo $lista->apodo; ?></td>
                            <td>
                                <span id="<?php echo $lista->ci ?>" class="pdf_resena" style="cursor:pointer">
                                    <i  class="fa fa-file-pdf-o fa-2x"></i>
                                </span>
                            </td>
                        </tr>
                        <?php
                        $i++;
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>

<!-- FIN PROCESO -->

<script>
    $(document).ready(function () {





        $('#tblconsulta').dataTable({
            "language": {
                "sProcessing": "Procesando...",
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sZeroRecords": "No se encontraron resultados",
                "sEmptyTable": "Ningún dato disponible en esta tabla",
                "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix": "",
                "sSearch": "Buscar:",
                "sUrl": "",
                "sInfoThousands": ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sLast": "Último",
                    "sNext": "Siguiente",
                    "sPrevious": "Anterior"

                },
                "oAria": {
                    "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"

                }

            }



        });



        // Setup - add a text input to each footer cell
        $('#tblconsulta tfoot th').each(function () {
            var title = $(this).text();

            if (title !== "Foto" && title !== "Consulta") {
                $(this).html('<input type="text" placeholder="Buscar ' + title + '" id="' + title + '" aria-controls="tblconsulta"/>');
            }
        });

        var table = $('#tblconsulta').DataTable();

        // Apply the search
        table.columns().every(function () {
            var that = this;

            $('input', this.footer()).on('keyup change', function () {
                if (that.search() !== this.value) {
                    that
                            .search(this.value)
                            .draw();
                }
            });

        });


        $('.pdf_resena').click(function (event) {
            var cedula = $(this).attr('id');
            var url = base_url('reportes/reporte/resena?ci=' + cedula);
            window.open(url)
        });

        $('a.consulta_pers').click(function (event) {
            $('div#div_consulta').modal('show');
        });
    });
</script>
