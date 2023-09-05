

var app = new Vue({
	el: '#app',
	data: {		
		idRollo: 0,
		codigo: 'codigo',
		descripcion: 'desc',
		proveedor: 'prove',
		remision: '',
		noRollo: '',
		kilos: '',
		
		errRemision: '',
		errNoRollo: '',
		errKilos: '',
		
		ingresos: [],
		
		blnNoRegistrados: false,
		blnProcesado: false
		
	},
	mounted: function () {
		if (typeof param1 !== 'undefined') {
			this.idRollo = param1;					  
			
			xajax_cargarRollo(this.idRollo);					
		}
		
		this.$refs.remision.focus();
	},	
	watch: {
		noRollo: function(val){
			this.noRollo = val.toUpperCase();
		},
		remision: function(val){
			this.remision = val.toUpperCase();
		},
		ingresos: function(){
			this.blnNoRegistrados = false;
		}
	},
	methods:{			
		getEstatusLabel: function(index){
			return this.ingresos[index].estatusLabel;
		},
		getIconProceso: function(index){
			return "<i class='fa fa-check text-success'></i>";
			//return "<i class='fa fa-times text-danger'></i>";
		},
		nuevaRecepcion: function(){
			this.blnProcesado = false;
			this.ingresos.splice(0, this.ingresos.length);
			this.limpiaDatos();
			this.$refs.remision.focus();	
		},
		listarIngreso: function(){
			var seguir = true;
		  
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
			}
			
			
			
		},
		registrarIngreso: function(){
			this.blnNoRegistrados = false;
			xajax_registrarIngresos(this.idRollo, this.ingresos);
		},
		probarIndex: function(){
			this.blnNoRegistrados = true;
			this.ingresos[2].estatusLabel = "<span class='label label-danger'>El N&uacute;mero de Rollo ya se encuentra registrado.</span>";
			this.blnProcesado = true;
		},
		quitarIngreso: function(index){
			this.ingresos.splice(index, 1);
		},
		limpiaDatos: function(){
			this.remision = '';
			this.noRollo = '';
			this.kilos = '';
		},
		limpiaErrores: function(){
			this.errRemision = '';
			this.errNoRollo = '';
			this.errKilos = '';
		},
		fnRegresarAListado: function(){
						
			window.location = URL_BASE + "rollo";
		}
	}
  
});