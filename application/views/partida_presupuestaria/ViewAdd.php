<?php
    if (isset($this->session->userdata['logged_in'])) {
        $username = ($this->session->userdata['logged_in']['username']);
        $id = ($this->session->userdata['logged_in']['id']);
    } else {
        $header = base_url();
        header("location: ".$header);
    }
?>
<script>
    $(document).ready(function () {
        
        $("select").select2();
        
        $('#partida_presupuestaria,#partida_padre').alpha({allow:" -.,"});
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

                $.post('<?php echo base_url(); ?>partida_presupuestaria/ControllersPartidaPresupuestaria/guardar', $('#form_partida_presupuestaria').serialize(), function (response) {
                    
                    if (response == '1') {
                        
                        bootbox.alert("Disculpe, ya existe un código o una partida Presupuestaria registrado, verifique los datos ", function () {
                        }).on('hidden.bs.modal', function (event) {
                            $("#partida_presupuestaria,#codigo").parent('div').addClass('has-error');
                            $("#partida_presupuestaria,#codigo").focus();
                        });
                        
                    }else{
                        bootbox.alert("Se registro con exito", function () {
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
<style type="text/css">
    .fancybox-overlay-fixed {
        z-index: 1000
    }
    .fancybox-inner {
        overflow: hidden;
        width:auto !important;
        margin: 15px !important;
        margin-left: 5px !important;
		}
		
		.fancybox-skin {
			position: relative;
			background: #f9f9f9;
			color: #444;
			width:1024px !important;
			text-shadow: none;
            margin-left: -170px !important;
			-webkit-border-radius: 4px;
			   -moz-border-radius: 4px;
					border-radius: 4px;
		}
		
		.fancybox-inner fancybox_img {
			overflow: hidden;
			width: 300px !important;
			margin: 15px !important;
			margin-left: 5px !important;
		}
		
		.fancybox-skin fancybox_img {
			position: relative;
			background: #f9f9f9;
			color: #444;
			width:300px !important;
			text-shadow: none;
			-webkit-border-radius: 4px;
			   -moz-border-radius: 4px;
					border-radius: 4px;
		}
</style>
<br/>
<br/>
<br/>
<br/>
<form id='form_partida_presupuestaria' action="" method="POST">
    <div style="width: 95%;text-transform:uppercase;box-shadow: 0 1px 5px rgba(0,0,0,.85);margin: auto;" class="panel panel-default">
        <div class="panel-heading" style='background: linear-gradient(#2F9292, #3B7272);color:#FFFFFF;' >
            <label style="float: left" class="panel-title " ><a  href="<?php echo base_url();?>partida_presupuestaria/ControllersPartidaPresupuestaria" >Configuraciones</a>
                > Registrar Partida Presupuestaria</label>
            <br>
        </div>
        <fieldset><legend class="titulo text-center">Datos de la Partida Presupuestaria</legend></fieldset>
        <div class="panel-body">
            <div class="col-xs-1" >Código</div>
            <div class="col-xs-4">
                <input id="codigo" style="width: 100%;text-transform:uppercase;" onblur="javascript:this.value = this.value.toUpperCase();" placeholder="Ingrese el código" name="codigo" type="text" class="form-control" />
            </div>
            <div class="col-xs-2" >Nombre de la partida</div>
            <div class="col-xs-4">
                <input id="partida_presupuestaria" style="width: 100%;text-transform:uppercase;" onblur="javascript:this.value = this.value.toUpperCase();" placeholder="Ingrese la Partida Presupuestaria" name="partida_presupuestaria" type="text" class="form-control" />
            </div>
        </div>
        <br/>
        <div class="row" style="text-align: center">
            <a href="<?php echo base_url();?>partida_presupuestaria/ControllersPartidaPresupuestaria">
                <button type="button" id="volver" style="font-weight: bold;font-size: 13px" class="btn btn-warning " >
                    &nbsp;<span class="glyphicon glyphicon-chevron-left"></span>&nbsp;Volver
                </button>
            </a>
            <input type="submit" id="registrar" style="font-weight: bold;font-size: 13px" class="btn btn-success" value="Guardar cambios"/>
            <button type="reset" id="limpiar" style="font-weight: bold;font-size: 13px; background: -moz-linear-gradient(#f4eb2f, #e5a32d); color: white " class="btn"/>
            &nbsp;<span class="glyphicon glyphicon-retweet"></span>&nbsp;&nbsp;Limpiar
            </button>
            
        </div>
        <br/>
    </div>
</form>
