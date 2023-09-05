


var sendPedidoACliente=function(idPedido)
{
	var form_data = new FormData();
    form_data.append('idPedido', idPedido);
	
    
        
	//axios.get('http://ron-swanson-quotes.herokuapp.com/v2/quotes')
	$.ajax({
        url: 'views/pedidosend.view.php', // point to server-side PHP script 
        dataType: 'json',  // what to expect back from the PHP script, if anything
//        cache: false,
        contentType: false,
        processData: false,
        data: form_data,                         
        type: 'post',
        success: function(resp){
        	
        	console.dir(resp);
        	if (!resp.error) {		   
        		saTextoAndTitle("Pedido Enviado","Se ha enviado Pedido a Cliente via EMail");
//            	mostrarAviso("Se ha cambiado la foto de perfil.");
//            	window.setTimeout(function () { window.location = URL_BASE + "miperfil";}, 1500);
            } else {
            	//vm.status = resp.msg;
            	mostrarAviso(resp.msg);
            }
        }
    });	
}


var fnAutorizar=function(idPedido, observacion)
{	
//	alert("a autorizar: " + idPedido + '  ' + observacion);
//	return false;
	//xajax_autorizarPedido(idPedido);
	$('#modalIndicaMotivoAutorizacion').modal('hide');
	swal({
			title: "¿Seguro que deseas continuar?",
			text: "El Pedido se AUTORIZARÁ para Producirse.",
			type: "warning",
			showCancelButton: true,
			cancelButtonText: "NO",
			cancelButtonColor: "#ed5565",
			confirmButtonColor: "#1c84c6",
			confirmButtonText: "¡Adelante!",
			closeOnConfirm: false },

			function(){
//				swal("¡Hecho!",
//						"Acabas de vender tu alma al diablo.",
//						"success");
				
				swal.close();
//				alert("a autorizar: " + idPedido + '  ' + observacion);
				xajax_autorizarPedido(idPedido, observacion);
			
		});
};

var fnDesbloquear=function(idPedido)
{	
//	alert("a autorizar: " + idPedido + '  ' + observacion);
//	return false;
	//xajax_autorizarPedido(idPedido);
	
	swal({
			title: "¿Seguro que deseas continuar?",
			text: "El Pedido será DESBLOQUEADO, no será necesario Actualizar precios.",
			type: "warning",
			showCancelButton: true,
			cancelButtonText: "NO",
			cancelButtonColor: "#ed5565",
			confirmButtonColor: "#1c84c6",
			confirmButtonText: "¡Adelante!",
			closeOnConfirm: true },

			function(){
//				swal("¡Hecho!",
//						"Acabas de vender tu alma al diablo.",
//						"success");
				
				// swal.close();
//				alert("a autorizar: " + idPedido + '  ' + observacion);
				xajax_desbloquearPedido(idPedido);
			
		});
};

var fnProducir=function(idPedido)
{	
	
	swal({
			title: "¿Seguro que deseas continuar?",
			text: "El Pedido entrará en estado de PRODUCCIÓN.",
			type: "warning",
			showCancelButton: true,
			cancelButtonText: "NO",
			cancelButtonColor: "#ed5565",
			confirmButtonColor: "#1c84c6",
			confirmButtonText: "¡Adelante!",
			closeOnConfirm: false },

			function(){
				
				swal.close();
				xajax_producirPedido(idPedido);
			
		});
};

var fnTerminar=function(idPedido)
{	
	
	swal({
			title: "¿Seguro que deseas continuar?",
			text: "El Pedido entrará en estado de TERMINADO.",
			type: "warning",
			showCancelButton: true,
			cancelButtonText: "NO",
			cancelButtonColor: "#ed5565",
			confirmButtonColor: "#1c84c6",
			confirmButtonText: "¡Adelante!",
			closeOnConfirm: false },

			function(){
				
				swal.close();
				xajax_terminarPedido(idPedido);
			
		});
};

var fnEntregar=function(idPedido)
{	
	
	swal({
			title: "¿Seguro que deseas continuar?",
			text: "El Pedido entrará en estado de ENTREGADO.",
			type: "warning",
			showCancelButton: true,
			cancelButtonText: "NO",
			cancelButtonColor: "#ed5565",
			confirmButtonColor: "#1c84c6",
			confirmButtonText: "¡Adelante!",
			closeOnConfirm: false },

			function(){
				
				swal.close();
				xajax_entregarPedido(idPedido);
			
		});
};

var fnTerminarYEntregar=function(idPedido)
{	
	
	swal({
			title: "¿Seguro que deseas continuar?",
			text: "El Pedido se marcará como TERMINADO y ENTREGADO.",
			type: "warning",
			showCancelButton: true,
			cancelButtonText: "NO",
			cancelButtonColor: "#ed5565",
			confirmButtonColor: "#1c84c6",
			confirmButtonText: "¡Adelante!",
			closeOnConfirm: false },

			function(){
				
				swal.close();
				xajax_terminarYEntregarPedido(idPedido);
			
		});
};

