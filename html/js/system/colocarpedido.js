
var app = new Vue ({
	el: '#app',
	data: {
		
		idPedidoFiltro: '',
//		seleccionarPedido: true,
		idPedidoReasignar: 0,
		idPedido: '',
		estado: '',
		
//		//visibilidad
//		mostrarEstatus: true,
//		mostrarPedido: true,
		
		sePuedeAsignar: false,
		
		verMontos: false,
		verExplosionado: false,
		verListoProducit: true,
		verDespachado: true,
		
//		//clases
//		claseEstatus: '',
//		clasePedido: '',
		
		//
		mostrarFactura: true,
		
		//Datos de Estatus
		capturadoImage: '',
		capturadoPor: '',
		capturadoFecha: '',
		capturaObservacion: '',
		
		autorizadoImage: '',
		autorizadoPor: '',
		autorizadoFecha: '',
		autorizadoObservacion: '',
		
		produccionImage: '',
		produccionPor: '',
		produccionFecha: '',
		
		terminadoImage: '',
		terminadoPor: '',
		terminadoFecha: '',
		
		entregadoImage: '',
		entregadoPor: '',
		entregadoFecha: '',
		
		canceladoImage: '',
		canceladoPor: '',
		canceladoFecha: '',
		
		//Clientes
		cteNombre: '',
        cteApellidos: '',
        cteEmpresa: '',
        cteDomicilio1: '',
        cteDomicilio2: '',
        cteNumero: '',
        cteColonia: '',
        cteCiudad: '',
        cteTelefonos: '',
        cteEMail: '',
        cteRFC: '',
        
        //sucursaldeseada
        sucursalPreferente: '',
        
        
        //promotor
        promoNombre: '',
        promoAPaterno: '',
        promoAMaterno: '',
        promotorImage: '',
        
        //consignacion
        personaEntrega: '',
        recogeentrega: '',
        domicilioEntrega: '',
        numeroEntrega: '',
        coloniaEntrega: '',
        ciudadEntrega: '',
        
        tipoObra: '',
        fechaEntregaPorDefinir: '',
        fechaEntrega: '',
        fechaAbierta: '',
        
        pedidos: [],
        pedidosColocados: [],
        pedidosColocadosAutomatico: [],
        
        //detalle productos
        productos: [],
        oldProductos: [],
        otrosServicios: [],
        detalleAColocar: [],
        
        
        

		//totales
		subtotal: '',
		descuento: '',
		total: ''
		
	},
	mounted: function(){
//		if (typeof param1 !== 'undefined') {
//			this.idPedido = param1;
			this.cargarPedidosAutorizados();
			setInterval(function() {app.cargarPedidosAutorizados(); }, 5000);
//			this.idPedido = 795;
//			setTimeout(function() { app.cargarDatosPedido();}, 2000);
						
//			this.cargarDatosPedido();					
//		}
		
			
	},	
	//////
	watch: {
	    
		productos: {
			handler: function (after, before) {
				// Return the object that changed
	//			var vm=this;
	//       
	//			let changed = after.filter( function( p, idx ) {
	//				return Object.keys(p).some( function( prop ) {
	//					//return p[prop] !== vm.$data.oldPeople[idx][prop];
	//					console.log("Col:  " + prop + "   -   " + p[prop] + "  -  " + vm.oldPeople[idx][prop]);
	//					return p[prop] !== vm.oldPeople[idx][prop];
	//				});
	//			});
	        // Log it
					
				var i;
				var j;
//				console.log("Parece que algo cambió");
				for (i = 0; i < this.productos.length ; i++)
				{
					for (j = 0; j < this.productos[i].inventariosucursal.length ; j++)
					{
						if (this.productos[i].inventariosucursal[j].asignar != this.oldProductos[i].inventariosucursal[j].asignar)
						{
							this.verificarBalanceoSucursal(i);
//							console.log("Ha cambiado producto " + i + "  en inventario " + j );
						}	
					}
				}
										
				this.setValue();
//				console.log(changed);
				},
	      deep: true,
		}
	},
	computed: {
		pedidosColocadosFiltrados: function(){
			var self=this;
	    	 
	    	 return this.pedidosColocados.filter(function(cust){
	    		
	    		if (self.idPedidoFiltro != '')
	    		{
	    			var str = cust.idPedido.toString();
		    		var find = self.idPedidoFiltro;
		    		 
		    			    			
	    			return str.includes(find);
	    		}
	    		else
	    		{
	    			return true;	
	    		}
	    		 
	    		

	    	 });
		},
		pedidosColocadosAutomaticoFiltrados: function(){
			var self=this;
	    	 
	    	 return this.pedidosColocadosAutomatico.filter(function(cust){
	    		
	    		if (self.idPedidoFiltro != '')
	    		{
	    			var str = cust.idPedido.toString();
		    		var find = self.idPedidoFiltro;
		    		 
		    			    			
	    			return str.includes(find);
	    		}
	    		else
	    		{
	    			return true;	
	    		}
	    		 
	    		

	    	 });
		},
		pedidosPorColocar:function(){
	    	 var self=this;
	    	 
	    	 return this.pedidos.filter(function(cust){
	    		
	    		if (self.idPedidoFiltro != '')
	    		{
	    			var str = cust.idPedido.toString();
		    		var find = self.idPedidoFiltro;
		    		 
		    			    			
	    			return str.includes(find) && ((cust.explotado == 'SI' && cust.explotadook == 'SI' && cust.fechaEntregaPorDefinir != 'SI' ) ||
	    		       (cust.explotado == 'SI' && cust.explotadook == 'NO' && cust.puedeProducirse == 'SI' && cust.fechaEntregaPorDefinir != 'SI'));
	    		}
	    		else
	    		{
	    			return (cust.explotado == 'SI' && cust.explotadook == 'SI' && cust.fechaEntregaPorDefinir != 'SI' ) ||
	    		       (cust.explotado == 'SI' && cust.explotadook == 'NO' && cust.puedeProducirse == 'SI' && cust.fechaEntregaPorDefinir != 'SI');	
	    		}
	    		 
	    		

	    	 });
	    },
	    pedidosSinMaterial:function(){
	    	 var self=this;
	    	 
	    	 return this.pedidos.filter(function(cust){
	    		
	    		 if (self.idPedidoFiltro != '')
		    		{
		    			var str = cust.idPedido.toString();
			    		var find = self.idPedidoFiltro;
			    		 
			    			    			
		    			return str.includes(find) && ((cust.explotado == 'SI' && cust.explotadook == 'NO' && cust.puedeProducirse == 'NO' ));
		    		}
		    		else
		    		{
		    			return (cust.explotado == 'SI' && cust.explotadook == 'NO' && cust.puedeProducirse == 'NO' );	
		    		}
	    		 
	    		 
	    		

	    	 });
	    },
	    pedidosNoExplotados:function(){
	    	 var self=this;
	    	 
	    	 return this.pedidos.filter(function(cust){
	    		
	    		 if (self.idPedidoFiltro != '')
		    		{
		    			var str = cust.idPedido.toString();
			    		var find = self.idPedidoFiltro;
			    		 
			    			    			
		    			return str.includes(find) && (cust.explotado == 'NO' );
		    		}
		    		else
		    		{
		    			return (cust.explotado == 'NO' );	
		    		}
	    		 
	    		

	    	 });
	    },
	    pedidosPorColocarFechaEntregaPorDefinir:function(){
	    	 var self=this;
	    	 
	    	 return this.pedidos.filter(function(cust){
	 

	    		 if (self.idPedidoFiltro != '')
		    		{
		    			var str = cust.idPedido.toString();
			    		var find = self.idPedidoFiltro;
			    		 
			    			    			
		    			return str.includes(find) && ((cust.explotado == 'SI' && cust.explotadook == 'SI' && cust.fechaEntregaPorDefinir == 'SI' ) ||
		    		       (cust.explotado == 'SI' && cust.explotadook == 'NO' && cust.puedeProducirse == 'SI' && cust.fechaEntregaPorDefinir == 'SI'));
		    		}
		    		else
		    		{
		    			return (cust.explotado == 'SI' && cust.explotadook == 'SI' && cust.fechaEntregaPorDefinir == 'SI' ) ||
		    		       (cust.explotado == 'SI' && cust.explotadook == 'NO' && cust.puedeProducirse == 'SI' && cust.fechaEntregaPorDefinir == 'SI');	
		    		}
	    		 
	    		

	    	 });
	    },
	},
	//////
	methods: {
		verificarBalanceoSucursales: function(){
			var i;
			var j;
			var sumaPiezas = 0;
			
//			console.log(this.productos.length);
			
			for (i = 0; i < this.productos.length ; i++)
			{
//				console.log("dfdsfa");
				this.productos[i].errInventarioSucursal = "";
				this.productos[i].apartadoValido = true;
				sumaPiezas = 0;
				for (j = 0; j < this.productos[i].inventariosucursal.length ; j++)
				{
//					console.log("nerk");
					sumaPiezas = sumaPiezas + parseFloat (this.productos[i].inventariosucursal[j].asignar);
					
					if (this.productos[i].sesacade == "ROLLO")
					{
						this.productos[i].inventariosucursal[j].kg = this.productos[i].inventariosucursal[j].asignar * this.productos[i].pesokiloml;
						
					}
				}
				
//				console.log("sumaPiezas: " + sumaPiezas);
//				console.log("partidaADespachar: " + this.productos[i].detPartidaAApartar);
				
				if (sumaPiezas != this.productos[i].detPartidaAApartar)
				{
					if (! (this.productos[i].detIdProducto == 9 && this.productos[i].inventariosucursal.length == 0) )
					{
						this.productos[i].errInventarioSucursal = "La Cantidad que a Asignado debe ser igual a las Piezas solicitadas. Verifique.";
						this.productos[i].apartadoValido = false;	
					}
						
					
				}
				
			}
		},
		verificarBalanceoSucursal: function(index){
			
			var j;
			var sumaPiezas = 0;
			
//			console.log(this.productos.length);
			
			
//				console.log("dfdsfa");
				this.productos[index].errInventarioSucursal = "";
				this.productos[index].apartadoValido = true;
				
				for (j = 0; j < this.productos[index].inventariosucursal.length ; j++)
				{
//					console.log("nerk");
					sumaPiezas = sumaPiezas + parseFloat (this.productos[index].inventariosucursal[j].asignar);
					this.productos[index].inventariosucursal[j].kg = this.productos[index].inventariosucursal[j].asignar * this.productos[index].pesokiloml;
				}
				
//				console.log("sumaPiezas: " + sumaPiezas);
//				console.log("partidaADespachar: " + this.productos[index].detPartidaAApartar);
				
				if (sumaPiezas != this.productos[index].detPartidaAApartar)
				{
					this.productos[index].errInventarioSucursal = "La Cantidad que a Asignado debe ser igual a las Piezas solicitadas. Verifique.";
					this.productos[index].apartadoValido = false;
				}
				
			
		},
		setValue:function(){		
			this.oldProductos = JSON.parse(JSON.stringify(this.productos));//			
		},
//		addPedido: function(){
//			this.pedidos.push({
//							id: this.pedidos.length + 1,
//							nombreCliente: 'Nombre Cliente'
//						});
//		},
		cargarPedidosAutorizados: function(){
			xajax_obtenerPedidosAutorizados();
			xajax_obtenerPedidosColocados();
		},
		cargarPedido: function(idped){
//			alert("vamos");
			this.sePuedeAsignar = true;
			mdlShowWait("Cargando información.");
			this.idPedido = idped;
			this.cargarDatosPedido();
		},
		cargarPedidoSoloMostrar: function(idped){
//			alert("vamos");
			this.sePuedeAsignar = false;
			mdlShowWait("Cargando información.");
			this.idPedido = idped;
			this.cargarDatosPedido();
		},
		reAsignarPedidoAutomatico: function(idped, index){
			this.idPedidoReasignar = idped;
			
			var texto = "";
			
			if (this.pedidosColocadosAutomaticoFiltrados[index].estado == 'PRODUCCION')
			{
				texto = "El Pedido se R E A S I G N A R Á. El Pedido actualmente está en PRODUCCIÓN, cerciorece de que no haya iniciado el proceso de Fabricación y de destruir cualquier ORDEN DE PRODUCCIÓN impresa.";
			}
			else
			{
				texto = "El Pedido se R E A S I G N A R Á";
			}
			
			swal({
				title: "¿Seguro que quieres continuar?",
				text: texto,
				type: "warning",
				showCancelButton: true,
				cancelButtonText: "NO",
				cancelButtonColor: "#ed5565",
				confirmButtonColor: "#1c84c6",
				confirmButtonText: "¡Adelante! REASIGNAR",
				closeOnConfirm: true },

				function(){
//					swal("¡Hecho!",
//							"Acabas de vender tu alma al diablo.",
//							"success");
					
					swal.close();
//					alert("a autorizar: " + idPedido + '  ' + observacion);
					xajax_reasignarPedido(app.idPedidoReasignar, true);
				
			});
			
			
		},
		reAsignarPedido: function(idped, index){
			this.idPedidoReasignar = idped;
			
			var texto = "";
			
			if (this.pedidosColocadosFiltrados[index].estado == 'PRODUCCION')
			{
				texto = "El Pedido se R E A S I G N A R Á. El Pedido actualmente está en PRODUCCIÓN, cerciorece de que no haya iniciado el proceso de Fabricación y de destruir cualquier ORDEN DE PRODUCCIÓN impresa.";
			}
			else
			{
				texto = "El Pedido se R E A S I G N A R Á";
			}
			
			swal({
				title: "¿Seguro que quieres continuar?",
				text: texto,
				type: "warning",
				showCancelButton: true,
				cancelButtonText: "NO",
				cancelButtonColor: "#ed5565",
				confirmButtonColor: "#1c84c6",
				confirmButtonText: "¡Adelante! REASIGNAR",
				closeOnConfirm: true },

				function(){
//					swal("¡Hecho!",
//							"Acabas de vender tu alma al diablo.",
//							"success");
					
					swal.close();
//					alert("a autorizar: " + idPedido + '  ' + observacion);
					xajax_reasignarPedido(app.idPedidoReasignar);
				
			});
			
			
		},
		cargarDatosPedido: function(){
	//		alert("cargamos");
			
//			if (this.idPedido == "")
//			{
//				saTexto("Indique el Número de Pedido");
//				return;
//			}
//			
//	
//			if (this.idPedido == 0)
//			{
//				saTexto("Indique el Número de Pedido");
//				return;
//			}
			
//			mdlShowWait("Obteniendo información de Pedido");
			
			xajax_cargarPedido(this.idPedido);	
//			this.seleccionarPedido = false;
	//		this.pedidoProduccion = true;			
		},
		asignarPedidoASucursal: function(){
			var i;
			var j;
						
//			console.log(this.productos.length);
			
			if (this.todosRenglonesValidos())
			{
				this.detalleAColocar.splice(0, this.detalleAColocar.length);
				
				for (i = 0; i < this.productos.length ; i++)
				{			
					for (j = 0; j < this.productos[i].inventariosucursal.length ; j++)
					{	
						this.detalleAColocar.push({
							idPedidoDetalle: this.productos[i].idPedidoDetalle,
							idsucursal: this.productos[i].inventariosucursal[j].idsucursal,
							idinventariosucursal: this.productos[i].inventariosucursal[j].idinventariosucursal,
							pdcid: this.productos[i].inventariosucursal[j].pdcid,
							pdccantidad: this.productos[i].inventariosucursal[j].pdccantidad,
							asignar: this.productos[i].inventariosucursal[j].asignar,
							isML: this.productos[i].proShortUnidad == "ML" && this.productos[i].proIdRollo == 1 && this.productos[i].proIdTipoProducto == 1 ? true : false
						});
					
					}
					
				}
				
				mdlShowWait("Asignando Pedido");
				xajax_colocarPedido(this.idPedido, this.detalleAColocar);
			}
			else
			{
				saInfo("No ha Asignado todos los renglones de manera correcta. Verifique por favor.");
			}
			
			
		},
		todosRenglonesValidos: function(){
			var result = true;
			var i;
			var j;
			
//			console.log(this.productos.length);
						
			for (i = 0; i < this.productos.length ; i++)
			{			
				
				console.log(this.productos[i].apartadoValido);
				if (this.productos[i].apartadoValido == false)
				{
					result = false;
					break;
				}
				
			}
			
			return result;
		},
		forzarChecar: function(){
			this.verificarBalanceoSucursales();
		},
		asignarTodoA: function(idSucursal){
			
			var i;
			var j;
						
				
			for (i = 0; i < this.productos.length ; i++)
			{			
				for (j = 0; j < this.productos[i].inventariosucursal.length ; j++)
				{	
					if (this.productos[i].inventariosucursal[j].idsucursal == idSucursal)
					{
						this.productos[i].inventariosucursal[j].asignar = this.productos[i].detPartidaAApartar;
					}
					else
					{
						this.productos[i].inventariosucursal[j].asignar = 0;
					}
				}
				
			
			}
			
			this.verificarBalanceoSucursales();
			
			saInfo("Se ha asignado en pantalla todo a la Sucursal indicada, verifique y guarde los cambios.");
				
		}
	}
	
});

$(document).ready(function()
{
    $("#collapseLeftMenu").click();
    
    
     
});
