
var app = new Vue({
	el: '#app',
	data: {
		filtro: {
			tipoProducto: '0',
			aplicacion: '0',
			material: '0',
			proveedor: '0',
			unidad: '4'
        },
        
        columns: [],
        rows: []
    },
    mounted: function(){
        // this.obtenerReporte();
    },
	watch: {
		filtro: function(val){
			if (this.filtro.tipoProducto == 5)
			{
				this.filtro.aplicacion = 0;
				this.filtro.unidad = 0;
			}
		}
	},
	methods: {
		fnRegresarAReportes: function(){
			window.location = URL_BASE + "rptmanager";
		},
		obtenerReporte: function(){
            
            // alert("vamos a por el reporte");
            mdlShowWait();
            xajax_obtenerReporte(this.filtro);
		},
		sendToExcel: function(){
			sendToExcel("tblReporte", "Inventario Productos Stock Sucursales", "Inventario Productos Stock Sucursales", "");
		}
	}
});