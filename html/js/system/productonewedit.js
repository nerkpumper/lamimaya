

var app = new Vue({
	el: '#app',
	data: {		
		idProducto: 0,
		isLoading: false,
		codigo: '',
		tipoProducto: '0=>',
		idTipoProducto: 0,
		claveTipoProducto: '0',
		aplicacion: '0=>',
		idAplicacion: 0,
		textoAplicacion: '',		
		material: '0=>0',
		idMaterial: 0,
		claveMaterial: '0',
		rollo: '0',
		calibre: '0',
		descripcion: '',
		descripcion2: '',
		medidaespecial: '',
		codigoAccesorio: '',
		pies: 0,
		origen: 'N',
		rolloCodigo: '',
		
		
		productoRollo: '0',
		unidad: 0,
		longitud: '',
		longitudmof: '',
		mlpieza: '',
		codeLongitud: '',
		listaPrecio: '0',
		isRango: false,
		tipoRango: '0',
		
		precio1: 0,
		precio2: 0,
		precio3: 0,
		precio4: 0,
		precioMendez: 0,
		precioRangoMendez: 0,
		costo: 0,
		
		
		rangoPrecio1: 'Rango 1',
		rangoPrecio2: 'Rango 2',
		rangoPrecio3: 'Rango 3',
		rangoPrecio4: 'Rango 4',
		rangoPrecioMendez: 'Rango Mendez',
		
		
		       
		errCodigo: '',		
		sucCodigo: '',
		errAplicacion: '',	
		errTipoProducto: '',
		errMaterial: '',
		errRollo: '',
		errCalibre: '',		
		errDescripcion: '',
		errDescripcion2: '',
		errUnidad: '',
		errLongitud: '',
		errMlpieza: '',
		errListaPrecio: '',
		errIsRango: '',
		errProductoRollo: '',
		errCodigoAccesorio: '',
		errPies: '',
		errOrigen: '',
		errTipoRango: '',
		
		
       
		accionModulo: 'Nuevo'
	},
	mounted: function () {
		if (typeof param1 !== 'undefined') {
			this.idProducto = param1;
			this.accionModulo = 'Actualizar';

			xajax_cargarProducto(this.idProducto);
		}

		this.$refs.tipoProducto.focus();
	},
	watch: {
		codigoAccesorio: function(val){			
			this.codigoAccesorio = val.toUpperCase();
			this.codigo = this.codigoAccesorio;
		},
		tipoProducto: function(val){
			xajax_obtenerClaveTipoProducto(val);			
		},	
		rollo: function(val){
			if (this.accionModulo != "Actualizar")
				{
				setTimeout(function(){xajax_obtenerCalibreRollo(val);}, 150);	
				}
			
						
		},
		aplicacion: function(val){
			xajax_obtenerClaveAplicacion(val);			
		},
		claveTipoProducto: function(val){
			if (val != "L")
			{
				this.aplicacion = '0=>';
			}
			
			if (val == "R")
			{
				this.tipoRango = 'R';
			}

		},
		material: function(val){
			xajax_obtenerClaveMaterial(val);			
		},
		unidad: function(val){
			this.verificaIsPieza();
		},
		longitud: function(val){
			
			this.longitud = val.toUpperCase();
			this.mlpieza = this.longitud;
			
			if (val != "")
			{
				
				this.codeLongitud = formatNumber(val);
//				if (this.longitud.includes("X"))
//				{
//					this.codeLongitud = this.longitud + "FT";
//					this.longitudmof = "FT";
//				}
//				else
//				{
//					this.codeLongitud = "-" + this.longitud + "MTS";
//					this.longitudmof = "MTS";
//				}
			}
			else
			{
				this.codeLongitud = "";
				this.longitudmof = "";
			}
		
			
//			this.longitud = val.toUpperCase();
//			
//			if (val != "")
//			{
//				this.codeLongitud = "X" + this.longitud;
//			}
//			else
//			{
//				this.codeLongitud = "";
//			}
//			
//			this.codeLongitud = this.codeLongitud.replace(".", "-");
//			this.codeLongitud = this.codeLongitud.replace(".", "-");
//			this.codeLongitud = this.codeLongitud.replace(".", "-");
//			this.codeLongitud = this.codeLongitud.replace(".", "-");
		}
	},
	computed: {
		esListaGalvamex: function(){
			return (this.listaPrecio == "G");
		},
		esAccesorio: function(){
			return (this.idTipoProducto == 4);
		},
		esPieza: function(){			
			return (this.unidad == 4);			
		},
		esRollo: function(){			
			return (this.idTipoProducto == 5);			
		},
		codigoGenerado: function(){
			
			if (this.esRollo)
			{			
				return this.codigo;
			}
			
			if (this.esAccesorio){
				//this.codigo = this.codigoAccesorio;
				
				this.errCodigo = '';
				this.sucCodigo = '';
				return this.codigo;
			}
			else{
				
				if (this.idProducto == 0){	
					
					if (this.rolloCodigo == "")
					{
						this.codigo = this.claveTipoProducto + this.textoAplicacion + " " + this.codeLongitud + " " + this.claveMaterial;
						
						
						
						if (this.calibre != '666' && this.calibre != '0')
						{
							this.codigo = this.codigo + this.calibre	
						}	
						
//						if (this.pies > '0' && !this.esPieza)
						if (this.pies > '0')
						{
							this.codigo = this.codigo + this.pies	;	
						}
						
						this.codigo = this.codigo + this.origen;
						
					}
					else
					{
						this.codigo = this.claveTipoProducto + this.textoAplicacion + " "+ this.codeLongitud + " "+ this.rolloCodigo;						
					}
					
//					this.codigo = this.codigo + this.codeLongitud;
					
					
					this.errCodigo = '';
					this.sucCodigo = '';
					
					if (this.idTipoProducto == 0 || this.idMaterial == 0 ||  (this.unidad != 4 && this.calibre == "0") ||  (this.unidad == 4 && this.longitud == "") || (this.idAplicacion == 0 && this.claveTipoProducto == "L"))				
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
			}			
		}	
	},
	methods:{	
		verificaCodigoCorrecto: function(){
			if (this.idTipoProducto == 0 || this.idMaterial == 0 ||  (this.unidad != 4 && this.calibre == "0") ||  (this.unidad == 4 && this.longitud == "") || (this.idAplicacion == 0 && this.claveTipoProducto == "L"))				
			{
				
				this.errCodigo = "El Código no está completo, es necesario seleccionar valores de las listas inferiores.";	
									
			}
			else
			{
				this.sucCodigo = "El Código está completo.";
			}
		},
		verificaIsPieza: function(){			
			if (this.unidad == 4)
			{				
				$('#listaPrecio').attr('disabled', true);
				this.rollo = "0";
				this.listaPrecio = "G";
				this.isRango = false;
			}
			else
			{			
				this.longitud = '';				
				setTimeout(function(){xajax_obtenerCalibreRollo(app.rollo);}, 150);
				$('#listaPrecio').attr('disabled', false);
			}
		},
		disableListasUnidadesPrecios: function(valor){
			$('#unidad').attr('disabled', valor);
			$('#listaPrecio').attr('disabled', valor);
			
			if (valor == false && !this.isLoading)
			{
				this.unidad = 0;
				this.listaPrecio = '0';
			}
			
		},
		guardarProducto: function(){
			var seguir = true;
		  
			this.limpiaErrores();
			
//			if (this.idTipoProducto == 0 || this.idMaterial == 0 || this.calibre == "0" || (this.idAplicacion == 0 && this.claveTipoProducto == "L"))
			
			if (!this.esAccesorio && !this.esRollo)
			{
				if (this.idTipoProducto == 0)
				{
					seguir = false;	
					this.errTipoProducto = "Debe seleccionar un Tipo Producto";
				}
				
				//if (this.calibre == "666" && this.unidad != 4 || this.unidad == 1 )
				//{
					//seguir = false;				
					//this.errCalibre = "Debe seleccionar un Calibre";
				//}
				
				if (this.idMaterial == "0" && this.idRollo > 1)
				{
					seguir = false;
					this.errMaterial = "Debe seleccionar un Material";
				}
				
				if (this.idAplicacion == 0 && this.claveTipoProducto == "L")
				{
					seguir = false;				
					this.errAplicacion = "Debe seleccionar una Aplicación";
				}
				
				if (this.rollo == "0" && this.unidad != 4)
				{
					seguir = false;
					this.errRollo = "Debe seleccionar un Rollo";
				}
				
				if (this.descripcion == "")
				{
					seguir = false;		
					this.errDescripcion = "Debe indicar una Descripción";
				}	
				
				if (!this.esPieza)
				{		
					this.longitud = '';
					this.mlpieza = '0'
				}
				else
				{
					if (this.longitud == "")
					{
						seguir = false;		
						this.errLongitud = "Debe indicar una Longitud";
					}
					
					if (this.mlpieza == "")
					{
						seguir = false;		
						this.errMlpieza = "Debe indicar una medida ML de la pieza";
					}
				}
			}
			else
			{
				if (this.esRollo)
				{
					if (this.idTipoProducto == 0)
					{
						seguir = false;	
						this.errTipoProducto = "Debe seleccionar un Tipo Producto";
					}
					
										
					if (this.productoRollo == "0")
					{
						seguir = false;
						this.errProductoRollo = "Debe seleccionar un Rollo";
					}
					
					if (this.descripcion == "")
					{
						seguir = false;		
						this.errDescripcion = "Debe indicar una Descripción";
					}
					
					this.codigo = $("#productoRollo option:selected").text();
					this.rollo = this.productoRollo;
					this.idMaterial = 1;
					this.idAplicacion = 1;				
				}
				else
				{
					if (this.codigoAccesorio == "")
					{
						seguir = false;
						this.errCodigoAccesorio = "Debe ingresar el código del producto.";						
					}
					
					if (this.idTipoProducto == 0)
					{
						seguir = false;	
						this.errTipoProducto = "Debe seleccionar un Tipo Producto";
					}
								
					
					if (this.descripcion == "")
					{
						seguir = false;		
						this.errDescripcion = "Debe indicar una Descripción";
					}
					
					this.codigo = this.codigoAccesorio;
					this.rollo = 1;
					this.idMaterial = 1;
					this.idAplicacion = 1;	
				}
			}
			
			
		  		
			if (seguir)
			{			
				
			console.log("Intentando guardar producto...");
			console.log("medidaespecial:", this.medidaespecial);

//				alert(this.idProducto +	this.codigo + this.idTipoProducto + this.idAplicacion + this.idMaterial + this.rollo +  this.calibre +  this.descripcion);
				
				xajax_guardarProducto(this.idProducto,
						           this.codigo,
						           this.idTipoProducto,
						           this.idAplicacion,
						           this.idMaterial,
						           this.rollo,
						           this.calibre,
						           this.pies,
						           this.origen,
						           this.descripcion,
						           this.longitud,
						           this.mlpieza,
						           this.unidad,
						           this.listaPrecio,
						           this.tipoRango,
						           this.esRollo,
						           this.precio1,
						           this.precio2,
						           this.precio3,
								   this.precio4,
						           this.precioMendez,
						           this.costo,
						           this.medidaespecial);
						           
			}
			
			
		},
		limpiaDatos: function(){
			this.idProducto= 0;
			this.codigo= '';
			this.tipoProducto= '0=>';
			this.idTipoProducto= 0;
			this.claveTipoProducto= '0';
			this.aplicacion= '0=>';
			this.idAplicacion= 0;
			this.textoAplicacion= '';		
			this.material= '0|';
			this.idMaterial= 0;
			this.claveMaterial= '0';
			this.rollo= '0';
			this.calibre= '0';
			this.costo= '0';
			this.precioMendez= '0';
			this.descripcion= '';
			this.rolloCodigo = '';
			this.tipoRango = '0';
		},
		limpiaErrores: function(){
			this.errCodigo= '';		
			this.sucCodigo= '';
			this.errAplicacion= '';	
			this.errTipoProducto= '';
			this.errMaterial= '';
			this.errRollo= '';
			this.errCalibre= '';		
			this.errDescripcion= '';
			this.errUnidad = '';
			this.errLongitud = '';
			this.errListaPrecio = '';
			this.errIsRango = '';
			this.errProductoRollo = '';
			this.errCodigoAccesorio = '';
			this.errTipoRango = '';
		},
		fnRegresarAListado: function(){
			window.location = URL_BASE + "producto";
		}
	}
  
});