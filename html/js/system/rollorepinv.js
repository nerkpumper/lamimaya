

var app = new Vue({
	el: '#app',
	data: {		
		idRollo: 0,
		codigo: 'codigo',
		descripcion: 'desc',
		proveedor: '',
		
		blnNoRegistrados: false,
		blnProcesado: false
		
	},
	mounted: function () {
		if (typeof param1 !== 'undefined') {
			this.idRollo = param1;					  
			
			xajax_cargarRollo(this.idRollo);					
		}
		
		//this.$refs.remision.focus();
	},	
	methods:{		
		listarIngreso: function(){
			/*var seguir = true;
		  
			this.limpiaErrores();
			
			if (this.remision == "")
			{
				this.errRemision = "Debe ingresar la remisión";
				seguir = false;
			}
			
			if (this.noRollo == "")
			{
				this.errNoRollo = "Debe ingresar la número de rollo";
				seguir = false;
			}
			
			if (this.kilos == "")
			{				
				this.errKilos = "Debe ingresar los kilos";
				seguir = false;
			}
			else 
			{
				if (Number(this.kilos) <= 0 || isNaN(this.kilos))
				{				
					this.errKilos = "Los kilos deben ser mayores a 0";
					seguir = false;
				}				
			}
			
			if (seguir)
			{
				this.ingresos.push({ remision: this.remision, noRollo: this.noRollo, kilos: this.kilos, estatus: "listado" , estatusLabel: "<span class='label label-info'>Enlistado</span>"});
				
				this.noRollo = '';
				this.kilos = '';
				this.$refs.noRollo.focus();	
			}*/
			
			
			
		},
		limpiaDatos: function(){
			/*this.remision = '';
			this.noRollo = '';
			this.kilos = '';*/
		},
		limpiaErrores: function(){
			/*this.errRemision = '';
			this.errNoRollo = '';
			this.errKilos = '';*/
		},
		fnRegresarAListado: function(){						
			window.location = URL_BASE + "rollo";
		}
	}
  
});