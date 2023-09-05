

var app = new Vue({
	el: '#app',
	data: {		
		idMaterial: 0,
		nombre: '',
		clave: '',
		              	
		errNombre: '',
		errClave: '',
		
		accionModulo: 'Nuevo'
	},
	mounted: function () {
		if (typeof param1 !== 'undefined') {
			this.idMaterial = param1;
			this.accionModulo = 'Actualizar';		  
			xajax_cargarMaterial(this.idMaterial);
		}	
		
		this.$refs.nombre.focus();
	},	
	watch: {
		clave: function(val){
			this.clave = val.toUpperCase();
		},
		nombre: function(val){
			this.nombre = val.toUpperCase();
		}
	},
	methods:{
		guardarMaterial: function(){
			var seguir = true;
		  
			this.limpiaErrores();
		  
			if (this.nombre.trim() == "")
			{
				this.errNombre = "Debe especificar un nombre de Material.";
				seguir = false;
			}
		  						
			if (this.clave.trim() == "")
			{
				this.errClave = "Debe especificar una Clave.";
				seguir = false;
			}
									
			if (seguir)
			{				
				xajax_guardarMaterial(this.idMaterial, this.nombre, this.clave);
			}
			
			
		},
		limpiaDatos: function(){
			this.idMaterial = 0;
			this.nombre = '';
			this.clave = '';
			
		},
		limpiaErrores: function(){
			this.errNombre = '';
			this.errClave = '';
			
		},
		fnRegresarAListado: function(){
			window.location = URL_BASE + "material";
		}
	}
  
});