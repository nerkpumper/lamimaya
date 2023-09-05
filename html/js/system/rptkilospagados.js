var app = new Vue({
	el: '#app',
	data: {		
		lstRollo:[],
        totalAcanalado:0,
        totalRollo:0,
        totalMoldura:0,
         errFechaInicio:'',
         errFechaFin:'', 
        //  strFechaInicial:'',
        //  strFechaFinal:'',
            fi: '',
		    ff: '',
         
         filtro: {  
			fechaInicio: '',
			fechaFin: '',
		}	

	},
	mounted: function () {
	
		
	},
	methods:{
        obtenerReporte: function(){
            var desde = $("#dtFechaInicio").val();
            var hasta = $("#dtFechaFin").val();
            var seguir = true;
            this.errFechaInicio = '';
            this.errFechaFin = '';
            var strFechaInicial = desde.substring(6, 10) + '' + desde.substring(3, 5) + '' + desde.substring(0, 2);
            var strFechaFinal = hasta.substring(6, 10) + '' + hasta.substring(3, 5) + '' + hasta.substring(0, 2);
    
    // //			alert(  strFechaInicial + ' ' + strFechaFinal);
    
    // //			if (hasta < desde)
            if (parseInt(strFechaFinal) < parseInt(strFechaInicial))
            {
                saInfo("Fecha Final debe ser mayor a Inicial.");
                this.errFechaFin = "Fecha Final debe ser mayor a Inicial";
                seguir = false;
            }          
    // //			console.log("*" + this.filtro.fechaInicio + "*");
    // //        	console.log("*" + this.filtro.fechaFin + "*");           
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
            }
            var FechaInicial = desde.substring(6, 10) + '-' + desde.substring(3, 5) + '-' + desde.substring(0, 2);
            var FechaFinal = hasta.substring(6, 10) + '-' + hasta.substring(3, 5) + '-' + hasta.substring(0, 2);
            mdlShowWait();
            axios.get(URL_BASE + 'api/rptkilospagados.api.php?method=getkilospagados&fi='+FechaInicial+'&ff='+FechaFinal)
                .then(function (response) {
                    mdlExitWait();
                    console.log(response.data);
                    app.lstRollo.splice(0, app.lstRollo.length);
                    response.data.lstRollo.forEach(element => {
                    app.lstRollo.push(element);
                    app.totalRollo = response.data.totalRollo;
                    app.totalMoldura = response.data.totalMoldura;
                    app.totalAcanalado = response.data.totalAcanalado;                
                    });;
                })
                .catch(function (error) {
                    mdlExitWait();
                    app.lstRollo.splice(0, app.lstRollo.length);
                    saInfo("No se encontro informacion con ese Rango de fecha.");
                    console.log(error);
                }); 
        }
	},
		fnRegresarAListado: function(){
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
});