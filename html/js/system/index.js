$(document).ready(function(){


    $('.slick_demo_1').slick({
        dots: true
    });

});
var gcurrentTime = new Date()
// returns the year (four digits)

var gyear = gcurrentTime.getFullYear()


$(document).ready(function(){	
//	$('#openmodal').modal('show');
	
//	setTimeout(function(){$('#openmodal').modal('hide');},10000);
	//$('#openmodal').modal('hide');
	
	$('#dtFechaEntrega').datepicker({
	    todayBtn: "linked",
	    keyboardNavigation: false,
	    forceParse: false,
	    calendarWeeks: true,
	    autoclose: true,
	    format: 'dd/mm/yyyy'
	});

	$('.clockpicker').clockpicker();
});



var app = new Vue ({
el: '#app',
data:{
movimientos:[],
movimientos1:[],
totalDia:1,
idUsuarioCaptura:0,
pedidoTotal:0,
totales: [],
pedidosDelDia:[],
pedidosDelDia1:[],
acumuladoPromotor:[],
produccionAcanalado:[],
produccionAcanaladoDia:[],
produccionMoldura:[],
pedidosPorVencer:[],
lstSucursales:[],
nombreSucursal:"TORRES LANDA",
lstCotizacion:[],
lstMotivoRechazo:[],
idMotivoSeleccionado:0,
motivoRechazoDescripcion:'Seleccione Motivo ',

pedidoSeleccionado:0,
cotizacionSeleccionada:0,
idSucursalSeleccionada:0,
indexMotivoRechazo:0,


fechaEntrega:'',
errFechaEntrega:'',
errMotivoRechazo:'',
fechaCompromiso:'',
fechaHoy:'',


total:0,
porcentaje:0,
numPedidos:0,
numCliente:0,
totalClientes:0,
totalPedidos:0,
TotalDia:0,
x:1,






// mes:0,							
// mesDes: 'Hola es una variable de vue', 
// costoDerivados:0, 
// costoStock: 0,
// costoMolduras:0, 	
// costoTotal:0,

showAnio: true,
year: gyear,


},
watch: {
    idMotivoSeleccionado: function(){
        if(this.idMotivoSeleccionado== '' ){
           
        }
    
        if (this.idMotivoSeleccionado>= 0){
            this.motivoRechazoDescripcion= this.lstMotivoRechazo[this.lstMotivoRechazo.findIndex(x => x.idMotivoRechazo == this.idMotivoSeleccionado)].descripcion;    
        }
    },

    errMotivoRechazo: function(val){
        this.errMotivoRechazo = '';
        
        if (this.idMotivoSeleccionado == 0)
        {
            this.errMotivoRechazo = "Seleccione Opcion";
        }
    }
   
 },
mounted: function() {
this.cargarVentasAnuales(this.year);
this.cargarVentaDiaria();
this.cargarLstCotizacion(); 
this.cargarProduccionAcanaladoDia();
this.cargarPedidosFechaCompromisoPorVencer();
this.cargarSucursales();
this.cargarProduccionSucursal();
this.cargarLstMotivoRechazo();


},
methods: {
cargarVentaDiaria: function(){
        
    xajax_cargarRecibos(); 
    xajax_cargarTotales();
    xajax_pedidosDelDia();
    xajax_acumuladoPromotor();
    xajax_grafico();
      
    
},	



cargarProduccionSucursal(){
 

this.cargarProduccionAcanalado();
this.cargarProduccionMoldura();


},


cargarProduccionAcanalado: function(){

    $.ajax({				
        headers: getAxiosHeaders(),   
        url: URL_BASE + 'api/rptproduccionacanalado.api.php?method=getProduccionAcanaladoMensual&idSucursal='+ this.idSucursalSeleccionada,
            success:function(response){
                // console.log(response.list);
                app.produccionAcanalado = response.lst;				
            },
            error: function (jqXHR, textStatus, errorThrown) { 
                console.log("error");
            }
        });

    // axios.get(URL_BASE + 'api/rptproduccionacanalado.api.php?method=getProduccionAcanaladoMensual&idSucursal='+ this.idSucursalSeleccionada)
    //         .then(function (response) {
            
    //             app.produccionAcanalado = response.data.lst;				

    //         })
    //         .catch(function (error) {
    //             console.log(error);
    //         });  
},  
cargarProduccionAcanaladoDia: function(){
    
    $.ajax({				
        headers: getAxiosHeaders(),   
        url: URL_BASE + 'api/rptproduccionacanalado.api.php?method=getAcanaladoDiario',
            success:function(response){
                // console.log(response.list);
                app.produccionAcanaladoDia = response.lst;
            },
            error: function (jqXHR, textStatus, errorThrown) { 
                console.log("error");
            }
        });
    
    // axios.get(URL_BASE + 'api/rptproduccionacanalado.api.php?method=getAcanaladoDiario')
    //         .then(function (response) {
            
    //             app.produccionAcanaladoDia = response.data.lst;				

    //         })
    //         .catch(function (error) {
    //             console.log(error);
    //         });  
}, 
cargarProduccionMoldura: function(){

    $.ajax({				
        headers: getAxiosHeaders(),   
        url: URL_BASE + 'api/produccionmoldura.api.php?method=getProduccionMoldura&idSucursal='+ this.idSucursalSeleccionada,
            success:function(response){
                app.produccionMoldura = response.lst;
            },
            error: function (jqXHR, textStatus, errorThrown) { 
                console.log("error");
            }
        });


    // axios.get(URL_BASE + 'api/produccionmoldura.api.php?method=getProduccionMoldura&idSucursal='+ this.idSucursalSeleccionada)
    //         .then(function (response) {          
    //             app.produccionMoldura = response.data.lst;
              
                		
    //         })
    //         .catch(function (error) {
    //             console.log(error);
    //         });  

},
cargarPedidosFechaCompromisoPorVencer: function(){
   
    $.ajax({				
        headers: getAxiosHeaders(),   
        url: URL_BASE + 'api/pedido.api.php?method=getFechaCompromisoPorVencer&idUsuarioCaptura='+_IDUSUARIO,
            success:function(response){
                app.pedidosPorVencer = response.lst;
            },
            error: function (jqXHR, textStatus, errorThrown) { 
                console.log("error");
            }
        });

    // axios.get(URL_BASE + 'api/pedido.api.php?method=getFechaCompromisoPorVencer&idUsuarioCaptura='+_IDUSUARIO)
    //         .then(function (response) {          
    //             app.pedidosPorVencer = response.data.lst;
       		
    //         })
    //         .catch(function (error) {
    //             console.log(error);
    //         });  

},   
cargarLstCotizacion(){

    $.ajax({				
        headers: getAxiosHeaders(),   
        url: URL_BASE + 'api/cotizacion.api.php?method=getCotizacion&idUsuarioCaptura='+_IDUSUARIO,
            success:function(response){
                app.lstCotizacion = response.lst;				
            },
            error: function (jqXHR, textStatus, errorThrown) { 
                console.log("error");
            }
        });

    // axios.get(URL_BASE + 'api/cotizacion.api.php?method=getCotizacion&idUsuarioCaptura='+_IDUSUARIO)
    // .then(function (response) {
    
    //     app.lstCotizacion = response.data.lst;				

    // })
    // .catch(function (error) {
    //     console.log(error);
    // });  
    
}, 

modalUpdateFechaCompromiso: function(pedidoSeleccionado){
  app.pedidoSeleccionado = pedidoSeleccionado;
   $('#modalUpdateFechaCompromiso').modal('show');  
}, 
modalRechazoCotizacion: function(cotizacionSeleccionada){
    this.cargarLstMotivoRechazo();
    app.cotizacionSeleccionada = cotizacionSeleccionada;
     $('#modalRechazoCotizacion').modal('show');  
  }, 

   

cargarSucursales: function(){
    
    $.ajax({				
        headers: getAxiosHeaders(),   
        url: URL_BASE + 'api/sucursal.api.php?method=getSucursales',
            success:function(response){
                app.lstSucursales = response.list;				
                // console.log(app.idSucursalSeleccionada);
                // app.x=(app.idSucursalSeleccionada)-1;
                // app.nombreSucursal=app.lstSucursales[app.x].nombre;
            },
            error: function (jqXHR, textStatus, errorThrown) { 
                console.log("error");
            }
        });
    
    // axios.get(URL_BASE + 'api/sucursal.api.php?method=getSucursales')
    // .then(function (response) {
    
    //     app.lstSucursales = response.data.list;				

    // })
    // .catch(function (error) {
    //     console.log(error);
    // });  


},
cargarLstMotivoRechazo: function(){
    
    $.ajax({				
        headers: getAxiosHeaders(),   
        url: URL_BASE + 'api/motivorechazo.api.php?method=getMotivoRechazo',
            success:function(response){
                app.lstMotivoRechazo = response.lst;				
            },
            error: function (jqXHR, textStatus, errorThrown) { 
                console.log("error");
            }
        });

    // axios.get(URL_BASE + 'api/motivorechazo.api.php?method=getMotivoRechazo')
    // .then(function (response) {
    
    //     app.lstMotivoRechazo = response.data.lst;				

    // })
    // .catch(function (error) {
    //     console.log(error);
    // });  



},
updateFechaCompromiso  : function(){
  
    app.errFechaEntrega = "";
			
			
			var seguir = true;
			var fechaEngrega = $("#dtFechaEntrega").val();

			var today = new Date();
			var dd = today.getDate();
			var mm = today.getMonth()+1; //January is 0!
			var yyyy = today.getFullYear();

            if(dd<10) {
			    dd = '0'+dd
			}

			if(mm<10) {
			    mm = '0'+mm
			}
			
			
			
			var strFechaEntrega = fechaEngrega.substring(6, 10) + '-' + fechaEngrega.substring(3, 5) + '-' + fechaEngrega.substring(0, 2);
			app.fechaCompromiso = fechaEngrega.substring(6, 10) + '' + fechaEngrega.substring(3, 5) + '' + fechaEngrega.substring(0, 2);
			app.fechaHoy = yyyy + '' + mm + '' + dd;
			app.fechaEntrega = strFechaEntrega;
            
            
		
			if (parseInt(app.fechaCompromiso) <= parseInt(app.fechaHoy))
			{
				app.errFechaEntrega = "La Fecha de Entrega debe ser posterior al día de hoy.";
                

				seguir = false;
			}	
 
           
    if(seguir){
        console.log("paso");
        if (this.pedidoSeleccionado == "")
        {
            saTexto("Indique el Número de Pedido");
            return;
        }
        
        $.ajax({				
        headers: getAxiosHeaders(),   
        url: URL_BASE + 'api/pedido.api.php?method=updateFechaCompromiso&idPedido=' + app.pedidoSeleccionado+ '&fechaCompromiso='+app.fechaEntrega,
            success:function(response){
                if (!response.error){ 
                    $('#modalUpdateFechaCompromiso').modal('hide'); 

                    app.cargarPedidosFechaCompromisoPorVencer(); 
                    saSuccess("La fecha compromiso del pedido: "+ app.pedidoSeleccionado+" se actualizo correctamente");
                        
                }
                else{
                    saError(response.msg);
                } 
            },
            error: function (jqXHR, textStatus, errorThrown) { 
                console.log("error");
            }
        });

        // axios.get(URL_BASE + 'api/pedido.api.php?method=updateFechaCompromiso&idPedido=' + app.pedidoSeleccionado+ '&fechaCompromiso='+app.fechaEntrega, getAxiosHeaders())
        // .then(function (response) {
        //     console.log(response.data);
        //     if (!response.data.error){ 
        //         $('#modalUpdateFechaCompromiso').modal('hide'); 

        //         app.cargarPedidosFechaCompromisoPorVencer(); 
        //         saSuccess("La fecha compromiso del pedido: "+ app.pedidoSeleccionado+" se actualizo correctamente");
                    
        //     }
        //     else{
        //         saError(response.data.msg);
        //     }        
        
            
        // })
        // .catch(function (error) {
        //     console.error(error);
        // });
    }	
},

guardarMotivoRechazoCotizacion : function(){
    seguir = true;

  app.errMotivoRechazo = '';

    if (app.idMotivoSeleccionado == 0)
    {
        app.errMotivoRechazo = "Seleccione un motivo de rechazo."; 
        seguir = false;
    }	

    if(seguir == true){   
        $.ajax({				
            headers: getAxiosHeaders(),   
            url: URL_BASE + 'api/cotizacionrechazada.api.php?method=guardarMotivoRechazoCotizacion&idCotizacion=' + app.cotizacionSeleccionada+ '&fecha_rechazo='+'2022-11-08'+'&idMotivoRechazo='+ app.idMotivoSeleccionado,
                success:function(response){
                    if (!response.error){ 
                        $('#modalRechazoCotizacion').modal('hide'); 
                    //  console.log("se guardo correctamente motivo rechazo");     
                    }
                    else{
                        saError(response.msg);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) { 
                    console.log("error");
                }
            });

        // axios.get(URL_BASE + 'api/cotizacionrechazada.api.php?method=guardarMotivoRechazoCotizacion&idCotizacion=' + app.cotizacionSeleccionada+ '&fecha_rechazo='+'2022-11-08'+'&idMotivoRechazo='+ app.idMotivoSeleccionado, getAxiosHeaders())
        //     .then(function (response) {
                
        //         if (!response.data.error){ 
        //             $('#modalRechazoCotizacion').modal('hide'); 
        //         //  console.log("se guardo correctamente motivo rechazo");     
        //         }
        //         else{
        //             saError(response.data.msg);
        //         }        
            
                
        //     })
        //     .catch(function (error) {
        //         console.error(error);
        //     });

        if( app.idMotivoSeleccionado == 10){
        
            $.ajax({				
                headers: getAxiosHeaders(),   
                url: URL_BASE + 'api/otromotivodescripcion.api.php?method=guardarOtromotivoDescripcion&idCotizacion='+app.cotizacionSeleccionada+'&motivoRechazo='+app.motivoRechazoDescripcion,
                    success:function(response){
                        if (!response.error){ 
                            // console.log("se guardo correctamente otro motivo");   
                                
                        }
                        else{
                            saError(response.msg);
                        }  
                    },
                    error: function (jqXHR, textStatus, errorThrown) { 
                        console.log("error");
                    }
                });

            // axios.get(URL_BASE + 'api/otromotivodescripcion.api.php?method=guardarOtromotivoDescripcion&idCotizacion='+app.cotizacionSeleccionada+'&motivoRechazo='+app.motivoRechazoDescripcion , getAxiosHeaders())
            // .then(function (response) {
            //     console.log(response.data);
            //     if (!response.data.error){ 
            //         // console.log("se guardo correctamente otro motivo");   
                        
            //     }
            //     else{
            //         saError(response.data.msg);
            //     }        
            
                
            // })
            // .catch(function (error) {
            //     console.error(error);
            // });


        }

        
            $.ajax({				
                headers: getAxiosHeaders(),   
                url: URL_BASE + 'api/cotizacion.api.php?method=updateCotizacionEstado&idCotizacion='+app.cotizacionSeleccionada ,
                    success:function(response){
                        if (!response.error){                        
            
                            app.cargarLstCotizacion();
                        
                            saSuccess("El motivo de Rechazo de la cotizacion: "+ app.cotizacionSeleccionada+" se guardo correctamente");
                        
                                
                        }
                        else{
                            saError(response.msg);
                        }  
                    },
                    error: function (jqXHR, textStatus, errorThrown) { 
                        console.log("error");
                    }
                });
           
            // axios.get(URL_BASE + 'api/cotizacion.api.php?method=updateCotizacionEstado&idCotizacion='+app.cotizacionSeleccionada , getAxiosHeaders())
            // .then(function (response) {
            //     console.log(response.data);
            //     if (!response.data.error){ 
                  
    
            //        app.cargarLstCotizacion();
                  
            //        saSuccess("El motivo de Rechazo de la cotizacion: "+ app.cotizacionSeleccionada+" se guardo correctamente");
                  
                        
            //     }
            //     else{
            //         saError(response.data.msg);
            //     }        
            
                
            // })
            // .catch(function (error) {
            //     console.error(error);
            // });

        }
        
        
    	
},



fnRegresarAReportes: function(){
    window.location = URL_BASE + "rptmanager";
},
cargarVentasAnuales: function(){
    $('#modalWait').modal('show');
    xajax_cargarVentaAnual(this.year);
   
  
},
cargarVentasMes: function(mes){
    xajax_cargarVentaMensual(mes, 2018);
},

mostrarAnio: function(){
    this.showAnio = true;
}

}
});

Highcharts.chart('chartAnio', {
chart: {
type: 'column'
},
title: {
text: 'Ventas Galvamex 2018'
},
xAxis: {
categories: []
},
yAxis: {
min: 0,
title: {
    text: 'Total Ventas'
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


Highcharts.chart('grPedidosExplotadosPie', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'Tiempos de Entrega Año Actual'
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