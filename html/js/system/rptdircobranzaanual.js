
// Return today's date and time
var gcurrentTime = new Date()
// returns the year (four digits)
var gyear = gcurrentTime.getFullYear()
var app = new Vue ({
	el: '#app',
	data:{
		showAnio: true,
		year: gyear
	},
	mounted: function() {
		this.cargarCobranzaAnual();
	},
	methods: {
		fnRegresarAReportes: function(){
			window.location = URL_BASE + "rptmanager";
		},
		cargarCobranzaAnual: function(){
			xajax_cargarCobranzaAnual(this.year);
			
		},
		mostrarAnio: function(){
			this.showAnio = true;
		}
		
	}
});

//
//Highcharts.setOptions({
//    colors: ['#058DC7', '#50B432', '#ED561B', '#DDDF00', '#24CBE5', '#64E572', '#FF9655', '#FFF263', '#6AF9C4']
//});

Highcharts.chart('chartAnio', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Cobranza Galvamex 2018'
    },
    xAxis: {
        categories: []
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Total Cobranza'
        },
        stackLabels: {
            enabled: true,
            style: {
                fontWeight: 'bold',
                color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
            }
        }
    },
    legend: {
        
        backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || 'white',
        borderColor: '#CCC',
        borderWidth: 1,
        shadow: false
    },
    tooltip: {
        headerFormat: '<b>{point.x}</b><br/>',
         pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b> ({point.percentage:.0f}%)<br/>',
        shared: true
    },
    plotOptions: {
        column: {
            stacking: 'normal',
            dataLabels: {
                enabled: false,
                color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white'
            }
        }
    },
    series: []
});




//
//{
//    name: 'John',
//    data: []
//}, {
//    name: 'Jane',
//    data: []
//}, {
//    name: 'Joe',
//    data: [3000, 42222, 2400, 20000, 52002]
//}

//$(document).ready(function()
//{
//	setTimeout(function(){
//		
//		 var index = $('#chartMeses').data('highchartsChart');
//		 chart = Highcharts.charts[index];
//		 
//		  chart.series[0].setData([]);
//		  chart.series[0].setData([100,40,50,70,143,23,44,76,21,2,4,90], false);
//		  chart.redraw();
//		
//		
//	}, 2000);
	
	
//	Highcharts.chart('chartAnio', {
//	    chart: {
//	        type: 'column'
//	    },
//	    title: {
//	        text: 'Ventas Galvamex 2018'
//	    },
//	    subtitle: {
//	        text: ''
//	    },
//	    xAxis: {
//	        type: 'category',
//	        labels: {
//	            rotation: -45,
//	            style: {
//	                fontSize: '13px',
//	                fontFamily: 'Verdana, sans-serif'
//	            }
//	        },	        
//	        categories: [
//	            'Enero',
//	            'Febrero',
//	            'Marzo',
//	            'Abril',
//	            'Mayo',
//	            'Junio',
//	            'Julio',
//	            'Agosto',
//	            'Septiembre',
//	            'Octubre',
//	            'Noviembre',
//	            'Diciembre'
//	        ],
//	        crosshair: true
//	    },
//	    yAxis: {
//	        min: 0,
//	        title: {
//	            text: 'Total Ventas'
//	        }
//	    },
//	    legend: {
//	        enabled: false
//	    },
//		plotOptions: 
//		{
//			series: 
//			{
////				stacking: 'normal',
//				cursor: 'pointer',
//    			point:
//    			{
//    				events: 
//    				{
//    					click: function (event) 
//    					{
//    						var mes = this["x"];
//    						
//    						app.cargarVentasMes(mes);
//    						
////    						alert("mes: " + mes);
////    						console.dir(this[""]);    						            						
////    						xajax_getChartGeneracionesDiasDeMes(idDispositivo, anioSeleccionado, mes + 1);
//    						
////    						var out = '';
////
////							for(var i in this)
////							{							
////								out += i + ": " + this[i] + "\n";
////							}
////							
////							alert(out);        						
//    					}
//    				}
//    			}
//			}       		
//		},
//	    tooltip: {
//	        pointFormat: 'Ventas: <b>{point.y:.2f}</b>'
//	    },
//	    series: [{
//	        name: 'Ventas',
//	        data: [
//	           
//	        ],
//	        dataLabels: {
//	            enabled: true,
//	            rotation: -90,
//	            color: '#FFFFFF',
//	            align: 'right',
//	            format: '{point.y:.2f}', // one decimal
//	            y: 10, // 10 pixels down from the top
//	            style: {
//	                fontSize: '12px',
//	                fontFamily: 'Verdana, sans-serif'
//	            }
//	        }
//	    }]
//	});
//	
//	Highcharts.chart('chartMes', {
//	    chart: {
//	        type: 'column'
//	    },
//	    title: {
//	        text: 'Ventas Mes'
//	    },
//	    subtitle: {
//	        text: ''
//	    },
//	    xAxis: {
//	        type: 'category',
//	        labels: {
//	            rotation: -45,
//	            style: {
//	                fontSize: '13px',
//	                fontFamily: 'Verdana, sans-serif'
//	            }
//	        },	        
//	        categories: [
//	            'Enero',
//	            'Febrero',
//	            'Marzo',
//	            'Abril',
//	            'Mayo',
//	            'Junio',
//	            'Julio',
//	            'Agosto',
//	            'Septiembre',
//	            'Octubre',
//	            'Noviembre',
//	            'Diciembre'
//	        ],
//	        crosshair: true
//	    },
//	    yAxis: {
//	        min: 0,
//	        title: {
//	            text: 'Total Ventas'
//	        }
//	    },
//	    legend: {
//	        enabled: false
//	    },
//		plotOptions: 
//		{
//			series: 
//			{
////				stacking: 'normal',
//				cursor: 'pointer',
//    			point:
//    			{
//    				events: 
//    				{
//    					click: function (event) 
//    					{
//    						var mes = this["x"];
//    						
////    						app.cargarVentasMes(mes);
//    						
////    						alert("mes: " + mes);
////    						console.dir(this[""]);    						            						
////    						xajax_getChartGeneracionesDiasDeMes(idDispositivo, anioSeleccionado, mes + 1);
//    						
////    						var out = '';
////
////							for(var i in this)
////							{							
////								out += i + ": " + this[i] + "\n";
////							}
////							
////							alert(out);        						
//    					}
//    				}
//    			}
//			}       		
//		},
//	    tooltip: {
//	        pointFormat: 'Ventas: <b>{point.y:.2f}</b>'
//	    },
//	    series: [{
//	        name: 'Ventas',
//	        data: [
//	           1,2,3,4,5,6,7,8,9,10,11,12
//	        ],
//	        dataLabels: {
//	            enabled: true,
//	            rotation: -90,
//	            color: '#FFFFFF',
//	            align: 'right',
//	            format: '{point.y:.2f}', // one decimal
//	            y: 10, // 10 pixels down from the top
//	            style: {
//	                fontSize: '12px',
//	                fontFamily: 'Verdana, sans-serif'
//	            }
//	        }
//	    }]
//	});
	
	
//	Highcharts.chart('chartMeses', {
//	    chart: {
//	        type: 'column'
//	    },
//	    title: {
//	        text: 'Monthly Average Rainfall'
//	    },
//	    subtitle: {
//	        text: 'Source: WorldClimate.com'
//	    },
//	    xAxis: {
//	        categories: [
//	            'Jan',
//	            'Feb',
//	            'Mar',
//	            'Apr',
//	            'May',
//	            'Jun',
//	            'Jul',
//	            'Aug',
//	            'Sep',
//	            'Oct',
//	            'Nov',
//	            'Dec'
//	        ],
//	        crosshair: true
//	    },
//	    yAxis: {
//	        min: 0,
//	        title: {
//	            text: 'Rainfall (mm)'
//	        }
//	    },
//	    tooltip: {
//	        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
//	        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
//	            '<td style="padding:0"><b>{point.y:.1f} mm</b></td></tr>',
//	        footerFormat: '</table>',
//	        shared: true,
//	        useHTML: true
//	    },
//	    plotOptions: {
//	        column: {
//	            pointPadding: 0.2,
//	            borderWidth: 0
//	        }
//	    },
//	    series: [{
//	        name: 'Tokyo',
//	        data: [49.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4]
//
//	    }]
//	});
	
