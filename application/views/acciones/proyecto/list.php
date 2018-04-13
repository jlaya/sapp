
<head>
    <link rel="icon" type="image/png" href="<?php echo base_url('assets/image/Home.png'); ?>" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/pnotify.custom.min.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap.theme.css'); ?>">   
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/select2.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/select2-bootstrap.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/dataTables.responsive.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/dataTables.bootstrap.css'); ?>">
</head>
<div class="row">
	<div style='color:000000;text-transform: uppercase;margin-left: 1%;' class='alert alert-info'>Al momento de ingresar el monto se toma los puntos decimales automaticamente, Ejempo: 0.000.000.000,00</div>
    <form id="frm" method="POST">
        <input type="hidden" value="<?php echo $id;?>" id="accion_id" name="accion_id" />
        <input type="hidden" id="id" name="id" />
        <div class="panel-body">
        <div class="col-xs-8">
            <select style="width:102%;" class="form-control" id="partida_id" name="partida_id">
                    <option value="0">Seleccione</option>
                    <?php foreach ($estructura as $key => $value) { ?>
                    <option value="<?php echo $value->id;?>"><?php echo "<span style='font-weight:bold;'>".$value->partida."</span> &nbsp;".$value->descripcion;?></option>
                    <?php }?>
                </select>
            </div>
            <div class="col-xs-2">
                <input style="text-align: right; width: 120%;" class="form-control" type="text" id="compromiso" name="compromiso" />
            </div>
            <div class="col-xs-2">
                <input type="submit" value="Guardar" class="btn btn-primary guardar" style="margin-left: 20%">
            </div>
        </div>
        
    </form>

    <div class="panel-body">
        <div class="form-inline">
            
                
        <div class="form-group col-xs-12">
            <fieldset>
            <legend>EJECUCIÓN FINANCIERA</legend>
                <table id="table-gestion-financiera" class="table-gestion-financiera table-bordered table-striped table-hover table-condensed dt-responsive table-responsive" style="width: 100%;">
                <thead>
                    <tr style="width: 963.75px !important;">
                        <th style='width:75% !important;'>
                            Partida
                        </th>
                        <th>Monto</th>
                        <th style='width:5% !important; text-align: right;'>Acción</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($obj as $key => $value) { ?>
                        <tr data-id="<?php echo $value->id;?>" data-partida="<?php echo $value->partida_id;?>" data-monto="<?php echo str_replace('', '', number_format($value->compromiso, 2, ",", "."));?>">
                            <td>
                                <?php echo "<span style='font-weight:bold;'>".$value->estructura."</span> &nbsp;".$value->partida;?>
                            </rd>
                            <td style="text-align: right;">
                                <?php echo str_replace('', '', number_format($value->compromiso, 2, ",", "."));?>
                            </td>
                            <td style="text-align: center; width: 10%;">
                                <span title="Guadar" class="btn btn-info glyphicon glyphicon-pencil edit-row"></span>
                                <span title="Eliminar" class="btn btn-danger glyphicon glyphicon-trash delete-row"></span>
                            </td>
                        </tr>
                    <?php  }?>
                    </tbody>
                </table>
            </fieldset>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url('assets/js/jquery-1.11.2.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/pnotify.custom.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.blockUI.js'); ?>"></script>

<script src="<?php echo base_url('assets/js/bootstrap.js'); ?>"></script>

<script src="<?php echo base_url('assets/js/datatable-edit/jquery.dataTables.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/datatable-edit/dataTables.buttons.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/datatable-edit/dataTables.select.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/bootbox.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/apprise.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/alphanumeric.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/script.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/select2.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/select2_locale_es.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/bootstrap-datepicker.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/bootstrap-datepicker.es.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/dataTables.bootstrap.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/maskedinput.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/tooltips.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/fileinput.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/url.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/librerias.js'); ?>"></script>
<script>
    $(document).ready(function () {
        $("select").select2();
        
        $( "#compromiso" ).on({
			  "focus": function (event) {
				  $(event.target).select();
			  },
			  "keyup": function (event) {
				  $(event.target).val(function (index, value ) {
					  return value.replace(/\D/g, "")
								  .replace(/([0-9])([0-9]{2})$/, '$1,$2')
								  .replace(/\B(?=(\d{3})+(?!\d)\.?)/g, ".");
				  });
			  }
		  });

        var table = $('.table-gestion-financiera').DataTable({
            "pageLength": 5,
            "iDisplayLength": 10,
            "iDisplayStart": 0,
            "sPaginationType": "full_numbers",
            "aLengthMenu": [5,  10, 15, 25, 30, 35, 40, 45, 50, 100],
            "oLanguage": {"sUrl": assets_url('assets/js/es.txt')},
            "order": [[1, "desc"]],
        });

        // Guardar
        $("input.guardar").click(function (e) {
            e.preventDefault();

            if ($('#partida_id').val() == 0) {

                bootbox.alert("Seleccione la partida presupuestaria", function () {
                }).on('hidden.bs.modal', function (event) {
                    $("#partida_id").parent('div').addClass('has-error');
                    $("#partida_id").select2('open');
                });

            } else if ($('#compromiso').val().trim() == '') {
                bootbox.alert("Ingrese el monto", function () {
                    $('.nav-tabs a[href=#tabs_identificacion]').tab('show');
                }).on('hidden.bs.modal', function (event) {
                    $("#compromiso").parent('div').addClass('has-error');
                    $("#compromiso").focus();
                });
            }else{

                $.post('<?php echo base_url(); ?>acciones/proyecto/ControllersProyecto/save', $('#frm').serialize(), function (response) {

                    bootbox.alert("Ingreso exito", function () {
                    }).on('hidden.bs.modal', function (event) {
                        location.reload();
                    });

                });
            }
        });

        // Detail
        $('.table-gestion-financiera tbody').on('click', 'span.edit-row', function () {
            var $id      = $(this).closest('tr').data('id');
            var $partida = $(this).closest('tr').data('partida');
            var $monto   = $(this).closest('tr').data('monto');
            $("#id").val($id);
            $("#partida_id").select2("val",$partida);
            $("#compromiso").val($monto);
        });

        // Borrar
        $('.table-gestion-financiera tbody').on('click', 'span.delete-row', function () {

            var $url = base_url("/acciones/proyecto/ControllersProyecto/deleteActionFAcc");
            var $id   = $(this).closest('tr').data('id');
            var $param_name = $(this).closest('tr').attr('param-name');
            var $this = $(this);

            if($param_name == "new-row"){

                table
                .row($this.parents('tr'))
                .remove()
                .draw();

            }else {

                $.get($url,{id:$id}, function (response) {
                    if(response.success == "ok"){
                        new PNotify({
                            title: 'Gestión de Control',
                            text: "Registro borrado con exito...",
                            type: 'info',
                        });
                        location.reload();
                    }
                },'json');
            }
        });
    });

</script>
