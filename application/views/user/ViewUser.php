<?php
if (isset($_REQUEST['error']) == "1") {

  $warning = '<div class="alert alert-dismissible alert-danger" style="width:300px;color:#3B542F;margin: auto">';
  $warning .= 'Disculpe, debe iniciar sesión';
  $warning .= '</div>';
} else {
  $warning = "";
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/png" href='<?php echo base_url("assets/image/$row->avatar"); ?>' />
  <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/fancybox/jquery.fancybox.css'); ?>">
  <script src="<?php echo base_url('assets/js/jquery-1.11.2.min.js'); ?>"></script>
  <script src="<?php echo base_url('assets/js/bootbox.js'); ?>"></script>
  <script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
  <script src="<?php echo base_url('assets/js/fancybox/jquery.fancybox.js'); ?>"></script> 
  <script>
    function inicia(){
            		//e.preventDefault();  // Para evitar que se envíe por defecto

                if ($('#username').val().trim() == '') {
                  bootbox.alert("Ingrese el usuario", function () {
                  }).on('hidden.bs.modal', function (event) {
                    $("#username").parent('div').addClass('has-error');
                    $("#username").focus();
                  });
                } else if ($('#password').val().trim() == '') {
                  bootbox.alert("Ingrese la contraseña", function () {
                  }).on('hidden.bs.modal', function (event) {
                    $("#password").parent('div').addClass('has-error');
                    $("#password").focus();
                  });
                } else {

                  $.post('<?php echo base_url(); ?>ControllersUser/iniciar', $('#form_login').serialize(), function (response) {

                    if (response == 1) {
                      url = "<?php echo base_url('dashboard'); ?>"
                      window.location = url;

                    } else if (response == 2) {
					  
                      if($("#is_active").val() == "f"){
						  $('div#div-send-notifications').modal({backdrop: 'static', keyboard: false})
					  }else{
						  bootbox.alert("Usuario y Contraseña Invalidos", function () {
						  }).on('hidden.bs.modal', function (event) {

						  });
					  }
                      
                    } else {
                      bootbox.alert("Usuario y Contraseña Invalidos", function () {
                      }).on('hidden.bs.modal', function (event) {

                      });
                    }
                  },'json');
                }
              }
              $(document).ready(function () {

                // Manual
                $("#show-manual").click(function () {
                  var manual = $("#manual").val();
                  window.open(manual, '_blank')
                });

                $("input#iniciar").attr('onclick','inicia();');
                var avatar_login = "<?php echo isset($row->avatar_login) ? $row->avatar_login: "camera.png"; ?>";
                $('body').css('background-image', 'url(assets/foto/' + avatar_login.trim() + ')');

                $("form").keypress(function (e) {
                  if (e.which == 13) {
                    inicia();
                  }
                });
                
                $("#notifications").click(function (e) {
					
					if ($('#comentario').val().trim() == '') {
					  bootbox.alert("Ingrese un comentario", function () {
					  }).on('hidden.bs.modal', function (event) {
						$("#comentario").parent('div').addClass('has-error');
						$("#comentario").focus();
					  });
					  
					  return true;
					}
					
					$.post('<?php echo base_url(); ?>ControllersUser/send_notifications', $('#frmnotifications').serialize(), function (res) {
						
						if(res.r == "existe"){
							bootbox.alert(res.m, function () {
							  }).on('hidden.bs.modal', function (event) {
								$('div#div-send-notifications').modal('hide');
								$("#comentario").val("");
							  });
						}else{
							bootbox.alert(res.m, function () {
						  }).on('hidden.bs.modal', function (event) {
							$('div#div-send-notifications').modal('hide');
							$("#comentario").val("");
						  });
						}
					}, 'json');
				});

                

                // Busqueda de la foto segun el usuario
                $(".busqueda").change(function (e) {
                  var $username = $(this).val();
                  $.get('<?php echo base_url(); ?>ControllersUser/picture', {username: $username}, function (data) {
					  
					$("#pk_user").val(data.id);
					$("#is_active").val(data.is_active);
					
					
					if($("#is_active").val() == "f"){
						$("div#menssage-acount").show();
					}
					
					

                    if (data == null) {
                      foto = '<img class="modal-content bg-foto" src="<?php echo base_url("assets/foto/usuario/usuario.png");?>" style="width: 80px; height: 80px;"/>';
                      $("#remember").prop("disabled",true);
                    } else if($username != ""){
                      foto = '<img class="modal-content bg-foto" src="<?php echo base_url("assets/foto/usuario/'+data.foto+'");?>" style="width: 80px; height: 80px;"/>';
                      $("#remember").prop("disabled",false);
                    } else {
                      foto = '<img class="modal-content bg-foto" src="<?php echo base_url("assets/foto/usuario/usuario.png");?>" style="width: 80px; height: 80px;"/>';
                      $("#remember").prop("disabled",true);
                    }
                    $(".div_foto").html(foto);
                  }, 'json');

                });

                $("input#remember").click(function () {
                  var $remember = $("#remember").is(':checked');
                  var $username = $("#username").val();
                  
                  if ($remember == true) {
                   
                   bootbox.confirm("¿Está seguro de procesar la información?", function(result) {
                    if(result == true){
                     $.ajax({
                      url: 'ControllersUser/remember_password/'+$username,
                      type: "post",
                      dataType: "html",
                      cache: false,
                      contentType: false,
                      processData: false
                    }).done(function(res){
                      if(res == 1){
                       setTimeout(function(){
                        bootbox.alert("Se ha recuperado su contraseña...");
                        $("#remember").prop("disabled",true);
                      }, 2000);
                     }
                   });
                  }
                });
                 }
               });
              });
              
              

            </script>
          </head>
          <style type="text/css">
			  
			  .content-not{
				display: block;
				margin-top: -89%;
				height: 377px;
			  }
    /*---
Author: W3layouts
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
----*/
/* reset */
html,body,div,span,applet,object,iframe,h1,h2,h3,h4,h5,h6,p,blockquote,pre,a,abbr,acronym,address,big,cite,code,del,dfn,em,img,ins,kbd,q,s,samp,small,strike,strong,sub,sup,tt,var,b,u,i,dl,dt,dd,ol,nav ul,nav li,fieldset,form,label,legend,table,caption,tbody,tfoot,thead,tr,th,td,article,aside,canvas,details,embed,figure,figcaption,footer,header,hgroup,menu,nav,output,ruby,section,summary,time,mark,audio,video{margin:0;padding:0;border:0;font-size:100%;font:inherit;vertical-align:baseline;}
article, aside, details, figcaption, figure,footer, header, hgroup, menu, nav, section {display: block;}
ol,ul{list-style:none;margin:0px;padding:0px;}
blockquote,q{quotes:none;}
blockquote:before,blockquote:after,q:before,q:after{background:'';background:none;}
table{border-collapse:collapse;border-spacing:0;}
/* start editing from here */
a{text-decoration:none;}
.txt-rt{text-align:right;}/* text align right */
.txt-lt{text-align:left;}/* text align left */
.txt-center{text-align:center;}/* text align center */
.float-rt{float:right;}/* float right */
.float-lt{float:left;}/* float left */
.clear{clear:both;}/* clear float */
.pos-relative{position:relative;}/* Position Relative */
.pos-absolute{position:absolute;}/* Position Absolute */
.vertical-base{ vertical-align:baseline;}/* vertical align baseline */
.vertical-top{  vertical-align:top;}/* vertical align top */
nav.vertical ul li{ display:block;}/* vertical menu */
nav.horizontal ul li{   display: inline-block;}/* horizontal menu */
img{max-width:100%;}
/*end reset*/
* { box-sizing: border-box; padding:0; margin: 0; }

body {
 /* Ubicación de la imagen */
 /*background-image: url("<?php echo base_url('assets/image/login_home.jpg'); ?>");*/
	  /* Nos aseguramos que la imagen de fondo este centrada vertical y

   horizontalmente en todo momento */
   background-position: center center;
   /* La imagen de fondo no se repite */
   background-repeat: no-repeat;
	  /* La imagen de fondo está fija en el viewport, de modo que no se mueva cuando

    la altura del contenido supere la altura de la imagen. */
    background-attachment: fixed;
	  /* La imagen de fondo se reescala cuando se cambia el ancho de ventana
    del navegador */
    background-size: cover;
	  /* Fijamos un color de fondo para que se muestre mientras se está
   cargando la imagen de fondo o si hay problemas para cargarla  */
   background-color: #464646;
   height: 100%;
 }

 .main{
  margin:13em auto 0;
  width: 22%;
}
form {
  background:#0A192A;
  border-radius:0.4em;
  border:1px solid #0A192A;
  overflow:hidden;
  position:relative;
  box-shadow: 0 5px 10px 5px rgba(0,0,0,0.2);
}

form:after {
  content:"";
  display:block;
  position:absolute;
  height:1px;
  width:100px;
  left:20%;
  top:0;
}

form:before {
  content:"";
  display:block;
  position:absolute;
  width:8px;
  height:5px;
  border-radius:50%;
  left:34%;
  top:-7px;
  box-shadow: 0 0 6px 4px #fff;
}

.inset {
 padding:20px; 
 border-top:1px solid #000;
}

form h1{
  text-align:center;
  padding:18px 0;
  border-bottom:1px solid #000;
  position:relative;
}
form h1:after {
 content:"";
 display:block;
 width:250px;
 height:100px;
 position:absolute;
 top:0;
 left:50px;
 pointer-events:none;
 -webkit-transform: rotate(70deg);
 background: linear-gradient(50deg, rgba(255,255,255,0.15), rgba(0,0,0,0));
 
}

form h1  {
  color:#fff;
  text-shadow:0 1px 0 #000;
  font-size:18px;
  font-weight: 600;
  text-align:center;
  padding:18px 0;
  border-bottom:1px solid #000;
  position:relative;
  
}
form h1 span{
  padding:5px;
  background:#0184ff;
}
label {
  color:rgba(137, 192, 243, 0.8);
  display:block;
  font-size:13px;
  padding-bottom:9px;
}

input[type=text],
input[type=password] {
  font-family: 'Open Sans', sans-serif;
  width:100%;
  padding:8px 5px;
  background: rgb(167,167,167); /* Old browsers */
  background: -moz-linear-gradient(top,  rgba(167,167,167,1) 0%, rgba(181,181,181,1) 21%, rgba(228,228,228,1) 79%, rgba(242,242,242,1) 100%); /* FF3.6+ */
  background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(167,167,167,1)), color-stop(21%,rgba(181,181,181,1)), color-stop(79%,rgba(228,228,228,1)), color-stop(100%,rgba(242,242,242,1))); /* Chrome,Safari4+ */
  background: -webkit-linear-gradient(top,  rgba(167,167,167,1) 0%,rgba(181,181,181,1) 21%,rgba(228,228,228,1) 79%,rgba(242,242,242,1) 100%); /* Chrome10+,Safari5.1+ */
  background: -o-linear-gradient(top,  rgba(167,167,167,1) 0%,rgba(181,181,181,1) 21%,rgba(228,228,228,1) 79%,rgba(242,242,242,1) 100%); /* Opera 11.10+ */
  background: -ms-linear-gradient(top,  rgba(167,167,167,1) 0%,rgba(181,181,181,1) 21%,rgba(228,228,228,1) 79%,rgba(242,242,242,1) 100%); /* IE10+ */
  background: linear-gradient(to bottom,  rgba(167,167,167,1) 0%,rgba(181,181,181,1) 21%,rgba(228,228,228,1) 79%,rgba(242,242,242,1) 100%); /* W3C */
  filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#a7a7a7', endColorstr='#f2f2f2',GradientType=0 ); /* IE6-9 */
  border:1px solid #222;
  box-shadow:0 1px 0 rgba(255,255,255,0.1);
  border-radius:0.3em;
  margin-bottom:20px;
  color: #000;
  font-size:15px;
  outline: none;
}
label[for=remember]{
  color:#fff;
  display:inline-block;
  font-size: 13px;
}

