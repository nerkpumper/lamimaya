
var app = new Vue ({
	el: '#app',
	data: {
		seleccionarPedido: true,
        uploadingFile: false,
		idPedido: '',
        cliente: '',
        totalPedido: 0,
        facturas: [],
        uploadedFiles: 0
    },
    methods: {
        seleccionarOtroPedido: function(){
			this.idPedido = '';
			this.seleccionarPedido = true;
		},
        cancelUpload: function(){
            this.uploadingFile = false;
            if (this.uploadedFiles > 0){
                this.cargarDatosPedido();
            }
        },
        uploadFile: function(){
            var file_data = $('#archivo').prop('files')[0];	
		    var form_data = new FormData();
		    form_data.append('archivo', file_data);
            form_data.append('folder', "facturas");
		    form_data.append('idPedido', this.idPedido);

            mdlShowWait("Subiendo archivo");
            
            axios.post(URL_BASE + 'api/pedidoaddfactura.api.php?method=uploadfiles', form_data,getAxiosHeaders())
            .then(function (response) {
                console.log(response.data);
                mdlExitWait();
                if (!response.data.error){
                    saSuccess("Archivo subido con éxito");
                    app.uploadedFiles = app.uploadedFiles+1;
                }
                else{
                    saError(response.data.msg);
                }
                
                document.getElementById("filename").value = null;                                                
            })
            .catch(function (error) {
                mdlExitWait();
                console.log(error);
                document.getElementById("filename").value = null;            
            });



        },
        showUploadFile: function(){
            this.uploadingFile = true;
            this.uploadedFiles = 0;
        },  
        cargarDatosPedido: function(){

			if (this.idPedido == "")
			{
				saTexto("Indique el Número de Pedido");
				return;
			}


			if (this.idPedido == 0)
			{
				saTexto("Indique el Número de Pedido");
				return;
			}

			// xajax_cargarDatosPedido(this.idPedido);
            
            axios.get(URL_BASE + 'api/pedidoaddfactura.api.php?method=cargarArchivos&idPedido=' + this.idPedido, getAxiosHeaders())
                .then(function (response) {
					console.log(response.data);
                    if (!response.data.error){
			            app.seleccionarPedido = false;  
                        app.facturas = response.data.files; 
                        app.cliente = response.data.cliente; 
                        app.totalPedido = response.data.totalPedido;                 
                    }
                    else{
                        saError(response.data.msg);
                    }        
                    
                    
                })
                .catch(function (error) {
                    console.error(error);
                });			

		},
    }
});


$(document).on('change', '.btn-file :file', function() {

			// console.log("cambio");
		    var input = $(this),
		        numFiles = input.get(0).files ? input.get(0).files.length : 1,
		        label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
		        $('#filename').val (label);
		    input.trigger('fileselect', [numFiles, label]);
		});
		
		$(document).ready( function() {
			
			// console.log("listo");
			
		    $('.btn-file :file').on('fileselect', function(event, numFiles, label) {
		    	
		        // console.log(numFiles);
		        // console.log(label);
		        $('#filename').val (label);
		    });
		});	