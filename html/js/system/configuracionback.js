
var app = new Vue(
		{
			el : '#app',
			data : {
				
				//Rango M2
				editRangoM2: false,
				
				configRangoM21: '',
				configRangoM22: '',
				configRangoM23: '',
				
				configRangoM21Inicio: 0,
				configRangoM21Fin: 0,
				configRangoM22Inicio: 0,
				configRangoM22Fin: 0,
				configRangoM23Inicio: 0,
				configRangoM23Fin: 0,
				
				editConfigRangoM21Inicio: 0,
				editConfigRangoM21Fin: 0,
				editConfigRangoM22Inicio: 0,
				editConfigRangoM22Fin: 0,
				editConfigRangoM23Inicio: 0,
				editConfigRangoM23Fin: 0,
				
				errEditConfigRangoM21Inicio: '',
				errEditConfigRangoM21Fin: '',
				errEditConfigRangoM22Inicio: '',
				errEditConfigRangoM22Fin: '',
				errEditConfigRangoM23Inicio: '',
				errEditConfigRangoM23Fin: '',
				
				//Peso ML Calibres
				editPesoXCalibre: false,
				
				configPesoCalibre20: 0,
				configPesoCalibre22: 0,
				configPesoCalibre24: 0,
				configPesoCalibre26: 0,
				configPesoCalibre28: 0,
				
				editConfigPesoCalibre20: 0,
				editConfigPesoCalibre22: 0,
				editConfigPesoCalibre24: 0,
				editConfigPesoCalibre26: 0,
				editConfigPesoCalibre28: 0,
				
				errorPesoXCalibre: '',
				
				//Pedido
				
				editPedido: false,
				
				configPedidoDescuento: 0,
				
				editConfigPedidoDescuento: 0,
				
				//Comisiones por rangos
				
				editComisiones: false,
				
				errComisiones: '',
				
				configComisionAlta: '',
				configComisionMedia: '',
				configComisionBaja: '',
				
				
				configComision1Rango1: 0,
				configComision1Rango2: 0,
				configComision1Rango3: 0,
				
				configComision2Rango1: 0,
				configComision2Rango2: 0,
				configComision2Rango3: 0,
				
				configComision3Rango1: 0,
				configComision3Rango2: 0,
				configComision3Rango3: 0,
				
				editConfigComision1Rango1: 0,
				editConfigComision1Rango2: 0,
				editConfigComision1Rango3: 0,
				
				editConfigComision2Rango1: 0,
				editConfigComision2Rango2: 0,
				editConfigComision2Rango3: 0,
				
				editConfigComision3Rango1: 0,
				editConfigComision3Rango2: 0,
				editConfigComision3Rango3: 0
				
				
				
			},
			mounted : function() {				
					
				xajax_cargarConfiguracion();				
			},

			methods : {
				//Comisiones
				activarComisiones: function(){
					
					this.editConfigComision1Rango1 = this.configComision1Rango1;
					this.editConfigComision1Rango2 = this.configComision1Rango2;
					this.editConfigComision1Rango3 = this.configComision1Rango3;
					
					this.editConfigComision2Rango1 = this.configComision2Rango1;
					this.editConfigComision2Rango2 = this.configComision2Rango2;
					this.editConfigComision2Rango3 = this.configComision2Rango3;
					
					this.editConfigComision3Rango1 = this.configComision3Rango1;
					this.editConfigComision3Rango2 = this.configComision3Rango2;
					this.editConfigComision3Rango3 = this.configComision3Rango3;
					
					this.editComisiones = true;
				},
				desactivarComisiones: function(){
					this.editComisiones = false;
				},
				guardarComisiones: function(){
					
					var seguir = true;
					
					this.errComisiones = '';
					
					if (this.editConfigComision1Rango1 == "" ||
						this.editConfigComision1Rango2 == "" ||
						this.editConfigComision1Rango3 == "" ||
						this.editConfigComision2Rango1 == "" ||
						this.editConfigComision2Rango2 == "" ||
						this.editConfigComision2Rango3 == "" ||
						this.editConfigComision3Rango1 == "" ||
						this.editConfigComision3Rango2 == "" ||
						this.editConfigComision3Rango3 == "" )
					{						
						seguir = false;
					}
					
					
					if (seguir)
					{
						this.configComision1Rango1 = this.editConfigComision1Rango1;
						this.configComision1Rango2 = this.editConfigComision1Rango2;
						this.configComision1Rango3 = this.editConfigComision1Rango3;
						
						this.configComision2Rango1 = this.editConfigComision2Rango1;
						this.configComision2Rango2 = this.editConfigComision2Rango2;
						this.configComision2Rango3 = this.editConfigComision2Rango3;
						
						this.configComision3Rango1 = this.editConfigComision3Rango1;
						this.configComision3Rango2 = this.editConfigComision3Rango2;
						this.configComision3Rango3 = this.editConfigComision3Rango3;
						
						
						xajax_guardarConfiguracionComisiones(this.editConfigComision1Rango1,
															 this.editConfigComision1Rango2,
															 this.editConfigComision1Rango3,
															 this.editConfigComision2Rango1,
															 this.editConfigComision2Rango2,
															 this.editConfigComision2Rango3,
															 this.editConfigComision3Rango1,
															 this.editConfigComision3Rango2,
															 this.editConfigComision3Rango3);
					}
					else
					{
						this.errComisiones = "Debe agregar valor a cada rango de Comisi&oacute;n";
					}
					
				},
				//Pedido
				activarPedido: function(){
					this.editConfigPedidoDescuento = this.configPedidoDescuento;
					this.editPedido = true;
				},
				desactivarPedido: function(){
					this.editPedido = false;
				},
				guardarPedido: function(){
					
					if (this.editConfirPedidoDescuento == "")
					{
						this.editConfigPedidoDescuento = 0;
					}
					
					this.configPedidoDescuento = this.editConfigPedidoDescuento;
					
					xajax_guardarConfiguracionPedido(this.editConfigPedidoDescuento);
					
				},
				//Peso X Calibre
				activarPesoXCalibre: function(){
					this.editConfigPesoCalibre20 = this.configPesoCalibre20;
					this.editConfigPesoCalibre22 = this.configPesoCalibre22; 
					this.editConfigPesoCalibre24 = this.configPesoCalibre24;
					this.editConfigPesoCalibre26 = this.configPesoCalibre26;
					this.editConfigPesoCalibre28 = this.configPesoCalibre28;
					this.editPesoXCalibre=true;
				},
				desactivarPesoXCalibre: function(){
					this.editPesoXCalibre=false;
				},
				guardarPesoXCalibre: function(){
					var seguir = true;					
										
					this.limpiaErrores();
					this.errorPesoXCalibre = "nrk";
					
					if (this.editConfigPesoCalibre20 == "" || parseFloat(this.editConfigPesoCalibre20) <= 0)
					{
						this.errorPesoXCalibre = this.errorPesoXCalibre + "<br>" + "El Peso KG de Calibre 20 debe ser mayor a 0.";
						seguir = false;
					}
					
					if (this.editConfigPesoCalibre22 == "" || parseFloat(this.editConfigPesoCalibre22) <= 0)
					{
						this.errorPesoXCalibre = this.errorPesoXCalibre + "<br>" + "El Peso KG de Calibre 22 debe ser mayor a 0.";
						seguir = false;
					}
					
					if (this.editConfigPesoCalibre24 == "" || parseFloat(this.editConfigPesoCalibre24) <= 0)
					{
						this.errorPesoXCalibre = this.errorPesoXCalibre + "<br>" + "El Peso KG de Calibre 24 debe ser mayor a 0.";
						seguir = false;
					}
					
					if (this.editConfigPesoCalibre26 == "" || parseFloat(this.editConfigPesoCalibre26) <= 0)
					{
						this.errorPesoXCalibre = this.errorPesoXCalibre + "<br>" + "El Peso KG de Calibre 26 debe ser mayor a 0.";
						seguir = false;
					}
					
					if (this.editConfigPesoCalibre28 == "" || parseFloat(this.editConfigPesoCalibre28) <= 0)
					{
						this.errorPesoXCalibre = this.errorPesoXCalibre + "<br>" + "El Peso KG de Calibre 28 debe ser mayor a 0.";
						seguir = false;
					}
					
					this.errorPesoXCalibre = this.errorPesoXCalibre.replace("nrk<br>", "");
					this.errorPesoXCalibre = this.errorPesoXCalibre.replace("nrk", "");
					
					if (seguir)
					{
						this.configPesoCalibre20 = this.editConfigPesoCalibre20;
						this.configPesoCalibre22 = this.editConfigPesoCalibre22; 
						this.configPesoCalibre24 = this.editConfigPesoCalibre24;
						this.configPesoCalibre26 = this.editConfigPesoCalibre26;
						this.configPesoCalibre28 = this.editConfigPesoCalibre28;
						
						
						xajax_guardarConfiguracionPrecioXCalibre(this.editConfigPesoCalibre20,
								                                 this.editConfigPesoCalibre22,
																 this.editConfigPesoCalibre24,
																 this.editConfigPesoCalibre26,
																 this.editConfigPesoCalibre28
						);
					}
					
					
					
					
				},
				//Fin Peso X Calibre
				//Rango M2
				activarEdicionRangoM2: function(){
					this.editConfigRangoM21Inicio = this.configRangoM21Inicio;
					this.editConfigRangoM21Fin = this.configRangoM21Fin;  
					this.editConfigRangoM22Inicio = this.configRangoM22Inicio; 
					this.editConfigRangoM22Fin = this.configRangoM22Fin; 
					this.editConfigRangoM23Inicio = this.configRangoM23Inicio;
					this.editConfigRangoM23Fin = this.configRangoM23Fin; 
					this.editRangoM2=true;
				},
				desactivarEdicionRangoM2: function(){
					this.editRangoM2=false;
				},
				guardarRangoM2: function(){
					var seguir = true;					
					
					this.limpiaErrores();
					
					if (parseInt(this.editConfigRangoM21Inicio) > parseInt(this.editConfigRangoM21Fin))
					{
						this.errConfigRangoM21Inicio = "El rango inicial debe ser menor o igual al final";
						seguir = false;
					}				
					
					
					if (parseInt(this.editConfigRangoM22Inicio) > parseInt(this.editConfigRangoM22Fin))
					{
						this.errConfigRangoM22Inicio = "El rango inicial debe ser menor o igual al final";
						seguir = false;
					}
					
					
					if (parseInt(this.editConfigRangoM23Inicio) > parseInt(this.editConfigRangoM23Fin))
					{
						this.errConfigRangoM23Inicio = "El rango inicial debe ser menor o igual al final";
						seguir = false;
					}
					
					if (parseInt(this.editConfigRangoM21Fin) >= parseInt(this.editConfigRangoM22Inicio))
					{
						this.errConfigRangoM21Fin = "El rango final debe ser menor al inicial del siguiente rango";
						seguir = false;
					}
					
					if (parseInt(this.editConfigRangoM22Fin) >= parseInt(this.editConfigRangoM23Inicio))
					{
						this.errConfigRangoM22Fin = "El rango final debe ser menor al inicial del siguiente rango";
						seguir = false;
					}				
					
					if (seguir)
					{
						this.configRangoM21Inicio = this.editConfigRangoM21Inicio;
						this.configRangoM21Fin = this.editConfigRangoM21Fin;  
						this.configRangoM22Inicio = this.editConfigRangoM22Inicio; 
						this.configRangoM22Fin = this.editConfigRangoM22Fin; 
						this.configRangoM23Inicio = this.editConfigRangoM23Inicio;
						this.configRangoM23Fin = this.editConfigRangoM23Fin; 
						
						
						xajax_guardarConfiguracion(this.editConfigRangoM21Inicio, 
								                   this.editConfigRangoM21Fin,
								                   this.editConfigRangoM22Inicio, 
								                   this.editConfigRangoM22Fin,
								                   this.editConfigRangoM23Inicio, 
								                   this.editConfigRangoM23Fin);
					}
					
				},
				//Fin Rango M2
				

				limpiaErrores : function() {
					this.errConfigRangoM21Inicio = '';
					this.errConfigRangoM21Fin = '';
					this.errConfigRangoM22Inicio = '';
					this.errConfigRangoM22Fin = '';
					this.errConfigRangoM23Inicio = '';
					this.errConfigRangoM23Fin = '';
					this.errorPesoXCalibre = '';
				},
				pruebaGetNotificaciones: function(){
					globalHeaderNotificaciones();
				}
//				fnRegresarAListado : function() {
//					window.location = URL_BASE + "lamina";
//				}
			}

		});




//watch : {
//tipoProducto : function(val) {
//	xajax_obtenerClaveTipoProducto(val);
//},
//modeloLamina : function(val) {
//	xajax_obtenerClaveModeloLamina(val);
//},
//claveTipoProducto : function(val) {
//	if (val != "L") {
//		this.modeloLamina = '0=>';
//	}
//},
//material : function(val) {
//	xajax_obtenerClaveMaterial(val);
//}
//},
//computed : {
//codigoGenerado : function() {
//
//	if (this.idLamina == 0) {
//		this.codigo = this.claveTipoProducto
//				+ this.claveMaterial + this.textoModeloLamina
//				+ "C" + this.calibre;
//
//		this.errCodigo = '';
//		this.sucCodigo = '';
//
//		if (this.idTipoProducto == 0
//				|| this.idMaterial == 0
//				|| this.calibre == "0"
//				|| (this.idModeloLamina == 0 && this.claveTipoProducto == "L")) {
//			this.errCodigo = "El Código no está completo, es necesario seleccionar valores de las listas inferiores.";
//		} else {
//			this.sucCodigo = "El Código está completo.";
//		}
//
//		return this.codigo;
//	} else {
//		this.errCodigo = '';
//		this.sucCodigo = '';
//	}
//}
//},