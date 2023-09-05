var app = new Vue({
    el: '#app',
    data: {
      msgError: '',
      monto:0,      
      referencia: '',   
      errMonto:'',
      errReferencia:'',
      lstAportaciones: [],
      seguir: false,
      isUserMendez: false,
      
    },
    mounted() {
        this.idUsuario = _IDUSUARIO;
        if(this.idUsuario == 7 || this.idUsuario == 2){
            this.isUserMendez = true;
        }
        
       
        this.cargarLstAportaciones();
    },
    watch: {
        },
    methods:{
        limpiarForm: function(){ 
            this.monto=0,
            this.referencia='',
            errMonto='',
            errReferencia= ''
        },
        

        
      

        guardarAportacion: function(){

            errMonto='',
            errReferencia= '',

            seguir = true;

            if(this.monto=='0'){

                this.errMonto = 'El monto debe ser mayor a cero';
                seguir=false;
            }
           
            if(this.referencia ===''){
          
                this.errReferencia='Referencia requerida';   
                seguir=false;  
            }

            if(seguir){
            var form_data = new FormData();        
            var objData = {
                idTipoGasto: this.idTipoGasto,
                idSucursal: this.idSucursal,
                monto: this.monto,
                referencia: this.referencia, 
                idUsuario: this.idUsuario
            }                           
            var vm = this;
            $.ajax({
                type: 'POST',
                dataType:  "json",				
                headers: getAxiosHeaders(),   					
                url: URL_BASE + 'api/aportacionesmendez.api.php?method=save',
                data: objData,
                    success:function(response){
                        // console.log(response.list);
                        if (!response.error)
                        {
                            var obj = {
                                monto: vm.monto,
                                monto: vm.monto,
                                referencia: vm.referencia,
                                idUsuario: this.idUsuario                                
                            }
                            vm.$emit("on-save", obj);
                            saSuccess("Aportacion almacenada con éxito");
                            vm.limpiarForm();
                            vm.cargarLstAportaciones();
                        }
                        else
                        {
                            saError(response.msg);
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) { 
                        console.log("error");
                    }
                });     
            }        
    }, 

    
    cargarLstAportaciones(){
        var vm = this;
        $.ajax({				
            headers: getAxiosHeaders(),   
            url: URL_BASE + 'api/aportacionesmendez.api.php?method=getAll',
                success:function(response){
                    vm.lstAportaciones = response.list;				
                },
                error: function (jqXHR, textStatus, errorThrown) { 
                    console.log("error");
                }
            });
    }   
    },
  });

  