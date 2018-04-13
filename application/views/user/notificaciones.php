
<script>
    $(document).ready(function () {
		
		$.sonido("mensaje"); // Seteamos los contenedores para los mensajes a emitir
		
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
            
            send_email = '<a class="get-email" id='+o.correo+' name="'+o.nom_organo+'" >';
                send_email += '<img style="width:25px;height: 25px" src="<?php echo base_url("assets/image/email.png"); ?>"/>';
            send_email += '</a>';

            // `o` is the original data object for the row
            var format_string =  '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+
                
                '<tr>'+
                    '<td>Estátus:</td>'+
                    '<td>'+is_active+'</td>'+
                '</tr>'+
                '<tr>'+
                    '<td>Respuesta:</td>'+
                    '<td>'+send_email+'</td>'+
                '</tr>'+
            '</table>';
            
            return format_string;
        }
        
        $(document).ready(function() {
            var table = $('#tab_user').DataTable( {
                "iDisplayLength": 10,
                "iDisplayStart": 0,
                "sPaginationType": "full_numbers",
                "aLengthMenu": [25, 50, 75, 100],
                "oLanguage": {"sUrl": "<?php echo base_url(); ?>/assets/js/es.txt"},
                "ajax": "<?php echo base_url();?>ControllersUser/notifications",
                "columns": [
                    {
                        "className":      'details-control',
                        "orderable":      true,
                        "data":           null,
                        "defaultContent": ''
                    },
                    { "data": "username"  },
                    { "data": "nom_organo"  },
                    { "data": "comentario"  },
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
        
        
        $("table#tab_user").on('click', 'a.get-email', function (e) {
            var correo = this.getAttribute('id');
            var name = this.getAttribute('name');
            $('div#div_send_email').modal({backdrop: 'static', keyboard: true});
            $("#email").val(correo);
            $("#nom_organo").val(name);
            
         });
         
         $("button.send-email").on('click', function (e) {
			 var nom_organo = $("#nom_organo").val();
			 var respuesta = $("#respuesta").val();
			 if(respuesta.trim() == ""){
				 bootbox.alert("Ingrese la repuesta", function () {
				 });
				return true;
			 }
			 
			 $.post('<?php echo base_url(); ?>ControllersUser/enviar_correo', $('#frmemail').serialize(), function (res) {
				 if(res.success == "ok" ){
					 
					 ion.sound.play("mensaje"); // Accion para notiificar un mensaje de voz para el envio de mensajes
					 
					 bootbox.alert("Se envio el correo electrónico para "+nom_organo, function () {
						}).on('hidden.bs.modal', function (event) {
							url = $(location).attr('href');
							window.location = url;
						});
				 }
			 },'json');
		 });

        // Validacion respectiva para la actualizacion de los datos(1)
        $("table#tab_user").on('click', 'a.cambio', function (e) {
            var id = this.getAttribute('id');
            var status = this.getAttribute('name');
            
            if (status == "t") {
                status = false;
            } else {
                status = true;
            }

            bootbox.dialog({
                message: "¿Desea habilitar el usuario en el sistema?",
                title: "Habilitar",
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

                            $.get('<?php echo base_url(); ?>ControllersUser/change_status',{id:id, is_active: status}, function (response) {
								
                                bootbox.alert("Se actualizo con exito", function () {
                                }).on('hidden.bs.modal', function (event) {
                                    url = $(location).attr('href');
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
        <table style="width:100%;" border="0" align="center" cellspacing="1" id="tab_user" align="center"
               class="table table-bordered table-striped table-hover table-condensed dt-responsive table-responsive" style="width:30%">
            <thead style="font-size: 16px">
                <tr style="background-color: #263238">
                    <th style='text-align: center;color: white' colspan="15">Solicitud de activación de cuenta</th>
                </tr>
                <tr style="background-color: #8BA8A7">
                    <th></th>
                    <th style='text-align: center;'>Usuario</th>
                    <th style='text-align: center;'>Órgano u Ente</th>
                    <th style='text-align: center;width:50%;'>Comentario</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>

<!-- Inicio envio de respuesta -->

<div class="modal fade" id="div_send_email" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<form method="post" enctype="multipart/form-data" id="frmemail">
					<div class="col-xs-12">
						<div class="form-group col-xs-12" style="margin:auto;">
							<label>Respuesta</label>
							<input type='hidden' id='email' name='correo' />
							<input type='hidden' id='nom_organo' name='nom_organo' />
							<textarea class="form-control" id='respuesta' name='respuesta' style='width:100%;height: 148px;'></textarea>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer" style='margin-top:25%;'>
				<button type="button" class="btn btn-sm btn-success send-email">Enviar</button>
				<button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>

<!-- Fin envio de respuesta -->