input[type=checkbox] {
  display:inline-block;
  vertical-align:middle;
}

.p-container {
  padding:0 20px 20px 20px; 
}

.p-container:after {
  clear:both;
  display:table;
  content:"";
}

.p-container span a {
  font-size:14px;
  display:block;
  float:left;
  color:#0d93ff;
  padding-top: 4px;
}

.bg{
  background-color: rgb(0,0,255); opacity: 0.8;
}
.bg-foto{
  background-color: rgb(0,0,255); opacity: normal;
}

/**start-copy-right**/
.copy-right {
  text-align: center;
}
.copy-right p {
  color: #FFF;
  font-size:1em;
  padding:6em 0;
}
.copy-right p a {
  font-size:1em;
  font-weight:600;
  color:#061A3D;
  -webkit-transition: all 0.3s ease-out;
  -moz-transition: all 0.3s ease-out;
  -ms-transition: all 0.3s ease-out;
  -o-transition: all 0.3s ease-out;
  transition: all 0.3s ease-out;
}
.copy-right a:hover{
  color:#fff;
}
/**//end-copy-right**/
/*----start-responsive design-----*/
@media only screen and (max-width:1680px) {
  .main{
    margin:15em auto 0;
  }
  .copy-right p {
    padding: 0em 0;
  }
}
@media only screen and (max-width:1440px)  {
  .main{
    margin:11em auto 0;
    width:24%;
  }
  .copy-right p {
    padding:3em 0;
  }
}
@media only screen and (max-width:1366px) {
  .main{
    margin:10em auto 0;
    width:25%;
  }
  .copy-right p {
    padding:3.5em 0;
  }
}
@media only screen and (max-width:1280px) {
  .main{
    margin:11em auto 0;
    width: 27%;
  }
  .copy-right p {
    padding:4.3em 0;
  }
}
@media only screen and (max-width:1024px)  {
  .main{
    margin:12em auto 0;
    width:33%;
  }
  .copy-right p {
    padding:6em 0;
  }
}
@media only screen and (max-width:768px) {
  .main{
    margin: 14em auto 0;
    width: 43%;
  }
  .copy-right p {
    padding:6em 0;
  }
}
@media only screen and (max-width:640px) {
  .main{
    margin:14em auto 0;
    width:51%;
  }
  .copy-right p {
    padding:6em 0;
  }
}
@media only screen and (max-width:480px)  {
  .main{
    margin: 12em auto 0;
    width: 68%;
  }
  .copy-right p {
    padding:6em 0;
  }
}
@media only screen and (max-width:320px) {
  .main{
    margin:7em auto 0;
    width:96%;
  }
  .copy-right p {
    padding:1em 0;
  }
}

