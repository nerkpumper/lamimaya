var app = new Vue ({
	el: '#app',
	data:{
	
		datos:[],
		
		
		fi: '',
		ff: '',
		
		filtro: {			
			fechaInicio: '',
			fechaFin: '',
		}		,
		
		
		errFechaInicio: '',
		errFechaFin: '',
	},
	computed: {
		
	},
	mounted: function() {
		
	
	},
	methods: {
		obtenerReporte: function(){
            var desde = $("#dtFechaInicio").val();
			var hasta = $("#dtFechaFin").val();
			var seguir = true;

			this.errFechaInicio = '';
			this.errFechaFin = '';

			var strFechaInicial = desde.substring(6, 10) + '' + desde.substring(3, 5) + '' + desde.substring(0, 2);
			var strFechaFinal = hasta.substring(6, 10) + '' + hasta.substring(3, 5) + '' + hasta.substring(0, 2);

//			alert(  strFechaInicial + ' ' + strFechaFinal);
			
			if (parseInt(strFechaFinal) < parseInt(strFechaInicial))
			{
				this.errFechaFin = "Fecha Final debe ser mayor a Inicial";
				seguir = false;
			}

//			if (parseInt(strFechaFinal) < parseInt("20190101"))
//			{
//				saInfo("No se han encontrado Datos");
//				seguir = false;
//				return;
//			}
			
//			if (parseInt(strFechaInicial) < parseInt("20190101"))
//			{
//				this.errFechaInicio = "Fecha Inicial debe ser mayor a 01 Enero 2019";
//				seguir = false;
//			}
			
//			if (hasta < desde)
			
			
//			console.log("*" + this.filtro.fechaInicio + "*");
//        	console.log("*" + this.filtro.fechaFin + "*");
        	
        	if (desde == "" || hasta == "")
        	{
        		saInfo("Debe indicar un rango de fechas válido.");
                seguir = false;
        	}

			if (seguir)
			{
				this.filtro.fechaInicio = desde;
				this.filtro.fechaFin = hasta;
				
				this.fi = desde;
				this.ff = hasta;
				
				xajax_obtenerDatos(this.filtro);
//				
			}


        },
		fnRegresarAReportes: function(){
			window.location = URL_BASE + "rptmanager";
		},
		obtenerDatos: function (){
			xajax_obtenerDatos();
		}
	}
});

var datos = [
];

$(document).ready(function()
		{
			

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
			
//			Highcharts.stockChart('container', {
//
//		        rangeSelector: {
//		            selected: 1
//		        },
//
//		        title: {
//		            text: 'AAPL Stock Price'
//		        },
//
//		        series: [{
//		            name: 'AAPL Stock Price',
//		            data: datos,
//		            step: true,
//		            tooltip: {
//		                valueDecimals: 2
//		            }
//		        }]
//		    });

		   
		});
