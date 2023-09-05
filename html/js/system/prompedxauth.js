

var app = new Vue({
	
	el: '#app',
	data: {
		
		idPedido: 2,
		nombreCliente: '',
		estado: '',
		autorizaCXC: 'SI',
		

		
		showFORMAUTH: false,
		showSELECCIONAPEDIDO: true,
		
		showSECAUTHCTE: false,
		showSECAUTHTOADMIN: false,
		
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
			saldoPedido: 0,
			abonadoPedido: 0,
			pedidoGrande: true,
			
			
			cteDisponibleSinEstePedido: 0,
			cteCredito: 10,
			cteUsado: 5,
			cteDisponible: 5,
			cteDisponibleShow: 0,
			cteATomar: 0,
			cteATomarPromo: 0,
			cteTipoCliente: 'NUEVO',
			
			
			promoCredito: 0,
			promoCredito50: 0,
			promoCredito25: 0,
			promoUsado: 0,
			promoDisponible: 0,
			promoATomar: 0,
			promoATomar4050: 0,
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
	computed: {
		porcentajeAnticipo: function(){
			return (this.frmXCredito.abonadoPedido * 100 / this.frmXCredito.totalPedido).toFixed(2);
		},
		porcentaje4050: function(){
			var result = false;
			
			if (this.frmXCredito.cteTipoCliente == 'NUEVO')
			{
				if (this.porcentajeAnticipo > 50)
				{
					result = true;
				}	
			}
			else
			{
				if (this.porcentajeAnticipo > 40)
				{
					result = true;
				}
			}
			
			
			return result;
		}
	},
	methods: {
		seleccionarOtroPedido: function(){
			this.showFORMAUTH = false;
			this.showSELECCIONAPEDIDO = true;
			this.filtrar();
		},
		seleccionaPedido: function(idPedido){
			this.idPedido = idPedido;
			this.showSECAUTHCTE = false;
			this.showSECAUTHTOADMIN = false;
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
			this.frmXCredito.saldoPedido = 0;
			this.frmXCredito.abonadoPedido = 0;
			
				
			this.frmXCredito.cteCredito = 0;
			this.frmXCredito.promoCredito50 = 0;
			this.frmXCredito.promoCredito25 = 0;
			this.frmXCredito.cteUsado = 0;
			this.frmXCredito.cteDisponible = 0;
			this.frmXCredito.cteTipoCliente = 'NUEVO';
			
				
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
			
			if (this.frmXCredito.cteDisponible < 0)
			{
				this.frmXCredito.cteDisponibleShow = 0;
			}
			else
			{
				this.frmXCredito.cteDisponibleShow = this.frmXCredito.cteDisponible;
			}
			
			this.frmXCredito.abonadoPedido = this.frmXCredito.totalPedido - this.frmXCredito.saldoPedido;
			
			this.frmXCredito.cteATomar = 0;
			this.frmXCredito.promoATomar = 0;
//			this.frmXCredito.disponibleTotal = parseFloat(this.frmXCredito.cteDisponible) + parseFloat(this.frmXCredito.promoDisponible);
//			if (this.frmXCredito.cteDisponible < 0)
//			{
//				this.frmXCredito.disponibleTotal = parseFloat(this.frmXCredito.promoCredito50);
//			}
//			else
//			{
//				this.frmXCredito.disponibleTotal = parseFloat(this.frmXCredito.cteDisponible) + parseFloat(this.frmXCredito.promoCredito50);
//			this.frmXCredito.disponibleTotal = parseFloat(this.frmXCredito.cteDisponibleSinEstePedido) + parseFloat(this.frmXCredito.promoCredito50);
//			}
			
				
//			this.frmXCredito.cteDisponibleSinEstePedido = this.frmXCredito.cteDisponible + this.frmXCredito.totalPedido;
			this.frmXCredito.cteDisponibleSinEstePedido = this.frmXCredito.cteDisponible + this.frmXCredito.saldoPedido;
			
			//aqui poner lo del 25 o 50 por cierto del crédito
			this.frmXCredito.disponibleTotal = parseFloat(this.frmXCredito.cteDisponibleSinEstePedido) + parseFloat(this.frmXCredito.promoCredito50);
			
			
//			if ( parseFloat(this.frmXCredito.cteDisponible)  >= parseFloat(this.frmXCredito.totalPedido) )
//			if ( parseFloat(this.frmXCredito.cteDisponibleSinEstePedido)  >= parseFloat(this.frmXCredito.totalPedido) )
			if ( parseFloat(this.frmXCredito.cteDisponibleSinEstePedido)  >= parseFloat(this.frmXCredito.saldoPedido) )
			{				
				this.showAUTHCTESuccess = true;
				this.showAUTHCTEAutorizar = true;
//				this.frmXCredito.cteATomar = parseFloat(this.frmXCredito.totalPedido);
				this.frmXCredito.cteATomar = parseFloat(this.frmXCredito.saldoPedido);
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
//					this.frmXCredito.cteATomar = this.frmXCredito.cteDisponible + this.frmXCredito.totalPedido;
					this.frmXCredito.cteATomar = this.frmXCredito.cteDisponible + this.frmXCredito.saldoPedido;
					if (this.frmXCredito.cteATomar < 0)
					{
						this.frmXCredito.cteATomar = 0;
					}
				}
			}
			
			if (!this.showAUTHCTESuccess)
			{
//				if ( parseFloat(this.frmXCredito.disponibleTotal)  >= parseFloat(this.frmXCredito.totalPedido) )
				if ( parseFloat(this.frmXCredito.disponibleTotal)  >= parseFloat(this.frmXCredito.saldoPedido) )
				{
					this.showAUTHPROMOSuccess = true;
					this.showAUTHPROMOAutorizar = true;
//					this.frmXCredito.promoATomar = parseFloat( parseFloat(this.frmXCredito.totalPedido) - this.frmXCredito.cteATomar );
					
					this.frmXCredito.cteATomarPromo = this.frmXCredito.cteATomar;
					
					//promo a tomar cuando el cliente paga el 40% o 50%
					this.frmXCredito.promoATomar4050 = parseFloat( parseFloat(this.frmXCredito.saldoPedido) );
					
					if (!this.frmXCredito.pedidoGrande)
					{
						this.frmXCredito.promoATomar = parseFloat( parseFloat(this.frmXCredito.saldoPedido) - this.frmXCredito.cteATomar );
					}
					else
					{
						this.frmXCredito.cteATomarPromo = 0;
						this.frmXCredito.promoATomar = parseFloat( parseFloat(this.frmXCredito.saldoPedido) );	
					}				
				}	
				else
				{
					if (!this.porcentaje4050)
					{
						this.showAUTHPROMODanger = true;
						this.frmXCredito.promoATomar = parseFloat( parseFloat(this.frmXCredito.disponibleTotal) - this.frmXCredito.cteATomar );
						console.log("a tomar promotor: " + this.frmXCredito.promoATomar);
						if (this.frmXCredito.promoATomar < 0)
						{
							this.frmXCredito.promoATomar = 0;
						}	
					}
					else
					{
						this.showAUTHPROMOSuccess = true;
						this.showAUTHPROMOAutorizar = true;
//						this.frmXCredito.promoATomar = parseFloat( parseFloat(this.frmXCredito.totalPedido) - this.frmXCredito.cteATomar );
												
						//promo a tomar cuando el cliente paga el 40% o 50%
						this.frmXCredito.promoATomar4050 = parseFloat( parseFloat(this.frmXCredito.saldoPedido) );
						
							
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
			swal({
				title: "¿Seguro que deseas continuar?",
				text: "La decisión de Autorizar Pedido la tomará CxC.",
				type: "warning",
				showCancelButton: true,
				cancelButtonText: "NO",
				cancelButtonColor: "#ed5565",
				confirmButtonColor: "#1c84c6",
				confirmButtonText: "¡Adelante!",
				closeOnConfirm: false },

				function(){
//					swal("¡Hecho!",
//							"Acabas de vender tu alma al diablo.",
//							"success");
					
					swal.close();
//					alert("a autorizar: " + idPedido + '  ' + observacion);
					xajax_solicitarAuthPedidoCXC(app.idPedido);
				
			});
			
		},
		filtrar: function(){
			xajax_filtrarPedidos(this.filtro);
		}
		
	}
	
	
});