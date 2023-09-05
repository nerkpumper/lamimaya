
var app = new Vue({
    el: '#app',
    data: {
        mostrarBotonGeneraCorteComision: true,
        seleccionandoPromotor: true,
        showBotonOtroPromotor: true,
        filtroNombreCliente: '',

        //filtro por mes, trimestre, anio
        tipoComision: 'NOSEL',
        mes: 0,
        trimestre: 0,
        anio: 0,
        strTipoObjetivo: "",
        
        //comisiones detalle
        comIdPedido: 0,
        comCliente: '',
        comPromotor: '',
        comVendedor: '',
        comSubtotal: 1,
        comTotal: 1,
        comOtrosCargos: 0,
        comDescuento: 0,
        comPorDescuento: 0,
        comDetalle: [{
        	renglon: 1,
        	idProducto: 1,
        	detProducto: '',
        	cantidad: '',
        	total: '',
        	tipoprecio: '',
        	porcomision: 1,
        	comision: 1}        	
        ],
        comTotalComisiones: 0,
        

        filtro: {
			promotor: 0,
			nombrePromotor: '',
            img: '',
			tipoComision: '',
            mes: 0,
            anio: 0
		}		,

		errFechaInicio: '',
		errFechaFin: '',
		
		incentivos: [],
        incentivo: 0,
        incentivoNeto: 0,
        objetivoParaIncentivo: 0,
        objetivoMes: '',
        objetivoAnio: 0,
        // objetivoPorcentaje: 0,
        incentivoPorcentaje: 0,
        incentivoTopado: false,

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
        totalPedidos: 0,
        totalPedidosDatoVenta: 0
        
        
        
    },
    mounted: function(){
    	
        xajax_cargarPromotores();
        xajax_cargarTablaIncentivos();
        
//        this.filtro.promotor=13;
    },
    watch: {
        tipoComision: function(val){
            this.calcularIncentivo();
        },
        comisionTotalPorPagar: function(valor){
            this.calcularIncentivo();
        },
        totalPedidos: function(valor){
            this.calcularIncentivo();
        }             
            
    },
    computed: {        
        comisionTotalPorPagarPorPeriodo: function(){
            if (this.tipoComision == "MENSUAL")
                return this.comisionTotalPorPagar;

            return 0;
        },
    	objetivoPorcentaje: function (){
            return this.objetivoParaIncentivo > 0 ?  this.totalPedidosDatoVenta * 100 / this.objetivoParaIncentivo : 100;
        },
    	netoAPagar: function()
    	{
    		return this.comisionTotalPorPagarPorPeriodo + this.incentivoNeto - this.totalDeducciones;
    	}
    },
    methods: {
        calcularIncentivo: function(){
            this.incentivoPorcentaje = 0;
            this.incentivoNeto = 0;
            
            
// console.log("com: " + this.totalPedidos);
            // for(var i=0 ; i < this.incentivos.length ; i++)
            // {
            //     if (this.totalPedidos >= this.incentivos[i].inicio && this.totalPedidos <= this.incentivos[i].fin)
            //     {
            //         // console.log("porcentaje " + this.incentivos[i].inicio);
            //         this.incentivoPorcentaje = this.incentivos[i].porcentaje;
            //         // console.log("incentivo xalculado: "+ this.incentivoPorcentaje);
            //         break;
            //     }
            // }
            if(this.objetivoPorcentaje >= 80 && this.objetivoPorcentaje < 86){
                this.incentivoPorcentaje = 5;
            }else if(this.objetivoPorcentaje >= 86 && this.objetivoPorcentaje < 91){
                this.incentivoPorcentaje = 10;
            }else if(this.objetivoPorcentaje >= 91 && this.objetivoPorcentaje < 96){
                this.incentivoPorcentaje = 15;
            }else if(this.objetivoPorcentaje >= 96 && this.objetivoPorcentaje < 101){
                this.incentivoPorcentaje = 20;
            }else if(this.objetivoPorcentaje >= 101){
                this.incentivoPorcentaje = 25;
            }
            	
            if (this.existe4132())
            {
            	this.incentivo = (this.comisionTotalPorPagar - 9597.29)  * this.incentivoPorcentaje / 100;
            }
            else
            {
            	this.incentivo = this.comisionTotalPorPagar * this.incentivoPorcentaje / 100;            	
            }

            if(app.filtro.promotor ==15){
                this.incentivoNeto =0;
                this.objetivoParaIncentivo = 0;
                this.incentivo=0;
                }else{
                this.incentivoNeto = this.incentivo;
                }   

            // // console.log("verificar Objetivo Porcentaje");
            // if (this.objetivoPorcentaje > 0)
            // {
            //     // console.log("Objetivo Porcentaje > 0");
            //     if (this.objetivoPorcentaje < 100)
            //     {
            //         // console.log("Objetivo Porcentaje < 100");
            //         this.incentivoNeto = this.incentivo * this.objetivoPorcentaje / 100;
            //     }                
            // }

            if (this.tipoComision == "MENSUAL")
            {
                console.log("cálculo Mensual");
                if (this.incentivoNeto > 10000)
                    this.incentivoNeto = 10000;
                    if (this.incentivo > 10000){
                        this.incentivo = 10000;
                        this.incentivoTopado = true;
                    }else{
                        this.incentivoTopado = false; 
                    }              
            }

            
            if (this.tipoComision == "TRIMESTRAL")
            {   
                console.log("cálculo Trimestral");
                this.incentivoNeto = this.totalPedidos * 0.0003;
            }
            else if (this.tipoComision == "ANUAL")
            {
                console.log("cálculo Anual");
                this.incentivoNeto = this.totalPedidos * 0.0007;
            }
            
            if (this.tipoComision != "MENSUAL")
            {                
                this.comisionTotalComisiones = 0;
                if (this.objetivoPorcentaje < 90)
                {
                   this.incentivoNeto = 0; 
                }
                
            }
        },
        existe4132: function()
    	{
    		var resultado = false;
    		
    		for (i = 0 ; i < app.pedidos.length ; i++)
//				for (i = 0 ; i < 10 ; i++)
				{
					if (app.pedidos[i].idPedido == 4132)
					{
						resultado = true;
						return resultado;
					}
//					console.log(app.pedidos[i].idPedido);
				}
    		
    		return resultado;
    	},
        obtenerReporte: function(){
            // tipoComision: 'NOSEL',
            // mes: 0,
            // trimestre: 0,
            // anio: 0,
            var tipo = "";
            var strMes = "";
            var mes = 0;
            this.strTipoObjetivo = "";
           

            if (this.tipoComision == 'NOSEL' || (this.mes == 0 && this.tipoComision == "MENSUAL") || (this.trimestre == 0 && this.tipoComision == "TRIMESTRAL") || this.anio == 0){
                saInfo("Debe seleccionar los parametros correctos");
                return;
            }
            
            if (this.tipoComision == "MENSUAL"){
                tipo = "M";
                mes = this.mes;
                if (this.mes == 1){
                    strMes = "ENERO";
                }
                else if (this.mes == 2){
                    strMes = "FEBRERO";
                }
                else if (this.mes == 3){
                    strMes = "MARZO";
                }
                else if (this.mes == 4){
                    strMes = "ABRIL";
                }
                else if (this.mes == 5){
                    strMes = "MAYO";
                }
                else if (this.mes == 6){
                    strMes = "JUNIO";
                }
                else if (this.mes == 7){
                    strMes = "JULIO";
                }
                else if (this.mes == 8){
                    strMes = "AGOSTO";
                }
                else if (this.mes == 9){
                    strMes = "SEPTIEMBRE";
                }
                else if (this.mes == 10){
                    strMes = "OCTUBRE";
                }
                else if (this.mes == 11){
                    strMes = "NOVIEMBRE";
                }
                else if (this.mes == 12)
                    strMes = "DICIEMBRE";
            }
            else if (this.tipoComision == "TRIMESTRAL"){
                tipo = "T";
                mes = this.trimestre;
                if (this.trimestre == 1){
                    strMes = "ENERO-MARZO";
                }
                else if (this.trimestre == 2){
                    strMes = "ABRIL-JUNIO";
                }
                else if (this.trimestre == 3){
                    strMes = "JULIO-SEPTIEMBRE";
                }
                else if (this.trimestre == 4){
                    strMes = "OCTUBRE-DICIEMBR";
                }
            }
            else if (this.tipoComision == "ANUAL"){
                tipo = "A";            
            }

            // console.log(URL_BASE + 'api/cxccomisionespromotor.api.php?method=getObjetivo&tipo='+tipo+'&mes='+mes+'&anio='+this.anio+'&idPromotor='+this.filtro.promotor);
            var vm = this;
            axios.get(URL_BASE + 'api/cxccomisionespromotor.api.php?method=getObjetivo&tipo='+tipo+'&mes='+mes+'&anio='+this.anio+'&idPromotor='+this.filtro.promotor, getAxiosHeaders())
            .then(function (response) {
                // console.log(response.data);
                if (!response.data.error){
                    console.log("Objetivo " + response.data.objetivo);
                    app.objetivoParaIncentivo = response.data.objetivo; 
                    if (tipo == "A"){
                        app.strTipoObjetivo = app.tipoComision + " - " + app.anio;
                    }
                    else{
                        app.strTipoObjetivo = app.tipoComision + " - " + strMes + " - " + app.anio;
                    }

                    app.filtro.tipoComision = tipo;
                    app.filtro.mes = mes;
                    app.filtro.anio = app.anio;					
                    xajax_obtenerReporte(app.filtro);
                }
                else{
                    saError("No se ha encontrado el Objetivo para el vendedor con los parametros seleccionados.");
                }
                
                
            })
            .catch(function (error) {
                console.log(error);
            });



        },
        cargarComisionesAnticipadasSinComision: function(){
        	xajax_cargarComisionesAnticipadasSinComision(this.filtro.promotor, this.filtro.tipoComision, this.filtro.mes, this.filtro.anio);
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

            setTimeout(function(){ xajax_obtenerObjetivoParaIncentivo(app.filtro.promotor);}, 500);

        },
        seleccionarOtroPromotor: function(){
                this.seleccionandoPromotor = true;
        },
        toogleGrafico: function(){

            this.mostrarGrafico = !this.mostrarGrafico;
        },
        generaCorteComision: function()
        {
            
        },
        mostrarDetalleComisiones: function(idPedido){
        	
        	this.comIdPedido = idPedido;
        	
        	$("#modalComisiones").modal();
//        	$("#modalComisiones").modal('toggle');
        	
        	
//        	alert("mostrar comisiones pedido " + idPedido);
        },
		sendToExcel: function(){

			console.log("antes de enviar");
			sendToExcel("tblReporte", "Comisiones", "Listado de Comisiones " + this.filtro.nombrePromotor, "Del: " + this.filtro.fechaInicio + " al: " + this.filtro.fechaFin, 1);
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
