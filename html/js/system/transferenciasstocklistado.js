

var app = new Vue({
    el: "#app",
    data: {
        sucursalOrigen: 0,
        sucursalDestino: 0,

        transferencias: [],
    },
    mounted: function(){
        this.obtenerTransferencias();
    },
    computed: {
        transferenciasFiltered: function(){
            var self=this;
            return this.transferencias.filter(function(f){
                // console.log(self.sucursalOrigen + "   "  + f.origen);
                var origen = f.origen.toUpperCase();                
                var destino = f.destino.toUpperCase();
                var findOrigen = self.sucursalOrigen;
                var findDestino = self.sucursalDestino;

                return  (findOrigen == "0" || findOrigen.toUpperCase() == origen) && 
                        (findDestino == "0" || findDestino.toUpperCase() == destino);

            });
        }
    },
    methods: {
        obtenerTransferencias: function(){
            // alert("a obtener");
            xajax_obtenerTransferencias();
        }

    }
});