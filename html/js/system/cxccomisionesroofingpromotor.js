
var app = new Vue({
    el: '#app',
    data: {
        mostrarBotonGeneraCorteComision: true,
        seleccionandoPromotor: true,
        filtroNombreCliente: '',

        filtro: {
			promotor: 0,
			nombrePromotor: '',
            img: '',
			fechaInicio: '',
			fechaFin: '',
		}		,

		errFechaInicio: '',
        errFechaFin: '',
        
        incentivos: [],
        incentivo: 0,
        incentivoPorcentaje: 0,

        promotores: [],

        pedidos: [],
        pedidosSinCorteComision: [],
        
        comisionesanticipadas: [],
        totalDeducciones: 0,

        mostrarGrafico: true,

        comisionTotalComisiones: 0,
        comisionTotalPagadas: 0,
        comisionTotalPorPagar: 0,
        comisionTotalPendiente: 0,
        totalPedidos: 0
    },
    mounted: function(){
        xajax_cargarPromotores();
        xajax_cargarTablaIncentivos();
        
//        alert("mounted");
//       setTimeout(function(){ xajax_pruebautf();}, 2000);
        
//        this.filtro.promotor=13;
    },
    watch: {
        comisionTotalPorPagar: function(valor){
            this.incentivoPorcentaje = 0;
console.log("com: " + this.totalPedidos);
            for(var i=0 ; i < this.incentivos.length ; i++)
            {
                if (this.totalPedidos >= this.incentivos[i].inicio && this.totalPedidos <= this.incentivos[i].fin)
                {
                    console.log("porcentaje " + this.incentivos[i].inicio);
                    this.incentivoPorcentaje = this.incentivos[i].porcentaje;
                    console.log("incentivo xalculado: "+ this.incentivoPorcentaje);
                    break;
                }
            }

            this.incentivo = this.comisionTotalPorPagar * this.incentivoPorcentaje / 100;
        },
       totalPedidos: function(valor){
            this.incentivoPorcentaje = 0;
console.log("tot: " + this.totalPedidos);
            for(var i=0 ; i < this.incentivos.length ; i++)
            {
                if (this.totalPedidos >= this.incentivos[i].inicio && this.totalPedidos <= this.incentivos[i].fin)
                {
                    console.log("porcentaje " + this.incentivos[i].inicio);
                    this.incentivoPorcentaje = this.incentivos[i].porcentaje;
                    console.log("incentivo xalculado: "+ this.incentivoPorcentaje);
                    break;
                }
            }

            this.incentivo = this.comisionTotalPorPagar * this.incentivoPorcentaje / 100;
        } 
    },
    computed: {
    	netoAPagar: function()
    	{
    		return this.comisionTotalPorPagar + this.incentivo - this.totalDeducciones;
    	}
    },
    methods: {
        obtenerReporte: function(){
            var desde = $("#dtFechaInicio").val();
			var hasta = $("#dtFechaFin").val();
			var seguir = true;

			this.errFechaInicio = '';
			this.errFechaFin = '';

			var strFechaInicial = desde.substring(6, 10) + '' + desde.substring(3, 5) + '' + desde.substring(0, 2);
			var strFechaFinal = hasta.substring(6, 10) + '' + hasta.substring(3, 5) + '' + hasta.substring(0, 2);

//			alert(  strFechaInicial + ' ' + strFechaFinal);

//			if (hasta < desde)
			if (parseInt(strFechaFinal) < parseInt(strFechaInicial))
			{
				this.errFechaFin = "Fecha Final debe ser mayor a Inicial";
				seguir = false;
			}
			
//			console.log("*" + this.filtro.fechaInicio + "*");
//        	console.log("*" + this.filtro.fechaFin + "*");
        	
        	if (desde == "" || hasta == "")
        	{
        		saInfo("Debe indicar un rango de fechas válido.");
                seguir = false;
        	}

			if (seguir)
			{
				this.filtro.fechaInicio = desde;
				this.filtro.fechaFin = hasta;
				xajax_obtenerReporte(this.filtro);
				
			}


        },
        cargarComisionesAnticipadasSinComision: function(){
        	
        	xajax_cargarComisionesAnticipadasSinComision(this.filtro.promotor, this.filtro.fechaInicio, this.filtro.fechaFin);
        },
        preparePromotor: function(index){

            this.filtro.promotor = this.promotores[index].id;
            this.filtro.nombrePromotor = this.promotores[index].nombre;
            this.filtro.img = this.promotores[index].img;
            this.seleccionandoPromotor = false;

            this.comisionTotalComisiones = 0;
            this.comisionTotalPagadas = 0;
            this.comisionTotalPorPagar = 0;
            this.comisionTotalPendiente = 0;

            var index = $('#container').data('highchartsChart');
            chart = Highcharts.charts[index];

            chart.setTitle({text: 'Reporte de Pedidos'});
            chart.setTitle(null, { text: ''});

            chart.xAxis[0].setCategories([]);

            chart.series[0].setData([]);

            chart.series[1].setData([]);

            chart.series[2].setData([]);

            chart.series[3].setData([]);

            chart.redraw();


        },
        seleccionarOtroPromotor: function(){
                this.seleccionandoPromotor = true;
        },
        toogleGrafico: function(){

            this.mostrarGrafico = !this.mostrarGrafico;
        },
        generaCorteComision: function()
        {
        	var i = 0;
        	
        		
//        	console.log("a pagar");
        	
            if(this.netoAPagar == 0)
            {
                saInfo("Para generar un corte de comisión, debe haber un Monto.");
                return false;
            }

            
            
            swal({
    			title: "¿Deseas continuar?",
    			text: "Se realizará el Corte de Comisión con las fechas indicadas, para el Promotor seleccionado.",
    			type: "warning",
    			showCancelButton: true,
    			cancelButtonText: "NO",
    			cancelButtonColor: "#ed5565",
    			confirmButtonColor: "#1c84c6",
    			confirmButtonText: "¡Adelante!",
    			closeOnConfirm: false },

    			function(){
    				
    				swal.close();
    				app.mostrarBotonGeneraCorteComision = false;
    				
    				app.pedidosSinCorteComision.splice(0, app.pedidosSinCorteComision.length);
//    				console.log(app.pedidos.length );
    				for (i = 0 ; i < app.pedidos.length ; i++)
//    				for (i = 0 ; i < 10 ; i++)
    				{
    					if (app.pedidos[i].idCorteComision == 0 || app.pedidos[i].idCorteComisionVendedor == 0)
    					{
    						app.pedidosSinCorteComision.push({
    							idPedido: app.pedidos[i].idPedido,
    							miCliente: app.pedidos[i].miCliente,
    							});
    					}
//    					console.log(app.pedidos[i].idPedido);
    				}
    				
//    				console.log("app.filtro:");
//    				console.dir(app.filtro); 
////    				console.log("app.pedidosSinCorteComision: " + app.pedidosSinCorteComision); 
//    				console.log("app.comisionesanticipadas: ");
//    				console.dir(app.comisionesanticipadas); 
//    				console.log("app.comisionTotalPorPagar: " + app.comisionTotalPorPagar); 
//    				console.log("app.totalDeducciones: " + app.totalDeducciones); 
//    				console.log("app.netoAPagar: " + app.netoAPagar);
//    				
    				xajax_generarCorteComision(app.filtro, 
    				                               app.pedidosSinCorteComision, 
    				                               app.comisionesanticipadas , 
    				                               app.comisionTotalPorPagar, 
    				                               app.totalDeducciones, 
                                                   app.netoAPagar,
                                                   app.incentivo
    				                               );
//    				xajax_generarCorteComisionV2(app.filtro);

    				
    				
    				
    				//    				xajax_pruebautf();
//    				xajax_generarCorteComision(app.filtro, app.pedidosSinCorteComision, app.comisionesanticipadas , app.comisionTotalPorPagar, app.totalDeducciones, app.netoAPagar);
    				
    			
    		});
            
        },
		sendToExcel: function(){

			sendToExcel("tblReporte", "Comisiones", "Listado de Comisiones " + this.filtro.nombrePromotor, "Del: " + this.filtro.fechaInicio + " al: " + this.filtro.fechaFin, 1, "D|E");
			//alert("enviamos");
		}
    }


});


