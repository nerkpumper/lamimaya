


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

var fnSolicitarObservacionAutorizacion=function(idPedido)
{
	app.pedidoAAutorizar = idPedido;
	app.observacionAutorizar = "";
	
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


$(document).ready(function(){	
	
	mdlShowWait();
	xajax_preparePage();
//	$('#openmodal').modal('show');
	setTimeout(function() { xajax_llenarListado(); }, 200);
//	setTimeout(function(){$('#openmodal').modal('hide');},10000);
	//$('#openmodal').modal('hide');
});


var app = new Vue({
	el: '#app',
	data: {
		noPedido: '',
		estatus: '0',
		cliente: '',
		
		pedidoAAutorizar: 0,
		observacionAutorizar: '',
			
		pedidoACambiarAutorizacion: 0,
		observacionAutorizarActualizar: ''
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