var fnPreSolicitarObservacionAutorizacion=function(idPedido)
{
	alert("pre autorizar");
};

var fnSolicitarObservacionAutorizacion=function(idPedido)
{
	app.pedidoAAutorizar = idPedido;
	app.observacionAutorizar = "";
	app.pedidoSaldoTotalMas30Dias = 0;
	app.pedidoSubtotal = 0;
	app.pedidoOtrosCargos = 0;
	app.pedidoTotal = 0;
	app.pedidoSaldo = 0;
	app.pedidoSaldoTotal = 0;
	app.pedidoCliente = '';
	app.promoNombre = '';
	app.vendeNombre = '';
	app.cteCredito = 0;
	app.cteCapacidadPago = 0;
	app.pedidoSurtiraCompleto = false;
	app.cargarTotalesPedido();
	
	$('#modalIndicaMotivoAutorizacion').modal('show');
};

var fnSolicitarCambioObservacionAutorizacion=function(idPedido)
{
	app.pedidoACambiarAutorizacion = idPedido;
	app.observacionAutorizarActualizar = $("#obsAutoriza" + idPedido).html();			
	
	$('#modalActualizaMotivoAutorizacion').modal('show');
};

var fnActualizarObservacionAutorizacion=function(idPedido, observacion)
{	
	$('#modalActualizaMotivoAutorizacion').modal('hide');
	swal({
			title: "¿Deseas continuar?",
			text: "Se actualizará la Observación de Autorización del Pedido.",
			type: "warning",
			showCancelButton: true,
			cancelButtonText: "NO",
			cancelButtonColor: "#ed5565",
			confirmButtonColor: "#1c84c6",
			confirmButtonText: "¡Adelante!",
			closeOnConfirm: false },

			function(){
				
				swal.close();
				xajax_actualizarAutorizacionPedido(idPedido, observacion);
//				xajax_autorizarPedido(idPedido, observacion);
			
		});
};

var fnImprimir=function(idPedido)
{
	app.noPedidoImprimir = idPedido;
	xajax_getImprimir(idPedido);
		
	$('#modalImprimir').modal('show');
};

var fnMostrarTracking = function(idPedido){
	$('#modalTracking').modal('show');
	app.mostrarTracking(idPedido);
};


$(document).ready(function(){	
	xajax_preparePage();
	setTimeout(function() { xajax_llenarListado(); }, 200);
	
});


var app = new Vue({
	el: '#app',
	data: {
		noPedido: '',
		estatus: '0',
		cliente: '',
		noPedidoImprimir: 0,

		pedidoSaldoTotalMas30Dias: 0,
		pedidoSubtotal: 0,
		pedidoOtrosCargos: 0,
		pedidoTotal: 0,
		pedidoSaldo: 0,
		pedidoSaldoTotal: 0,
		pedidoCliente: '',
		promoNombre: '',
		vendeNombre: '',
		cteCredito: 0,
		cteCapacidadPago: 0,
		pedidoSurtiraCompleto: false,
		
		
		pedidoAAutorizar: 0,
		observacionAutorizar: '',
			
		pedidoACambiarAutorizacion: 0,
		observacionAutorizarActualizar: ''
	},
	computed: {
		saldoCredito: function(){
			return (this.cteCredito - this.pedidoSaldoTotal) ;
		},
		saldoCapacidadPago: function(){
			return (this.cteCapacidadPago - this.pedidoSaldoTotal) ;
		}
	},
	watch: {
		cliente: function(val){
			this.cliente = val.toUpperCase();
		},
		observacionAutorizar: function(val){
			this.observacionAutorizar = val.toUpperCase();
		},
		observacionAutorizarActualizar: function(val){
			this.observacionAutorizarActualizar = val.toUpperCase();
		}
	},
	methods:{
		mostrarTracking: function(idPedido){
			
			this.$refs.trackingPedido.show(idPedido);
		},
		cargarTotalesPedido: function(){
			xajax_cargarPedido(this.pedidoAAutorizar);
		},
		filtrar: function(){
			xajax_llenarListado(this.noPedido, this.estatus, this.cliente);
		},
		autorizarPedido: function(){
			
			if (this.observacionAutorizar != "")
			{
				fnAutorizar(this.pedidoAAutorizar, this.observacionAutorizar);
			}
		},
		actualizarAutorizacionPedido: function(){
			
			if (this.observacionAutorizarActualizar != "")
			{				
				fnActualizarObservacionAutorizacion(this.pedidoACambiarAutorizacion, this.observacionAutorizarActualizar);
			}
			
//			$("#obsAutoriza" + idPedido).html("texto cambiado");
		}
		
	} 
		
});