Highcharts.chart('container', {
    chart: {
        type: 'line'
    },
    title: {
        text: 'Historic and Estimated Worldwide Population Growth by Region'
    },
    subtitle: {
        text: 'Source: Wikipedia.org'
    },
    xAxis: {
        categories: [],
        tickmarkPlacement: 'on',
        title: {
            enabled: false
        }
    },
    yAxis: {
        title: {
            text: 'Pedidos'
        },
        labels: {
            formatter: function () {
                // return this.value / 1000;
                return this.value;
            }
        }
    },
    tooltip: {
        split: true,
        valueSuffix: ' Pedidos'
    },
    plotOptions: {
        area: {
            stacking: 'normal',
            lineColor: '#666666',
            lineWidth: 1,
            marker: {
                lineWidth: 1,
                lineColor: '#666666'
            }
        }
    },
    // labels: {
    //     items: [{
    //         html: 'Total fruit consumption',
    //         style: {
    //             left: '50px',
    //             top: '18px',
    //             color: (Highcharts.theme && Highcharts.theme.textColor) || 'blue'
    //         }
    //     }]
    // },
    series: [
            {
                name: 'Generados',
                // color: '#23c6c8',
                color: 'LightSkyBlue',
                data: []
            }, {
                name: 'Saldados',
                // color: '#1ab394',
                color: 'springgreen',
                data: []
            }, {
                name: 'Comisión Pagada',
                color: 'limegreen',
                data: []
            }, {
                name: 'Por Saldar',
                color: 'red',
                data: []
            }
    ]
});

