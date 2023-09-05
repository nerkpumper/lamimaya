
var app = new Vue ({
	el: '#app',
	data:{
		infoRollos: [],
		infoProductos: []
	},
	mounted: function(){
//		this.infoRollos.push({
//			idRollo: 1,
//			codigo: '',	 
//			idMaterial: 1, 
//			material: '', 
//			idProveedor: 1, 
//			proveedor: '', 
//			calibre: '', 
//			pies: '', 
//			descripcion: '', 
//			observaciones: '', 
//			estado: '', 
//			existencia: 1, 
//			apartado: 1
//		});
	},
	methods: {
		obtenerInfoRollos: function(){
			xajax_cargarInformacionRollos();
		},
		getProgressBarRollo: function(index){
			
			var tipoBarra = "";
			
			if (this.infoRollos[index].porcentajeapartado > 85.0)
			{
				tipoBarra = "progress-bar-danger";
			}
			else
			{
				if (this.infoRollos[index].porcentajeapartado > 50.0)
				{
					tipoBarra = "progress-bar-warning";
				}
			}
			
			return "<div style='width: "+this.infoRollos[index].porcentajeapartado+"%;' class='progress-bar "+tipoBarra+"'></div>";
		},
		obtenerInfoProductos: function(){
			xajax_cargarInformacionProductos();
		},
		getProgressBarProducto: function(index){
			var tipoBarra = "";
			
			if (this.infoProductos[index].porcentajeapartado > 85.0)
			{
				tipoBarra = "progress-bar-danger";
			}
			else
			{
				if (this.infoProductos[index].porcentajeapartado > 50.0)
				{
					tipoBarra = "progress-bar-warning";
				}
			}
			
			return "<div style='width: "+this.infoProductos[index].porcentajeapartado+"%;' class='progress-bar "+tipoBarra+"'></div>";
		},
		sendToExcelProductos: function(){
			sendToExcel("tblProductos", "Monitor Existencias Productos","Monitor Existencias", "Productos Stock", pexcluir = 1)
		},
		sendToExcelRollos: function(){
			sendToExcel("tblRollos", "Monitor Existencias Rollos","Monitor Existencias", "Mercancía Rollos", pexcluir = 1)
		}
		
	}	
});