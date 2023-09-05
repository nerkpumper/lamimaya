var app = new Vue({
    el: '#app',
    data: {
      msgError: '',
      monto:0,      
      referencia: '',   
      errMonto:'',
      errReferencia:'',
      pedidosOtrosCargos: [],
      seguir: false,
      isUserMendez: false,
      idUsuario : 0,
      idPedidoSeleccionado:0,
      
    },
    mounted() {
        this.idUsuario = _IDUSUARIO;
    
       
        this.cargarPedidosFechaCompromisoPorVencer();
    },
   
    methods:{

        cerrarPedidoOtrosCargos: function(pedidoSeleccionado){

            app.idPedidoSeleccionado= pedidoSeleccionado;
            $.ajax({				
                headers: getAxiosHeaders(),   
                url: URL_BASE + 'api/pedido.api.php?method=cerrarPedidosOtrosCargos&idPedido=' + app.idPedidoSeleccionado+ '&idUsuario='+app.idUsuario,
                    success:function(response){
                        if (!response.error){ 
                            $('#modalUpdateFechaCompromiso').modal('hide'); 
        
                            app.cargarPedidosFechaCompromisoPorVencer(); 
                            saSuccess("el pedido: "+ app.idPedidoSeleccionado+" se actualizo correctamente");
                                
                        }
                        else{
                            saError(response.msg);
                        } 
                    },
                    error: function (jqXHR, textStatus, errorThrown) { 
                        console.log("error");
                    }
                });
        },

    cargarPedidosFechaCompromisoPorVencer: function(){
   
        $.ajax({				
            headers: getAxiosHeaders(),   
            url: URL_BASE + 'api/pedido.api.php?method=getPedidoOtrosCargos',
                success:function(response){
                    app.pedidosOtrosCargos = response.lst;
                },
                error: function (jqXHR, textStatus, errorThrown) { 
                    console.log("error");
                }
            });
    
        // axios.get(URL_BASE + 'api/pedido.api.php?method=getFechaCompromisoPorVencer&idUsuarioCaptura='+_IDUSUARIO)
        //         .then(function (response) {          
        //             app.pedidosPorVencer = response.data.lst;
                   
        //         })
        //         .catch(function (error) {
        //             console.log(error);
        //         });  
    
    },  
    },
  });

  