
var app = new Vue({
	el: '#app',
	data: {		
		idTipoMaterial: 0,
		nombre: '',
		clave: '',
	},
	created: function () {
		if (typeof param1 !== 'undefined') {
			this.idTipoMaterial = param1;				  
			xajax_cargarTipoProducto(this.idTipoMaterial);
		}
		else
		{
			window.location = URL_BASE + "tipoproducto";
		}
	},
	methods:{
		eliminarTipoProducto: function(){
					
			xajax_eliminarTipoProducto(this.idTipoMaterial);
		},
		limpiaDatos: function(){
			this.idTipoMaterial = 0;
			this.nombre = '';
			this.clave = '';
			
		},		
		fnRegresarAListado: function(){
			window.location = URL_BASE + "tipoproducto";
		}
	}
  
});