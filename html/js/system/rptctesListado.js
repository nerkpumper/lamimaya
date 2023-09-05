
var app = new Vue({
	el: '#app',
	data: {
		filtro: {
			promotor: '0',
			nombrePromotor: ''
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
			var sel = $("#selPromotor").val();
			if (sel != "0")
			{
				sendToExcel("tblReporte", "Listado de Clientes Galvamex", "Listado de Clientes Galvamex", "Promotor: " + $("#selPromotor :selected").text());	
			}
			else
			{
				sendToExcel("tblReporte", "Listado de Clientes Galvamex", "Listado de Clientes Galvamex", "Todos los Promotores");
			}
			
		}
	}
});