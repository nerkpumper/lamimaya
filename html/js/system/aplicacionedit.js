

var app = new Vue({
	el: '#app',
	data: {		
		idAplicacion: 0,
		nombreAplicacion: '',		
		              	
		errNombreAplicacion: '',		
		
		accionModulo: 'Nuevo'
	},
	mounted: function () {
		if (typeof param1 !== 'undefined') {
			this.idAplicacion = param1;
			
			if (this.idAplicacion == 1)
			{
				window.location = URL_BASE + "aplicacion";
			}
			
			this.accionModulo = 'Actualizar';		  
			xajax_cargarAplicacion(this.idAplicacion);
		}
		
		this.$refs.nombreAplicacion.focus();
	},
	watch: {
		nombreAplicacion: function(val){
			this.nombreAplicacion = val.toUpperCase();
		}
	},
	methods:{
		guardarAplicacion: function(){
			var seguir = true;		  
			this.limpiaErrores();
		  
			if (this.nombreAplicacion.trim() == "")
			{
				this.errNombreAplicacion = "Debe especificar un nombre de Aplicación.";
				seguir = false;
			}
		  										
			if (seguir)
			{				
				xajax_guardarAplicacion(this.idAplicacion, this.nombreAplicacion);
			}
			
			
		},
		limpiaDatos: function(){
			this.idAplicacion = 0;
			this.nombreAplicacion = '';			
			
		},
		limpiaErrores: function(){
			this.errNombreAplicacion = '';			
			
		},
		fnRegresarAListado: function(){
			window.location = URL_BASE + "aplicacion";
		}
	}
  
});