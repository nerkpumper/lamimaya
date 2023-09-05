
var app = new Vue({
	el: '#app',
	data: {
		strRollo: '',
		totalCostoInventario: 0,
		totalExistencia: 0,
		rollos: []
	},
	mounted: function(){
//		<th>Rollo</th>
//		<th>CU sin IVA</th>
//		<th>Existencia</th>
//		<th>Costo Inventario</th>
//		<th>Total Rollos</th>
//		<th>Rollos En Producci&oacute;n</th>
//		<th>Rollos Terminados</th>
//		<th>Rollos por Terminar</th>
		
		xajax_cargarDatosRollos();
		
		
	},
	methods: {
		sendToExcel: function(){
			sendToExcel("tblReporte", "Costo Inventario Rollos", "Costo Inventario Rollos", "Costo Inventario Rollos", 1, "D|E|F");
			
		},
		mostrarGraficoRollos: function(index){
			 $("#modalChart").modal();
			 var idx = $('#chartRollos').data('highchartsChart');
			 chart = Highcharts.charts[idx];
			 
			 this.strRollo = this.rollos[index].desc;
			 
			 chart.series[0].setData([]);
			 chart.series[0].setData([this.rollos[index].rollosTotal, this.rollos[index].rollosInventario , this.rollos[index].rollosRP], false);
			 chart.series[0].update({name: this.rollos[index].desc}, false);
			 chart.redraw();
		}
	}
	
});

Highcharts.chart('chartRollos', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Rollos'
    },
    xAxis: {
        categories: ['Total Rollos','En Almacén','En Producción']
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Rollos'
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
         pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b> ',
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
    series: [{data:[0,0,0]}]
});