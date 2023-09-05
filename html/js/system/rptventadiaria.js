
		
		// var totalPedidos= 0;
		// var totalClientes= 0;
		// var totalDia= 0;
var app = new Vue({
	el: '#app',
	data: {
		
		totalDia:0,
		idUsuarioCaptura:'',
		pedidoTotal:0,
		totales: [],
        movimientos: [],
        total:0,
		porcentaje:0,
		numPedidos:0,
		numCliente:0,
		totalClientes:0,
		totalPedidos:0,
		TotalDia:0,
		
		ususarioCaptura: 0,
	
		
		
	
	},
	mounted: function()
	{
		
		this.cargarVentaDiaria();

	},	

	methods: {
		cargarVentaDiaria: function(){	
		
		xajax_cargarRecibos();
		xajax_cargarTotales();
		
		 
		}		
	}
	
});