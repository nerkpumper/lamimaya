//Highcharts.chart('grRollos', {
//    chart: {
//        zoomType: 'xy'
//    },
//    title: {
//        text: 'Relación Rollos Existencia/Apartado'
//    },
//    subtitle: {
//        text: ''
//    },
//    xAxis: [{
////        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
//        crosshair: true
//    }],
//    yAxis: [{ // Primary yAxis
//        labels: {
//            format: '{value} KG',
//            style: {
//                color: Highcharts.getOptions().colors[1]
//            }
//        },
//        title: {
//            text: 'Apartados',
//            style: {
//                color: Highcharts.getOptions().colors[1]
//            }
//        }
//    }, { // Secondary yAxis
//        title: {
//            text: 'Existencia',
//            style: {
//                color: Highcharts.getOptions().colors[1]
//            }
//        },
//        labels: {
//            format: '{value} KG',
//            style: {
//                color: Highcharts.getOptions().colors[1]
//            }
//        },
//        opposite: true
//    }],
//    tooltip: {
//        shared: true
//    },
//    plotOptions: 
//	{
//		series: 
//		{
//			stacking: 'normal',
//			cursor: 'pointer',
//			point:
//			{
//				events: 
//				{
//					click: function (event) 
//					{
////						var mes = this["x"];
//						            
////						alert(this["x"]);
//						//xajax_getChartGeneracionesDiasDeMes(idDispositivo, anioSeleccionado, mes + 1);
//						
////						var out = '';
////
////						for(var i in this)
////						{							
////							out += i + ": " + this[i] + "\n";
////						}
////						
////						console.log(out);
//						
//						console.dir(this);
//					}
//				}
//			}
//			
//		}
////    ,
////		allowPointSelect: true,
////    	point:
////        {
////    		events: 
////        	{
////            	click: function (event) 
////            	{
////					var out = '';
////
////					for(var i in this)
////					{
////						out += i + ": " + this[i] + "\n";
////					}
////					
////					alert(out);
////					
//////					zona_seleccionada = this.id;
//////					
//////					if(this.id != 1){ // verifica que el id elegino no sea el general para evitar cargar general al seleccionar general.
//////                		//alert(
//////                		//		'cargamos ' + 
//////	                    //        this.name + ' clicked\n' +
//////	                    //        'Id: ' + this.id + '\n'				                            
//////                        //	);
//////                		mostrarEspera("Cargando informacion de " + this.name + ".");
//////                		idDispositivoEntrada = this.id;
//////                		
////////                		xajax_getChartConsumos(idDispositivo, anioSeleccionado, idDispositivoEntrada);
//////                	}
////                	
////				
////                    /*if (this.hasOwnProperty("parent"))
////                    {
////                    	alert(
////	                            this.name + ' clicked\n' +
////	                            'Id: ' + this.id + '\n' +
////	                            'Alt: ' + event.altKey + '\n' +
////	                            'Control: ' + event.ctrlKey + '\n' +
////    	                        'Meta: ' + event.metaKey + '\n' +
////        	                    'Shift: ' + event.shiftKey + '\n'
////                        	);
////                	}*/			                        
////            	}
////        	}
////    	}	
//	},
//    legend: {
//        layout: 'vertical',
//        align: 'left',
//        x: 120,
//        verticalAlign: 'top',
//        y: 100,
//        floating: true,
//        backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'
//    },
//    series: [{
//        name: 'Existencia',
//        type: 'column',
//        yAxis: 1,
////        data: [49.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4],
//        tooltip: {
//            valueSuffix: ' KG'
//        }
//
//    }, {
//        name: 'Apartado',
//        type: 'spline',
////        data: [7.0, 6.9, 9.5, 14.5, 18.2, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6],
//        tooltip: {
//            valueSuffix: ' KG'
//        }
//    }]
//});


Highcharts.chart('grRollos', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Relación Rollos Existencia/Apartado'
    },
    xAxis: {
//        categories: [            'Seattle HQ',            'San Francisco',            'Tokyo'        ]
    },
    yAxis: [{
        min: 0,
        title: {
            text: ''
        },
        labels: {
          format: '{value} KG',
//          style: {
//              color: Highcharts.getOptions().colors[1]
//          }
      }
    
    }
    
//    , {
//        title: {
//            text: 'Profit (millions)'
//        },
//        opposite: true
//    }
    ],
    legend: {
        shadow: false
    },
    tooltip: {
        shared: true
//        ,
//        formatter: function() {
//            var tooltip;
//            if (this.key == 'last') {
//                tooltip = '<b>Final result is </b> ' + this.y;
//            }
//            else {
//                tooltip =  '<span style="color:' + this.series.color + '">' + this.series.name + '</span>: <b>' + this.y + '</b><br/>';
//            }
//            return tooltip;
//        }
    },
    plotOptions: {
        column: {
            grouping: false,
            shadow: false,
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
						
//						console.dir(this);
					}
				}
			}
			
		}
    },
    series: [{
        name: 'Existencia',
        color: 'rgba(165,170,217,1)',
//        data: [150, 73, 20],
        pointPadding: 0.3,
        pointPlacement: -0.2
    }, {
        name: 'Apartado',
        color: 'rgba(126,86,134,.9)',
//        data: [140, 90, 40],
        pointPadding: 0.4,
        pointPlacement: -0.2
    }
//    , {
//        name: 'Profit',
//        color: 'rgba(248,161,63,1)',
//        data: [183.6, 178.8, 198.5],
//        tooltip: {
//            valuePrefix: '$',
//            valueSuffix: ' M'
//        },
//        pointPadding: 0.3,
//        pointPlacement: 0.2,
//        yAxis: 1
//    }, {
//        name: 'Profit Optimized',
//        color: 'rgba(186,60,61,.9)',
//        data: [203.6, 198.8, 208.5],
//        tooltip: {
//            valuePrefix: '$',
//            valueSuffix: ' M'
//        },
//        pointPadding: 0.4,
//        pointPlacement: 0.2,
//        yAxis: 1
//    }
    ]
});

