
var app = new Vue({
	el: '#app',
	data: {		
		idUsuario: 0,
		username: '',
		email: '',
		nombre: '',       
		apellidoPaterno: '',
		apellidoMaterno: ''
	},
	mounted: function () {
		if (typeof param1 !== 'undefined') {
			this.idUsuario = param1;		
			console.log("Vamos a cargar usuario ", this.idUsuario);		  
			xajax_cargarUsuario(this.idUsuario);
		}
		else
		{
			window.location = URL_BASE + "usuario";
		}
	},
	methods:{
		eliminarUsuario: function(){
					
			xajax_eliminarUsuario(this.idUsuario);
		},
		limpiaDatos: function(){
			this.idUsuario = 0;
			this.username = '';
			this.nombre = '';
			this.apellidoPaterno = ''; 
			this.apellidoMaterno = '';
			this.email = '';
			
		},		
		fnRegresarAListado: function(){
			window.location = URL_BASE + "usuario";
		}
	}
  
});