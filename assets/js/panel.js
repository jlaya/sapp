$(document).ready(function () {
	
	//$("select").select2();
	
	Highcharts.setOptions({
    lang: {
			printChart: "Imprimir Gráfico",
			decimalPoint: ',',
			downloadPNG: 'Descargar imágen en PNG',
			downloadJPEG: 'Descargar imágen en JPEG',
			downloadPDF: 'Descargar documento en PDF',
			downloadSVG: 'Descargar imágen en formato Vectorial',
			exportButtonTitle: 'Exportar Gráfico',
			loading: 'Cargaando...',
			printButtonTitle: 'Imprimir Gráfico',
			resetZoom: 'Restablecer zoom',
			resetZoomTitle: 'Restablecer el zoom al nivel 1: 1',
			thousandsSep: ' ',
			decimalPoint: ','
		}
	});
	
	// Themes Highcharts
	Highcharts.theme = {
    colors: ['#058DC7', '#50B432', '#ED561B', '#DDDF00', '#24CBE5', '#64E572', 
             '#FF9655', '#FFF263', '#6AF9C4'],
    chart: {
        backgroundColor: {
            linearGradient: [0, 0, 500, 500],
            stops: [
                [0, 'rgb(255, 255, 255)'],
                [1, 'rgb(240, 240, 255)']
            ]
        },
    },
    title: {
        style: {
            color: '#000',
            font: 'bold 16px "Trebuchet MS", Verdana, sans-serif'
        }
    },
    subtitle: {
        style: {
            color: '#666666',
            font: 'bold 12px "Trebuchet MS", Verdana, sans-serif'
        }
    },

    legend: {
        itemStyle: {
            font: '9pt Trebuchet MS, Verdana, sans-serif',
            color: 'black'
        },
        itemHoverStyle:{
            color: 'gray'
        }   
    }
};

// Apply the theme
Highcharts.setOptions(Highcharts.theme);
	
	var tipo_grafico = $("#tipo_grafico").val();
	var trimestre = $("#trimestre").val();
	var tabla_consulta = $("#tabla_consulta").val();
	var ano_fiscal = $("#ano_fiscal").val();

	if(tabla_consulta == 'acciones_registro'){
		var title = "Acciones";
	}else{
		var title = "Proyectos";
	}
	
	$( "#tipo_grafico, #trimestre, #tabla_consulta, #ano_fiscal" ).change(function() {
		var tipo_grafico = $("#tipo_grafico").val();
		var trimestre = $("#trimestre").val();
		var tabla_consulta = $("#tabla_consulta").val();
		var ano_fiscal = $("#ano_fiscal").val();

		if(tabla_consulta == 'acciones_registro'){
			var title = "Acciones";
		}else{
			var title = "Proyectos";
		}

		grafico_ano(tabla_consulta, tipo_grafico, title);
		grafico_trimestre(tabla_consulta, tipo_grafico, trimestre, title);
		organos_entes(tabla_consulta, tipo_grafico, trimestre, "Orgános u Entes "+ano_fiscal, ano_fiscal);
	});
	
	
	
	
	
	function grafico_ano(tabla_consulta, tipo_grafico, title){
		
	  // Acciones y Proyectos Aprobados por Año
		$.get(base_url('/gestion/GestionControllers/grafico?table='+tabla_consulta), function(data, status){
			
			var datos_ps = $.parseJSON(data);
			
			$('#container-grafico-1').highcharts({
				chart: {
					plotBackgroundColor: null,
					plotBorderWidth: null,
					plotShadow: false,
					type: tipo_grafico
				},
				title: {
					text: title+' por Año'
				},
				tooltip: {
					pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
				},
				plotOptions: {
					pie: {
						allowPointSelect: true,
						cursor: 'pointer',
						dataLabels: {
							enabled: true,
							formatter: function() {
								return '<b>'+ this.point.name +'</b>: '+ Highcharts.numberFormat(this.percentage, 2) +' %';
							}
						},
						showInLegend: true
					}
				},
				series: [{
					name: 'Indicador',
					colorByPoint: true,
					data: datos_ps
				}]
			});
					
		});
	}
	
	
	function grafico_trimestre(tabla_consulta, tipo_grafico, trimestre, title){
		// Acciones y Proyectos Aprobados por Año, Trimestral
		$.get(base_url('/gestion/GestionControllers/grafico?table='+tabla_consulta+'&acc=1&trimestre='+trimestre), function(data, status){
			
			var datos_ps = $.parseJSON(data);
			
			$('#container-grafico-2').highcharts({
				chart: {
					plotBackgroundColor: null,
					plotBorderWidth: null,
					plotShadow: false,
					type: tipo_grafico
				},
				title: {
					text: title+' por Año (Trimestre)'
				},
				tooltip: {
					pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
				},
				plotOptions: {
					pie: {
						allowPointSelect: true,
						cursor: 'pointer',
						dataLabels: {
							enabled: true,
							formatter: function() {
								return '<b>'+ this.point.name +'</b>: '+ Highcharts.numberFormat(this.percentage, 2) +' %';
							}
						},
						showInLegend: true
					}
				},
				series: [{
					name: 'Indicador',
					colorByPoint: true,
					data: datos_ps
				}]
			});
					
		});
	}
	
	function organos_entes(tabla_consulta, tipo_grafico, trimestre, title, ano_fiscal){
		
	  // Acciones y Proyectos Aprobados por Año
		$.get(base_url('/gestion/GestionControllers/organos_entes?table='+tabla_consulta+"&ano_fiscal="+ano_fiscal), function(data, status){
			
			var datos_ps = $.parseJSON(data);
			
			$('#container-grafico-3').highcharts({
				chart: {
					plotBackgroundColor: null,
					plotBorderWidth: null,
					plotShadow: false,
					type: tipo_grafico
				},
				title: {
					text: title
				},
				tooltip: {
					pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
				},
				plotOptions: {
					pie: {
						allowPointSelect: true,
						cursor: 'pointer',
						dataLabels: {
							enabled: true,
							formatter: function() {
								return '<b>'+ this.point.name +'</b>: '+ Highcharts.numberFormat(this.percentage, 2) +' %';
							}
						},
						showInLegend: true
					}
				},
				series: [{
					name: 'Indicador',
					colorByPoint: true,
					data: datos_ps
				}]
			});
					
		});
	}
	
	grafico_ano(tabla_consulta, tipo_grafico, title);
	grafico_trimestre(tabla_consulta, tipo_grafico, trimestre, title);
	organos_entes(tabla_consulta, tipo_grafico, trimestre, "Orgános u Entes "+ano_fiscal, ano_fiscal);
	

		
		
		
		
	
});
