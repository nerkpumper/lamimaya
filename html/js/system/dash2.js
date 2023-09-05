Highcharts.chart('grPedidos', {
	chart: {
        type: 'column'
    },
    title: {
        text: 'Pedidos por Estatus'
    },
    subtitle: {
        text: 'Total Pedidos'
    },
    xAxis: {
        categories: [            
            'CAPTURADOS',
            'AUTORIZADOS',
            'PRODUCCION',
            'TERMINADO',
            'ENTREGADO',
            'CANCELADO'            
        ],
        crosshair: true,
        
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Pedidos'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
//        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
        pointFormat: '<tr><td style="color:{series.color};padding:0">Total Pedidos: </td>' +
            '<td style="padding:0"><b> {point.y} </b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        },
        showInLegend: false,
        series: 
		{			
			cursor: 'pointer',
			point:
			{
				events: 
				{
					click: function (event) 
					{
//						var mes = this["x"];
						            
//						alert(this["x"]);
						//xajax_getChartGeneracionesDiasDeMes(idDispositivo, anioSeleccionado, mes + 1);
						
//						var out = '';
//
//						for(var i in this)
//						{							
//							out += i + ": " + this[i] + "\n";
//						}
//						
//						console.log(out);
						
						console.log(this.category);
					}
				}
			}
			
		}
    },
    series: [{
        name: 'Pedidos',        
        data: [],
        dataLabels: {
            enabled: true,
            rotation: -90,
            color: '#FFFFFF',
            align: 'right',
            format: '{point.y}', // one decimal
            y: 10, // 10 pixels down from the top
            style: {
                fontSize: '13px',
                fontFamily: 'Verdana, sans-serif'
            }
        }

    }]
});


Highcharts.chart('grPedidosPie', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'Pedidos por Estatus Porcentajes'
    },
    tooltip: {
    	headerFormat: '<span style="font-size:14px">{point.key}</span><br>',
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                style: {
                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                }
            }
            //showInLegend: true
        },
        series: 
		{			
			cursor: 'pointer',
			point:
			{
				events: 
				{
					click: function (event) 
					{
//						var mes = this["x"];
						            
//						alert(this["x"]);
						//xajax_getChartGeneracionesDiasDeMes(idDispositivo, anioSeleccionado, mes + 1);
						
//						var out = '';
//
//						for(var i in this)
//						{							
//							out += i + ": " + this[i] + "\n";
//						}
//						
//						console.log(out);
						
						console.log(this.name);
					}
				}
			}
			
		}
    },
    series: [{
        name: 'Pedidos',
        colorByPoint: true,
        data: []

    }]
});

// ____________________________________________________________________________________
//      E X P L O T A D O S 
//____________________________________________________________________________________

Highcharts.chart('grPedidosExplotados', {
	chart: {
        type: 'column'
    },
    title: {
        text: 'Pedidos Explosionados'
    },
    subtitle: {
        text: 'Total Pedidos'
    },
    xAxis: {
        categories: [            
            'EXPLOSIONADOS CON ÉXITO',
            'EXPLOSIONADOS SIN ÉXITO',
            'SIN EXPLOSIONAR'                        
        ],
        crosshair: true,
        
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Pedidos'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
//        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
        pointFormat: '<tr><td style="color:{series.color};padding:0">Total Pedidos: </td>' +
            '<td style="padding:0"><b> {point.y} </b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        },
        series: 
		{			
			cursor: 'pointer',
			point:
			{
				events: 
				{
					click: function (event) 
					{
//						var mes = this["x"];
						            
//						alert(this["x"]);
						//xajax_getChartGeneracionesDiasDeMes(idDispositivo, anioSeleccionado, mes + 1);
						
//						var out = '';
//
//						for(var i in this)
//						{							
//							out += i + ": " + this[i] + "\n";
//						}
//						
//						console.log(out);
						
						console.log(this.category);
					}
				}
			}
			
		}
    },
    series: [{
        name: 'Pedidos',
        data: [],
        dataLabels: {
            enabled: true,
            rotation: -90,
            color: '#FFFFFF',
            align: 'right',
            format: '{point.y}', // one decimal
            y: 10, // 10 pixels down from the top
            style: {
                fontSize: '13px',
                fontFamily: 'Verdana, sans-serif'
            }
        }

    }]
});

Highcharts.chart('grPedidosExplotadosPie', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'Pedidos Explosionados Porcentajes'
    },
    tooltip: {
    	headerFormat: '<span style="font-size:14px">{point.key}</span><br>',
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                style: {
                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                }
            }
            //showInLegend: true
        },
        series: 
		{			
			cursor: 'pointer',
			point:
			{
				events: 
				{
					click: function (event) 
					{
//						var mes = this["x"];
						            
//						alert(this["x"]);
						//xajax_getChartGeneracionesDiasDeMes(idDispositivo, anioSeleccionado, mes + 1);
						
//						var out = '';
//
//						for(var i in this)
//						{							
//							out += i + ": " + this[i] + "\n";
//						}
//						
//						console.log(out);
						
						console.log(this.name);
					}
				}
			}
			
		}
    },
    series: [{
        name: 'Pedidos',
        colorByPoint: true,
        data: []

    }]
});


$(document).ready(function(){
	
	xajax_cargarInformacionPedidos();
//	xajax_cargarInformacionProductos();
	
//	var index = $('#grPedidos').data('highchartsChart');	
//	var chart = Highcharts.charts[index];
//	
//	chart.xAxis[0].setCategories(['uno', 'dos', 'tres']);
//	
//	
//    //chart.series[0].setData([2,3,4], false);
//    //chart.series[1].setData([1,2,3], false);
//	
//	
//	chart.series[0].addPoint({color: "#f8ac59",  y: 2});
//	chart.series[0].addPoint({color: "#d1dade", y: 4});
//	chart.series[0].addPoint({color: "#23c6c8", y: 6});
//	chart.series[0].addPoint({color: "#1ab394", y: 2});
//	chart.series[0].addPoint({color: "#1c84c6", y: 4});
//	chart.series[0].addPoint({color: "#ed5565", y: 6});
//	
//	chart.series[1].addPoint({existencia: 1, name: 'e1', y: 1});
//	chart.series[1].addPoint({existencia: 2, name: 'e2', y: 3});
//	chart.series[1].addPoint({existencia: 3, name: 'e3', y: 2});    
//	
//    chart.redraw();
    
//    index = $('#grPedidosPie').data('highchartsChart');	
//	var chartP = Highcharts.charts[index];
//	
//	chartP.xAxis[0].setCategories(['uno', 'dos', 'tres']);
//	
//	
//    //chart.series[0].setData([2,3,4], false);
//    //chart.series[1].setData([1,2,3], false);
//	
//	
//	chartP.series[0].addPoint({color: "#f8ac59", name: 'eluno', y: 10});
//	chartP.series[0].addPoint({color: "#d1dade", name: 'elcuatro', y: 7});
//	chartP.series[0].addPoint({color: "#23c6c8", name: 'elseis', y: 3});
//	chartP.series[0].addPoint({color: "#1ab394", name: 'eluno', y: 10});
//	chartP.series[0].addPoint({color: "#1c84c6", name: 'elcuatro', y: 7});
//	chartP.series[0].addPoint({color: "#ed5565", name: 'elseis', y: 3});
	
//	
//	chartP.series[1].addPoint({existencia: 1, name: 'e1', y: 1});
//	chartP.series[1].addPoint({existencia: 2, name: 'e2', y: 3});
//	chartP.series[1].addPoint({existencia: 3, name: 'e3', y: 2});    
//	
//    chartP.redraw();
	
	
});