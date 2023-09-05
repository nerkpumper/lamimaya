

var app = new Vue({
    el: "#app",
    data: {
        almacenOrigen: "SN",
        almacenDestino: "SN",

        transferencias: [],
    },
    mounted: function(){
        this.obtenerTransferencias();
    },
    computed: {
        transferenciasFiltered: function(){
            var self=this;
            return this.transferencias.filter(function(f){

                var origen = f.origen.toUpperCase();                
                var destino = f.destino.toUpperCase();
                var findOrigen = self.almacenOrigen.toUpperCase();
                var findDestino = self.almacenDestino.toUpperCase();

                return  (findOrigen == "SN" || findOrigen == origen) && 
                        (findDestino == "SN" || findDestino == destino);

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