//mostrarAviso("hola");
//saTemporal("titulillo", "cosillas", 3);
//alert("holis");

//mostrarEspera("enviando el mail");
//
//setTimeout(function() { ocultarMensaje();}, 5000);

var app = new Vue({
	el: '#app',
	data: {
		status: 'holis'
	},
	created: function(){
		this.loadQuote();
	},
	methods: {
		loadQuote: function(){
			this.status = "loading . . . ";
			var vm = this;
			var form_data = new FormData();
		    form_data.append('idPedido', 1);
			
			//axios.get('http://ron-swanson-quotes.herokuapp.com/v2/quotes')
// 			$.ajax({
// 		        url: 'pedidoclient.send.php', // point to server-side PHP script 
// 		        dataType: 'json',  // what to expect back from the PHP script, if anything
// 		        cache: false,
// 		        contentType: false,
// 		        processData: false,
// 		        data: form_data,                         
// 		        type: 'post',
// 		        success: function(resp){
		        	
		        	
// 		        	if (!resp.error) {		   
// 		        		vm.status = "Oki doki";
// //		            	mostrarAviso("Se ha cambiado la foto de perfil.");
// //		            	window.setTimeout(function () { window.location = URL_BASE + "miperfil";}, 1500);
// 		            } else {
// 		            	vm.status = resp.msg;
// //		            	mostrarAviso(resp.msg);
// 		            }
// 		        }
// 		    });	
			axios.post('api/pedidoclient.send.php', form_data)
			.then(function (response) {
				console.log(response.data);
				vm.status = response.data.msg;
			})
			.catch(function (error) {
				console.log(error);
			});
			
			
//			axios.get('pedidosendclients')
//			.then(function(response){
////				alert(response[0]);
//				vm.status = response.estatus;
//			})
//			.catch(function(error){
//				vm.estatus = "Error: " + error;
//			});
		}
	}
});
//php:
//
//	$data = array(
//	    'name' => $c_name,
//	    'credit' => $c_credit,
//	);
//	echo json_encode($data);
//
//	javascript:
//
//	success: function(data) {
//	    var result = $.parseJSON(data);
//	    $('#course_name').val(result.name);
//	    $('#course_credit').val(result.credit);
//	}