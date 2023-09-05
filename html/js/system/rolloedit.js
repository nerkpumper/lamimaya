

var app = new Vue({
	el: '#app',
	data: {		
		idRollo: 0,
		codigo: '',
		material: '0=>',
		idMaterial: 0,
		claveMaterial: '0',	
		calibre: '0',
		pies: '0',
		proveedor: '0=>',
		idProveedor: 0,
		claveProveedor: '0',
		descripcion: '',		
		observaciones: '',
       
		errCodigo: '',		
		sucCodigo: '',
		errMaterial: '',
		errCalibre: '',
		errPies: '',
		errProveedor: '',
		errDescripcion: '',
		errObservaciones: '',
		
       
		accionModulo: 'Nuevo'
	},
	mounted: function () {
		if (typeof param1 !== 'undefined') {
			this.idRollo = param1;
			this.accionModulo = 'Actualizar';		  
			
			xajax_cargarRollo(this.idRollo);		
		}
		
		this.$refs.material.focus();
	},
	watch: {
		material: function(val){
			xajax_obtenerClaveMaterial(val);
			//this.generarCodigo();
		},		
		proveedor: function(val){
			xajax_obtenerClaveProveedor(val);
			//this.generarCodigo();
		}
	},
	computed: {
		codigoGenerado: function(){
			if (this.idRollo == 0){				
				this.codigo = "R" + this.claveMaterial + "C" + this.calibre + this.pies + this.claveProveedor;
				
				this.errCodigo = '';
				this.sucCodigo = '';
				
				if (this.idMaterial == 0 || this.calibre == "0" || this.pies == "0" || this.idProveedor == 0)
				{
					this.errCodigo = "El Código no está completo, es necesario seleccionar valores de las listas inferiores.";
				}
				else
				{
					this.sucCodigo = "El Código está completo.";
				}
				
				return this.codigo;
			}
			else
			{
				this.errCodigo = '';
				this.sucCodigo = '';
			}
		},
		showSave: function(){
			if (this.idMaterial == 0 || this.calibre == "0" || this.pies == "0" || this.idProveedor == 0 || this.descripcion == "")
			{
				return false;
			}
			else
			{
				return true;
			}
		}
	},
	methods:{		
		saluda: function(saludo){
			console.log(saludo);
		},		
		guardarRollo: function(){
			var seguir = true;
		  
			this.limpiaErrores();
			
			if (this.idMaterial == 0)
			{
				seguir = false;	
				this.errMaterial = "Debe seleccionar un Material";
			}
			
			if (this.calibre == "0")
			{
				seguir = false;				
				this.errCalibre = "Debe seleccionar un Calibre";
			}
			
			if (this.pies == "0")
			{
				seguir = false;
				this.errPies = "Debe seleccionar Pies";
			}
			
			if (this.idProveedor == 0)
			{
				seguir = false;				
				this.errProveedor = "Debe seleccionar un Proveedorl";
			}
			
			if (this.descripcion == "")
			{
				seguir = false;		
				this.errDescripcion = "Debe indicar una Descripción";
			}
			
		  		
			if (seguir)
			{				
				xajax_guardarRollo(this.idRollo,
						           this.codigo,
						           this.idMaterial,
						           this.calibre,
						           this.pies,
						           this.idProveedor,
						           this.descripcion,
						           this.observaciones);
			}
			
			
		},
		limpiaDatos: function(){
			this.idRollo = 0;
			this.codigo = '';
			this.material = '0|';
			this.idMaterial = 0;
			this.claveMaterial = '0';	
			this.calibre = '0';
			this.pies = '0';
			this.proveedor = '0|';
			this.idProveedor = 0;
			this.claveProveedor = '0';
			this.descripcion = '';
			this.observaciones = '';		
		},
		limpiaErrores: function(){
			this.errCodigo = '';		
			this.sucCodigo = '';
			this.errMaterial = '';
			this.errCalibre = '';
			this.errPies = '';
			this.errProveedor = '';
			this.errDescripcion = '';
			this.errObservaciones = '';
		},
		fnRegresarAListado: function(){
			window.location = URL_BASE + "rollo";
		}
	}
  
});