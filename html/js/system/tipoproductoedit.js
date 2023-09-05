

var app = new Vue({
	el: '#app',
	data: {		
		idTipoProducto: 0,
		nombre: '',
		clave: '',
		              	
		errNombre: '',
		errClave: '',
		
		accionModulo: 'Nuevo'
	},
	mounted: function () {
		if (typeof param1 !== 'undefined') {
			this.idTipoProducto = param1;
			this.accionModulo = 'Actualizar';		  
			xajax_cargarTipoProducto(this.idTipoProducto);
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
		guardarTipoProducto: function(){
			var seguir = true;
		  
			this.limpiaErrores();
		  
			if (this.nombre.trim() == "")
			{
				this.errNombre = "Debe especificar un nombre de Tipo Producto.";
				seguir = false;
			}
		  						
			if (this.clave.trim() == "")
			{
				this.errClave = "Debe especificar una Clave.";
				seguir = false;
			}
									
			if (seguir)
			{				
				xajax_guardarTipoProducto(this.idTipoProducto, this.nombre, this.clave);
			}
			
			
		},
		limpiaDatos: function(){
			this.idTipoProducto = 0;
			this.nombre = '';
			this.clave = '';
			
		},
		limpiaErrores: function(){
			this.errNombre = '';
			this.errClave = '';
			
		},
		fnRegresarAListado: function(){
			window.location = URL_BASE + "tipoproducto";
		}
	}
  
});