Highcharts.chart('grProductos', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Relación Productos Existencia/Apartado'
    },
    xAxis: {
//        categories: [            'Seattle HQ',            'San Francisco',            'Tokyo'        ]
    },
    yAxis: [{
        min: 0,
        title: {
            text: ''
        },
        labels: {
          format: '{value} PZAS',
//          style: {
//              color: Highcharts.getOptions().colors[1]
//          }
      }
    
    }
    
//    , {
//        title: {
//            text: 'Profit (millions)'
//        },
//        opposite: true
//    }
    ],
    legend: {
        shadow: false
    },
    tooltip: {
        shared: true
    },
    plotOptions: {
        column: {
            grouping: false,
            shadow: false,
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
						
//						console.dir(this);
					}
				}
			}
			
		}
    },
    series: [{
        name: 'Existencia',
        color: 'rgba(248,161,63,1)',
//        data: [150, 73, 20],
        pointPadding: 0.3,
        pointPlacement: -0.2
    }, {
        name: 'Apartado',
        color: 'rgba(186,60,61,.9)',
//        data: [140, 90, 40],
        pointPadding: 0.4,
        pointPlacement: -0.2
    }
//    , {
//        name: 'Profit',
//        color: 'rgba(248,161,63,1)',
//        data: [183.6, 178.8, 198.5],
//        tooltip: {
//            valuePrefix: '$',
//            valueSuffix: ' M'
//        },
//        pointPadding: 0.3,
//        pointPlacement: 0.2,
//        yAxis: 1
//    }, {
//        name: 'Profit Optimized',
//        color: 'rgba(186,60,61,.9)',
//        data: [203.6, 198.8, 208.5],
//        tooltip: {
//            valuePrefix: '$',
//            valueSuffix: ' M'
//        },
//        pointPadding: 0.4,
//        pointPlacement: 0.2,
//        yAxis: 1
//    }
    ]
});

$(document).ready(function(){
	
	xajax_cargarInformacionRollos();
	xajax_cargarInformacionProductos();
	
//	var index = $('#grRollos').data('highchartsChart');	
//	var chart = Highcharts.charts[index];
//	
//	chart.xAxis[0].setCategories(['uno', 'dos', 'tres']);
//	
//	
//    //chart.series[0].setData([2,3,4], false);
//    //chart.series[1].setData([1,2,3], false);
//	
//	
//	chart.series[0].addPoint({idRollo: 1, name: 'eluno', y: 2});
//	chart.series[0].addPoint({idRollo: 2, name: 'elcuatro', y: 4});
//	chart.series[0].addPoint({idRollo: 3, name: 'elseis', y: 6});
//	
//	chart.series[1].addPoint({existencia: 1, name: 'e1', y: 1});
//	chart.series[1].addPoint({existencia: 2, name: 'e2', y: 3});
//	chart.series[1].addPoint({existencia: 3, name: 'e3', y: 2});    
//	
//    chart.redraw();
    
//    index = $('#grProductos').data('highchartsChart');	
//	var chartP = Highcharts.charts[index];
//	
//	chartP.xAxis[0].setCategories(['uno', 'dos', 'tres']);
//	
//	
//    //chart.series[0].setData([2,3,4], false);
//    //chart.series[1].setData([1,2,3], false);
//	
//	
//	chartP.series[0].addPoint({idRollo: 1, name: 'eluno', y: 2});
//	chartP.series[0].addPoint({idRollo: 2, name: 'elcuatro', y: 4});
//	chartP.series[0].addPoint({idRollo: 3, name: 'elseis', y: 6});
//	
//	chartP.series[1].addPoint({existencia: 1, name: 'e1', y: 1});
//	chartP.series[1].addPoint({existencia: 2, name: 'e2', y: 3});
//	chartP.series[1].addPoint({existencia: 3, name: 'e3', y: 2});    
//	
//    chartP.redraw();
	
	
});