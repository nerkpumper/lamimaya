
var app = new Vue({
	el: '#app',
	data: {
		filtro: {
			tipoProducto: '0',
			aplicacion: '0',
			material: '0',
			unidad: '4',
			semaforo: 'ALL'
		}		
	},
	methods: {
		fnRegresarAReportes: function(){
			window.location = URL_BASE + "rptmanager";
		},
		obtenerReporte: function(){
			xajax_obtenerReporte(this.filtro);
		},
		sendToExcel: function(){
			sendToExcel("tblReporte", "Inventario Productos Stock", "Inventario Productos Stock", "");
		}
	}
});