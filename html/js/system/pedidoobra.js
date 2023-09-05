
var app = new Vue({
	el: '#app',
	data: {
		idPedido: '',
		seleccionarPedido: true,
		
		filtroNoRollo: '',
		
		showPYC: false,

		retirarRollosDeObra: false,
		
		nrNoRolloSeleccionado: false,
		nrIdRemisionRollo: 0,
		nrCodigoRollo: '',
		nrNoRollo: '',
		nrRollo: '',
		nrKilos: 0,
		nrCalibre: 0,
		nrPies: 0,
		nrExistencia: 0,
		nrAlmacen: '',
		nrAlmacenOriginal: '',
		nrIdPedidoObra: 0,
		nrIdRegistroProduccion: 0,
		nrKilosMaquilados: 0,
		nrTotalML: 0,
		nrTerminado: 'NO',
		nrSucursalRollo: 0,
		nrFactor: 0,
		nrRendimiento: 0,
		
		//Pyc
		pycPiezas: 1,
		errPycPiezas: '',				
		pycML: 1,
		errPycML: '',
		
		//////////////
		pedidoEstado: '',
		pedidoRecogeEngrega: '',
		pedidoDespieceTerminado: '',
		
		
		//Pedido
		pedidoIdPedido: '',
		pedidoMsgPedido: '',
		pedidoShortUnidad: '',
		pedidoCliente: '',
		
		pedidoPedidoDetalle: [],
		pedidoDespachando: false,
		pedidoDespachandoProducto: '',
		pedidoIdPedidoDetalle: 0,
		pedidoIdProducto: 0,
		pedidoIdPedidoDetalleColocacion: 0,
		
		pedidoTotalPiezas: 0,
		pedidoML: 0,
		pedidoPorDespachar: 0,
		pedidoPiezas: 1,
		errPedidoPiezas: '',
		errPedidoTotalPiezas: '',
		
		nrPesoEstimadoXKiloRolloSeleccionado: 0,
		
		registroProduccionDetalle: [],
		
		rollosObra: [],
		
		rollosParaAnadir: [],
		
	},
	mounted: function(){
		
//		setTimeout(function () { app.cargarRollosEnObra();}, 200);
//		
	},
	computed: {
		pycTotalML: function(){
			
			return parseFloat((this.pycPiezas * this.pycML).toFixed(2));
			
		},
		pycTotalKG: function(){
			
			return parseFloat((this.pycTotalML * this.nrPesoEstimadoXKiloRolloSeleccionado).toFixed(2));
			
		},
		rollosParaAnadirFiltrados:function(){

	    	 var self=this;
	    	 return this.rollosParaAnadir.filter(function(cust){

	    		 var str = cust.noRollo;
	    		 var find = self.filtroNoRollo;
	    		 
	    		 str = str.toUpperCase();
	    		 find = find.toUpperCase();

	    		 return str.includes(find);

	    	 });
	       //return this.customers;
	    },
	    pedidoMLDespachar: function(){
			
//			return parseFloat(this.pedidoPiezas * this.pedidoML).toFixed(2);
	    	return parseFloat(this.pedidoPiezas * this.pedidoTotalPiezas).toFixed(2);
		},
		pedidoKGDespachar: function(){
			
			var result = 0;
//			return 1234;	
			if (this.pedidoShortUnidad != "KG")
			{
//				console.log("is ml en pedidookfdespachar");
//				result = parseFloat((this.pedidoPiezas * this.pedidoML * this.nrPesoEstimadoXKiloRolloSeleccionado).toFixed(2));
				result = parseFloat((this.pedidoPiezas  * this.pedidoTotalPiezas * this.nrPesoEstimadoXKiloRolloSeleccionado).toFixed(2));
			}
			else
			{
				result = parseFloat(this.pedidoPiezas).toFixed(2);
			}
			
			return (isNaN(result) ? 0 : result);
		},
		
		
	},
	watch: {
		pedidoPiezas: function(val){
			
			this.errPedidoPiezas = "";
			
			if (this.pedidoPiezas == '')
			{
				this.errPedidoPiezas = "Introduzca valor";
				return;
			}
			
//			if (this.pedidoPiezas > this.pedidoPorDespachar)
//			{
//				this.errPedidoPiezas = "La cantidad a Despachar debe ser menor o igual a lo pendiente por Despachar.";	
//			}
			
		},
		pedidoTotalPiezas: function(val){
			this.errPedidoTotalPiezas = '';
			
			if (this.pedidoTotalPiezas == '' || this.pedidoTotalPiezas == 0)
			{
				this.errPedidoTotalPiezas = "Introduzcavalor";
			}
		}
	},
	methods: {
		pedidoNoDespachar: function(){
			this.pedidoDespachando = false;	
		},
		pedidoDespacharPedidoDetalle: function(index){
			
//			this.showButtonRegistrarRPPedido = true;
			this.pedidoDespachando = true;			
			this.pedidoDespachandoProducto = this.pedidoPedidoDetalle[index].proCodigo + ' ' + this.pedidoPedidoDetalle[index].proDescripcion; 
			
			this.pedidoTotalPiezas = this.pedidoPedidoDetalle[index].partida;
			this.pedidoML = this.pedidoPedidoDetalle[index].cantidadReal;
			this.pedidoPorDespachar = this.pedidoPedidoDetalle[index].partida - this.pedidoPedidoDetalle[index].partidaDespachada;
			this.pedidoShortUnidad = this.pedidoPedidoDetalle[index].shortUnidad;
			this.pedidoPiezas = 1;	
			this.pedidoIdPedidoDetalle = this.pedidoPedidoDetalle[index].idPedidoDetalle;
			this.pedidoIdProducto = this.pedidoPedidoDetalle[index].idProducto;
			this.pedidoIdPedidoDetalleColocacion = this.pedidoPedidoDetalle[index].idPedidoDetalleColocacion;
			
			
		},
		cargarPedidoDetalle: function(){
			
			this.pedidoMsgPedido = "";
//			this.pedidoCliente = "";
//			this.pedidoNoDespachar();
			
			if(this.idPedido <= 0)
			{
				saTexto("No. de Pedido no válido");
				return;
			}
			
			xajax_cargarDatosPedido(this.idPedido, this.nrNoRollo, this.nrSucursalRollo);
		},
		cargarDatosRegistroProduccionAbierto: function(){
//			this.showRegistroDeProduccion = true;
			xajax_cargarDatosRegistroProduccionAbierto(this.nrIdRegistroProduccion);
//			alert("vamos a cargar registro produccion: " + this.idRegistroProduccion);
		},
		asignarRolloAObra: function(idremisionrollo){
			console.log(" idremisionrollo "+idremisionrollo);

			var i;
			for (i = 0; i < this.rollosParaAnadir.length ; i++)
			{
				if (this.rollosParaAnadir[i].idRemisionRollo == idremisionrollo)
				{
					$("#modalNoRollos").modal("hide");
					mdlShowWait();
					xajax_asignarRemisionRolloAObra(this.rollosParaAnadir[i].idRemisionRollo, i, this.idPedido);
//					this.rollosParaAnadir.splice(i, 1);		
				}
			}
			
			
		},
		moverAAlmacen: function(idRemisionRollo, index, almacenDestino){
			// this.rollosObra.splice(index, 1);

			swal({
		        title: "Confirme",
		        text: "Se moverá el Rollo al Almacen indicado, ya no podrá utilizarlo en esta Obra. ¿Desea Continuar?",
		        type: "warning",
		        showCancelButton: true,
		        confirmButtonColor: "#DD6B55",
		        confirmButtonText: "Si",
		        cancelButtonText: "No",
		        closeOnConfirm: true
		    }, function () {
//		    	app.showBotonCrearRegistroProduccion = false;
		    	mdlShowWait();
		    	xajax_moverAAlmacen(idRemisionRollo, index, almacenDestino);
		    });	

		},
		quitarRolloAObra: function(){
			var i = 0;

			for(i = 0; i < this.rollosObra.length; i ++)
			{
				this.rollosObra[i].almacendestino = 'SN';
			}

			this.nrNoRolloSeleccionado = false;
			this.retirarRollosDeObra = true;
		},
		seleccionarNoRemision: function(idRemisionRollo){
//			alert("a cargar: " + idRemisionRollo);
			this.nrNoRolloSeleccionado = true;
			this.retirarRollosDeObra = false;
			
			//Pyc
			this.pycPiezas = 1;
			this.errPycPiezas = '';				
			this.pycML = 1;
			this.errPycML = '';
			this.showPYC = false;
			
			mdlShowWait();
			
			this.pedidoNoDespachar();
			
			setTimeout(function() { xajax_cargarNoRemision(idRemisionRollo, app.idPedido); }, 150);
			
			setTimeout(function() { xajax_cargarPesoEstimadoXCalibrePies(app.nrCalibre, app.nrPies); }, 500 );
			setTimeout(function() { app.cargarDatosRegistroProduccionAbierto(); }, 1000 );
			setTimeout(function() { app.cargarPedidoDetalle(); }, 500);
			
			
		},
		refresh: function(){
			this.cargarDatosPedido();
		},
		cargarDatosPedido: function(){
//			alert("cargamos");
			
			if (this.idPedido == "")
			{
				saTexto("Indique el Número de Pedido");
				return;
			}
			

			if (this.idPedido == 0)
			{
				saTexto("Indique el Número de Pedido");
				return;
			}
						
			this.rollosObra.splice (0, this.rollosObra.length);	
			xajax_cargarPedido(this.idPedido);	
			this.seleccionarPedido = false;			
			
			
		},
		seleccionarOtroPedido: function(){
			this.idPedido = '';
			this.seleccionarPedido = true;
		},
		cargarRollosEnObra: function(){
			xajax_cargarRollosEnObra(this.idPedido);
		},
		agregarRolloAObra: function (){
			$("#modalNoRollos").modal("show");
			this.filtroNoRollo = "";
			xajax_cargarNoRolloParaObra(this.idPedido);
			
//			setTimeout(function() { $("#modalNoRollos").modal("hide"); } , 2000);
		},
		agregarRolloAObra2: function (){
			$("#modalNoRollos").modal("show");
			
			xajax_cargarNoRolloParaObra(this.idPedido);
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
//		    	app.showBotonCrearRegistroProduccion = false;
		    	mdlShowWait();
		    	xajax_crearRegistroProduccion(app.nrIdRemisionRollo);
		    });	
		},
		terminarDespiece: function(){
			
			if (this.rollosObra.length > 0)
			{
				saError("No puede terminar con el despiece hasta que haya retirado los rollos de la Obra.");
				return;
			}


			swal({
		        title: "Confirme",
		        text: "Se terminará el despiece del pedido, ya no podrá registrar produccion en esta pantalla. \nSe hará un recalculo de los totales del Pedido. \nLos rollos utilizados para este Pedido, se regresarán al Almacen donde se ubicaban previo a este proceso.",
		        type: "warning",
		        showCancelButton: true,
		        confirmButtonColor: "#DD6B55",
		        confirmButtonText: "Entendido",
		        cancelButtonText: "No",
		        closeOnConfirm: true
		    }, function () {
		    			    	
		    	mdlShowWait();
		    	xajax_terminarPedido(app.idPedido);
//		    	setTimeout(function() { mdlExitWait();}, 2000);
		    });
		},
		registrarRPPedido: function(){
			
			if (this.pedidoKGDespachar > 0)
			{
//				console.log((this.rpKilosMaquilados + this.pedidoKGDespachar));
//				console.log((this.rpKilosRollo * 1.1));
				if ((this.nrKilosMaquilados + this.pedidoKGDespachar) < (this.nrKilos * 1.1))
				{
//					if(this.pedidoPiezas <= this.pedidoPorDespachar)				
//					{
						swal({
					        title: "Confirme",
					        text: "Se ingresará la información indicada y se harán movimientos en inventario sobre el Número de Rollo y el Rollo en General",
					        type: "warning",
					        showCancelButton: true,
					        confirmButtonColor: "#DD6B55",
					        confirmButtonText: "Si",
					        cancelButtonText: "No",
					        closeOnConfirm: true
					    }, function () {
					    	app.showButtonRegistrarRPPedido = false;
					    	console.log ("registrar rp Pedido");
					    	xajax_registrarRPPedido(app.nrNoRollo, app.nrIdRemisionRollo, app.nrIdRegistroProduccion, app.pedidoIdPedidoDetalle, app.pedidoIdProducto , app.pedidoTotalPiezas, app.pedidoPiezas, app.nrPesoEstimadoXKiloRolloSeleccionado, app.pedidoKGDespachar, app.pedidoIdPedidoDetalleColocacion, app.nrSucursalRollo);
//					    	xajax_registrarRPStock(this.idRegistroProduccion, this.stockPiezas, this.stockML, this.pesoEstimadoXKiloRolloSeleccionado, this.stockTotalKG);
					    });		
//					}
//					else
//					{
//						saInfo("Ingrese los datos correctos");
//					}
				}
				else
				{
					//saInfo("La Cantidad que desea Ingresar superará la Cantidad total del Rollo(+10%).");
					swal({
				        title: "Confirme",
				        text:"La Cantidad que desea Ingresar superará la Cantidad total del Rollo(+10%).",
				        text: "Se ingresará la información indicada y se harán movimientos en inventario sobre el Número de Rollo y el Rollo en General",
				        type: "warning",
				        showCancelButton: true,
				        confirmButtonColor: "#DD6B55",
				        confirmButtonText: "Si",
				        cancelButtonText: "No",
				        closeOnConfirm: true
				    }, function () {
				    	app.showButtonRegistrarRPPedido = false;
				    	console.log ("registrar rp Pedido");
				    	xajax_registrarRPPedido(app.nrNoRollo, app.nrIdRemisionRollo, app.nrIdRegistroProduccion, app.pedidoIdPedidoDetalle, app.pedidoIdProducto , app.pedidoTotalPiezas, app.pedidoPiezas, app.nrPesoEstimadoXKiloRolloSeleccionado, app.pedidoKGDespachar, app.pedidoIdPedidoDetalleColocacion, app.nrSucursalRollo);
//				    	xajax_registrarRPStock(this.idRegistroProduccion, this.stockPiezas, this.stockML, this.pesoEstimadoXKiloRolloSeleccionado, this.stockTotalKG);
				    });		
				}
				
			}
			else
			{
				saInfo("Ingrese los datos necesarios");
			}
				
		},
		registrarRPPyc: function(){
			
			if (this.pycTotalKG > 0)
			{
//				console.log((this.rpKilosMaquilados + this.pycTotalKG));
//				console.log((this.rpKilosRollo * 1.1));
				if ((this.nrKilosMaquilados + this.pycTotalKG) < (this.nrKilos * 1.1))
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

				    	xajax_registrarRPPyc(app.nrNoRollo, app.nrIdRemisionRollo, app.nrIdRegistroProduccion, app.pycPiezas, app.pycML, app.nrPesoEstimadoXKiloRolloSeleccionado, app.pycTotalKG, app.nrSucursalRollo);
//				    	xajax_registrarRPStock(this.idRegistroProduccion, this.stockPiezas, this.stockML, this.pesoEstimadoXKiloRolloSeleccionado, this.stockTotalKG);
				    });	
				}
				else
				{
					//saInfo("La Cantidad que desea Ingresar superará la Cantidad total del Rollo(+10%).");
					swal({
				        title: "Confirme",
				        text: "La Cantidad que desea Ingresar superará la Cantidad total del Rollo(+10%).",
				        text: "Se ingresará la información indicada y se harán movimientos en inventario sobre el Número de Rollo y el Rollo en General",
				        type: "warning",
				        showCancelButton: true,
				        confirmButtonColor: "#DD6B55",
				        confirmButtonText: "Si",
				        cancelButtonText: "No",
				        closeOnConfirm: false
				    }, function () {
				    	app.showButtonRegistrarRPPyc = false;

				    	xajax_registrarRPPyc(app.nrNoRollo, app.nrIdRemisionRollo, app.nrIdRegistroProduccion, app.pycPiezas, app.pycML, app.nrPesoEstimadoXKiloRolloSeleccionado, app.pycTotalKG, app.nrSucursalRollo);
//				    	xajax_registrarRPStock(this.idRegistroProduccion, this.stockPiezas, this.stockML, this.pesoEstimadoXKiloRolloSeleccionado, this.stockTotalKG);
				    });	
				}
				
				
								
			}
			else
			{
				saInfo("Ingrese los datos necesarios");
			}
				
		},
		cancelarIngresoRegistro: function(){
			this.pycPiezas = 1;
			this.errPycPiezas = '';				
			this.pycML = 1;
			this.errPycML = '';
			this.showPYC = false;
		},
		mostrarPYC: function(){
			this.showPYC = true;
		},
		
	}	
});