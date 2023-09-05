
var app = new Vue({
	el: '#app',
	data: {		
		idAplicacion: 0,
		nombreAplicacion: ''		
	},
	created: function () {
		if (typeof param1 !== 'undefined') {
			this.idAplicacion = param1;				 
			
			if (this.idAplicacion == 1)
			{
				window.location = URL_BASE + "aplicacion";
			}
			
			xajax_cargarAplicacion(this.idAplicacion);
		}
		else
		{
			window.location = URL_BASE + "aplicacion";
		}
	},
	methods:{
		eliminarAplicacion: function(){
					
			xajax_eliminarAplicacion(this.idAplicacion);
		},
		limpiaDatos: function(){
			this.idAplicacion = 0;
			this.nombreAplicacion = '';			
			
		},		
		fnRegresarAListado: function(){
			window.location = URL_BASE + "aplicacion";
		}
	}
  
});