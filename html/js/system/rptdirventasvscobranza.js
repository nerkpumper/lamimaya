
// Return today's date and time
var gcurrentTime = new Date()
// returns the year (four digits)
var gyear = gcurrentTime.getFullYear()

var app = new Vue ({
	el: '#app',
	data:{
		showAnio: true,
		year: gyear
		
	},
	mounted: function() {
		this.cargarCobranzaAnual(this.year);
	},
	methods: {
		fnRegresarAReportes: function(){
			window.location = URL_BASE + "rptmanager";
		},
		cargarCobranzaAnual: function(){
			
			xajax_cargarVentasVSCobranzaAnual(this.year);
		
			xajax_cargarVentasVSCobranzaAnualByPromotor(this.year);
		},
		mostrarAnio: function(){
			this.showAnio = true;
		}
		
	}
});

Highcharts.chart('chartAnio', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Ventas vs Cobranza Galvamex 2018'
    },
    xAxis: {
        categories: []
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Total'
        },
        stackLabels: {
            enabled: true,
            style: {
                fontWeight: 'bold',
                color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
            }
        }
    },
    legend: {
        
        backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || 'white',
        borderColor: '#CCC',
        borderWidth: 1,
        shadow: false
    },
    tooltip: {
        headerFormat: '<b>{point.x}</b><br/>',
         pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b> <br/>',
        shared: true
    },
    plotOptions: {
        column: {
            
            dataLabels: {
	            enabled: true,
	            rotation: -90,
	            color: '#FFFFFF',
	            align: 'right',
	            format: '{point.y:.2f}', // one decimal
	            y: 10, // 10 pixels down from the top
	            style: {
	                fontSize: '12px',
	                fontFamily: 'Verdana, sans-serif'
	            }

            }
        }
    },
    series: []
});

Highcharts.chart('chartvevsco', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Ventas vs Cobranza Por Promotor Galvamex 2018'
    },
    xAxis: {
        categories: []
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Totales'
        },
        stackLabels: {
            enabled: false,
            style: {
                fontWeight: 'bold',
                color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
            }
        }
    },
    legend: {
        
        backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || 'white',
        borderColor: '#CCC',
        borderWidth: 1,
        shadow: false
    },
    tooltip: {
    	formatter: function () {
            return '<b>' + this.x + '</b><br/>' +
                this.series.name + ': ' + this.y + '<br/>' +
                'Total: ' + this.point.stackTotal;
        }
    },
    plotOptions: {
        column: {
            stacking: 'normal',
            dataLabels: {
                enabled: false,
                color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white'
            }
        }
    },
    series: []
});