var chart;
var nopedidos;
var saldados;
var porsaldar;
var comisionpagada;

$(document).ready(function()
{

    $('#dtFechaInicio').datepicker({
	    todayBtn: "linked",
	    keyboardNavigation: false,
	    forceParse: false,
	    calendarWeeks: true,
	    autoclose: true,
	    format: 'dd/mm/yyyy'
	});

	$('#dtFechaFin').datepicker({
	    todayBtn: "linked",
	    keyboardNavigation: false,
	    forceParse: false,
	    calendarWeeks: true,
	    autoclose: true,
	    format: 'dd/mm/yyyy'
	});

    var index = $('#container').data('highchartsChart');
    chart = Highcharts.charts[index];

    nopedidos = chart.renderer.text('Total Pedidos: ', 70, 90)
        .css({
            fontSize: '12px',
            color: '#0d60fc'
        })
        .add();

    saldados = chart.renderer.text('Saldados: ', 70, 105)
        .css({
            fontSize: '12px',
            color: '#00a123'
        })
        .add();

    porsaldar = chart.renderer.text('Por Saldar: ', 70, 120)
            .css({
                fontSize: '12px',
                color: '#ff0020'
            })
            .add();

    comisionpagada = chart.renderer.text('Comisión Pagada: ', 70, 135)
                .css({
                    fontSize: '12px',
                    color: '#074f00'
                })
                .add();

    // var index = $('#container').data('highchartsChart');
    // chart = Highcharts.charts[index];
    //
    // chart.setTitle({text: 'El Titulillo'});
    // chart.setTitle(null, { text: 'New subtitle '});
    //
    // chart.xAxis[0].setCategories(['1','2','3','4','5','6','7']);
    //
    // chart.series[0].setData([]);
    // chart.series[0].setData([502, 635, 809, 947, 1402, 3634, 5268,502, 635, 809, 947, 1402, 3634, 5268,502, 635, 809, 947, 1402, 3634, 5268,502, 635, 809, 947, 1402, 3634, 5268], false);
    // chart.redraw();
});



    //
    // var index = $('#container').data('highchartsChart');
	// chart = Highcharts.charts[index];
    //
    // chart.setTitle({text: "El Titulillo"});
    // chart.setTitle(null, { text: 'New subtitle '});

    //
    // var title = chart.renderer.text('Total fruits consumption', 100, 90)
    //     .css({
    //         fontSize: '12px'
    //     })
    //     .add();
    //
    //  // chart.xAxis[0].setCategories(['1','2','3','4','5','6','7']);
    // //
    // // chart.xAxis[0].setCategories([" . $categorias . "]);
    // //
    // //alert("cambiando");
    // setTimeout (function() {
    //
    //     chart.series[0].setData([]);
    // 	chart.series[0].setData([502, 635, 809, 947, 1402, 3634, 5268,502, 635, 809, 947, 1402, 3634, 5268,502, 635, 809, 947, 1402, 3634, 5268,502, 635, 809, 947, 1402, 3634, 5268], false);
    //     chart.redraw();
    // }, 1000);
    //
    // setTimeout(function() {title.attr({text: 'holi'});}, 3000);
    //
    // setTimeout(function() {title.attr({display: 'none'});}, 5000);
    //
    // setTimeout(function() {title.attr({display: 'block'});}, 7000);
    //
    // setTimeout(function() {title.css({color: 'blue'});}, 9000);



    // chart.series[0].setData([]);
	// chart.series[0].setData([502, 635, 809, 947, 1402, 3634, 5268,502, 635, 809, 947, 1402, 3634, 5268,502, 635, 809, 947, 1402, 3634, 5268,502, 635, 809, 947, 1402, 3634, 5268], false);



