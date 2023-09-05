

var app = new Vue({
	
	el: '#app',
	data: {
		
		idPedido: 2,
		nombreCliente: '',
		estado: '',
		autorizaCXC: 'SI',
		
		idValeSalida: 0, 
		indexValeSalida: 0,
		
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
		
//		Permitir vale
		chkPedidoSaldado: 'NO',
		chkDireccionCorrecta: false,
		chkDiaCorrecto: false,
		chkHorarioCorrecto: false,
		chkEquipoListo: false,
		chkPersonaCorrecta: false,
		chkHayEspacio: false,
		
		chkImprimirPedidoNoSaldado: false,
		
		yaSeFiltro: false,
		
		showFORMAUTH: false,
		showSELECCIONAPEDIDO: true,
		
		showSECAUTHCTE: false,
		showSECAUTHTOADMIN: false,
		
		//observacion aunno
		valesalidaAunNo: 0,
		observacionAunNo: '',
		indexAunNo: 0,
		
		//Elementos de SECAUTHCTE
				//parte Cte
		showAUTHCTESuccess: false,
		showAUTHCTEDanger: false,
		showAUTHCTEAutorizar: false,
		
		        //parte Promo
		showAUTHPROMOSuccess: false,
		showAUTHPROMOWarning: false,
		showAUTHPROMODanger: false,
		showAUTHPROMOAutorizar: false,
		
		frmXCredito: {
			idPedido: '99',
			totalPedido: 1,
			
			cteDisponibleSinEstePedido: 0,
			cteCredito: 10,
			cteUsado: 5,
			cteDisponible: 5,
			cteATomar: 0,			
			
			promoCredito: 20,
			promoUsado: 5,
			promoDisponible: 15,
			promoATomar: 0,
			promoBloquedado: 'NO',	
			
			disponibleTotal: 0
		},
		
		filtro: {
			noPedido: '',
			idCliente: 0
		},
		
		pedidos: []
	},
	mounted: function(){
//		this.prepararPedido();
	},
	watch: {
		observacionAunNo: function(val){
			this.observacionAunNo = val.toUpperCase();
		}
	},
	methods: {
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
					closeOnConfirm: false },

					function(){
//						swal("¡Hecho!",
//								"Acabas de vender tu alma al diablo.",
//								"success");
						
						swal.close();
//						alert("a autorizar: " + idPedido + '  ' + observacion);
						xajax_setValeSalidaAunNo(app.valesalidaAunNo, app.observacionAunNo, app.indexAunNo);
					
				});
		},
		pedidoAunNoValeSalida: function(idValeSalids, index){
			this.valesalidaAunNo = idValeSalids;
			this.indexAunNo = index;
			this.observacionAunNo = "";
			
			$('#modalIndicaMotivoAunNo').modal('show');
		},
		setPedidoSiValeSalida: function(idPedido, idValeSalida, index){
			this.idPedido = idPedido;
			this.idValeSalida = idValeSalida; 
			this.indexValeSalida = index;
			setTimeout(function() { xajax_cargarDatosValeYPedido(idPedido, idValeSalida)}, 150) ;
			$('#modalCheckList').modal('show');
		},
		pedidoSiValeSalida: function(){
			
//			xajax_pedidoSiValeSalida(idpedido, index);
			$('#modalCheckList').modal('hide');
			
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
							
							xajax_pedidoSiValeSalida(app.idValeSalida, app.indexValeSalida, 
									app.chkPedidoSaldado,
									app.chkDireccionCorrecta, 
									app.chkDiaCorrecto, 							
									app.chkHorarioCorrecto,
									app.chkEquipoListo,
									app.chkPersonaCorrecta,
									app.chkHayEspacio,							
									app.chkImprimirPedidoNoSaldado);	
							
							
						}, 150);
						
						
					
				});
				
				
			}, 150);
		},
		seleccionarOtroPedido: function(){
			this.showFORMAUTH = false;
			this.showSELECCIONAPEDIDO = true;
			this.filtrar();
		},
		seleccionaPedido: function(idPedido){
			this.idPedido = idPedido;
			this.prepararPedido();
		},
		prepararPedido: function(){
			this.showFORMAUTH = true;
			this.showSELECCIONAPEDIDO = false;
			xajax_prepararPedido(this.idPedido)
		},
		cargarPedidoCreditos: function(){
			this.limpiaFrmXCredito();
			this.hideSections();
			this.showSECAUTHCTE = true;
//			alert("a cargar pedidos");
//			this.idPedido = 5;
			xajax_cargarPedidoCreditos(this.idPedido);
		},
		limpiaFrmXCredito: function(){			
			this.frmXCredito.idPedido = '0';
			this.frmXCredito.totalPedido = 0;
				
			this.frmXCredito.cteCredito = 0;
			this.frmXCredito.cteUsado = 0;
			this.frmXCredito.cteDisponible = 0;
				
			this.frmXCredito.promoCredito = 0;
			this.frmXCredito.promoUsado = 0;
			this.frmXCredito.promoDisponible = 0;
			this.frmXCredito.promoBloquedado = 'NO';
		},
		hideSections: function(){
			this.showSECAUTHCTE = false;
			this.showSECAUTHTOADMIN = false;
		},
		prepararFrmXCredito: function(){
//			frmXCredito: {
//				idPedido: '99',
//				totalPedido: 1,
//				
//				cteCredito: 10,
//				cteUsado: 5,
//				cteDisponible: 5,
//              cteATomar: 0,			
//				
//				promoCredito: 20,
//				promoUsado: 5,
//				promoDisponible: 15,
//              promoATomar: 0,		
//				promoBloquedado: 'NO',
//			disponibleTotal: 0
//			},
			this.hideNotificacionesFrmXCredito();
			
			this.frmXCredito.cteATomar = 0;
			this.frmXCredito.promoATomar = 0;
			this.frmXCredito.disponibleTotal = parseFloat(this.frmXCredito.cteDisponible) + parseFloat(this.frmXCredito.promoDisponible);
				
			this.frmXCredito.cteDisponibleSinEstePedido = this.frmXCredito.cteDisponible + this.frmXCredito.totalPedido;
			
//			if ( parseFloat(this.frmXCredito.cteDisponible)  >= parseFloat(this.frmXCredito.totalPedido) )
			if ( parseFloat(this.frmXCredito.cteDisponibleSinEstePedido)  >= parseFloat(this.frmXCredito.totalPedido) )
			{
				this.showAUTHCTESuccess = true;
				this.showAUTHCTEAutorizar = true;
				this.frmXCredito.cteATomar = parseFloat(this.frmXCredito.totalPedido);
			}
			else
			{
				this.showAUTHCTEDanger = true;
				if ( parseFloat(this.frmXCredito.cteDisponible) > 0 )
				{
					this.frmXCredito.cteATomar = parseFloat(this.frmXCredito.cteDisponible);
				}
				else
				{
//					this.frmXCredito.cteATomar = 0;
					this.frmXCredito.cteATomar = this.frmXCredito.cteDisponible + this.frmXCredito.totalPedido;
					if (this.frmXCredito.cteATomar < 0)
					{
						this.frmXCredito.cteATomar = 0;
					}
				}
			}
			
			if (!this.showAUTHCTESuccess)
			{
				if ( parseFloat(this.frmXCredito.disponibleTotal)  >= parseFloat(this.frmXCredito.totalPedido) )
				{
					this.showAUTHPROMOSuccess = true;
					this.showAUTHPROMOAutorizar = true;
					this.frmXCredito.promoATomar = parseFloat( parseFloat(this.frmXCredito.totalPedido) - this.frmXCredito.cteATomar );
				}	
				else
				{
					this.showAUTHPROMODanger = true;
					this.frmXCredito.promoATomar = parseFloat( parseFloat(this.frmXCredito.disponibleTotal) - this.frmXCredito.cteATomar );
					if (this.frmXCredito.promoATomar < 0)
					{
						this.frmXCredito.promoATomar = 0;
					}
				}
			}
			else
			{
				this.showAUTHPROMOWarning = true;
			}
		},
		hideNotificacionesFrmXCredito: function(){
			this.showAUTHCTESuccess = false;
			this.showAUTHCTEDanger = false;
			this.showAUTHCTEAutorizar = false;
						        
			this.showAUTHPROMOSuccess = false;
			this.showAUTHPROMOWarning = false;
			this.showAUTHPROMODanger = false;
			this.showAUTHPROMOAutorizar = false;
		},
		autorizarXCreditoCliente: function(){
			xajax_autorizarXCreditoCliente(this.frmXCredito.idPedido);
		},
		autorizarXCreditoPromotor: function(){
			xajax_autorizarXCreditoPromotor(this.frmXCredito.idPedido, this.frmXCredito.promoATomar);
		},
		solicitaAuthCXC: function(){
			
			this.hideSections();
			this.showSECAUTHTOADMIN = true;

			
		},
		solicitarAuthPedidoCXC: function(){
			xajax_solicitarAuthPedidoCXC(this.idPedido);
		},
		filtrar: function(){
			xajax_filtrarPedidos(this.filtro);
		}
		
	}
	
	
});