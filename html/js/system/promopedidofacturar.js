

var app = new Vue ({
	el: '#app',
	data: {
		seleccionarPedido: true,
		idPedido: '',
		idCliente : '',
		idClienteDatoFacturacion: 0,	
		estado: '',
		observacionCancelacion: '',
		facRegimenFiscal: 0,
		
		//banderas
		pedidoCancelado: false,
		estatusIncorrecto: false,
		puedeCancelarse: false,
		chkEditFactura:false,
		
	
		
		//visibilidad
		mostrarEstatus: false,
		mostrarPedido: true,
		mostrarSolfactura: false,
		
		verMontos: true,
		verExplosionado: false,
		verListoProducit: true,
		verDespachado: true,
		
		//clases
		claseEstatus: '',
		clasePedido: '',
		
		//
		mostrarFactura: true,
		facturaSolicitada: '',
		
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
		cancelaObservacion: '',
		
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
        
        //consignacion
        personaEntrega: '',
        recogeentrega: '',
        domicilioEntrega: '',
        numeroEntrega: '',
        coloniaEntrega: '',
        ciudadEntrega: '',
        
        //detalle productos
        productos: [],

		//totales
		subtotal: '',
		descuento: '',
		total: '',

		//factura
		razonSocial:'',
		domicilioFiscal:'',
		cpFiscal:'',		
		
		errRazonSocial:'',
		errCteRFC:'',
		errIdPedido:'',
		errTelefonos:'',
		errCteEMail:'',
		errDomicilioFiscal:'',
		errCpFiscal:'',
		
		
		
		// PARA LA F A C T U R A 
			
		facRazonSocial: '',
		facDomicilio: '',
		facNumero: '',
		facCP: '',
		facColonia: '',
		facCiudad: '',
		facTelefono: '',
		facEmail: '',
		facRFC: '',
		facCFDI: 0,
		
		errFacRazonSocial: '',
		errFacDomicilio: '',
		errFacNumero: '',
		errFacCP: '',
		errFacColonia: '',
		errFacCiudad: '',
		errFacTelefono: '',
		errFacEmail: '',
		errFacRFC: '',
		errFacCFDI: ''
		
	},	 
	mounted: function(){		
		if (typeof param1 !== 'undefined') {
			this.idPedido = param1;
			this.cargarDatosPedido();					
		}
		
		if (this.mostrarEstatus && this.mostrarPedido)
		{
			this.claseEstatus = "col-lg-3 col-md-3 col-sm-12 col-xs-12";
			this.clasePedido = "col-lg-9 col-md-9 col-sm-12 col-xs-12";
		}
		else
		{
			this.claseEstatus = "";
			this.clasePedido = "col-lg-12 col-md-12 col-sm-12 col-xs-12";
		}
			
	},	
	watch: {
		observacionCancelacion: function (val){
			this.observacionCancelacion = val.toUpperCase();
		}
	},
	methods: {
		cambiarIdClienteDatosFacturacion: function(){
			xajax_cambiarIdClienteDatosFacturacion(this.idPedido, this.idClienteDatoFacturacion);
		},
		onDirSelected: function(event){
			this.facturaSolicitada= "";
			// console.log(event.idClienteDatosFacturacion);
			this.idClienteDatoFacturacion = event.idClienteDatosFacturacion;
			this.cambiarIdClienteDatosFacturacion();
			// this.idClienteDatosFacturacion = event.idClienteDatosFacturacion;
			// this.levantarOConvertirAPedidoCall();				
		},
		seleccionarDirFiscal: function(){
			this.$refs.nuevaDireccionExistente.show(this.idCliente, this.cteNombre+ ' ' + this.cteApellidos, false, this.idClienteDatoFacturacion); 				

		},
		cargarDatosPedido: function(){
	//		alert("cargamos");

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
						
			this.pedidoCancelado = false;
			this.estatusIncorrecto = false;
			this.puedeCancelarse = false;
			
			xajax_cargarPedido(this.idPedido);	
			this.seleccionarPedido = false;
			 
	//		this.pedidoProduccion = true;			
		},		
		solicitarFactura: function(){
		
			swal({
				title: "¿Seguro que deseas continuar?",
				text: "Se solicitará factura.",
				type: "info",
				showCancelButton: true,
				cancelButtonText: "NO",
				cancelButtonColor: "#ed5565",
				confirmButtonColor: "#1c84c6",
				confirmButtonText: "¡Adelante!",
				closeOnConfirm: false },

				function(){
					//swal("¡Hecho!",
					//		"Acabas de vender tu alma al diablo.",
					//		"success");
					
					swal.close();
//					alert("a autorizar: " + idPedido + '  ' + observacion);
					
					xajax_solicitarFactura(app.idPedido, app.facCFDI);
				
			});
				
		},
		activarEdicionFactura:function()
		{
			$("#guardarEdicionFactura").css("display","block");
			$("#desactivarEdicionFactura").css("display","block");
			$("#activarEdicionFactura").css("display","none");
			$("#facRazonSocial").removeAttr("disabled");
			$("#facRazonSocial").focus();
			$("#facRFC").removeAttr("disabled");
			$("#facDomicilio").removeAttr("disabled");
			$("#facCP").removeAttr("disabled");
			$("#facTelefono").removeAttr("disabled");
			$("#facEmail").removeAttr("disabled");
			
			$("#facNumero").removeAttr("disabled");
			$("#facColonia").removeAttr("disabled");
			$("#facCiudad").removeAttr("disabled");
			$("#facCFDI").removeAttr("disabled");
			
			
			var ValSolFactra=true;
    	
			if($("#facRazonSocial").val()==""){ValSolFactra=false;}
			if($("#facRFC").val()==""){ValSolFactra=false;}
			if($("#facDomicilio").val()==""){ValSolFactra=false;}
			if($("#facCP").val()==""){ValSolFactra=false;}
			if($("#facTelefono").val()==""){ValSolFactra=false;}
			if($("#facEmail").val()==""){ValSolFactra=false;}
			if($("#facNumero").val()==""){ValSolFactra=false;}
			if($("#facColonia").val()==""){ValSolFactra=false;}
			if($("#facCiudad").val()==""){ValSolFactra=false;}
			if (this.facCFDI == 0) {ValSolFactra=false;}
			
			
			
			if(ValSolFactra)
			{
				mostrarSolfactura=true;
			}else
			{
				mostrarSolfactura=false;
			}

		},
		guardarEdicionFactura:function()
		{
			this.limpiarErrores();
			var seguir = true;
//			console.log("empezamos");
			if (this.facRazonSocial.trim() == "")
			{
				this.errFacRazonSocial ="Debe agregar la Razón Social";
//				console.log("Error rzon");
				seguir =false;
			}
			if(this.facRFC.trim()=="")
			{
				this.errFacRFC ="Debe agregar el RFC";
//				console.log("Error rfc");
				seguir =false;
			}
			if(this.facDomicilio.trim()=="")
			{
				this.errFacDomicilio ="Debe agregar el Domicilio Fiscal";
//				console.log("Error dom");
				seguir =false;
			}
			if(this.facCP.trim()=="")
			{
				this.errFacCP ="Debe agregar el C.P.";
//				console.log("Error cp");
				seguir =false;
			}
			
			if(this.facTelefono.trim()=="")
			{
				this.errFacTelefono ="Debe agregar el Teléfono";
//				console.log("Error te");
				seguir =false;
			}
			if(this.facEmail.trim()=="")
			{
				this.errFacEmail ="Debe agregar el Email";
//				console.log("Error em");
				seguir =false;
			}else
			{
				if (!this.validEmail (this.facEmail.trim()))
				{
					this.errFacEmail = "El dato EMail no tiene un formato correcto.";
//					console.log("Error emno");
					seguir = false;
				}
			}
			
			if(this.facNumero.trim()=="")
			{
				this.errFacNumero ="Debe agregar Numero";
//				console.log("Error num");
				seguir =false;
			}
			if(this.facColonia.trim()=="")
			{
				this.errFacColonia ="Debe agregar el Colonia";
//				console.log("Error col");
				seguir =false;
			}
			if(this.facCiudad.trim()=="")
			{
				this.errFacCiudad ="Debe agregar el Ciudad";
//				console.log("Error ciu");
				seguir =false;
			}
			if(this.facCFDI == 0)
			{
				this.errFacCFDI ="Debe indicar uso CFDI";
//				console.log("Error cfdi");
				seguir =false;
			}
			
			
			
	if (seguir){
//		alert("seguir");
			xajax_guardarEdicionFactura(this.idCliente, 
										this.facRazonSocial,
										this.facDomicilio,
										this.facNumero,
										this.facCP,
										this.facColonia,
										this.facCiudad,
										this.facTelefono,
										this.facEmail,
										this.facRFC,
										this.facCFDI,
					                    this.idPedido);
	}
		},
		limpiarErrores:function()
		{

			this.errFacRazonSocial = "";
			this.errFacDomicilio = "";
			this.errFacNumero = "";
			this.errFacCP = "";
			this.errFacColonia = "";
			this.errFacCiudad = "";
			this.errFacTelefono = "";
			this.errFacEmail = "";
			this.errFacRFC = "";
			this.errFacCFDI = "";
			
			
		},validEmail:function(email) {
		      var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		      return re.test(email);
		      },
		desactivarEdicionFactura:function()
		{
			this.limpiarErrores();
			
			$("#guardarEdicionFactura").css("display","none");
			$("#desactivarEdicionFactura").css("display","none");
			$("#activarEdicionFactura").css("display","block");
			$("#facRazonSocial").attr("disabled","disabled");
			$("#facDomicilio").attr("disabled","disabled");
			$("#facNumero").attr("disabled","disabled");
			$("#facCP").attr("disabled","disabled");
			$("#facColonia").attr("disabled","disabled");
			$("#facCiudad").attr("disabled","disabled");
			$("#facTelefono").attr("disabled","disabled");
			$("#facEmail").attr("disabled","disabled");
			$("#facRFC").attr("disabled","disabled");
			$("#facCFDI").attr("disabled","disabled");
			
			this.pedidoCancelado = false;
			this.estatusIncorrecto = false;
			this.puedeCancelarse = false;
			
			xajax_cargarPedido(this.idPedido);	
			this.seleccionarPedido = false;
			
		}
	}
	
});