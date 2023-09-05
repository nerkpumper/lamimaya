

var app = new Vue ({
	el: '#app',
	data: {
		seleccionarPedido: true,
		idPedido: '',
		estado: '',
		promotorAutorizaValeSalida: 'NO',
		observacionaunno: '',
		
		//mostrar
		mostrarSinValeSalida: false,
		mostrarValeSalida: false,
			
		//datos del cliente
		cteIdCliente: 0,
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
		
		//mercancía sin vale
		mercanciaSinVale: [],
		mercanciaVale: [],
		idValeSalida: 0,
//		totalKilos: 0,
		valesSalida: []
	},
	mounted: function(){
		if (typeof param1 !== 'undefined') {
			this.idPedido = param1;
						
			this.cargarDatosPedido();			
		}			
	},
	computed: {
		totalKilos: function(){
			
			var i = 0;
			var kilos = 0.0;
			
			for (i = 0 ; i < this.mercanciaVale.length ; i++)
			{
				kilos = kilos +  (this.mercanciaVale[i].cantidad * this.mercanciaVale[i].explotarUnidad);
			}
			
			return kilos;
		}
	},
	methods: {
		seleccionarOtroPedido: function(){
			this.seleccionarPedido = true;
		},
		cargarDatosPedido: function(){
			
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
			
			xajax_cargarDatosPedido(this.idPedido);	
			this.cargarValesSalida();
			setTimeout(function(){app.mostrarPartidasSinValeSalida();}, 300);
			
		},
		cargarValesSalida: function(){
			xajax_cargarValesSalida(this.idPedido);
		},
		mostrarPartidasSinValeSalida: function(){			
			this.mostrarSinValeSalida = true;			
			this.mostrarValeSalida = false;
			xajax_cargarMercanciaSinVale(this.idPedido);
		},
		generarvaleSalida: function(){
			var seleccionados = 0;
			
			for (i = 0; i < this.mercanciaSinVale.length ; i++)
			{
				if (this.mercanciaSinVale[i].selected == true)
				{
					seleccionados++;
				}
			}
			
			if (seleccionados > 0)
			{
				swal({
					title: "¿Seguro que deseas continuar?",
					text: "Se generará un Vale de Salida para los elementos que ha seleccionado.",
					type: "warning",
					showCancelButton: true,
					cancelButtonText: "NO",
					cancelButtonColor: "#ed5565",
					confirmButtonColor: "#1c84c6",
					confirmButtonText: "¡Adelante!",
					closeOnConfirm: false },

					function(){

						
						swal.close();
						xajax_generarValeSalida(app.idPedido, app.mercanciaSinVale);
					
				});
				
			}
			else
			{
				saInfo("Debe seleccionar al menos un elemento de la lista para generar el Vale de Salida");
			}
			
		},
		exportarSinVale: function(){
			
			sendToExcel("tablaToExcel", "Reporte Notas", "El titulillo", "El subtitulillo", 1);
		},
		exportarVale: function(){
			sendToExcel("tablaValeSalida", "Vale Salida " + this.idValeSalida, "Vale de Salida " + this.idValeSalida, "Total Kilos: " + this.totalKilos);
		},
		cargarValeSalida: function(idValeSalida){
			this.idValeSalida = idValeSalida;
			this.mostrarSinValeSalida = false;			
			this.mostrarValeSalida = true;
			xajax_cargarSingleValeSalida(this.idPedido, idValeSalida);
//			alert("cargamos el vale: " + idValeSalida);
		}
			
	
	}
});

