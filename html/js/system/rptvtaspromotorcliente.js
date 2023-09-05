
var app = new Vue({
	el: '#app',
	data: {
		filtro: {
			promotor: '0',
			nombrePromotor: '',
			fechaInicio: '',
			fechaFin: '',
			tipo: 'O'
		}		,

		errFechaInicio: '',
		errFechaFin: '',
		//totales

		total:'',
		totalCalculado: 0,
        totalCalculado1: 0,
        
        
		

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
			var sel = $("#selPromotor").val();
			if (sel != "0")
			{
				sendToExcel("tblReporte", "Ventas Agrupadas por Cliente", "Ventas Agrupadas por Cliente", "Promotor: " + $("#selPromotor :selected").text() + " de: " + this.filtro.fechaInicio + " a: " + this.filtro.fechaFin);	
			}
			else
			{
				sendToExcel("tblReporte", "Ventas Agrupadas por Cliente", "Ventas Agrupadas por Cliente", "Todos los Promotores de: " + this.filtro.fechaInicio + " a: " + this.filtro.fechaFin);
			}
			
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

