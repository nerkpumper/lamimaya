
var app = new Vue({
	el: '#app',
	data: {
		idPedido: '',
		despachandoAlgo: false,
		
		//Moldura
		molIdProductoMoldura: 9,
		molIdProductoMaquilaMoldura: 10,
		
		//para controlar si se despacha el pedido o no
		seleccionarPedido: true,
		pedidoProduccion: false,
		pedidoNoProduccion: false,
		pedidoTerminado: false,
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
		
		
		rolloCodigo: '',
		rolloMaterial: '',
		rolloProveedor: '',
		rolloCalibre: '',
		rolloPies: '',
		rolloDescripcion: '',
		
		
		
		proShortUnidad: '',
		proDescripcion: '',
		
		detPartida: 0,      //Numero de Piezas
		detCantidad: 0,     //Longitud de láminas
		detCantidadReal: 0, //Longitud en ML, diferirá de M2
		detDesarrollo: '',  //Desarrollo
		detDobleces: 0,     //Dobleces
		
		totalExplotar: 0,
		totalExplotado: 0,
		explotadoReal: 0,
		
		detProductoDetalleDespachado: false
	},
	mounted: function(){		 
		if (typeof param1 !== 'undefined') {
			this.idPedido = param1;
						
			this.cargarDatosPedido();	
		}
		$('#tblNoRollos').footable();
	},
	created: function(){
		//xajax_cargarPedido(this.idPedido);	
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
			var porDespachar = this.totalExplotar - this.explotadoReal ;
			
//			console.log("Por Despachar: " + porDespachar);
			porDespachar = parseFloat(Math.round(porDespachar * 100) / 100).toFixed(2);
//			console.log("Por Despachar(2): " + porDespachar);
	
			
			return (porDespachar < 0 ? 0 : porDespachar);
		}
	},
	methods: {
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
			    	xajax_darSalidaARollo(app.proIdRollo, app.remisionIdRemisionRollo, app.remisionCantidadSacar, app.idPedidoDetalle, app.idPedido);
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
			    	xajax_marcarComoDespachado(app.idPedidoDetalle);
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
			    	xajax_marcarMaquilaRealizada(app.idPedidoDetalle);
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
		    	xajax_darSalidaAInventario(app.idPedidoDetalle, app.detIdProducto, app.idPedido, app.totalExplotar);
		    });
			
//			xajax_darSalidaAInventario(this.idPedidoDetalle, this.detIdProducto, this.idPedido, this.totalExplotar);
		},
		viewDespachoPedidoDetalle: function(index){
			swal({
				title: "Cargando Información",
				text: "Por favor espere.",				
				showConfirmButton: false
				});
			
			if(this.indexDespachando >= 0)
			{				
				this.pedidoDetalle[this.indexDespachando].despachando = false;
			}
						
			this.indexDespachando = index;
			this.despachandoAlgo = true;
			
			xajax_cargarPedidoDetalle(this.pedidoDetalle[index].idPedidoDetalle);
		},
		despacharPedidoDetalle: function(index){
			
			
			swal({
				title: "Cargando Información",
				text: "Por favor espere.",				
				showConfirmButton: false
				});
			
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
			
			xajax_cargarPedidoDetalle(this.pedidoDetalle[index].idPedidoDetalle);
			
			
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
			
			if (this.stockNoRolloCantidadSacar <= 0)
			{
				saInfo("Debe indicar la cantidad a Surtir.");
				seguir = false;
			}
			
			if (this.stockNoRolloCantidadSacar > this.stockNoRolloExistencia)
			{
				saInfo("No puede tomar del Stock No Rollo mas de la Existencia.");
				seguir = false;
			}
			
			if (this.stockNoRolloCantidadSacar > this.totalPorDespachar)
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
			    	xajax_darSalidaAInventarioFromStockNoRollo(app.idPedidoDetalle, app.detIdProducto, app.idPedido, app.stockNoRolloCantidadSacar, app.stockIdRemisionRollo, app.proIdTipoProducto, app.proIdUnidad, app.proIdRollo, app.detCantidadReal);
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
			
			var seguir = true;
			
			if (this.molCantidadSurtirScrap <= 0)
			{
				saInfo("Debe indicar el número de Molduras a Surtir.");
				seguir = false;
			}
			
			
			if (this.molCantidadSurtirScrap > this.totalPorDespachar)
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
			    	xajax_darSalidaAInventarioFromStockNoRolloScrap(app.idPedidoDetalle, app.idPedido,  app.molCantidadSurtirScrap);
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
			
			if (this.stockNoRolloCantidadSacar <= 0)
			{
				saInfo("Debe indicar el número de Láminas que utilizará para Surtir las Molduras.");
				seguir = false;
			}
			
			if (this.stockNoRolloCantidadSacar > this.stockNoRolloExistencia)
			{
				saInfo("No puede tomar del Stock No Rollo mas de la Existencia.");
				seguir = false;
			}
			
			if (this.molCantidadSurtir <= 0)
			{
				saInfo("Debe indicar el número de Molduras a Surtir.");
				seguir = false;
			}
			
			if (this.molCantidadSurtir > this.totalPorDespachar)
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
			    	xajax_darSalidaAInventarioFromStockNoRolloLaminaYScrap(app.idPedidoDetalle, app.molIdProductoLisa, app.idPedido, app.stockNoRolloCantidadSacar, app.stockIdRemisionRollo, app.molCantidadSurtir);
			    });				
			}
			
			
		}
	}
	
});