/*----//end-responsive design-----*/
</style>
<body>
  <title>SAPP <?= date('Y', now()) ?></title>
  <div class="col-xs-12">
	  <div class="main modal-content bg">
		<form id="form_login" act1ion="" method="POST">
		  <div style='text-align:center;margin:5%' class="div_foto">
			<img class="modal-content bg-foto" src="<?php echo base_url("assets/foto/usuario/usuario.png");?>" style="width: 80px; height: 80px;margin: 4%;margin-top: 1%;"/>
			<div class='alert alert-danger' style='display:none;' id='menssage-acount'>
				Se está procesando su solicitud para la activación en el sistema
			</div>
		  </div>
		  <div class="inset">
        <p>
       <label for="username">Manual de referencia</label>
       <div style="float: left;">
         <select class="form-control" id="manual" style="width: 150%;">
           <option value="<?php echo base_url('/assets/manual/GESTION.pdf')?>">Manual de Gestión</option>
         </select>
       </div>
       <div style="float: left;">
        <input style="width: 100%;margin-left: 157%;" type="button" class="btn btn-success" id="show-manual" value="PDF">
       </div>
       </p>
       <br>
       <br>
       <br>
			<p>
			 <label for="username">Usuario</label>
			 <input id='username' autofocus name='username' type="text" placeholder="Usuario" class='form-control busqueda'/>
		   </p>
		   <p>
			<label for="password">Contraseña</label>
			<input id='password' name='password' type="password" placeholder="Contraseña" class='form-control'/>
		  </p>
		  <!--<p>
			<input type="checkbox" id="remember" disabled>
			<label for="remember">¿Olvido su contraseña?</label>
		  </p>-->
		  <div class="col-xs-12">
			<input style="width: 100%;" type="button" class="btn btn-info" id="iniciar" value="Ingresar al sistema">
			<br/><br/>
		  </div>
		</div>
	  </form>
	</div> 
  </div>
</div>

<div class="modal fade" id="div-send-notifications" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<form method="post" enctype="multipart/form-data" id="frmnotifications">
					<div class="col-xs-12">
						<div class='alert alert-danger'>Usuario inactivo, a continuación ingrese el comentario para la activación de la cuenta en el Sistema</div>
						<input type='hidden' id='pk_user' name='pk_user'/>
						<input type='hidden' id='is_active' name='is_active'/>
						<textarea class='form-control' style='height: 250px;margin-top: 13%;text-transform:uppercase;' onblur="javascript:this.value = this.value.toUpperCase();" id='comentario' name='comentario'></textarea>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<input style="width: 100%;" type="button" class="btn btn-success" id="notifications" value="Enviar">                   
			</div>
		</div>
	</div>
</div>

  
  
<!-----start-copyright---->
<div class="copy-right">
  <p>Gerencia de Desarrollo y Aplicaciones 2016</p> 
</div>
<!-----//end-copyright---->
</body>
</html>
