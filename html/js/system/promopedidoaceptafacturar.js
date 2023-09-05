


var fnAutorizar=function(idPedido, observacion)
{	
	//alert("a autorizar: " + idPedido + '  ' + observacion);
	//return false;
	//xajax_autorizarPedido(idPedido);
	$('#modalIndicaMotivoAutorizacion').modal('hide');
	swal({
			title: "¿Seguro que deseas continuar?",
			text: "Se asignará la Factura al Pedido",
			type: "warning",
			showCancelButton: true,
			cancelButtonText: "NO",
			cancelButtonColor: "#ed5565",
			confirmButtonColor: "#1c84c6",
			confirmButtonText: "¡Adelante!",
			closeOnConfirm: false },

			function(){
			
				swal.close();
				//alert("a autorizar: " + idPedido + '  ' + observacion);
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


var mostrar=function(id)
{
	app.factura='';
	$("#pedidoAAutorizar").val(id);
	xajax_cargarPedido(id);
	app.pedidoAAutorizar=id;
 
}

$(document).ready(function(){	
	xajax_preparePage();
	$('#openmodal').modal('show');
	setTimeout(function() { xajax_llenarListado(); }, 200);
	
	   // $('#modalIndicaMotivoAutorizacion').on('show.bs.modal', function (evnt) {

	     //   var valueBottom = $(evnt.relatedTarget).val();
	      //  console.log(valueBottom);       
	      //  $(evnt.currentTarget).find('input[name="pedidoAAutorizar"]').val(valueBottom); 
	  //  }); 
	
	
});

var app = new Vue({
	el: '#app',
	data: {
		noPedido: '',
		estatus: '0',
		cliente: '',		
		pedidoAAutorizar: 0,
		factura: '',			
		pedidoACambiarAutorizacion: 0,
		facturaActualizar: '',
		count: 50,
		
		

		// PARA LA F A C T U R A 
			
		facRazonSocial: '',
		facDomicilio: '',
		facNumero: '',
		facCP: '',
		facColonia: '',
		facCiudad: '',
		facTelefono: '',
		facEmail: '',
		facRFC: '',
		facCFDI: 0,
		facRegimenFiscal: 1,
		
		facTotal: 0,
		
		errFacRazonSocial: '',
		errFacDomicilio: '',
		errFacNumero: '',
		errFacCP: '',
		errFacColonia: '',
		errFacCiudad: '',
		errFacTelefono: '',
		errFacEmail: '',
		errFacRFC: '',
		errFacCFDI: ''
	},
	watch:{
		factura :function(val)
		{
			this.factura = val.toUpperCase(); 
		}
	},
	methods:{
		filtrar: function(){
			xajax_llenarListado(this.noPedido, this.estatus, this.cliente);
		},
		autorizarPedido: function(){
			
			if (this.factura != "")
			{
				fnAutorizar(this.pedidoAAutorizar , this.factura);
			}
		},
		countdown: function() {
		      this.count = 50 - this.factura.length;
		    }
			} 
		
});