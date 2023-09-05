
var app = new Vue({
	el: '#app',
	data: {
		
		filtro: {
			idCliente: '0',
			nombrePromotor: '',
			fechaInicio: '',
			fechaFin: '',
		}		,

		
		//para la busqueda de clientes
		idClienteSeleccionado: 0,
		idUsuarioPromotor: 0,
		clienteSeleccionado: '-- Seleccione --',
		promotorClienteSeleccionado: '',
		cteSelDomicilio1: '',
		cteSelDomicilio2: '',
		cteSelNumero: '',
		cteSelColonia: '',
		cteSelCiudad: '',
		cteSelTelefonos: '',



		seleccionandoCliente: false,
		clientes: [],
		filtroNombreCliente: '',
		
		
		
		
		errFechaInicio: '',
		errFechaFin: ''
	},	
	computed:{
		clientesFiltradosPorNombre:function(){

	    	 var self=this;
	    	 return this.clientes.filter(function(cust){

	    		 //return cust.nombre == self.filtroNombreCliente;
	    		 var str = cust.nombre;
	    		 var find = self.filtroNombreCliente;

//	    		 if (find.trim() == "")
//	    		 {
//	    			 find = "sdjfklsdjfaj";
//	    		 }

	    		 return str.includes(find);

	    	 });
	       //return this.customers;
	    },
	},
	watch: {
		filtroNombreCliente: function(val){
			this.filtroNombreCliente = val.toUpperCase();
		},
	},
	methods: {
		fnRegresarAReportes: function(){
			window.location = URL_BASE + "rptmanager";
		},
		setClienteSelected: function(idCliente){
			var i;

			this.idClienteSeleccionado = 0;
			this.clienteSeleccionado = '-- SIN CLIENTE --';
			this.promotorClienteSeleccionado = '';

			for (i = 0 ; i < this.clientes.length ; i++)
			{
				if (this.clientes[i].id == idCliente)
				{
					this.idClienteSeleccionado = this.clientes[i].id;
					this.idUsuarioPromotor = this.clientes[i].idUsuarioPromotor;
					this.clienteSeleccionado = this.clientes[i].nombre;
					this.promotorClienteSeleccionado = this.clientes[i].promotor;
					
					this.filtro.idCliente = this.idClienteSeleccionado;
					
					$("#modalSelCliente").modal('toggle');
					break;
				}
			}
		},
		seleccionarCliente: function(){
			xajax_cargarClientes();
			$("#modalSelCliente").modal();
		},
		obtenerReporte: function(){
			
			var desde = $("#dtFechaInicio").val();
			var hasta = $("#dtFechaFin").val();
			var seguir = true;
			
			this.errFechaInicio = '';
			this.errFechaFin = '';
			
			var strFechaInicial = desde.substring(6, 10) + '' + desde.substring(3, 5) + '' + desde.substring(0, 2);
			var strFechaFinal = hasta.substring(6, 10) + '' + hasta.substring(3, 5) + '' + hasta.substring(0, 2);
				
			if (this.filtro.idCliente == 0)
			{
				saInfo("Debe seleccionar un Cliente"); 
				seguir = false;
			}
			
			
//			alert(  strFechaInicial + ' ' + strFechaFinal);
						
//			if (hasta < desde)
			if (parseInt(strFechaFinal) < parseInt(strFechaInicial))
			{
				this.errFechaFin = "Fecha Final debe ser mayor a Inicial"; 
				seguir = false;
			}
			
			if (seguir)
			{
				
				this.filtro.fechaInicio = desde;
				this.filtro.fechaFin = hasta;
				
				xajax_obtenerReporte(this.filtro);	
			}
			
		},
		obtenerReportePendientesSaldar: function(){
			xajax_obtenerReportePendientesSaldar(this.filtro);
		},
		sendToExcel: function(){
			sendToExcel("tblReporte", "Listado de Pedidos X Cliente Galvamex", "Listado de Pedidos X Cliente Galvamex", "Cliente: " + this.clienteSeleccionado + " de: " + this.filtro.fechaInicio + " a: " + this.filtro.fechaFin, 0, "");
			
		}
	}
});


$(document).ready(function(){
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
});

