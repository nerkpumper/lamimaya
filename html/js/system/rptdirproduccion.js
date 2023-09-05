
var app = new Vue ({
	el: '#app',
	data:{
		showAnio: true,
		datosTabla: []
	},
	mounted: function() {
		this.cargarProduccionAnual();
	},
	methods: {
		fnRegresarAReportes: function(){
			window.location = URL_BASE + "rptmanager";
		},
		cargarProduccionAnual: function(){
			xajax_cargarProduccionAnual();
		},
		cargarVentasMes: function(mes){
			xajax_cargarVentaMensual(mes, 2018);
		},
		mostrarAnio: function(){
			this.showAnio = true;
		},
		exportar: function(){
			sendToExcel("tablaToExcel", "Reporte de Producción 2018", "Reporte de Producción 2018", "Total Kilos Producción");
		}
	}
});

//Highcharts.setOptions({
//colors: ['#058DC7', '#50B432', '#ED561B', '#DDDF00', '#24CBE5', '#64E572', '#FF9655', '#FFF263', '#6AF9C4']
//});

Highcharts.setOptions({
	colors: [
		'#0000FF',
		'#8A2BE2',
		'#A52A2A',
		'#DEB887',
		'#5F9EA0',
		'#7FFF00',
		'#D2691E',		
		'#6495ED',		
		'#DC143C',		
		'#00008B',
		'#008B8B',
		'#B8860B',
		'#A9A9A9',
		'#006400',
		'#BDB76B',
		'#8B008B',
		'#556B2F',
		'#FF8C00',
		'#9932CC',
		'#8B0000',
		'#E9967A',
		'#8FBC8B',
		'#483D8B',
		'#2F4F4F',
		'#00CED1',
		'#9400D3',
		'#FF1493',
		'#00BFFF',
		'#696969',
		'#1E90FF',
		'#B22222',
		'#FFFAF0',
		'#228B22',
		'#FF00FF',
		'#DCDCDC',
		'#F8F8FF',
		'#FFD700',
		'#DAA520',
		'#808080',
		'#008000',
		'#ADFF2F',
		'#F0FFF0',
		'#FF69B4',
		'#CD5C5C',
		'#4B0082',
		'#FFFFF0',
		'#F0E68C',
		'#E6E6FA',
		'#FFF0F5',
		'#7CFC00',
		'#FFFACD',
		'#ADD8E6',
		'#F08080',
		'#E0FFFF',
		'#FAFAD2',
		'#D3D3D3',
		'#90EE90',
		'#FFB6C1',
		'#FFA07A',
		'#20B2AA',
		'#87CEFA',
		'#778899',
		'#B0C4DE',
		'#FFFFE0',
		'#00FF00',
		'#32CD32',
		'#FAF0E6',
		'#FF00FF',
		'#800000',
		'#66CDAA',
		'#0000CD',
		'#BA55D3',
		'#9370DB',
		'#3CB371',
		'#7B68EE',
		'#00FA9A',
		'#48D1CC',
		'#C71585',
		'#191970'

]
	});

Highcharts.chart('chartAnio', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Producción de Rollos Galvamex 2018'
    },
    xAxis: {
        categories: []
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Total kg'
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
    	backgroundColor: 'rgba(247,247,247,0.9)',
        borderWidth: 1,
        borderColor: '#AAA',
        headerFormat: '<b>{point.x}</b><br/>',
         pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b> kg ({point.percentage:.0f}%) <br>',
        shared: true
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
