
var app = new Vue({
	el: '#app',
	data: {
		filtro: {			
			fechaInicio: '',
			fechaFin: '',
		}		,

		errFechaInicio: '',
		errFechaFin: ''
	},	
	methods: {
		fnRegresarAReportes: function(){
			window.location = URL_BASE + "rptmanager";
		},
		obtenerReporte: function(){
			
			var desde = $("#dtFechaInicio").val();
			var hasta = $("#dtFechaFin").val();
			var seguir = true;
			
			this.errFechaInicio = '';
			this.errFechaFin = '';
			
			var strFechaInicial = desde.substring(6, 10) + '' + desde.substring(3, 5) + '' + desde.substring(0, 2);
			var strFechaFinal = hasta.substring(6, 10) + '' + hasta.substring(3, 5) + '' + hasta.substring(0, 2);
					
//			alert(  strFechaInicial + ' ' + strFechaFinal);
						
//			if (hasta < desde)
			if (parseInt(strFechaFinal) < parseInt(strFechaInicial))
			{
				this.errFechaFin = "Fecha Final debe ser mayor a Inicial"; 
				seguir = false;
			}
			
			if (seguir)
			{
				
				this.filtro.fechaInicio = desde;
				this.filtro.fechaFin = hasta;
				xajax_obtenerReporte(this.filtro);	
			}
			
		},
		obtenerReportePendientesSaldar: function(){
			xajax_obtenerReportePendientesSaldar(this.filtro);
		},
		sendToExcel: function(){
			
			sendToExcel("tblReporte", "Listado de Pedidos CxC Galvamex", "Listado de Pedidos CxC Galvamex", "De: " + this.filtro.fechaInicio + " a: " + this.filtro.fechaFin);
			
			
		}
	}
});


$(document).ready(function(){
	$('#dtFechaInicio').datepicker({
	    todayBtn: "linked",
	    keyboardNavigation: false,
	    forceParse: false,
	    calendarWeeks: true,
	    autoclose: true,
	    format: 'dd/mm/yyyy'
	});
	
	$('#dtFechaFin').datepicker({
	    todayBtn: "linked",
	    keyboardNavigation: false,
	    forceParse: false,
	    calendarWeeks: true,
	    autoclose: true,
	    format: 'dd/mm/yyyy'
	});
});

