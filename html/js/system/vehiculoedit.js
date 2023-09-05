

var app = new Vue({
	el: '#app',
	data: {		
		idVehiculo: 0,
		placa: '',
		descripcion: '',
		              	
		errPlaca: '',
		errDescripcion: '',
		
		accionModulo: 'Nuevo'
	},
	mounted: function () {
		// console.log("mounted")
        if (typeof param1 !== 'undefined') {
            // console.log("el param: " + param1)
			this.idVehiculo = param1;
			this.accionModulo = 'Actualizar';		  
			xajax_cargarVehiculo(this.idVehiculo);
		}	
		
		this.$refs.placa.focus();
	},	
	watch: {
		descripcion: function(val){
			this.descripcion = val.toUpperCase();
		},
		placa: function(val){
			this.placa = val.toUpperCase();
		}
	},
	methods:{
		guardarVehiculo: function(){
			var seguir = true;
		  
			this.limpiaErrores();
		  
			if (this.placa.trim() == "")
			{
				this.errplaca = "Debe especificar una placa de Vehiculo.";
				seguir = false;
			}
		  						
			if (this.descripcion.trim() == "")
			{
				this.errdescripcion = "Debe especificar una descripcion.";
				seguir = false;
			}
									
			if (seguir)
			{				
				xajax_guardarVehiculo(this.idVehiculo, this.placa, this.descripcion);
			}
			
			
		},
		limpiaDatos: function(){
			this.idVehiculo = 0;
			this.placa = '';
			this.descripcion = '';
			
		},
		limpiaErrores: function(){
			this.errplaca = '';
			this.errdescripcion = '';
			
		},
		fnRegresarAListado: function(){
			window.location = URL_BASE + "vehiculo";
		}
	}
  
});