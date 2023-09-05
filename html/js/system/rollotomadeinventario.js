

var app = new Vue({
	el: '#app',
	data: {		
		idRollo: 0,
		codigo: 'codigo',
		descripcion: 'desc',
		proveedor: 'prove',
		remision: '',
		almacen: "NS",
		noRollo: '',
		kilos: '',

		// producto
		productoStock: '',
		errProductoStock: '',

		//
		tomaInventario: 0,
		chkVerCapturados: true,
		
		//rollo calibre y pies
		rollocalibre: 0,
		rollopies: 0,
		
		errRemision: '',
		errAlmacen: '',
		errNoRollo: '',
		errKilos: '',
		
		ingresos: [],
		ingresosCapturados: [],

		productos: [],
		productosCapturados: [],
		
		blnNoRegistrados: false,
		blnProcesado: false
		
	},
	mounted: function () {
		if (typeof param1 !== 'undefined') {
			this.idRollo = param1;					  
//			alert("a cargar rollo");
//			xajax_cargarRollo(this.idRollo);	
//			setTimeout(function(){xajax_cargarRollo(app.idRollo);}, 1000);
			this.cargarRollo();
			
		}

		this.setTomaInventarioID();
		
		
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
		setTomaInventarioID: function(){
			this.ingresos.splice(0, this.ingresos.length);
			this.productos.splice(0, this.productos.length);
			mdlShowWait("Obteniendo Inventario Capturado.");
			xajax_setTomaInventarioID();
		},
		loadTomaInventarioActual: function(){
			xajax_loadTomaInventarioActual(this.tomaInventario);
			xajax_loadTomaInventarioStockActual(this.tomaInventario);
			mdlExitWait();
		},
		enlistarNoRollo: function(){
//			alert("Enlistar Rollo");
			var seguir = true;

			this.errNoRollo = "";
			// this.errKilos = "";

			if (this.noRollo == "")
			{
				this.errNoRollo = "Ingrese NoRollo";
				seguir = false;
			}

			// if (this.kilos == 0 || this.kilos == "")
			// {
			// 	this.errKilos = "Ingrese Kilos";
			// 	seguir = false;
			// }



			if (seguir)
			{
				this.ingresos.push({
					idtomainventariodetalle: 0,	
					idremisionrollo: 0,
					norollo: this.noRollo,
					idrollo: 1,
					codigo: '-',
					idrollooriginal: 1,
					almacen: 'ALMACEN PRINCIPAL',
					almacenoriginal: 'ALMACEN PRINCIPAL',
					kilos: 0,
					kilosoriginal: 0,
					cargadoensistema: false,
					infosistemacargada: false,
					oklista: 'SI',
					idregistroproduccion: 0,
					rpterminado: 'SI',
					rpmaquilados: 0
				});

				this.buscarRepetidosEnLista();

				var norollo =  this.noRollo;
				var index = this.ingresos.length - 1;
				setTimeout (function() { xajax_obtenerRemisionRollo(index,norollo);}, 100);

			
				this.$refs.noRollo.focus();

				this.noRollo = "";
				this.kilos = "";
			}
					
		},
		enlistarProductoStock: function(){
			//			alert("Enlistar Rollo");
						var seguir = true;
			
						this.errProductoStock = "";
						
			
						if (this.productoStock == "")
						{
							this.errProductoStock = "Ingrese Código de Producto";
							seguir = false;
						}
			
						
			
			
						if (seguir)
						{

							var indexLista = 0;

							indexLista = this.getIndexProductos(this.productoStock);

							if (indexLista == -1)
							{
								this.productos.push({
									idproducto: 0,
									codigo: this.productoStock,
									descripcion: '',
									existencia: 0,
									inventario: 1,									
									cargadoensistema: false,
									infosistemacargada: false,
									isstock: false								
								});

															// this.buscarRepetidosEnLista();
			
								var codigo =  this.productoStock;
								var index = this.productos.length - 1;
								setTimeout (function() { xajax_obtenerProducto(index,codigo);}, 100);

							}
							else
							{
								this.productos[indexLista].inventario = this.productos[indexLista].inventario + 1; 
							}

							
			
			
						
							this.$refs.productoStock.focus();
			
							this.productoStock = "";
							
						}
								
					},
		getIndexProductos: function(codigo){
			var indexReturn = -1;
			
			for (i = 0 ; i < this.productos.length ; i++)
					    {
							
					        if(this.productos[i].codigo == codigo)
					        	 {
									indexReturn = i;
									break;
					        	 }
						}
						
			return indexReturn;

		},
		buscarRepetidosEnLista: function(){
			
			for (i = 0 ; i < this.ingresos.length ; i++)
				{
					this.ingresos[i].oklista = 'SI';
					for (i2 = 0 ; i2 < this.ingresos.length ; i2++)
					    {
							
					        if(this.ingresos[i].norollo == this.ingresos[i2].norollo && i != i2)
					        	 {
					        		this.ingresos[i].oklista = 'NO';
					        	 }
					    }
				}
			
		},
		cargarRollo: function(){
//			alert("a cargar rollo");
			xajax_cargarRollo(this.idRollo);
		},
		
		nuevaRecepcion: function(){
			this.blnProcesado = false;
			this.ingresos.splice(0, this.ingresos.length);
			this.limpiaDatos();
			this.$refs.remision.focus();	
		},
		
		registrarIngreso: function(){
			this.blnNoRegistrados = false;
			var i = 0;
			
			if (this.procedeIngresarASistema())	
			{
				mdlShowWait("Registrando Captura de Inventario.");
				xajax_registrarInventario(this.tomaInventario, this.ingresos, this.almacen);
				
			}
			
			
			
		},
		procedeIngresarASistema: function(){
			var procede = true;
			var i = 0;

			for (i = 0 ; i < this.ingresos.length ; i++)
			{
				if (this.ingresos[i].idrollo == 1 || this.ingresos[i].kilos <= 0 || this.ingresos[i].oklista == 'NO')
				{
					procede = false;
					saError("Debe ajustar algunos valores en la lista.");
					break;
				}
			}

			console.log("antes de limpiar el error almacen");
			this.errAlmacen = "";
			if (this.almacen == 'NS')
			{
				console.log("err almacen = NS");
				this.errAlmacen = 'Seleccione Almacen donde se toma Inventario.';
				procede = false;
				saError("Debe indicar el Almacén donde se toma Inventario.");
			}

			return procede;
			
		},
		registrarProductos: function(){
			this.blnNoRegistrados = false;
			var i = 0;
			
			if (this.procedeIngresarProductosASistema())	
			{
				mdlShowWait("Registrando Captura de Productos Stock.");
				xajax_registrarProductos(this.tomaInventario, this.productos);
				
			}
			
			
			
		},
		procedeIngresarProductosASistema: function(){
			var procede = true;
			var i = 0;

			for (i = 0 ; i < this.productos.length ; i++)
			{
				if (this.productos[i].idproducto == 0 || this.productos[i].inventario <= 0 || !this.productos[i].isstock)
				{
					procede = false;
					saError("Debe ajustar algunos valores en la lista.");
					break;
				}
			}

			// console.log("antes de limpiar el error almacen");
			

			return procede;
			
		},
		probarIndex: function(){
			this.blnNoRegistrados = true;
			this.ingresos[2].estatusLabel = "<span class='label label-danger'>El N&uacute;mero de Rollo ya se encuentra registrado.</span>";
			this.blnProcesado = true;
		},
		quitarIngreso: function(index){
			this.ingresos.splice(index, 1);
			
			this.buscarRepetidosEnLista();
		},
		quitarProducto: function(index){
			this.productos.splice(index, 1);
			
			// this.buscarRepetidosEnLista();
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
		},
		getRutaReporteProduccion: function(id){
			return URL_BASE + "registroproduccionprint?id=" + id.toString(); 
		},
		addForTest: function(){
			// this.ingresos.push({
			// 	idremisionrollo: 0,
			// 	norollo: 'ABCDE12345',
			// 	idrollo: 1,
			// 	codigo: '-',
			// 	idrollooriginal: 1,
			// 	almacen: 'ALMACEN PRINCIPAL',
			// 	almacenoriginal: 'ALMACEN PRINCIPAL',
			// 	kilos: 500,
			// 	kilosoriginal: 500,
			// 	cargadoensistema: false,
			// 	infosistemacargada: false,
			// 	oklista: 'SI',
			// 	idregistroproduccion: 0,
			// 	rpterminado: 'SI',
			// 	rpmaquilados: 0
			// });

			this.ingresos.push({
				idtomainventariodetalle: 0,	
				idremisionrollo: 0,
				norollo: 'ABCDE12345',
				idrollo: 1,
				codigo: '-',
				idrollooriginal: 1,
				almacen: 'NS',
				almacenoriginal: 'NS',
				kilos: 0,
				kilosoriginal: 0,
				cargadoensistema: true,
				infosistemacargada: false,
				oklista: 'SI',
				idregistroproduccion: 0,
				rpterminado: 'SI',
				rpmaquilados: 0
			});

			this.buscarRepetidosEnLista();
		}
	}
  
});



$(document).ready(function()
{
    $("#collapseLeftMenu").click();
});
