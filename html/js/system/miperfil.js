$(document).on('change', '.btn-file :file', function() {

			console.log("cambio");
		    var input = $(this),
		        numFiles = input.get(0).files ? input.get(0).files.length : 1,
		        label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
		        $('#filename').val (label);
		    input.trigger('fileselect', [numFiles, label]);
		});
		
		$(document).ready( function() {
			
			console.log("listo");
			
		    $('.btn-file :file').on('fileselect', function(event, numFiles, label) {
		    	
		        console.log(numFiles);
		        console.log(label);
		        $('#filename').val (label);
		    });
		});	
		


var app = new Vue({
	el : '#app',
	data : {
		cambiaFoto: false,
		passActual: '',
		passNuevo: '',
		passConfirma: '',
		errPassActual: '',
		errPassNuevo: '',
		errPassConfirma: '',
		
		passConfirmed: false
	},	
	watch: {
		passNuevo: function(val){
			if (this.passNuevo.trim() != this.passConfirma.trim())
			{
				this.errPassConfirma = "Password no coinciden.";			  
			}  
			else
			{
				this.errPassConfirma = "";
				this.passConfirmed = true;
			}
		},
		passConfirma: function(val){
			if (this.passNuevo.trim() != this.passConfirma.trim())
			{
				this.errPassConfirma = "Password no coinciden.";			  
			}  
			else
			{
				this.errPassConfirma = "";
				this.passConfirmed = true;
			}
		}
	  
	},
	methods : {
		subirArchivo: function(){
						
			var file_data = $('#archivo').prop('files')[0];	
		    var form_data = new FormData();
		    form_data.append('archivo', file_data);
		    form_data.append('txtIdUsuario', $('#txtIdUsuario').val());
		             
		    $.ajax({
		        url: 'miperfil.uploadfile.php', // point to server-side PHP script 
		        dataType: 'json',  // what to expect back from the PHP script, if anything
		        cache: false,
		        contentType: false,
		        processData: false,
		        data: form_data,                         
		        type: 'post',
		        success: function(resp){
		        	//alert (resp.msg);
		        	
		        	if (!resp.error) {		        		
		            	mostrarAviso("Se ha cambiado la foto de perfil.");
		            	window.setTimeout(function () { window.location = URL_BASE + "miperfil";}, 1500);
		            } else {
		            	mostrarAviso(resp.msg);
		            }
		        }
		    });	

			return false;
		},
		prepareSubir: function(){
			this.cambiaFoto = true;
		},
		cancelSubir: function(){
			this.cambiaFoto = false;
		},
		cambiaPassword: function(){
			xajax_cambiaPassword(this.passActual, this.passNuevo, this.passConfirma);
		}
	}

});		