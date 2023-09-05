

var app = new Vue({
	el: '#app',
	data: {		
		idProveedor: 0,
		nombre: '',
		clave: '',
		              	
		errNombre: '',
		errClave: '',
		
		accionModulo: 'Nuevo'
	},
	mounted: function () {
		if (typeof param1 !== 'undefined') {
			this.idProveedor = param1;
			this.accionModulo = 'Actualizar';		  
			xajax_cargarProveedor(this.idProveedor);
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
		guardarProveedor: function(){
			var seguir = true;
		  
			this.limpiaErrores();
		  
			if (this.nombre.trim() == "")
			{
				this.errNombre = "Debe especificar un nombre de Proveedor.";
				seguir = false;
			}
		  						
			if (this.clave.trim() == "")
			{
				this.errClave = "Debe especificar una Clave.";
				seguir = false;
			}
						
			if (seguir)
			{				
				xajax_guardarProveedor(this.idProveedor, this.nombre, this.clave);
			}
			
			
		},
		limpiaDatos: function(){
			this.idProveedor = 0;
			this.nombre = '';
			this.clave = '';
			
		},
		limpiaErrores: function(){
			this.errNombre = '';
			this.errClave = '';
			
		},
		fnRegresarAListado: function(){
			window.location = URL_BASE + "proveedor";
		}
	}
  
});