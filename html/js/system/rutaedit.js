

var app = new Vue({
	el: '#app',
	data: {		
		idRuta: 0,
		nombre: '',
		descripcion: '',
		              	
		errNombre: '',
		errDescripcion: '',

        image: '',
        file: '',
		
		accionModulo: 'Nuevo'
	},
	mounted: function () {
		if (typeof param1 !== 'undefined') {
            console.log(param1)
			this.idRuta = param1;
			this.accionModulo = 'Actualizar';		  
			xajax_cargarRuta(this.idRuta);
		}	
		
		this.$refs.nombre.focus();
	},	
    computed: {
        imgURL: function(){
            return URL_BASE + "img/rutas/" + this.idRuta + ".png";
        },
        selImagen: function(){
            return this.idRuta == 0 ? "Seleccionar Imagen" :  "Cambiar Imagen";
        }
    },
	watch: {
		descripcion: function(val){
			this.descripcion = val.toUpperCase();
		},
		nombre: function(val){
			this.nombre = val.toUpperCase();
		}
	},
	methods:{
		guardarRuta: function(){
			var seguir = true;
		  
			this.limpiaErrores();
		  
			if (this.nombre.trim() == "")
			{
				this.errNombre = "Debe especificar un nombre de Ruta.";
				seguir = false;
			}
		  						
			if (this.descripcion.trim() == "")
			{
				this.errDescripcion = "Debe especificar una descripcion.";
				seguir = false;
			}
									
			if (seguir)
			{				
				xajax_guardarRuta(this.idRuta, this.nombre, this.descripcion);
			}
			
			
		},
		limpiaDatos: function(){
			this.idRuta = 0;
			this.nombre = '';
			this.descripcion = '';
			
		},
		limpiaErrores: function(){
			this.errNombre = '';
			this.errDescripcion = '';
			
		},
		fnRegresarAListado: function(){
			window.location = URL_BASE + "ruta";
		},
        saveImage: function(){

            if (this.image == "")
            {
                return;
            }
            console.log("antes formdata");
            var fd = new FormData();
            var files = $("#fileImage")[0].files[0];

                fd.append('file',files);
            // fd.append('file', this.file);
            fd.append('idRuta', this.idRuta); 
            
            console.log("despues  formdata");

            // return false;

            $.ajax({
                type: 'POST',
                url: URL_BASE + 'submitfileruta.php',
                data: fd,//new FormData(this),
                contentType: false,
                cache: false,
                processData:false,
                beforeSend: function(){
                    console.log("before send imagen");
                    // $('.submitBtn2').attr("disabled","disabled");
                    // $('#fupForm2').css("opacity",".5");
                    // $("#divImg1").html("<img id='mylogo1' src='' width='300px' /><br><br>");
                },
                success: function(msg){
                    console.log(msg)
                    // $('.statusMsg2').html('');
                    if(msg == 'ok'){

                        // saSuccess("La imagen se ha almacenado con éxito. Espere un momento.");
                        // setTimeout(function() { window.location = URL_BASE + "rutaedit/" + app.idRuta; }, 2000);
                        
                        // $('#fupForm2')[0].reset();
                        // $('.statusMsg2').html('<span style="font-size:18px;color:#34A853">Imagen subida con &eacute;xito.</span>');
                        // setTimeout(function() {
                                        // window.location = "configuracion.php"; 
                                        // $("#divImg1").html("<img id='mylogo1' src='images/logo1.jpeg?nocache=" + milliseconds + "' width='300px' /><br><br>");  
                                    // }
                        // , 200);
    
                        
                    }else{
                        saError("No se ha podido almacenar la imagen, por favor verifique que sea extensión png");
                        // $('.statusMsg2').html('<span style="font-size:18px;color:#EA4335">Ha ocurrido algun problema, intente de nuevo.</span>');
                    }
                    // $('#fupForm2').css("opacity","");
                    // $(".submitBtn2").removeAttr("disabled");
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert("some error");
                 }
            });
        },
        onFileChange(e) {
            
            var files = e.target.files || e.dataTransfer.files;
            if (!files.length)
              return;
            this.file = files[0];
            this.createImage(files[0]);
          },
        createImage(file) {
            // this.file = file;
            var image = new Image();
            var reader = new FileReader();
            var vm = this;
      
            reader.onload = (e) => {
              vm.image = e.target.result;
            };
            reader.readAsDataURL(file);
          },
        removeImage: function (e) {
            e.preventDefault();
            this.image = '';
            return false;
          }
	}
  
});