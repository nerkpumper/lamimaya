
var app = new Vue({
	el: '#app',
	data: {
		idPedido: '',
		seleccionarPedido: true,
		mostrandoVale: false,
		clicks: 0,
		idSucursal: 0,
		
		errCrearValeSalida: '',
		
		filtroNoRollo: '',
		
		idValeSalidaPromotorSeleccionado: 0,
		idValeSalidaSeleccionado: 0,
		sucursalValeSalidaSeleccionado: '',
		auxAunNo: '',
		generarValeSalida: '',
		

		//chkRecibeDinero
		chkRecibeDinero: false,
		chkRecibeDineroAux: false,

		//pagovsentrega
		chkPagoVSEntrega: false,
		chkPagoVSEntregaAux: false,
		yaimpreso: 'SI',
		pedidoSaldoTotalMas30Dias: 0,
		
		//pedido
		pedidoSubtotal: 0,
		pedidoOtrosCargos: 0,
		pedidoTotal: 0,
		pedidoSaldo: 0,
		pedidoSaldoTotal: 0,
		pedidoSaldoEntregados: 0,
		pedidoCliente: '',
		promoNombre: '',
		vendeNombre: '',
		cteCredito: 0,
		cteCapacidadPago: 0,
		pedidoSurtiraCompleto: false,
		//ChecklistVale
		
		estado: '',
		//consignacion
        personaEntrega: '',
        recogeentrega: '',
        domicilioEntrega: '',
        numeroEntrega: '',
        coloniaEntrega: '',
        ciudadEntrega: '',
        fechaEntrega: '',
        horaEntrega: 'NOSEL',
        
        keepInfoEntregaVale: true,
        
        personaEntregaAux: '',
        recogeentregaAux: '',
        domicilioEntregaAux: '',
        numeroEntregaAux: '',
        coloniaEntregaAux: '',
        ciudadEntregaAux: '',
        fechaEntregaAux: '',
        horaEntregaAux: 'NOSEL',
        
        personaEntregaErr: '',
        recogeentregaErr: '',
        domicilioEntregaErr: '',
        numeroEntregaErr: '',
        coloniaEntregaErr: '',
        ciudadEntregaErr: '',
        fechaEntregaErr: '',
        
        tipoObra: '',
        fechaEntregaPorDefinir: '',
        
        fechaAbierta: '',
		
//		Permitir vale
		chkPedidoSaldado: 'NO',
		chkDireccionCorrecta: false,
		chkDiaCorrecto: false,
		chkHorarioCorrecto: false,
		chkEquipoListo: false,
		chkPersonaCorrecta: false,
		chkHayEspacio: false,
		aunno: '',
		
		chkImprimirPedidoNoSaldado: false,
		
		//fin ChecklistVale
		
//		nrNoRolloSeleccionado: false,
//		nrIdRemisionRollo: 0,
//		nrCodigoRollo: '',
//		nrNoRollo: '',
//		nrRollo: '',
//		nrKilos: 0,
//		nrCalibre: 0,
//		nrPies: 0,
//		nrExistencia: 0,
//		nrAlmacen: '',
//		nrAlmacenOriginal: '',
//		nrIdPedidoObra: 0,
//		nrIdRegistroProduccion: 0,
//		nrKilosMaquilados: 0,
//		nrTotalML: 0,
//		nrTerminado: 'NO',
//		nrSucursalRollo: 0,
//		nrFactor: 0,
//		nrRendimiento: 0,
		
		//////////////
		
		valeSalidaTotal: 0,
		
		
		
		
		
		pedidoEstado: '',
		pedidoRecogeEngrega: '',
		pedidoDespieceTerminado: '',
		pedidoColocado: '',
		
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
		
		valessalida: [],
		
		rollosParaAnadir: [],
		
		mercanciaSinVale: [],
		mercanciaEnVale: [],
		itemsVale: [],
		
	},
	mounted: function(){
		
//		setTimeout(function () { app.cargarRollosEnObra();}, 200);
//		
	},
	computed: {
		saldoCredito: function(){
			return (this.cteCredito - this.pedidoSaldoEntregados) ;
		},
		saldoCapacidadPago: function(){
			return (this.cteCapacidadPago - this.pedidoSaldoEntregados) ;
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
		chkPagoVSEntrega: function(val)		{

			if(this.loadingVS)
			{
				return;  
			}



			if (val)
			{
				if (this.recogeentrega == 'RECOGE')
				{
						swal({
						title: "¿Está seguro?",
						text: "¿ESTAS DE ACUERDO EN ASUMIR EL COMPROMISO DE LIBERAR EL VALE DE SALIDA, ASUMIRÁS TÚ EL COMPROMISO DE LA LIQUIDACIÓN DEL MISMO?",
						type: "warning",
						showCancelButton: true,
						confirmButtonColor: "#DD6B55",
						confirmButtonText: "SI, ESTOY DE ACUERDO!",
						cancelButtonText: "NO",
						closeOnConfirm: true
					}, function (inputValue) {

						if (inputValue === true)
						{
							mdlShowWait();
							xajax_pagoVSEntrega(app.idValeSalidaSeleccionado, true, app.recogeentrega);
							// app.chkPagoVSEntregaAux = true;						

						}
						else
						{
							app.chkPagoVSEntrega = false;
						}
		
					});
				}
				else
				{
					swal({
						title: "¿Está seguro?",
						text: "¿ESTAS DE ACUERDO EN ASUMIR EL COMPROMISO DE COBRAR VS LA ENTREGA Y EN CASO DE NO DARSE, ASUMIR TÚ EL COMPROMISO DE LA LIQUIDACIÓN DEL MISMO?",
						type: "warning",
						showCancelButton: true,
						confirmButtonColor: "#DD6B55",
						confirmButtonText: "SI, ESTOY DE ACUERDO!",
						cancelButtonText: "NO",
						closeOnConfirm: true
					}, function (inputValue) {

						if (inputValue === true)
						{
							mdlShowWait();
							xajax_pagoVSEntrega(app.idValeSalidaSeleccionado, true, app.recogeentrega);
							// app.chkPagoVSEntregaAux = true;						

						}
						else
						{
							app.chkPagoVSEntrega = false;
						}
		
					});
				}
				
			}
			else
			{
				if (this.chkPagoVSEntregaAux == true)
				{
					mdlShowWait();					
					xajax_pagoVSEntrega(app.idValeSalidaSeleccionado, false, app.recogeentrega);
					// this.chkPagoVSEntregaAux = false;
				}
			}
		},
		idSucursal: function(val){
			xajax_cargarMercanciaSinValeSalida(this.idPedido, this.idSucursal);
		}, 
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
		mostrarTracking: function(){
		
			$('#modalTracking').modal('show');
			this.$refs.trackingPedido.show(this.idPedido);
		},
		crearValeSalida: function(){
			var i = 0;
			var disponible = 0;
			var seguir = true;
			this.clicks++;
			
			if (this.clicks > 1)
			{				
				console.log("Clicks mayor a 1, previniendo doble proceso");
				return;
			}
						
			this.errCrearValeSalida = "";
			this.itemsVale.splice (0, this.itemsVale.length);
			
			if (this.mercanciaSinVale.length <= 0)
			{
				seguir = false;
				this.errCrearValeSalida = this.errCrearValeSalida + "No hay elementos para crear el Vale de Salida." + "<br>";
			}
									
			for(i = 0 ; i < this.mercanciaSinVale.length ; i++)
			{
				disponible = this.mercanciaSinVale[i].partida - this.mercanciaSinVale[i].partidaenvale;
				
				if (this.mercanciaSinVale[i].partidaaagregar > disponible)
				{
					seguir = false;
					this.errCrearValeSalida = this.errCrearValeSalida + "En el renglon " + (i+1) + " desea asignar mas piezas de lo posible." + "<br>";
				}
				else
				{
//					console.log ("no es mas grande, verificando si es mayor a cero");
					if (this.mercanciaSinVale[i].partidaaagregar > 0)
					{
//						console.log ("mayor a cero, push");
						this.itemsVale.push ({
							idpedidodetalle: this.mercanciaSinVale[i].idpedidodetalle,
							idproducto: this.mercanciaSinVale[i].idproducto,
							cantidadparavale: this.mercanciaSinVale[i].partidaaagregar ,
							idpedidodetallecolocacion: this.mercanciaSinVale[i].idpedidodetallecolocacion,
						});
					}
				}
					
					//				this.errCrearValeSalida = this.errCrearValeSalida + this.mercanciaSinVale[i].idpedidodetalle + "<br>"; 
//				console.log(this.mercanciaSinVale[i]);
			}
			
			
			if (this.itemsVale.length <= 0)
			{
				seguir = false;
				this.errCrearValeSalida = this.errCrearValeSalida + "No ha seleccionado elementos para crear el Vale de Salida." + "<br>";
			}
			
			if (seguir)
			{
				setTimeout(function(){ console.log("limpiando contador clicks"); app.clicks = 0;}, 2000);
				this.generarValeDeSalida();
			}
			else
			{
				this.clicks = 0;
				this.itemsVale.splice (0, this.itemsVale.length);
			}
		},
		generarValeDeSalida: function(){
			swal({
		        title: "¿Está seguro?",
		        text: "Se generará un Vale de Salida para los productos indicados.",
		        type: "warning",
		        showCancelButton: true,
		        confirmButtonColor: "#DD6B55",
		        confirmButtonText: "Si, adelante!",
		        cancelButtonText: "No",
		        closeOnConfirm: true
		    }, function () {
		    	mdlShowWait();
		    	xajax_generarValeSalida(app.idPedido, app.itemsVale, app.idSucursal);

		    });
		},
		generarUnSoloVale: function (){
			swal({
		        title: "¿Está seguro?",
		        text: "Se generará un solo Vale de Salida para los todos los produtos del Pedido.",
		        type: "warning",
		        showCancelButton: true,
		        confirmButtonColor: "#DD6B55",
		        confirmButtonText: "Si, adelante!",
		        cancelButtonText: "No",
		        closeOnConfirm: true
		    }, function () {
		    	mdlShowWait();
		    	xajax_generarUnSoloValeSalida(app.idPedido);

		    });
		},
		BorrarValeSalida: function(){
			
			if (this.idValeSalidaPromotorSeleccionado > 0)
				{
					swal({
				        title: "¿Está seguro?",
				        text: "El Vale de Salida sera eliminado. Deberá crear otro Vale para los productos listados.",
				        type: "warning",
				        showCancelButton: true,
				        confirmButtonColor: "#DD6B55",
				        confirmButtonText: "Si, entiendo!",
				        cancelButtonText: "No",
				        closeOnConfirm: true
				    }, function () {
				    	xajax_borrarValeSalida(app.idValeSalidaPromotorSeleccionado);
	
				    });
						
				}
			
			
		},
		cargarMercanciaSinValeSalida: function(){
			xajax_cargarMercanciaSinValeSalida(this.idPedido, this.idSucursal);
		},
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
		hideMostrarVale: function()		{
			this.mostrandoVale = false;
		},
		ConfirmarValeSalida: function(){
			if (this.idValeSalidaPromotorSeleccionado > 0)
			{
				swal({
			        title: "¿Está seguro?",
			        text: "El Vale de Salida sera Confirmado. No podra hacer cambios en dicho Vale.",
			        type: "warning",
			        showCancelButton: true,
			        confirmButtonColor: "#DD6B55",
			        confirmButtonText: "Si, entiendo!",
			        cancelButtonText: "No",
			        closeOnConfirm: true
			    }, function () {
			    	mdlShowWait();
			    	xajax_confirmarValeSalida(app.idValeSalidaPromotorSeleccionado);

			    });
					
			}
		},
		seleccionarValeSalida: function(idValeSalidaPromotor){
//			alert("a cargar: " + idRemisionRollo);
//			this.nrNoRolloSeleccionado = true;
			
			mdlShowWait();
			
			this.keepInfoEntregaVale = true;
			
			this.estado = '';
			//consignacion
			this.personaEntrega = '';
			this.recogeentrega = '';
			this.domicilioEntrega = '';
			this.numeroEntrega = '';
			this.coloniaEntrega = '';
			this.ciudadEntrega = '';
	        
			this.tipoObra = '';
			this.fechaEntregaPorDefinir = '';
			this.fechaEntrega = '';
			this.fechaAbierta = '';
			
//			Permitir vale
			this.chkPedidoSaldado = 'NO';
			this.chkDireccionCorrecta = false;
			this.chkDiaCorrecto = false;
			this.chkHorarioCorrecto = false;
			this.chkEquipoListo = false;
			this.chkPersonaCorrecta = false;
			this.chkHayEspacio = false;
			this.aunno = '';
			this.generarValeSalida = '';
			
			this.chkImprimirPedidoNoSaldado = false;
			
			this.mostrandoVale = true;
			this.idValeSalidaPromotorSeleccionado = idValeSalidaPromotor;
			this.sucursalValeSalidaSeleccionado = '';
			this.valeSalidaTotal = 0;
			this.chkPagoVSEntregaAux = false;
			this.chkPagoVSEntrega = false;
			this.chkRecibeDinero = false;
			this.loadingVS = true;
			
			
			xajax_cargarValeSalida(idValeSalidaPromotor);
			
//			this.pedidoNoDespachar();
//			
//			setTimeout(function() { xajax_cargarNoRemision(idRemisionRollo, app.idPedido); }, 150);
//			
//			setTimeout(function() { xajax_cargarPesoEstimadoXCalibrePies(app.nrCalibre, app.nrPies); }, 500 );
//			setTimeout(function() { app.cargarDatosRegistroProduccionAbierto(); }, 1000 );
//			setTimeout(function() { app.cargarPedidoDetalle(); }, 500);
			
			
		},
		cargarDatosPedido: function(){
//			alert("cargamos");
			
			this.mostrandoVale = false;
			
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
						
			this.valessalida.splice (0, this.valessalida.length);	

			this.pedidoSaldoTotalMas30Dias = 0;
			
			xajax_cargarPedido(this.idPedido);	
			this.seleccionarPedido = false;			
			
			
		},
		seleccionarOtroPedido: function(){
			this.idPedido = '';
			this.seleccionarPedido = true;
		},
		cargarValesSalida: function(){
			xajax_cargarValesSalida(this.idPedido);
		},
		permitirImprimirVale: function(){
			
//			xajax_pedidoSiValeSalida(idpedido, index);
//			$('#modalCheckList').modal('hide');
			
			setTimeout (function(){
				swal({
					title: "¿Seguro que deseas continuar?",
					text: "Se permitirá que se imprima el Vale de Salida del Pedido.",
					type: "warning",
					showCancelButton: true,
					cancelButtonText: "NO",
					cancelButtonColor: "#ed5565",
					confirmButtonColor: "#1c84c6",
					confirmButtonText: "¡Adelante!",
					closeOnConfirm: true },

					function(){
						
						swal.close();
//						alert(app.idValeSalida);
						
						setTimeout(function() {
							
							xajax_permitirImprimirVale(app.idValeSalidaSeleccionado, app.idValeSalidaPromotorSeleccionado,
									app.chkPedidoSaldado,
									app.chkDireccionCorrecta, 
									app.chkDiaCorrecto, 							
									app.chkHorarioCorrecto,
									app.chkEquipoListo,
									app.chkPersonaCorrecta,
									app.chkHayEspacio,										
									app.chkImprimirPedidoNoSaldado,
									app.chkRecibeDinero);	
							
							
						}, 150);
						
						
					
				});
				
				
			}, 150);
		},
		pedidoAunNoValeSalida: function(idValeSalida){
						
			this.auxAunNo = this.aunno;
			
			$('#modalIndicaMotivoAunNo').modal('show');
		},
		setValeSalidaAunNo: function()	{
			$('#modalIndicaMotivoAunNo').modal('hide');
			swal({
					title: "¿Seguro que deseas continuar?",
					text: "Se indicará que AÚN NO pueda imprimir el Vale de Salida del Pedido.",
					type: "warning",
					showCancelButton: true,
					cancelButtonText: "NO",
					cancelButtonColor: "#ed5565",
					confirmButtonColor: "#1c84c6",
					confirmButtonText: "¡Adelante!",
					closeOnConfirm: true },

					function(){
//						swal("¡Hecho!",
//								"Acabas de vender tu alma al diablo.",
//								"success");
						
						swal.close();
//						alert("a autorizar: " + idPedido + '  ' + observacion);
						xajax_setValeSalidaAunNo(app.idValeSalidaSeleccionado, app.auxAunNo);
					
				});
		},
		editarConsignacion: function(){
//			alert("a configurar	");
			this.personaEntregaAux = this.personaEntrega;			
			this.domicilioEntregaAux = this.domicilioEntrega;
			this.numeroEntregaAux = this.numeroEntrega;
			this.coloniaEntregaAux = this.coloniaEntrega;
			this.ciudadEntregaAux = this.ciudadEntrega;
			
			this.horaEntregaAux = this.horaEntrega;
			
//			var fechaEngrega = $("#dtFechaEntrega").val();
			var today = new Date();
			var dd = today.getDate();
			var mm = today.getMonth()+1; //January is 0!
			var yyyy = today.getFullYear();
			var strFechaEntrega =  this.fechaEntrega.substring(0, 2) + '/' + this.fechaEntrega.substring(3, 5) + '/' + this.fechaEntrega.substring(6, 10);
			
//			console.log(fechaEngrega);
			console.log(strFechaEntrega);
			$("#dtFechaEntrega").val(strFechaEntrega);
			
			this.fechaEntregaAux = strFechaEntrega;
			
			this.keepInfoEntregaVale = false;
		},
		calcelarEdicionConsignacion: function(){
			this.keepInfoEntregaVale = true;
		},
		saveConsignacion: function(){
			var seguir = true;
			
			this.personaEntregaErr = "";			
			this.domicilioEntregaErr = "";
			this.numeroEntregaErr = "";
			this.coloniaEntregaErr = "";
			this.ciudadEntregaErr = "";
			this.fechaEntregaErr = "";
			
			if (this.personaEntregaAux == "")
			{
				seguir = false;
				this.personaEntregaErr = "Debe indicar Persona";
			}
			
			if (this.domicilioEntregaAux == "")
			{
				seguir = false;
				this.domicilioEntregaErr = "Debe indicar Domicilio";
			}
			
			if (this.numeroEntregaAux == "")
			{
				seguir = false;
				this.numeroEntregaErr = "Debe indicar Numero de Entrega";
			}
			
			if (this.coloniaEntregaAux == "")
			{
				seguir = false;
				this.coloniaEntregaErr = "Debe indicar Colonia";
			}
						
			if (this.ciudadEntregaAux == "")
			{
				seguir = false;
				this.ciudadEntregaErr = "Debe indicar Ciudad";
			}
			
			var fechaEngrega = $("#dtFechaEntrega").val();
			console.log("Guardar: FechaEntrega " + $("#dtFechaEntrega").val());
			var today = new Date();
			var dd = today.getDate();
			var mm = today.getMonth()+1; //January is 0!
			var yyyy = today.getFullYear();
			var strFechaEntrega = fechaEngrega.substring(6, 10) + '-' + fechaEngrega.substring(3, 5) + '-' + fechaEngrega.substring(0, 2);
			var strFE = fechaEngrega.substring(6, 10) + '' + fechaEngrega.substring(3, 5) + '' + fechaEngrega.substring(0, 2);
			var strToday = yyyy + '' + (mm >= 10 ? mm : '0' + mm) + '' + dd;
			
			console.log(strToday);
			console.log(strFE);
			if (parseInt(strToday) > parseInt(strFE))
			{
				this.fechaEntregaErr = "La Fecha de Entrega debe ser posterior o igual al día de hoy.";

//				saInfo("La Fecha de Entrega debe ser posterior al día de hoy.");
				seguir = false;
			}
			
//			this.fechaEntregaErr = "";
			
			if (seguir)
			{
				xajax_saveConsignacion(this.idValeSalidaPromotorSeleccionado, 
						this.idValeSalidaSeleccionado,
						this.personaEntregaAux,
						this.domicilioEntregaAux,
						this.numeroEntregaAux,
						this.coloniaEntregaAux,
						this.ciudadEntregaAux,
						this.horaEntregaAux,
						strFechaEntrega);	
			}
//			
		},
		asignarTodoAVale: function (){
			for (var i = 0 ; i < this.mercanciaSinVale.length ; i++)
			{
				this.mercanciaSinVale[i].partidaaagregar = (this.mercanciaSinVale[i].partida - this.mercanciaSinVale[i].partidaenvale);
				if (this.mercanciaSinVale[i].partidaaagregar < 0 )
					this.mercanciaSinVale[i].partidaaagregar = 0;
			}
		}
		
	}	
});



$(document).ready(function()
{
    $("#collapseLeftMenu").click();
    
    $('#dtFechaEntrega').datepicker({
	    todayBtn: "linked",
	    keyboardNavigation: false,
	    forceParse: false,
	    calendarWeeks: true,
	    autoclose: true,
	    format: 'dd/mm/yyyy'
	}); 
     
});