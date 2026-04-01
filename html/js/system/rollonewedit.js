

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
		origen: '0',
		proveedor: '0=>',
		idProveedor: 0,
		claveProveedor: '0',
		grado: 0,
		color: '0=>',
		idColor: 0,
		claveColor: '0',
		
		descripcion: '',		
		observaciones: '',
       
		errCodigo: '',		
		sucCodigo: '',
		errMaterial: '',
		errColor: '',
		errCalibre: '',
		errPies: '',
		errOrigen: '',
		errProveedor: '',
		errDescripcion: '',
		errObservaciones: '',
		
		errGrado: '',

		precio1: 0,
		precio2: 0,
		precio3: 0,
		precio4: 0,
		preciokg1: 0,
		preciokg2: 0,
		preciokg3: 0,
		preciokg4: 0,
		precioMendez: 0,
		precioRangoMendez: 0,
		costo: 0,
		
		
		rangoPrecio1: 'Rango 1',
		rangoPrecio2: 'Rango 2',
		rangoPrecio3: 'Rango 3',
		rangoPrecio4: 'Rango 4',
		rangoPrecioMendez: 'Rango Mendez',
		
       
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
		color: function(val){
			xajax_obtenerClaveColor(val);
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
//				this.codigo = "R" + this.claveMaterial + "C" + this.calibre + this.pies + this.claveProveedor;
				this.codigo = "R" + this.claveMaterial +  this.calibre + this.pies  + this.origen + this.claveProveedor + this.claveColor + 'G' + this.grado;
				
				
				
				
				this.errCodigo = '';
				this.sucCodigo = '';
				
				if (this.idMaterial == 0 || this.calibre == "0" || this.pies == "0" || this.origen == "0" || this.idProveedor == 0 || this.idColor == 0)
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
			if (this.idMaterial == 0 || this.calibre == "0" || this.pies == "0" || this.idProveedor == 0 || this.descripcion == "" || this.idColor == 0)
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
			
			if (this.grado == 0)
			{
				seguir = false;	
				this.errGrado = "Debe indicar un Grado";
			}
			
			if (this.idColor == 0)
			{
				seguir = false;	
				this.errColor = "Debe especificar Color";
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
			
			if (this.origen == "0")
			{
				seguir = false;
				this.errOrigen = "Debe seleccionar Origen";
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
						           this.origen,
						           this.idProveedor,
						           this.idColor,
						           this.grado,
						           this.descripcion,
						           this.observaciones,
								   this.precio1,
						           this.precio2,
						           this.precio3,
								   this.precio4,
								   this.preciokg1,
						           this.preciokg2,
						           this.preciokg3,
								   this.preciokg4
								   );
			}
			
			
		},
		limpiaDatos: function(){
			this.idRollo = 0;
			this.codigo = '';
			this.material = '0=>';
			this.idMaterial = 0;
			this.claveMaterial = '0';
			this.color = '0=>';
			this.idColor = 0;
			this.claveColor = '0';
			this.calibre = '0';
			this.pies = '0';
			this.origen = '0';
			this.proveedor = '0|';
			this.idProveedor = 0;
			this.claveProveedor = '0';
			this.descripcion = '';
			this.observaciones = '';
			this.grado = 0;
		},
		limpiaErrores: function(){
			this.errCodigo = '';		
			this.sucCodigo = '';
			this.errMaterial = '';
			this.errColor = '';
			this.errGrado = '';
			this.errCalibre = '';
			this.errPies = '';
			this.errOrigen = '';
			this.errProveedor = '';
			this.errDescripcion = '';
			this.errObservaciones = '';
		},
		fnRegresarAListado: function(){
			window.location = URL_BASE + "rollo";
		}
	}
  
});