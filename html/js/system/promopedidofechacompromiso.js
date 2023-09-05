


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
			text: "Se asignará la Fecha de Entrega al Pedido",
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





var app = new Vue({
	el: '#app',
	data: {
		noPedido: '',
		estatus: '0',
		cliente: '',
		
		pedidoAAutorizar: 0,
		observacionAutorizar: '',
			
		pedidoACambiarAutorizacion: 0,
		observacionAutorizarActualizar: '',
		
		
		fechaEntrega: '',
		errFechaEntrega: ''
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
			
			this.errFechaEntrega = "";
			
			
			var seguir = true;
			var fechaEngrega = $("#dtFechaEntrega").val();
//			var strHoraEntrega = "";
			var today = new Date();
			var dd = today.getDate();
			var mm = today.getMonth()+1; //January is 0!
			var yyyy = today.getFullYear();
			var horaactual = today.getHours();
			horaactual = 12

			if(dd<10) {
			    dd = '0'+dd
			}

			if(mm<10) {
			    mm = '0'+mm
			}

			var strFESave = "";
			var strFechaEntrega = fechaEngrega.substring(6, 10) + '-' + fechaEngrega.substring(3, 5) + '-' + fechaEngrega.substring(0, 2);
			var strFE = fechaEngrega.substring(6, 10) + '' + fechaEngrega.substring(3, 5) + '' + fechaEngrega.substring(0, 2);
			var strToday = yyyy + '' + mm + '' + dd;
			strFESave = strFechaEntrega;
			
			if (parseInt(strToday) > parseInt(strFE))
			{
				this.errFechaEntrega = "La Fecha de Entrega debe ser posterior o igual al día de hoy.";

//				saInfo("La Fecha de Entrega debe ser posterior al día de hoy.");
				seguir = false;
			}	
			
			if (seguir)
			{
				fnAutorizar(this.pedidoAAutorizar, strFESave);
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