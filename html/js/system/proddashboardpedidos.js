var inter;
var app = new Vue({
    el: '#app',
    data:{
    	
    	mostrarEspera: false,

        filtro: {
            promotor: 0
        },

        lstSucursales: [],
        sucursalSeleccionada:'TORRES LANDA',

        pedidosproduccion1: [],
        pedidosproduccion2: [],
        pedidosterminados1: [],
        pedidosterminados2: [],
        pedidosentregados1: [],
        pedidosentregados2: []
    },
    mounted: function(){
    	
        this.cargarSucursales();

        setTimeout(function(){

//            if (app.filtro.promotor > 0)
//            {
                app.cargarDatos();
//            }
        }, 100);

        //
        // this.pedidosproduccion1.push({
        //     id: 1,
        //     nombreCliente: 'cliente',
        //     recogeentrega: 'RECOGE',
        //     total: '1'
        // });
        // this.pedidosproduccion2.push({
        //     id: 1,
        //     nombreCliente: 'cliente',
        //     recogeentrega: 'RECOGE',
        //     total: '1'
        // });
        // this.pedidosproduccion1.push({
        //     id: 1,
        //     nombreCliente: 'cliente',
        //     recogeentrega: 'ENTREGA',
        //     total: '1'
        // });
        // this.pedidosproduccion2.push({
        //     id: 1,
        //     nombreCliente: 'cliente',
        //     recogeentrega: 'ENTREGA',
        //     total: '1'
        // });
        // this.pedidosproduccion1.push({
        //     id: 1,
        //     nombreCliente: 'cliente',
        //     recogeentrega: 'RECOGE',
        //     total: '1'
        // });
    },
    methods: {
        cargarDatos: function(){
        	
        	this.mostrarEspera = true;
//        	console.log("vamos");
        	
//            if (this.filtro.promotor > 0)
//            {
                xajax_cargarDatos(this.sucursalSeleccionada);
//            }
//            else
//            {
//                saInfo("Primero seleccione un Promotor");
//            }
        },

        cargarSucursales: function(){
    
            $.ajax({				
                headers: getAxiosHeaders(),   
                url: URL_BASE + 'api/sucursal.api.php?method=getSucursales',
                    success:function(response){
                        app.lstSucursales = response.list;				
                        // console.log(app.idSucursalSeleccionada);
                        // app.x=(app.idSucursalSeleccionada)-1;
                        // app.nombreSucursal=app.lstSucursales[app.x].nombre;
                    },
                    error: function (jqXHR, textStatus, errorThrown) { 
                        console.log("error");
                    }
                });
            
            // axios.get(URL_BASE + 'api/sucursal.api.php?method=getSucursales')
            // .then(function (response) {
            
            //     app.lstSucursales = response.data.list;				
        
            // })
            // .catch(function (error) {
            //     console.log(error);
            // });  
        
        
        },
    }
});

$(document).ready(function()
{
    $("#collapseLeftMenu").click();
    inter = setInterval(app.cargarDatos, 5000);
});
