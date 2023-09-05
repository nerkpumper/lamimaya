
var app = new Vue({
	el: '#app',
	data: {
		idCliente: '',
		indexCliente: '',
		nombreCliente: '',
		empresaCliente: '',
		descuentoCliente: '',
		seleccionandoCliente: true,
		
		filtroDescuento: 'TODOS',
					    
		filtroNombreCliente: '',
		
		clientes: []		
	},
	mounted: function(){
//		this.cargarClientes();	
	},	
	watch: {
		filtroNombreCliente: function(val){
			this.filtroNombreCliente = val.toUpperCase();
		}
	},
	computed: {		
		clientesFiltradosPorNombre:function(){
	    	
	    	 var self=this;
	    	 return this.clientes.filter(function(cust){
	    		 	    		 
	    		 var str = cust.nombre;
	    		 var find = self.filtroNombreCliente;
   		 	    		 
	    		 return str.includes(find);
	    		 
	    	 });
	      
	    }
	},
	methods: {
		cargarClientes: function(){
			xajax_cargarClientes(this.filtroDescuento);
		},
		seleccionarCliente: function(index){
			
			
			this.idCliente = this.clientesFiltradosPorNombre[index].idCliente;
			this.indexCliente = index;
			this.nombreCliente = this.clientesFiltradosPorNombre[index].nombre;
			this.empresaCliente = this.clientesFiltradosPorNombre[index].empresa;
			this.descuentoCliente = this.clientesFiltradosPorNombre[index].porDescuento;
			
			$('#modalIndicaDescuento').modal('show');
			
//			this.seleccionandoCliente = false;
//			this.idCliente = idCliente;
//			
//			xajax_cargarCliente (this.idCliente);
		},
		asignarDescuento: function(){
			
			if (this.descuentoCliente <0 || this.descuentoCliente > 100)
			{
				saInfo("El Descuento debe un valor entre 0 y 100");
				return false;
			}
			
			$('#modalIndicaDescuento').modal('hide');
			swal({
				title: "¿Seguro que deseas continuar?",
				text: "Se le asignará al Cliente el Descuento indicado.",
				type: "warning",
				showCancelButton: true,
				cancelButtonText: "NO",
				cancelButtonColor: "#ed5565",
				confirmButtonColor: "#1c84c6",
				confirmButtonText: "¡Adelante!",
				closeOnConfirm: true },

				function(){					
//					swal.close();
					
					 
//					
//					idCliente: '',
//					indexCliente: '',
//					nombreCliente: '',
//					empresaCliente: '',
//					descuentoCliente: '',
//					$('#modalIndicaDescuento').modal('hide');
					
					
					xajax_asignarDescuento(app.idCliente, app.indexCliente, app.descuentoCliente);
				
			});
			
//			$('#modalIndicaDescuento').modal('hide');
//			xajax_asignarDescuento(app.idCliente, app.indexCliente, app.descuentoCliente);
		},
		sendToExcel: function(){
			
			sendToExcel("tablaToExcel", "Reporte Notas", "El titulillo", "El subtitulillo", 1);
			//alert("enviamos");
		}
		
		
	}
});