
var app = new Vue({
	el: '#app',
	data: {
		noRollo: '',
		//2A431467JGP04
		//2A477954JGP01
		
		
		idRolloSeleccionado: '',
		codigoRolloSeleccionado: '',		
		rolloSeleccionado: '',
		calibreRolloSeleccionado: 0,
		pesoEstimadoXKiloRolloSeleccionado: 0,
		
		
		idRemisionRolloSeleccionado: 0,
		kilosNoRolloSeleccionado: 0,
		noRolloSeleccionado: '',
		
		idRegistroProduccion: 0,
		
		msgError: '',
			
		rollos: [],
		
		registrosProduccion: [],
		
		registroProduccionDetalle: [],
		
		//Registro de Produccion		
		rpKilosRollo: 0,
		rpKilosMaquilados: 0,
		rpTotalML: 0,
		
		//stock
		stockPiezas: 1,
		errStockPiezas: '',				
		stockML: 0,
		errStockML: '',
		stockIdProducto: 0,
		errStockIdProducto: '',
		
		//Pyc
		pycPiezas: 1,
		errPycPiezas: '',				
		pycML: 1,
		errPycML: '',
		
		//Pedido
		pedidoIdPedido: '',
		pedidoMsgPedido: '',
		pedidoShortUnidad: '',
		pedidoCliente: '',
		pedidoPedidoDetalle: [],
		pedidoDespachando: false,
		pedidoDespachandoProducto: '',
		pedidoIdPedidoDetalle: 0,
		
		pedidoTotalPiezas: 0,
		pedidoML: 0,
		pedidoPorDespachar: 0,
		pedidoPiezas: 1,
		errPedidoPiezas: '',
		
		
		
		//shows
		showListadoRollos: true,
		showRolloSeleccionado: false,
		showBotonCrearRegistroProduccion: false,
		
		showRegistroDeProduccion: false,
		showBotonesAddRegistro: true,
		
		showFormByPedido: false,
		showFormByStock: false,
		showFormByPYC: false,
		
		//botones registro produccion
		showButtonRegistrarRPStock: true,
		showButtonRegistrarRPPyc: true,
		showButtonRegistrarRPPedido: true
	},
	created: function() {
//idregistroproduccion, idremisionrollo, consecutivonorollo, kilos, kilosmaquilados, totalml, fecha_creacion, fecha_termina
//        this.registrosProduccion.push({
//        	idRegistroProduccion: 1,
//        	idRemisionRollo: 10,
//        	consecutivoNoRollo: 1,
//        	kilos: 100,
//        	kilosMaquilados: 10,
//        	totalML: 40,
//        	fechaCreacion: '2018-01-01',
//        	fechaTermino: '2018-01-03'
//        });
		
//		this.pedidoPedidoDetalle.push({
//			idPedidoDetalle: 1, 
//			proCodigo: 'ddd', 
//			proDescripcion: 'fsdfasd', 
//			proIdRollo: 10, 
//			shortUnidad: 'ML', 
//			partida: 10, 
//			cantidad: 10, 
//			cantidadReal: 10, 
//			explotarUnidad: 4 , 
//			partidaDespachada: 0, 
//			despachado: 'NO'
//		});
		
        
		
	},
	watch: {
		noRollo: function(val){
			this.noRollo = val.toUpperCase();
			this.rollos.splice(0, this.rollos.length);
		},
		pedidoIdPedido: function(val){
			this.pedidoCliente = "";
			this.pedidoNoDespachar();
		},		
		pedidoPiezas: function(val){
			
			this.errPedidoPiezas = "";
			
			if (this.pedidoPiezas == '')
			{
				this.errPedidoPiezas = "Introduzca valor";
				return;
			}
			
			if (this.pedidoPiezas > this.pedidoPorDespachar)
			{
				this.errPedidoPiezas = "La cantidad a Despachar debe ser menor o igual a lo pendiente por Despachar.";	
			}
			
		},
		stockPiezas: function(val){
			
			this.errStockPiezas = "";
			
			if (this.stockPiezas == '')
			{
				this.errStockPiezas = "Introduzca valor";
								
			}
		},
		stockML: function(val){
			
			this.errStockML = "";
			
			if (this.stockML == '')
			{
				this.errStockML = "ML debe ser mayor a cero.";
								
			}
		},
		stockIdProducto: function(val){
//			console.log(val);
			this.errStockIdProducto = "";
			
			if (this.stockIdProducto == 0)
			{
				this.errStockIdProducto = "Seleccione un Producto";
								
			}
			
			setTimeout(function(){
				app.stockML = "" + $("#selLongitudStockProducto option:selected").text();
			}, 100);
			
		},
		pycML: function(val){
			
			this.errPycML = "";
			
			if (this.pycML == '')
			{
				this.errPycML = "Introduzca valor";
								
			}
		}
	},
	computed: {
		rpKilosFaltantes: function(){
			
			var kf = this.rpKilosRollo - this.rpKilosMaquilados;
			
			return kf;
		},
		stockTotalML: function(){
						
			return parseFloat((this.stockPiezas * this.stockML).toFixed(2));
			
		},
		stockTotalKG: function(){
			
			return parseFloat((this.stockTotalML * this.pesoEstimadoXKiloRolloSeleccionado).toFixed(2));
			
		},
		pycTotalML: function(){
			
			return parseFloat((this.pycPiezas * this.pycML).toFixed(2));
			
		},
		pycTotalKG: function(){
			
			return parseFloat((this.pycTotalML * this.pesoEstimadoXKiloRolloSeleccionado).toFixed(2));
			
		},
		pedidoMLDespachar: function(){
			
			return parseFloat(this.pedidoPiezas * this.pedidoML).toFixed(2);
		},
		pedidoKGDespachar: function(){
			
			var result = 0;
			
			if (this.pedidoShortUnidad != "KG")
			{
				result = parseFloat((this.pedidoPiezas * this.pedidoML * this.pesoEstimadoXKiloRolloSeleccionado).toFixed(2));	
			}
			else
			{
				result = parseFloat(this.pedidoPiezas).toFixed(2);
			}
			
			return (isNaN(result) ? 0 : result);
		},
		
	},
	methods: {
		cargarDatosNoRollo: function(){
			if (this.noRollo != "")
			{		
				this.msgError = '';
				xajax_cargarNoRemisiones(this.noRollo);
			}
			else
			{
				saTexto("Debes introducir un Número de Rollo");
			}
		},
		seleccionarOtroNoRollo: function(){
			this.pedidoIdPedido = '';
			this.showListadoRollos = true;
			this.showRolloSeleccionado = false;
			this.showRegistroDeProduccion = false;
			this.cancelarIngresoRegistro();
			this.cargarDatosNoRollo();
		},
		seleccionarNoRemision: function(indexrollo, indexnorollo){
			
			this.showListadoRollos = false;
			this.showRolloSeleccionado = true;
						
			this.codigoRolloSeleccionado = this.rollos[indexrollo].codigo;
			this.idRolloSeleccionado = this.rollos[indexrollo].idRollo;
			this.rolloSeleccionado = this.rollos[indexrollo].descripcion;
			this.idRemisionRolloSeleccionado = this.rollos[indexrollo].noRollos[indexnorollo].idRemisionRollo;
			this.noRolloSeleccionado = this.rollos[indexrollo].noRollos[indexnorollo].noRollo;
			
//			alert("cargar registrosproducción");
			xajax_cargarRegistrosProduccionTerminados(this.idRemisionRolloSeleccionado);
			
//			alert("vamos por " + this.rollos[indexrollo].noRollos[indexnorollo].idRemisionRollo + '\n' + 
//				  "rollo: " + this.rollos[indexrollo].descripcion );
			
		},
		crearRegistroProduccion: function(){
			
			swal({
		        title: "Confirme",
		        text: "Se creará un Registro de Producción por los kilos disponibles del Número de Rollo",
		        type: "warning",
		        showCancelButton: true,
		        confirmButtonColor: "#DD6B55",
		        confirmButtonText: "Si",
		        cancelButtonText: "No",
		        closeOnConfirm: false
		    }, function () {
		    	app.showBotonCrearRegistroProduccion = false;
		    	xajax_crearRegistroProduccion(app.idRemisionRolloSeleccionado);
		    });	
		},
		cargarDatosRegistroProduccionAbierto: function(){
			this.showRegistroDeProduccion = true;
			xajax_cargarDatosRegistroProduccionAbierto(this.idRegistroProduccion);
//			alert("vamos a cargar registro produccion: " + this.idRegistroProduccion);
		},
		cancelarIngresoRegistro: function(){
			this.showFormByPedido = false;
			this.showFormByStock = false;
			this.showFormByPYC = false;
			this.showBotonesAddRegistro = true;
		},
		ingresarRPStock: function(){
			this.stockIdProducto = 0;
			xajax_cargarProductosParaStock(this.idRolloSeleccionado);
			this.stockPiezas = 1;
			this.stockML = 0;
			this.showFormByStock = true;			
			this.showBotonesAddRegistro = false;
			this.showButtonRegistrarRPStock = true;
		},
		ingresarRPPedido: function(){
			this.pedidoIdPedido = '';
			this.pedidoPiezas = 1;
			this.showFormByPedido = true;		
			this.showButtonRegistrarRPPedido = true;
			this.showBotonesAddRegistro = false;
			
		},
		ingresarRPPYC: function(){
			this.pycML = 1;
			this.showFormByPYC = true;
			this.showBotonesAddRegistro = false;
			this.showButtonRegistrarRPPyc = true;
			
		},
		registrarRPStock: function(){
			
			this.errStockIdProducto = "";
			
			if (this.stockIdProducto == 0)
			{
				this.errStockIdProducto = "Seleccione un Producto";
								
			}
			
			if (this.stockTotalKG > 0)
			{
				swal({
			        title: "Confirme",
			        text: "Se ingresará la información indicada y se harán movimientos en inventario sobre el Número de Rollo y el Rollo en General",
			        type: "warning",
			        showCancelButton: true,
			        confirmButtonColor: "#DD6B55",
			        confirmButtonText: "Si",
			        cancelButtonText: "No",
			        closeOnConfirm: false
			    }, function () {
			    	app.showButtonRegistrarRPStock = false;
			    						
			    	xajax_registrarRPStock(app.idRolloSeleccionado, app.idRemisionRolloSeleccionado, app.idRegistroProduccion, app.stockIdProducto, app.stockPiezas, app.stockML, app.pesoEstimadoXKiloRolloSeleccionado, app.stockTotalKG);
//			    	xajax_registrarRPStock(this.idRegistroProduccion, this.stockPiezas, this.stockML, this.pesoEstimadoXKiloRolloSeleccionado, this.stockTotalKG);
			    });				
			}
			else
			{
				saInfo("Ingrese los datos necesarios");
			}
				
		},
		registrarRPPyc: function(){
			
			if (this.pycTotalKG > 0)
			{
				swal({
			        title: "Confirme",
			        text: "Se ingresará la información indicada y se harán movimientos en inventario sobre el Número de Rollo y el Rollo en General",
			        type: "warning",
			        showCancelButton: true,
			        confirmButtonColor: "#DD6B55",
			        confirmButtonText: "Si",
			        cancelButtonText: "No",
			        closeOnConfirm: false
			    }, function () {
			    	app.showButtonRegistrarRPPyc = false;

			    	xajax_registrarRPPyc(app.idRolloSeleccionado, app.idRemisionRolloSeleccionado, app.idRegistroProduccion, app.pycPiezas, app.pycML, app.pesoEstimadoXKiloRolloSeleccionado, app.pycTotalKG);
//			    	xajax_registrarRPStock(this.idRegistroProduccion, this.stockPiezas, this.stockML, this.pesoEstimadoXKiloRolloSeleccionado, this.stockTotalKG);
			    });				
			}
			else
			{
				saInfo("Ingrese los datos necesarios");
			}
				
		},
		cargarPedidoDetalle: function(){
			
			this.pedidoMsgPedido = "";
			this.pedidoCliente = "";
			this.pedidoNoDespachar();
			
			if(this.pedidoIdPedido <= 0)
			{
				saTexto("No. de Pedido no válido");
				return;
			}
			
			xajax_cargarDatosPedido(this.pedidoIdPedido, this.idRolloSeleccionado);
		},
		pedidoDespacharPedidoDetalle: function(index){
			
			this.showButtonRegistrarRPPedido = true;
			this.pedidoDespachando = true;			
			this.pedidoDespachandoProducto = this.pedidoPedidoDetalle[index].proCodigo + ' ' + this.pedidoPedidoDetalle[index].proDescripcion; 
			
			this.pedidoTotalPiezas = this.pedidoPedidoDetalle[index].partida;
			this.pedidoML = this.pedidoPedidoDetalle[index].cantidadReal;
			this.pedidoPorDespachar = this.pedidoPedidoDetalle[index].partida - this.pedidoPedidoDetalle[index].partidaDespachada;
			this.pedidoShortUnidad = this.pedidoPedidoDetalle[index].shortUnidad;
			this.pedidoPiezas = 1;	
			this.pedidoIdPedidoDetalle = this.pedidoPedidoDetalle[index].idPedidoDetalle;
			
			
		},
		pedidoNoDespachar: function(){
			this.pedidoDespachando = false;	
		},
		registrarRPPedido: function(){
			
			if (this.pedidoKGDespachar > 0)
			{
				
				if(this.pedidoPiezas <= this.pedidoPorDespachar)				
				{
					swal({
				        title: "Confirme",
				        text: "Se ingresará la información indicada y se harán movimientos en inventario sobre el Número de Rollo y el Rollo en General",
				        type: "warning",
				        showCancelButton: true,
				        confirmButtonColor: "#DD6B55",
				        confirmButtonText: "Si",
				        cancelButtonText: "No",
				        closeOnConfirm: false
				    }, function () {
				    	app.showButtonRegistrarRPPedido = false;
				    	
				    	xajax_registrarRPPedido(app.idRolloSeleccionado, app.idRemisionRolloSeleccionado, app.idRegistroProduccion, app.pedidoIdPedidoDetalle, app.pedidoPiezas, app.pedidoML, app.pesoEstimadoXKiloRolloSeleccionado, app.pedidoKGDespachar);
//				    	xajax_registrarRPStock(this.idRegistroProduccion, this.stockPiezas, this.stockML, this.pesoEstimadoXKiloRolloSeleccionado, this.stockTotalKG);
				    });		
				}
				else
				{
					saInfo("Ingrese los datos correctos");
				}
			}
			else
			{
				saInfo("Ingrese los datos necesarios");
			}
				
		},
		concluirRegistroProduccion: function(){
			if (this.rpKilosMaquilados == 0)
			{
				saInfo("No puede concluir un Registro de Producción sin Kilos Maquilados.");
				return;
			}
			
			swal({
		        title: "Confirme",
		        text: "Se concluirá el Registro de Producción, realizando los cálculos y movimientos de Inventario de Rollo necesarios.",
		        type: "warning",
		        showCancelButton: true,
		        confirmButtonColor: "#DD6B55",
		        confirmButtonText: "Si",
		        cancelButtonText: "No",
		        closeOnConfirm: false
		    }, function () {
		    	app.showButtonRegistrarRPPedido = false;
		    	
		    	xajax_concluirRegistroProduccion(app.idRegistroProduccion);
//		    	xajax_registrarRPStock(this.idRegistroProduccion, this.stockPiezas, this.stockML, this.pesoEstimadoXKiloRolloSeleccionado, this.stockTotalKG);
		    });	
			
		},
		getRutaReporteProduccion: function(id){
			return URL_BASE + "registroproduccionprint?id=" + id.toString(); 
		}
		
	}
});