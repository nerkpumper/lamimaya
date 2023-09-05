$(document).ready(function(){			

	$('#tblListado2').DataTable({
		
         dom: '<"html5buttons"B>lTfgitp',
         buttons: [
            // {extend: 'copy'},
            // {extend: 'csv'},
             {extend: 'excel', title: 'Rollos'},
             {extend: 'pdf', title: 'Rollos'},

            /* {extend: 'print',
              customize: function (win){
                     $(win.document.body).addClass('white-bg');
                     $(win.document.body).css('font-size', '10px');

                     $(win.document.body).find('table')
                             .addClass('compact')
                             .css('font-size', 'inherit');
             	}
             }*/
         ]

    });
	
			//alert ("entrando");
			//mostrarAviso("probando Ajax");
		});

var app = new Vue ({
	el: '#app',
	data:{
		inventarioInicialMendez: 0,
		inventarioRollos: 0,
		pedidos: 0
	},
	computed: {
		totalNeto: function() {
			return this.inventarioInicialMendez + this.inventarioRollos - this.pedidos; 
		}
	},
	mounted: function() {
		
		this.obtenerDatos();
	},
	methods: {
		fnRegresarAReportes: function(){
			window.location = URL_BASE + "rptmanager";
		},
		obtenerDatos: function (){
			xajax_obtenerDatos();
		}
	}
});
