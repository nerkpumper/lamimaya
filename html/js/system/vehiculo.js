	$(document).ready(function(){			

			$('#tblListado').DataTable({
				
                 dom: '<"html5buttons"B>lTfgitp',
                 buttons: [
                     //{extend: 'copy'},
                     //{extend: 'csv'},
                     {extend: 'excel', title: 'Vehiculo'},
                     {extend: 'pdf', title: 'Vehiculo'},

                     /*{extend: 'print',
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