//	Highcharts.chart('chartMeses', 
//			{
//        		chart: 
//        		{
//        			zoomType: 'xy'
//        		},
//        		title: 	
//        		{
//        			text: ''
//        		},
//        		subtitle: 
//        		{
//        			text: ''
//        		},
//        		xAxis: [
//        		        {
//        		        	categories: [
//
//        		        	             ],
//        		            crosshair: true
//        		        }],
//        		yAxis: [
//        		        { // Primary yAxis
//        		        	labels: 
//        		        	{
//        		        		format: '{value} K',
//        		        		style: 
//        		        		{
//        		        			color: Highcharts.getOptions().colors[1]
//        		        		}
//        		        	},
//        		        	title: 
//        		        	{
//        		        		text: 'Energia',
//        		        		style: 
//        		        		{
//        		        			color: Highcharts.getOptions().colors[1]
//        		        		}
//        		        	}
//        		        }, 
//        		        { // Secondary yAxis
//        		        	title: 
//        		        	{
//        		        		text: 'Ahorro',
//        		        		style: 
//        		        		{
//        		        			color: Highcharts.getOptions().colors[0]
//        		        		}	
//        		        	},
//        		        	labels: 
//        		        	{
//        		        		format: '{value} K',
//        		        		style: 
//        		        		{
//        		        			color: Highcharts.getOptions().colors[0]
//        		        		}
//        		        	},
//        		        opposite: true
//        		     }],
//        		tooltip: 
//        		{
//        			shared: true
//        		},
//        		plotOptions: 
//        		{
//        			series: 
//        			{
//        				stacking: 'normal',
//        				cursor: 'pointer',
//            			point:
//            			{
//            				events: 
//            				{
//            					click: function (event) 
//            					{
//            						var mes = this["x"];
//            						            						            						
////            						xajax_getChartGeneracionesDiasDeMes(idDispositivo, anioSeleccionado, mes + 1);
//            						
//            						//var out = '';
//
//        							//for(var i in this)
//        							//{							
//        							//	out += i + ": " + this[i] + "\n";
//        							//}
//        							
//        							//alert(out);        						
//            					}
//            				}
//            			}
//        			}       		
//        		},
//        		legend: 
//        		{
//        			layout: 'horizontal',
//        			align: 'left',
//        			x: 10,
//        			verticalAlign: 'bottom',
//        			y: 10,
//        			floating: false,
//        			backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'
//        		},
//        		series: [{
//        					name: 'Energia Base',
//        					type: 'column',
//        					yAxis: 1,
//        					data: [],
//        					tooltip: 
//        					{
//        						valueSuffix: 'K'
//        					}
//
//        				}]
//			});	
//});


