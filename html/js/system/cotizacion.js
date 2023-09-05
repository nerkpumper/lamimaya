
var fnEditRangoCliente=function(idCotizacion, rangoCliente)
{
	var rc  = $("#rc"+idCotizacion).html();
	app.idCotizacionRangoClienteEdit = idCotizacion ;
	app.rangoClienteEdit = rc;
	app.rangoClienteEditAux = rc;
	$('#modalCambiarRangoCliente').modal('show');
}


var fnAutorizar=function(idCotizacion, observacion = "")
{		
	swal({
			title: "¿Seguro que deseas continuar?",
			text: "La Cotización se AUTORIZARÁ para convertirse a Pedido. No se considerarán algunas validaciones para ello.",
			type: "warning",
			showCancelButton: true,
			cancelButtonText: "NO",
			cancelButtonColor: "#ed5565",
			confirmButtonColor: "#1c84c6",
			confirmButtonText: "¡Adelante!",
			closeOnConfirm: true },

			function(){
				// alert("OK");
				xajax_autorizarConvertirAPedido(idCotizacion, observacion);
			
		});
};


var fnSolicitarObservacionAutorizacion=function(idPedido)
{
	app.pedidoAAutorizar = idPedido;
	app.observacionAutorizar = "";
	
	$('#modalCambiarRangoCliente').modal('show');
};


$(document).ready(function(){	
	// alert("vamos a preparar la pagina");
	xajax_preparePage();
	setTimeout(function() { app.filtrar(); }, 200);
	
});


var app = new Vue({
	el: '#app',
	data: {
		noPedido: '',
		estatus: '0',
		cliente: '',
		noPedidoImprimir: 0,

		//paginacion
		page: 0,
		pageSize: 10,
		pageTotalRegs: 0,

		idCotizacionRangoClienteEdit: 0,
		rangoClienteEdit: '',
		rangoClienteEditAux: '',
		
		
		pedidoAAutorizar: 0,
		observacionAutorizar: '',
			
		pedidoACambiarAutorizacion: 0,
		observacionAutorizarActualizar: ''
	},
	computed: {
		pages: function(){
			var noPages = parseInt(this.pageTotalRegs / this.pageSize);

			if (this.pageTotalRegs % this.pageSize > 0)
				noPages++;

			return noPages;
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
		editarCotizacionRangoCliente: function(idCotizacion){
			this.idCotizacionRangoClienteEdit = idCotizacion;
		},
		filtrar: function(){
			this.page = 0;
			this.loadPage();
		},
		loadPage: function(){
			xajax_llenarListado(this.page, this.pageSize, this.noPedido, this.estatus, this.cliente);
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
		},
		editarRangoCliente: function(){
			$('#modalCambiarRangoCliente').modal('hide');
			if (this.rangoClienteEdit != this.rangoClienteEditAux)
			{
				xajax_actualizarRangoCliente(this.idCotizacionRangoClienteEdit, this.rangoClienteEdit);
			}
		},
		previousPage: function(){
			this.page--;
			this.loadPage();
		},
		nextPage: function(){
			this.page++;
			this.loadPage();
		}
		
	} 
		
});