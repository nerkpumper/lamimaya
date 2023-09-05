

var app = new Vue ({
	el: '#app',
	data: {
		seleccionarPedido: true,
		idPedido: '',
		
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
			
			
			this.cargarValesSalida();
			
			
		},
		cargarValesSalida: function(){
      		this.seleccionarPedido = false;
			this.$refs.trackingPedido.show(this.idPedido);
		},		
		
			
	
	}
});

