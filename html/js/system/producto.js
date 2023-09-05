	$(document).ready(function(){			

			$('#tblListado').DataTable({
				"pageLength": 25,
				"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todo"]],
                 dom: '<"html5buttons"B>lTfgitp',
                 buttons: [
                     //{extend: 'copy'},
                     //{extend: 'csv'},
                     {extend: 'excel', title: 'Productos'},
                     {extend: 'pdf', title: 'Productos'},

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