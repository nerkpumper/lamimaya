var app = new Vue({
	el: '#app',
	data: {
		idCliente: 0,
		nombre: '',
		apellidos: '',
		empresa: '',
		domicilio1: '',
		domicilio2: '',
		telefonos: '',
		email: '',
		rfc: '',
		estado: '',
	},
	created: function () {
		if (typeof param1 !== 'undefined') {
			this.idCliente = param1;				  
			xajax_cargarCliente(this.idCliente);
		}
		else
		{
			window.location = URL_BASE + "cliente";
		}
	},
	methods:{
		eliminarCliente: function(){
					
			xajax_eliminarCliente(this.idCliente);
		},
		limpiaDatos: function(){
			this.idCliente = 0;
			this.nombre = '';
			this.apellidos = '';
			this.empresa = '';
			this.domicilio1 = '';
			this.domicilio2 = '';
			this.telefonos = '';
			this.email = '';
			this.rfc = '';
			this.estado = '';			
		},		
		fnRegresarAListado: function(){
			window.location = URL_BASE + "cliente";
		}
	}
  
});