
var app = new Vue({
	el: '#app',
	data: {		
		idProveedor: 0,
		nombre: '',
		clave: '',
	},
	created: function () {
		if (typeof param1 !== 'undefined') {
			this.idProveedor = param1;				  
			xajax_cargarProveedor(this.idProveedor);
		}
		else
		{
			window.location = URL_BASE + "proveedor";
		}
	},
	methods:{
		eliminarProveedor: function(){
					
			xajax_eliminarProveedor(this.idProveedor);
		},
		limpiaDatos: function(){
			this.idProveedor = 0;
			this.nombre = '';
			this.clave = '';
			
		},		
		fnRegresarAListado: function(){
			window.location = URL_BASE + "proveedor";
		}
	}
  
});