$(document).ready( function () {
	var categoria = $("#id_categoria2").val();
	var titulo = '';
	var titulo_gen = [];
	
	//------------------------------------------------------------------------------
	// AL CARGAR LA PÁGINA.---------------------------------------------------------
	// Sección para las categorías específicas
	if (categoria != '1' && categoria != ''){
	  // Ocultamos el contenedor inferior
	  $('#contenedor_inferior').hide();
	  $('#contenedor_superior').show();
	  
	  if (categoria == 'sexo'){
		titulo = 'Estadísticas de Agremiados por Género'
	  }
	  else if (categoria == 'status'){
		titulo = 'Estadísticas de Agremiados por Estatus'
	  }
	  else if (categoria == 's_habitacional_id'){
		titulo = 'Estadísticas de Agremiados por Situación habitacional'
	  }
	  else if (categoria == 'partido_p_id'){
		titulo = 'Estadísticas de Agremiados por Partido'
	  }
	  else if (categoria == 'ins_cne'){
		titulo = 'Estadísticas de Agremiados Inscritos en el Registro Electoral'
	  }
	  else if (categoria == 'discapcidad'){
		titulo = 'Estadísticas de Agremiados Discapacitados'
	  }
	  $("#titulo").text(titulo);
	  
	  $.get('/registro/grafico_agremiados_data/', {'categoria': categoria,}, function(data) {
		//alert(data)
		var data_barra = []; // Armamos un nuevo arreglo de datos para las gráficas de barra 
		var total_agremiados = 0;
		var porcentaje = 0;
		$.each(data, function(i){
			//alert(data[i][1]);
			total_agremiados += data[i][1];
		})
		//alert(total_agremiados)
		$.each(data, function(i){
			d = [];
			//alert(data[i][1]);
			porcentaje = parseFloat(((data[i][1]*100)/(total_agremiados)).toFixed(2));
			//alert(porcentaje)
			d[0] = data[i][0];
			d[1] = porcentaje;
			data_barra[i] = d
		})
		//alert(data_barra)
	
		$('#container1').highcharts({
							
			chart: {
				plotBackgroundColor: null,
				plotBorderWidth: null,
				plotShadow: false,
			},
			title: {
				text: '',
			},
			tooltip: {
				pointFormat: '{series.name}: <b>{point.percentage:.2f}%</b>'
			},
			plotOptions: {
				pie: {
					allowPointSelect: true,
					cursor: 'pointer',
					dataLabels: {
						enabled: true,
						format: '(<span style="color:#FF0000">{point.y}</span>)  {point.percentage:.2f} %',
						style: {
							color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
							}
					},
					
					showInLegend: true
				}
			},
			series: [{
				type: 'pie',
				name: 'Porcentaje de Agremiados',
				data: data,
			}]
		});
		
		// Gráficos de barras
		$('#container2').highcharts({
			chart: {
				type: 'column'
			},
			title: {
				text: '',
			},
			subtitle: {
				text: ''
			},
			xAxis: {
				type: 'category'
			},
			yAxis: {
				title: {
					text: ''
					//texto lateral                                    
				}
			},
			legend: {
				enabled: false
			},
			plotOptions: {
				series: {
					borderWidth: 0,
					dataLabels: {
						enabled: true,
						format: '<span style="color:#FF0000">{point.y}</span> %',
					}
				}
			},
			tooltip: {
				headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
				pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> del total<br/>'
			},
	  
			series: [{
				name: 'Porcentaje de Agremiados',
				colorByPoint: true,
				data: data_barra,
			}], 
		});
		
	  }, 'json');
	  
	}// Fin de la sección para las categorías específicas
	
	
	// Sección para las estadísticas generales
	else if (categoria == '1'){
	  // Ocultamos el contenedor superior
	  $('#contenedor_superior').hide();
	  $('#contenedor_inferior').show();
	  
	  titulo_gen[0] = 'Estadísticas de Agremiados por Género';
	  titulo_gen[1] = 'Estadísticas de Agremiados por Estatus';
	  titulo_gen[2] = 'Estadísticas de Agremiados por Situación habitacional';
	  titulo_gen[3] = 'Estadísticas de Agremiados por Partido';
	  titulo_gen[4] = 'Estadísticas de Agremiados Inscritos en el Registro Electoral';
	  titulo_gen[5] = 'Estadísticas de Agremiados Discapacitados';
	  
	  $.get('/registro/grafico_agremiados_data/', {'categoria': categoria,}, function(data) {
		//alert(data);
		
		// Armado de los id de los contenedores de los gráficos de torta y barra.
		cont_cont = 2; // Acumulador para crear el id de los contenedores de torta
		cont_cont2 = 3; // Acumulador para crear el id de los contenedores de barra
		$.each(data, function(i){
		  //alert(titulo_gen[i])
		  //alert(data[i]);
		  
		  cont_tit = (i+1)+1; // Acumulador de títulos
		  
		  cont_cont += 1; // Primera suma para el acumulador de los contenedores de torta
		  cont_cont2 += 1; // Primera suma para el acumulador de los contenedores de barra
		  
		  //alert("titulo"+cont_tit);
		  //alert('container torta'+cont_cont);
		  //alert('container barra'+cont_cont2);
		  
		  // Armado de los contenedores para cada categoría (Seis en total)
		  contenedor_inferior = "<div class='panel panel-primary' style='width:90%'>";
			contenedor_inferior += "<div id='titulo"+cont_tit+"' class='panel-heading' style='font-size: 20px;font-weight:bold;'></div>"
			contenedor_inferior += "<br>";
			contenedor_inferior += "<div id='id_graficas' style='width: 90%'>";
				contenedor_inferior += "<div style='float: left;width: 50%;'>";
					contenedor_inferior += "<div id='container"+cont_cont+"' style='min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto'></div>";
				contenedor_inferior += "</div>";
				contenedor_inferior += "<div style='float: left;width: 50%;'>";
					contenedor_inferior += "<div id='container"+cont_cont2+"' style='min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto'></div>";
				contenedor_inferior += "</div>";
			contenedor_inferior += "</div>";
			contenedor_inferior += "<div style='width: 50%'>";
				contenedor_inferior += "<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>";
			contenedor_inferior += "</div>";
		  contenedor_inferior += "</div>";
		  contenedor_inferior += "<br><br><br><br>";
		  
		  // Asignación de título a cada contenedor
		  $("#titulo"+cont_tit).text(titulo_gen[i]);
		  
		  $("#contenedor_inferior").append(contenedor_inferior);
		  
		  cont_cont += 1; // Segunda suma para el acumulador de los contenedores de torta
		  cont_cont2 += 1; // Segunda suma para el acumulador de los contenedores de barra
		})
		
		
		// Asignación de la data a cada contenedor
		cont_cont3 = 2; // Acumulador para el id de los contenedores de torta
		cont_cont4 = 3; // Acumulador para el id de los contenedores de barra
		
		$.each(data, function(i){
		  
		  // Cálculo de los porcentajes para los gráficos de barra
		  var data_barra = []; // Armamos un nuevo arreglo de datos para las gráficas de barra
		  var total_agremiados = 0;
		  var porcentaje = 0;
		  $.each(data[i], function(j){
			  //alert(data[i][1]);
			  total_agremiados += data[i][j][1];
		  })
		  //alert(total_agremiados)
		  $.each(data[i], function(j){
			  d = [];
			  //alert(data[i][1]);
			  porcentaje = parseFloat(((data[i][j][1]*100)/(total_agremiados)).toFixed(2));
			  //alert(porcentaje)
			  d[0] = data[i][j][0];
			  d[1] = porcentaje;
			  data_barra[j] = d
		  })
		  //alert(data_barra)
		  
		  //alert(data[i])
		  cont_tit = (i+1)+1; // Acumulador de títulos
		  
		  cont_cont3 += 1; // Primera suma para el acumulador de los ids contenedores de torta
		  cont_cont4 += 1; // Primera suma para el acumulador de los ids contenedores de barra
		  
		  //alert('container grafico torta'+cont_cont);
		  //alert('container grafico barra'+cont_cont2);
		  
		  // Asignación del título a cada contenedor
		  $("#titulo"+cont_tit).text(titulo_gen[i]);
		  
		  // Gráficos de torta
		  $("#container"+cont_cont3).highcharts({
							
			chart: {
				plotBackgroundColor: null,
				plotBorderWidth: null,
				plotShadow: false,
			},
			title: {
				text: '',
			},
			tooltip: {
				pointFormat: '{series.name}: <b>{point.percentage:.2f}%</b>'
			},
			plotOptions: {
				pie: {
					allowPointSelect: true,
					cursor: 'pointer',
					dataLabels: {
						enabled: true,
						format: '(<span style="color:#FF0000">{point.y}</span>)  {point.percentage:.2f} %',
						style: {
							color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
							}
					},
					
					showInLegend: true
				}
			},
			series: [{
				type: 'pie',
				name: 'Porcentaje de Agremiados',
				data: data[i],
			}]
		  });
		
		  // Gráficos de barras
		  $('#container'+cont_cont4).highcharts({
			  chart: {
				  type: 'column'
			  },
			  title: {
				  text: '',
			  },
			  subtitle: {
				  text: ''
			  },
			  xAxis: {
				  type: 'category'
			  },
			  yAxis: {
				  title: {
					  text: ''
					  //texto lateral                                    
				  }
			  },
			  legend: {
				  enabled: false
			  },
			  plotOptions: {
				  series: {
					  borderWidth: 0,
					  dataLabels: {
						  enabled: true,
						  format: '<span style="color:#FF0000">{point.y}</span> %',
					  }
				  }
			  },
			  tooltip: {
				  headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
				  pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> del total<br/>'
			  },
		
			  series: [{
				  name: 'Porcentaje de Agremiados',
				  colorByPoint: true,
				  data: data_barra,
			  }], 
		  });
		  
		  cont_cont3 += 1; // Segunda suma para el acumulador de los ids contenedores de torta
		  cont_cont4 += 1; // Segunda suma para el acumulador de los ids contenedores de torta
		})
		
	  }, 'json');
	}
	
	else{
		//alert("Seleccione una categor\u00eda");
		// Ocultamos el contenedor superior y mostramos el inferior
		$('#contenedor_superior').hide();
		$('#contenedor_inferior').hide();
	}// Cierra de la sección para las estadísticas generales
	//------------------------------------------------------------------------------

	
	//------------------------------------------------------------------------------	
	// AL HACER CLICK EN EL BOTÓN DE GENERAR GRÁFICO.-------------------------------
	$("#reporte_grafico_agremiados").click(function() {
		var categoria = $("#id_categoria2").val();
		var titulo = '';
		var titulo_gen = [];
		//alert(categoria)
		
		// Sección para las categorías específicas
		if (categoria != '1' && categoria != ''){
		  // Ocultamos el contenedor inferior
		  $('#contenedor_inferior').hide();
		  $('#contenedor_superior').show();
		  
		  if (categoria == 'sexo'){
			titulo = 'Estadísticas de Agremiados por Género'
		  }
		  else if (categoria == 'status'){
			titulo = 'Estadísticas de Agremiados por Estatus'
		  }
		  else if (categoria == 's_habitacional_id'){
			titulo = 'Estadísticas de Agremiados por Situación habitacional'
		  }
		  else if (categoria == 'partido_p_id'){
			titulo = 'Estadísticas de Agremiados por Partido'
		  }
		  else if (categoria == 'ins_cne'){
			titulo = 'Estadísticas de Agremiados Inscritos en el Registro Electoral'
		  }
		  else if (categoria == 'discapcidad'){
			titulo = 'Estadísticas de Agremiados Discapacitados'
		  }
		  $("#titulo").text(titulo);
		  
		  $.get('/registro/grafico_agremiados_data/', {'categoria': categoria,}, function(data) {
			//alert(data)
			var data_barra = []; // Armamos un nuevo arreglo de datos para las gráficas de barra 
			var total_agremiados = 0;
			var porcentaje = 0;
			$.each(data, function(i){
				//alert(data[i][1]);
				total_agremiados += data[i][1];
			})
			//alert(total_agremiados)
			$.each(data, function(i){
				d = [];
				//alert(data[i][1]);
				porcentaje = parseFloat(((data[i][1]*100)/(total_agremiados)).toFixed(2));
				//alert(porcentaje)
				d[0] = data[i][0];
				d[1] = porcentaje;
				data_barra[i] = d
			})
			//alert(data_barra)
		
			$('#container1').highcharts({
								
				chart: {
					plotBackgroundColor: null,
					plotBorderWidth: null,
					plotShadow: false,
				},
				title: {
					text: '',
				},
				tooltip: {
					pointFormat: '{series.name}: <b>{point.percentage:.2f}%</b>'
				},
				plotOptions: {
					pie: {
						allowPointSelect: true,
						cursor: 'pointer',
						dataLabels: {
							enabled: true,
							format: '(<span style="color:#FF0000">{point.y}</span>)  {point.percentage:.2f} %',
							style: {
								color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
								}
						},
						
						showInLegend: true
					}
				},
				series: [{
					type: 'pie',
					name: 'Porcentaje de Agremiados',
					data: data,
				}]
			});
			
			// Gráficos de barras
			$('#container2').highcharts({
				chart: {
					type: 'column'
				},
				title: {
					text: '',
				},
				subtitle: {
					text: ''
				},
				xAxis: {
					type: 'category'
				},
				yAxis: {
					title: {
						text: ''
						//texto lateral                                    
					}
				},
				legend: {
					enabled: false
				},
				plotOptions: {
					series: {
						borderWidth: 0,
						dataLabels: {
							enabled: true,
							format: '<span style="color:#FF0000">{point.y}</span> %',
						}
					}
				},
				tooltip: {
					headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
					pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> del total<br/>'
				},
		  
				series: [{
					name: 'Porcentaje de Agremiados',
					colorByPoint: true,
					data: data_barra,
				}], 
			});
			
		  }, 'json');
		}// Fin de la sección para las categorías específicas
		
		
		// Sección para las estadísticas generales
		else if (categoria == '1'){
		  // Ocultamos el contenedor superior y mostramos el inferior
		  $('#contenedor_superior').hide();
		  $('#contenedor_inferior').show();
		  
		  titulo_gen[0] = 'Estadísticas de Agremiados por Género';
		  titulo_gen[1] = 'Estadísticas de Agremiados por Estatus';
		  titulo_gen[2] = 'Estadísticas de Agremiados por Situación habitacional';
		  titulo_gen[3] = 'Estadísticas de Agremiados por Partido';
		  titulo_gen[4] = 'Estadísticas de Agremiados Inscritos en el Registro Electoral';
		  titulo_gen[5] = 'Estadísticas de Agremiados Discapacitados';
		  
		  $.get('/registro/grafico_agremiados_data/', {'categoria': categoria,}, function(data) {
			//alert(data);
			
			// Armado de los id de los contenedores de los gráficos de torta y barra.
			cont_cont = 2; // Acumulador para crear el id de los contenedores de torta
			cont_cont2 = 3; // Acumulador para crear el id de los contenedores de barra
			$.each(data, function(i){
			  //alert(titulo_gen[i])
			  //alert(data[i]);
			  
			  cont_tit = (i+1)+1; // Acumulador de títulos
			  
			  cont_cont += 1; // Primera suma para el acumulador de los contenedores de torta
			  cont_cont2 += 1; // Primera suma para el acumulador de los contenedores de barra
			  
			  //alert("titulo"+cont_tit);
			  //alert('container torta'+cont_cont);
			  //alert('container barra'+cont_cont2);
			  
			  // Armado de los contenedores para cada categoría (Seis en total)
			  contenedor_inferior = "<div class='panel panel-primary' style='width:90%'>";
				contenedor_inferior += "<div id='titulo"+cont_tit+"' class='panel-heading' style='font-size: 20px;font-weight:bold;'></div>"
				contenedor_inferior += "<br>";
				contenedor_inferior += "<div id='id_graficas' style='width: 90%'>";
					contenedor_inferior += "<div style='float: left;width: 50%;'>";
						contenedor_inferior += "<div id='container"+cont_cont+"' style='min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto'></div>";
					contenedor_inferior += "</div>";
					contenedor_inferior += "<div style='float: left;width: 50%;'>";
						contenedor_inferior += "<div id='container"+cont_cont2+"' style='min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto'></div>";
					contenedor_inferior += "</div>";
				contenedor_inferior += "</div>";
				contenedor_inferior += "<div style='width: 50%'>";
					contenedor_inferior += "<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>";
				contenedor_inferior += "</div>";
			  contenedor_inferior += "</div>";
			  contenedor_inferior += "<br><br><br><br>";
			  
			  // Asignación de título a cada contenedor
			  $("#titulo"+cont_tit).text(titulo_gen[i]);
			  
			  $("#contenedor_inferior").append(contenedor_inferior);
			  
			  cont_cont += 1; // Segunda suma para el acumulador de los contenedores de torta
			  cont_cont2 += 1; // Segunda suma para el acumulador de los contenedores de barra
			})
			
			
			// Asignación de la data a cada contenedor
			cont_cont3 = 2; // Acumulador para el id de los contenedores de torta
			cont_cont4 = 3; // Acumulador para el id de los contenedores de barra
			
			$.each(data, function(i){
			  
			  // Cálculo de los porcentajes para los gráficos de barra
			  var data_barra = []; // Armamos un nuevo arreglo de datos para las gráficas de barra
			  var total_agremiados = 0;
			  var porcentaje = 0;
			  $.each(data[i], function(j){
				  //alert(data[i][1]);
				  total_agremiados += data[i][j][1];
			  })
			  //alert(total_agremiados)
			  $.each(data[i], function(j){
				  d = [];
				  //alert(data[i][1]);
				  porcentaje = parseFloat(((data[i][j][1]*100)/(total_agremiados)).toFixed(2));
				  //alert(porcentaje)
				  d[0] = data[i][j][0];
				  d[1] = porcentaje;
				  data_barra[j] = d
			  })
			  //alert(data_barra)
			  
			  //alert(data[i])
			  cont_tit = (i+1)+1; // Acumulador de títulos
			  
			  cont_cont3 += 1; // Primera suma para el acumulador de los ids contenedores de torta
			  cont_cont4 += 1; // Primera suma para el acumulador de los ids contenedores de barra
			  
			  //alert('container grafico torta'+cont_cont);
			  //alert('container grafico barra'+cont_cont2);
			  
			  // Asignación del título a cada contenedor
			  $("#titulo"+cont_tit).text(titulo_gen[i]);
			  
			  // Gráficos de torta
			  $("#container"+cont_cont3).highcharts({
								
				chart: {
					plotBackgroundColor: null,
					plotBorderWidth: null,
					plotShadow: false,
				},
				title: {
					text: '',
				},
				tooltip: {
					pointFormat: '{series.name}: <b>{point.percentage:.2f}%</b>'
				},
				plotOptions: {
					pie: {
						allowPointSelect: true,
						cursor: 'pointer',
						dataLabels: {
							enabled: true,
							format: '(<span style="color:#FF0000">{point.y}</span>)  {point.percentage:.2f} %',
							style: {
								color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
								}
						},
						
						showInLegend: true
					}
				},
				series: [{
					type: 'pie',
					name: 'Porcentaje de Agremiados',
					data: data[i],
				}]
			  });
			
			  // Gráficos de barras
			  $('#container'+cont_cont4).highcharts({
				  chart: {
					  type: 'column'
				  },
				  title: {
					  text: '',
				  },
				  subtitle: {
					  text: ''
				  },
				  xAxis: {
					  type: 'category'
				  },
				  yAxis: {
					  title: {
						  text: ''
						  //texto lateral                                    
					  }
				  },
				  legend: {
					  enabled: false
				  },
				  plotOptions: {
					  series: {
						  borderWidth: 0,
						  dataLabels: {
							  enabled: true,
							  format: '<span style="color:#FF0000">{point.y}</span> %',
						  }
					  }
				  },
				  tooltip: {
					  headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
					  pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> del total<br/>'
				  },
			
				  series: [{
					  name: 'Porcentaje de Agremiados',
					  colorByPoint: true,
					  data: data_barra,
				  }], 
			  });
			  
			  cont_cont3 += 1; // Segunda suma para el acumulador de los ids contenedores de torta
			  cont_cont4 += 1; // Segunda suma para el acumulador de los ids contenedores de torta
			})
			
		  }, 'json');
		
		}
		
		else{
			alert("Seleccione una categor\u00eda");
			// Ocultamos los contenedores superior e inferior
			$('#contenedor_superior').hide();
			$('#contenedor_inferior').hide();
		}// Cierra de la sección para las estadísticas generales
	
	// CIERRE DE .click()
	});
	//------------------------------------------------------------------------------
  
  // CIERRE DE JQUERY
  });