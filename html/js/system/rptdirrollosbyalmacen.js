
var app = new Vue({
	el: '#app',
	data: {
		filtro: {			
			almacen: 'ALL'
		},
		
		totalExistencia: 0, 
		detallado: false
	},
	watch: {
		filtro: {
			handler: function (val, oldVal) {
				this.obtenerReporte();
		      },
		      deep: true
		},
		detallado: function(value){
			this.obtenerReporte();
		}
	},
	methods: {
		fnRegresarAReportes: function(){
			window.location = URL_BASE + "rptmanager";
		},
		obtenerReporte: function(){
			
			mdlShowWait();
			
			if (this.detallado)
			{
				xajax_obtenerReporte(this.filtro);	
			}
			else
			{
				xajax_obtenerReporteAgrupado(this.filtro);
			}
				
			
		},
		sendToExcel: function(){
			if (this.detallado)
			{
				sendToExcel("tblReporte", "Inventario Rollos ", "Inventario Rollos Detallado por Almacen", "Inventario Rollos, Almacen: " + this.filtro.almacen);
			}
			else
			{
				sendToExcel("tblReporte", "Inventario Rollos ", "Inventario Rollos Agrupado por Almacen", "Inventario Rollos, Almacen: " + this.filtro.almacen);				
			}
			
		}
	}
});