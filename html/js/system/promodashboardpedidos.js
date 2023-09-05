
var app = new Vue({
    el: '#app',
    data:{

        filtro: {
            promotor: 0
        },

        pedidosproduccion1: [],
        pedidosproduccion2: [],
        pedidosterminados1: [],
        pedidosterminados2: [],
        pedidosentregados1: [],
        pedidosentregados2: []
    },
    mounted: function(){

        xajax_setIdPromotor();

        setTimeout(function(){

            if (app.filtro.promotor > 0)
            {
                app.cargarDatos();
            }
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
            if (this.filtro.promotor > 0)
            {
                xajax_cargarDatos(this.filtro.promotor);
            }
            else
            {
                saInfo("Primero seleccione un Promotor");
            }
        }
    }
});

$(document).ready(function()
{
    $("#collapseLeftMenu").click();
});
