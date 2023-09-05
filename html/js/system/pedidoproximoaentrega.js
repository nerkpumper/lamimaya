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
    pedidosPorVencer:[],
    lstUsuario:[],
    idPromotorSeleccionado:0,
    fechaEntrega:'',
    errFechaEntrega:'',
    errMotivoRechazo:'',
    fechaCompromiso:'',
    fechaHoy:''

},
mounted: function() {

    this.cargarUsuario();
    },
methods: { 
    cargarPedidosFechaCompromisoPorVencer: function(){
        
        axios.get(URL_BASE + 'api/pedido.api.php?method=getFechaCompromisoPorVencer&idUsuarioCaptura='+app.idPromotorSeleccionado)
                .then(function (response) {          
                    app.pedidosPorVencer = response.data.lst;
                   
                })
                .catch(function (error) {
                    console.log(error);
                });  
    },
    cargarUsuario: function(){
        
        axios.get(URL_BASE + 'api/usuario.api.php?method=getUsuarioCapturaPedido')
                .then(function (response) {          
                    app.lstUsuario = response.data.lst;
                   
                })
                .catch(function (error) {
                    console.log(error);
                });  
    },

    modalUpdateFechaCompromiso: function(pedidoSeleccionado){
        app.pedidoSeleccionado = pedidoSeleccionado;
         $('#modalUpdateFechaCompromiso').modal('show');  
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
            axios.get(URL_BASE + 'api/pedido.api.php?method=updateFechaCompromiso&idPedido=' + app.pedidoSeleccionado+ '&fechaCompromiso='+app.fechaEntrega, getAxiosHeaders())
            .then(function (response) {
                console.log(response.data);
                if (!response.data.error){ 
                    $('#modalUpdateFechaCompromiso').modal('hide'); 
    
                    app.cargarPedidosFechaCompromisoPorVencer(); 
                    saSuccess("La fecha compromiso del pedido: "+ app.pedidoSeleccionado+" se actualizo correctamente");
                        
                }
                else{
                    saError(response.data.msg);
                }        
            
                
            })
            .catch(function (error) {
                console.error(error);
            });
        }	
    },  
}
});