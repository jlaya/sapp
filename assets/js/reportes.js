$(document).ready( function () {
	$("#id_reportes").attr('class','active');
	// Validación del campo 'id_tipo_rep' al cargar la página
	if ($("#id_tipo_rep").val() == '' ){
		$("#reporte_lista_agremiados").hide();
		$("#reporte_grafico_agremiados").hide();
		$("#opcion_categoria2").hide();
		$("#id_categoria").val('')
		$("#id_categoria2").val('')
		$("#opcion_categoria").hide();
		$("#opcion_sexo").hide();
		$("#opcion_status").hide();
		$("#opcion_habitacional").hide();
		$("#opcion_partido").hide();
		$("#opcion_elector").hide();
		$("#opcion_discapacidad").hide();
		$("#opcion_estado").hide();
		$("#opcion_municipio").hide();
		$("#opcion_parroquia").hide();
		// Ocultamos los contenedores superior e inferior
		$('#contenedor_superior').hide();
		$('#contenedor_inferior').hide();
	}else if ($("#id_tipo_rep").val() == 'lista' ){
		$("#reporte_lista_agremiados").show();
		$("#reporte_grafico_agremiados").hide();
		$("#opcion_categoria").show();
		$("#opcion_categoria2").hide();
		$("#id_categoria2").val('')
		// Ocultamos los contenedores superior e inferior
		$('#contenedor_superior').hide();
		$('#contenedor_inferior').hide();
	}else if ($("#id_tipo_rep").val() == 'grafico' ){
		$("#reporte_lista_agremiados").hide();
		$("#reporte_grafico_agremiados").show();
		$("#id_categoria").val('')
		$("#opcion_categoria").hide();
		$("#opcion_categoria2").show();
		$("#opcion_sexo").hide();
		$("#opcion_status").hide();
		$("#opcion_habitacional").hide();
		$("#opcion_partido").hide();
		$("#opcion_elector").hide();
		$("#opcion_discapacidad").hide();
		$("#opcion_estado").hide();
		$("#opcion_municipio").hide();
		$("#opcion_parroquia").hide();
		$('#contenedor_superior').show();
		$('#contenedor_inferior').show();
	}
	// Validación del campo 'id_tipo_rep' al seleccionar una opción
	$("#id_tipo_rep").change(function() {
		if ($("#id_tipo_rep").val() == '' ){
			$("#reporte_lista_agremiados").hide();  // Botón de lista en PDF
			$("#reporte_grafico_agremiados").hide();  // Botón de gráficos
			$("#opcion_categoria2").hide();
			$("#opcion_categoria").hide();
			$("#id_categoria").val('')
			$("#id_categoria2").val('')
			$("#opcion_sexo").hide();
			$("#opcion_status").hide();
			$("#opcion_habitacional").hide();
			$("#opcion_partido").hide();
			$("#opcion_elector").hide();
			$("#opcion_discapacidad").hide();
			$("#opcion_estado").hide();
			$("#opcion_municipio").hide();
			$("#opcion_parroquia").hide();
			// Ocultamos los contenedores superior e inferior
			$('#contenedor_superior').hide();
			$('#contenedor_inferior').hide();
		}else if ($("#id_tipo_rep").val() == 'lista' ){
			$("#reporte_lista_agremiados").show();  // Botón de lista en PDF
			$("#reporte_grafico_agremiados").hide();  // Botón de gráficos
			$("#opcion_categoria").show();
			$("#opcion_categoria2").hide();
			$("#id_categoria2").val('')
			// Ocultamos los contenedores superior e inferior
			$('#contenedor_superior').hide();
			$('#contenedor_inferior').hide();
		}else if ($("#id_tipo_rep").val() == 'grafico' ){
			$("#reporte_lista_agremiados").hide();  // Botón de lista en PDF
			$("#reporte_grafico_agremiados").show();  // Botón de gráficos
			$("#opcion_categoria").hide();
			$("#opcion_categoria2").show();
			$("#opcion_sexo").hide();
			$("#opcion_status").hide();
			$("#opcion_habitacional").hide();
			$("#opcion_partido").hide();
			$("#opcion_elector").hide();
			$("#opcion_discapacidad").hide();
			$("#opcion_estado").hide();
			$("#opcion_municipio").hide();
			$("#opcion_parroquia").hide();
		}
	});
		
	// Validación del campo 'categoría' al cargar la página
	if ($("#id_categoria").val() == '1' || $("#id_categoria").val() == '') {
		$("#id_rep_sexo").val('')
		$("#id_rep_status").val('')
		$("#id_rep_habitacional").val('')
		$("#id_rep_partido").val('')
		$("#id_rep_elector").val('')
		$("#id_rep_discapacidad").val('')
		$("#id_cod_estado").val('')
		$("#id_cod_municipio").val('')
		$("#id_cod_parroquia").val('')
		$("#opcion_sexo").hide();
		$("#opcion_status").hide();
		$("#opcion_habitacional").hide();
		$("#opcion_partido").hide();
		$("#opcion_elector").hide();
		$("#opcion_discapacidad").hide();
		$("#opcion_estado").hide();
		$("#opcion_municipio").hide();
		$("#opcion_parroquia").hide();
	}else{
	  if ($("#id_categoria").val() == 'sexo') {
		  $("#opcion_estado").hide();
		  $("#opcion_municipio").hide();
		  $("#opcion_parroquia").hide();
		  $("#opcion_discapacidad").hide();
		  $("#opcion_elector").hide();
		  $("#opcion_partido").hide();
		  $("#opcion_habitacional").hide();
		  $("#opcion_status").hide();
		  $("#opcion_sexo").show();  // Campo a mostrar
	  }
	  if ($("#id_categoria").val() == 'status') {
		  $("#opcion_estado").hide();
		  $("#opcion_municipio").hide();
		  $("#opcion_parroquia").hide();
		  $("#opcion_discapacidad").hide();
		  $("#opcion_elector").hide();
		  $("#opcion_partido").hide();
		  $("#opcion_habitacional").hide();
		  $("#opcion_status").show();  // Campo a mostrar
		  $("#opcion_sexo").hide();
	  }
	  if ($("#id_categoria").val() == 's_habitacional_id') {
		  $("#opcion_estado").hide();
		  $("#opcion_municipio").hide();
		  $("#opcion_parroquia").hide();
		  $("#opcion_discapacidad").hide();
		  $("#opcion_elector").hide();
		  $("#opcion_partido").hide();
		  $("#opcion_habitacional").show();  // Campo a mostrar
		  $("#opcion_status").hide();
		  $("#opcion_sexo").hide();
	  }
	  if ($("#id_categoria").val() == 'partido_p_id') {
		  $("#opcion_estado").hide();
		  $("#opcion_municipio").hide();
		  $("#opcion_parroquia").hide();
		  $("#opcion_discapacidad").hide();
		  $("#opcion_elector").hide();
		  $("#opcion_partido").show();  // Campo a mostrar
		  $("#opcion_habitacional").hide();
		  $("#opcion_status").hide();
		  $("#opcion_sexo").hide();
	  }
	  if ($("#id_categoria").val() == 'ins_cne') {
		  $("#opcion_estado").hide();
		  $("#opcion_municipio").hide();
		  $("#opcion_parroquia").hide();
		  $("#opcion_discapacidad").hide();
		  $("#opcion_elector").show();  // Campo a mostrar
		  $("#opcion_partido").hide();
		  $("#opcion_habitacional").hide();
		  $("#opcion_status").hide();
		  $("#opcion_sexo").hide();
	  }
	  if ($("#id_categoria").val() == 'discapcidad') {
		  $("#opcion_estado").hide();
		  $("#opcion_municipio").hide();
		  $("#opcion_parroquia").hide();
		  $("#opcion_discapacidad").show();  // Campo a mostrar
		  $("#opcion_elector").hide();
		  $("#opcion_partido").hide();
		  $("#opcion_habitacional").hide();
		  $("#opcion_status").hide();
		  $("#opcion_sexo").hide();
	  }
	  if ($("#id_categoria").val() == 'localidad') {
		  $("#opcion_estado").show();
		  $("#opcion_municipio").show();
		  $("#opcion_parroquia").show();
		  $("#opcion_discapacidad").hide();  // Campo a mostrar
		  $("#opcion_elector").hide();
		  $("#opcion_partido").hide();
		  $("#opcion_habitacional").hide();
		  $("#opcion_status").hide();
		  $("#opcion_sexo").hide();
	  }
  }
	
  // Validación del campo 'categoría' al seleccionar una opción
  $("#id_categoria").change(function() {
	  if ($("#id_categoria").val() == '1' || $("#id_categoria").val() == '') {
		  $("#id_rep_sexo").val('')
		  $("#id_rep_status").val('')
		  $("#id_rep_habitacional").val('')
		  $("#id_rep_partido").val('')
		  $("#id_rep_elector").val('')
		  $("#id_rep_discapacidad").val('')
		  $("#id_cod_estado").val('')
		  $("#id_cod_municipio").val('')
		  $("#id_cod_parroquia").val('')
		  $("#opcion_sexo").hide();
		  $("#opcion_status").hide();
		  $("#opcion_habitacional").hide();
		  $("#opcion_partido").hide();
		  $("#opcion_elector").hide();
		  $("#opcion_discapacidad").hide();
		  $("#opcion_estado").hide();
		  $("#opcion_municipio").hide();
		  $("#opcion_parroquia").hide();
	  }else{
		  if ($("#id_categoria").val() == 'sexo') {
			  $("#opcion_estado").hide();
			  $("#opcion_municipio").hide();
			  $("#opcion_parroquia").hide();
			  $("#opcion_discapacidad").hide();
			  $("#opcion_elector").hide();
			  $("#opcion_partido").hide();
			  $("#opcion_habitacional").hide();
			  $("#opcion_status").hide();
			  $("#opcion_sexo").show();  // Campo a mostrar
			  /*$("#id_rep_sexo").val('')
			  $("#id_rep_status").val('')
			  $("#id_rep_habitacional").val('')
			  $("#id_rep_partido").val('')
			  $("#id_rep_elector").val('')
			  $("#id_rep_discapacidad").val('')
			  $("#id_cod_estado").val('')
			  $("#id_cod_municipio").val('')
			  $("#id_cod_parroquia").val('')*/
		  }
		  if ($("#id_categoria").val() == 'status') {
			  $("#opcion_estado").hide();
			  $("#opcion_municipio").hide();
			  $("#opcion_parroquia").hide();
			  $("#opcion_discapacidad").hide();
			  $("#opcion_elector").hide();
			  $("#opcion_partido").hide();
			  $("#opcion_habitacional").hide();
			  $("#opcion_status").show();  // Campo a mostrar
			  $("#opcion_sexo").hide();
			  /*$("#id_rep_sexo").val('')
			  $("#id_rep_status").val('')
			  $("#id_rep_habitacional").val('')
			  $("#id_rep_partido").val('')
			  $("#id_rep_elector").val('')
			  $("#id_rep_discapacidad").val('')
			  $("#id_cod_estado").val('')
			  $("#id_cod_municipio").val('')
			  $("#id_cod_parroquia").val('')*/
		  }
		  if ($("#id_categoria").val() == 's_habitacional_id') {
			  $("#opcion_estado").hide();
			  $("#opcion_municipio").hide();
			  $("#opcion_parroquia").hide();
			  $("#opcion_discapacidad").hide();
			  $("#opcion_elector").hide();
			  $("#opcion_partido").hide();
			  $("#opcion_habitacional").show();  // Campo a mostrar
			  $("#opcion_status").hide();
			  $("#opcion_sexo").hide();
			  /*$("#id_rep_sexo").val('')
			  $("#id_rep_status").val('')
			  $("#id_rep_habitacional").val('')
			  $("#id_rep_partido").val('')
			  $("#id_rep_elector").val('')
			  $("#id_rep_discapacidad").val('')
			  $("#id_cod_estado").val('')
			  $("#id_cod_municipio").val('')
			  $("#id_cod_parroquia").val('')*/
		  }
		  if ($("#id_categoria").val() == 'partido_p_id') {
			  $("#opcion_estado").hide();
			  $("#opcion_municipio").hide();
			  $("#opcion_parroquia").hide();
			  $("#opcion_discapacidad").hide();
			  $("#opcion_elector").hide();
			  $("#opcion_partido").show();  // Campo a mostrar
			  $("#opcion_habitacional").hide();
			  $("#opcion_status").hide();
			  $("#opcion_sexo").hide();
			  /*$("#id_rep_sexo").val('')
			  $("#id_rep_status").val('')
			  $("#id_rep_habitacional").val('')
			  $("#id_rep_partido").val('')
			  $("#id_rep_elector").val('')
			  $("#id_rep_discapacidad").val('')
			  $("#id_cod_estado").val('')
			  $("#id_cod_municipio").val('')
			  $("#id_cod_parroquia").val('')*/
		  }
		  if ($("#id_categoria").val() == 'ins_cne') {
			  $("#opcion_estado").hide();
			  $("#opcion_municipio").hide();
			  $("#opcion_parroquia").hide();
			  $("#opcion_discapacidad").hide();
			  $("#opcion_elector").show();  // Campo a mostrar
			  $("#opcion_partido").hide();
			  $("#opcion_habitacional").hide();
			  $("#opcion_status").hide();
			  $("#opcion_sexo").hide();
			  /*$("#id_rep_sexo").val('')
			  $("#id_rep_status").val('')
			  $("#id_rep_habitacional").val('')
			  $("#id_rep_partido").val('')
			  $("#id_rep_elector").val('')
			  $("#id_rep_discapacidad").val('')
			  $("#id_cod_estado").val('')
			  $("#id_cod_municipio").val('')
			  $("#id_cod_parroquia").val('')*/
		  }
		  if ($("#id_categoria").val() == 'discapcidad') {
			  $("#opcion_estado").hide();
			  $("#opcion_municipio").hide();
			  $("#opcion_parroquia").hide();
			  $("#opcion_discapacidad").show();  // Campo a mostrar
			  $("#opcion_elector").hide();
			  $("#opcion_partido").hide();
			  $("#opcion_habitacional").hide();
			  $("#opcion_status").hide();
			  $("#opcion_sexo").hide();
			  /*$("#id_rep_sexo").val('')
			  $("#id_rep_status").val('')
			  $("#id_rep_habitacional").val('')
			  $("#id_rep_partido").val('')
			  $("#id_rep_elector").val('')
			  $("#id_rep_discapacidad").val('')
			  $("#id_cod_estado").val('')
			  $("#id_cod_municipio").val('')
			  $("#id_cod_parroquia").val('')*/
		  }
		  if ($("#id_categoria").val() == 'localidad') {
			  $("#opcion_estado").show();
			  $("#opcion_municipio").show();
			  $("#opcion_parroquia").show();
			  $("#opcion_discapacidad").hide();  // Campo a mostrar
			  $("#opcion_elector").hide();
			  $("#opcion_partido").hide();
			  $("#opcion_habitacional").hide();
			  $("#opcion_status").hide();
			  $("#opcion_sexo").hide();
			  /*$("#id_rep_sexo").val('')
			  $("#id_rep_status").val('')
			  $("#id_rep_habitacional").val('')
			  $("#id_rep_partido").val('')
			  $("#id_rep_elector").val('')
			  $("#id_rep_discapacidad").val('')
			  $("#id_cod_estado").val('')
			  $("#id_cod_municipio").val('')
			  $("#id_cod_parroquia").val('')*/
		  }
	  }
  });
	
  // Validación del campo de municipio al cargar la página
  var id_est = $('#id_cod_estado').val();
  $('#id_cod_municipio').find('option:gt(0)').remove().end();
  if (id_est != '') {
	  $.get('/parroquia/busqueda_ajax/', {'id':id_est}, function(data) {
	  var option = "";
	  $.each(data, function(i) {
		  option += "<option value=" + data[i].fields.cod_municipio + ">" + data[i].fields.municipio + "</option>";
	  });
	  $('#id_cod_municipio').append(option);
	  }, 'json');
  }
  
  // Validación del campo de parroquia al cargar la página (NO TIENE EFECTO)
  /*var id_est  = $('#id_cod_estado').val();
  var id_mun  = $("#id_cod_municipio").val();
  
  $('#id_cod_parroquia').find('option:gt(0)').remove().end();
  if (id_est != '' && id_mun != '') {
	  
	  $.get('/parroquia/busqueda_ajax2/', {'id_est':id_est,'id_mun':id_mun}, function(data) {
	  var option = "";
	  $.each(data, function(i) {
		  option += "<option value=" + data[i].fields.cod_parroquia + ">" + data[i].fields.parroquia + "</option>";
	  });
	  $('#id_cod_parroquia').append(option);
  
	  }, 'json');
  }*/
  
  // Validación de los campos y envio de los datos al hacer click en el botón de reportes en PDF  
  $("#reporte_lista_agremiados").click(function() {
	  var categoria = $("#id_categoria").val();
	  var sexo = $("#id_rep_sexo").val();
	  var status = $("#id_rep_status").val();
	  var situacion_h = $("#id_rep_habitacional").val();
	  var partido = $("#id_rep_partido").val();
	  var inscrito_cne = $("#id_rep_elector").val();
	  var discapacidad = $("#id_rep_discapacidad").val();
	  var estado = $("#id_cod_estado").val();
	  var municipio = $("#id_cod_municipio").val();
	  var parroquia = $("#id_cod_parroquia").val();
	
	  if (categoria != '') {
		  if (categoria == 1) {
			  URL = "../reporte_lista_gen/"
			  //alert(URL)
			  window.open(URL)
		  }
		  if (categoria == 'sexo') {
			  if (sexo != '') {
				 URL = "../reporte_lista_fil/"+categoria+"/"+sexo+"/"
				 //alert(URL)
				 window.open(URL)
			  }else{
				  alert("Seleccione el sexo");
			  }
		  }
		  if (categoria == 'status') {
			  if (status != '') {
				  URL = "../reporte_lista_fil/"+categoria+"/"+status+"/"
				  //alert(URL)
				  window.open(URL)
			  }else{
				  alert("Seleccione el status");   
			  }
		  }
		  if (categoria == 's_habitacional_id') {
			  if (situacion_h != '') {
				  URL = "../reporte_lista_fil/"+categoria+"/"+situacion_h+"/"
				  //alert(URL)
				  window.open(URL)
			  }else{
				  alert("Seleccione la situaci\u00f3n habitacional");   
			  }
		  }
		  if (categoria == 'partido_p_id') {
			  if (partido != '') {
				  URL = "../reporte_lista_fil/"+categoria+"/"+partido+"/"
				  //alert(URL)
				  window.open(URL)
			  }else{
				  alert("Seleccione el partido");   
			  }
		  }
		  if (categoria == 'ins_cne') {
			  if (inscrito_cne != '') {
				  URL = "../reporte_lista_fil/"+categoria+"/"+inscrito_cne+"/"
				  //alert(URL)
				  window.open(URL)
			  }else{
				  alert("Indique si est\u00e1 inscrito en el CNE");   
			  }
		  }
		  if (categoria == 'discapcidad') {
			  if (discapacidad != '') {
				  URL = "../reporte_lista_fil/"+categoria+"/"+discapacidad+"/"
				  //alert(URL)
				  window.open(URL)
			  }else{
				  alert("Indique si es discapacitado");   
			  }
		  }
		  if (categoria == 'localidad') {
			  if (estado != '') {
				  if (municipio == '' && parroquia == '') {
					municipio = '0';
					parroquia = '0';
					URL = "../reporte_lista_localidad/"+categoria+"/"+estado+"/"+municipio+"/"+parroquia+"/"
					//alert(URL)
					window.open(URL)
				  }
				  else if (municipio != '' && parroquia == '') {
					parroquia = '0';
					URL = "../reporte_lista_localidad/"+categoria+"/"+estado+"/"+municipio+"/"+parroquia+"/"
					//alert(URL)
					window.open(URL)
				  }
				  else if (municipio != '' && parroquia != '') {
					URL = "../reporte_lista_localidad/"+categoria+"/"+estado+"/"+municipio+"/"+parroquia+"/"
					//alert(URL)
					window.open(URL)
				  }
			  }else{
				  alert("Debe seleccionar al menos el estado");   
			  }
		  }
	  }else{
		alert("Seleccione una categor\u00eda")
	  }
  });
  
  // Validación de los campos y envio de los datos al hacer click en el botón de reportes gráficos
//  $("#reporte_grafico_agremiados").click(function() {
//	  var categoria = $("#id_categoria2").val();
//	  
//	  if (categoria != '') {
//		  //alert("Categor\u00eda: "+categoria);
//		  //~ if (categoria == 'sexo') {
//			URL = "../grafico_agremiados/"+categoria+"/"
//			//alert(URL)
//			window.open(URL)
//		  //~ }
//	  }else{
//		alert("Seleccione una categor\u00eda")
//	  }
//  }); 
});