// Highcharts.chart('container', {
//     chart: {
//         type: 'area'
//     },
//     title: {
//         text: 'Historic and Estimated Worldwide Population Growth by Region'
//     },
//     subtitle: {
//         text: 'Source: Wikipedia.org'
//     },
//     xAxis: {
//         categories: ['1750', '1800', '1850', '1900', '1950', '1999', '2050','1750', '1800', '1850', '1900', '1950', '1999', '2050','1750', '1800', '1850', '1900', '1950', '1999', '2050','1750', '1800', '1850', '1900', '1950', '1999', '2050'],
//         tickmarkPlacement: 'on',
//         title: {
//             enabled: false
//         }
//     },
//     yAxis: {
//         title: {
//             text: 'Billions'
//         },
//         labels: {
//             formatter: function () {
//                 // return this.value / 1000;
//                 return this.value;
//             }
//         }
//     },
//     tooltip: {
//         split: true,
//         valueSuffix: ' millions'
//     },
//     plotOptions: {
//         area: {
//             stacking: 'normal',
//             lineColor: '#666666',
//             lineWidth: 1,
//             marker: {
//                 lineWidth: 1,
//                 lineColor: '#666666'
//             }
//         }
//     },
//     series: [{
//         name: 'Asia',
//         color: '#fcb3bc',
//         data: [502, 635, 809, 947, 1402, 3634, 5268,502, 635, 809, 947, 1402, 3634, 5268,502, 635, 809, 947, 1402, 3634, 5268,502, 635, 809, 947, 1402, 3634, 5268]
//     }, {
//         name: 'Africa',
//         data: [106, 107, 111, 133, 221, 767, 1766,106, 107, 111, 133, 221, 767, 1766,106, 107, 111, 133, 221, 767, 1766,106, 107, 111, 133, 221, 767, 1766]
//     }, {
//         name: 'Europe',
//         data: [163, 203, 276, 408, 547, 729, 628,163, 203, 276, 408, 547, 729, 628,163, 203, 276, 408, 547, 729, 628,163, 203, 276, 408, 547, 729, 628]
//     }, {
//         name: 'America',
//         data: [18, 31, 54, 156, 339, 818, 1201,18, 31, 54, 156, 339, 818, 1201,18, 31, 54, 156, 339, 818, 1201,18, 31, 54, 156, 339, 818, 1201]
//     }, {
//         name: 'Oceania',
//         data: [2, 2, 2, 6, 13, 30, 46,2, 2, 2, 6, 13, 30, 46,2, 2, 2, 6, 13, 30, 46,2, 2, 2, 6, 13, 30, 46]
//     }]
// });
//



