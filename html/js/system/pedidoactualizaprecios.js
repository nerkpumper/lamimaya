// Tipo A para los rangos normales, todo tipo de lámina, pero no se pone en automático este valor
// Tipo B para los Acrylit y Opalit, pero no se pone en automático este valor
// Tipo C para los Multipanel, pero no se pone en automático este valor
// Tipo D las Galvatejas, pero no se pone en automático este valor
// Tipo R las Rollo Kilo, pero no se pone en automático este valor

	// AIzaSyDRxUzlluNFaKpmV_J91pZIBma14x3JQFI
	var app = new Vue({
		el: '#app',
		data: {
			token: '',
			tokenDone: '',
			clicks: 0,
			clicksfecha: 0,

			isAdministrador: false,
			pedidoDesbloqueado: false,
	
			//buscar por codigo
			buscarXCodigo: true,
			indexPadreDeComercializado: -1,
	
	
			//search 
			productosNuevoFiltro: [],
			productosNuevoFiltroComercializados: [],
			productosNuevoFiltroComercializadosAgruped: [],
			productosNuevoFiltroAccesorios: [],
			productosNuevoFiltroMasVendidos: [],
			productosNuevoFiltroFavoritos: [],
			productosDePadreComercializados: [],
			
	
			lstAcanalados: [],
			lstMateriales: [],
			lstCalibres: [],
			lstEspesores: [],
			lstProveedores: [],
	
			expandedAcanalados: true,
			expandedMateriales: true,
			expandedCalibres: true,
			expandedEspesores: true,
			expandedProveedores: true,
			showAbonarAPedido: true,
	
			cookieAcanalados: 'cookiePedidoAcanalados',
			cookieMateriales: 'cookiePedidoMateriales',
			cookieCalibres: 'cookiePedidoCalibres',
			cookieEspesores: 'cookiePedidoEspesores',
			cookieProveedores: 'cookiePedidoProveedores',
	
			expandedAcanaladosComer: true,
			expandedMaterialesComer: true,
			expandedCalibresComer: true,
			expandedMedidaEspecialComer: true,
	
			lstAcanaladosComer: [],
			lstMaterialesComer: [],
			lstCalibresComer: [],
			lstMedidaEspecialComer: [],
			
	
			cookieAcanaladosComer: 'cookiePedidoAcanaladosComer',
			cookieMaterialesComer: 'cookiePedidoMaterialesComer',
			cookieCalibresComer: 'cookiePedidoCalibresComer',
			cookieMedidaEspecialComer: 'cookiePedidoMedidaEspecialComer',
	
			filtroAccesorios: '',
			filtroMasVendidos: '',
			filtroFavoritos: '',
	
			//selectores
			seleccionarLaminaMetalica: false,
			seleccionarComercializados: false,
			seleccionarAccesorios: false,
			seleccionarMasVendidos: false,
			seleccionarFavoritos: false,
	
			//disponible cliente
			verificandoDisponibleParaPagarPedido: false,
			rdDisponible: 0,
			rdTotalPedido: 0,
			rdAbonoMonto: '',
			rdErrAbonoMonto: '',
			rdCliente: '',
	
			//msgs
			msgCotizarFlete: '',
			msgCotizarManiobras: '',
	
			//Recibos de Dinero
			saldoRD: 0,
			haCambiadoPrecioCotizacion: 'NO', 
			saldoRD030: 0,
			saldoRD3160: 0,
			saldoRDmas60: 0,
			id_usuario_autorizaimpresion: 0,
			RDDebeActualizarPrecios: true,
			RDPreciosActualizados: false,
			RDNoSeSurteTodo: false,
	
			//cotizaciones
			idCotizacion: 0,
			listaCotizaciones: [],
			isCotiPedido: false,
			wasPedido: false,
			wasCotizacion: false,
			searchCotizacion: '',
	
			appisCotizacion: false, 
			apppasarAPedidoLaCotizacion: false,
			previoAPasarACotizacion: false,
			utilizarReciboDinero: false,
			
			chkFechaEntregaPorDefinir: false,
			selTipoObra: 'NINGUNO',
			errSelTipoObra: '',
			
			promobuenfin: false,
			buenfintipopago: 0,
			
			curvaIndexListado: -1,
			curvaActual: '',
			porcentajeCurvatura: 5,
			
			// Otros Cargos
			otrosCargos: [
	//			{
	//				id: 1,
	//				descripcion: 'Manejo de Materiales',
	//				monto: ''
	//			},
	//			{
	//				id: 2,
	//				descripcion: 'Renta de Equipo',
	//				monto: ''
	//			}			
			],
			totalOtrosCargos: 0,
			
			// Molduras
			molPrecioCorteBase: 10,
			
			molIndexMoldura: -1,
			molIdProducto: 9,
			molIdMaquila: 10,
			molCantidad: 1,
			molMoldurasXLaminas: 1,
			molMoldurasXLaminaTodos: 1,
			molLaminasCobrar: 1,
			molCantUnidad: 3.05,
			
			molLongitudinal: 'L',		
			molIncluirCorte: true,
			
			molDesarrollo: '0',
			molDesarrolloV2: '0',
			molIdRollo: 0,
			molIdRolloV2: 0,
			
			molCalibreFiltroRollo: 0,
			molMaterialFiltroRollo: 0,
			
			
			molDescripcion: '',	
			molStrTemp: '',
			molDobleces: 1,
			molDoblecesV2: 1,
			molPiesXDesarrollo: 0,
			molPiesXDesarrolloSugerido: 0,
			molPies: 0,
			molIsScrap: false,
			molTotalCMScrap: 0,
			molSobrante4Pies: 0,
			molSobrante3Pies: 0,
			molXLaminas3Pies: 0,
			molXLaminas4Pies: 0,
			molXLaminas3PiesAUsar: 0,
			molXLaminas4PiesAUsar: 0,
			molXLaminas3PiesAUsarCompletas: 0,
			molXLaminas4PiesAUsarCompletas: 0,
			moldurasSueltas3Pies: 0,
			moldurasSueltas4Pies: 0,
			molSobrante3PiesPSPP: 0,
			molSobrante4PiesPSPP: 0,
			
			//376   348
			molXLaminas376Pies: 0,
			molXLaminas348Pies: 0,
	
			moldurasSueltas376Pies: 0,
			moldurasSueltas348Pies: 0,
	
	
			molXLaminas376PiesAUsarCompletas: 0,
			molXLaminas348PiesAUsarCompletas: 0,
	
			molXLaminas376PiesAUsar: 0,
			molXLaminas348PiesAUsar: 0,
	
			molSobrante376Pies: 0,
			molSobrante348Pies: 0,
	
				
			molSobrante376PiesESP: 0,
			molSobrante348PiesESP: 0,
			
			
			
			//fin 376   348
			
			molCalibre: '0',
			molCalibreV2: '0',
			molIdMaterialV2: '0',
			
			molDividirLamina: 0,
			molPrecioRollo: 0,
			molPrecioADar: 0,
			molPrecioCM: 0,
			molPrecioMetroMoldura: 0,
			molIdMaterial: 0,
			molCostoCorte: 10,
			molCostoDobles: 10,
			molCostoCorteMaquila: 11,
			molCostoDoblesMaquila: 11,
			
			molError: '',
			molMsgAgregarMasMolduras: false,
			molTextoBotonAddMoldura: '',
			molTextoBotonCancelAddMoldura: '',
			
			molIsMaquila: false,
			
					
	
			// nos traemos todos los rollos, con sus existencias
			rollosExistencias: [],
			piezasExistencias: [],
	
			mostrarBotonGuardar: true,
	
			//datos pedido
			pedidoFolio: 0,
			
	
			vistaPedido: false,
			seleccionaCliente: true,
			secCotizacionAPedido: false,
			imprimirPedido: false,
			observacionPedido: '',
	
			modalMostrarMsgAgregarMas: false,
	
			selTipoPedido: 'AT',
	
			comisionR1: 2,
			comisionR2: 3,
			comisionR3: 4,
	
			elementos: [],
	
			//auxiliares
			tblProductosFiltradosFootable: false,
	
			id:0 ,
			debugging: false,
			debug: '',
	
			//Pantalla
			isPantallaGrande: false,
			claseTotalAndClienteSegunPantalla: '',
			clasePedidoSegunPantalla: '',
			claseTotalClienteSegunPantalla: '',
			claseRecepcionSegunPantalla: '',
	
			//Rangos Metros y descuento individual
			rango1Inicio: 1,
			rango1Fin: 0,
			rango2Inicio: 0,
			rango2Fin: 0,
			rango3Inicio: 0,
	
			rango1InicioAcryOpa: 1,
			rango1FinAcryOpa: 0,
			rango2InicioAcryOpa: 0,
			rango2FinAcryOpa: 0,
			rango3InicioAcryOpa: 0,
			
			rango1InicioGalvateja: 1,
			rango1FinGalvateja: 0,
			rango2InicioGalvateja: 0,
			rango2FinGalvateja: 0,
			rango3InicioGalvateja: 0,
	
			rango1InicioMultipanel: 1,
			rango1FinMultipanel: 0,
			rango2InicioMultipanel: 0,
			rango2FinMultipanel: 0,
			rango3InicioMultipanel: 0,
			
			rango1InicioRolloKilo: 1,
			rango1FinRolloKilo: 0,
			rango2InicioRolloKilo: 0,
			rango2FinRolloKilo: 0,
			rango3InicioRolloKilo: 0,
	
			maxDescuentoIndividual: 0,
	
	
	
			//para borrar
			indexToDelete: 0,
	
			// comenzamos
			productoAEnlistar: '',
	
			idTipoProducto: 0,
			mostrarTiposProducto: true,
			tiposProducto: [],
			productos: [],
			listadoPedido: [],
			listadoPedidoShort: [],
			listadoPedidoPuedeSurtirse: [],
			//oldListadoPedido: [],
	
			desarrollos: [],
	
			textShowGrid: "Mostrar Grid",
			gridOculta: true,
	
			// Para la busqueda de productos
			searchEncontrado: false,
			searchIndexProductos: 0,
	
			filtroDescripcion: '',
	
			//para la busqueda de clientes
			idClienteSeleccionado: 0,
			idUsuarioPromotor: 0,
			clienteSeleccionado: '-- SIN CLIENTE --',
			promotorClienteSeleccionado: '',
			cteSelDomicilio1: '',
			cteSelDomicilio2: '',
			cteSelNumero: '',
			cteSelColonia: '',
			cteSelCiudad: '',
			cteSelTelefonos: '',
			
			clienteTipoRangoSeleccionado: 'REGULAR',
	
	
	
			seleccionandoCliente: false,
			clientes: [],
			filtroNombreCliente: '',
	
			//Modal
			indexModal: -1,
			indexAEnlistarModal: -1,
			idProductoModal: -1,
			codigoModal: 'Código',
			descripcionModal: 'Descripción',
			unidadModal: '',
			cantidadModal: 1,
			cantUnidadModal: 1,
			tipoPrecioModal: '',
			shortUnidadModal: '',
			desarrolloIModal: '0',
			desarrolloTModal: '0',
			doblecesModal: '0',
			textBotonAddModal: '',
			textBotonCancelModal: '',
			errorModal: '',
	
	
			//totales
			calcularRangosPrecios: true,
	
			maxTipoPrecioGalvamex: 1,
			tipoPrecioGalvamex: 1,
	
			maxTipoPrecioGalvamexAcryOpa: 1,
			tipoPrecioGalvamexAcryOpa: 1,
			
			maxTipoPrecioGalvamexGalvateja: 1,
			tipoPrecioGalvamexGalvateja: 1,
	
			maxTipoPrecioGalvamexMultipanel: 1,
			tipoPrecioGalvamexMultipanel: 1,
			
			maxTipoPrecioGalvamexRolloKilo: 1,
			tipoPrecioGalvamexRolloKilo: 1,
	
			subtotalPedido: 0,
			ivaPedido: 0,
			descuentoPedido: 0,
	//		descuentoPedido: 50,
			porDescuento: 0,
			totalPedido: 0,
	
			totalML: 0,
			totalMLAcryOpa: 0,
			totalMLGalvateja: 0,
			totalMLMultipanel: 0,
			totalMLRolloKilo: 0,
			
	
			selDescuentoIndividual: 10,
	
			//RecogeRecibe
			selRecogeRecibe: 'NOSEL',
			selSucursalPreferencia: '-1',
			chkUsarInformacionCliente: false,
	
			//Datos del cliente
			ctePersona: '',
			errCtePersona: '',
	
			cteDireccion: '',
			errCteDireccion: '',
	
			cteNumero: '',
			errCteNumero: '',
	
			cteColonia: '',
			errCteColonia: '',
	
			cteCiudad: '',
			errCteCiudad: '',
	
			fechaEntrega: '',
			errFechaEntrega: '',
	
			horaEntrega: 'NOSEL',
			
			fechaAbierta: 'NOSEL',
			errFechaAbierta: '' ,
			
			pedidoExpress: 'NO',		
			
			
	
	
	//		Alta Cliente
	
			idCliente: 0,
			nombre: '',
			apellidos: '',
			empresa: '',
			domicilio1: '',
			domicilio2: '',
			domicilioFiscal: '',
			numero: '',
			colonia: '',
			ciudad: '',
			telefonos: '',
			email: '',
			rfc: '',
			estado: 'ACTIVO',
			usuarioPromotor: '0',
			razonSocial: '',
			CP: '',
			usoCFDI: '22',
			mostrarUsuarioPromotor: true,
			
			chkFacturable: false,
					  
			errNombre: '',
			errApellidos: '',
			errEmpresa: '',
			errDomicilio1: '',
			errDomicilio2: '',
			errDomicilioFiscal: '',
			errNumero: '',
			errColonia: '',
			errCiudad: '',
			errTelefonos: '',
			errEmail: '',
			errRfc: '',
			errEstado: '',
			errUsuarioPromotor: '',
			errRazonSocial: '',
			errCP: '',
			errUsoCFDI: '',
			
	//		Fin Alta Cliente
	
			accionModulo: 'Nuevo'
		},
		
		mounted: function () {
			
	//		mdlShowWait();
			
			var d = new Date();
			var n = d.getTime();
			
			this.token = n;
			
			this.molCalibre = '3/16"';
			
			this.setPreciosCortesDobleces();
			
			$("#secImprimirONuevo").hide();
	
			$( "#tablero" ).animate({
				  height: "toggle",
				  opacity: "toggle"
				}, {
				  duration: "fast"
				});
			
			
			setTimeout(function(){ xajax_setPromotor(); }, 500);
	
			//$('.footable').footable();
			//$('#tblProductosFiltrados').footable();
	
	//		setTimeout(function(){
				$('#tblPedidoShort').footable();
	//			}, 1000);
	
			//$('#tblPedidoShort').footable();
	
			//$('#tblProductosFiltrados').html("hola mundo");
	
	
	//		setTimeout(function(){ $('#tblFootable').trigger('footable_redraw'); console.log('footable refresh');}, 5000);
	
	//		this.respaldaListado();
			this.cargarProductos();
			this.cargarRollos();
	
			this.cargarTiposProducto();
			this.cargarOtrosCargos();
			// this.cargarListaCotizaciones();
	
			// this.listaCotizaciones.push ({
			// 	idCotizacion: 2, 
			// 	idCliente: 1, 
			// 	total: 125.33, 
			// 	id_usuario_capturado: 2, 
			// 	fecha_capturado: '2019-08-19 20:14:40', 
			// 	days: 25,
			// 	recogeentrega: 'RECOGE', 
			// 	nombreCliente: 'JUAN URRUTIA'           
			// });
	
			this.clasePedidoSegunPantalla = (this.isPantallaGrande ? "col-lg-8 col-md-8 col-sm-12 col-xs-12" : "col-lg-12 col-md-12 col-sm-12 col-xs-12");
			this.claseTotalAndClienteSegunPantalla = (this.isPantallaGrande ? "col-lg-4 col-md-4 col-sm-12 col-xs-12" : "col-lg-12 col-md-12 col-sm-12 col-xs-12");
			this.claseTotalClienteSegunPantalla = (this.isPantallaGrande ? "col-lg-12 col-md-12 col-sm-12 col-xs-12" : "col-lg-6 col-md-6 col-sm-12 col-xs-12");
			this.claseRecepcionSegunPantalla = (this.isPantallaGrande ? "col-lg-12 col-md-12 col-sm-12 col-xs-12" : "col-lg-8 col-md-8 col-sm-12 col-xs-12");
	
			if (!this.isPantallaGrande)
			{
				//$("#secCliente").appendTo("#secIzquierda");
				$("#secTotalPedido").appendTo("#secDerecha");
			}
	
			xajax_verificaPromotor();
	
			if (_IDUSUARIO == 7 || _IDUSUARIO == 9)
			{
				xajax_cargarClienteMostador(137);
			}
			else
			{
				xajax_cargarClienteMostador(1);			
			}
	
			// setTimeout(function() { app.verificarDisponiblePagoPedido(); }, 100);
	
			toastr.options = {			
				"positionClass": "toast-top-right"			
			  };
	
			setTimeout(function(){  app.readCookie();  }, 750);

			if (typeof param1 !== 'undefined') {
				this.pedidoFolio = param1;				  
				this.LoadPedido(this.pedidoFolio);
	//			setTimeout(function(){app.cargarUltimosMovimientos();}, 1000);
			}
			else
			{
				window.location = URL_BASE + "index";
			}
	
		},
		watch: {
			selRecogeRecibe: function(val){
	
				this.msgFechaRecoge();
				this.checarSiHayMercanciaIsocindu();
			
			},
			rdAbonoMonto: function(value){
	
				this.rdErrAbonoMonto = '';
	
				if (this.rdAbonoMonto == '')
				{
					this.rdErrAbonoMonto = '';
					return;
				}
	
				if (this.rdAbonoMonto == 0)
				{
					this.rdErrAbonoMonto = 'El monto debe ser mayor a cero.';
					return;
				}
				
				if (this.rdAbonoMonto > this.rdDisponible)
				{
					this.rdErrAbonoMonto = 'El monto debe ser menor o igual al Disponible del Cliente.';			
					return;
				}
	
				if (this.rdAbonoMonto > this.rdTotalPedido)
				{
					this.rdErrAbonoMonto = 'El monto debe ser menor o igual al Saldo del Pedido.';
					return;
				}
	
			},
			molCalibreFiltroRollo: function(){
				this.molIdRolloV2 = 0;
			},
			molMaterialFiltroRollo: function(){
				this.molIdRolloV2 = 0;
			},
			buenfintipopago: function(){
				setTimeout(function(){ app.calculaTotales(); }, 100);
			},
			molIsScrap: function(val){
				this.calculaPrecioMoldura2();
			},
			molTotalCMScrap: function(val){
				this.calculaPrecioMoldura2();
			},
			molCantidad: function(val){
				this.calculaPrecioMoldura2();
			},
			molCantUnidad:  function(val){
				// console.log("cambió molCantUnidad");
				this.setPreciosCortesDobleces();
			},
			otrosCargos: {
					handler: function (after, before) {
	//				console.log("a ver");
					var toc = 0;
					var i;
	//				console.log("Parece que algo cambió");
					for (i = 0; i < this.otrosCargos.length ; i++)
					{
						this.otrosCargos[i].monto = this.otrosCargos[i].precioingreso * this.otrosCargos[i].cantidad;
						toc = toc + Number(this.otrosCargos[i].monto);
					}
						
						
	//				this.setValue();
	//				console.log("Total: " + toc);
					this.totalOtrosCargos = toc;
					this.calculaTotales();
					},
			  deep: true,
			},
			molDobleces: function(val){
				this.calculaPrecioMoldura();
			},
			molDoblecesV2: function(val){
	//			alert("recalcular por dobles");
	//			this.reprocesaElRolloV2(this.molIdRollo);
			},
			molCalibreV2: function(val){
				this.molCalibre = val;
				this.setPreciosCortesDobleces();
			},
			molLongitudinal: function(val){
				this.setPreciosCortesDobleces();
			},
			molIncluirCorte: function(val){
				this.setPreciosCortesDobleces();
			},
			molIdMaterialV2: function(val){
				
			},
			molIdRolloV2: function(val){
				
				this.reprocesaElRolloV2(val);
				
	//			var i = 0;
	//			
	//			this.molDividirLamina = 1;
	//			this.molMoldurasXLaminas = 1;
	//			
	//			
	//			
	//			this.molStrTemp = '';
	//			this.molPrecioRollo = 0;
	//			
	//			for(i=0; i < this.rollosExistencias.length ; i++)
	//			{
	//				if (this.rollosExistencias[i].idrollo == val)
	//				{
	//					this.molStrTemp = " -- " + this.rollosExistencias[i].descauto;
	//					this.molPrecioRollo = this.rollosExistencias[i].precio1;
	//					this.molIdMaterial = this.rollosExistencias[i].idmaterial;
	//					this.molDescripcion = this.rollosExistencias[i].descauto;
	//					this.molCalibre = this.rollosExistencias[i].calibre;
	//					this.molPies = this.rollosExistencias[i].pies;
	//					
	//					this.setPreciosCortesDobleces();
	////					if (this.molIdMaterial != 13)
	////					{
	////						this.molDividirLamina = 1;
	////					}
	//					
	//					console.log("Calculando molduras x laminas");
	//					if (this.molPies == 3)
	//					{
	//						this.molMoldurasXLaminas =   Math.trunc( 91.44 / this.molDesarrolloV2);	
	//					}
	//					
	//					if (this.molPies == 4)
	//					{
	//						this.molMoldurasXLaminas =   Math.trunc( 122 / this.molDesarrolloV2);	
	//					}
	//					
	//					this.molMoldurasXLaminaTodos = this.molMoldurasXLaminas ;
	//					
	//					
	//					if (val != 2 &&
	//							val != 9 &&
	//							val != 13 &&
	//							val != 15 &&
	//							val != 25 &&
	//							val != 26 &&
	//							val != 33 &&
	//							val != 35)				
	//					{
	//						this.molDividirLamina = 1;
	//						
	////						console.log(" no se divide precio "+ val);
	//					}
	//					else
	//					{
	////						console.log(" si se divide precio " + val);
	//						this.molMoldurasXLaminas = 1;
	//					}
	//					
	//					
	//					this.molPrecioADar = Math.round(this.molPrecioRollo / this.molDividirLamina * 100) / 100;
	//					break;
	//				}
	//			}
	//			
	//			this.calculaPrecioMoldura2();
			},
			molIdRollo: function(val){
				var i = 0;
				
				this.molDividirLamina = 1;
				this.molMoldurasXLaminas = 1;
				
				if (this.molDesarrollo == "1-15")
				{				
					this.molDividirLamina = 3;
					this.molMoldurasXLaminas = 3;
				}
				else if (this.molDesarrollo == "16-20")
				{				
					this.molDividirLamina = 3;
					this.molMoldurasXLaminas = 3;
				}
				else if (this.molDesarrollo ==	"21-25")
				{				
					this.molDividirLamina = 3;
					this.molMoldurasXLaminas = 3;
				}
				else if (this.molDesarrollo == "26-30")
				{				
					this.molDividirLamina = 3;
					this.molMoldurasXLaminas = 3;
				}
				else if (this.molDesarrollo ==	"31-35")
				{				
					this.molDividirLamina = 3;
					this.molMoldurasXLaminas = 3;
				}
				else if (this.molDesarrollo ==	"36-40")
				{				
					this.molDividirLamina = 3;
					this.molMoldurasXLaminas = 3;
				}
				else if (this.molDesarrollo ==	"41-45")
				{				
					this.molDividirLamina = 2;
					this.molMoldurasXLaminas = 2;
				}
				else if (this.molDesarrollo ==	"46-61")
				{				
					this.molDividirLamina = 2;
					this.molMoldurasXLaminas = 2;
				}
				else if (this.molDesarrollo ==	"62-91")
				{				
					this.molDividirLamina = 1;
					this.molMoldurasXLaminas = 1;
				}
				else if (this.molDesarrollo == "92-1.22")
				{				
					this.molDividirLamina = 1;
					this.molMoldurasXLaminas = 1;
				}
				
				this.molStrTemp = '';
				this.molPrecioRollo = 0;
				
				for(i=0; i < this.rollosExistencias.length ; i++)
				{
					if (this.rollosExistencias[i].idrollo == val)
					{
						this.molStrTemp = " -- " + this.rollosExistencias[i].descauto;
						this.molPrecioRollo = this.rollosExistencias[i].precio1;
						this.molIdMaterial = this.rollosExistencias[i].idmaterial;
						this.molDescripcion = this.rollosExistencias[i].descauto;
						this.molCalibre = this.rollosExistencias[i].calibre;
						
						this.setPreciosCortesDobleces();
	//					if (this.molIdMaterial != 13)
	//					{
	//						this.molDividirLamina = 1;
	//					}
						
						this.molMoldurasXLaminaTodos = this.molMoldurasXLaminas ;
						
						if (val != 2 &&
								val != 9 &&
								val != 13 &&
								val != 15 &&
								val != 25 &&
								val != 26 &&
								val != 33 &&
								val != 35)				
						{
							this.molDividirLamina = 1;
							
	//						console.log(" no se divide precio "+ val);
						}
						else
						{
	//						console.log(" si se divide precio " + val);
							this.molMoldurasXLaminas = 1;
						}
						
						
						this.molPrecioADar = Math.round(this.molPrecioRollo / this.molDividirLamina * 100) / 100;
						break;
					}
				}
				
				this.calculaPrecioMoldura();
				
			},
			molDesarrolloV2: function(val){
				
				if (val >= 1 && val <=15)
				{
					this.molPiesXDesarrolloSugerido = 3;
	//				this.molDividirLamina = 3;
				}
				else if (val >= 16 && val <= 20)
				{
					this.molPiesXDesarrolloSugerido = 3;
	//				this.molDividirLamina = 3;
				}
				else if (val >=	21 && val <= 25)
				{
					this.molPiesXDesarrolloSugerido = 3;
	//				this.molDividirLamina = 3;
				}
				else if (val >= 26 && val <= 30)
				{
					this.molPiesXDesarrolloSugerido = 3;
	//				this.molDividirLamina = 3;
				}
				else if (val >=	31 && val <= 35)
				{
					this.molPiesXDesarrolloSugerido = 4;
	//				this.molDividirLamina = 2;
				}
				else if (val >=	36 && val <= 40)
				{
					this.molPiesXDesarrolloSugerido = 4;
	//				this.molDividirLamina = 3;
				}
				else if (val >=	41 && val <= 45)
				{
					this.molPiesXDesarrolloSugerido = 3;
	//				this.molDividirLamina = 2;
				}
				else if (val >=	46 && val <= 61)
				{
					this.molPiesXDesarrolloSugerido = 4;
	//				this.molDividirLamina = 2;
				}
				else if (val >=	62 && val <= 91)
				{
					this.molPiesXDesarrolloSugerido = 3;
	//				this.molDividirLamina = 1;
				}
				else if (val >= 92 && val <= 122)
				{
					this.molPiesXDesarrolloSugerido = 4;
	//				this.molDividirLamina = 1;
				}
				
				
	//			if (val > 0)
	//			{
	//				console.log("Calculando molduras x laminas");
	//				if (this.molPies == 3)
	//				{
	//					this.molMoldurasXLaminas = Math.trunc( 91.44 / this.molDesarrolloV2 );	
	//				}
	//				
	//				if (this.molPies == 4)
	//				{
	//					
	//					this.molMoldurasXLaminas =  Math.trunc( 122 / this.molDesarrolloV2 );	
	//				}
	//				
	//				this.molMoldurasXLaminaTodos = this.molMoldurasXLaminas;  
	//			}
	//			
				
				this.setPreciosCortesDobleces();
				this.reprocesaElRolloV2(this.molIdRolloV2);
	//			this.calculaPrecioMoldura2();
			},
			molDesarrollo: function(val){
				this.molPiesXDesarrollo = 0;
				this.molDividirLamina = 0;
				
				if (val == "1-15")
				{
					this.molPiesXDesarrollo = 3;
					this.molDividirLamina = 3;
				}
				else if (val == "16-20")
				{
					this.molPiesXDesarrollo = 3;
					this.molDividirLamina = 3;
				}
				else if (val ==	"21-25")
				{
					this.molPiesXDesarrollo = 3;
					this.molDividirLamina = 3;
				}
				else if (val == "26-30")
				{
					this.molPiesXDesarrollo = 3;
					this.molDividirLamina = 3;
				}
				else if (val ==	"31-35")
				{
					this.molPiesXDesarrollo = 4;
					this.molDividirLamina = 2;
				}
				else if (val ==	"36-40")
				{
					this.molPiesXDesarrollo = 4;
					this.molDividirLamina = 3;
				}
				else if (val ==	"41-45")
				{
					this.molPiesXDesarrollo = 3;
					this.molDividirLamina = 2;
				}
				else if (val ==	"46-61")
				{
					this.molPiesXDesarrollo = 4;
					this.molDividirLamina = 2;
				}
				else if (val ==	"62-91")
				{
					this.molPiesXDesarrollo = 3;
					this.molDividirLamina = 1;
				}
				else if (val == "92-1.22")
				{
					this.molPiesXDesarrollo = 4;
					this.molDividirLamina = 1;
				}
				
							
				this.molIdRollo = 0;
	//			console.log(val);
	//			alert("cambio de desarrollo");
				this.calculaPrecioMoldura();
				
			},
			observacionPedido: function(val){
				this.observacionPedido = val.toUpperCase();
			},
			tipoPrecioGalvamex: function(val){
				setTimeout(function(){ app.calculaTotales(); }, 100);
			},
			tipoPrecioGalvamexAcryOpa: function(val){
				setTimeout(function(){ app.calculaTotales(); }, 100);
			},
			tipoPrecioGalvamexMultipanel: function(val){
				setTimeout(function(){ app.calculaTotales(); }, 100);
			},
			tipoPrecioGalvamexGalvateja: function(val){
				setTimeout(function(){ app.calculaTotales(); }, 100);
			},
			tipoPrecioGalvamexRolloKilo: function(val){
				setTimeout(function(){ app.calculaTotales(); }, 100);
			},
			selDescuentoIndividual: function(val){
				setTimeout(function(){ app.calculaTotales(); }, 100);
			},
			idClienteSeleccionado: function(val){
				setTimeout(function(){ app.calculaTotales(); }, 100);
			},
			chkUsarInformacionCliente: function(val){
	
				this.ctePersona = '';
				this.errCtePersona = '';
				this.cteDireccion = '';
				this.errCteDireccion = '';
				this.cteNumero = '';
				this.errCteNumero = '';
				this.cteColonia = '';
				this.errCteColonia = '';
				this.cteCiudad = '';
				this.errCteCiudad = '';
			},
			filtroNombreCliente: function(val){
				this.filtroNombreCliente = val.toUpperCase();
			},
			productoAEnlistar: function(val){
				this.productoAEnlistar = val.toUpperCase();
			},
			filtroDescripcion: function(val){
				this.filtroDescripcion = val.toUpperCase();
				//console.log("a triggear");
				setTimeout(function(){ $('.footable').trigger('footable_redraw')}, 2);
			},
			filtroAccesorios: function(val){
				this.filtroAccesorios = val.toUpperCase();
				//console.log("a triggear");
				setTimeout(function(){ $('.footable').trigger('footable_redraw')}, 2);
			},
			filtroMasVendidos: function(val){
				this.filtroMasVendidos = val.toUpperCase();
				//console.log("a triggear");
				setTimeout(function(){ $('.footable').trigger('footable_redraw')}, 2);
			},
	//		listadoPedido: {
	//			handler: function (after, before) {
	//				var i;
	//
	//				for (i = 0; i < this.listadoPedido.length ; i++)
	//				{
	//					if (this.listadoPedido[i].cantidad != this.oldListadoPedido[i].cantidad ||
	//						this.listadoPedido[i].desarrolloI != this.oldListadoPedido[i].desarrolloI ||
	//						this.listadoPedido[i].desarrolloT != this.oldListadoPedido[i].desarrolloT ||
	//						this.listadoPedido[i].dobleces != this.oldListadoPedido[i].dobleces)
	//					{
	//						console.log("Ha cambiado el objeto de " + i);
	//						this.listadoPedido[i].debug = this.listadoPedido[i].debug + "Ha cambiado el objeto de " + i;
	//
	//					}
	//				}
	//
	//				this.respaldaListado();
	//
	//			},
	//			deep: true,
	//		}
		},
		computed: {
			RDATomar: function(){
				return ( this.RDTotal > this.totalPedido ? this.totalPedido : this.RDTotal);
			},
			RDCubreCotizacion: function (){
				return this.RDTotalAAmparar >= this.totalPedido;
			},
			RDTotal: function(){
				return this.saldoRD030 + this.saldoRD3160 + this.saldoRDmas60;
			},
			RDTotalAAmparar: function(){
				return (this.saldoRD030 * 2) + (this.saldoRD3160 * 1.5) + (this.saldoRDmas60);
			},
			getRangosString: function (){
				
				return this.maxTipoPrecioGalvamex.toString() +
				this.tipoPrecioGalvamex.toString() +
				this.maxTipoPrecioGalvamexAcryOpa.toString() +
				this.tipoPrecioGalvamexAcryOpa.toString() +
				this.maxTipoPrecioGalvamexGalvateja.toString() +
				this.tipoPrecioGalvamexGalvateja.toString() +
				this.maxTipoPrecioGalvamexMultipanel.toString() +
				this.tipoPrecioGalvamexMultipanel.toString() +
				this.maxTipoPrecioGalvamexRolloKilo.toString() +
				this.tipoPrecioGalvamexRolloKilo.toString() ;
			},
			ismolDesarrolloV2Valido: function(){
				return (this.molDesarrolloV2 > 0 && this.molDesarrolloV2 <= 122 );
			},
			rollosExistenciasXDesarrollo:function(){
	
				 var self=this;
				 return this.rollosExistencias.filter(function(cust){
	
					 return cust.pies == app.molPiesXDesarrollo;
	
				 });
			   //return this.customers;
			},
			rollosExistenciasXDesarrollo34:function(){
	
				 var self=this;
				 return this.rollosExistencias.filter(function(cust){
	
					 return cust.pies >= 2 && cust.pies <= 4 && cust.disponible > 0 && cust.idmaterial == self.molMaterialFiltroRollo && cust.calibre == self.molCalibreFiltroRollo;
	
				 });
			   //return this.customers;
			},
			
			mostrarUnidadEnModal: function(){
				return this.shortUnidadModal != 'PZA' && this.shortUnidadModal != 'KG';
			},
			labelUnidadEnModal	: function(){
				var label = '';
	
				if (this.shortUnidadModal == "ML")
				{
					label = "Metros Lineales";
				}
				else if (this.shortUnidadModal == "M2")
					{
	//					label = "Metros Cuadrados";
						label = "Metros Lineales";
					}
				else if (this.shortUnidadModal == "KG")
					{
						label = "Kilogramos";
					}
	
	
				return label;
			},
			noElementosEnPedido: function(){
				return this.listadoPedido.length;
			},
			listaCotizacionesFiltradas:function(){
	
				var self=this;
				// console.log("filtrando cotizaciones");
				return this.listaCotizaciones.filter(function(cust){
	
				 
					var str = cust.idCotizacion + ' ' + cust.nombreCliente;
					// var str = cust.nombreCliente;
					var find = self.searchCotizacion;
	
					str = str.toUpperCase();
					find = find.toUpperCase();
	
					return str.includes(find);
	
	
	
				});
			 
			   },
			productosFiltradosLaminas: function(){
				var self = this;
	
				setTimeout(function(){$('#tblProductosFiltradosLamina').trigger('footable_redraw');},1000);
				return this.productosNuevoFiltro.filter(function(cust){
	
					var select = false;
					var arrAcanalados = self.lstAcanalados.filter(function(a){
									return a.checked;
								})
								.map(function(item) {
												return parseInt(item.id, 10);
											});
					
					var arrMateriales = self.lstMateriales.filter(function(a){
									return a.checked;
								})
								.map(function(item) {
												return parseInt(item.id, 10);
											});
								
					var arrCalibres = self.lstCalibres.filter(function(a){
									return a.checked;
								})
								.map(function(item) {
												return parseInt(item.id, 10);
											});
					
					
					var arrEspesores = self.lstEspesores.filter(function(a){
									return a.checked;
								})
								.map(function(item) {
												return parseFloat(item.id);
											});
	
					var arrProveedores = self.lstProveedores.filter(function(a){
									return a.checked;
								})
								.map(function(item) {
												return parseInt(item.id, 10);
											});
					
					var index = -1;
					
					if ((cust.idTipoProducto == 1 && cust.idRollo > 1) || cust.idTipoProducto == 5){
						
						// console.log("arr:" + arrAcanalados);
						// console.log("cust:" + cust.idAplicacion);
						// if (arrAcanalados.includes(cust.idAplicacion))
							// select = true;
	
						index = arrAcanalados.findIndex(x => x == cust.idAplicacion);										
						if (arrAcanalados.length == 0 || index >= 0) {
							index = -1;
							index = arrMateriales.findIndex(x => x == cust.idMaterial);										
							if (arrMateriales.length == 0 || index >= 0) {
								index = -1;
								index = arrCalibres.findIndex(x => x == cust.rolloCalibre);										
								if (arrCalibres.length == 0 || index >= 0) {
									index = -1;
									index = arrEspesores.findIndex(x => x == cust.rolloPies);										
									if (arrEspesores.length == 0 || index >= 0) {
										index = -1;
										index = arrProveedores.findIndex(x => x == cust.rolloIdProveedor);										
										if (arrProveedores.length == 0 || index >= 0) {
											select = true;
										}	
									}	
								}
							}
						}
						
	
						
					}
					
					return select;
						
	
	
				 });
	
			},
			productosFiltradosComercializados: function(){
				var self = this;
	
				setTimeout(function(){$('#tblProductosFiltradosComercializados').trigger('footable_redraw');},1000);	
				return this.productosNuevoFiltroComercializadosAgruped.filter(function(cust){
	
					var select = false;
					var arrAcanaladosComer = self.lstAcanaladosComer.filter(function(a){
									return a.checked;
								})
								.map(function(item) {
												return parseInt(item.id, 10);
											});
					
					var arrMaterialesComer = self.lstMaterialesComer.filter(function(a){
									return a.checked;
								})
								.map(function(item) {
												return parseInt(item.id, 10);
											});
								
					var arrCalibresComer = self.lstCalibresComer.filter(function(a){
									return a.checked;
								})
								.map(function(item) {
												return parseInt(item.id, 10);
											});
	
					var arrMedidaEspecialComer = self.lstMedidaEspecialComer.filter(function(a){
									return a.checked;
								})
								.map(function(item) {
												return item.id;
											});
					
					// console.log("arrmediaespecial");
					// console.log(arrMedidaEspecialComer);
					var index = -1;
	
					// var arrEspesores = self.lstEspesores.filter(function(a){
					// 				return a.checked;
					// 			})
					// 			.map(function(item) {
					// 							return parseFloat(item.id);
					// 						});
	
					// var arrProveedores = self.lstProveedores.filter(function(a){
					// 				return a.checked;
					// 			})
					// 			.map(function(item) {
					// 							return parseInt(item.id, 10);
					// 						});
					
					
					
	
						index = arrAcanaladosComer.findIndex(x => x == cust.idAplicacion);										
						if (arrAcanaladosComer.length == 0 || index >= 0 ) {
							index = -1;
							index = arrMaterialesComer.findIndex(x => x == cust.idMaterial);										
							if (arrMaterialesComer.length == 0 || index >= 0) {
								index = -1;
								index = arrCalibresComer.findIndex(x => x == cust.rolloCalibre);										
								if (arrCalibresComer.length == 0 || index >= 0) {
									index = -1;
									// console.log(cust.medidaespecial);
									index = arrMedidaEspecialComer.findIndex(x => x == cust.medidaespecial);										
									if (arrMedidaEspecialComer.length == 0 ||index >= 0) {
									// 	index = -1;
									// 	index = arrProveedores.findIndex(x => x == cust.rolloIdProveedor);										
									// 	if (index >= 0) {
											select = true;
										// }	
									}	
								}
							}
						}
						
	
						
					
					
					return select;
						
	
	
				 });
			},
			productosFiltradosAccesorios:function(){
	
				 var self=this;
				 //console.log('vamos a filtrar . . .');
				 //setTimeout(function(){ $('#tblFootable').trigger('footable_redraw'); console.log('footable refresh');}, 100);
				 return this.productosNuevoFiltroAccesorios.filter(function(cust){
	
					if (self.filtroAccesorios == "")
					{
	//	    			return cust.idTipoProducto == self.idTipoProducto && cust.shortUnidad == "PZA";
						return true;
					}
					else
					{
						var str = cust.codigo + ' ' + cust.fullDescripcion;
						var find = self.filtroAccesorios;
	
						str = str.toUpperCase();
	//	    			return cust.idTipoProducto == self.idTipoProducto && str.includes(find) && cust.shortUnidad == "PZA";
						return str.includes(find);
	//	    			return str.includes(find);
					}
	
	
	
				 });
			   //return this.customers;
			},
			productosFiltradosMasVendidos:function(){
	
				 var self=this;
				 //console.log('vamos a filtrar . . .');
				 //setTimeout(function(){ $('#tblFootable').trigger('footable_redraw'); console.log('footable refresh');}, 100);
				 return this.productosNuevoFiltroMasVendidos.filter(function(cust){
	
					if (self.filtroMasVendidos == "")
					{
	//	    			return cust.idTipoProducto == self.idTipoProducto && cust.shortUnidad == "PZA";
						return true;
					}
					else
					{
						var str = cust.codigo + ' ' + cust.fullDescripcion;
						var find = self.filtroMasVendidos;
	
						str = str.toUpperCase();
	//	    			return cust.idTipoProducto == self.idTipoProducto && str.includes(find) && cust.shortUnidad == "PZA";
						return str.includes(find);
	//	    			return str.includes(find);
					}
	
	
	
				 });
			   //return this.customers;
			},
			productosFiltradosFavoritos:function(){
	
				 var self=this;
				 //console.log('vamos a filtrar . . .');
				 //setTimeout(function(){ $('#tblFootable').trigger('footable_redraw'); console.log('footable refresh');}, 100);
				 return this.productosNuevoFiltroFavoritos.filter(function(cust){
	
					if (self.filtroFavoritos == "")
					{
	//	    			return cust.idTipoProducto == self.idTipoProducto && cust.shortUnidad == "PZA";
						return true;
					}
					else
					{
						var str = cust.codigo + ' ' + cust.fullDescripcion;
						var find = self.filtroFavoritos;
	
						str = str.toUpperCase();
	//	    			return cust.idTipoProducto == self.idTipoProducto && str.includes(find) && cust.shortUnidad == "PZA";
						return str.includes(find);
	//	    			return str.includes(find);
					}
	
	
	
				 });
			   //return this.customers;
			},		
			productosFiltradosPorTipo:function(){
	
				 var self=this;
				 //console.log('vamos a filtrar . . .');
				 //setTimeout(function(){ $('#tblFootable').trigger('footable_redraw'); console.log('footable refresh');}, 100);
				 return this.productos.filter(function(cust){
	
					if (self.filtroDescripcion == "")
					{
	//	    			return cust.idTipoProducto == self.idTipoProducto && cust.shortUnidad == "PZA";
						return cust.idTipoProducto == self.idTipoProducto ;
					}
					else
					{
						var str = cust.codigo + ' ' + cust.fullDescripcion;
						var find = self.filtroDescripcion;
	
						str = str.toUpperCase();
	//	    			return cust.idTipoProducto == self.idTipoProducto && str.includes(find) && cust.shortUnidad == "PZA";
						return cust.idTipoProducto == self.idTipoProducto && str.includes(find);
	//	    			return str.includes(find);
					}
	
	
	
				 });
			   //return this.customers;
			},
			clientesFiltradosPorNombre:function(){
	
				 var self=this;
				 return this.clientes.filter(function(cust){
	
					 //return cust.nombre == self.filtroNombreCliente;
					 var str = cust.nombre;
					 var find = self.filtroNombreCliente;
	
	//	    		 if (find.trim() == "")
	//	    		 {
	//	    			 find = "sdjfklsdjfaj";
	//	    		 }
	
					 return str.includes(find);
	
				 });
			   //return this.customers;
			},
			desarrollosImportados: function(){
	
				 return this.desarrollos.filter(function(des){
	
					 return des.tipoPrecio == "I";
	
				 });
			},
			desarrollosTernium: function(){
				return this.desarrollos.filter(function(des){
	
					 return des.tipoPrecio == "T";
	
				 });
			}
		},
		methods:{
			deseoSaldarTodo: function(){
				this.rdAbonoMonto = this.rdTotalPedido;
				this.pagarConReciboDinero();
			},
			pagarConReciboDinero: function(){
			
				if (this.rdAbonoMonto == 0)
				{
					this.rdErrAbonoMonto = 'El monto debe ser mayor a cero.';
					return;
				}
				
				if (this.rdAbonoMonto > this.rdDisponible)
				{
					this.rdErrAbonoMonto = 'El monto debe ser menor o igual al Disponible del Cliente.';			
					return;
				}
	
				if (this.rdAbonoMonto > this.rdTotalPedido)
				{
					this.rdErrAbonoMonto = 'El monto debe ser menor o igual al Saldo del Pedido.';
					return;
				}
	
				swal({
					title: "Atención",
					text: "Se realizará el Abono al Pedido utilizando el Disponible del Cliente por el Monto que ha indicado.",
					type: "warning",
					showCancelButton: true,
					confirmButtonColor: "#DD6B55",
					confirmButtonText: "Continuar",
					cancelButtonText: "Cancelar",
					closeOnConfirm: true
				}, function () {
					
					// alert("vamos");
					mdlShowWait();
					xajax_pagarConReciboDinero(app.pedidoFolio, app.rdAbonoMonto);
	
				});
				
			},
			omitirAbono: function(){
				 this.showAbonarAPedido = false;
			},
			verificarDisponiblePagoPedido: function(){
				mdlShowWait("Por favor espere", "Verificando Disponible del Cliente");
				this.rdDisponible = 0;
				this.rdTotalPedido = 0;
				this.rdAbonoMonto = '';
				this.rdErrAbonoMonto = '';
				this.rdCliente = '';
				this.verificandoDisponibleParaPagarPedido = true;
				xajax_verificarDisponiblePagoPedido(this.pedidoFolio);
				// setTimeout(function() { mdlExitWait(); }, 1000);
			},
			cargarListaCotizaciones: function (){
				xajax_cargarListaCotizaciones();			
			},
			LoadCotizacion: function(idCotizacion){
				mdlShowWait();
				this.vistaPedido = true;
				this.imprimirPedido = false;
				$('#secImprimirONuevo').hide();
				this.seleccionaCliente= false;	
				this.vistaPedido = true;
				this.idCotizacion = idCotizacion;
				xajax_loadCotizacion(idCotizacion);
			},
			LoadPedido: function(idPedido){
				// console.log("cargar pedido: ", idPedido);
				
				mdlShowWait();
				this.vistaPedido = true;
				this.imprimirPedido = false;
				$('#secImprimirONuevo').hide();
				this.seleccionaCliente= false;	
				this.vistaPedido = true;
				this.pedidoFolio = idPedido;
				xajax_loadPedido(idPedido);
			},
			DeleteCotizacion: function(idCotizacion){
				
				swal({
					title: "Atención",
					text: "Se eliminará la Cotización, no podrá recuperarla. ¿Desea continuar?",
					type: "warning",
					showCancelButton: true,
					confirmButtonColor: "#DD6B55",
					confirmButtonText: "Continuar",
					cancelButtonText: "Cancelar",
					closeOnConfirm: true
				}, function () {
									
					// mdlShowWait();				
					xajax_deleteCotizacion(idCotizacion);
				});
				
				
			},			
			reprocesaElRolloV2: function(val){
				var i = 0;
				
				this.molDividirLamina = 1;
				this.molMoldurasXLaminas = 1;
				
				
				
				this.molStrTemp = '';
				this.molPrecioRollo = 0;
				
				for(i=0; i < this.rollosExistencias.length ; i++)
				{
					if (this.rollosExistencias[i].idrollo == val)
					{
						this.molStrTemp = " -- " + this.rollosExistencias[i].descauto;
						this.molPrecioRollo = this.rollosExistencias[i].precio1;
						this.molIdMaterial = this.rollosExistencias[i].idmaterial;
						this.molDescripcion = this.rollosExistencias[i].descauto;
						this.molCalibre = this.rollosExistencias[i].calibre;
						this.molPies = this.rollosExistencias[i].pies;
						
						this.setPreciosCortesDobleces();
	//					if (this.molIdMaterial != 13)
	//					{
	//						this.molDividirLamina = 1;
	//					}
						
	//					console.log("Calculando molduras x laminas");
						if (this.molPies == 2)
						{
							this.molMoldurasXLaminas =   Math.trunc( 60.96 / this.molDesarrolloV2);	
						}
	
						if (this.molPies == 3)
						{
							this.molMoldurasXLaminas =   Math.trunc( 91.44 / this.molDesarrolloV2);	
						}
						
						if (this.molPies == 3.76)
						{
							this.molMoldurasXLaminas =   Math.trunc( 114.6 / this.molDesarrolloV2);	
						}
						
						if (this.molPies == 3.48)
						{
							this.molMoldurasXLaminas =   Math.trunc( 106.07 / this.molDesarrolloV2);	
						}
						
						if (this.molPies == 4)
						{
							this.molMoldurasXLaminas =   Math.trunc( 122 / this.molDesarrolloV2);	
						}
						
						this.molMoldurasXLaminaTodos = this.molMoldurasXLaminas ;
						
						
						if (val != 2 &&
								val != 9 &&
								val != 13 &&
								val != 15 &&
								val != 25 &&
								val != 26 &&
								val != 33 &&
								val != 35)				
						{
							this.molDividirLamina = 1;
							
	//						console.log(" no se divide precio "+ val);
						}
						else
						{
	//						console.log(" si se divide precio " + val);
							this.molMoldurasXLaminas = 1;
						}
						
						var str = "";
						
						if (this.molPies == 2)
						{
							
							this.molPrecioCM =  this.molPrecioRollo / 60.96 ;
	//						this.molPrecioCM = Number(str.toFixed(2));
	//						this.molPrecioCM = Math.round(this.molPrecioCM * 10000) / 10000;
	//						this.molMoldurasXLaminas =   Math.trunc( 91.44 / this.molDesarrolloV2);	
						}
	
	
	
						if (this.molPies == 3)
						{
							
							this.molPrecioCM =  this.molPrecioRollo / 91.44 ;
	//						this.molPrecioCM = Number(str.toFixed(2));
	//						this.molPrecioCM = Math.round(this.molPrecioCM * 10000) / 10000;
	//						this.molMoldurasXLaminas =   Math.trunc( 91.44 / this.molDesarrolloV2);	
						}
						
						if (this.molPies == 3.76)
						{
							
							this.molPrecioCM =  this.molPrecioRollo / 114.6 ;
	//						this.molPrecioCM = Number(str.toFixed(2));
	//						this.molPrecioCM = Math.round(this.molPrecioCM * 10000) / 10000;
	//						this.molMoldurasXLaminas =   Math.trunc( 91.44 / this.molDesarrolloV2);	
						}
						
						if (this.molPies == 3.48)
						{
							
							this.molPrecioCM =  this.molPrecioRollo / 106.07 ;
	//						this.molPrecioCM = Number(str.toFixed(2));
	//						this.molPrecioCM = Math.round(this.molPrecioCM * 10000) / 10000;
	//						this.molMoldurasXLaminas =   Math.trunc( 91.44 / this.molDesarrolloV2);	
						}
						
						if (this.molPies == 4)
						{
							this.molPrecioCM = this.molPrecioRollo / 122;
	//						this.molPrecioCM = Number(str.toFixed(2));
	//						this.molPrecioCM = Math.round(this.molPrecioCM * 10000) / 10000;
							
	//						this.molMoldurasXLaminas =   Math.trunc( 122 / this.molDesarrolloV2);	
						}
						
	//					this.molPrecioADar = Math.round(this.molPrecioRollo / this.molDividirLamina * 100) / 100;
						break;
					}
				}
				
				this.calculaPrecioMoldura2();
			},
			setPreciosCortesDobleces: function(){
	//			console.log("setPreciosCortesDobleces");
				
				var porcentaje = 0;
				var porcentajeMaquila = 0;
				var pesosIncrementar = 0;
				
				if (this.molCalibre == "28" || this.molCalibre == "26" || this.molCalibre == "24")
				{
					porcentaje = 0;
					porcentajeMaquila = 10;
					
				}
				else if(this.molCalibre == "22")
				{
					porcentaje = 10;
					porcentajeMaquila = 20;
					
				}
				else if(this.molCalibre == "20")
				{
					porcentaje = 20;
					porcentajeMaquila = 30;
					pesosIncrementar = 2;
				}
				else if(this.molCalibre == "18")
				{
					porcentaje = 30;
					porcentajeMaquila = 40;
					pesosIncrementar = 2;
				}
				else if(this.molCalibre == "16")
				{
					porcentaje = 40;
					porcentajeMaquila = 50;
					pesosIncrementar = 2;
				}
				else if(this.molCalibre == "14")
				{
					porcentaje = 50;
					porcentajeMaquila = 60;
					pesosIncrementar = 2;
				}
				else if(this.molCalibre == "12")
				{
					porcentaje = 60;
					porcentajeMaquila = 70;
					pesosIncrementar = 2;
				}
				else if(this.molCalibre == "10")
				{
					porcentaje = 70;
					porcentajeMaquila = 80;
					pesosIncrementar = 2;
				}
				else if(this.molCalibre == '1/8"')
				{
					porcentaje = 80;
					porcentajeMaquila = 90;
					pesosIncrementar = 2;
				}
				else if(this.molCalibre == '3/16"')
				{
					porcentaje = 90;
					porcentajeMaquila = 100;
					pesosIncrementar = 2;
				}
				
	//			console.log("Porcentaje + " + porcentaje);
	//			console.log("Porcentaje Maquila + " + porcentajeMaquila);
				
	//			console.log("Base: " + this.molPrecioCorteBase);
				
				this.molCostoCorte = this.molPrecioCorteBase * ( ( 100 + porcentaje) / 100 );
				this.molCostoDobles = this.molPrecioCorteBase * ( ( 100 + porcentaje) / 100 );
				
	//			console.log("Moldura: " + this.molCostoCorte);
				
				this.molCostoCorteMaquila = this.molPrecioCorteBase * ( ( 100 + porcentajeMaquila) / 100 );
				this.molCostoDoblesMaquila = this.molPrecioCorteBase * ( ( 100 + porcentajeMaquila) / 100 );
				
	//			console.log("Maquila: " + this.molCostoCorteMaquila);
				
	//			console.log("+ Pesos: " + pesosIncrementar);
				
				this.molCostoCorte = this.molCostoCorte  + pesosIncrementar;
				this.molCostoDobles = this.molCostoDobles + pesosIncrementar;
				
	//			console.log("Moldura: " + this.molCostoDobles);
				
				this.molCostoCorteMaquila = this.molCostoCorteMaquila  + pesosIncrementar;
				this.molCostoDoblesMaquila = this.molCostoDoblesMaquila + pesosIncrementar;
				
	//			console.log("Maquila: " + this.molCostoDoblesMaquila);
				
	//			console.log(" Calculamos si agregamos costo a Doblés, en base a si es longitudinal o ancho");
				
				if (this.molLongitudinal == "L")
				{
					// console.log("Desarrollo >= 100");
					// if (this.molDesarrolloV2 >= 100)
					// {
					// 	console.log("Sumamos a a costodobles el 50%");
					// 	this.molCostoDobles = this.molCostoDobles + (this.molCostoDobles / 2); 
					// 	this.molCostoDoblesMaquila = this.molCostoDoblesMaquila + (this.molCostoDoblesMaquila / 2); 
					// 	//this.molCostoCorte = this.molCostoCorte + (this.molCostoCorte / 2); 
					// 	//this.molCostoCorteMaquila = this.molCostoCorteMaquila + (this.molCostoCorteMaquila / 2); 
					// }
	
					// console.log("Longitudinal");
					// console.log("molCantUnidad > 3.05 ");
					if (this.molCantUnidad > 3.05)
					{
						// console.log("Sumamos a a costodobles el 100% (" + this.molCantUnidad + ") porque es mayor a 3.05");
						this.molCostoDobles = this.molCostoDobles * 2; 
						this.molCostoDoblesMaquila = this.molCostoDoblesMaquila * 2;
						//this.molCostoCorte = this.molCostoCorte * 2; 
						//this.molCostoCorteMaquila = this.molCostoCorteMaquila * 2; 
						this.molCostoCorte = this.molCostoCorte * 3; 
						this.molCostoCorteMaquila = this.molCostoCorteMaquila * 3; 
					}
					
				}
				else
				{
					// console.log("molCantUnidad > 1 and < 2");
					if (this.molCantUnidad >= 2.0)
					{
						// console.log("Sumamos a a costodobles el 100% (" + this.molCantUnidad + ")");
						this.molCostoDobles = this.molCostoDobles * 2; 
						this.molCostoDoblesMaquila = this.molCostoDoblesMaquila * 2;
						this.molCostoCorte = this.molCostoCorte * 2; 
						this.molCostoCorteMaquila = this.molCostoCorteMaquila * 2; 
					}
					else
					{
						if (this.molCantUnidad >= 1.0)
						{
							// console.log("Sumamos a a costodobles el 50% (" + this.molCantUnidad + ")");
							this.molCostoDobles = this.molCostoDobles + (this.molCostoDobles / 2); 
							this.molCostoDoblesMaquila = this.molCostoDoblesMaquila + (this.molCostoDoblesMaquila / 2);
							this.molCostoCorte = this.molCostoCorte + (this.molCostoCorte / 2); 
							this.molCostoCorteMaquila = this.molCostoCorteMaquila + (this.molCostoCorteMaquila / 2); 
						}
					}
					
				}
	
				
	
				// console.log(" -> molCostoDobles = " + this.molCostoDobles); 
				// console.log(" -> molCostoDoblesMaquila = " + this.molCostoDoblesMaquila);
	
				if (!this.molIncluirCorte)
				{
					this.molCostoCorte = 0; 
					this.molCostoCorteMaquila = 0;
				}	
				
				
			},
			cargarOtrosCargos: function(){
				xajax_cargarOtrosCargos();
			},
			sendPedidoACliente: function(){
				var form_data = new FormData();
				form_data.append('idPedido', this.pedidoFolio);
	
				//axios.get('http://ron-swanson-quotes.herokuapp.com/v2/quotes')
				$.ajax({
					url: 'pedidoclient.send.php', // point to server-side PHP script
					dataType: 'json',  // what to expect back from the PHP script, if anything
					cache: false,
					contentType: false,
					processData: false,
					data: form_data,
					type: 'post',
					success: function(resp){
	
	
						if (!resp.error) {
							saTextoAndTitle("Pedido Enviado","Se ha enviado Pedido a Cliente via EMail");
	//		            	mostrarAviso("Se ha cambiado la foto de perfil.");
	//		            	window.setTimeout(function () { window.location = URL_BASE + "miperfil";}, 1500);
						} else {
							vm.status = resp.msg;
	//		            	mostrarAviso(resp.msg);
						}
					}
				});
			},
			addElement: function(){
				this.id++;
				this.elementos.push({codigo: "code: " + this.id, fullDescripcion: 'Cliente ' + this.id, shortUnidad: '10', dateadd: '01/01/2017', datemod: '02/02/2017', status: 'Pendiente'});
				//$('.footable').footable();
				setTimeout(function(){ $('.footable').trigger('footable_redraw')}, 5);
				setTimeout(function(){ $('#tblProductosFiltrados').trigger('footable_redraw')}, 5);
			},
			//se levanta el pedido
			levantarPedido2Veces: function()
			{
				this.levantarPedido();
				this.levantarPedido();
			},
			showPantallaPasarAPedido: function(){
				// this.secCotizacionAPedido = true;
				// this.vistaPedido = false;
	
				// this.listadoPedidoPuedeSurtirse.push ({renglon: 1, puedeSurtirse: 'SI'});
				// this.listadoPedidoPuedeSurtirse.push ({renglon: 2, puedeSurtirse: 'NO'});
				// this.listadoPedidoPuedeSurtirse.push ({renglon: 3, puedeSurtirse: 'SI'});
				// this.listadoPedidoPuedeSurtirse.push ({renglon: 4, puedeSurtirse: 'NO'});
				// this.listadoPedidoPuedeSurtirse.push ({renglon: 5, puedeSurtirse: 'SI'});
	
				this.saldoRD = 0;
				this.haCambiadoPrecioCotizacion= 'NO'; 
				this.saldoRD030 = 0;
				this.saldoRD3169 = 0;
				this.saldoRDmas60 = 0;
				this.RDDebeActualizarPrecios = true	;
				this.RDPreciosActualizados = false;
				
	
				this.preLevantarPedido(true, false, true);
			},
			indicarSiPuedeONoSurtirseCotizacion: function(){
				var i = 0;
				var j = 0;
	
				$("html, body").animate({ scrollTop: 0 }, "slow");
	
				for (i = 0 ; i < this.listadoPedido.length ; i++)
				{
					for (j = 0 ; j < this.listadoPedidoPuedeSurtirse.length ; j++)
					{
						// console.log("r " + (i+1) + " - " + this.listadoPedidoPuedeSurtirse[j].renglon);
						if ((i+1)  == this.listadoPedidoPuedeSurtirse[j].renglon)
						{
							// console.log("entró");
							this.listadoPedido[i].debug = this.listadoPedidoPuedeSurtirse[j].puedeSurtirse;
							break;
						}
					}
	
				}
			},
			backPantallaPasarAPedido: function(){
				this.secCotizacionAPedido = false;
				this.vistaPedido = true;
			},
			preLevantarPedido: function(isCotizacion, pasarAPedidoLaCotizacion, previoAPasarACotizacion = false, usarRD = false){
	
				var texto = "";
				this.appisCotizacion = isCotizacion;
				this.apppasarAPedidoLaCotizacion = pasarAPedidoLaCotizacion;
				this.previoAPasarACotizacion = previoAPasarACotizacion;
				this.utilizarReciboDinero = usarRD;
	
				if (pasarAPedidoLaCotizacion)
				{
					texto = "Se Pasará la información ingresada a Pedido.";
				}
				else
				{
					if (isCotizacion)
					{
						texto = "Se Actualizará la informacion de la Cotización.";
					}
					else
					{
						texto = "Se Actualizará el Pedido con la información indicada.";
					}
				}
	
				swal({
					title: "Atención",
					text: texto,
					type: "warning",
					showCancelButton: true,
					confirmButtonColor: "#DD6B55",
					confirmButtonText: "Proceder!",
					cancelButtonText: "No",
					closeOnConfirm: true,
					closeOnCancel: false
				}, function (isConfirm) {
					
					// alert("vamos A func levantar pedido");
					// mdlShowWait();
					if (isConfirm){
						setTimeout(app.actualizarPedido(app.appisCotizacion, app.apppasarAPedidoLaCotizacion, app.previoAPasarACotizacion, app.utilizarReciboDinero), 100);
					}
					else
					{
						// alert("cancelamos");
						console.log("Cancelamos");
						this.LoadPedido(this.pedidoFolio);
					}
	
				});
			}, 
			preActualizarPedido: function(isCotizacion, pasarAPedidoLaCotizacion, previoAPasarACotizacion = false, usarRD = false){
	
				var texto = "";
				this.appisCotizacion = isCotizacion;
				this.apppasarAPedidoLaCotizacion = pasarAPedidoLaCotizacion;
				this.previoAPasarACotizacion = previoAPasarACotizacion;
				this.utilizarReciboDinero = usarRD;
	
				if (pasarAPedidoLaCotizacion)
				{
					texto = "Se Pasará la información ingresada a Pedido.";
				}
				else
				{
					if (isCotizacion)
					{
						texto = "Se Actualizará la informacion de la Cotización.";
					}
					else
					{
						texto = "Se Actualizará el Pedido con la información indicada.";
					}
				}
	
				swal({
					title: "Atención",
					text: texto,
					type: "warning",
					showCancelButton: true,
					confirmButtonColor: "#DD6B55",
					confirmButtonText: "Proceder!",
					cancelButtonText: "No",
					closeOnConfirm: false,
					closeOnCancel: false
				}, function (isConfirm) {
					
					// alert("vamos A func levantar pedido");
					// mdlShowWait();
					if (isConfirm)
					{
						swal.close();
						setTimeout(app.actualizarPedido(app.appisCotizacion, app.apppasarAPedidoLaCotizacion, app.previoAPasarACotizacion, app.utilizarReciboDinero), 100);
					}
					else
					{
						// alert("cancelamos");
						swal.close();
						// console.log("Cancelamos ", URL_BASE + 'pedidoactualizaprecios/' + app.pedidoFolio);
						window.location = URL_BASE + 'pedidoactualizaprecios/' + app.pedidoFolio;
						// this.LoadPedido(this.pedidoFolio);
					}
	
				});
			}, 

			msgFechaRecoge: function(){
				if (this.selRecogeRecibe == "RECOGE" && this.clicksfecha < 2)
				{
					mdlExitWait();
					// saInfo("Asegúrese de poner fecha y hora de entrega real en las observaciónes.");
					this.clicksfecha=this.clicksfecha+ 1;
					return;
				}

			},
			levantarPedido: function(isCotizacion, pasarAPedidoLaCotizacion, previoAPasarACotizacion, utilizarReciboDinero){
				
				
	
				
				
				// if (this.clicks > 1)
				// {
				// 	console.log("Se ha evitado doble inserción de Pedido");
				// 	return;
				// }
				// alert("Iscotizacion =  " + isCotizacion); return;
				
				mdlShowWait();
				// console.log("Levantando Pedido");
				if (this.totalPedido <= 0)
				{
					mdlExitWait();
					saInfo ("No se puede levantar el Pedido, el Total debe ser mayor a Cero Pesos.");
					return false;
				}
	
	//			this.mostrarBotonGuardar = false;
				var seguir = true;
				var fechaEngrega = $("#dtFechaEntrega").val();
	//			var strHoraEntrega = "";
				var today = new Date();
				var dd = today.getDate();
				var mm = today.getMonth()+1; //January is 0!
				var yyyy = today.getFullYear();
				var horaactual = today.getHours();
				horaactual = 12
	
	//			alert(fechaEngrega);
	//			console.log(fechaEngrega);
	//			console.log(today.getHours());
				if(dd<10) {
					dd = '0'+dd
				}
	
				if(mm<10) {
					mm = '0'+mm
				}
	
				var strFESave = "";
				var strFechaEntrega = fechaEngrega.substring(6, 10) + '-' + fechaEngrega.substring(3, 5) + '-' + fechaEngrega.substring(0, 2);
				var strFE = fechaEngrega.substring(6, 10) + '' + fechaEngrega.substring(3, 5) + '' + fechaEngrega.substring(0, 2);
				var strToday = yyyy + '' + mm + '' + dd;
	
				this.errCtePersona = "";
				this.errCteDireccion = "";
				this.errCteNumero = "";
				this.errCteColonia = "";
				this.errCteCiudad = "";
				this.errFechaEntrega = "";
				this.errFechaAbierta = "";
	
	//			if (this.listadoPedido.length <= 0)
	//			{
	//				saInfo("No se han capturado productos al Pedido.");
	//				this.mostrarBotonGuardar = true;
	//				return;
	//			}
	
				if (this.idClienteSeleccionado == 0)
				{
					mdlExitWait();
					saInfo("No ha seleccionado un Cliente.");
					this.mostrarBotonGuardar = true;
					return;
				}
	
				if (this.selRecogeRecibe == "NOSEL")
				{
					mdlExitWait();
					saInfo("No ha indicado si el Pedido se lo lleva el Cliente, se le Envía, o se lleva a cabo en Obra.");
					this.mostrarBotonGuardar = true;
					return;
				}
				
	
				if (this.selTipoPedido == "0")
				{
					mdlExitWait();
					saInfo("Debe indicar el tipo de Producto");
					this.mostrarBotonGuardar = true;
					return;
				}
	
				if (this.promobuenfin && this.buenfintipopago == "0")
				{
					mdlExitWait();
					saInfo("Debe indicar el Tipo de Pago");
					this.mostrarBotonGuardar = true;
					return;
				}
				
				if (this.selRecogeRecibe == 'RECOGE')
				{
					
					if (this.selSucursalPreferencia == -1 ) 
					{
						mdlExitWait();
						saInfo("Debe indicar la Sucursal de Preferencia");
						this.mostrarBotonGuardar = true;
						return;
					}	
				}
				else
				{
					this.selSucursalPreferenciaa = 0;
				}
				
				if (this.selRecogeRecibe == 'OBRA')
				{
					if (this.selTipoObra == 'NINGUNO' ) 
					{
						mdlExitWait();
						saInfo("Debe indicar el tipo de Obra");
						this.mostrarBotonGuardar = true;
						return;
					}	
				}
				
				
	
				var strNombre = this.clienteSeleccionado;
				var strDireccion = this.cteSelDomicilio1 + ' ' + this.cteSelDomicilio2;
				var strNumero = this.cteSelNumero;
				var strColonia = this.cteSelColonia;
				var strCiudad = this.cteSelCiudad;
				strFESave = "";
	//			strHoraEntrega = "";
	
				if (this.selRecogeRecibe == "ENTREGA" || this.selRecogeRecibe == "OBRA" )
				{
					if (!this.chkUsarInformacionCliente)
					{
						if (this.ctePersona == "")
						{
							this.errCtePersona = "Debe ingresar Persona Contacto.";
							seguir = false;
						}
	
						if (this.cteDireccion == "")
						{
							this.errCteDireccion = "Debe ingresar Dirección.";
							seguir = false;
						}
	
						if (this.cteNumero == "")
						{
							this.errCteNumero = "Debe ingresar Número.";
							seguir = false;
						}
	
						if (this.cteColonia == "")
						{
							this.errCteColonia = "Debe ingresar Colonia.";
							seguir = false;
						}
	
						if (this.cteCiudad == "")
						{
							this.errCteCiudad = "Debe ingresar Ciudad.";
							seguir = false;
						}
	
						strNombre = this.ctePersona;
						strDireccion = this.cteDireccion;
						strNumero = this.cteNumero;
						strColonia = this.cteColonia;
						strCiudad = this.cteCiudad;
					}
	
					
	// 				if (!this.chkFechaEntregaPorDefinir)
	// 				{
	// 					if (horaactual < 12)
	// 					{
	// 						if (parseInt(strToday) > parseInt(strFE))
	// 						{
	// 							this.errFechaEntrega = "La Fecha de Entrega debe ser posterior o igual al día de hoy.";
	
	// //							saInfo("La Fecha de Entrega debe ser posterior al día de hoy.");
	// 							seguir = false;
	// 						}	
	// 					}
	// 					else
	// 					{
	// 						if (parseInt(strToday) >= parseInt(strFE))
	// 						{
	// 							this.errFechaEntrega = "La Fecha de Entrega debe ser posterior al día de hoy.";
	
	// //							saInfo("La Fecha de Entrega debe ser posterior al día de hoy.");
	// 							seguir = false;
	// 						}	
	// 					}	
	// 				}
					
					
					
					if (this.fechaAbierta == "NOSEL")
					{
						this.errFechaAbierta = "Debe indicar si la Fecha es Abierta.";
	
	//					saInfo("La Fecha de Entrega debe ser posterior al día de hoy.");
						seguir = false;
						
					}
	
					strFESave = strFechaEntrega;
	//				strHoraEntrega = $("#txtHoraEntrega").val();
				}
				
	// 			if (this.selRecogeRecibe == "RECOGE")
	// 			{
	// 				//if (horaactual < 12)
	// 				//{
	// 				if (!this.chkFechaEntregaPorDefinir)
	// 				{
	// 					if (parseInt(strToday) > parseInt(strFE))
	// 					{
	// 						this.errFechaEntrega = "La Fecha de Entrega debe ser posterior o igual al día de hoy.";
	
	// //						saInfo("La Fecha de Entrega debe ser posterior al día de hoy.");
	// 						seguir = false;
	// 					}
	// 				}
	// 				//}
	// 				//else
	// 				//{
	// 				//	if (parseInt(strToday) >= parseInt(strFE))
	// 			//		{
	// 			//			this.errFechaEntrega = "La Fecha de Entrega debe ser posterior al día de hoy.";
	
	// //						saInfo("La Fecha de Entrega debe ser posterior al día de hoy.");
	// 			//			seguir = false;
	// 		//			}	
	// 			//	}	
					
	// 				strFESave = strFechaEntrega;
	// 			}
				
				// console.log("antes de seguir var");
				if (seguir)
				{
					this.clicks++;
	
					// console.log("seguir = true, seguimos");
	//				if (this.tokenDone != this.token)
	//				{
					
					this.listadoPedidoShort.splice(0, this.listadoPedidoShort.length);
					var auxDesc = "";
					
					for (var indexListado = 0 ; indexListado < this.listadoPedido.length ; indexListado ++)
					{
						
						if (this.listadoPedido[indexListado].idProducto == 10)
						{
							auxDesc = this.listadoPedido[indexListado].fullDescripcion;
						}
						else					
						{
							auxDesc = this.listadoPedido[indexListado].codigo;
						}
						
						
						this.listadoPedidoShort.push({
							shortUnidad: this.listadoPedido[indexListado].shortUnidad,
							idProducto: this.listadoPedido[indexListado].idProducto,
							fullDescripcion:  auxDesc,						
							idProducto: this.listadoPedido[indexListado].idProducto,
							cantidad: this.listadoPedido[indexListado].cantidad,
							cantUnidad: this.listadoPedido[indexListado].cantUnidad,
							cantUnidadReal: this.listadoPedido[indexListado].cantUnidadReal,
							tipoPrecioComision: this.listadoPedido[indexListado].tipoPrecioComision,
							rolloPesokiloml: this.listadoPedido[indexListado].rolloPesokiloml,
							molIsScrap: this.listadoPedido[indexListado].molIsScrap,
							molTotalCMScrap: this.listadoPedido[indexListado].molTotalCMScrap,
							molLongitudinal: this.listadoPedido[indexListado].molLongitudinal,
							molLaminasATomar: this.listadoPedido[indexListado].molLaminasATomar,
							dobleces: this.listadoPedido[indexListado].dobleces,
							desarrolloT: this.listadoPedido[indexListado].desarrolloT,
							molDobles: this.listadoPedido[indexListado].molDobles,
							molCorte: this.listadoPedido[indexListado].molCorte,
							kl: this.listadoPedido[indexListado].kl,
							curva: this.listadoPedido[indexListado].curva,
							idRollo: this.listadoPedido[indexListado].idRollo,
							rangoRenglon: this.listadoPedido[indexListado].rangoRenglon,
							tipoPrecio: this.listadoPedido[indexListado].tipoPrecio,
							precioRenglon: this.listadoPedido[indexListado].precioRenglon,
							totalRenglon: this.listadoPedido[indexListado].totalRenglon,
							rolloCalibre: this.listadoPedido[indexListado].rolloCalibre,
							rolloIdMaterial: this.listadoPedido[indexListado].rolloIdMaterial				 ,
							precio1: this.listadoPedido[indexListado].precio1,
							precio2: this.listadoPedido[indexListado].precio2,
							precio3: this.listadoPedido[indexListado].precio3,
							preciomendez: this.listadoPedido[indexListado].preciomendez
							
						});
					}
					
					
					
					
						this.tokenDone = this.token;
	//					console.log("antes de ir a guardar");
	//					xajax_levantarPedidoV2(this.idClienteSeleccionado, 
	//							               this.subtotalPedido, 
	//							               this.ivaPedido, 
	//							               this.descuentoPedido, 
	//							               this.totalPedido, 
	//							               this.tipoPrecioGalvamex, 
	//							               this.listadoPedido	
	//							               ,
											   
	//							               this.selRecogeRecibe, 
	//							               strNombre, 
	//							               strDireccion, 
	//							               strNumero, 
	//							               strColonia, 
	//							               strCiudad, 
	//							               strFESave, 
	//							               strHoraEntrega, 
	//							               this.selTipoPedido, 
	//							               this.porDescuento, 
	//							               this.maxDescuentoIndividual, 
	//							               this.selDescuentoIndividual, 
	//							               this.observacionPedido, 
	//							               this.totalOtrosCargos, 
	//							               this.otrosCargos
	//							               );
	//					xajax_levantarPedidoV2();
						
						
						
	//					console.log("la que estaba antes");
	//					xajax_levantarPedido(this.idClienteSeleccionado, this.subtotalPedido, this.ivaPedido, this.descuentoPedido, this.totalPedido, this.tipoPrecioGalvamex, this.listadoPedido, this.selRecogeRecibe, strNombre, strDireccion, strNumero, strColonia, strCiudad, strFESave, strHoraEntrega, this.selTipoPedido, this.porDescuento, this.maxDescuentoIndividual, this.selDescuentoIndividual, this.observacionPedido, this.totalOtrosCargos, this.otrosCargos, this.molCostoDobles, this.molCostoCorte);
						
	//					console.log(" Vamos A levantar el Pedido");
	//					xajax_lp(this.idClienteSeleccionado, this.subtotalPedido, this.ivaPedido, this.descuentoPedido, this.totalPedido, this.tipoPrecioGalvamex, this.listadoPedidoShort	, this.selRecogeRecibe, strNombre, strDireccion, strNumero, strColonia, strCiudad, strFESave, this.horaEntrega, this.fechaAbierta, this.pedidoExpress, this.selTipoPedido, this.porDescuento, this.maxDescuentoIndividual, this.selDescuentoIndividual, this.observacionPedido, this.totalOtrosCargos, this.otrosCargos, this.molCostoDobles, this.molCostoCorte, this.buenfintipopago);
						//console.log("antes de levantar pedido");
					
						
						
						
	
						xajax_levantarPedido(this.idClienteSeleccionado, 
											this.subtotalPedido, 
											this.ivaPedido, 
											this.descuentoPedido, 
											this.totalPedido, 
											this.tipoPrecioGalvamex, 
											this.listadoPedidoShort, 
											this.selRecogeRecibe, 
											this.selSucursalPreferencia, 
											strNombre, 
											strDireccion, 
											strNumero, 
											strColonia, 
											strCiudad, 
											strFESave, 
											this.horaEntrega, 
											this.fechaAbierta, 
											this.pedidoExpress, 
											this.selTipoPedido, 
											this.porDescuento, 
											this.maxDescuentoIndividual, 
											this.selDescuentoIndividual, 
											this.observacionPedido, 
											this.totalOtrosCargos, 
											this.otrosCargos, 
											this.molCostoDobles, 
											this.molCostoCorte, 
											this.buenfintipopago, 
											this.chkFechaEntregaPorDefinir, 
											this.selTipoObra, 
											isCotizacion,
											this.idCotizacion,
											this.getRangosString,
											pasarAPedidoLaCotizacion,
											previoAPasarACotizacion,
											utilizarReciboDinero,
											this.RDCubreCotizacion,
											this.RDATomar);
	//				}
	//				else
	//				{
	//					setTimeout(function(){alert("Parece que ha pulsado 2 veces el botón de Levantar Pedido, se ha omitido el segundo click para prevenir duplicar Pedidos.");}, 150); 
	//				}
					
				}
				else
				{
					mdlExitWait();
					this.mostrarBotonGuardar = true;
					return false;
				}
	
	
	
			},

			actualizarPedido: function(isCotizacion, pasarAPedidoLaCotizacion, previoAPasarACotizacion, utilizarReciboDinero){
				
				
	
				
				
				// if (this.clicks > 1)
				// {
				// 	console.log("Se ha evitado doble inserción de Pedido");
				// 	return;
				// }
				// alert("Iscotizacion =  " + isCotizacion); return;
				
				// mdlShowWait();
				// console.log("Actualizando Pedido");
				if (this.totalPedido <= 0)
				{
					mdlExitWait();
					saInfo ("No se puede actualizar el Pedido, el Total debe ser mayor a Cero Pesos.");
					return false;
				}
	
	//			this.mostrarBotonGuardar = false;
				var seguir = true;
				// var fechaEngrega = $("#dtFechaEntrega").val();
	//			var strHoraEntrega = "";
				var today = new Date();
				var dd = today.getDate();
				var mm = today.getMonth()+1; //January is 0!
				var yyyy = today.getFullYear();
				var horaactual = today.getHours();
				horaactual = 12
	
	//			alert(fechaEngrega);
				// console.log(fechaEngrega);
	//			console.log(today.getHours());
				if(dd<10) {
					dd = '0'+dd
				}
	
				if(mm<10) {
					mm = '0'+mm
				}
	
				// var strFESave = "";
				// var strFechaEntrega = fechaEngrega.substring(6, 10) + '-' + fechaEngrega.substring(3, 5) + '-' + fechaEngrega.substring(0, 2);
				// var strFE = fechaEngrega.substring(6, 10) + '' + fechaEngrega.substring(3, 5) + '' + fechaEngrega.substring(0, 2);
				// var strToday = yyyy + '' + mm + '' + dd;
	
				this.errCtePersona = "";
				this.errCteDireccion = "";
				this.errCteNumero = "";
				this.errCteColonia = "";
				this.errCteCiudad = "";
				this.errFechaEntrega = "";
				this.errFechaAbierta = "";

				console.log("Fecha save done");
	
	//			if (this.listadoPedido.length <= 0)
	//			{
	//				saInfo("No se han capturado productos al Pedido.");
	//				this.mostrarBotonGuardar = true;
	//				return;
	//			}
	
				// if (this.idClienteSeleccionado == 0)
				// {
				// 	mdlExitWait();
				// 	saInfo("No ha seleccionado un Cliente.");
				// 	this.mostrarBotonGuardar = true;
				// 	return;
				// }
	
				// if (this.selRecogeRecibe == "NOSEL")
				// {
				// 	mdlExitWait();
				// 	saInfo("No ha indicado si el Pedido se lo lleva el Cliente, se le Envía, o se lleva a cabo en Obra.");
				// 	this.mostrarBotonGuardar = true;
				// 	return;
				// }
				
	
				// if (this.selTipoPedido == "0")
				// {
				// 	mdlExitWait();
				// 	saInfo("Debe indicar el tipo de Producto");
				// 	this.mostrarBotonGuardar = true;
				// 	return;
				// }
	
				// if (this.promobuenfin && this.buenfintipopago == "0")
				// {
				// 	mdlExitWait();
				// 	saInfo("Debe indicar el Tipo de Pago");
				// 	this.mostrarBotonGuardar = true;
				// 	return;
				// }
				
				// if (this.selRecogeRecibe == 'RECOGE')
				// {
					
				// 	if (this.selSucursalPreferencia == -1 ) 
				// 	{
				// 		mdlExitWait();
				// 		saInfo("Debe indicar la Sucursal de Preferencia");
				// 		this.mostrarBotonGuardar = true;
				// 		return;
				// 	}	
				// }
				// else
				// {
				// 	this.selSucursalPreferenciaa = 0;
				// }
				
				// if (this.selRecogeRecibe == 'OBRA')
				// {
				// 	if (this.selTipoObra == 'NINGUNO' ) 
				// 	{
				// 		mdlExitWait();
				// 		saInfo("Debe indicar el tipo de Obra");
				// 		this.mostrarBotonGuardar = true;
				// 		return;
				// 	}	
				// }
				
				
	
				var strNombre = this.clienteSeleccionado;
				var strDireccion = this.cteSelDomicilio1 + ' ' + this.cteSelDomicilio2;
				var strNumero = this.cteSelNumero;
				var strColonia = this.cteSelColonia;
				var strCiudad = this.cteSelCiudad;
				strFESave = "";
	//			strHoraEntrega = "";
	
				// if (this.selRecogeRecibe == "ENTREGA" || this.selRecogeRecibe == "OBRA" )
				// {
				// 	if (!this.chkUsarInformacionCliente)
				// 	{
				// 		if (this.ctePersona == "")
				// 		{
				// 			this.errCtePersona = "Debe ingresar Persona Contacto.";
				// 			seguir = false;
				// 		}
	
				// 		if (this.cteDireccion == "")
				// 		{
				// 			this.errCteDireccion = "Debe ingresar Dirección.";
				// 			seguir = false;
				// 		}
	
				// 		if (this.cteNumero == "")
				// 		{
				// 			this.errCteNumero = "Debe ingresar Número.";
				// 			seguir = false;
				// 		}
	
				// 		if (this.cteColonia == "")
				// 		{
				// 			this.errCteColonia = "Debe ingresar Colonia.";
				// 			seguir = false;
				// 		}
	
				// 		if (this.cteCiudad == "")
				// 		{
				// 			this.errCteCiudad = "Debe ingresar Ciudad.";
				// 			seguir = false;
				// 		}
	
				// 		strNombre = this.ctePersona;
				// 		strDireccion = this.cteDireccion;
				// 		strNumero = this.cteNumero;
				// 		strColonia = this.cteColonia;
				// 		strCiudad = this.cteCiudad;
				// 	}
	
					
	// 				if (!this.chkFechaEntregaPorDefinir)
	// 				{
	// 					if (horaactual < 12)
	// 					{
	// 						if (parseInt(strToday) > parseInt(strFE))
	// 						{
	// 							this.errFechaEntrega = "La Fecha de Entrega debe ser posterior o igual al día de hoy.";
	
	// //							saInfo("La Fecha de Entrega debe ser posterior al día de hoy.");
	// 							seguir = false;
	// 						}	
	// 					}
	// 					else
	// 					{
	// 						if (parseInt(strToday) >= parseInt(strFE))
	// 						{
	// 							this.errFechaEntrega = "La Fecha de Entrega debe ser posterior al día de hoy.";
	
	// //							saInfo("La Fecha de Entrega debe ser posterior al día de hoy.");
	// 							seguir = false;
	// 						}	
	// 					}	
	// 				}
					
					
					
	// 				if (this.fechaAbierta == "NOSEL")
	// 				{
	// 					this.errFechaAbierta = "Debe indicar si la Fecha es Abierta.";
	
	// //					saInfo("La Fecha de Entrega debe ser posterior al día de hoy.");
	// 					seguir = false;
						
	// 				}
	
					// strFESave = strFechaEntrega;
	//				strHoraEntrega = $("#txtHoraEntrega").val();
				// }
				
	// 			if (this.selRecogeRecibe == "RECOGE")
	// 			{
	// 				//if (horaactual < 12)
	// 				//{
	// 				if (!this.chkFechaEntregaPorDefinir)
	// 				{
	// 					if (parseInt(strToday) > parseInt(strFE))
	// 					{
	// 						this.errFechaEntrega = "La Fecha de Entrega debe ser posterior o igual al día de hoy.";
	
	// //						saInfo("La Fecha de Entrega debe ser posterior al día de hoy.");
	// 						seguir = false;
	// 					}
	// 				}
	// 				//}
	// 				//else
	// 				//{
	// 				//	if (parseInt(strToday) >= parseInt(strFE))
	// 			//		{
	// 			//			this.errFechaEntrega = "La Fecha de Entrega debe ser posterior al día de hoy.";
	
	// //						saInfo("La Fecha de Entrega debe ser posterior al día de hoy.");
	// 			//			seguir = false;
	// 		//			}	
	// 			//	}	
					
	// 				strFESave = strFechaEntrega;
	// 			}
				
				console.log("antes de seguir var");
				if (seguir)
				{
					this.clicks++;
	
					console.log("seguir = true, seguimos");
	//				if (this.tokenDone != this.token)
	//				{
					
					this.listadoPedidoShort.splice(0, this.listadoPedidoShort.length);
					var auxDesc = "";
					
					for (var indexListado = 0 ; indexListado < this.listadoPedido.length ; indexListado ++)
					{
						
						if (this.listadoPedido[indexListado].idProducto == 10)
						{
							auxDesc = this.listadoPedido[indexListado].fullDescripcion;
						}
						else					
						{
							auxDesc = this.listadoPedido[indexListado].codigo;
						}
						
						
						this.listadoPedidoShort.push({
							shortUnidad: this.listadoPedido[indexListado].shortUnidad,
							idProducto: this.listadoPedido[indexListado].idProducto,
							fullDescripcion:  auxDesc,						
							idProducto: this.listadoPedido[indexListado].idProducto,
							cantidad: this.listadoPedido[indexListado].cantidad,
							cantUnidad: this.listadoPedido[indexListado].cantUnidad,
							cantUnidadReal: this.listadoPedido[indexListado].cantUnidadReal,
							tipoPrecioComision: this.listadoPedido[indexListado].tipoPrecioComision,
							rolloPesokiloml: this.listadoPedido[indexListado].rolloPesokiloml,
							molIsScrap: this.listadoPedido[indexListado].molIsScrap,
							molTotalCMScrap: this.listadoPedido[indexListado].molTotalCMScrap,
							molLongitudinal: this.listadoPedido[indexListado].molLongitudinal,
							molLaminasATomar: this.listadoPedido[indexListado].molLaminasATomar,
							dobleces: this.listadoPedido[indexListado].dobleces,
							desarrolloT: this.listadoPedido[indexListado].desarrolloT,
							molDobles: this.listadoPedido[indexListado].molDobles,
							molCorte: this.listadoPedido[indexListado].molCorte,
							kl: this.listadoPedido[indexListado].kl,
							curva: this.listadoPedido[indexListado].curva,
							idRollo: this.listadoPedido[indexListado].idRollo,
							rangoRenglon: this.listadoPedido[indexListado].rangoRenglon,
							tipoPrecio: this.listadoPedido[indexListado].tipoPrecio,
							precioRenglon: this.listadoPedido[indexListado].precioRenglon,
							totalRenglon: this.listadoPedido[indexListado].totalRenglon,
							rolloCalibre: this.listadoPedido[indexListado].rolloCalibre,
							rolloIdMaterial: this.listadoPedido[indexListado].rolloIdMaterial				 ,
							precio1: this.listadoPedido[indexListado].precio1,
							precio2: this.listadoPedido[indexListado].precio2,
							precio3: this.listadoPedido[indexListado].precio3,
							preciomendez: this.listadoPedido[indexListado].preciomendez,
							idPedidoDetalle: this.listadoPedido[indexListado].idPedidoDetalle
							
						});
					}
					
					
					
					
						this.tokenDone = this.token;
						console.log("antes de ir a actualizar");
	//					xajax_levantarPedidoV2(this.idClienteSeleccionado, 
	//							               this.subtotalPedido, 
	//							               this.ivaPedido, 
	//							               this.descuentoPedido, 
	//							               this.totalPedido, 
	//							               this.tipoPrecioGalvamex, 
	//							               this.listadoPedido	
	//							               ,
											   
	//							               this.selRecogeRecibe, 
	//							               strNombre, 
	//							               strDireccion, 
	//							               strNumero, 
	//							               strColonia, 
	//							               strCiudad, 
	//							               strFESave, 
	//							               strHoraEntrega, 
	//							               this.selTipoPedido, 
	//							               this.porDescuento, 
	//							               this.maxDescuentoIndividual, 
	//							               this.selDescuentoIndividual, 
	//							               this.observacionPedido, 
	//							               this.totalOtrosCargos, 
	//							               this.otrosCargos
	//							               );
	//					xajax_levantarPedidoV2();
						
						
						
	//					console.log("la que estaba antes");
	//					xajax_levantarPedido(this.idClienteSeleccionado, this.subtotalPedido, this.ivaPedido, this.descuentoPedido, this.totalPedido, this.tipoPrecioGalvamex, this.listadoPedido, this.selRecogeRecibe, strNombre, strDireccion, strNumero, strColonia, strCiudad, strFESave, strHoraEntrega, this.selTipoPedido, this.porDescuento, this.maxDescuentoIndividual, this.selDescuentoIndividual, this.observacionPedido, this.totalOtrosCargos, this.otrosCargos, this.molCostoDobles, this.molCostoCorte);
						
	//					console.log(" Vamos A levantar el Pedido");
	//					xajax_lp(this.idClienteSeleccionado, this.subtotalPedido, this.ivaPedido, this.descuentoPedido, this.totalPedido, this.tipoPrecioGalvamex, this.listadoPedidoShort	, this.selRecogeRecibe, strNombre, strDireccion, strNumero, strColonia, strCiudad, strFESave, this.horaEntrega, this.fechaAbierta, this.pedidoExpress, this.selTipoPedido, this.porDescuento, this.maxDescuentoIndividual, this.selDescuentoIndividual, this.observacionPedido, this.totalOtrosCargos, this.otrosCargos, this.molCostoDobles, this.molCostoCorte, this.buenfintipopago);
						//console.log("antes de levantar pedido");
					
						
						
						
	
						xajax_actualizarPedido(this.idClienteSeleccionado, 
											this.subtotalPedido, 
											this.ivaPedido, 
											this.descuentoPedido, 
											this.totalPedido, 
											this.tipoPrecioGalvamex, 
											this.listadoPedidoShort, 
											this.selRecogeRecibe, 
											this.selSucursalPreferencia, 
											strNombre, 
											strDireccion, 
											strNumero, 
											strColonia, 
											strCiudad, 
											strFESave, 
											this.horaEntrega, 
											this.fechaAbierta, 
											this.pedidoExpress, 
											this.selTipoPedido, 
											this.porDescuento, 
											this.maxDescuentoIndividual, 
											this.selDescuentoIndividual, 
											this.observacionPedido, 
											this.totalOtrosCargos, 
											this.otrosCargos, 
											this.molCostoDobles, 
											this.molCostoCorte, 
											this.buenfintipopago, 
											this.chkFechaEntregaPorDefinir, 
											this.selTipoObra, 
											isCotizacion,
											this.idCotizacion,
											this.getRangosString,
											pasarAPedidoLaCotizacion,
											previoAPasarACotizacion,
											utilizarReciboDinero,
											this.RDCubreCotizacion,
											this.RDATomar,
											this.pedidoFolio);
	//				}
	//				else
	//				{
	//					setTimeout(function(){alert("Parece que ha pulsado 2 veces el botón de Levantar Pedido, se ha omitido el segundo click para prevenir duplicar Pedidos.");}, 150); 
	//				}
					
				}
				else
				{
					mdlExitWait();
					this.mostrarBotonGuardar = true;
					return false;
				}
	
	
	
			},
	
			//Seleccionar Cliente
			seleccionarCliente: function(){
				this.seleccionandoCliente = true;
	
				xajax_cargarClientes();
			},
			cancelarSeleccionarCliente: function(){
				this.seleccionandoCliente = false;
				this.filtroNombreCliente = "";
			},
			setClienteSelected: function(idCliente){
				var i;
				var rc = 1;
	
				this.idClienteSeleccionado = 0;
				this.clienteSeleccionado = '-- SIN CLIENTE --';
				this.promotorClienteSeleccionado = '';
	
				for (i = 0 ; i < this.clientes.length ; i++)
				{
					if (this.clientes[i].id == idCliente)
					{
						this.idClienteSeleccionado = this.clientes[i].id;
						this.idUsuarioPromotor = this.clientes[i].idUsuarioPromotor;
						this.clienteSeleccionado = this.clientes[i].nombre;
						this.promotorClienteSeleccionado = this.clientes[i].promotor;
						this.porDescuento = this.clientes[i].porDescuento;
	
						this.cteSelDomicilio1 = this.clientes[i].domicilio1;
						this.cteSelDomicilio2 = this.clientes[i].domicilio2;
						this.cteSelNumero = this.clientes[i].numero;
						this.cteSelColonia = this.clientes[i].colonia;
						this.cteSelCiudad = this.clientes[i].ciudad;
						this.cteSelTelefonos = this.clientes[i].telefonos;
						this.clienteTipoRangoSeleccionado = this.clientes[i].rangoCliente;
						
						if (this.clienteTipoRangoSeleccionado == 'DISTINGUIDO')
						{
	//						alert("DISTINGUIDO");
							rc = 2;
						}
						else
						{
							if (this.clienteTipoRangoSeleccionado == "SELECT")
							{
	//							alert("SELECT");
								rc = 3;	
							}
							else
							{
	//							alert("REGULAR");
								rc = 1;
							}	
							
						}
						
						this.tipoPrecioGalvamex = rc;
						this.tipoPrecioGalvamexAcryOpa = rc;
						this.tipoPrecioGalvamexGalvateja = rc;
						this.tipoPrecioGalvamexMultipanel = rc;
						this.tipoPrecioGalvamexRolloKilo = rc;
						
	//                    console.log("tipoPrecioGalvamex : " + this.tipoPrecioGalvamex);
						
						this.seleccionandoCliente = false;
						this.cargarRangos();
	
						this.calculaTotales();
						setTimeout(function() { app.calculaTotales();}, 300);
	
						this.seleccionaCliente = false;
						this.vistaPedido = true;
	
	
	
						break;
					}
				}
			},
			//fin Seleccionar Cliente
			quitarElementoDePedido: function(index){
	
				this.indexToDelete = index;
	
				swal({
					title: "¿Está seguro?",
					text: "Se quitará el producto del Pedido",
					type: "warning",
					showCancelButton: true,
					confirmButtonColor: "#DD6B55",
					confirmButtonText: "Si, quitar!",
					cancelButtonText: "No",
					closeOnConfirm: false
				}, function () {
					app.listadoPedido.splice(app.indexToDelete, 1);
					app.calculaTotales();
					swal({
						title: "Listo!",
						text: "El producto ha sido retirado del Pedido.",
						timer: 2000,
						showConfirmButton: false
						}
						);
	
				});
				//this.items.splice(index, 1);
				setTimeout(function(){  app.checarSiHayMercanciaIsocindu();	 }, 150);
			},
			testButton: function(){
				alert("jfkdsjlfkdjklfj");
			},
			updateProductoLista: function(index, usemodal = true){
	
				this.limpiaDatosModal();
				this.textBotonAddModal = "Actualizar Item de Pedido";
				this.textBotonCancelModal = "Cancelar";
	
				this.idProductoModal = this.listadoPedido[index].idProducto;
				this.codigoModal = this.listadoPedido[index].codigo;
				this.descripcionModal = this.listadoPedido[index].fullDescripcion;
				this.cantidadModal = this.listadoPedido[index].cantidad;
				this.cantUnidadModal = this.listadoPedido[index].cantUnidad;
				this.tipoPrecioModal = this.listadoPedido[index].tipoPrecio;
				this.shortUnidadModal = this.listadoPedido[index].shortUnidad;
				this.desarrolloIModal = this.listadoPedido[index].desarrolloI;
				this.desarrolloTModal = this.listadoPedido[index].desarrolloT;
				this.doblecesModal = this.listadoPedido[index].dobleces;
				this.unidadModal = this.listadoPedido[index].unidad;
				this.indexModal = index;
	
				this.modalMostrarMsgAgregarMas = false;
				if (usemodal) $("#myModal").modal();
			},
			validaDatosProductoDeModal: function(){
	
				this.errorModal = "nrk";
				var result = true;
	
	
				if (!Number(this.cantidadModal))
				{
					this.errorModal = this.errorModal + "<br>" + "Debe especificar una Cantidad.";
					result = false;
				}
	
	
				if (this.tipoPrecioModal == "T" || this.tipoPrecioModal == "I")
				{
					if (this.tipoPrecioModal == "T")
					{
						if (this.desarrolloTModal == "0")
						{
							this.errorModal = this.errorModal + "<br>" + "Debe especificar el Desarrollo.";
							result = false;
						}
					}
					else
					{
						if (this.desarrolloIModal == "0")
						{
							this.errorModal = this.errorModal + "<br>" + "Debe especificar el Desarrollo.";
							result = false;
						}
					}
	
	
					if (this.doblecesModal == 0)
					{
						this.errorModal = this.errorModal + "<br>" + "Debe especificar los Dobleces.";
						result = false;
					}
	
	
				}
	
				this.errorModal = this.errorModal.replace("nrk<br>", "");
				this.errorModal = this.errorModal.replace("nrk", "");
	
				return result;
			},
			enlistaProductoDeModal: function(usemodal = true)		{
	
				var vindexModal = this.indexModal;
				var label = '';
	
				if (!this.validaDatosProductoDeModal()) return;
	
				if (this.shortUnidadModal == "ML")
				{
					label = "Metros Lineales";
				}
				else if (this.shortUnidadModal == "M2")
					{
	//					label = "Metros Cuadrados";
						label = "Metros Lineales";
					}
				else if (this.shortUnidadModal == "KG")
					{
						label = "Kiogramos";
					}
	
				if (this.indexModal >= 0)
				{
					this.listadoPedido[this.indexModal].cantidad = Number(this.cantidadModal);
					this.listadoPedido[this.indexModal].cantUnidad = Number(this.cantUnidadModal);
					this.listadoPedido[this.indexModal].tipoPrecio = this.tipoPrecioModal;
					this.listadoPedido[this.indexModal].desarrolloI = this.desarrolloIModal;
					this.listadoPedido[this.indexModal].desarrolloT = this.desarrolloTModal;
					this.listadoPedido[this.indexModal].dobleces = this.doblecesModal;
	
					this.listadoPedido[this.indexModal].lblUnidad = label;
	
					//this.setPrecioProductoListado(this.indexModal);
					setTimeout(function() { app.setPrecioProductoListado(vindexModal); }, 500);
	
					if (usemodal) $("#myModal").modal('toggle');
					toastr.info('Producto Modificado.','Pedido');
					
					setTimeout(function(){ 
	//					console.log("Producto Modificado: index-> " + vindexModal); 
						app.verificaSiHayStock(vindexModal);
						}, 250);
	
				}
				else
				{
					if (this.indexAEnlistarModal >= 0)
					{
						this.listadoPedido.push(JSON.parse(JSON.stringify(this.productos[this.indexAEnlistarModal])));
	
	//					alert("index listadoPedido: " + this.listadoPedido.length);
	
						this.listadoPedido[this.listadoPedido.length - 1].cantidad = Number(this.cantidadModal);
						this.listadoPedido[this.listadoPedido.length - 1].cantUnidad = Number(this.cantUnidadModal);
						this.listadoPedido[this.listadoPedido.length - 1].tipoPrecio = this.tipoPrecioModal;
						this.listadoPedido[this.listadoPedido.length - 1].desarrolloI = this.desarrolloIModal;
						this.listadoPedido[this.listadoPedido.length - 1].desarrolloT = this.desarrolloTModal;
						this.listadoPedido[this.listadoPedido.length - 1].dobleces = this.doblecesModal;
	
						this.listadoPedido[this.listadoPedido.length - 1].lblUnidad = label;
	
						vindexModal = this.listadoPedido.length - 1;
						//this.setPrecioProductoListado(this.listadoPedido.length - 1);
						setTimeout(function() { app.setPrecioProductoListado(vindexModal); }, 500);
	
	//					this.respaldaListado();
	
	//					$("#myModal").modal('toggle');
						this.cantidadModal = 1;
						this.cantUnidadModal = 1;
						this.desarrolloIModal = '0';
						this.desarrolloTModal = '0';
						this.doblecesModal = '0';
						this.errorModal="";
	
						this.modalMostrarMsgAgregarMas = true;
	
						toastr.success('Producto Enlistado','Pedido');
						
						setTimeout(function(){ 
	//						console.log("Producto Modificado: index-> " + (vindexModal));
							app.verificaSiHayStock(vindexModal);
							}, 250);
					}
	
				}
	
				//setTimeout(function(){$('#tblPedidoShort').footable();},50);
				setTimeout(function(){ $('#tblPedidoShort').trigger('footable_redraw')}, 5);
			},
			checarSiHayMercanciaIsocindu: function(){
				// console.log("checarSiHayMercanciaIsocindu");
	
				// msgCotizarFlete: 'RECUERDA COTIZAR FLETE',
				// msgCotizarManiobras: 'SI SE LAMINA EN CUBIERTA, NO OLVIDE COTIZAR MANIOBRAS.',
	
				this.msgCotizarFlete = '';
				this.msgCotizarManiobras = '';
	
				var i = 0;
				for (i = 0; i < this.listadoPedido.length; i++)
				{
					if (this.listadoPedido[i].idAplicacion == 31)
					{
						var str = this.listadoPedido[i].material;
						if (str.includes("ISO"))
						// if (str.includes("POLI"))
						{	
							if (this.selRecogeRecibe == 'ENTREGA' || this.selRecogeRecibe == 'OBRA')
							{
								this.msgCotizarFlete = 'RECUERDA COTIZAR FLETE.'; 
							}
							
							break;
						}
	
					}
				}
	
				for (i = 0; i < this.listadoPedido.length; i++)
				{
					if (this.listadoPedido[i].idRollo > 1)
					{
						var str = this.listadoPedido[i].aplicacion;
						if (str.includes("KR-18"))
						// if (str.includes("POLI"))
						{	
							if (this.selRecogeRecibe == 'ENTREGA')
							{
								this.msgCotizarManiobras = 'SI SE ENTREGA EN CUBIERTA, NO OLVIDE COTIZAR MANIOBRAS.';
							}
	
							if (this.selRecogeRecibe == 'OBRA')
							{
								this.msgCotizarManiobras = 'SI SE LAMINA EN CUBIERTA, NO OLVIDE COTIZAR MANIOBRAS.';
							}
							
							break;
						}
	
					}
				}
	
				if (this.msgCotizarFlete != "" || this.msgCotizarManiobras != "")
				{
					setTimeout(function(){ saInfo(app.msgCotizarFlete + " - " + app.msgCotizarManiobras); }, 500);
				}
			},
			verificaSiHayStock: function(index){
				// console.log("VerificaSiHayStock: " + index);
	
				if (this.listadoPedido[index].idTipoProducto == "1" &&
					this.listadoPedido[index].shortUnidad == "ML" &&	 			 
					this.listadoPedido[index].cantUnidad > 0 &&
					this.listadoPedido[index].idRollo > 1){
					
					xajax_verificaSiHayStock(index, this.listadoPedido[index].idMaterial, this.listadoPedido[index].idAplicacion, this.listadoPedido[index].idRollo, this.listadoPedido[index].cantUnidad);
				
	//				this.listadoPedido[index].sugerirStock.push({
	//					idProducto: 1, 
	//					codigo: "el code", 
	//					mlpieza: 3.4, 
	//					descauto: "la descripcion", 
	//					disponible: 4
	//				});
	//				
	//				this.listadoPedido[index].sugerirStock.push({
	//					idProducto: 1, 
	//					codigo: "el code", 
	//					mlpieza: 3.4, 
	//					descauto: "la descripcion", 
	//					disponible: 4
	//				});
	//				
	//				this.listadoPedido[index].sugerirStock.push({
	//					idProducto: 1, 
	//					codigo: "el code", 
	//					mlpieza: 3.4, 
	//					descauto: "la descripcion", 
	//					disponible: 4
	//				});
				
				}
				else
				{
					if (this.listadoPedido[index].shortUnidad == "PZA" )
					{
						xajax_mostrarInventarioStock(index, this.listadoPedido[index].idProducto);
					}
				}
					
						
					
				
				
			},
			//Se pone el precio del producto en el listado del pedido
			setPrecioProductoListado: function(index){
	
				if (this.listadoPedido[index].tipoPrecio == "G")
				{
					this.listadoPedido[index].precioRenglon = this.listadoPedido[index].precio1 + this.maxDescuentoIndividual;
					this.calculaTotales();
				}
				else
				{
					if (this.listadoPedido[index].tipoPrecio == "I")
					{
	//					alert("cargamos precio de Importados");
						xajax_setPrecioProductoByDobles(index,  this.listadoPedido[index].calibre,  this.listadoPedido[index].tipoPrecio, this.listadoPedido[index].desarrolloI, this.listadoPedido[index].dobleces);
					}
					else
					{
	//					alert("cargamos precio de ternium");
						xajax_setPrecioProductoByDobles(index, this.listadoPedido[index].calibre, this.listadoPedido[index].tipoPrecio, this.listadoPedido[index].desarrolloT, this.listadoPedido[index].dobleces);
					}
	
				}
	
	
			},
			calculaTotales: function(){
				var i;
	
				this.totalML = 0;
				this.totalMLAcryOpa = 0;
				this.totalMLMultipanel = 0;
	//			console.log("limpia galvateja total ml");
				this.totalMLGalvateja = 0;
				this.totalMLRolloKilo = 0;
	
				this.piezasExistencias.splice(0, this.piezasExistencias.length);
				
				this.subtotalPedido = 0;
	
				if (this.promobuenfin && this.buenfintipopago == 99)
				{
					this.descuentoPedido = 0;
				}
	
				for (i = 0; i < this.listadoPedido.length ; i++)
				{
	
					// Tipo A para los rangos normales
					if (this.listadoPedido[i].isRango == "1" && this.listadoPedido[i].tipoRango == "A" )
					{
						if (this.listadoPedido[i].mlpieza > 0)
						{
							
							if (this.listadoPedido[i].idAplicacion == 6)
							{
								this.totalML = this.totalML + ( (this.listadoPedido[i].cantidad * this.listadoPedido[i].cantUnidad * this.listadoPedido[i].mlpieza ) * 0.4572 ); 	
							}
							else
							{
								if (this.listadoPedido[i].idAplicacion == 7)
								{
									this.totalML = this.totalML + ( (this.listadoPedido[i].cantidad * this.listadoPedido[i].cantUnidad * this.listadoPedido[i].mlpieza ) * 0.721 ); 	
								}
								else
								{
									if (this.listadoPedido[i].idAplicacion == 9)
									{
										this.totalML = this.totalML + ( (this.listadoPedido[i].cantidad * this.listadoPedido[i].cantUnidad * this.listadoPedido[i].mlpieza ) * 0.702 ); 	
									}
									else
									{
										this.totalML = this.totalML + (this.listadoPedido[i].cantidad * this.listadoPedido[i].cantUnidad * this.listadoPedido[i].mlpieza );
									}
								}
							}
							
						}
						else
						{
							if (this.listadoPedido[i].idAplicacion == 6)
							{
								this.totalML = this.totalML + ( (this.listadoPedido[i].cantidad * this.listadoPedido[i].cantUnidad) * 0.46);
							}
							else
							{
								if (this.listadoPedido[i].idAplicacion == 7)
								{
									this.totalML = this.totalML + ( (this.listadoPedido[i].cantidad * this.listadoPedido[i].cantUnidad) * 0.721);
								}
								else
								{
									if (this.listadoPedido[i].idAplicacion == 9)
									{
										this.totalML = this.totalML + ( (this.listadoPedido[i].cantidad * this.listadoPedido[i].cantUnidad) * 0.702);
									}
									else
									{
										this.totalML = this.totalML + (this.listadoPedido[i].cantidad * this.listadoPedido[i].cantUnidad);	
									}	
								}	
							}
							
						}
	
					}
	
					// Tipo B para los AcryOpa
					if (this.listadoPedido[i].isRango == "1" && this.listadoPedido[i].tipoRango == "B" )
					{
						if (this.listadoPedido[i].mlpieza > 0)
						{
							this.totalMLAcryOpa = this.totalMLAcryOpa + (this.listadoPedido[i].cantidad * this.listadoPedido[i].cantUnidad * this.listadoPedido[i].mlpieza );
						}
						else
						{
							this.totalMLAcryOpa = this.totalMLAcryOpa + (this.listadoPedido[i].cantidad * this.listadoPedido[i].cantUnidad);
						}
	
					}
	
					// Tipo C para los Multipanel this.totalMLMultipanel
					if (this.listadoPedido[i].isRango == "1" && this.listadoPedido[i].tipoRango == "C" )
					{
						// console.log("Tipo C para los Multipanel this.totalMLMultipanel")
						if (this.listadoPedido[i].mlpieza > 0)
						{
							this.totalMLMultipanel = this.totalMLMultipanel + (this.listadoPedido[i].cantidad * this.listadoPedido[i].cantUnidad * this.listadoPedido[i].mlpieza );
						}
						else
						{
							this.totalMLMultipanel = this.totalMLMultipanel + (this.listadoPedido[i].cantidad * this.listadoPedido[i].cantUnidad);
						}
	
					}
	//				console.log("Total ml Multipanel: " + this.totalMLMultipanel);
					
					// Tipo D las Galvatejas
					if (this.listadoPedido[i].isRango == "1" && this.listadoPedido[i].tipoRango == "D" )
					{
						if (this.listadoPedido[i].mlpieza > 0)
						{
							this.totalMLGalvateja = this.totalMLGalvateja + (this.listadoPedido[i].cantidad * this.listadoPedido[i].cantUnidad * this.listadoPedido[i].mlpieza );
						}
						else
						{
							this.totalMLGalvateja = this.totalMLGalvateja + (this.listadoPedido[i].cantidad * this.listadoPedido[i].cantUnidad);
						}
	
					}
	//				console.log("Total ml Galvateja: " + this.totalMLGalvateja);
					
					// Tipo R las Rollo Kilo
					if (this.listadoPedido[i].isRango == "1" && this.listadoPedido[i].tipoRango == "R" )
					{
						if (this.listadoPedido[i].mlpieza > 0)
						{
							this.totalMLRolloKilo = this.totalMLRolloKilo + (this.listadoPedido[i].cantidad * this.listadoPedido[i].cantUnidad * this.listadoPedido[i].mlpieza );
						}
						else
						{
							this.totalMLRolloKilo = this.totalMLRolloKilo + (this.listadoPedido[i].cantidad * this.listadoPedido[i].cantUnidad);
						}
	
					}
	//				console.log("Total ml RolloKilo: " + this.totalMLRolloKilo);
					
				}
	
	
				if (this.calcularRangosPrecios)
				{
					/*
					|--------------------------------------------------------------------------
					| Inicio Bloque: Rangos de láminas
					|--------------------------------------------------------------------------
					|
					| Se determina el rango de precios que se le dará a las láminas
					| sependiento la cantidas, definido en configuración
					|
					*/
	
					if (this.totalML <= this.rango1Fin)
					{
						this.maxTipoPrecioGalvamex = 1;
					}
					else if(this.totalML >= this.rango2Inicio && this.totalML < this.rango2Fin)
					{
						this.maxTipoPrecioGalvamex = 2;
					}
					else if (this.totalML >= this.rango3Inicio)
					{
	
						this.maxTipoPrecioGalvamex = 3;
					}
	
					if (this.tipoPrecioGalvamex > this.maxTipoPrecioGalvamex && this.clienteTipoRangoSeleccionado == 'REGULAR')
					{
						this.tipoPrecioGalvamex = this.maxTipoPrecioGalvamex;
						return;
					}
					/*
					|--------------------------------------------------------------------------
					| Fin Bloque: Rangos de láminas
					|------------------------------------------------------------------------*/
	
					/*
					|--------------------------------------------------------------------------
					| Inicio Bloque: Rangos de láminas Acrylit Opalit
					|--------------------------------------------------------------------------
					|
					| Se determina que tipo de precio se dará para las láminas Oplit y Tizacril
					|
					*/
	
					if (this.totalMLAcryOpa <= this.rango1FinAcryOpa)
					{
						this.maxTipoPrecioGalvamexAcryOpa = 1;
					}
					else if(this.totalMLAcryOpa >= this.rango2InicioAcryOpa && this.totalMLAcryOpa < this.rango2FinAcryOpa)
					{
						this.maxTipoPrecioGalvamexAcryOpa = 2;
					}
					else if (this.totalMLAcryOpa >= this.rango3InicioAcryOpa)
					{
	
						this.maxTipoPrecioGalvamexAcryOpa = 3;
					}
	
					if (this.tipoPrecioGalvamexAcryOpa > this.maxTipoPrecioGalvamexAcryOpa  && this.clienteTipoRangoSeleccionado == 'REGULAR')
					{
						this.tipoPrecioGalvamexAcryOpa = this.maxTipoPrecioGalvamexAcryOpa;
						return;
					}
	
					/*
					|--------------------------------------------------------------------------
					| Fin Bloque: Rangos de láminas Acrylit Opalit
					|------------------------------------------------------------------------*/
					
					
					/*
					|--------------------------------------------------------------------------
					| Inicio Bloque: Rangos de Multipanel
					|--------------------------------------------------------------------------
					|
					| Se determina que tipo de precio se dará para las Multipanel
					|
					*/
					
					if (this.totalMLMultipanel <= this.rango1FinMultipanel)
					{
						this.maxTipoPrecioGalvamexMultipanel = 1;
					}
					else if(this.totalMLMultipanel >= this.rango2InicioMultipanel && this.totalMLMultipanel < this.rango2FinMultipanel)
					{
						this.maxTipoPrecioGalvamexMultipanel = 2;
					}
					else if (this.totalMLMultipanel >= this.rango3InicioMultipanel)
					{
	
						this.maxTipoPrecioGalvamexMultipanel = 3;
					}
	
					if (this.tipoPrecioGalvamexMultipanel > this.maxTipoPrecioGalvamexMultipanel  && this.clienteTipoRangoSeleccionado == 'REGULAR')
					{
						this.tipoPrecioGalvamexMultipanel = this.maxTipoPrecioGalvamexMultipanel;
						return;
					}
					
					/*
					|--------------------------------------------------------------------------
					| Fin Bloque: Rangos de láminas Multipanel
					|------------------------------------------------------------------------*/
					
					/*
					|--------------------------------------------------------------------------
					| Inicio Bloque: Rangos de Galvatejas
					|--------------------------------------------------------------------------
					|
					| Se determina que tipo de precio se dará para las Galvatejas
					|
					*/
	
					if (this.totalMLGalvateja <= this.rango1FinGalvateja)
					{
						this.maxTipoPrecioGalvamexGalvateja = 1;
					}
					else if(this.totalMLGalvateja >= this.rango2InicioGalvateja && this.totalMLGalvateja < this.rango2FinGalvateja)
					{
						this.maxTipoPrecioGalvamexGalvateja = 2;
					}
					else if (this.totalMLGalvateja >= this.rango3InicioGalvateja)
					{
	
						this.maxTipoPrecioGalvamexGalvateja = 3;
					}
	
					if (this.tipoPrecioGalvamexGalvateja > this.maxTipoPrecioGalvamexGalvateja  && this.clienteTipoRangoSeleccionado == 'REGULAR')
					{
						this.tipoPrecioGalvamexGalvateja = this.maxTipoPrecioGalvamexGalvateja;
						return;
					}
	
					/*
					|--------------------------------------------------------------------------
					| Fin Bloque: Rangos de Galvatejas
					|------------------------------------------------------------------------*/
					
					/*
					|--------------------------------------------------------------------------
					| Inicio Bloque: Rangos de Rollo Kilo
					|--------------------------------------------------------------------------
					|
					| Se determina que tipo de precio se dará para las Galvatejas
					|
					*/
	
					if (this.totalMLRolloKilo <= this.rango1FinRolloKilo)
					{
						this.maxTipoPrecioGalvamexRolloKilo = 1;
					}
					else if(this.totalMLRolloKilo >= this.rango2InicioRolloKilo && this.totalMLRolloKilo < this.rango2FinRolloKilo)
					{
						this.maxTipoPrecioGalvamexRolloKilo = 2;
					}
					else if (this.totalMLRolloKilo >= this.rango3InicioRolloKilo)
					{
	
						this.maxTipoPrecioGalvamexRolloKilo = 3;
					}
	
					if (this.tipoPrecioGalvamexRolloKilo > this.maxTipoPrecioGalvamexRolloKilo  && this.clienteTipoRangoSeleccionado == 'REGULAR')
					{
						this.tipoPrecioGalvamexRolloKilo = this.maxTipoPrecioGalvamexRolloKilo;
						return;
					}
	
					/*
					|--------------------------------------------------------------------------
					| Fin Bloque: Rangos de Rollo Kilo
					|------------------------------------------------------------------------*/
					
					
					
					/*
					|--------------------------------------------------------------------------
					| Clientes Distinguido y Select
					|------------------------------------------------------------------------*/
					
					if (this.clienteTipoRangoSeleccionado == 'DISTINGUIDO')
					{
						if (this.maxTipoPrecioGalvamex < 2) this.maxTipoPrecioGalvamex = 2;
						if (this.maxTipoPrecioGalvamexMultipanel < 2) this.maxTipoPrecioGalvamexMultipanel = 2; 
						if (this.maxTipoPrecioGalvamexGalvateja < 2) this.maxTipoPrecioGalvamexGalvateja = 2; 
						if (this.maxTipoPrecioGalvamexAcryOpa < 2) this.maxTipoPrecioGalvamexAcryOpa = 2; 
						if (this.maxTipoPrecioGalvamexRolloKilo < 2) this.maxTipoPrecioGalvamexRolloKilo = 2; 
						
						
						if (this.tipoPrecioGalvamex > this.maxTipoPrecioGalvamex ) this.tipoPrecioGalvamex = this.maxTipoPrecioGalvamex;
						if (this.tipoPrecioGalvamexAcryOpa > this.maxTipoPrecioGalvamexAcryOpa) this.tipoPrecioGalvamexAcryOpa = this.maxTipoPrecioGalvamexAcryOpa;
						if (this.tipoPrecioGalvamexGalvateja > this.maxTipoPrecioGalvamexGalvateja) this.tipoPrecioGalvamexGalvateja = this.maxtipoPrecioGalvamexGalvateja;
						if (this.tipoPrecioGalvamexMultipanel > this.maxTipoPrecioGalvamexMultipanel) this.tipoPrecioGalvamexMultipanel = this.maxTipoPrecioGalvamexMultipanel;
						if (this.tipoPrecioGalvamexRolloKilo > this.maxTipoPrecioGalvamexRolloKilo) this.tipoPrecioGalvamexRolloKilo = this.maxTipoPrecioGalvamexRolloKilo;
					}
					else
					{
						if (this.clienteTipoRangoSeleccionado == 'SELECT')
						{
							if (this.maxTipoPrecioGalvamex < 3) this.maxTipoPrecioGalvamex = 3;
							if (this.maxTipoPrecioGalvamexMultipanel < 3) this.maxTipoPrecioGalvamexMultipanel = 3; 
							if (this.maxTipoPrecioGalvamexGalvateja < 3) this.maxTipoPrecioGalvamexGalvateja = 3; 
							if (this.maxTipoPrecioGalvamexAcryOpa < 3) this.maxTipoPrecioGalvamexAcryOpa = 3; 
							if (this.maxTipoPrecioGalvamexRolloKilo < 3) this.maxTipoPrecioGalvamexRolloKilo = 3; 
							
							if (this.tipoPrecioGalvamex > this.maxTipoPrecioGalvamex ) this.tipoPrecioGalvamex = this.maxTipoPrecioGalvamex;
							if (this.tipoPrecioGalvamexAcryOpa > this.maxTipoPrecioGalvamexAcryOpa) this.tipoPrecioGalvamexAcryOpa = this.maxTipoPrecioGalvamexAcryOpa;
							if (this.tipoPrecioGalvamexGalvateja > this.maxTipoPrecioGalvamexGalvateja) this.tipoPrecioGalvamexGalvateja = this.maxtipoPrecioGalvamexGalvateja;
							if (this.tipoPrecioGalvamexMultipanel > this.maxTipoPrecioGalvamexMultipanel) this.tipoPrecioGalvamexMultipanel = this.maxTipoPrecioGalvamexMultipanel;
							if (this.tipoPrecioGalvamexRolloKilo > this.maxTipoPrecioGalvamexRolloKilo) this.tipoPrecioGalvamexRolloKilo = this.maxTipoPrecioGalvamexRolloKilo;
						}
					}
					
					
					
					
					/*
					|--------------------------------------------------------------------------
					| Fin Bloque: Clientes Distinguido y Select
					|------------------------------------------------------------------------*/
	
				}
				//fin calcularRangosPrecios
				
				
	
	
				this.subtotalPedido = 0;
	
				for (i = 0; i < this.listadoPedido.length ; i++)
				{
					if (this.listadoPedido[i].shortUnidad == "M2")
					{
						this.listadoPedido[i].cantUnidadReal = this.listadoPedido[i].cantUnidad * .46;
					}
					else
					{
						this.listadoPedido[i].cantUnidadReal = this.listadoPedido[i].cantUnidad;
					}
	
					this.listadoPedido[i].rangoRenglon = this.comisionR1;
	
					// Manejo de rangos normales tipo A
					if (this.listadoPedido[i].isRango == "1" && this.listadoPedido[i].tipoRango == "A")
					{
						// console.log("  renglonprecio: " +this.listadoPedido[i].precioRenglon);
						// console.log("estamos en el rango tipo A");
						if (this.tipoPrecioGalvamex == 1)
						{
							this.listadoPedido[i].rangoRenglon = this.comisionR1;
							this.listadoPedido[i].tipoPrecioComision = "RANGO1";
						}
						else if (this.tipoPrecioGalvamex == 2)
						{
							this.listadoPedido[i].rangoRenglon = this.comisionR2;
							this.listadoPedido[i].tipoPrecioComision = "RANGO2";
						}
						else
						{
							this.listadoPedido[i].rangoRenglon = this.comisionR3;
							this.listadoPedido[i].tipoPrecioComision = "RANGO3";
						}
	
	
						if (this.tipoPrecioGalvamex == 3)
						{
							// console.log("Rango Normal: tipo 3");
	
							// this.listadoPedido[i].precioRenglon = parseFloat(this.listadoPedido[i].precio3); //++++++++++++
							// console.log("precio 3 " + this.listadoPedido[i].precio3 + "  renglonprecio: " +this.listadoPedido[i].precioRenglon);
	
							// console.log("Rango Normal: tipo 3");
							if (this.listadoPedido[i].mlpieza > 0)
							{
								this.listadoPedido[i].precioRenglon = parseFloat(this.listadoPedido[i].precio3) + (parseFloat(this.maxDescuentoIndividual) * parseFloat(this.listadoPedido[i].mlpieza));
							}
							else
							{
								this.listadoPedido[i].precioRenglon = parseFloat(this.listadoPedido[i].precio3) + parseFloat(this.maxDescuentoIndividual);
							}
						}
						else if (this.tipoPrecioGalvamex == 2)
						{
							// console.log("Rango Normal: tipo 2");
	
							// this.listadoPedido[i].precioRenglon = parseFloat(this.listadoPedido[i].precio2); // ++++++++++++++++++++++
	
							// console.log("precio 2 " + this.listadoPedido[i].precio2 + "  renglonprecio: " +this.listadoPedido[i].precioRenglon);
	
							// console.log("Rango Normal: tipo 2");
							if (this.listadoPedido[i].mlpieza > 0)
							{
								this.listadoPedido[i].precioRenglon = parseFloat(this.listadoPedido[i].precio2) + (parseFloat(this.maxDescuentoIndividual) * parseFloat(this.listadoPedido[i].mlpieza));
							}
							else
							{
								this.listadoPedido[i].precioRenglon = parseFloat(this.listadoPedido[i].precio2) + parseFloat(this.maxDescuentoIndividual);
							}
						}
						else
						{
							// console.log("Rango Normal: tipo 1");
							if (this.listadoPedido[i].mlpieza > 0)
							{
								this.listadoPedido[i].precioRenglon = parseFloat(this.listadoPedido[i].precio1) + (parseFloat(this.maxDescuentoIndividual) * parseFloat(this.listadoPedido[i].mlpieza));
							}
							else
							{
								this.listadoPedido[i].precioRenglon = parseFloat(this.listadoPedido[i].precio1) + parseFloat(this.maxDescuentoIndividual);
							}
							// console.log("precio 1 " + this.listadoPedido[i].precio1 + "  renglonprecio: " +this.listadoPedido[i].precioRenglon);
	
						}
					}// FIN Manejo de rangos normales tipo A
					else if(this.listadoPedido[i].isRango == "1" && this.listadoPedido[i].tipoRango == "B")
					{
						// Manejo de rangos normales tipo B
						// console.log("estamos en el rango tipo B");
						if (this.tipoPrecioGalvamexAcryOpa == 1)
						{
							this.listadoPedido[i].rangoRenglon = this.comisionR1;
							this.listadoPedido[i].tipoPrecioComision = "RANGO1";
						}
						else if (this.tipoPrecioGalvamexAcryOpa == 2)
						{
							this.listadoPedido[i].rangoRenglon = this.comisionR2;
							this.listadoPedido[i].tipoPrecioComision = "RANGO2";
						}
						else
						{
							this.listadoPedido[i].rangoRenglon = this.comisionR3;
							this.listadoPedido[i].tipoPrecioComision = "RANGO3";
						}
	
	
	
						if (this.tipoPrecioGalvamexAcryOpa == 3)
						{
							// console.log("AcryOpa 3 ");
	//						this.listadoPedido[i].precioRenglon = parseFloat(this.listadoPedido[i].precio3) + parseFloat(this.maxDescuentoIndividual);
							// this.listadoPedido[i].precioRenglon = parseFloat(this.listadoPedido[i].precio3); // ++++++++++++++
	
	
							// console.log("AcryOpa 3 ");
							if (this.listadoPedido[i].mlpieza > 0)
							{
								this.listadoPedido[i].precioRenglon = parseFloat(this.listadoPedido[i].precio3) + (parseFloat(this.maxDescuentoIndividual) * parseFloat(this.listadoPedido[i].mlpieza));
							}
							else
							{
								this.listadoPedido[i].precioRenglon = parseFloat(this.listadoPedido[i].precio3) + parseFloat(this.maxDescuentoIndividual);
							}
						}
						else if (this.tipoPrecioGalvamexAcryOpa == 2)
						{
							// console.log("AcryOpa 2 ");
							// this.listadoPedido[i].precioRenglon = parseFloat(this.listadoPedido[i].precio2); // +++++++++
	
							// console.log("AcryOpa 2 ");
							if (this.listadoPedido[i].mlpieza > 0)
							{
								this.listadoPedido[i].precioRenglon = parseFloat(this.listadoPedido[i].precio2) + (parseFloat(this.maxDescuentoIndividual) * parseFloat(this.listadoPedido[i].mlpieza));
							}
							else
							{
								this.listadoPedido[i].precioRenglon = parseFloat(this.listadoPedido[i].precio2) + parseFloat(this.maxDescuentoIndividual);
							}
						}
						else
						{
							// console.log("AcryOpa 1 ");
							if (this.listadoPedido[i].mlpieza > 0)
							{
								this.listadoPedido[i].precioRenglon = parseFloat(this.listadoPedido[i].precio1) + (parseFloat(this.maxDescuentoIndividual) * parseFloat(this.listadoPedido[i].mlpieza));
							}
							else
							{
								this.listadoPedido[i].precioRenglon = parseFloat(this.listadoPedido[i].precio1) + parseFloat(this.maxDescuentoIndividual);
							}
	
	
						}
					} // FIN Manejo de rangos normales tipo B
					else if(this.listadoPedido[i].isRango == "1" && this.listadoPedido[i].tipoRango == "C")
					{
	//					 Manejo de rangos normales tipo C MULTIPANEL
						//  console.log("estamos en el rango tipo C");
						if (this.tipoPrecioGalvamexMultipanel == 1)
						{
							this.listadoPedido[i].rangoRenglon = this.comisionR1;
							this.listadoPedido[i].tipoPrecioComision = "RANGO1";
						}
						else if (this.tipoPrecioGalvamexMultipanel == 2)
						{
							this.listadoPedido[i].rangoRenglon = this.comisionR2;
							this.listadoPedido[i].tipoPrecioComision = "RANGO2";
						}
						else
						{
							this.listadoPedido[i].rangoRenglon = this.comisionR3;
							this.listadoPedido[i].tipoPrecioComision = "RANGO3";
						}
	
	
	
						if (this.tipoPrecioGalvamexMultipanel == 3)
						{
							//  console.log("MULTIPANEL 3 ");
	//						this.listadoPedido[i].precioRenglon = parseFloat(this.listadoPedido[i].precio3) + parseFloat(this.maxDescuentoIndividual);
							// this.listadoPedido[i].precioRenglon = parseFloat(this.listadoPedido[i].precio3); //+++++++
							// console.log("Asignando precio:" + parseFloat(this.listadoPedido[i].precio3));
	
							if (this.listadoPedido[i].mlpieza > 0)
							{
								// console.log(" ** mlpieza > 0 precioRenglon: " + this.listadoPedido[i].precioRenglon)	
								this.listadoPedido[i].precioRenglon = parseFloat(this.listadoPedido[i].precio3) + (parseFloat(this.maxDescuentoIndividual) * parseFloat(this.listadoPedido[i].mlpieza));
							}
							else
							{
								// console.log(" ** mlpieza == 0 precioRenglon: " + this.listadoPedido[i].precioRenglon)	
								this.listadoPedido[i].precioRenglon = parseFloat(this.listadoPedido[i].precio3) + parseFloat(this.maxDescuentoIndividual);
							}
							// console.log("precioRenglon: " + this.listadoPedido[i].precioRenglon)
						}
						else if (this.tipoPrecioGalvamexMultipanel == 2)
						{
							//  console.log("MULTIPANEL 2 ");
							//  console.log("Asignando precio:" + parseFloat(this.listadoPedido[i].precio2));
	//						this.listadoPedido[i].precioRenglon = parseFloat(this.listadoPedido[i].precio2) + parseFloat(this.maxDescuentoIndividual);
							// this.listadoPedido[i].precioRenglon = parseFloat(this.listadoPedido[i].precio2); //+++++
	
							if (this.listadoPedido[i].mlpieza > 0)
							{
								// console.log(" ** mlpieza > 0 precioRenglon: " + this.listadoPedido[i].precioRenglon)	
								this.listadoPedido[i].precioRenglon = parseFloat(this.listadoPedido[i].precio2) + (parseFloat(this.maxDescuentoIndividual) * parseFloat(this.listadoPedido[i].mlpieza));
							}
							else
							{	
								// console.log(" ** mlpieza == 0 precioRenglon: " + this.listadoPedido[i].precioRenglon)	
								this.listadoPedido[i].precioRenglon = parseFloat(this.listadoPedido[i].precio2) + parseFloat(this.maxDescuentoIndividual);
							}
							// console.log("precioRenglon: " + this.listadoPedido[i].precioRenglon)
						}
						else
						{
							//  console.log("MULTIPANEL 1 ");
							//  console.log("Asignando precio:" + parseFloat(this.listadoPedido[i].precio1));
							if (this.listadoPedido[i].mlpieza > 0)
							{
								// console.log(" ** mlpieza > 0 precioRenglon: " + this.listadoPedido[i].precioRenglon)	
								this.listadoPedido[i].precioRenglon = parseFloat(this.listadoPedido[i].precio1) + (parseFloat(this.maxDescuentoIndividual) * parseFloat(this.listadoPedido[i].mlpieza));
							}
							else
							{
								// console.log(" ** mlpieza == 0 precioRenglon: " + this.listadoPedido[i].precioRenglon)	
								this.listadoPedido[i].precioRenglon = parseFloat(this.listadoPedido[i].precio1) + parseFloat(this.maxDescuentoIndividual);
							}
	
							// console.log("precioRenglon: " + this.listadoPedido[i].precioRenglon)
						}
					} // FIN Manejo de rangos normales tipo C MULTIPANEL
					else if(this.listadoPedido[i].isRango == "1" && this.listadoPedido[i].tipoRango == "D")
					{
						// Manejo de rangos normales tipo D GALVATEJA
	//					 console.log("estamos en el rango tipo D");
						if (this.tipoPrecioGalvamexGalvateja == 1)
						{
							this.listadoPedido[i].rangoRenglon = this.comisionR1;
							this.listadoPedido[i].tipoPrecioComision = "RANGO1";
						}
						else if (this.tipoPrecioGalvamexGalvateja == 2)
						{
							this.listadoPedido[i].rangoRenglon = this.comisionR2;
							this.listadoPedido[i].tipoPrecioComision = "RANGO2";
						}
						else
						{
							this.listadoPedido[i].rangoRenglon = this.comisionR3;
							this.listadoPedido[i].tipoPrecioComision = "RANGO3";
						}
	
	
	
						if (this.tipoPrecioGalvamexGalvateja == 3)
						{
	//						 console.log("Galvateja 3 ");
	//						this.listadoPedido[i].precioRenglon = parseFloat(this.listadoPedido[i].precio3) + parseFloat(this.maxDescuentoIndividual);
							this.listadoPedido[i].precioRenglon = parseFloat(this.listadoPedido[i].precio3);
						}
						else if (this.tipoPrecioGalvamexGalvateja == 2)
						{
	//						 console.log("Galvateja 2 ");
	//						this.listadoPedido[i].precioRenglon = parseFloat(this.listadoPedido[i].precio2) + parseFloat(this.maxDescuentoIndividual);
							this.listadoPedido[i].precioRenglon = parseFloat(this.listadoPedido[i].precio2);
						}
						else
						{
	//						 console.log("Galvateja 1 ");
	//						if (this.listadoPedido[i].mlpieza > 0)
	//						{
	//							this.listadoPedido[i].precioRenglon = parseFloat(this.listadoPedido[i].precio1) + (parseFloat(this.maxDescuentoIndividual) * parseFloat(this.listadoPedido[i].mlpieza));
	//						}
	//						else
	//						{
	//							this.listadoPedido[i].precioRenglon = parseFloat(this.listadoPedido[i].precio1) + parseFloat(this.maxDescuentoIndividual);
								this.listadoPedido[i].precioRenglon = parseFloat(this.listadoPedido[i].precio1) ;
	//						}
	
	
						}
					} // FIN Manejo de rangos normales tipo D Galvateja
					else if(this.listadoPedido[i].isRango == "1" && this.listadoPedido[i].tipoRango == "R")
					{
						// Manejo de rangos normales tipo R Rollo Kilo
	//					 console.log("estamos en el rango tipo R");
						if (this.tipoPrecioGalvamexRolloKilo == 1)
						{
							this.listadoPedido[i].rangoRenglon = this.comisionR1;
							this.listadoPedido[i].tipoPrecioComision = "RANGO1";
						}
						else if (this.tipoPrecioGalvamexRolloKilo == 2)
						{
							this.listadoPedido[i].rangoRenglon = this.comisionR2;
							this.listadoPedido[i].tipoPrecioComision = "RANGO2";
						}
						else
						{
							this.listadoPedido[i].rangoRenglon = this.comisionR3;
							this.listadoPedido[i].tipoPrecioComision = "RANGO3";
						}
	
	
	
						if (this.tipoPrecioGalvamexRolloKilo == 3)
						{
	//						 console.log("RolloKilo 3 ");
	//						this.listadoPedido[i].precioRenglon = parseFloat(this.listadoPedido[i].precio3) + parseFloat(this.maxDescuentoIndividual);
							this.listadoPedido[i].precioRenglon = parseFloat(this.listadoPedido[i].precio3);
						}
						else if (this.tipoPrecioGalvamexRolloKilo == 2)
						{
	//						 console.log("RolloKilo 2 ");
	//						this.listadoPedido[i].precioRenglon = parseFloat(this.listadoPedido[i].precio2) + parseFloat(this.maxDescuentoIndividual);
							this.listadoPedido[i].precioRenglon = parseFloat(this.listadoPedido[i].precio2);
						}
						else
						{
	//						 console.log("RolloKilo 1 ");
	//						if (this.listadoPedido[i].mlpieza > 0)
	//						{
	//							this.listadoPedido[i].precioRenglon = parseFloat(this.listadoPedido[i].precio1) + (parseFloat(this.maxDescuentoIndividual) * parseFloat(this.listadoPedido[i].mlpieza));
	//						}
	//						else
	//						{
	//							this.listadoPedido[i].precioRenglon = parseFloat(this.listadoPedido[i].precio1) + parseFloat(this.maxDescuentoIndividual);
								this.listadoPedido[i].precioRenglon = parseFloat(this.listadoPedido[i].precio1) ;
	//						}
	
	
						}
					} // FIN Manejo de rangos normales tipo R Rollo Kilo
					else
					{
						if (this.listadoPedido[i].tipoPrecio == "G")
						{
							if (this.listadoPedido[i].idTipoProducto == "1")
							{
								if (this.listadoPedido[i].mlpieza > 0)
								{
									this.listadoPedido[i].precioRenglon = parseFloat(this.listadoPedido[i].precio1) + (parseFloat(this.maxDescuentoIndividual) * parseFloat(this.listadoPedido[i].mlpieza));
								}
								else
								{
									this.listadoPedido[i].precioRenglon = parseFloat(this.listadoPedido[i].precio1) + parseFloat(this.maxDescuentoIndividual);
								}
							}
							else
							{
								this.listadoPedido[i].precioRenglon = parseFloat(this.listadoPedido[i].precio1);
							}
						}
	
	
	
					}
	
					// FIN Manejo de rangos normales tipo ABCD	
	
	
	
	
					if (this.listadoPedido[i].tipoPrecio == "G")
					{
						//solo aplica descuentos individuales a las láminas
						if (this.listadoPedido[i].idTipoProducto == "1")
						{
							//solo jugar con los descuento aquellos productos por rango y el rango es 1
							if (this.listadoPedido[i].isRango == "1" && this.listadoPedido[i].tipoRango == "A")
							{
								// if (this.tipoPrecioGalvamex == 1)
								// {
									if (this.listadoPedido[i].mlpieza > 0)
									{
										this.listadoPedido[i].precioRenglon = parseFloat(this.listadoPedido[i].precioRenglon) - (parseFloat(this.selDescuentoIndividual) * parseFloat(this.listadoPedido[i].mlpieza));
									}
									else
									{
										this.listadoPedido[i].precioRenglon = parseFloat(this.listadoPedido[i].precioRenglon) - parseFloat(this.selDescuentoIndividual);
									}
	
								// }
								// else
								// {
								// 	this.listadoPedido[i].precioRenglon = parseFloat(this.listadoPedido[i].precioRenglon);
								// }
							}
							else if(this.listadoPedido[i].isRango == "1" && this.listadoPedido[i].tipoRango == "B")
							{
								// console.log("calculamos descuento si o no de tipo B");
								// if (this.tipoPrecioGalvamexAcryOpa == 1)
								// {
									// console.log("SI");
									if (this.listadoPedido[i].mlpieza > 0)
									{
										// console.log("Calculando precio tipo rango B ");
										// console.log("this.listadoPedido[i].precioRenglon) " + this.listadoPedido[i].precioRenglon);
										// console.log("this.selDescuentoIndividual " + this.selDescuentoIndividual);
										// console.log("this.listadoPedido[i].mlpieza  " + this.listadoPedido[i].mlpieza);
										
										this.listadoPedido[i].precioRenglon = parseFloat(this.listadoPedido[i].precioRenglon) - (parseFloat(this.selDescuentoIndividual) * parseFloat(this.listadoPedido[i].mlpieza));
										
										// console.log("T o t a l : " + this.listadoPedido[i].precioRenglon);
									}
									else
									{
										this.listadoPedido[i].precioRenglon = parseFloat(this.listadoPedido[i].precioRenglon) - parseFloat(this.selDescuentoIndividual);
									}
	
								// }
								// else
								// {
								// 	// console.log("NO");
								// 	this.listadoPedido[i].precioRenglon = parseFloat(this.listadoPedido[i].precioRenglon);
								// }
							}
							else if(this.listadoPedido[i].isRango == "1" && this.listadoPedido[i].tipoRango == "C")
							{
								// console.log("calculamos descuento si o no de tipo B");
								// if (this.tipoPrecioGalvamexMultipanel == 1)
								// {
									// console.log("SI");
									if (this.listadoPedido[i].mlpieza > 0)
									{
										// console.log("Calculando precio tipo rango C ");
										// console.log("this.listadoPedido[i].precioRenglon) " + this.listadoPedido[i].precioRenglon);
										// console.log("this.selDescuentoIndividual " + this.selDescuentoIndividual);
										// console.log("this.listadoPedido[i].mlpieza  " + this.listadoPedido[i].mlpieza);
										
										this.listadoPedido[i].precioRenglon = parseFloat(this.listadoPedido[i].precioRenglon) - (parseFloat(this.selDescuentoIndividual) * parseFloat(this.listadoPedido[i].mlpieza));
										
										// console.log("T o t a l : " + this.listadoPedido[i].precioRenglon);
									}
									else
									{
										this.listadoPedido[i].precioRenglon = parseFloat(this.listadoPedido[i].precioRenglon) - parseFloat(this.selDescuentoIndividual);
									}
	
								// }
								// else
								// {
								// 	// console.log("NO");
								// 	this.listadoPedido[i].precioRenglon = parseFloat(this.listadoPedido[i].precioRenglon);
								// }
							}
							else if(this.listadoPedido[i].isRango == "1" && this.listadoPedido[i].tipoRango == "D")
							{
								// console.log("calculamos descuento si o no de tipo B");
								if (this.tipoPrecioGalvamexGalvateja == 1)
								{
									// console.log("SI");
									if (this.listadoPedido[i].mlpieza > 0)
									{
										this.listadoPedido[i].precioRenglon = parseFloat(this.listadoPedido[i].precioRenglon) - (parseFloat(this.selDescuentoIndividual) * parseFloat(this.listadoPedido[i].mlpieza));
									}
									else
									{
										this.listadoPedido[i].precioRenglon = parseFloat(this.listadoPedido[i].precioRenglon) - parseFloat(this.selDescuentoIndividual);
									}
	
								}
								else
								{
									// console.log("NO");
									this.listadoPedido[i].precioRenglon = parseFloat(this.listadoPedido[i].precioRenglon);
								}
							}
							else if(this.listadoPedido[i].isRango == "1" && this.listadoPedido[i].tipoRango == "R")
							{
								// console.log("calculamos descuento si o no de tipo B");
								if (this.tipoPrecioGalvamexRolloKilo == 1)
								{
									// console.log("SI");
									if (this.listadoPedido[i].mlpieza > 0)
									{
										this.listadoPedido[i].precioRenglon = parseFloat(this.listadoPedido[i].precioRenglon) - (parseFloat(this.selDescuentoIndividual) * parseFloat(this.listadoPedido[i].mlpieza));
									}
									else
									{
										this.listadoPedido[i].precioRenglon = parseFloat(this.listadoPedido[i].precioRenglon) - parseFloat(this.selDescuentoIndividual);
									}
	
								}
								else
								{
									// console.log("NO");
									this.listadoPedido[i].precioRenglon = parseFloat(this.listadoPedido[i].precioRenglon);
								}
							}
							else
							{
								if (this.listadoPedido[i].mlpieza > 0)
								{
									this.listadoPedido[i].precioRenglon = parseFloat(this.listadoPedido[i].precioRenglon) - (parseFloat(this.selDescuentoIndividual) * parseFloat(this.listadoPedido[i].mlpieza));
								}
								else
								{
									this.listadoPedido[i].precioRenglon = parseFloat(this.listadoPedido[i].precioRenglon) - parseFloat(this.selDescuentoIndividual);
								}
	
							}
	
						}
						else
						{
							this.listadoPedido[i].precioRenglon = parseFloat(this.listadoPedido[i].precioRenglon);
						}
					}
					
					
					
					
	
					/*
					|--------------------------------------------------------------------------
					| Rango MENDEZ
					|------------------------------------------------------------------------*/
					
					if (this.idClienteSeleccionado == 137)
					{
						// Manejo de PRECIOS PARA CLIENTE MENDEZ
	//					 console.log("PRECIOS MENDEZ");
						
						this.listadoPedido[i].rangoRenglon = this.comisionR1;
						this.listadoPedido[i].tipoPrecioComision = "MENDEZ";					
	
						this.listadoPedido[i].precioRenglon = parseFloat(this.listadoPedido[i].preciomendez);
	
					}
					
					/*
					|--------------------------------------------------------------------------
					| Fin Bloque: Rango MENDEZ
					|------------------------------------------------------------------------*/
					
					
					
					
					
					
					
					//precio de las molduras 9
					if (this.listadoPedido[i].idProducto == this.molIdProducto)
					{
	//					this.listadoPedido[i].molLaminasCobrar = Math.ceil(this.listadoPedido[i].cantidad / this.listadoPedido[i].molMoldurasXLamina);
						this.listadoPedido[i].molLaminasATomar = Math.ceil(this.listadoPedido[i].cantidad / this.listadoPedido[i].molMoldurasXLaminaTodos);
	//					this.listadoPedido[i].precioRenglon = parseFloat((this.listadoPedido[i].molLaminasCobrar * this.listadoPedido[i].molPrecioLamina) + (this.listadoPedido[i].cantidad * this.molCostoDobles * this.listadoPedido[i].dobleces) + ((this.listadoPedido[i].cantidad * this.molCostoCorte)));
	//					this.listadoPedido[i].precioRenglon = parseFloat((this.listadoPedido[i].molLaminasCobrar * this.listadoPedido[i].molPrecioLamina) 
	//							                                          + ((this.listadoPedido[i].cantidad * this.molCostoDobles * this.listadoPedido[i].dobleces) 
	//							                                          + ((this.listadoPedido[i].cantidad * this.molCostoCorte)) / this.listadoPedido[i].cantUnidadReal)
	//					                                                 );
	//					this.listadoPedido[i].precioRenglon = parseFloat((this.listadoPedido[i].molLaminasCobrar * this.listadoPedido[i].molPrecioLamina));
	//					this.listadoPedido[i].precioRenglon = parseFloat( (this.listadoPedido[i].precioRenglon / this.listadoPedido[i].cantidad ) * this.listadoPedido[i].cantUnidadReal);
						
	//					this.listadoPedido[i].precioRenglon = parseFloat( this.listadoPedido[i].precioRenglon + ( this.molCostoDobles * this.listadoPedido[i].dobleces) +  this.molCostoCorte );
	//					this.listadoPedido[i].precioRenglon = parseFloat( (this.listadoPedido[i].precio1 * this.listadoPedido[i].cantUnidadReal) + ( this.molCostoDobles * this.listadoPedido[i].dobleces) +  this.molCostoCorte );
						
						this.listadoPedido[i].precioRenglon = parseFloat( (this.listadoPedido[i].precio1 * this.listadoPedido[i].cantUnidadReal) + ( this.listadoPedido[i].molDobles * this.listadoPedido[i].dobleces) +  this.listadoPedido[i].molCorte );
					}
					
					if (this.listadoPedido[i].idProducto == this.molIdMaquila)
					{
						this.listadoPedido[i].molLaminasCobrar = 0; //Math.ceil(this.listadoPedido[i].cantidad / this.listadoPedido[i].molMoldurasXLamina);
						this.listadoPedido[i].molLaminasATomar = 0; //Math.ceil(this.listadoPedido[i].cantidad / this.listadoPedido[i].molMoldurasXLaminaTodos);
						
	//					this.listadoPedido[i].precioRenglon = parseFloat((this.listadoPedido[i].cantidad * this.molCostoDobles * this.listadoPedido[i].dobleces) + ((this.listadoPedido[i].cantidad * this.molCostoCorte)));
	//					this.listadoPedido[i].precioRenglon = parseFloat(this.listadoPedido[i].precioRenglon / this.listadoPedido[i].cantidad);
						
	//					this.listadoPedido[i].precioRenglon = parseFloat((this.molCostoDoblesMaquila * this.listadoPedido[i].dobleces) + (this.molCostoCorteMaquila));
	//					this.listadoPedido[i].precioRenglon = parseFloat(this.listadoPedido[i].precioRenglon / this.listadoPedido[i].cantidad);
						
						this.listadoPedido[i].precioRenglon = parseFloat((this.listadoPedido[i].molDobles * this.listadoPedido[i].dobleces) + (this.listadoPedido[i].molCorte));
						
					}
	
	//				console.log(i + " - Curva - " + this.listadoPedido[i].curva);
					if (this.listadoPedido[i].curva != "")
					{
	//					console.log("incrementa precio");
						this.listadoPedido[i].precioRenglon = parseFloat(this.listadoPedido[i].precioRenglon) * (1 + (this.porcentajeCurvatura / 100));
					}
	
					//ponemos que todos los productos se podrán fabricar o surtir
					this.listadoPedido[i].productoCantidadDisponible = true;
					if (this.listadoPedido[i].idRollo > 1 && this.listadoPedido[i].shortUnidad != "PZA")
					{
						if (this.listadoPedido[i].idRollo > 1 && this.listadoPedido[i].shortUnidad == "KG")
						{
							this.listadoPedido[i].kl = this.listadoPedido[i].cantidad;
							this.listadoPedido[i].kl = this.listadoPedido[i].kl.toFixed(2);
						}
						else
						{
							this.listadoPedido[i].kl = this.listadoPedido[i].cantidad * this.listadoPedido[i].cantUnidadReal * this.listadoPedido[i].rolloPesokiloml;
							this.listadoPedido[i].kl = this.listadoPedido[i].kl.toFixed(2);
						}
						
					}
					else
					{
						this.addPiezaParaContar(this.listadoPedido[i].codigo);
					}
					
					//redondear pesos en totalrenglon
	//				this.listadoPedido[i].totalRenglon = this.listadoPedido[i].totalRenglon.toFixed(2);
					
					if ( this.listadoPedido[i].idProducto == this.molIdMaquila || this.listadoPedido[i].idProducto == this.molIdProducto)
					{
						this.listadoPedido[i].totalRenglon = parseFloat( this.listadoPedido[i].cantidad *  this.listadoPedido[i].precioRenglon);
						this.listadoPedido[i].totalRenglon = Math.round(this.listadoPedido[i].totalRenglon * 100) / 100;
						this.subtotalPedido = this.subtotalPedido + (this.listadoPedido[i].cantidad * this.listadoPedido[i].precioRenglon);
					}
					else
					{
						
						this.listadoPedido[i].totalRenglon = parseFloat( this.listadoPedido[i].cantidad * this.listadoPedido[i].cantUnidadReal * this.listadoPedido[i].precioRenglon);
						this.listadoPedido[i].totalRenglon = Math.round(this.listadoPedido[i].totalRenglon * 100) / 100;
						this.subtotalPedido = this.subtotalPedido + (this.listadoPedido[i].cantidad * this.listadoPedido[i].cantUnidadReal * this.listadoPedido[i].precioRenglon);
												
					}
					
					
					
	//				this.listadoPedido[i].totalRenglon = Math.round(this.listadoPedido[i].totalRenglon) ;
					
					if (this.promobuenfin && this.buenfintipopago == 99)
					{
						
						if (this.listadoPedido[i].idProducto >= 410 && this.listadoPedido[i].idProducto <= 415)
						{
	//						alert("buen fin");
							if (this.listadoPedido[i].tipoPrecioComision == "RANGO1" || this.listadoPedido[i].tipoPrecioComision == "PRECIO" )
							{
	//							alert("precio");
								this.descuentoPedido = this.descuentoPedido + parseFloat(parseFloat(this.listadoPedido[i].cantidad) * parseFloat(this.listadoPedido[i].cantUnidad) * 10 );
							}
							else if (this.listadoPedido[i].tipoPrecioComision == "RANGO2")
							{
	//							alert("rango2");
								this.descuentoPedido = this.descuentoPedido + parseFloat(parseFloat(this.listadoPedido[i].cantidad) * parseFloat(this.listadoPedido[i].cantUnidad) * 9 );
							}
							else if (this.listadoPedido[i].tipoPrecioComision == "RANGO3")
							{
	//							alert("rango3");
								this.descuentoPedido = this.descuentoPedido + parseFloat(parseFloat(this.listadoPedido[i].cantidad) * parseFloat(this.listadoPedido[i].cantUnidad) * 8 );
							}						
						}
						else
						{
							if (this.listadoPedido[i].rolloIdProveedor == 2)
							{
	//							alert("buen fin");
								if (this.listadoPedido[i].tipoPrecioComision == "RANGO1" || this.listadoPedido[i].tipoPrecioComision == "PRECIO" )
								{
	//								alert("precio");
									this.descuentoPedido = this.descuentoPedido + parseFloat(parseFloat(this.listadoPedido[i].cantidad) * parseFloat(this.listadoPedido[i].cantUnidad) * 5 );
								}
								else if (this.listadoPedido[i].tipoPrecioComision == "RANGO2")
								{
	//								alert("rango2");
									this.descuentoPedido = this.descuentoPedido + parseFloat(parseFloat(this.listadoPedido[i].cantidad) * parseFloat(this.listadoPedido[i].cantUnidad) * 4 );
								}
								else if (this.listadoPedido[i].tipoPrecioComision == "RANGO3")
								{
	//								alert("rango3	");
									this.descuentoPedido = this.descuentoPedido + parseFloat(parseFloat(this.listadoPedido[i].cantidad) * parseFloat(this.listadoPedido[i].cantUnidad) * 3 );
								}
							}
						}
					}
	
					this.subtotalPedido = Math.round(this.subtotalPedido * 100) / 100;
				}
				
				
	
				//this.descuentoPedido = Math.round((this.subtotalPedido + this.ivaPedido) * this.porDescuento) / 100;
				this.porDescuento = formatNumber((this.descuentoPedido * 100) / (this.subtotalPedido + this.totalOtrosCargos + this.ivaPedido));
				if (!isFinite(this.porDescuento))
					this.porDescuento = 0;
				this.totalPedido = this.subtotalPedido + this.totalOtrosCargos + this.ivaPedido - this.descuentoPedido;
				this.totalPedido = Math.round(this.totalPedido * 100) / 100;
	
				this.contarKilosPiezas();
			},
			addPiezaParaContar: function(codigo){
	//			console.log("Agregar el producto " + codigo);
				var i=0;
				var existe = false;
	
				for (i = 0 ; i < this.piezasExistencias.length ; i++)
				{
					if (this.piezasExistencias[i].codigo == codigo)
					{
						existe = true;
					}
				}
	
				if (!existe)
				{
					for (i = 0 ; i < this.productos.length ; i++)
					{
						if (this.productos[i].codigo == codigo)
						{
							this.piezasExistencias.push({
									idProducto: this.productos[i].idProducto,
									codigo: this.productos[i].codigo,
									fullDescripcion: this.productos[i].fullDescripcion,
									longitud: this.productos[i].longitud,
									mlpieza: this.productos[i].mlpieza,
									existencia: Number(this.productos[i].existenciaEstimada),
									enpedido: 0,
									nosepuede: false,
									productoenpedido: false 
								});
						}
					}
				}
	
				
				
			},
			contarKilosPiezas: function(){
				// console.log("aqui contamos kilos y piezas");
				var i = 0;
	
				this.limpiarKlEnPedidosDeRollos();
				this.limpiarPiezasEnPedidosDeProductos();
	
				for (i = 0 ; i < this.listadoPedido.length ; i++)
				{
	//				console.log("Producto: " + this.listadoPedido[i].codigo);
	
					if (this.listadoPedido[i].shortUnidad != "PZA")
					{
						// console.log("Contar kilos: " + this.listadoPedido[i].kl);		
						this.cuentaEstosKilosEnRollo(this.listadoPedido[i].idRollo, this.listadoPedido[i].kl);
					}
					else
					{
	//					console.log("No contamos los kilos, es pza");
						this.cuentaEstasPiezasEnProductos(this.listadoPedido[i].codigo, this.listadoPedido[i].cantidad);
					}
				}
	
				this.indicarProductosYRollosNoDisponibles();
	
			},
			indicarProductosYRollosNoDisponibles: function(){
				var i = 0;
				var j = 0;
	
				// console.log("indicarProductosYRollosNoDisponibles")
	
				for(j = 0; j < this.listadoPedido.length ; j++)
						{
							// if (this.listadoPedido[j].idRollo == this.rollosExistencias[i].idrollo && this.listadoPedido[j].shortUnidad != "PZA")
							// {
								this.listadoPedido[j].productoCantidadDisponible = true;				
								// console.log("setting productoCantidadDisponible at index " + j + " to true")
							// }
							
						}
	// alert("press anykey")
				for (i = 0 ; i < this.rollosExistencias.length ; i++)
				{
					if (this.rollosExistencias[i].nosepuede)
					{
						for(j = 0; j < this.listadoPedido.length ; j++)
						{
							if (this.listadoPedido[j].idRollo == this.rollosExistencias[i].idrollo && this.listadoPedido[j].shortUnidad != "PZA")
							{
								this.listadoPedido[j].productoCantidadDisponible = false;				
							}
							
						}
					}	
					
				}
	
				for (i = 0 ; i < this.piezasExistencias.length ; i++)
				{
					if (this.piezasExistencias[i].nosepuede)
					{
						for(j = 0; j < this.listadoPedido.length ; j++)
						{
							if (this.listadoPedido[j].codigo == this.piezasExistencias[i].codigo && this.listadoPedido[j].shortUnidad == "PZA")
							{
								this.listadoPedido[j].productoCantidadDisponible = false;				
							}
							
						}
					}	
					
				}
			},
			cuentaEstosKilosEnRollo: function(idRollo, kl){
				var i = 0;
	
				for (i = 0 ; i < this.rollosExistencias.length ; i++)
				{
					if (this.rollosExistencias[i].idrollo == idRollo)
					{
						// console.log("Rollo " + i + " enpedido: " + this.rollosExistencias[i].enpedido)
						this.rollosExistencias[i].rolloenpedido = true;
						this.rollosExistencias[i].enpedido += Number(kl);
						// console.log("Rollo " + i + " enpedido: " + this.rollosExistencias[i].enpedido)
					}
					
					if (this.rollosExistencias[i].enpedido > this.rollosExistencias[i].disponible)
					{
						this.rollosExistencias[i].nosepuede = true;
					}
					else
					{
					this.rollosExistencias[i].nosepuede = false;
					}
				}
			},
			cuentaEstasPiezasEnProductos: function(codigo, piezas){
				var i = 0;
	
				for (i = 0 ; i < this.piezasExistencias.length ; i++)
				{
					if (this.piezasExistencias[i].codigo == codigo)
					{
						this.piezasExistencias[i].productoenpedido = true;
						this.piezasExistencias[i].enpedido += Number(piezas);
					}
					
					if (this.piezasExistencias[i].enpedido > this.piezasExistencias[i].existencia)
					{
						this.piezasExistencias[i].nosepuede = true;
					}
				}
			},
			limpiarKlEnPedidosDeRollos: function(){	
				var i = 0;
	
				for (i = 0 ; i < this.rollosExistencias.length ; i++)
				{
					this.rollosExistencias[i].rolloenpedido = false;
					this.rollosExistencias[i].enpedido = 0;
				}
			},
			limpiarPiezasEnPedidosDeProductos: function(){
				var i = 0;
	
				for (i = 0 ; i < this.piezasExistencias.length ; i++)
				{
					this.piezasExistencias[i].productoenpedido = false;
					this.piezasExistencias[i].enpedido = 0;
				}
			},
			respaldaListado:function(){
	
				this.oldListadoPedido = JSON.parse(JSON.stringify(this.listadoPedido));
	
			},
			mostrarOtroProductoEnModal: function(idProducto){
				var index = -1;
	
				index = this.productos.findIndex(x => x.idProducto == idProducto);
				
				if (index >= 0)
				{
					this.showModalParaEnlistar(index, false);
				}
	
			},
			//enlistarProducto
			showModalParaEnlistar: function(index, mostrarModal = true){
				this.debug = "";
				this.addDebug("Enlistamos");
				var i;
				var existe = false;
	
				this.limpiaDatosModal();
				this.textBotonAddModal = "Agregar a Pedido";
				this.textBotonCancelModal = "Terminar Captura de Producto";
	
				//comentamos para que acepte 2 renglones del mismo tipo
	//			for (i = 0 ; i < this.listadoPedido.length ; i++)
	//			{
	//				if (this.listadoPedido[i].idProducto == this.productos[index].idProducto)
	//				{
	//					existe = true;
	////					toastr.info('Producto ya existe en el Pedido. Se suma a la Cantidad.','Pedido');
	////					this.listadoPedido[i].cantidad = this.listadoPedido[i].cantidad + 1;
	//					this.codigoModal = this.listadoPedido[i].codigo;
	//					this.descripcionModal = this.listadoPedido[i].fullDescripcion;
	//					this.cantidadModal = this.listadoPedido[i].cantidad;
	//					this.cantUnidadModal = this.listadoPedido[i].cantUnidad;
	//					this.tipoPrecioModal = this.listadoPedido[i].tipoPrecio;
	//					this.shortUnidadModal = this.listadoPedido[i].shortUnidad;
	//					this.desarrolloIModal = this.listadoPedido[i].desarrolloI;
	//					this.desarrolloTModal = this.listadoPedido[i].desarrolloT;
	//					this.doblecesModal = this.listadoPedido[i].dobleces;
	//					this.unidadModal = this.listadoPedido[i].unidad;
	//					this.indexModal = i;
	//				}
	//			}
	
				if (!existe)
				{
					//this.listadoPedido.push(this.productos[index]);
	//				this.listadoPedido.push(JSON.parse(JSON.stringify(this.productos[index])));
	//				this.respaldaListado();
					this.idProductoModal = this.productos[index].idProducto;
					this.codigoModal = this.productos[index].codigo;
					this.descripcionModal = this.productos[index].fullDescripcion;
					this.cantidadModal = this.productos[index].cantidad;
					this.cantUnidadModal = this.productos[index].cantUnidad;
					this.tipoPrecioModal = this.productos[index].tipoPrecio;
					this.shortUnidadModal = this.productos[index].shortUnidad;
					this.desarrolloIModal = this.productos[index].desarrolloI;
					this.desarrolloTModal = this.productos[index].desarrolloT;
					this.doblecesModal = this.productos[index].dobleces;
					this.unidadModal = this.productos[index].unidad;
	
					this.indexAEnlistarModal = index;
	//				toastr.success('Producto Enlistado','Pedido');
				}
	
				this.modalMostrarMsgAgregarMas = false;
				if (mostrarModal) $("#myModal").modal();
	
	
				this.productoAEnlistar = "";
			},
			prepararProductoDesdeGrid: function(codigo, indexPadreDeComercializado = -1){
	//			console.log("producto: " + codigo);
				this.saveCookie();
				this.buscarXCodigo = true;
				this.productoAEnlistar = codigo;
				
				this.indexPadreDeComercializado = indexPadreDeComercializado;
				this.productosDePadreComercializados.splice(0, this.productosDePadreComercializados.length);
				if (indexPadreDeComercializado >= 0)
				{
					// numbersCopy = numbers.map((x) => x);
					// this.productosDePadreComercializados = this.productosFiltradosComercializados[this.indexPadreDeComercializado].productos;
					this.productosDePadreComercializados = this.productosFiltradosComercializados[this.indexPadreDeComercializado].productos.map(x => x);
				}
				// console.log(this.productosDePadreComercializados);
				this.prepararProducto();
				this.buscarXCodigo = false;
			},
			prepararProducto: function(indexPadreDeComercializado = -1){
				var indexPrepareProducto = -1;
	//			console.log("producto: " + this.productoAEnlistar);
				if (this.productoAEnlistar == "")
				{
					mostrarAviso('Debe ingresar un producto');
					return;
				}
				this.addDebug("Comenzamos busqueda de " + this.productoAEnlistar);
	
				if (indexPadreDeComercializado < 0)
					this.productosDePadreComercializados.splice(0, this.productosDePadreComercializados.length);
	
				this.searchEncontrado = false;
	
				if (!isNaN(this.productoAEnlistar))
				{
					indexPrepareProducto = this.productos.findIndex(x => x.idProducto == this.productoAEnlistar);
					
					if (indexPrepareProducto >= 0)
					{					
						this.searchEncontrado = true;
						this.searchIndexProductos= indexPrepareProducto;				
					}
					
					if (this.searchEncontrado == true)
					{
						this.addDebug('');
						this.addDebug("         ------ Elemento encontrado en " + this.searchIndexProductos);
						this.addDebug('');
						this.showModalParaEnlistar(this.searchIndexProductos);
						// alert("aqui abrimos modal");
						return;
					}
					else
					{
						mostrarAviso('No se ha encontrado el producto con el ID indicado');
						return;
					}
				}
				
				
				
	
				
	
				this.searchEncontrado = false;
	
				if (this.buscarXCodigo)
				{
					indexPrepareProducto = this.productos.findIndex(x => x.fullDescripcionCode.toUpperCase() == this.productoAEnlistar.toUpperCase());
					
					if (indexPrepareProducto >= 0)
					{					
						this.searchEncontrado = true;
						this.searchIndexProductos= indexPrepareProducto;				
					}
				}
				// alert("buscaProductoXFullDescripcion");
				// this.buscaProductoXFullDescripcion();
				this.addDebug ("Fin busqueda");
	
				if (this.searchEncontrado == true)
				{
					this.addDebug('');
					this.addDebug("         ------ Elemento encontrado en " + this.searchIndexProductos);
					this.addDebug('');
					this.showModalParaEnlistar(this.searchIndexProductos);
				}
				else
				{
	//				this.debug="";
	//				this.addDebug("  Buscamos por Codigo");
	
					indexPrepareProducto = this.productos.findIndex(x => x.codigo == this.productoAEnlistar);
								
					if (indexPrepareProducto >= 0)
					{					
						this.searchEncontrado = true;
						this.searchIndexProductos= indexPrepareProducto;				
					}
					// alert("buscaProductoXCodigo");
					// this.buscaProductoXCodigo();
	
					if (this.searchEncontrado == true)
					{
						this.addDebug('');
						this.addDebug("         ------ Elemento encontrado en " + this.searchIndexProductos);
						this.addDebug('');
	
						this.showModalParaEnlistar(this.searchIndexProductos);
					}
					else
					{
						mostrarEspera("Por favor espere...");
						this.addDebug('');
						this.addDebug('');
						this.addDebug(" NNNOO Encontrado");
						this.addDebug('');
						this.addDebug('');
	
						xajax_cargarProductoIndividual(this.productoAEnlistar);
					}
				}
	
			},
			buscaProductoXFullDescripcion: function(){
				var i;
				this.addDebug("Buscaremos " + this.productoAEnlistar);
	//			alert("Buscaremos " + this.productoAEnlistar);
				for(i = 0; i < this.productos.length ; i++)
				{
					this.addDebug ("  Es: "  + this.productos[i].fullDescripcionCode + "  ? ");
					if (this.productos[i].fullDescripcionCode.toUpperCase() == this.productoAEnlistar.toUpperCase())
					{
						this.addDebug ("        ->>  Si Es");
						this.searchEncontrado = true;
						this.searchIndexProductos= i;
						return;
					}
					else
					{
						this.addDebug ("        ><  no Es");
					}
				}
			},
			buscaProductoXCodigo: function(){
				var i;
				this.addDebug("Buscaremos " + this.productoAEnlistar);
				for(i = 0; i < this.productos.length ; i++)
				{
					this.addDebug ("  Es: "  + this.productos[i].codigo + "  ? ");
					if (this.productos[i].codigo == this.productoAEnlistar)
					{
						this.addDebug ("        ->>  Si Es");
						this.searchEncontrado = true;
						this.searchIndexProductos= i;
						return;
					}
					else
					{
						this.addDebug ("        ><  no Es");
					}
				}
			},
			addDebug: function(line){
				this.debug = this.debug + "<br>" + line;
			},
			cargarProductos: function(){
				// console.log("cargar lista Productos");
				xajax_cargarListaProductos();
			},
			cargarProductosMasVendidos: function(){
				xajax_cargarListaProductosMasVendidos();
			},
			cargarProductosFavoritos: function(){
				xajax_cargarListaProductosFavoritos();
			},
			cargarRollos: function(){
				// console.log("cargar lista Productos");
				xajax_cargarListaRollos();
			},
			cargarTiposProducto: function(){
				xajax_cargarTiposProducto();
			},
			cargarRangos: function(){
				xajax_cargarRangos(this.idUsuarioPromotor);
			},
			listarProductos: function(tipoProducto){
				this.idTipoProducto = tipoProducto;
				this.hideSectionTiposProductos();
				setTimeout(function(){ $('.footable').trigger('footable_redraw')}, 2);
			},
			limpiaDatosModal: function(){
				this.indexModal = -1;
				this.indexAEnlistarModal = -1;
				this.idProductoModal = -1;
				this.codigoModal = 'Código';
				this.descripcionModal = 'Descripción';
				this.cantidadModal = 1;
				this.cantUnidadModal = 1;
				this.tipoPrecioModal = '';
				this.shortUnidadModal = '';
				this.desarrolloIModal = '0';
				this.desarrolloTModal = '0';
				this.doblecesModal = '0';
				this.errorModal="";
				this.unidadModal = '';
	
			},
			hideSectionTiposProductos: function(){
				this.mostrarTiposProducto = false;
	
	//			if (!this.tblProductosFiltradosFootable)
	//			{
	////				alert("apenas footable");
	//				setTimeout(function(){$('#tblProductosFiltrados').footable();},50);
	//				this.tblProductosFiltradosFootable = true;
	//			}
	
				setTimeout(function(){$('#tblProductosFiltrados').footable();},50);
				//setTimeout(function(){ $('#tblProductosFiltrados').trigger('footable_redraw')}, 100);
	
			},
			showSectionTiposProductos: function(){
	//			console.log("aca");
				this.mostrarTiposProducto = true;
	
	
			},
			showHideGrid: function(){
	//			this.productos.push({ id: 1, descripcion: 'Producto 1'});
	//			this.productos.push({ id: 2, descripcion: 'Producto 2'});
	//
	
				$( "#tablero" ).animate({
					  height: "toggle",
					  opacity: "toggle"
					}, {
					  duration: "slow"
					});//
	
				this.gridOculta = !this.gridOculta;
	
				if (this.gridOculta)
				{
					this.textShowGrid = "Mostrar Grid";
				}
				else
				{
					this.textShowGrid = "Ocultar Grid";
				}
	
	
	
			},
			seleccionarOtroCliente: function(){
				this.vistaPedido = false;
				this.seleccionaCliente = true;
			},
			dejarClienteSeleccionado: function(){
	
				xajax_cargarClienteById(this.idClienteSeleccionado);
	
				this.vistaPedido = true;
				this.seleccionaCliente = false;
			},
			refreshDatosClienteSeleccionado: function(rango = ""){
				console.log("rango parametro: " + rango);
				xajax_cargarClienteById(this.idClienteSeleccionado, rango);
			},
			getOptionsDescuentoIndividual: function(){
				var resultado = "";
				var i;
	
				for (i = 0 ; i <= this.maxDescuentoIndividual ; i++)
				{
					resultado = resultado + "<option value='" + i + "'>"+i+"</option>";
				}
	
				return resultado;
			},
			levantarPedidoSinChecarStock: function(texto){
				swal({
					title: "¿Levantar Pedido sin considerar Stock?",
					text: texto,
					type: "warning",
					showCancelButton: true,
					cancelButtonText: "NO",
					cancelButtonColor: "#ed5565",
					confirmButtonColor: "#1c84c6",
					confirmButtonText: "¡Adelante!",
					closeOnConfirm: false },
	
					function(){
	
						swal.close();
						app.selTipoPedido = "D";
						setTimeout(function() { app.levantarPedido(); }, 200);
						//xajax_autorizarPedido(idPedido, observacion);
	
				});
			},
			registrarNuevoCliente: function(){
	//			modalRegistrarCliente
				this.limpiaDatosCliente();
				$("#modalRegistrarCliente").modal();
			},
			guardarCliente: function(){
				var seguir = true;
			  
				this.limpiaErroresCliente();
			  
				if (this.nombre.trim() == "")
				{
					this.errNombre = "Debe especificar un Nombre de Cliente.";
					seguir = false;
				}
				
				if (this.apellidos.trim() == "")
				{
					this.errApellidos = "Debe especificar Apellido(s) del Cliente.";
					seguir = false;
				}		
				
				if (this.usuarioPromotor == "0")
				{
					this.errUsuarioPromotor = "Debe especificar el Promotor asociado";
					seguir = false;
				}
				
				
				
				if (this.chkFacturable)
				{
					if (this.domicilio1.trim() == "")
					{
						this.errDomicilio1 = "Debe especificar Dirección.";
						seguir = false;
					}
					
					if (this.numero.trim() == "")
					{
						this.errNumero = "Debe especificar Número.";
						seguir = false;
					}
					
					if (this.colonia.trim() == "")
					{
						this.errColonia = "Debe especificar Colonia.";
						seguir = false;
					}
					
					if (this.ciudad.trim() == "")
					{
						this.errCiudad = "Debe especificar Ciudad.";
						seguir = false;
					}
					
					if (this.telefonos.trim() == "")
					{
						this.errTelefonos = "Debe especificar Telefono(s).";
						seguir = false;
					}
				  
					if (this.email.trim() == "")
					{
						this.errEmail = "Debe especificar un EMail.";
						seguir = false;
					}
					else
					{
						if (!isEmail (this.email.trim()))
						{
							this.errEmail = "El dato EMail no tiene un formato correcto.";
							seguir = false;
						}
					}
					
					if (this.rfc.trim() == "")
					{
						this.errRfc = "Debe especificar R.F.C.";
						seguir = false;
					}
					
					if (this.estado.trim() == "0")
					{
						this.errEstado = "Debe especificar un Estatus.";
						seguir = false;
					}
					
					
					
					if (this.domicilioFiscal == '')
					{
						this.errDomicilioFiscal = "Debe especificar el Domicilio Fical";
						seguir = false;
					}	
					
					if (this.usoCFDI == '0')
					{
						this.errUsoCFDI = "Debe especificar el Uso CFDI";
						seguir = false;
					}	
					
					if (this.razonSocial == '')
					{
						this.errRazonSocial = "Debe especificar Razón Social";
						seguir = false;
					}
					
					if (this.CP == '')
					{
						this.errCP = "Debe especificar CP";
						seguir = false;
					}
					
				}
				else
				{
					this.usoCFDI = '22'
				}
				
					
				
				
				if (seguir)
				{		
	//				alert("GUARDAR");
					$("#modalRegistrarCliente").modal('toggle');
					
					xajax_guardarCliente(this.idCliente, 
										   this.nombre.trim(), 
										   this.apellidos.trim(), 
										   this.empresa.trim(), 
										   this.domicilio1.trim(), 
										   this.domicilio2.trim(), 
										   this.numero.trim(), 
										   this.colonia.trim(), 
										   this.ciudad.trim(), 
										   this.telefonos.trim(), 
										   this.email.trim(), 
										   this.rfc.trim(), 
										   this.estado, 
										   this.usuarioPromotor,
										   this.chkFacturable,
										   this.razonSocial,
										   this.domicilioFiscal,
										   this.CP,
										   this.usoCFDI);
				}	
				
				//xajax_guardar(this.id, this.nombre, this.apellidoPaterno, this.apellidoMaterno);
			},
			limpiaDatosCliente: function(){
				this.idCliente = 0;
				this.nombre = '';
				this.apellidos = '';
				this.empresa = '';
				this.domicilio1 = '';
				this.domicilio2 = '';
				this.numero = '';
				this.colonia = '';
				this.ciudad = '';
				this.telefonos = '';
				this.email = '';
				this.rfc = '';
				this.estado = 'ACTIVO';
				this.usuarioPromotor = '0';
				this.errRazonSocial = '';
				this.errDomicilioFiscal = '';
				this.errCP = '';
			},
			limpiaErroresCliente: function(){
				this.errNombre = '';
				this.errApellidos = '';
				this.errEmpresa = '';
				this.errDomicilio1 = '';
				this.errDomicilio2 = '';
				this.errNumero = '';
				this.errColonia = '';
				this.errCiudad = '';
				this.errTelefonos = '';
				this.errEmail = '';
				this.errRfc = '';
				this.errEstado = '';
				this.errUsuarioPromotor = '';
				
				this.razonSocial = '';
				this.domicilioFiscal = '';
				this.CP = '';
			},
			agregarMoldura: function(){
				this.limpiarModalMoldura();
				$("#modalAgregarMoldura").modal();
			},
			agregarMaquila	: function(){
				this.limpiarModalMoldura();
				this.molIsMaquila = true;
				this.molTextoBotonAddMoldura = 'Agregar Maquila a Pedido';
				this.molTextoBotonCancelAddMoldura = 'Dejar de Capturar Maquila';
				$("#modalAgregarMoldura").modal();
			},
			agregarMolduraV2: function(){
				this.limpiarModalMoldura();
				$("#modalAgregarMolduraV2").modal();
			},
			agregarMaquilaV2: function(){
				this.limpiarModalMoldura();
				this.molIsMaquila = true;
				this.molTextoBotonAddMoldura = 'Agregar Maquila a Pedido';
				this.molTextoBotonCancelAddMoldura = 'Dejar de Capturar Maquila';
				$("#modalAgregarMolduraV2").modal();
			},
			calculaPrecioMoldura: function(){
				this.molPrecioMetroMoldura = (this.molPrecioADar + this.molCostoCorte + (this.molCostoDobles * this.molDobleces)).toFixed(2) ;
	//			this.molPrecioMetroMoldura = (this.molPrecioADar).toFixed(2) ;
			},
			calculaPrecioMoldura2: function(){
	//			this.molPrecioMetroMoldura = (this.molPrecioADar + this.molCostoCorte + (this.molCostoDobles * this.molDobleces)).toFixed(2) ;
	//			console.clear();
				
	//			console.log(" ********");
	//			console.log("Molduras por Lámina: " + this.molMoldurasXLaminaTodos);
	//			console.log("Molduras Pedidas: " + this.molCantidad);
				var laminasPosiblesACobrar = Math.ceil(this.molCantidad / this.molMoldurasXLaminaTodos);
	//			console.log( "Total Láminas posibles a Cobrar: " +  laminasPosiblesACobrar);
				var laminasAUsarReal = Math.trunc(this.molCantidad / this.molMoldurasXLaminaTodos);
				var laminasAUsar = Math.trunc(this.molCantidad / this.molMoldurasXLaminaTodos);
				if (laminasAUsar == 0) laminasAUsar = 1;
	//			console.log( "Total Láminas a Usar: " + laminasAUsar );
	//			console.log( "Total Molduras en Láminas Completas: " + (Math.trunc(this.molCantidad / this.molMoldurasXLaminaTodos) * this.molMoldurasXLaminaTodos));
				var moldurasSueltas = (this.molCantidad % this.molMoldurasXLaminaTodos);
	//			console.log( "Molduras en Lámina no Completa: " + moldurasSueltas);
							
				var sobrante = 0;
				var aUsarReal = 0;
				var aUsarPorPiesMedios = 0;
				var precioUnitarioML = 0;
				if (moldurasSueltas > 0)
				{
					if (this.molPies == 3)
					{
						sobrante = (91.44 - (moldurasSueltas * this.molDesarrolloV2));
						aUsarReal = (moldurasSueltas * this.molDesarrolloV2);
	//					console.log("sobrante de la lámina: " + sobrante);
							
					}
					
	//				3.76	114.6
					if (this.molPies == 3.76)
					{
						sobrante = (114.6 - (moldurasSueltas * this.molDesarrolloV2));
						aUsarReal = (moldurasSueltas * this.molDesarrolloV2);
	//					console.log("3.76  ----------  sobrante de la lámina: " + sobrante);
							
					}
					
	//				3.48	106.07
					if (this.molPies == 3.48)
					{
						sobrante = (106.07 - (moldurasSueltas * this.molDesarrolloV2));
						aUsarReal = (moldurasSueltas * this.molDesarrolloV2);
	//					console.log("3.48  ----------  sobrante de la lámina: " + sobrante);
							
					}
	
					
					if (this.molPies == 4)
					{
						sobrante = (122 - (moldurasSueltas * this.molDesarrolloV2));
						aUsarReal = (moldurasSueltas * this.molDesarrolloV2);
	//					console.log("sobrante de la lámina: " + sobrante);					
					}	
					
					if (sobrante >= 60)
					{
	//					console.log("** cobrar " + laminasAUsarReal + " láminas + solo " + (this.molPrecioCM * this.molDesarrolloV2 * moldurasSueltas ) + "  por sobrante > 60");
	//					console.log("");
	//					console.log("Precio ML Lámina: " + this.molPrecioRollo);
						precioUnitarioML = (this.molPrecioRollo * laminasAUsarReal);
	//					console.log(" > : " + precioUnitarioML);
						precioUnitarioML = (this.molPrecioCM * this.molDesarrolloV2 * moldurasSueltas ).toFixed(2);
	//					console.log(" >> : " + precioUnitarioML);
						
						
						//calculando los pies
						
	//					console.log(" a usar, suelto: " + (this.molDesarrolloV2 * moldurasSueltas) + " cm ("+ aUsarReal + ")");
						
						if (aUsarReal > 0 && aUsarReal <=15.24) //0.5 pies
						{
							aUsarPorPiesMedios = 15.24;
						}
						else
						{
							if (aUsarReal > 15.24 && aUsarReal <=30.48) //1 pies
							{
								aUsarPorPiesMedios = 30.48;
							}
							else
							{
								if (aUsarReal > 30.48 && aUsarReal <= 45.72) //1.5 pies
								{
									aUsarPorPiesMedios = 45.72;
								}
								else
								{
									if (aUsarReal > 45.72 && aUsarReal <= 60.96) //2 pies
									{
										aUsarPorPiesMedios = 60.96;
									}
									else
									{
										if (aUsarReal > 60.96 && aUsarReal <= 76.2) //2.5 pies
										{
											aUsarPorPiesMedios = 76.2;
										}
										else
										{
											if (aUsarReal > 76.2 && aUsarReal <= 91.44) //2.5 pies
											{
												aUsarPorPiesMedios = 91.44;
											}
											else
											{
												aUsarPorPiesMedios = aUsarReal;
											}
										}
									}
								}
								
							}
						}
						
	//					console.log(" a cobrar por 1/2 s pies: "+ aUsarPorPiesMedios + " cm");
	//					console.log("");
	//					console.log("precio medida exacta: " + (this.molPrecioCM * this.molDesarrolloV2 * moldurasSueltas ));
	//					console.log("precio medida medios pies: " + (this.molPrecioCM * aUsarPorPiesMedios ));
	//					console.log("");
	//					precioUnitarioML = (this.molPrecioRollo * laminasAUsarReal ) + (this.molPrecioCM * this.molDesarrolloV2 * moldurasSueltas );
						precioUnitarioML = (this.molPrecioRollo * laminasAUsarReal ) + (this.molPrecioCM * aUsarPorPiesMedios );
						
	//					precioUnitarioML = precioUnitarioML.toFixed(2);
	//					console.log(" >>> : " + precioUnitarioML);
						
	//					precioUnitarioML =  ( ((this.molPrecioRollo * laminasAUsarReal ) + (this.molPrecioCM * this.molDesarrolloV2 * moldurasSueltas ) ) / this.molCantidad ).toFixed(2);
						
						precioUnitarioML =  ( ((this.molPrecioRollo * laminasAUsarReal ) + (this.molPrecioCM * aUsarPorPiesMedios ) ) / this.molCantidad ).toFixed(2);
						
	//					precioUnitarioML =  ( ((this.molPrecioRollo * laminasAUsarReal ) + (this.molPrecioCM * this.molDesarrolloV2 * moldurasSueltas ) ) );
							
	//					console.log(" p.u.> : " + precioUnitarioML);
						
					}
					else
					{
	//					console.log("--- cobrar " + laminasPosiblesACobrar + " láminas, por el sobrante");
	//					console.log("");
	//					console.log("Precio ML Lámina: " + this.molPrecioRollo);
	//					precioUnitarioML = (this.molPrecioRollo * laminasPosiblesACobrar).toFixed(2);
						precioUnitarioML = (this.molPrecioRollo * laminasPosiblesACobrar);
	//					console.log(" >>>> : " + precioUnitarioML);
	//					precioUnitarioML = (((this.molPrecioRollo * laminasPosiblesACobrar ).toFixed(2)) / this.molCantidad).toFixed(2);
						precioUnitarioML = (((this.molPrecioRollo * laminasPosiblesACobrar ).toFixed(2)) / this.molCantidad);
	//					precioUnitarioML = (((this.molPrecioRollo * laminasPosiblesACobrar ).toFixed(2)));
	//					console.log(" p.u.> : " + precioUnitarioML);
					}
					
					
				}
				else
				{				
	//				console.log("No hay sobrante, se usa lámina completa");
	//				console.log("+++++ cobrar " + laminasPosiblesACobrar + " láminas");
	//				console.log("");
	//				console.log("Precio ML Lámina: " + this.molPrecioRollo);
					precioUnitarioML = (this.molPrecioRollo * laminasPosiblesACobrar).toFixed(2);
	//				console.log(" >>>> : " + precioUnitarioML);
					precioUnitarioML = (((this.molPrecioRollo * laminasPosiblesACobrar ).toFixed(2)) / this.molCantidad).toFixed(2);
	//				precioUnitarioML = (((this.molPrecioRollo * laminasPosiblesACobrar ).toFixed(2)) );
					// console.log(" p.u.> : " + precioUnitarioML);
				}
				
				var totalPrecioLaminas = (laminasPosiblesACobrar * this.molPrecioRollo).toFixed(2); 
				// console.log(" Precio Total Laminas (no pp ni ps): " + totalPrecioLaminas);
				
	//			if (this.molIdRolloV2 != 2 &&
	//					this.molIdRolloV2 != 9 &&
	//					this.molIdRolloV2 != 5 &&
	//					this.molIdRolloV2 != 13 &&
	//					this.molIdRolloV2 != 15 &&
	//					this.molIdRolloV2 != 19 &&
	//					this.molIdRolloV2 != 25 &&
	//					this.molIdRolloV2 != 26 &&
	//					this.molIdRolloV2 != 33 &&
	//					this.molIdRolloV2 != 35 &&
	//					this.molIdRolloV2 != 39)
				if (this.molIdRolloV2 != 2 &&
						this.molIdRolloV2 != 9 &&
						this.molIdRolloV2 != 5 &&					
						this.molIdRolloV2 != 19 &&
						this.molIdRolloV2 != 25 &&
						this.molIdRolloV2 != 26 )
				{
	//				this.molDividirLamina = 1;
					this.molPrecioADar = totalPrecioLaminas;
					// console.log(" no se divide precio ");
				}
				else
				{
					// console.log(" si se divide precio " );
					this.molPrecioADar = precioUnitarioML * this.molCantidad;
	//				this.molMoldurasXLaminas = 1;
				}
				
				if (this.molIsScrap)
				{
					// console.log (" *+*+ *+*+ SCRAP *+*+ *+*+ *+*+");
					this.molPrecioADar = (this.molTotalCMScrap * this.molPrecioCM) ;
				}
				
				// console.log("");
				// console.log("Precio a Dar: " + this.molPrecioADar);
							
	//			this.molPrecioMetroMoldura = Number(this.molPrecioADar) + this.molCostoCorte + (this.molCostoDobles * this.molDoblecesV2) ;
				this.molPrecioMetroMoldura = Number(this.molPrecioADar) / this.molCantidad;
	//			console.log(" molPrecioMetroMoldura: " + this.molPrecioMetroMoldura + " corte: " + this.molCostoCorte );
	//			this.molPrecioMetroMoldura = this.molPrecioADar ;
				
				
				// Calcular el sobrante para los pies 3 y 4
	//			var molXLaminas4Pies = 0;
	//			var molXLaminas3Pies = 0;
	//			var moldurasSueltas4Pies = 0;
	//			var moldurasSueltas3Pies = 0;
						
				this.molXLaminas3Pies =   Math.trunc( 91.44 / this.molDesarrolloV2);
	//			console.log("91.44 / this.molDesarrolloV2: " + this.molXLaminas3Pies);
				this.molXLaminas4Pies =   Math.trunc( 122 / this.molDesarrolloV2);	
	//			console.log("122 / this.molDesarrolloV2: " + this.molXLaminas4Pies);
				
				//calibres decimales
				this.molXLaminas376Pies =   Math.trunc( 114.6  / this.molDesarrolloV2);
				this.molXLaminas348Pies =   Math.trunc( 106.07 / this.molDesarrolloV2);
	
				
				
				
				this.moldurasSueltas3Pies = (this.molCantidad % this.molXLaminas3Pies);
	//			console.log("moldurassueleta3pies: " + this.moldurasSueltas3Pies);
				this.moldurasSueltas4Pies = (this.molCantidad % this.molXLaminas4Pies);
				
				this.moldurasSueltas376Pies = (this.molCantidad % this.molXLaminas376Pies);
				this.moldurasSueltas348Pies = (this.molCantidad % this.molXLaminas348Pies);
				
				this.molXLaminas3PiesAUsarCompletas = Math.ceil(this.molCantidad / this.molXLaminas3Pies) ;
				this.molXLaminas4PiesAUsarCompletas = Math.ceil(this.molCantidad / this.molXLaminas4Pies) ;
				
				this.molXLaminas376PiesAUsarCompletas = Math.ceil(this.molCantidad / this.molXLaminas376Pies) ;
				this.molXLaminas348PiesAUsarCompletas = Math.ceil(this.molCantidad / this.molXLaminas348Pies) ;
				
				this.molXLaminas3PiesAUsar = Math.trunc(this.molCantidad / this.molXLaminas3Pies) ;
				this.molXLaminas4PiesAUsar = Math.trunc(this.molCantidad / this.molXLaminas4Pies) ;
				
				this.molXLaminas376PiesAUsar = Math.trunc(this.molCantidad / this.molXLaminas376Pies) ;
				this.molXLaminas348PiesAUsar = Math.trunc(this.molCantidad / this.molXLaminas348Pies) ;
				
	//			if (this.molXLaminas3PiesAUsar == 0) this.molXLaminas3PiesAUsar = 1;
	//			if (this.molXLaminas4PiesAUsar == 0) this.molXLaminas4PiesAUsar = 1;
				
	//			var laminasPosiblesACobrar = Math.ceil(this.molCantidad / this.molMoldurasXLaminaTodos);
				
	//			molXLaminas3PiesAUsarCompletas: 0,
	//			molXLaminas4PiesAUsarCompletas: 0,
				
				this.molSobrante3Pies = 0;
				var aUsarPSPP = 0;
				var maxMolduraUsarPSPP = 0;
				
				this.molSobrante376Pies = 0;
				this.molSobrante348Pies = 0;
				
				if (this.moldurasSueltas3Pies > 0)
				{
	//				this.molSobrante3Pies = (91.44 - (this.moldurasSueltas3Pies * this.molDesarrolloV2));
					this.molSobrante3Pies = ( (91.44 - (this.molXLaminas3Pies * this.molDesarrolloV2)) * this.molXLaminas3PiesAUsar) + (91.44 - (this.moldurasSueltas3Pies * this.molDesarrolloV2));
					aUsarPSPP = this.moldurasSueltas3Pies * this.molDesarrolloV2;
					
	//				A usar calcular a Pies
					if (aUsarPSPP > 0 && aUsarPSPP <=15.24) //0.5 pies
					{
						maxMolduraUsarPSPP = 15.24;
					}
					else
					{
						if (aUsarPSPP > 15.24 && aUsarPSPP <=30.48) //1 pies
						{
							maxMolduraUsarPSPP = 30.48;
						}
						else
						{
							if (aUsarPSPP > 30.48 && aUsarPSPP <= 45.72) //1.5 pies
							{
								maxMolduraUsarPSPP = 45.72;
							}
							else
							{
								if (aUsarPSPP > 45.72 && aUsarPSPP <= 60.96) //2 pies
								{
									maxMolduraUsarPSPP = 60.96;
								}
								else
								{
									if (aUsarPSPP > 60.96 && aUsarPSPP <= 76.2) //2.5 pies
									{
										maxMolduraUsarPSPP = 76.2;
									}
									else
									{
										if (aUsarPSPP > 76.2 && aUsarPSPP <= 91.44) //2.5 pies
										{
											maxMolduraUsarPSPP = 91.44;
										}
										else
										{
											maxMolduraUsarPSPP = aUsarPSPP;
										}
									}
								}
							}
							
						}
					}
	//				A usar Calcular a Pies fin
					
					
					if ( (91.44 - aUsarPSPP) < 60 )
					{
						this.molSobrante3PiesPSPP = ( (91.44 - (this.molXLaminas3Pies * this.molDesarrolloV2)) * this.molXLaminas3PiesAUsar) + (91.44 - (this.moldurasSueltas3Pies * this.molDesarrolloV2));	
					}
					else
					{
						this.molSobrante3PiesPSPP = ( (91.44 - (this.molXLaminas3Pies * this.molDesarrolloV2)) * this.molXLaminas3PiesAUsar) + (maxMolduraUsarPSPP - (aUsarPSPP));
					}
					
				}
				else
				{
	//				this.molSobrante3Pies = (91.44 - (this.molXLaminas3Pies * this.molDesarrolloV2));
					this.molSobrante3Pies = ( (91.44 - (this.molXLaminas3Pies * this.molDesarrolloV2)) * this.molXLaminas3PiesAUsar);
					this.molSobrante3PiesPSPP = this.molSobrante3Pies;  
				}
				
				
				this.molSobrante4Pies = 0;
				if (this.moldurasSueltas4Pies > 0)
				{
	//				this.molSobrante4Pies = (122 - (this.moldurasSueltas4Pies * this.molDesarrolloV2));
					this.molSobrante4Pies = ( (122 - (this.molXLaminas4Pies * this.molDesarrolloV2)) * this.molXLaminas4PiesAUsar) + (122 - (this.moldurasSueltas4Pies * this.molDesarrolloV2));
					aUsarPSPP = this.moldurasSueltas4Pies * this.molDesarrolloV2;
					
	//				A usar calcular a Pies
					if (aUsarPSPP > 0 && aUsarPSPP <=15.24) //0.5 pies
					{
						maxMolduraUsarPSPP = 15.24;
					}
					else
					{
						if (aUsarPSPP > 15.24 && aUsarPSPP <=30.48) //1 pies
						{
							maxMolduraUsarPSPP = 30.48;
						}
						else
						{
							if (aUsarPSPP > 30.48 && aUsarPSPP <= 45.72) //1.5 pies
							{
								maxMolduraUsarPSPP = 45.72;
							}
							else
							{
								if (aUsarPSPP > 45.72 && aUsarPSPP <= 60.96) //2 pies
								{
									maxMolduraUsarPSPP = 60.96;
								}
								else
								{
									if (aUsarPSPP > 60.96 && aUsarPSPP <= 76.2) //2.5 pies
									{
										maxMolduraUsarPSPP = 76.2;
									}
									else
									{
										if (aUsarPSPP > 76.2 && aUsarPSPP <= 91.44) //2.5 pies
										{
											maxMolduraUsarPSPP = 91.44;
										}
										else
										{
											maxMolduraUsarPSPP = aUsarPSPP;
										}
									}
								}
							}
							
						}
					}
	//				A usar Calcular a Pies fin
					
					
					if ( (122 - aUsarPSPP) < 60 )
					{
						this.molSobrante4PiesPSPP = ( (122 - (this.molXLaminas4Pies * this.molDesarrolloV2)) * this.molXLaminas4PiesAUsar) + (122 - (this.moldurasSueltas4Pies * this.molDesarrolloV2));	
					}
					else
					{
						this.molSobrante4PiesPSPP = ( (122 - (this.molXLaminas4Pies * this.molDesarrolloV2)) * this.molXLaminas4PiesAUsar) + (maxMolduraUsarPSPP - (aUsarPSPP));
					}
					
	//				if ((122 - (this.moldurasSueltas4Pies * this.molDesarrolloV2)) < 60)
	//				{
	//					this.molSobrante4PiesPSPP = ( (122 - (this.molXLaminas4Pies * this.molDesarrolloV2)) * this.molXLaminas4PiesAUsar) + (122 - (this.moldurasSueltas4Pies * this.molDesarrolloV2));	
	//				}
	//				else
	//				{
	//					this.molSobrante4PiesPSPP = ( (122 - (this.molXLaminas4Pies * this.molDesarrolloV2)) * this.molXLaminas4PiesAUsar);
	//				}
					
				}
				else
				{
	//				this.molSobrante4Pies = (122 - (this.molXLaminas3Pies * this.molDesarrolloV2));
					this.molSobrante4Pies = ( (122 - (this.molXLaminas4Pies * this.molDesarrolloV2)) * this.molXLaminas4PiesAUsar);
					this.molSobrante4PiesPSPP = this.molSobrante4Pies; 
				}
				
				
				//con decimales los calibres
				if (this.moldurasSueltas376Pies > 0)
				{
	//				this.molSobrante3Pies = (91.44 - (this.moldurasSueltas3Pies * this.molDesarrolloV2));
					this.molSobrante376Pies = ( (114.6 - (this.molXLaminas376Pies * this.molDesarrolloV2)) * this.molXLaminas376PiesAUsar) + (114.6 - (this.moldurasSueltas376Pies * this.molDesarrolloV2));
					aUsarPSPP = this.moldurasSueltas376Pies * this.molDesarrolloV2;
					
	//				A usar calcular a Pies
					if (aUsarPSPP > 0 && aUsarPSPP <=15.24) //0.5 pies
					{
						maxMolduraUsarPSPP = 15.24;
					}
					else
					{
						if (aUsarPSPP > 15.24 && aUsarPSPP <=30.48) //1 pies
						{
							maxMolduraUsarPSPP = 30.48;
						}
						else
						{
							if (aUsarPSPP > 30.48 && aUsarPSPP <= 45.72) //1.5 pies
							{
								maxMolduraUsarPSPP = 45.72;
							}
							else
							{
								if (aUsarPSPP > 45.72 && aUsarPSPP <= 60.96) //2 pies
								{
									maxMolduraUsarPSPP = 60.96;
								}
								else
								{
									if (aUsarPSPP > 60.96 && aUsarPSPP <= 76.2) //2.5 pies
									{
										maxMolduraUsarPSPP = 76.2;
									}
									else
									{
										if (aUsarPSPP > 76.2 && aUsarPSPP <= 91.44) //2.5 pies
										{
											maxMolduraUsarPSPP = 91.44;
										}
										else
										{
											maxMolduraUsarPSPP = aUsarPSPP;
										}
									}
								}
							}
							
						}
					}
	//				A usar Calcular a Pies fin
					
					
					if ( (114.6 - aUsarPSPP) < 60 )
					{
						this.molSobrante376PiesESP = ( (114.6 - (this.molXLaminas376Pies * this.molDesarrolloV2)) * this.molXLaminas376PiesAUsar) + (114.6 - (this.moldurasSueltas376Pies * this.molDesarrolloV2));	
					}
					else
					{
						this.molSobrante376PiesESP = ( (114.6 - (this.molXLaminas376Pies * this.molDesarrolloV2)) * this.molXLaminas376PiesAUsar) + (maxMolduraUsarPSPP - (aUsarPSPP));
					}
					
				}
				else
				{
	//				this.molSobrante3Pies = (91.44 - (this.molXLaminas3Pies * this.molDesarrolloV2));
					this.molSobrante376Pies = ( (114.6 - (this.molXLaminas376Pies * this.molDesarrolloV2)) * this.molXLaminas376PiesAUsar);
					this.molSobrante376PiesESP = this.molSobrante376Pies;  
				}
				
				//3.48
				if (this.moldurasSueltas348Pies > 0)
				{
	//				this.molSobrante3Pies = (91.44 - (this.moldurasSueltas3Pies * this.molDesarrolloV2));
					this.molSobrante348Pies = ( (106.07 - (this.molXLaminas348Pies * this.molDesarrolloV2)) * this.molXLaminas348PiesAUsar) + (106.07 - (this.moldurasSueltas348Pies * this.molDesarrolloV2));
					aUsarPSPP = this.moldurasSueltas348Pies * this.molDesarrolloV2;
					
	//				A usar calcular a Pies
					if (aUsarPSPP > 0 && aUsarPSPP <=15.24) //0.5 pies
					{
						maxMolduraUsarPSPP = 15.24;
					}
					else
					{
						if (aUsarPSPP > 15.24 && aUsarPSPP <=30.48) //1 pies
						{
							maxMolduraUsarPSPP = 30.48;
						}
						else
						{
							if (aUsarPSPP > 30.48 && aUsarPSPP <= 45.72) //1.5 pies
							{
								maxMolduraUsarPSPP = 45.72;
							}
							else
							{
								if (aUsarPSPP > 45.72 && aUsarPSPP <= 60.96) //2 pies
								{
									maxMolduraUsarPSPP = 60.96;
								}
								else
								{
									if (aUsarPSPP > 60.96 && aUsarPSPP <= 76.2) //2.5 pies
									{
										maxMolduraUsarPSPP = 76.2;
									}
									else
									{
										if (aUsarPSPP > 76.2 && aUsarPSPP <= 91.44) //2.5 pies
										{
											maxMolduraUsarPSPP = 91.44;
										}
										else
										{
											maxMolduraUsarPSPP = aUsarPSPP;
										}
									}
								}
							}
							
						}
					}
	//				A usar Calcular a Pies fin
					
					
					if ( (106.07 - aUsarPSPP) < 60 )
					{
						this.molSobrante348PiesESP = ( (106.07 - (this.molXLaminas348Pies * this.molDesarrolloV2)) * this.molXLaminas348PiesAUsar) + (106.07 - (this.moldurasSueltas348Pies * this.molDesarrolloV2));	
					}
					else
					{
						this.molSobrante348PiesESP = ( (106.07 - (this.molXLaminas348Pies * this.molDesarrolloV2)) * this.molXLaminas348PiesAUsar) + (maxMolduraUsarPSPP - (aUsarPSPP));
					}
					
				}
				else
				{
	//				this.molSobrante3Pies = (91.44 - (this.molXLaminas3Pies * this.molDesarrolloV2));
					this.molSobrante348Pies = ( (106.07 - (this.molXLaminas348Pies * this.molDesarrolloV2)) * this.molXLaminas348PiesAUsar);
					this.molSobrante348PiesESP = this.molSobrante348Pies;  
				}
				
				
			},
	//		agregarMolduraAPedido: function()
	//		{
	//			var seguir = true;
	//			this.molError = "nrk";
	//			
	//			
	//			if (this.molIdRollo <= 1)
	//			{
	//				seguir = false;
	//				this.molError = this.molError + "<br>" + "Falta seleccionar Rollo.";
	//			}
	//			
	//			if (this.molDobleces == 0)
	//			{
	//				seguir = false;
	//				this.molError = this.molError + "<br>" + "Debe especificar dobleces.";
	//			}
	//			
	//			if (this.molPrecioADar <= 0 && !this.molIsMaquila)
	//			{
	//				seguir = false;
	//				this.molError = this.molError + "<br>" + "No se ha especificado un Rollo o no se cuenta con precio del mismo.";
	//			}
	//			
	////			alert("indexmoldura: "  + this.molIndexMoldura);
	//			if (seguir)
	//			{
	//				
	//				if (this.molIndexMoldura < 0)
	//				{
	//					if (!this.molIsMaquila)
	//					{
	//						this.listadoPedido.push(
	//								
	//								{
	//								    "idProducto": this.molIdProducto,
	//								    "codigo": "MOL",
	//								    "isMoldura": true,
	//								    "longitud": "",
	//								    "mlpieza": 0,
	//								    "idTipoProducto": "3",
	//								    "tipoProducto": "MOLDURA",
	//								    "shortTipoProducto": "M",
	//								    "idAplicacion": "1",
	//								    "aplicacion": "--NO APLICA--",
	//								    "idMaterial": this.molIdMaterial,
	//								    "material": "",
	//								    "tipoPrecioComision": "PRECIO",
	//								    "curva": "",
	//								    "idRollo": this.molIdRollo,
	//								    "rolloCodigo": "-- NO APLICA --",
	//								    "rolloIdMaterial": "1",
	//								    "rolloMaterial": "-- NO APLICA --",
	//								    "rolloShortMaterial": "NA",
	//								    "rolloIdProveedor": "1",
	//								    "rolloProveedor": "-- NO APLICA --",
	//								    "rolloShortProveedor": "NA",
	//								    "rolloCalibre": "0",
	//								    "rolloPies": "0",
	//								    "rolloPesokiloml": 0,
	//								    "rolloDescripcion": "",
	//								    "idUnidad": "1",
	//								    "unidad": "METRO LINEAL",
	//								    "shortUnidad": "ML",
	//								    "calibre": this.molCalibre,
	//								    "descripcion": "MOLDURA",
	//								    "existencia": "0",
	//								    "tipoPrecio": "G",
	//								    "isRango": "0",
	//								    "tipoRango": "0",
	//								    "isRollo": "0",
	//								    "precio1": this.molPrecioMetroMoldura,
	//								    "precio2": "0",
	//								    "precio3": "0",
	//								    "estado": "ACTIVO",
	//								    "existenciaEstimada": "0",
	//								    "fullDescripcion": "MOLDURA - " +  this.molDescripcion,
	//								    "fullDescripcionCode": "MOLDURA - " +  this.molDescripcion,
	//								    "cantidad": this.molCantidad,
	//								    "lblUnidad": "Metros Lineales",
	//								    "cantUnidad": this.molCantUnidad,
	//								    "cantUnidadReal": this.molCantUnidad,
	//								    "dobleces": this.molDobleces,
	//								    "precioRenglon": 0,
	//								    "rangoRenglon": 1,
	//								    "totalRenglon": 0,
	//								    "desarrolloI": "0",
	//								    "desarrolloT": this.molDesarrollo,
	//								    "debug": "",
	//								    "kl": 0,
	//								    "productoCantidadDisponible": true,
	//								    "molPrecioLamina": this.molPrecioADar,
	//			                        "molMoldurasXLamina": this.molMoldurasXLaminas,
	//			                        "molLaminasCobrar": 1,
	//			                        "molLaminasATomar": 1,
	//			                        "molMoldurasXLaminaTodos": this.molMoldurasXLaminaTodos 
	//								  }
	//								
	//								
	//						);
	//					}
	//					else
	//					{
	//						this.listadoPedido.push(
	//								
	//								{
	//								    "idProducto": this.molIdMaquila,
	//								    "codigo": "MAQ",
	//								    "isMoldura": true,
	//								    "longitud": "",
	//								    "mlpieza": 0,
	//								    "idTipoProducto": "3",
	//								    "tipoProducto": "MAQUILA",
	//								    "shortTipoProducto": "MQ",
	//								    "idAplicacion": "1",
	//								    "aplicacion": "--NO APLICA--",
	//								    "idMaterial": this.molIdMaterial,
	//								    "material": "",
	//								    "tipoPrecioComision": "PRECIO",
	//								    "curva": "",
	//								    "idRollo": this.molIdRollo,
	//								    "rolloCodigo": "-- NO APLICA --",
	//								    "rolloIdMaterial": "1",
	//								    "rolloMaterial": "-- NO APLICA --",
	//								    "rolloShortMaterial": "NA",
	//								    "rolloIdProveedor": "1",
	//								    "rolloProveedor": "-- NO APLICA --",
	//								    "rolloShortProveedor": "NA",
	//								    "rolloCalibre": "0",
	//								    "rolloPies": "0",
	//								    "rolloPesokiloml": 0,
	//								    "rolloDescripcion": "",
	//								    "idUnidad": "1",
	//								    "unidad": "METRO LINEAL",
	//								    "shortUnidad": "ML",
	//								    "calibre": this.molCalibre,
	//								    "descripcion": "MAQUILA",
	//								    "existencia": "0",
	//								    "tipoPrecio": "G",
	//								    "isRango": "0",
	//								    "tipoRango": "0",
	//								    "isRollo": "0",
	//								    "precio1": this.molPrecioMetroMoldura,
	//								    "precio2": "0",
	//								    "precio3": "0",
	//								    "estado": "ACTIVO",
	//								    "existenciaEstimada": "0",
	//								    "fullDescripcion": "MAQUILA - " +  this.molDescripcion,
	//								    "fullDescripcionCode": "MAQUILA - " +  this.molDescripcion,
	//								    "cantidad": this.molCantidad,
	//								    "lblUnidad": "Metros Lineales",
	//								    "cantUnidad": this.molCantUnidad,
	//								    "cantUnidadReal": this.molCantUnidad,
	//								    "dobleces": this.molDobleces,
	//								    "precioRenglon": 0,
	//								    "rangoRenglon": 1,
	//								    "totalRenglon": 0,
	//								    "desarrolloI": "0",
	//								    "desarrolloT": this.molDesarrollo,
	//								    "debug": "",
	//								    "kl": 0,
	//								    "productoCantidadDisponible": true,
	//								    "molPrecioLamina": this.molPrecioADar,
	//			                        "molMoldurasXLamina": this.molMoldurasXLaminas,
	//			                        "molLaminasCobrar": 1,
	//			                        "molLaminasATomar": 1,
	//			                        "molMoldurasXLaminaTodos": this.molMoldurasXLaminaTodos 
	//								  }
	//								
	//								
	//						);
	//					}
	//					
	//				}
	//				else
	//				{
	////					alert("actualizamos el precio tambien "+ this.listadoPedido[this.molIndexMoldura].cantUnidadReal = this.molPrecioMetroMoldura;);
	//					
	//					if (!this.molIsMaquila)
	//					{
	//						this.listadoPedido[this.molIndexMoldura].cantidad = this.molCantidad;
	//						this.listadoPedido[this.molIndexMoldura].cantUnidad = this.molCantUnidad;
	//						this.listadoPedido[this.molIndexMoldura].cantUnidadReal = this.molCantUnidad;
	//						this.listadoPedido[this.molIndexMoldura].precio1 = this.molPrecioMetroMoldura;
	//						
	//						this.listadoPedido[this.molIndexMoldura].molPrecioLamina = this.molPrecioADar;
	//						this.listadoPedido[this.molIndexMoldura].molMoldurasXLamina = this.molMoldurasXLaminas;
	//						
	//						this.listadoPedido[this.molIndexMoldura].molMoldurasXLaminaTodos = this.molMoldurasXLaminaTodos;
	//						
	//						
	//						this.listadoPedido[this.molIndexMoldura].fullDescripcion = "MOLDURA - " +  this.molDescripcion
	//						this.listadoPedido[this.molIndexMoldura].fullDescripcionCode = "MOLDURA - " +  this.molDescripcion;
	//						
	//					    		    
	//					    this.listadoPedido[this.molIndexMoldura].desarrolloT = this.molDesarrollo;
	//					    
	//					    this.listadoPedido[this.molIndexMoldura].dobleces = this.molDobleces;
	//					    
	//					    this.listadoPedido[this.molIndexMoldura].idRollo = this.molIdRollo;	
	//					}	
	//					else
	//					{
	//						this.listadoPedido[this.molIndexMoldura].cantidad = this.molCantidad;
	//						this.listadoPedido[this.molIndexMoldura].cantUnidad = this.molCantUnidad;
	//						this.listadoPedido[this.molIndexMoldura].cantUnidadReal = this.molCantUnidad;
	//						this.listadoPedido[this.molIndexMoldura].precio1 = this.molPrecioMetroMoldura;
	//						
	//						this.listadoPedido[this.molIndexMoldura].molPrecioLamina = this.molPrecioADar;
	//						this.listadoPedido[this.molIndexMoldura].molMoldurasXLamina = this.molMoldurasXLaminas;
	//						
	//						this.listadoPedido[this.molIndexMoldura].molMoldurasXLaminaTodos = this.molMoldurasXLaminaTodos;
	//						
	//						
	//						this.listadoPedido[this.molIndexMoldura].fullDescripcion = "MAQUILA - " +  this.molDescripcion
	//						this.listadoPedido[this.molIndexMoldura].fullDescripcionCode = "MAQUILA - " +  this.molDescripcion;
	//						
	//					    		    
	//					    this.listadoPedido[this.molIndexMoldura].desarrolloT = this.molDesarrollo;
	//					    
	//					    this.listadoPedido[this.molIndexMoldura].dobleces = this.molDobleces;
	//					    
	//					    this.listadoPedido[this.molIndexMoldura].idRollo = this.molIdRollo;
	//					}
	//					
	//					
	//				    $("#modalAgregarMoldura").modal('toggle');
	//				}
	//				
	//				
	////				$("#modalAgregarMoldura").modal('toggle');
	//				this.molMsgAgregarMasMolduras = true;
	//				setTimeout(function(){ app.calculaTotales(); }, 100);
	//				
	//			}
	//			
	//			
	//			
	//			
	//			this.molError = this.molError.replace("nrk<br>", "");
	//			this.molError = this.molError.replace("nrk", "");
	//			
	//		},
			agregarMolduraAPedidoV2: function(usemodal = true)
			{
				var seguir = true;
				this.molError = "nrk";
				
				
	//			if (this.molIdRolloV2 <= 1 && !this.molIsMaquila)
	//			{
	//				seguir = false;
	//				this.molError = this.molError + "<br>" + "Falta seleccionar Rollo.";
	//			}
	
				if (this.molIsScrap && this.molTotalCMScrap < this.molDesarrolloV2)
				{
					seguir = false;
					this.molError = this.molError + "<br>" + "Scrap debe ser mayor o igual al Ancho.";
				}
				
				if (this.molCantUnidad > 6.1 )
				{
					seguir = false;
					this.molError = this.molError + "<br>" + "Metros Lineales debe ser menor o igual a 6.1.";
				}
			
				
				if (this.molDesarrolloV2 <= 0 )
					{
						seguir = false;
						this.molError = this.molError + "<br>" + "Indique Desarrollo.";
					}
				
				if (this.molDoblecesV2 == 0)
				{
					seguir = false;
					this.molError = this.molError + "<br>" + "Debe especificar dobleces.";
				}
				
				if (!this.molIsMaquila)
				{
					if (this.molIdRolloV2 <= 1 && !this.molIsMaquila)
					{
						seguir = false;
						this.molError = this.molError + "<br>" + "Falta seleccionar Rollo.";
					}
					
				}
				else
				{
					if (this.molCalibreV2 == '0')
					{
						seguir = false;
						this.molError = this.molError + "<br>" + "Debe seleccionar el Calibre.";
					}
					
					if (this.molIdMaterialV2 == '0')
					{
						seguir = false;
						this.molError = this.molError + "<br>" + "Debe seleccionar el Material.";
					}
					
					
				}
				
				
				
				if (this.molIsScrap)
				{
					if (this.molTotalCMScrap <= 0)
					{
						seguir = false;
						this.molError = this.molError + "<br>" + "Debe especificar la Longitud a utilizar de Scrap.";
					}
				}
				else
				{
					if (this.molPrecioADar <= 0 && !this.molIsMaquila)
					{
						seguir = false;
						this.molError = this.molError + "<br>" + "No se ha especificado un Rollo o no se cuenta con precio del mismo.";
					}
				}
				
	//			console.log("this.molPrecioMetroMoldura: " + this.molPrecioMetroMoldura );
	//			console.log("this.molPrecioADar: " + this.molPrecioADar );
	//			alert("indexmoldura: "  + this.molIndexMoldura);
				if (seguir)
				{
					
					if (this.molIndexMoldura < 0)
					{
						if (!this.molIsMaquila)
						{
							this.listadoPedido.push(
									
									{
										"idProducto": this.molIdProducto,
										"codigo": "MOL",
										"isMoldura": true,
										"longitud": "",
										"mlpieza": 0,
										"idTipoProducto": "3",
										"tipoProducto": "MOLDURA",
										"shortTipoProducto": "M",
										"idAplicacion": "1",
										"aplicacion": "--NO APLICA--",
										"idMaterial": this.molIdMaterial,
										"material": "",
										"tipoPrecioComision": "PRECIO",
										"curva": "",
										"idRollo": this.molIdRolloV2,
										"rolloCodigo": "-- NO APLICA --",
										"rolloIdMaterial": "1",
										"rolloMaterial": "-- NO APLICA --",
										"rolloShortMaterial": "NA",
										"rolloIdProveedor": "1",
										"rolloProveedor": "-- NO APLICA --",
										"rolloShortProveedor": "NA",
										"rolloCalibre": "0",
										"rolloPies": "0",
										"rolloPesokiloml": 0,
										"rolloDescripcion": "",
										"idUnidad": "1",
										"unidad": "METRO LINEAL",
										"shortUnidad": "ML",
										"calibre": this.molCalibre,
										"descripcion": "MOLDURA",
										"existencia": "0",
										"tipoPrecio": "G",
										"isRango": "0",
										"tipoRango": "0",
										"isRollo": "0",
										"precio1": this.molPrecioMetroMoldura,
										"precio2": "0",
										"precio3": "0",
										"preciomendez": this.molPrecioMetroMoldura,
										"estado": "ACTIVO",
										"existenciaEstimada": "0",
										"fullDescripcion": "MOLDURA - " +  this.molDescripcion,
										"fullDescripcionCode": "MOLDURA - " +  this.molDescripcion,
										"cantidad": this.molCantidad,
										"lblUnidad": "Metros Lineales",
										"cantUnidad": this.molCantUnidad,
										"cantUnidadReal": this.molCantUnidad,
										"dobleces": this.molDoblecesV2,
										"precioRenglon": 0,
										"rangoRenglon": 1,
										"totalRenglon": 0,
										"desarrolloI": "0",
										"desarrolloT": this.molDesarrolloV2,
										"debug": "",
										"kl": 0,
										"productoCantidadDisponible": true,
										"molPrecioLamina": this.molPrecioADar,
										"molMoldurasXLamina": this.molMoldurasXLaminas,
										"molLaminasCobrar": 1,
										"molLaminasATomar": 1,
										"molMoldurasXLaminaTodos": this.molMoldurasXLaminaTodos,
										"molCorte": this.molCostoCorte,
										"molDobles": this.molCostoDobles,
										"molIsScrap": this.molIsScrap,
										"molTotalCMScrap": this.molTotalCMScrap,
										"molLongitudinal": this.molLongitudinal,
										"sugerirStock": [],
										"inventarioSucursal": [],
										"idPedidoDetalle": 0
									  }
									
									
							);
						}
						else
						{
							this.setDescripcionMaquila();
							
							
							this.listadoPedido.push(
									
									{
										"idProducto": this.molIdMaquila,
										"codigo": "MAQ",
										"isMoldura": true,
										"longitud": "",
										"mlpieza": 0,
										"idTipoProducto": "3",
										"tipoProducto": "MAQUILA",
										"shortTipoProducto": "MQ",
										"idAplicacion": "1",
										"aplicacion": "--NO APLICA--",
										"idMaterial": this.molIdMaterial,
										"material": "",
										"tipoPrecioComision": "PRECIO",
										"curva": "",
										"idRollo": this.molIdRolloV2,
										"rolloCodigo": "-- NO APLICA --",
										"rolloIdMaterial": this.molIdMaterialV2,
										"rolloMaterial": "-- NO APLICA --",
										"rolloShortMaterial": "NA",
										"rolloIdProveedor": "1",
										"rolloProveedor": "-- NO APLICA --",
										"rolloShortProveedor": "NA",
										"rolloCalibre": this.molCalibre,
										"rolloPies": "0",
										"rolloPesokiloml": 0,
										"rolloDescripcion": "",
										"idUnidad": "1",
										"unidad": "METRO LINEAL",
										"shortUnidad": "ML",
										"calibre": this.molCalibre,
										"descripcion": "MAQUILA",
										"existencia": "0",
										"tipoPrecio": "G",
										"isRango": "0",
										"tipoRango": "0",
										"isRollo": "0",
										"precio1": this.molPrecioMetroMoldura,
										"precio2": "0",
										"precio3": "0",
										"preciomendez": this.molPrecioMetroMoldura,
										"estado": "ACTIVO",
										"existenciaEstimada": "0",
										"fullDescripcion": "MAQUILA - " +  this.molDescripcion,
										"fullDescripcionCode": "MAQUILA - " +  this.molDescripcion,
										"cantidad": this.molCantidad,
										"lblUnidad": "Metros Lineales",
										"cantUnidad": this.molCantUnidad,
										"cantUnidadReal": this.molCantUnidad,
										"dobleces": this.molDoblecesV2,
										"precioRenglon": 0,
										"rangoRenglon": 1,
										"totalRenglon": 0,
										"desarrolloI": "0",
										"desarrolloT": this.molDesarrolloV2,
										"debug": "",
										"kl": 0,
										"productoCantidadDisponible": true,
										"molPrecioLamina": this.molPrecioADar,
										"molMoldurasXLamina": this.molMoldurasXLaminas,
										"molLaminasCobrar": 1,
										"molLaminasATomar": 1,
										"molMoldurasXLaminaTodos": this.molMoldurasXLaminaTodos,
										"molCorte": this.molCostoCorteMaquila,
										"molDobles": this.molCostoDoblesMaquila,
										"molIsScrap": this.molIsScrap,
										"molTotalCMScrap": this.molTotalCMScrap,
										"molLongitudinal": this.molLongitudinal,
										"sugerirStock": [],
										"inventarioSucursal": [],
										"idPedidoDetalle": 0
									  }
									
									
							);
						}
						
						toastr.success('Producto Enlistado','Pedido');
					}
					else
					{
	//					alert("actualizamos el precio tambien "+ this.listadoPedido[this.molIndexMoldura].cantUnidadReal = this.molPrecioMetroMoldura;);
						
						if (!this.molIsMaquila)
						{
							this.listadoPedido[this.molIndexMoldura].cantidad = this.molCantidad;
							this.listadoPedido[this.molIndexMoldura].cantUnidad = this.molCantUnidad;
							this.listadoPedido[this.molIndexMoldura].cantUnidadReal = this.molCantUnidad;
							this.listadoPedido[this.molIndexMoldura].precio1 = this.molPrecioMetroMoldura;
							this.listadoPedido[this.molIndexMoldura].preciomendez = this.molPrecioMetroMoldura;
							
							this.listadoPedido[this.molIndexMoldura].molPrecioLamina = this.molPrecioADar;
							this.listadoPedido[this.molIndexMoldura].molMoldurasXLamina = this.molMoldurasXLaminas;
							
							this.listadoPedido[this.molIndexMoldura].molMoldurasXLaminaTodos = this.molMoldurasXLaminaTodos;
							
							this.listadoPedido[this.molIndexMoldura].molCorte = this.molCostoCorte;
							this.listadoPedido[this.molIndexMoldura].molDobles = this.molCostoDobles;
							
							this.listadoPedido[this.molIndexMoldura].molIsScrap = this.molIsScrap;
							this.listadoPedido[this.molIndexMoldura].molTotalCMScrap = this.molTotalCMScrap;
							this.listadoPedido[this.molIndexMoldura].molLongitudinal = this.molLongitudinal;
							
							this.listadoPedido[this.molIndexMoldura].fullDescripcion = "MOLDURA - " +  this.molDescripcion
							this.listadoPedido[this.molIndexMoldura].fullDescripcionCode = "MOLDURA - " +  this.molDescripcion;
							
										
							this.listadoPedido[this.molIndexMoldura].desarrolloT = this.molDesarrolloV2;
							
							this.listadoPedido[this.molIndexMoldura].dobleces = this.molDoblecesV2;
							
							this.listadoPedido[this.molIndexMoldura].idRollo = this.molIdRolloV2;	
						}	
						else
						{
							
							this.setDescripcionMaquila();
							
							
							this.listadoPedido[this.molIndexMoldura].cantidad = this.molCantidad;
							this.listadoPedido[this.molIndexMoldura].cantUnidad = this.molCantUnidad;
							this.listadoPedido[this.molIndexMoldura].cantUnidadReal = this.molCantUnidad;
							this.listadoPedido[this.molIndexMoldura].precio1 = this.molPrecioMetroMoldura;
							this.listadoPedido[this.molIndexMoldura].preciomendez = this.molPrecioMetroMoldura;
							
							this.listadoPedido[this.molIndexMoldura].molPrecioLamina = this.molPrecioADar;
							this.listadoPedido[this.molIndexMoldura].molMoldurasXLamina = this.molMoldurasXLaminas;
							
							this.listadoPedido[this.molIndexMoldura].molMoldurasXLaminaTodos = this.molMoldurasXLaminaTodos;
							
							this.listadoPedido[this.molIndexMoldura].molCorte = this.molCostoCorteMaquila;
							this.listadoPedido[this.molIndexMoldura].molDobles = this.molCostoDoblesMaquila;
							
							this.listadoPedido[this.molIndexMoldura].rolloIdMaterial = this.molIdMaterialV2;
							this.listadoPedido[this.molIndexMoldura].rolloCalibre = this.molCalibreV2;
							
							this.listadoPedido[this.molIndexMoldura].rolloCalibre = this.molCalibre;
							this.listadoPedido[this.molIndexMoldura].calibre = this.molCalibre;
							
							this.listadoPedido[this.molIndexMoldura].molIsScrap = this.molIsScrap;
							this.listadoPedido[this.molIndexMoldura].molTotalCMScrap = this.molTotalCMScrap;
							this.listadoPedido[this.molIndexMoldura].molLongitudinal = this.molLongitudinal;
							
							
							this.listadoPedido[this.molIndexMoldura].fullDescripcion = "MAQUILA - " +  this.molDescripcion
							this.listadoPedido[this.molIndexMoldura].fullDescripcionCode = "MAQUILA - " +  this.molDescripcion;
							
										
							this.listadoPedido[this.molIndexMoldura].desarrolloT = this.molDesarrolloV2;
							
							this.listadoPedido[this.molIndexMoldura].dobleces = this.molDoblecesV2;
							
							this.listadoPedido[this.molIndexMoldura].idRollo = this.molIdRolloV2;
						}
						
						
						if (usemodal) $("#modalAgregarMolduraV2").modal('toggle');
						
						toastr.success('Producto Modificado','Pedido');
					}
					
					
	//				$("#modalAgregarMoldura").modal('toggle');
					this.molMsgAgregarMasMolduras = true;
					setTimeout(function(){ app.calculaTotales(); }, 100);
					
				}
				
				
				
				
				this.molError = this.molError.replace("nrk<br>", "");
				this.molError = this.molError.replace("nrk", "");
				
			},
			setDescripcionMaquila: function ()
			{			
				this.molDescripcion = "";
				if (this.molIdMaterialV2 == 5)
				{
					this.molDescripcion = " GALVANIZADO ";
				}
				else
				{
					if (this.molIdMaterialV2 == 27)
					{
						this.molDescripcion = " NEGRA ";
					}
					else
					{
						if (this.molIdMaterialV2 == 13)
						{
							this.molDescripcion = " PINTRO POLIESTER";
						}
						else
						{
							if (this.molIdMaterialV2 == 2)
							{
								this.molDescripcion = " PINTRO SULTANA ";
							}
							else
							{
								if (this.molIdMaterialV2 == 4)
								{
									this.molDescripcion = " ZINTRO ALUM ";
								}
								else
								{
									this.molDescripcion = "";
								}
							}
						}
					}
				}
				
				this.molDescripcion = this.molDescripcion + " CAL " + this.molCalibreV2;
				
				this.molDescripcion = this.molDescripcion.replace("\"", "´´");
				this.molDescripcion = this.molDescripcion.replace("  ", " ");
				
			},
	//		updateMoldura: function(index){
	//			this.limpiarModalMoldura();
	//			
	//			this.molTextoBotonAddMoldura = 'Actualizar Moldura';
	//			this.molTextoBotonCancelAddMoldura = 'Cancelar';
	//			
	//			this.molCantidad = this.listadoPedido[index].cantidad;
	//			this.molCantUnidad = this.listadoPedido[index].cantUnidad;
	//			
	//			
	//			
	//		    		    
	//		    setTimeout(function(){ console.log("ponemos desarrollo " + app.listadoPedido[index].desarrolloT); app.molDesarrollo = app.listadoPedido[index].desarrolloT; }, 100);
	//		    
	//		    setTimeout(function(){ console.log("ponemos dobleces " + app.listadoPedido[index].dobleces);  app.molDobleces = app.listadoPedido[index].dobleces; } , 150);
	//		    
	//		    setTimeout(function(){ console.log("ponemor rollo " + app.listadoPedido[index].idRollo); app.molIdRollo = app.listadoPedido[index].idRollo;}, 200);
	//			
	//		    
	//		    this.molIndexMoldura = index;
	////		    alert("poniendo molIndexMoldura: " + index);
	//		    
	//			$("#modalAgregarMoldura").modal();
	//		},
	//		updateMaquila: function(index){
	//			this.limpiarModalMoldura();
	//			
	//			this.molTextoBotonAddMoldura = 'Actualizar Maquila';
	//			this.molTextoBotonCancelAddMoldura = 'Cancelar';
	//			
	//			this.molCantidad = this.listadoPedido[index].cantidad;
	//			this.molCantUnidad = this.listadoPedido[index].cantUnidad;
	//			
	//			this.molIsMaquila = true;
	//			
	//		    		    
	//		    setTimeout(function(){ console.log("ponemos desarrollo " + app.listadoPedido[index].desarrolloT); app.molDesarrollo = app.listadoPedido[index].desarrolloT; }, 100);
	//		    
	//		    setTimeout(function(){ console.log("ponemos dobleces " + app.listadoPedido[index].dobleces);  app.molDobleces = app.listadoPedido[index].dobleces; } , 150);
	//		    
	//		    setTimeout(function(){ console.log("ponemor rollo " + app.listadoPedido[index].idRollo); app.molIdRollo = app.listadoPedido[index].idRollo;}, 200);
	//		    
	//		    
	//			
	//		    
	//		    this.molIndexMoldura = index;
	////		    alert("poniendo molIndexMoldura: " + index);
	//		    
	//			$("#modalAgregarMoldura").modal();
	//		},
			updateMolduraV2: function(index, usemodal = true){
				this.limpiarModalMoldura();
				
				this.molTextoBotonAddMoldura = 'Actualizar Moldura';
				this.molTextoBotonCancelAddMoldura = 'Cancelar';
				
				this.molCantidad = this.listadoPedido[index].cantidad;
				this.molCantUnidad = this.listadoPedido[index].cantUnidad;
				
				
				
							
				setTimeout(function(){ console.log("ponemos desarrollo " + app.listadoPedido[index].desarrolloT); app.molDesarrolloV2 = app.listadoPedido[index].desarrolloT; }, 100);
				
				setTimeout(function(){ console.log("ponemos dobleces " + app.listadoPedido[index].dobleces);  app.molDoblecesV2 = app.listadoPedido[index].dobleces; } , 150);
	
				setTimeout(function(){ console.log("ponemos molCalibreFiltroRollo " + app.listadoPedido[index].calibre);  app.molCalibreFiltroRollo = app.listadoPedido[index].calibre; } , 175);
	
				setTimeout(function(){ console.log("ponemos molMaterialFiltroRollo " + app.listadoPedido[index].idMaterial);  app.molMaterialFiltroRollo = app.listadoPedido[index].idMaterial; } , 190);
	
				setTimeout(function(){ console.log("ponemos molCalibreV2 " + app.listadoPedido[index].calibre);  app.molCalibreV2 = app.listadoPedido[index].calibre; } , 175);
				setTimeout(function(){ console.log("ponemos molMaterialFiltroRollo " + app.listadoPedido[index].idMaterial);  app.molIdMaterialV2 = app.listadoPedido[index].idMaterial; } , 190);
	
				
				
				
				
				setTimeout(function(){ console.log("ponemor rollo " + app.listadoPedido[index].idRollo); app.molIdRolloV2 = app.listadoPedido[index].idRollo;}, 200);
				
				setTimeout(function(){ console.log("ponemos isscrap " + app.listadoPedido[index].molIsScrap); app.molIsScrap = app.listadoPedido[index].molIsScrap;}, 250);
				
				setTimeout(function(){ console.log("ponemos totalcmscrap " + app.listadoPedido[index].molTotalCMScrap); app.molTotalCMScrap = app.listadoPedido[index].molTotalCMScrap;}, 300);
				
				this.molIndexMoldura = index;
				// alert("poniendo molIndexMoldura: " + index);
				
				if (usemodal) $("#modalAgregarMolduraV2").modal();
			},
			updateMaquilaV2: function(index, usemodal = true){
				this.limpiarModalMoldura();
				
				this.molTextoBotonAddMoldura = 'Actualizar Maquila';
				this.molTextoBotonCancelAddMoldura = 'Cancelar';
				
				this.molCantidad = this.listadoPedido[index].cantidad;
				this.molCantUnidad = this.listadoPedido[index].cantUnidad;
				
				this.molIsMaquila = true;
				
							
				setTimeout(function(){ console.log("ponemos desarrollo " + app.listadoPedido[index].desarrolloT); app.molDesarrolloV2 = app.listadoPedido[index].desarrolloT; }, 100);
				
				setTimeout(function(){ console.log("ponemos dobleces " + app.listadoPedido[index].dobleces);  app.molDoblecesV2 = app.listadoPedido[index].dobleces; } , 150);
				
	//		    setTimeout(function(){ console.log("ponemor rollo " + app.listadoPedido[index].idRollo); app.molIdRolloV2 = app.listadoPedido[index].idRollo;}, 200);
				setTimeout(function(){ console.log("ponemor rolloCalibre " + app.listadoPedido[index].rolloCalibre); app.molCalibreV2 = app.listadoPedido[index].rolloCalibre;}, 200);
				
				setTimeout(function(){ console.log("ponemor rolloIdMaterial " + app.listadoPedido[index].rolloIdMaterial); app.molIdMaterialV2 = app.listadoPedido[index].rolloIdMaterial;}, 220);
				
				setTimeout(function(){ console.log("ponemos isscrap " + app.listadoPedido[index].molIsScrap); app.molIsScrap = app.listadoPedido[index].molIsScrap;}, 250);
				
				setTimeout(function(){ console.log("ponemos totalcmscrap " + app.listadoPedido[index].molTotalCMScrap); app.molTotalCMScrap = app.listadoPedido[index].molTotalCMScrap;}, 300);
				
				
				this.molIndexMoldura = index;
	//		    alert("poniendo molIndexMoldura: " + index);
				
				if (usemodal) $("#modalAgregarMolduraV2").modal();
			},
			limpiarModalMoldura: function(){
				this.molIndexMoldura = -1;
				this.molCantidad = 1;
				this.molMoldurasXLaminas = 1;
				
				this.molMoldurasXLaminaTodos = 1;
				this.molCantUnidad = 3.05;
	//			console.log("limpia de desarrollo");
				this.molDesarrollo = '0';
				this.molDesarrolloV2 = '0';
				this.molIdRollo = 0;
				this.molIdRolloV2 = 0;
				this.molDescripcion = '' ;
				this.molDobleces = 1;
				this.molDoblecesV2 = 1;
				this.molPiesXDesarrollo = 0;
				this.molPies = 0;
				this.molPiesXDesarrolloSugerido = 0;
				this.molCalibre = '0';
				this.molCalibreV2 = '0';
				this.molIdMaterialV2 = '0';
				this.molLongitudinal = 'L';
				this.molIncluirCorte = true;
				
				this.molDividirLamina = 1;
				
				this.molIsScrap = false;
				this.molTotalCMScrap = 0;
				
				this.molIsMaquila = false;
							
				this.molStrTemp = '';
				
				this.molPrecioRollo = 0;
				this.molPrecioADar = 0;
				this.molPrecioCM = 0;
				this.molPrecioMetroMoldura = 0;
				this.molIdMaterial = 0;
				this.molCostoCorte = 10;
				this.molCostoDobles = 10;
				
				this.molCostoCorteMaquila = 11;
				this.molCostoDoblesMaquila = 11;
				
				this.molError = '';
				this.molMsgAgregarMasMolduras = false;
				
				this.molTextoBotonAddMoldura = 'Agregar Moldura a Pedido';
				this.molTextoBotonCancelAddMoldura = 'Dejar de Capturar Molduras';
				
			},
			agregarOtrosGastos: function(){
				$("#modalOtrosCargos").modal();
			},
			quitarOtrosCargos: function(){
				var i = 0;
				
				for (i = 0; i < this.otrosCargos.length ; i++)
				{				
					this.otrosCargos[i].cantidad = '';
					this.otrosCargos[i].monto = 0;
				}
			},
			aceptaOtrosCargos: function(){
	//			alert("quitamos modal cargos");
				$("#modalOtrosCargos").modal('toggle');
			},
			curvarProducto: function(index){
				this.curvaIndexListado = index;
				this.curvaActual = this.listadoPedido[this.curvaIndexListado].curva;
				
				$("#modalCurvar").modal();
			},
			setCurva: function(curva){
				$("#modalCurvar").modal('toggle');			
				this.listadoPedido[this.curvaIndexListado].curva = curva;
				this.curvaIndexListado = -1;
				this.calculaTotales();
			},
			quitarCurvaAProducto: function(index){
				this.listadoPedido[index].curva = '';
				this.calculaTotales();
			},
			updateToCurrentPrices: function(index){
				// console.log("updateToCurrentPrices: " + index);
				var indexAux = 0 ;
	
				for (indexAux = 0 ; indexAux < this.productos.length ; indexAux ++)
				{
					if (this.productos[indexAux].idProducto === this.listadoPedido[index].idProducto)
					{
						this.listadoPedido[index].precio1 = this.productos[indexAux].precio1;
						this.listadoPedido[index].precio2 = this.productos[indexAux].precio2;
						this.listadoPedido[index].precio3 = this.productos[indexAux].precio3;
						this.listadoPedido[index].preciomendez = this.productos[indexAux].preciomendez;
						break;
					}
				}
	
	
				var item = this.listadoPedido[index];
	
				if (!item.isMoldura)
				{
					//updateProductoLista
					//enlistaProductoDeModal
					this.updateProductoLista(index, false);
					setTimeout (function() { 
						app.enlistaProductoDeModal(false); 
						// console.log("actualizando row (enlistaProductoDeModal): " + index);
					}, 200);
				}
				else
				{
					if (item.idProducto == this.molIdProducto)
					{
						//updateMolduraV2 wait 300
						//agregarMolduraAPedidoV2
						
						this.updateMolduraV2(index, false);
						setTimeout (function() { 
							app.agregarMolduraAPedidoV2(false); 
							// console.log("actualizando row (agregarMolduraAPedidoV2): " + index);
						}, 200);
						
						
	
						// alert("es una moldura");
					}
					else if(item.idProducto == this.molIdMaquila)
					{
						//updateMaquilaV2
						//agregarMolduraAPedidoV2
						this.updateMaquilaV2(index, false);
						setTimeout (function() { 
							app.agregarMolduraAPedidoV2(false); 
							// console.log("actualizando row (agregarMolduraAPedidoV2): " + index); 
						}, 200);
					}
	
				}
	
				// setTimeout (function() { 
				// 	// alert ("Vamos a verificar si hay stock");
				// 	app.verificaSiHayStock(index);
				// }, 400);
			},
			updateIndividualToCurrentPrices: function(index){
				mdlShowWait();
				mdlStatusWait("Actualizando Cotización");
				
	
	// 			this.updateMolduraV2(index, false);
				
	// 			setTimeout (function() { 
	// 			this.agregarMolduraAPedidoV2(false); 
	// }, 400);
	
					setTimeout(function(i){
						mdlStatusWait("Actualizando Cotización Renglon " + (i + 1));
						// console.log("++Inicio re calcula con nuevos precios row: " + i);
						app.updateToCurrentPrices(i);
						// console.log("--Fin re calcula con nuevos precios row: " + i);
	
					}, 150, index);
				
	
				setTimeout (function() { mdlExitWait(); }, 500 + 550);
			},
			updateAllToCurrentPrices: function(preactualizar = true){
				var i = 0;
	
				mdlShowWait();
				mdlStatusWait("Actualizando Cotización");
				for (i = 0 ; i < this.listadoPedido.length ; i++)
				{
					setTimeout(function(index){
						mdlStatusWait("Actualizando Cotización Renglon " + (index + 1));
						// console.log("++Inicio re calcula con nuevos precios row: " + index);
						app.updateToCurrentPrices(index);
						// console.log("--Fin re calcula con nuevos precios row: " + index);
	
					}, (i+1)*450, i);
				}
	
				setTimeout (function() {  app.RDDebeActualizarPrecios = false; app.RDPreciosActualizados = true; }, 500 + (550 * this.listadoPedido.length));

				setTimeout (function() { mdlExitWait(); 
						
						if (preactualizar) app.preActualizarPedido(false, false) 
					}, 700 + (550 * this.listadoPedido.length));

				
			},
			refreshInventarioSucursal: function(){
				// var i = 0;
				// // console.log("refrescando Inventario Sucursal");
				// for (i = 0 ; i < this.listadoPedido.length ; i++)
				// {
				// 	setTimeout (function(index) { 
				// 		// alert ("Vamos a verificar si hay stock");
				// 		app.verificaSiHayStock(index);
				// 	}, (i+1)*100, i);			
				// }
			},
			compare_item: function(a, b){
					// a should come before b in the sorted order
					if(a.value < b.value){
							return -1;
					// a should come after b in the sorted order
					}else if(a.value > b.value){
							return 1;
					// and and b are the same
					}else{
							return 0;
					}
			},
			compare_mlpieza: function(a, b){
					// a should come before b in the sorted order
					if(a.mlpieza < b.mlpieza){
							return -1;
					// a should come after b in the sorted order
					}else if(a.mlpieza > b.mlpieza){
							return 1;
					// and and b are the same
					}else{
							return 0;
					}
			},
			compare_qty: function(a, b){
				// a should come before b in the sorted order
				if(a.qty < b.qty){
						return -1;
				// a should come after b in the sorted order
				}else if(a.qty > b.qty){
						return 1;
				// a and b are the same
				}else{
						return 0;
				}
			},
			saveCookie: function(){
				var i = 0;
	
				// lstAcanalados: [],
				var arrAcanalados = []
				for (let i = 0; i < this.lstAcanalados.length; i++) {
					
					// console.log(this.lstAcanalados[i]);
					if (this.lstAcanalados[i].checked == true)
					{
						arrAcanalados.push(this.lstAcanalados[i].id);
					}
					
				}
							
				if (arrAcanalados.join() != "")
				{
					setCookie(this.cookieAcanalados, arrAcanalados.join());
				}
				else
				{
					eraseCookie(this.cookieAcanalados);
				}
	
				// lstMateriales: [],
				var arrMateriales = []
				for (let i = 0; i < this.lstMateriales.length; i++) {
					
					// console.log(this.lstMateriales[i]);
					if (this.lstMateriales[i].checked == true)
					{
						arrMateriales.push(this.lstMateriales[i].id);
					}
					
				}
	
				// console.log(arrMateriales.join());
				if (arrMateriales.join() != "")
				{
					setCookie(this.cookieMateriales, arrMateriales.join());
				}
				else
				{
					eraseCookie(this.cookieMateriales);
				}
	
				// lstCalibres: [],
				var arrCalibres = []
				for (let i = 0; i < this.lstCalibres.length; i++) {
					
					// console.log(this.lstCalibres[i]);
					if (this.lstCalibres[i].checked == true)
					{
						arrCalibres.push(this.lstCalibres[i].id);
					}
					
				}
	
				// console.log(arrCalibres.join());
				if (arrCalibres.join() != "")
				{
					setCookie(this.cookieCalibres, arrCalibres.join());
				}
				else
				{
					eraseCookie(this.cookieCalibres);
				}
	
				// lstEspesores: [],
				var arrEspesores = []
				for (let i = 0; i < this.lstEspesores.length; i++) {
					
					// console.log(this.lstEspesores[i]);
					if (this.lstEspesores[i].checked == true)
					{
						arrEspesores.push(this.lstEspesores[i].id);
					}
					
				}
	
				// console.log(arrEspesores.join());
				if (arrEspesores.join() != "")
				{
					setCookie(this.cookieEspesores, arrEspesores.join());
				}
				else
				{
					eraseCookie(this.cookieEspesores);
				}
	
				// lstProveedores: [],
				var arrProveedores = []
				for (let i = 0; i < this.lstProveedores.length; i++) {
					
					// console.log(this.lstProveedores[i]);
					if (this.lstProveedores[i].checked == true)
					{
						arrProveedores.push(this.lstProveedores[i].id);
					}
					
				}
	
				// console.log(arrProveedores.join());
				if (arrProveedores.join() != "")
				{
					setCookie(this.cookieProveedores, arrProveedores.join());
				}
				else
				{
					eraseCookie(this.cookieProveedores);
				}
	
	
				//----------------------------------------------
	
				// lstAcanaladosComer: [],
				var arrAcanaladosComer = []
				for (let i = 0; i < this.lstAcanaladosComer.length; i++) {
					
					// console.log(this.lstAcanaladosComer[i]);
					if (this.lstAcanaladosComer[i].checked == true)
					{
						arrAcanaladosComer.push(this.lstAcanaladosComer[i].id);
					}
					
				}
							
				if (arrAcanaladosComer.join() != "")
				{
					setCookie(this.cookieAcanaladosComer, arrAcanaladosComer.join());
				}
				else
				{
					eraseCookie(this.cookieAcanaladosComer);
				}
	
				// lstMaterialesComer: [],
				var arrMaterialesComer = []
				for (let i = 0; i < this.lstMaterialesComer.length; i++) {
					
					// console.log(this.lstMaterialesComer[i]);
					if (this.lstMaterialesComer[i].checked == true)
					{
						arrMaterialesComer.push(this.lstMaterialesComer[i].id);
					}
					
				}
	
				// console.log(arrMaterialesComer.join());
				if (arrMaterialesComer.join() != "")
				{
					setCookie(this.cookieMaterialesComer, arrMaterialesComer.join());
				}
				else
				{
					eraseCookie(this.cookieMaterialesComer);
				}
	
				// lstCalibresComer: [],
				var arrCalibresComer = []
				for (let i = 0; i < this.lstCalibresComer.length; i++) {
					
					// console.log(this.lstCalibresComer[i]);
					if (this.lstCalibresComer[i].checked == true)
					{
						arrCalibresComer.push(this.lstCalibresComer[i].id);
					}
					
				}
	
				// console.log(arrCalibresComer.join());
				if (arrCalibresComer.join() != "")
				{
					setCookie(this.cookieCalibresComer, arrCalibresComer.join());
				}
				else
				{
					eraseCookie(this.cookieCalibresComer);
				}
	
				setCookie("expandedAcanalados", this.expandedAcanalados);
				setCookie("expandedMateriales", this.expandedMateriales);
				setCookie("expandedCalibres", this.expandedCalibres);
				setCookie("expandedEspesores", this.expandedEspesores);
				setCookie("expandedProveedores", this.expandedProveedores);
				setCookie("filtroAccesorios", this.filtroAccesorios);
				setCookie("filtroMasVendidos", this.filtroMasVendidos);
				setCookie("filtroFavoritos", this.filtroFavoritos);
	
				setCookie("expandedAcanaladosComer", this.expandedAcanaladosComer);
				setCookie("expandedMaterialesComer", this.expandedMaterialesComer);
				setCookie("expandedCalibresComer", this.expandedCalibresComer);
				
			},
			readCookie: function(){
				var i = 0;
	
				//lstAcanalados: [],
				
				if (getCookie(this.cookieAcanalados) != null){
					arrAcanalados = getCookie(this.cookieAcanalados).split(',').map(function(item) {
										return parseInt(item, 10);
									});
					// console.log(arrAcanalados);
					// console.log("arrAcanalados.length " + arrAcanalados.length);
					for (let i = 0; i < arrAcanalados.length; i++) {
						
						var index = this.lstAcanalados.findIndex(x => x.id == arrAcanalados[i]);
						// console.log(arrAcanalados[i] +  " " + index);
						this.lstAcanalados[index].checked = true;								
					}
				}
	
				// lstMateriales: [],					
	
				if (getCookie(this.cookieMateriales) != null){
					arrMateriales = getCookie(this.cookieMateriales).split(',').map(function(item) {
									return parseInt(item, 10);
								});
					// console.log(arrMateriales)
					for (let i = 0; i < arrMateriales.length; i++) {
						
						var index = this.lstMateriales.findIndex(x => x.id == arrMateriales[i]);
						// console.log(arrMateriales[i] +  " " + index);
						this.lstMateriales[index].checked = true;								
					}
				}
	
				// console.log(" this.lstMateriales: " + this.lstMateriales.length)
				// this.lstMateriales.forEach(x => console.log(x))
				// console.log("     ")
	
	
				// lstCalibres: [],
				// console.log(getCookie(this.cookieCalibres));
				if (getCookie(this.cookieCalibres) != null){
					arrCalibres = getCookie(this.cookieCalibres).split(',').map(function(item) {
										return parseInt(item, 10);
									});
	
					for (let i = 0; i < arrCalibres.length; i++) {
						
						var index = this.lstCalibres.findIndex(x => x.id == arrCalibres[i]);
						// console.log(arrCalibres[i] +  " " + index);
						this.lstCalibres[index].checked = true;								
					}
				}
	
				// lstEspesores: [],
				// console.log(getCookie(this.cookieEspesores));
				if (getCookie(this.cookieEspesores) != null){
					arrEspesores = getCookie(this.cookieEspesores).split(',').map(function(item) {
										return parseFloat(item);
									});
	
					for (let i = 0; i < arrEspesores.length; i++) {
						
						var index = this.lstEspesores.findIndex(x => x.id == arrEspesores[i]);
						console.log(arrEspesores[i] +  " " + index);
						this.lstEspesores[index].checked = true;								
					}
				}
	
				// lstProveedores: [],
				// console.log(getCookie(this.cookieProveedores));
				if (getCookie(this.cookieProveedores)){
					arrProveedores = getCookie(this.cookieProveedores).split(',').map(function(item) {
										return parseInt(item, 10);
									});
	
					for (let i = 0; i < arrProveedores.length; i++) {
						
						var index = this.lstProveedores.findIndex(x => x.id == arrProveedores[i]);
						// console.log(arrProveedores[i] +  " " + index);
						this.lstProveedores[index].checked = true;								
					}
				}
	
				//lstAcanaladosComer: [],
				
				if (getCookie(this.cookieAcanaladosComer) != null){
					arrAcanaladosComer = getCookie(this.cookieAcanaladosComer).split(',').map(function(item) {
										return parseInt(item, 10);
									});
					// console.log(arrAcanaladosComer);
					// console.log("arrAcanaladosComer.length " + arrAcanaladosComer.length);
					for (let i = 0; i < arrAcanaladosComer.length; i++) {
						
						var index = this.lstAcanaladosComer.findIndex(x => x.id == arrAcanaladosComer[i]);
						// console.log(arrAcanaladosComer[i] +  " " + index);
						this.lstAcanaladosComer[index].checked = true;								
					}
				}
	
				// lstMaterialesComer: [],					
	
				if (getCookie(this.cookieMaterialesComer) != null){
					arrMaterialesComer = getCookie(this.cookieMaterialesComer).split(',').map(function(item) {
									return parseInt(item, 10);
								});
	
					for (let i = 0; i < arrMaterialesComer.length; i++) {
						
						var index = this.lstMaterialesComer.findIndex(x => x.id == arrMaterialesComer[i]);
						// console.log(arrMaterialesComer[i] +  " " + index);
						this.lstMaterialesComer[index].checked = true;								
					}
				}
	
	
				// lstCalibresComer: [],
				// console.log(getCookie(this.cookieCalibresComer));
				if (getCookie(this.cookieCalibresComer) != null){
					arrCalibresComer = getCookie(this.cookieCalibresComer).split(',').map(function(item) {
										return parseInt(item, 10);
									});
	
					for (let i = 0; i < arrCalibresComer.length; i++) {
						
						var index = this.lstCalibresComer.findIndex(x => x.id == arrCalibresComer[i]);
						// console.log(arrCalibresComer[i] +  " " + index);
						this.lstCalibresComer[index].checked = true;								
					}
				}
	
				
				if (getCookie("expandedAcanalados") == null)
				{
					this.expandedAcanalados = true;
					this.expandedMateriales = true;
					this.expandedCalibres = true;
					this.expandedEspesores = true;
					this.expandedProveedores = true;
					this.expandedAcanaladosComer = true;
					this.expandedMaterialesComer = true;
					this.expandedCalibresComer = true;
				}
				else
				{
					this.expandedAcanalados = getCookie("expandedAcanalados");
					this.expandedMateriales = getCookie("expandedMateriales");
					this.expandedCalibres = getCookie("expandedCalibres");
					this.expandedEspesores = getCookie("expandedEspesores");
					this.expandedProveedores = getCookie("expandedProveedores");
					this.expandedAcanaladosComer = getCookie("expandedAcanaladosComer");
					this.expandedMaterialesComer = getCookie("expandedMaterialesComer");
					this.expandedCalibresComer = getCookie("expandedCalibresComer");
				}
	
				if (getCookie("filtroAccesorios") != null)
				{
					this.filtroAccesorios = getCookie("filtroAccesorios");
				}
	
				if (getCookie("filtroMasVendidos") != null)
				{
					this.filtroMasVendidos = getCookie("filtroMasVendidos");
				}
	
				if (getCookie("filtroFavoritos") != null)
				{
					this.filtroFavoritos = getCookie("filtroFavoritos");
				}
				
				
			},
			selectAll: function(list){
	
				var arr = null;
	
				switch(list){
					case "Acanalado":
						arr = this.lstAcanalados;
						break;
					case "Material":
						arr = this.lstMateriales;
						break;
					case "Calibre":
						arr = this.lstCalibres;
						break;
					case "Ancho":
						arr = this.lstEspesores;
						break;
					case "Proveedor":
						arr = this.lstProveedores;
						break;
					case "AcanaladoComer":
						arr = this.lstAcanaladosComer;
						break;
					case "MaterialComer":
						arr = this.lstMaterialesComer;
						break;
					case "CalibreComer":
						arr = this.lstCalibresComer;
						break;
					case "MedidaEspecialComer":
						arr = this.lstMedidaEspecialComer;
						break;
						
				}
	
				if (arr != null)
				{				
					arr.forEach(element => element.checked = true);
				}
			},
			unselectAll: function(list){
				var arr = null;
	
				switch(list){
					case "Acanalado":
						arr = this.lstAcanalados;
						break;
					case "Material":
						arr = this.lstMateriales;
						break;
					case "Calibre":
						arr = this.lstCalibres;
						break;
					case "Ancho":
						arr = this.lstEspesores;
						break;
					case "Proveedor":
						arr = this.lstProveedores;
						break;
					case "AcanaladoComer":
						arr = this.lstAcanaladosComer;
						break;
					case "MaterialComer":
						arr = this.lstMaterialesComer;
						break;
					case "CalibreComer":
						arr = this.lstCalibresComer;
						break;
					case "MedidaEspecialComer":
						arr = this.lstMedidaEspecialComer;
						break;
				}
	
				if (arr != null)
				{
					arr.forEach(element => element.checked = false);
				}
	
			},
			selectorLaminaMetalica: function(){
	
	
				if (!this.seleccionarLaminaMetalica)
				{
					if (this.seleccionarAccesorios){
						this.saveCookie();
						this.selectorAccesorios();
					}
	
					if (this.seleccionarComercializados){
						this.saveCookie();
						this.selectorComercializados();
					}
	
					if (this.seleccionarMasVendidos){
						this.saveCookie();
						this.selectorMasVendidos();
					}
	
					if (this.seleccionarFavoritos){
						this.saveCookie();
						this.selectorFavoritos();
					}
	
					this.seleccionarLaminaMetalica = true;
	
					setTimeout(function(){$('#tblProductosFiltradosLamina').footable();},50);
					
					$('#tableroSeleccionarLaminaMetalica').removeAttr('class').attr('class', '');
					var animation = 'shake'
					$('#tableroSeleccionarLaminaMetalica').addClass('ibox m-l-sm m-r-l');
					$('#tableroSeleccionarLaminaMetalica').addClass('animated');
					$('#tableroSeleccionarLaminaMetalica').addClass(animation);
				}
				else
				{
					
					$('#tableroSeleccionarLaminaMetalica').removeAttr('class').attr('class', '');
					var animation = 'fadeOut'
					$('#tableroSeleccionarLaminaMetalica').addClass('ibox m-l-sm m-r-l');
					$('#tableroSeleccionarLaminaMetalica').addClass('animated');
					$('#tableroSeleccionarLaminaMetalica').addClass(animation);
					
					setTimeout(function() { app.seleccionarLaminaMetalica = false;}, 20);
					this.saveCookie();
				}
			},
			selectorComercializados: function(){
	
	
				if (!this.seleccionarComercializados)
				{
					if (this.seleccionarAccesorios){
						this.saveCookie();
						this.selectorAccesorios();
					}
	
					if (this.seleccionarLaminaMetalica){
						this.saveCookie();
						this.selectorLaminaMetalica();
					}
	
					if (this.seleccionarMasVendidos){
						this.saveCookie();
						this.selectorMasVendidos();
					}
	
					if (this.seleccionarFavoritos){
						this.saveCookie();
						this.selectorFavoritos();
					}
	
					this.seleccionarComercializados = true;
	
					setTimeout(function(){$('#tblProductosFiltradosComercializados').footable();},50);
					
					$('#tableroSeleccionarComercializados').removeAttr('class').attr('class', '');
					var animation = 'shake'
					$('#tableroSeleccionarComercializados').addClass('ibox m-l-sm m-r-l');
					$('#tableroSeleccionarComercializados').addClass('animated');
					$('#tableroSeleccionarComercializados').addClass(animation);
				}
				else
				{
					
					$('#tableroSeleccionarComercializados').removeAttr('class').attr('class', '');
					var animation = 'fadeOut'
					$('#tableroSeleccionarComercializados').addClass('ibox m-l-sm m-r-l');
					$('#tableroSeleccionarComercializados').addClass('animated');
					$('#tableroSeleccionarComercializados').addClass(animation);
					
					this.seleccionarComercializados = false;
					this.saveCookie();
				}
			},
			selectorAccesorios: function(){
	
	
				if (!this.seleccionarAccesorios)
				{
					if (this.seleccionarLaminaMetalica){
						this.saveCookie();
						this.selectorLaminaMetalica();
					}
	
					if (this.seleccionarComercializados){
						this.saveCookie();
						this.selectorComercializados();
					}
	
					if (this.seleccionarMasVendidos){
						this.saveCookie();
						this.selectorMasVendidos();
					}
	
					if (this.seleccionarFavoritos){
						this.saveCookie();
						this.selectorFavoritos();
					}
	
					this.seleccionarAccesorios = true;
	
					setTimeout(function(){$('#tblProductosFiltradosAccesorios').footable();},50);
					
					$('#tableroSeleccionarAccesorios').removeAttr('class').attr('class', '');
					var animation = 'shake'
					$('#tableroSeleccionarAccesorios').addClass('ibox m-l-sm m-r-l');
					$('#tableroSeleccionarAccesorios').addClass('animated');
					$('#tableroSeleccionarAccesorios').addClass(animation);
				}
				else
				{
					
					$('#tableroSeleccionarAccesorios').removeAttr('class').attr('class', '');
					var animation = 'fadeOut'
					$('#tableroSeleccionarAccesorios').addClass('ibox m-l-sm m-r-l');
					$('#tableroSeleccionarAccesorios').addClass('animated');
					$('#tableroSeleccionarAccesorios').addClass(animation);
					
					
					setTimeout(function() { app.seleccionarAccesorios = false;}, 20);
					this.saveCookie();
				}
			},
			selectorMasVendidos: function(){
	
	
				if (!this.seleccionarMasVendidos)
				{
					if (this.seleccionarLaminaMetalica){
						this.saveCookie();
						this.selectorLaminaMetalica();
					}
	
					if (this.seleccionarComercializados){
						this.saveCookie();
						this.selectorComercializados();
					}
	
					if (this.seleccionarAccesorios){
						this.saveCookie();
						this.selectorAccesorios();
					}
	
					if (this.seleccionarFavoritos){
						this.saveCookie();
						this.selectorFavoritos();
					}
	
					this.seleccionarMasVendidos = true;
	
					setTimeout(function(){$('#tblProductosFiltradosMasVendidos').footable();},50);
					
					$('#tableroSeleccionarMasVendidos').removeAttr('class').attr('class', '');
					var animation = 'shake'
					$('#tableroSeleccionarMasVendidos').addClass('ibox m-l-sm m-r-l');
					$('#tableroSeleccionarMasVendidos').addClass('animated');
					$('#tableroSeleccionarMasVendidos').addClass(animation);
				}
				else
				{
					
					$('#tableroSeleccionarMasVendidos').removeAttr('class').attr('class', '');
					var animation = 'fadeOut'
					$('#tableroSeleccionarMasVendidos').addClass('ibox m-l-sm m-r-l');
					$('#tableroSeleccionarMasVendidos').addClass('animated');
					$('#tableroSeleccionarMasVendidos').addClass(animation);
					
					
					setTimeout(function() { app.seleccionarMasVendidos = false;}, 20);
					this.saveCookie();
				}
			},
			selectorFavoritos: function(){
	
	
				if (!this.seleccionarFavoritos)
				{
					if (this.seleccionarLaminaMetalica){
						this.saveCookie();
						this.selectorLaminaMetalica();
					}
	
					if (this.seleccionarComercializados){
						this.saveCookie();
						this.selectorComercializados();
					}
	
					if (this.seleccionarAccesorios){
						this.saveCookie();
						this.selectorAccesorios();
					}
	
					if (this.seleccionarMasVendidos){
						this.saveCookie();
						this.selectorMasVendidos();
					}
	
					this.seleccionarFavoritos = true;
	
					setTimeout(function(){$('#tblProductosFiltradosFavoritos').footable();},50);
					
					$('#tableroSeleccionarFavoritos').removeAttr('class').attr('class', '');
					var animation = 'shake'
					$('#tableroSeleccionarFavoritos').addClass('ibox m-l-sm m-r-l');
					$('#tableroSeleccionarFavoritos').addClass('animated');
					$('#tableroSeleccionarFavoritos').addClass(animation);
				}
				else
				{
					
					$('#tableroSeleccionarFavoritos').removeAttr('class').attr('class', '');
					var animation = 'fadeOut'
					$('#tableroSeleccionarFavoritos').addClass('ibox m-l-sm m-r-l');
					$('#tableroSeleccionarFavoritos').addClass('animated');
					$('#tableroSeleccionarFavoritos').addClass(animation);
					
					
					setTimeout(function() { app.seleccionarFavoritos = false;}, 20);
					this.saveCookie();
				}
			},
			testAcanalado: function(){
	
				var a = this.lstAcanalados.filter(function(a){
						return a.checked;
					}).map(function(item) {
									return parseInt(item.id, 10);
								});
				console.log(a);
			},
			agruparProductosComercializados: function(){
				// productosNuevoFiltroComercializados: [],
				// productosNuevoFiltroComercializadosAgruped: [],
	
				var index = -1;
				var i = 0;
	
				for (let i = 0; i < this.productosNuevoFiltroComercializados.length; i++) {
					const element = this.productosNuevoFiltroComercializados[i];
	
					index = -1;
					index = this.productosNuevoFiltroComercializadosAgruped.findIndex(x => x.idAplicacion == element.idAplicacion &&
																					   x.idMaterial == element.idMaterial &&
																					   x.rolloCalibre == element.rolloCalibre &&
																					   x.rolloPies == element.rolloPies &&
																					   x.medidaespecial == element.medidaespecial);
					
					if (index < 0){
						this.productosNuevoFiltroComercializadosAgruped.push({
							idAplicacion: element.idAplicacion,
							idMaterial: element.idMaterial,
							rolloCalibre: element.rolloCalibre,
							rolloPies: element.rolloPies,
							medidaespecial: element.medidaespecial,
							fullDescripcion: element.fullDescripcion.replace(' ' + element.longitud + ' ', '').replace(' ' + element.mlpieza + ' ', '').replace('  ', ' ').replace('  ', ' '),
							productos: []
						});
						index = this.productosNuevoFiltroComercializadosAgruped.findIndex(x => x.idAplicacion == element.idAplicacion &&
																					   x.idMaterial == element.idMaterial &&
																					   x.rolloCalibre == element.rolloCalibre &&
																					   x.rolloPies == element.rolloPies &&
																					   x.medidaespecial == element.medidaespecial);
					}
	
					this.productosNuevoFiltroComercializadosAgruped[index].productos.push(element);
	
				}
	
				for (let i = 0; i < this.productosNuevoFiltroComercializadosAgruped.length; i++) {
					this.productosNuevoFiltroComercializadosAgruped[i].productos.sort(this.compare_mlpieza);
					
				}
	
				
			},
			addRemoveFromFavoritos: function(idProducto, favorito){
				if (favorito == 'NO')
				{
					xajax_handleProductoFavorito(idProducto, 'SI');
					this.reserProductoFavorito(idProducto, 'SI');
					toastr.info('Producto Agregado de Mis Favoritos.','Favoritos');
					// alert("vamos a quitarlo");
				}
				else
				{
					xajax_handleProductoFavorito(idProducto, 'NO');
					this.reserProductoFavorito(idProducto, 'NO');
					toastr.info('Producto Removido de Mis Favoritos.','Favoritos');
					// alert("vamos a ponerlo");
				}
	
				this.cargarProductosFavoritos();
	
			},
			reserProductoFavorito: function(idProducto, favorito){
				
				var i = -1;
	
				// productos: [],
				
				i = this.productos.findIndex(x => x.idProducto == idProducto);
	
				if (i >= 0)
				{
					this.productos[i].favorito = favorito;
				}
	
				// productosNuevoFiltro: [],
				
				i = this.productosNuevoFiltro.findIndex(x => x.idProducto == idProducto);
	
				if (i >= 0)
				{
					this.productosNuevoFiltro[i].favorito = favorito;
				}
	
				// productosNuevoFiltroComercializados: [],
				// productosNuevoFiltroComercializadosAgruped: [],
				i = -1;
				
				for (let i = 0; i < this.productosNuevoFiltroComercializadosAgruped.length; i++) {
					var index = -1;
	
					index = this.productosNuevoFiltroComercializadosAgruped[i].productos.findIndex(x => x.idProducto == idProducto);
	
					if (index >= 0)
					{
						this.productosNuevoFiltroComercializadosAgruped[i].productos[index].favorito = favorito;
					}	
					
				}
				
	
				
				// productosNuevoFiltroAccesorios: [],
				i = -1;
				i = this.productosNuevoFiltroAccesorios.findIndex(x => x.idProducto == idProducto);
	
				if (i >= 0)
				{
					this.productosNuevoFiltroAccesorios[i].favorito = favorito;
				}
	
				// productosNuevoFiltroMasVendidos: [],
				i = -1;
				i = this.productosNuevoFiltroMasVendidos.findIndex(x => x.idProducto == idProducto);
	
				if (i >= 0)
				{
					this.productosNuevoFiltroMasVendidos[i].favorito = favorito;
				}
	
				// productosNuevoFiltroFavoritos: [],
	
	
				// listadoPedido: [],
				
				for (let i = 0; i < this.listadoPedido.length; i++) {
					var index = -1;
	
					if (this.listadoPedido[i].idProducto == idProducto)
					{
						this.listadoPedido[i].favorito = favorito;
					}	
					
				}
				
	
			},
			desbloquearPedido: function(){
				// alert("desbloquear");
				xajax_desbloquearPedido(this.pedidoFolio);
			}
			
	
	
	//		limpiaDatos: function(){
	//			this.idAplicacion = 0;
	//			this.nombreAplicacion = '';
	//
	//		},
	//		limpiaErrores: function(){
	//			this.errNombreAplicacion = '';
	//
	//		},
	//		fnRegresarAListado: function(){
	//			window.location = URL_BASE + "aplicacion";
	//		}
		}
	
	});
	
	$(document).ready(function(){
		
	//	xajax_saludar();
		
	//	$('#app').css("background", "black");
		
		$('#dtFechaEntrega').datepicker({
			todayBtn: "linked",
			keyboardNavigation: false,
			forceParse: false,
			calendarWeeks: true,
			autoclose: true,
			format: 'dd/mm/yyyy'
		});
		
	//	$('#dtFechaEntrega2').datepicker({
	//	    todayBtn: "linked",
	//	    keyboardNavigation: false,
	//	    forceParse: false,
	//	    calendarWeeks: true,
	//	    autoclose: true,
	//	    format: 'dd/mm/yyyy'
	//	});
	
		$('.clockpicker').clockpicker();
		
		$("#collapseLeftMenu").click();	
	
	
	});
	