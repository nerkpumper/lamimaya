//  console.log(" __DEVELOPERMODE " + __DEVELOPERMODE);
//  console.log("url_api_file: " + URL_API_FILE);

var app = new Vue({
	el: '#app',
	data: {
		idPedido: '',
		despachandoAlgo: false,

		//Registros de Produccion
		rpIdRegistroProduccion: 0,
		rpIdRemisionRollo: 0,
		rpKilos: 0,
		rpKilosMaquilados: 0,
		rpRegistrosDeProduccion: [],
		rpRegistroProduccionDetalle: [],
		rpPesoEstimadoXKiloRolloSeleccionado: 0,
		rpSucursalCantidadSacar: 0,
		rpmolCantidadSurtir: 0,
		rpIndex: -1,
		
		errRpSucursalCantidad: '',

		//Moldura
		molIdProductoMoldura: 386,
		molIdProductoMaquilaMoldura: 394,
		
		//para controlar si se despacha el pedido o no
		seleccionarPedido: true,
		pedidoProduccion: false,
		pedidoNoProduccion: false,
		pedidoTerminado: false,
		pedidoRecogeEntrega: '',
		pedidoEstado: '',

		
		pedidoDetalle: [],
		
		indexDespachando: 0,
		
		//de donde sacar mercancía remisionRollo
		remisionIdRemisionRollo: 0,
		remisionRemision: 0,
		remisionNoRollo: '',
		remisionExistencia: 0,
		remisionCantidadSacar: 0,
		remisionHistorial: '',
		
		//de donde sacar mercancía remisionRollo
		stockIdInvzStockNoRollo: 0,
		stockIdRemisionRollo: 0,		
		stockNoRollo: '',
		stockNoRolloExistencia: 0,
		stockNoRolloCantidadSacar: 0,
		remisionHistorial: '',
		
				
		//Datos Pedido Detalle
		idPedidoDetalle: 0,
		detIdProducto: 0,
		molIdProductoLisa: 0,
		molCodigoLisa: '',
		molDescripcionLisa: '',
		molCantidadSurtir: 0,
		molCantidadSurtirScrap: 0,
		molLaminasATomar: 1,
		
		proCodigo: 'codigo',
		proFullname: 'fullname',
		proTipoProducto: '',
		proAplicacion: '',
		proMaterial: '',
		proIdTipoProducto: 0,
		proIdUnidad: 0,
		proIdRollo: 0,
		molIdRollo: 0,
		molIsScrap: false,
		
		idSucursal: 0,
		sucursalNombre: '',
		sucursalExistencia: 0,
		sucursalApartado: 0,
		sucursalCantidadSacar: 0, 
		colocaCantidad: 0,
		colocaCantidadSurtida: 0,
		
		
		rolloCodigo: '',
		rolloMaterial: '',
		rolloProveedor: '',
		rolloCalibre: '',
		rolloPies: '',
		rolloDescripcion: '',
		
		
		
		proShortUnidad: '',
		proDescripcion: '',
		proLongitud: '',
		
		detPartida: 0,      //Numero de Piezas
		detCantidad: 0,     //Longitud de láminas
		detCantidadReal: 0, //Longitud en ML, diferirá de M2
		detDesarrollo: '',  //Desarrollo
		detDobleces: 0,     //Dobleces
		
		totalExplotar: 0,
		totalExplotado: 0,
		explotadoReal: 0,
		isParcial: 'NO',
		
		detProductoDetalleDespachado: false
	},
	mounted: function(){		 
		if (typeof param1 !== 'undefined') {
			this.idPedido = param1;
						
			this.cargarDatosPedido();	
		}
		$('#tblNoRollos').footable();
		// this.mifuncion ();
	},
	created: function(){
		//xajax_cargarPedido(this.idPedido);	
	},
	watch: {
		rpSucursalCantidadSacar: function(val){
			if (this.rpSucursalCantidadSacar > this.totalPorDespachar)
			{
				this.errRpSucursalCantidad = "La cantidad a fabricar excede lo solicitado.";
			}	
			else
			{
				this.errRpSucursalCantidad = "";
			}		
		}
	},
	computed:{	
		descripcionRollo: function(){			
			
			var des = this.rolloCodigo + '  ' + 
			       this.rolloMaterial + '   ' + 
			       this.rolloProveedor + ' ' + 
			       this.rolloCalibre + '  ' + 
			       this.rolloPies + '  PIES [' +
			       this.rolloDescripcion + ']';
			
			return des.replace("--NO APLICA--", "").toUpperCase();
		},
		isMoldura: function(){
			return this.detIdProducto == this.molIdProductoMoldura;
		},
		isMaquilaMoldura: function(){
			return this.detIdProducto == this.molIdProductoMaquilaMoldura;
		},		
		queSeSaca: function(){
			var deDonde = "";
			if (this.proShortUnidad == "PZA" || this.detIdProducto == this.molIdProductoMoldura)
			{
				deDonde = "PIEZAS";
			}
			else
			{
				deDonde = "KILOS";
			}
			
			return deDonde;
		},
		deDondeSeSaca: function(){
			var deDonde = "";
			if (this.proShortUnidad == "PZA" || (this.proShortUnidad == "ML" && this.proIdRollo == 1) || this.detIdProducto == this.molIdProductoMoldura || this.detIdProducto == this.molIdProductoMaquilaMoldura)
			{
				deDonde = "INVENTARIO";
			}
			else
			{
				deDonde = "ROLLO";
			}
			
			return deDonde;
		},	
		totalPorDespachar: function(){
//			var porDespachar = this.totalExplotar - this.explotadoReal ;
			var porDespachar = this.colocaCantidad - this.colocaCantidadSurtida;
			
//			console.log("Por Despachar: " + porDespachar);
			porDespachar = parseFloat(Math.round(porDespachar * 100) / 100).toFixed(2);
//			console.log("Por Despachar(2): " + porDespachar);
	
			
			return (porDespachar < 0 ? 0 : porDespachar);
		}
	},
	methods: {
		// mifuncion: function(val = 1){
        // return;
        //     //xajax_funcionEjemplo();

        //     // setTimeout(function(){ app.mifuncion(); }, 2000);

        //     // this.status = "loading . . . ";
		// 	var vm = this;
		// 	var form_data = new FormData();
		// 	var mk = [{id: 3, name: "el 3"}, {id: 4, name: "el mk 4"}];
            
        //     form_data.append('method', 'prueba');
		// 	form_data.append('idPedido', 1);
		// 	form_data.append("mk", JSON.stringify(mk));
        //     // form_data.append('losquevan', JSON.stringify(vm.loselementos));
            
        //     // console.log(URL_API_FILE);	

        //     // //axios.get('http://ron-swanson-quotes.herokuapp.com/v2/quotes')
		// 	// headers: { 'content-type': 'application/form-data' },
		// 	// application/json
        //     const options = {
        //         method: 'POST',
		// 		headers: { 'content-type': 'application/form-data' },
        //         data: form_data,
        //         url: URL_API_FILE,
		// 	};
			
			

        //     axios(options)
        //         .then( function(response) {
        //             // console.log("OK");
        //             // console.log(response.data);

        //             if (!response.data.error)
        //             {
		// 				console.log("->success: ");
		// 				console.log(response.data);
                        
        //             }
        //             else
        //             {    
        //                 // setErrorHandler(response.data);
        //                 // vm.errMsg =response.data.errDetail;                     
        //                 // saError(response.data.msg);
		// 				alert(response.data.msg);
		// 				alert(response.data.errDetail);
        //             }
        //         })
        //         .catch(err => {-
        //             console.log("ERROR: ")
        //             console.log(err)
        //         } );
            
		// },
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
			
			this.pedidoTerminado = false;
			this.pedidoNoProduccion = false;
			this.despachandoAlgo = false;	
			this.indexDespachando = -1;
			
			xajax_cargarPedido(this.idPedido);	
			this.seleccionarPedido = false;
//			this.pedidoProduccion = true;			
		},
		seleccionarOtroPedido: function(){
			this.idPedido = 0;
			this.pedidoTerminado = false;
			this.pedidoNoProduccion = false;
			this.seleccionarPedido = true;
			this.pedidoProduccion = false;
			this.despachandoAlgo = false;
		},
		descontarDeRollo: function(){
//			remisionIdRemisionRollo: 0,
//			remisionRemision: 0,
//			remisionNoRollo: '',
//			remisionExistencia: 0,
//			remisionCantidadSacar: 0
			
			var seguir = true;
			console.log("descontarDeRollo");
			
			if (this.remisionCantidadSacar <= 0)
			{
				mostrarAviso("Debe indicar la cantidad a despachar.");
				seguir = false;
			}
			
			if (this.remisionCantidadSacar > this.remisionExistencia)
			{
				mostrarAviso("No puede tomar del Rollo mas de la Existencia.");
				seguir = false;
			}
			
			
			if (seguir)			
			{
				swal({
			        title: "Confirme",
			        text: "Se relizará el movimiento en el Inventario",
			        type: "warning",
			        showCancelButton: true,
			        confirmButtonColor: "#DD6B55",
			        confirmButtonText: "Si",
			        cancelButtonText: "No",
			        closeOnConfirm: false
			    }, function () {
			    	xajax_darSalidaARollo(app.proIdRollo, app.remisionIdRemisionRollo, app.remisionCantidadSacar, app.idPedidoDetalle, app.idPedido, app.idSucursal);
			    });				
			}
			
			
		},
		showModalNoRollos: function(){
			
			xajax_cargarNoRollos(this.proIdRollo);
			$('#modalNoRollos').modal('show');
		},
		seleccionarNoRollo: function(idRemisionRollo){
			//alert("vamos a cargar idRemisionRollo: " + idRemisionRollo);
			this.remisionIdRemisionRollo = idRemisionRollo; 
			
			xajax_cargarDatosRemisionRollo(this.remisionIdRemisionRollo);
			
			$('#modalNoRollos').modal('hide');
			
		},
		seleccionarStockNoRollo: function(idinvzstocknorollo){
			//alert("vamos a cargar idRemisionRollo: " + idRemisionRollo);
			this.stockIdInvzStockNoRollo = idinvzstocknorollo; 
			
			xajax_cargarDatosStockRemisionRollo(this.stockIdInvzStockNoRollo);
			
			$('#modalStockNoRollos').modal('hide');
			
		},
		marcarComoDespachado: function(){			
			if (this.totalExplotar > this.explotadoReal)
			{
				mostrarAviso("No se puede realizar la petición. La Cantidad Despachada es menos al Total a Despachar.");
			}
			else
			{
				swal({
			        title: "¿Desea continuar?",
			        text: "Ya no podrá hacer movimientos con este renglon de Pedido.",
			        type: "warning",
			        showCancelButton: true,
			        confirmButtonColor: "#DD6B55",
			        confirmButtonText: "Si",
			        cancelButtonText: "No",
			        closeOnConfirm: false
			    }, function () {
			    	xajax_marcarComoDespachado(app.idPedidoDetalle, app.idSucursal);
			    });
			}
		},
		marcarMaquilaRealizada: function(){			
			
				swal({
			        title: "¿Desea continuar?",
			        text: "Se marcara como Productos Realizados.",
			        type: "warning",
			        showCancelButton: true,
			        confirmButtonColor: "#DD6B55",
			        confirmButtonText: "Si",
			        cancelButtonText: "No",
			        closeOnConfirm: false
			    }, function () {
			    	xajax_marcarMaquilaRealizada(app.idPedidoDetalle, app.idSucursal);
			    });
			
		},
		darSalidaAInventario: function(){
			
			swal({
		        title: "Confirme",
		        text: "Se relizará el movimiento en el Inventario",
		        type: "warning",
		        showCancelButton: true,
		        confirmButtonColor: "#DD6B55",
		        confirmButtonText: "Si",
		        cancelButtonText: "No",
		        closeOnConfirm: false
		    }, function () {
		    	xajax_darSalidaAInventario(app.idPedidoDetalle, app.detIdProducto, app.idPedido, app.totalExplotar, app.idSucursal);
		    });
			
//			xajax_darSalidaAInventario(this.idPedidoDetalle, this.detIdProducto, this.idPedido, this.totalExplotar);
		},
		viewDespachoPedidoDetalle: function(index){
			
//			swal({
//				title: "Cargando Información",
//				text: "Por favor espere.",				
//				showConfirmButton: false
//				});
			
			if(this.indexDespachando >= 0)
			{				
				this.pedidoDetalle[this.indexDespachando].despachando = false;
			}
						
			this.indexDespachando = index;
			this.despachandoAlgo = true;
																																																																																																																					
			
			xajax_cargarPedidoDetalle(this.pedidoDetalle[index].idPedidoDetalle, this.pedidoDetalle[index].idSucursal);
		},
		despacharPedidoRPDeStock: function(index){
			if(this.indexDespachando >= 0)
			{				
				this.pedidoDetalle[this.indexDespachando].despachando = false;
			}
			
			this.pedidoDetalle[index].despachando = true;
			this.indexDespachando = index;
			this.despachandoAlgo = true;
			
			this.molIdProductoLisa = 0;
			this.molCodigoLisa = '';
			this.molDescripcionLisa = '';
			this.molCantidadSurtir = 0;
			this.molCantidadSurtirScrap = 0;
			this.molIsScrap = false;
			
			this.idSucursal = 0;
			this.sucursalNombre = '';
			this.sucursalExistencia = 0;
			this.sucursalApartado = 0;
			this.colocaCantidad = 0;
			this.colocaCantidadSurtida = 0;

			this.rpIdRegistroProduccion = 0;
			this.rpKilos = 0;
			this.rpKilosMaquilados = 0;
			this.rpSucursalCantidadSacar = 0;
			this.rpmolCantidadSurtir = 0;
			
			xajax_cargarPedidoDetalle(this.pedidoDetalle[index].idPedidoDetalle, this.pedidoDetalle[index].idSucursal, false, true);
		},
		despacharPedidoDetalle: function(index){
			
			
//			swal({
//				title: "Cargando Información",
//				text: "Por favor espere.",				
//				showConfirmButton: false
//				});
			
			if(this.indexDespachando >= 0)
			{				
				this.pedidoDetalle[this.indexDespachando].despachando = false;
			}
			
			this.pedidoDetalle[index].despachando = true;
			this.indexDespachando = index;
			this.despachandoAlgo = true;
			
			this.molIdProductoLisa = 0;
			this.molCodigoLisa = '';
			this.molDescripcionLisa = '';
			this.molCantidadSurtir = 0;
			this.molCantidadSurtirScrap = 0;
			this.molIsScrap = false;
			
			this.idSucursal = 0;
			this.sucursalNombre = '';
			this.sucursalExistencia = 0;
			this.sucursalApartado = 0;
			this.colocaCantidad = 0;
			this.colocaCantidadSurtida = 0;

			this.rpIdRegistroProduccion = 0;
			this.rpKilos = 0;
			this.rpKilosMaquilados = 0;
			this.rpSucursalCantidadSacar = 0;
			this.rpmolCantidadSurtir = 0;
			
			xajax_cargarPedidoDetalle(this.pedidoDetalle[index].idPedidoDetalle, this.pedidoDetalle[index].idSucursal);
			
			
		},
		showModalStockNoRollos: function(){	
//			saInfo("Este producto se saca en automático de inventario");
			
			xajax_cargarStockNoRollos(this.detIdProducto);
			$('#modalStockNoRollos').modal('show');
		},
		showModalStockNoRollosParaMoldura: function(){	
//			saInfo("Este producto se saca en automático de inventario");
			
			xajax_cargarStockNoRollos(this.molIdProductoLisa);
			$('#modalStockNoRollos').modal('show');
		},
		descontarDeStockNoRollo: function(){
//			stockIdInvzStockNoRollo: 0,
//			stockIdRemisionRollo: 0,		
//			stockNoRollo: '',
//			stockNoRolloExistencia: 0,
//			stockNoRolloCantidadSacar: 0,
//			remisionHistorial: '',
			
			var seguir = true;
//			console.log("descontarDeStockNoRollo");
			if (this.sucursalCantidadSacar <= 0)
			{
				saInfo("Debe indicar la cantidad a Surtir.");
				seguir = false;
			}
			
			if (parseFloat(this.sucursalCantidadSacar) > this.sucursalExistencia)
			{
				saInfo("No puede tomar del Stock No Rollo mas de la Existencia.");
				seguir = false;
			}
			
//			console.log("sucursalCantidadSacar: " + this.sucursalCantidadSacar);
//			console.log("totalPorDespachar: " + this.totalPorDespachar);
			if (parseFloat(this.sucursalCantidadSacar) > this.totalPorDespachar)
			{
				saInfo("La cantidad excede el total por Surtir.");
				seguir = false;
			}
			
			
			
			if (seguir)			
			{
				swal({
			        title: "Confirme",
			        text: "Se relizará el movimiento en el Inventario",
			        type: "warning",
			        showCancelButton: true,
			        confirmButtonColor: "#DD6B55",
			        confirmButtonText: "Si",
			        cancelButtonText: "No",
			        closeOnConfirm: false
			    }, function () {
//			    	alert("a surtir");
			    	xajax_darSalidaAInventarioFromStockNoRollo(app.idPedidoDetalle, app.detIdProducto, app.idPedido, app.sucursalCantidadSacar, app.stockIdRemisionRollo, app.proIdTipoProducto, app.proIdUnidad, app.proIdRollo, app.detCantidadReal, app.idSucursal);
			    });				
			}
			
			
		},
		descontarDeStockNoRolloScrap: function(){
//			stockIdInvzStockNoRollo: 0,
//			stockIdRemisionRollo: 0,		
//			stockNoRollo: '',
//			stockNoRolloExistencia: 0,
//			stockNoRolloCantidadSacar: 0,
//			remisionHistorial: '',
//			console.log("descontarDeStockNoRolloScrap");
			var seguir = true;
			
			if (this.molCantidadSurtirScrap <= 0)
			{
				saInfo("Debe indicar el número de Molduras a Surtir.");
				seguir = false;
			}
			
			
			if (parseFloat(this.molCantidadSurtirScrap) > this.totalPorDespachar)
			{
				saInfo("La cantidad excede el total por surtir.");
				seguir = false;
			}
			
			
			if (seguir)			
			{
				swal({
			        title: "Confirme",
			        text: "Se relizará el movimiento en el Inventario",
			        type: "warning",
			        showCancelButton: true,
			        confirmButtonColor: "#DD6B55",
			        confirmButtonText: "Si",
			        cancelButtonText: "No",
			        closeOnConfirm: false
			    }, function () {
			    	xajax_darSalidaAInventarioFromStockNoRolloScrap(app.idPedidoDetalle, app.idPedido,  app.molCantidadSurtirScrap, app.idSucursal);
			    });				
			}
			
			
		},
		descontarDeStockNoRolloLaminaYScrap: function(){
//			stockIdInvzStockNoRollo: 0,
//			stockIdRemisionRollo: 0,		
//			stockNoRollo: '',
//			stockNoRolloExistencia: 0,
//			stockNoRolloCantidadSacar: 0,
//			remisionHistorial: '',
			
			var seguir = true;
			console.log("descontarDeStockNoRolloLaminaYScrap");
			if (parseFloat(this.sucursalCantidadSacar) <= 0)
			{
				saInfo("Debe indicar el número de Láminas que utilizará para Surtir las Molduras.");
				seguir = false;
			}
			
			if (parseFloat(this.sucursalCantidadSacar) > parseFloat(this.sucursalExistencia))
			{
				saInfo("No puede tomar del Stock No Rollo mas de la Existencia.");
				seguir = false;
			}
			
			if (parseFloat(this.molCantidadSurtir) <= 0)
			{
				saInfo("Debe indicar el número de Molduras a Surtir.");
				seguir = false;
			}
			
			if (parseFloat(this.molCantidadSurtir) > parseFloat(this.totalPorDespachar))
			{
				saInfo("La cantidad de Molduras excede el total por Surtir.");
				seguir = false;
			}
			
			
			if (seguir)			
			{
//				alert("a guardar");
				swal({
			        title: "Confirme",
			        text: "Se relizará el movimiento en el Inventario",
			        type: "warning",
			        showCancelButton: true,
			        confirmButtonColor: "#DD6B55",
			        confirmButtonText: "Si",
			        cancelButtonText: "No",
			        closeOnConfirm: false
			    }, function () {
			    	xajax_darSalidaAInventarioFromStockNoRolloLaminaYScrap(app.idPedidoDetalle, app.molIdProductoLisa, app.idPedido, app.sucursalCantidadSacar, 0, app.molCantidadSurtir, app.idSucursal);
			    });				
			}
			
			
		},
		showModalRegistrosProduccion: function(){
			this.rpIdRegistroProduccion = 0;
			this.rpIdRemisionRollo = 0;
			this.rpKilos = 0;
			this.rpKilosMaquilados = 0;
			this.rpSucursalCantidadSacar = 0;
			this.rpmolCantidadSurtir = 0;
			this.rpIndex = -1;
			
			xajax_cargarRegistrosProduccion(this.molIdRollo);
			$('#modalRegistrosProduccion').modal('show');
		},
		seleccionarRegistroProduccion: function(idrp, idrr, index){
			
			this.rpIdRegistroProduccion = idrp;		
			this.rpIdRemisionRollo = idrr;
			this.rpKilos = this.rpRegistrosDeProduccion[index].kilos;
			this.rpKilosMaquilados = this.rpRegistrosDeProduccion[index].kilosMaquilados;
			this.rpSucursalCantidadSacar = 0;
			this.rpmolCantidadSurtir = 0;
			this.rpIndex = index;

			setTimeout(function () { xajax_cargarDetalleRegistroProduccion(app.rpIdRegistroProduccion);}, 1000);

			$('#modalRegistrosProduccion').modal('hide');
		},
		registrarProduccionYDescontarMolduras: function(){
			

			var totalML = 0;
			var totalKG = 0;
			var ml = 0;
			
			if (this.isMoldura)			
			{
				totalML = this.rpSucursalCantidadSacar*this.detCantidadReal;							
				ml = this.detCantidad;
			}
			else
			{
				totalML = this.rpSucursalCantidadSacar*this.proLongitud;
				ml = this.proLongitud;

				if (this.rpSucursalCantidadSacar > this.totalPorDespachar)
				{
					this.errRpSucursalCantidad = "Láminas a fabricar excede lo solicitado.";
					saInfo("Las Láminas que indica a fabricar, supera la cantidad pedida. Favor de verificar.");
					return;
				}
			}
			
			totalKG = totalML * this.rpPesoEstimadoXKiloRolloSeleccionado;

			if (this.rpSucursalCantidadSacar > 0)
			{

				if ((this.rpKilosMaquilados + totalKG) < (this.rpKilos * 1.1))
				{
					if (this.isMoldura)			
					{
						if (this.rpmolCantidadSurtir > 0)
						{
							if (this.rpmolCantidadSurtir <= this.totalPorDespachar)
							{
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
										// console.log ("registrar rp Pedido");
										mdlShowWait();
										// console.log("RegistrarRPPedido L 731")
										xajax_registrarRPPedido(app.molIdRollo, 
																app.rpIdRemisionRollo,  
																app.rpIdRegistroProduccion, 
																app.idPedidoDetalle, 
																app.detIdProducto , 
																app.rpSucursalCantidadSacar, 
																ml,  //ml
																app.rpPesoEstimadoXKiloRolloSeleccionado, 
																totalKG, 
																0, 
																app.idSucursal,
																app.rpmolCantidadSurtir,
																app.isMoldura);
			
								});		
	
							}
							else
							{
								saInfo("La Cantidad que desea Ingresar superará la Cantidad total de Láminas a Surtir.");
							}
						}
						else
						{
							saInfo("Ingrese los datos necesarios. Molduras a surtir.");
						}


					}
					else
					{
				
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
								// console.log ("registrar rp Pedido");
								mdlShowWait();
								// console.log("RegistrarRPPedido L 777")
								xajax_registrarRPPedido(app.molIdRollo, 
														app.rpIdRemisionRollo,  
														app.rpIdRegistroProduccion, 
														app.idPedidoDetalle, 
														app.detIdProducto , 
														app.rpSucursalCantidadSacar, 
														ml,  //ml
														app.rpPesoEstimadoXKiloRolloSeleccionado, 
														totalKG, 
														0, 
														app.idSucursal,
														app.isMoldura);
	
						});		
	
						
					}

				}
				else
				{
					saInfo("La Cantidad que desea Ingresar superará la Cantidad total del Rollo(+10%).");
				}
				
			}
			else
			{
				saInfo("Ingrese los datos necesarios. Láminas a fabricar.");
			}
				
		},
	}
	
});