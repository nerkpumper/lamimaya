
var app = new Vue ({
	el: '#app',
	data: {
		seleccionarPedido: true,
		idPedido: '',
		estado: '',
		
		//visibilidad
		mostrarEstatus: true,
		mostrarPedido: true,
		
		verMontos: true,
		verExplosionado: false,
		verListoProducit: true,
		verDespachado: true,
		
		//clases
		claseEstatus: '',
		clasePedido: '',
		
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
		total: ''
		
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
	methods: {
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
						
			
			xajax_cargarPedido(this.idPedido);	
			this.seleccionarPedido = false;
	//		this.pedidoProduccion = true;			
		},
		seleccionarOtroPedido: function(){
			this.seleccionarPedido = true;
		}
	}
	
});