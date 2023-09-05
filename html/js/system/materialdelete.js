
var app = new Vue({
	el: '#app',
	data: {		
		idMaterial: 0,
		nombre: '',
		clave: '',
	},
	created: function () {
		if (typeof param1 !== 'undefined') {
			this.idMaterial = param1;				  
			xajax_cargarMaterial(this.idMaterial);
			
		}
		else
		{
			window.location = URL_BASE + "material";
		}
	},
	methods:{
		eliminarMaterial: function(){
					
			xajax_eliminarMaterial(this.idMaterial);
		},
		limpiaDatos: function(){
			this.idMaterial = 0;
			this.nombre = '';
			this.clave = '';
			
		},		
		fnRegresarAListado: function(){
			window.location = URL_BASE + "material";
		}
	}
  
});