//
//
// Highcharts.chart('container', {
//
//     title: {
//         text: 'Solar Employment Growth by Sector, 2010-2016'
//     },
//
//     subtitle: {
//         text: 'Source: thesolarfoundation.com'
//     },
//
//     yAxis: {
//         title: {
//             text: 'Number of Employees'
//         }
//     },
//     legend: {
//         layout: 'vertical',
//         align: 'right',
//         verticalAlign: 'middle'
//     },
//     //
//     // plotOptions: {
//     //     series: {
//     //         label: {
//     //             connectorAllowed: false
//     //         },
//     //         pointStart: 2010
//     //     }
//     // }
//     // ,
//
//     series: [{
//         name: 'Installation',
//         data: [30, 20, 10, 30, 40,30, 20, 10, 30, 40,30, 20, 10, 30, 40,30, 20, 10, 30, 40,30, 20, 10, 30, 40,30, 20, 10, 30, 40,30, 20, 10, 30, 40,30, 20, 10, 30, 40,30, 20, 10, 30, 40,30, 20, 10, 30, 40]
//     }, {
//         name: 'Manufacturing',
//         data: [30,15,8,22,35,30,15,8,22,35,30,15,8,22,35,30,15,8,22,35,30,15,8,22,35,30,15,8,22,35,30,15,8,22,35,30,15,8,22,35,30,15,8,22,35,30,15,8,22,35]
//     }, {
//         name: 'Sales & Distribution',
//         data: [2,5,7,5,12,2,5,7,5,12,2,5,7,5,12,2,5,7,5,12,2,5,7,5,12,2,5,7,5,12,2,5,7,5,12,2,5,7,5,12,2,5,7,5,12,2,5,7,5,12,2,5,7,5,12,2,5,7,5,12]
//     }],
//
//     responsive: {
//         rules: [{
//             condition: {
//                 maxWidth: 500
//             },
//             chartOptions: {
//                 legend: {
//                     layout: 'horizontal',
//                     align: 'center',
//                     verticalAlign: 'bottom'
//                 }
//             }
//         }]
//     }
//
// });

//
//
// Highcharts.chart('container', {
//     title: {
//         text: 'Combination chart'
//     },
//     xAxis: {
//         categories: ['Apples', 'Oranges', 'Pears', 'Bananas', 'Plums','Apples', 'Oranges', 'Pears', 'Bananas', 'Plums','Apples', 'Oranges', 'Pears', 'Bananas', 'Plums','Apples', 'Oranges', 'Pears', 'Bananas', 'Plums','Apples', 'Oranges', 'Pears', 'Bananas', 'Plums','Apples', 'd', 'v', 'b', 'a','Apples', 'Oranges', 'Pears', 'Bananas', 'Plums','Apples', 'Oranges', 'Pears', 'Bananas', 'Plums','Apples', 'Oranges', 'Pears', 'Bananas', 'Plums','Apples', 'Oranges', 'Pears', 'Bananas', 'Plums','Apples', 'Oranges', 'Pears', 'Bananas', 'Plums','Apples', 'd', 'v', 'b', 'a']
//     },
//     labels: {
//         items: [{
//             html: 'Total fruit consumption',
//             style: {
//                 left: '50px',
//                 top: '18px',
//                 color: (Highcharts.theme && Highcharts.theme.textColor) || 'blue'
//             }
//         }]
//     },
//     series: [{
//                 type: 'column',
//                 name: 'Jane',
//                 color: 'cyan',
//                 // data: [30, 20, 10, 30, 40,30, 20, 10, 30, 40,30, 20, 10, 30, 40,30, 20, 10, 30, 40,30, 20, 10, 30, 40,30, 20, 10, 30, 40,30, 20, 10, 30, 40,30, 20, 10, 30, 40,30, 20, 10, 30, 40,30, 20, 10, 30, 40]
//                 data: [30, 20, 10, 30, 40,30, 20]
//             },
//             {
//             type: 'spline',
//             name: 'Average',
//             color: 'green',
//             // data: [30,15,8,22,35,30,15,8,22,35,30,15,8,22,35,30,15,8,22,35,30,15,8,22,35,30,15,8,22,35,30,15,8,22,35,30,15,8,22,35,30,15,8,22,35,30,15,8,22,35],
//             data: [30,15,8,22,35,30,15],
//             marker: {
//                 lineWidth: 2,
//                 // lineColor: Highcharts.getOptions().colors[3],
//                 lineColor: 'green',
//                 fillColor: 'lightgreen'
//                 }
//             },
//             {
//             type: 'spline',
//             name: 'Average',
//             color: 'red',
//             // data: [2,5,7,5,12,2,5,7,5,12,2,5,7,5,12,2,5,7,5,12,2,5,7,5,12,2,5,7,5,12,2,5,7,5,12,2,5,7,5,12,2,5,7,5,12,2,5,7,5,12,2,5,7,5,12,2,5,7,5,12],
//             data: [2,5,7,5,12,2,7],
//             marker: {
//                 lineWidth: 2,
//                 // lineColor: Highcharts.getOptions().colors[3],
//                 lineColor: 'red',
//                 fillColor: 'lightred'
//                 }
//             }
//
//         ]
// });
