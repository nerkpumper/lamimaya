

var app = new Vue({
	el: '#app',
	data: {
		
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
		molCantidad: 1,
		molCantUnidad: 3.05,
		molDesarrollo: '0',
		molIdRollo: 0,
		molStrTemp: '',
		molDobleces: 1,
		molPiesXDesarrollo: 0,
		molDividirLamina: 0,
		molPrecioRollo: 0,
		
				

		// nos traemos todos los rollos, con sus existencias
		rollosExistencias: [],
		piezasExistencias: [],

		mostrarBotonGuardar: true,

		//datos pedido
		pedidoFolio: 0,

		vistaPedido: false,
		seleccionaCliente: true,
		imprimirPedido: true,
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

		rango1InicioMultipanel: 1,
		rango1FinMultipanel: 0,
		rango2InicioMultipanel: 0,
		rango2FinMultipanel: 0,
		rango3InicioMultipanel: 0,

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



		seleccionandoCliente: false,
		clientes: [],
		filtroNombreCliente: '',

		//Modal
		indexModal: -1,
		indexAEnlistarModal: -1,
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

		maxTipoPrecioGalvamexMultipanel: 1,
		tipoPrecioGalvamexMultipanel: 1,

		subtotalPedido: 0,
		ivaPedido: 0,
		descuentoPedido: 0,
		porDescuento: 0,
		totalPedido: 0,

		totalML: 0,
		totalMLAcryOpa: 0,
		totalMLMultipanel: 0,

		selDescuentoIndividual: 0,

		//RecogeRecibe
		selRecogeRecibe: 'NOSEL',
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

		horaEntrega: '',


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
//alert("a cargar productos");
//		this.respaldaListado();
		this.cargarProductos();
		this.cargarRollos();
//		this.cargarRangos();
		this.cargarTiposProducto();
		this.cargarOtrosCargos();

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
		xajax_cargarClienteMostador(1);




	},
	watch: {
		otrosCargos: {
				handler: function (after, before) {
//				console.log("a ver");
				var toc = 0;
				var i;
//				console.log("Parece que algo cambió");
				for (i = 0; i < this.otrosCargos.length ; i++)
				{
					toc = toc + Number(this.otrosCargos[i].monto);
				}
					
					
//				this.setValue();
//				console.log("Total: " + toc);
				this.totalOtrosCargos = toc;
				this.calculaTotales();
				},
	      deep: true,
		},
		molIdRollo: function(val){
			var i = 0;
			
			this.molStrTemp = '';
			this.molPrecioRollo = 0;
			
			for(i=0; i < this.rollosExistencias.length ; i++)
			{
				if (this.rollosExistencias[i].idrollo == val)
				{
					this.molStrTemp = " -- " + this.rollosExistencias[i].descauto;
					this.molPrecioRollo = this.rollosExistencias[i].precio1;
					break;
				}
			}
			
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
		selDescuentoIndividual: function(val){
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
		}
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
		rollosExistenciasXDesarrollo:function(){

	    	 var self=this;
	    	 return this.rollosExistencias.filter(function(cust){

	    		 return cust.pies == app.molPiesXDesarrollo;

	    	 });
	       //return this.customers;
	    },
		mostrarUnidadEnModal: function(){
			return this.shortUnidadModal != 'PZA' && this.shortUnidadModal != 'KG';
		},
		labelUnidadEnModal: function(){
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
		levantarPedido: function(){

			if (this.totalPedido <= 0)
			{
				saInfo ("No se puede levantar el Pedido, el Total debe ser mayor a Cero Pesos.");
				return false;
			}

//			this.mostrarBotonGuardar = false;
			var seguir = true;
			var fechaEngrega = $("#dtFechaEntrega").val();
			var strHoraEntrega = "";
			var today = new Date();
			var dd = today.getDate();
			var mm = today.getMonth()+1; //January is 0!
			var yyyy = today.getFullYear();

//			alert(fechaEngrega);
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

			if (this.listadoPedido.length <= 0)
			{
				saInfo("No se han capturado productos al Pedido.");
				this.mostrarBotonGuardar = true;
				return;
			}

			if (this.idClienteSeleccionado == 0)
			{
				saInfo("No ha seleccionado un Cliente.");
				this.mostrarBotonGuardar = true;
				return;
			}

			if (this.selRecogeRecibe == "NOSEL")
			{
				saInfo("No ha indicado si el Pedido se lo lleva el Cliente o se le Envía.");
				this.mostrarBotonGuardar = true;
				return;
			}

			if (this.selTipoPedido == "0")
			{
				saInfo("Debe indicar el tipo de Producto");
				this.mostrarBotonGuardar = true;
				return;
			}


			var strNombre = this.clienteSeleccionado;
			var strDireccion = this.cteSelDomicilio1 + ' ' + this.cteSelDomicilio2;
			var strNumero = this.cteSelNumero;
			var strColonia = this.cteSelColonia;
			var strCiudad = this.cteSelCiudad;
			strFESave = "";
			strHoraEntrega = "";

			if (this.selRecogeRecibe == "ENTREGA")
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

				if (parseInt(strToday) > parseInt(strFE))
				{
					this.errFechaEntrega = "La Fecha de Entrega debe ser posterior o igual al día de hoy.";

//					saInfo("La Fecha de Entrega debe ser posterior al día de hoy.");
					seguir = false;
				}

				strFESave = strFechaEntrega;
				strHoraEntrega = $("#txtHoraEntrega").val();
			}

			if (seguir)
			{
				xajax_levantarPedido(this.idClienteSeleccionado, this.subtotalPedido, this.ivaPedido, this.descuentoPedido, this.totalPedido, this.tipoPrecioGalvamex, this.listadoPedido, this.selRecogeRecibe, strNombre, strDireccion, strNumero, strColonia, strCiudad, strFESave, strHoraEntrega, this.selTipoPedido, this.porDescuento, this.maxDescuentoIndividual, this.selDescuentoIndividual, this.observacionPedido, this.totalOtrosCargos, this.otrosCargos);
			}
			else
			{
				this.mostrarBotonGuardar = true;
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
		},
		testButton: function(){
			alert("jfkdsjlfkdjklfj");
		},
		updateProductoLista: function(index){

			this.limpiaDatosModal();
			this.textBotonAddModal = "Actualizar Item de Pedido";
			this.textBotonCancelModal = "Cancelar";

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
			$("#myModal").modal();
		},
		validaDatosProductoDeModal: function(){

			this.errorModal = "nrk";
			var result = true;


			if (!Number(this.cantidadModal))
			{
				this.errorModal = this.errorModal + "<br>" + "Debe especificar una Cantidad.";
				result = false;
			}


			if (this.tipoPrecioModal != "G")
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
		enlistaProductoDeModal: function()		{

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

				$("#myModal").modal('toggle');
				toastr.info('Producto Modificado.','Pedido');

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
				}

			}

			//setTimeout(function(){$('#tblPedidoShort').footable();},50);
			setTimeout(function(){ $('#tblPedidoShort').trigger('footable_redraw')}, 5);
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

			this.piezasExistencias.splice(0, this.piezasExistencias.length);

			for (i = 0; i < this.listadoPedido.length ; i++)
			{

				// Tipo A para los rangos normales
				if (this.listadoPedido[i].isRango == "1" && this.listadoPedido[i].tipoRango == "A" )
				{
					if (this.listadoPedido[i].mlpieza > 0)
					{
						this.totalML = this.totalML + (this.listadoPedido[i].cantidad * this.listadoPedido[i].cantUnidad * this.listadoPedido[i].mlpieza );
					}
					else
					{
						this.totalML = this.totalML + (this.listadoPedido[i].cantidad * this.listadoPedido[i].cantUnidad);
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

				// Tipo C para los Multipanel
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

				if (this.tipoPrecioGalvamex > this.maxTipoPrecioGalvamex)
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

				if (this.tipoPrecioGalvamexAcryOpa > this.maxTipoPrecioGalvamexAcryOpa)
				{
					this.tipoPrecioGalvamexAcryOpa = this.maxTipoPrecioGalvamexAcryOpa;
					return;
				}

				/*
				|--------------------------------------------------------------------------
				| Fin Bloque: Rangos de láminas Acrylit Opalit
				|------------------------------------------------------------------------*/

			}


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
					if (this.tipoPrecioGalvamex == 1)
					{
						this.listadoPedido[i].rangoRenglon = this.comisionR1;
					}
					else if (this.tipoPrecioGalvamex == 2)
					{
						this.listadoPedido[i].rangoRenglon = this.comisionR2;
					}
					else
					{
						this.listadoPedido[i].rangoRenglon = this.comisionR3;
					}



					if (this.tipoPrecioGalvamex == 3)
					{
						// console.log("Rango Normal: tipo 3");
//						this.listadoPedido[i].precioRenglon = parseFloat(this.listadoPedido[i].precio3) + parseFloat(this.maxDescuentoIndividual);
						this.listadoPedido[i].precioRenglon = parseFloat(this.listadoPedido[i].precio3);
						// console.log("precio 3 " + this.listadoPedido[i].precio3 + "  renglonprecio: " +this.listadoPedido[i].precioRenglon);
					}
					else if (this.tipoPrecioGalvamex == 2)
					{
						// console.log("Rango Normal: tipo 2");
//						this.listadoPedido[i].precioRenglon = parseFloat(this.listadoPedido[i].precio2) + parseFloat(this.maxDescuentoIndividual);
						this.listadoPedido[i].precioRenglon = parseFloat(this.listadoPedido[i].precio2);
						// console.log("precio 2 " + this.listadoPedido[i].precio2 + "  renglonprecio: " +this.listadoPedido[i].precioRenglon);
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
				}
				else if(this.listadoPedido[i].isRango == "1" && this.listadoPedido[i].tipoRango == "B")
				{
					// console.log("estamos en el rango tipo B");
					if (this.tipoPrecioGalvamexAcryOpa == 1)
					{
						this.listadoPedido[i].rangoRenglon = this.comisionR1;
					}
					else if (this.tipoPrecioGalvamexAcryOpa == 2)
					{
						this.listadoPedido[i].rangoRenglon = this.comisionR2;
					}
					else
					{
						this.listadoPedido[i].rangoRenglon = this.comisionR3;
					}



					if (this.tipoPrecioGalvamexAcryOpa == 3)
					{
						// console.log("AcryOpa 3 ");
//						this.listadoPedido[i].precioRenglon = parseFloat(this.listadoPedido[i].precio3) + parseFloat(this.maxDescuentoIndividual);
						this.listadoPedido[i].precioRenglon = parseFloat(this.listadoPedido[i].precio3);
					}
					else if (this.tipoPrecioGalvamexAcryOpa == 2)
					{
						// console.log("AcryOpa 2 ");
//						this.listadoPedido[i].precioRenglon = parseFloat(this.listadoPedido[i].precio2) + parseFloat(this.maxDescuentoIndividual);
						this.listadoPedido[i].precioRenglon = parseFloat(this.listadoPedido[i].precio2);
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
				}
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

				// FIN Manejo de rangos normales tipo A




				if (this.listadoPedido[i].tipoPrecio == "G")
				{
					//solo aplica descuentos individuales a las láminas
					if (this.listadoPedido[i].idTipoProducto == "1")
					{
						//solo jugar con los descuento aquellos productos por rango y el rango es 1
						if (this.listadoPedido[i].isRango == "1" && this.listadoPedido[i].tipoRango == "A")
						{
							if (this.tipoPrecioGalvamex == 1)
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
							else
							{
								this.listadoPedido[i].precioRenglon = parseFloat(this.listadoPedido[i].precioRenglon);
							}
						}
						else if(this.listadoPedido[i].isRango == "1" && this.listadoPedido[i].tipoRango == "B")
						{
							// console.log("calculamos descuento si o no de tipo B");
							if (this.tipoPrecioGalvamexAcryOpa == 1)
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

				this.listadoPedido[i].totalRenglon = this.listadoPedido[i].cantidad * this.listadoPedido[i].cantUnidadReal * this.listadoPedido[i].precioRenglon;
				this.subtotalPedido = this.subtotalPedido + (this.listadoPedido[i].cantidad * this.listadoPedido[i].cantUnidadReal * this.listadoPedido[i].precioRenglon);

				this.subtotalPedido = Math.round(this.subtotalPedido * 100) / 100
			}

			this.descuentoPedido = Math.round((this.subtotalPedido + this.ivaPedido) * this.porDescuento) / 100;
			
			this.totalPedido = this.subtotalPedido + this.totalOtrosCargos + this.ivaPedido - this.descuentoPedido;
			this.totalPedido = Math.round(this.totalPedido * 100) / 100;

			this.contarKilosPiezas();
		},
		addPiezaParaContar: function(codigo){
			console.log("Agregar el producto " + codigo);
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
				console.log("Producto: " + this.listadoPedido[i].codigo);

				if (this.listadoPedido[i].shortUnidad != "PZA")
				{
					console.log("Contar kilos: " + this.listadoPedido[i].kl);		
					this.cuentaEstosKilosEnRollo(this.listadoPedido[i].idRollo, this.listadoPedido[i].kl);
				}
				else
				{
					console.log("No contamos los kilos, es pza");
					this.cuentaEstasPiezasEnProductos(this.listadoPedido[i].codigo, this.listadoPedido[i].cantidad);
				}
			}

			this.indicarProductosYRollosNoDisponibles();

		},
		indicarProductosYRollosNoDisponibles: function(){
			var i = 0;
			var j = 0;

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
					this.rollosExistencias[i].rolloenpedido = true;
					this.rollosExistencias[i].enpedido += Number(kl);
				}
				
				if (this.rollosExistencias[i].enpedido > this.rollosExistencias[i].disponible)
				{
					this.rollosExistencias[i].nosepuede = true;
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
		//enlistarProducto
		showModalParaEnlistar: function(index){
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
			$("#myModal").modal();


			this.productoAEnlistar = "";
		},
		prepararProductoDesdeGrid: function(codigo){
//			console.log("producto: " + codigo);
			this.productoAEnlistar = codigo;
			this.prepararProducto();
		},
		prepararProducto: function(){
//			console.log("producto: " + this.productoAEnlistar);
			if (this.productoAEnlistar == "")
			{
				mostrarAviso('Debe ingresar un producto');
				return;
			}
			this.addDebug("Comenzamos busqueda de " + this.productoAEnlistar);

			this.searchEncontrado = false;

			this.buscaProductoXFullDescripcion();

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


				this.buscaProductoXCodigo();

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
		refreshDatosClienteSeleccionado: function(){
			xajax_cargarClienteById(this.idClienteSeleccionado);
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
		limpiarModalMoldura: function(){
			this.molCantidad = 1;
			this.molCantUnidad = 3.05;
			this.molDesarrollo = '0';
			this.molIdRollo = 0;
			this.molDobleces = 1;
			this.molPiesXDesarrollo = 0;
			this.molDividirLamina = 0;
		},
		agregarOtrosGastos: function(){
			$("#modalOtrosCargos").modal();
		},
		quitarOtrosCargos: function(){
			var i = 0;
			
			for (i = 0; i < this.otrosCargos.length ; i++)
			{
				this.otrosCargos[i].monto = 0;
			}
		},
		aceptaOtrosCargos: function(){
//			alert("quitamos modal cargos");
			$("#modalOtrosCargos").modal('toggle');
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
	$('#dtFechaEntrega').datepicker({
	    todayBtn: "linked",
	    keyboardNavigation: false,
	    forceParse: false,
	    calendarWeeks: true,
	    autoclose: true,
	    format: 'dd/mm/yyyy'
	});

	$('.clockpicker').clockpicker();


});
