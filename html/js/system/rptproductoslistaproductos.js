
var app = new Vue({
	el: '#app',
	data: {
		filtro: {
			tipoProducto: '0',
			aplicacion: '0',
			material: '0',
			proveedor: '0',
			unidad: '0'
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
			sendToExcel("tblReporte", "Listado de Productos", "Listado de Productos", "");
		}
	}
});
$(document).ready(function(){	
	    
		$("#collapseLeftMenu").click();
		// alert ("entrando");
		// 			mostrarAviso("probando Ajax");
				});