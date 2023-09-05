
var app = new Vue({
    el: "#app",
    data: {
        almacenOrigen: "SN",
        almacenDestino: "SN",

        filtroRollo: '',

        rollosOrigen: [],
        rollosDestino: [],
    },
    computed: {
        rollosOrigenFiltered: function(){

            var self=this;
            return this.rollosOrigen.filter(function(f){

                var remision = f.remision.toUpperCase();                
                var norollo = f.norollo.toUpperCase();
                var find = self.filtroRollo.toUpperCase();

                return find == "" || remision.includes(find) || norollo.includes(find);

            });

       }
    },
    watch: {
        almacenOrigen: function(value){
            if (value == "SN")
            {
                this.rollosOrigen.splice(0, this.rollosOrigen.length);
            }
            else
            {
                console.log("cargando remisiones");
                xajax_cargarRemisionesRollosDeAlmacen(this.almacenOrigen);
            }
        }
    },
    methods: {
        addToTarget: function(idRemisionRollo){

            var index = 0;
            for(index=0 ; index < this.rollosOrigen.length ; index++)
            {
                if (this.rollosOrigen[index].idRemisionRollo == idRemisionRollo)
                {
                    this.rollosOrigen[index].added = true;
                    this.rollosDestino.push({ index ,...this.rollosOrigen[index]});
                    break;
                }
            }
            
        },
        removeFromTarget: function(idRemisionRollo, indexTgt){

            var index = 0;
            for(index=0 ; index < this.rollosOrigen.length ; index++)
            {
                if (this.rollosOrigen[index].idRemisionRollo == idRemisionRollo)
                {
                    this.rollosOrigen[index].added = false;
                    this.rollosDestino.splice(indexTgt, 1);
                    break;
                }
            }

        },
        cambiarOrigen: function(){
            swal({
		        title: "Atención",
		        text: "Los listados se limpiarán y tendrá que hacer su selección de nuevo. Ningun cambio ha sido guardado.",
		        type: "warning",
		        showCancelButton: true,
		        confirmButtonColor: "#DD6B55",
		        confirmButtonText: "Si, Seleccionar otro Almacén",
		        cancelButtonText: "Cancelar",
		        closeOnConfirm: true
		    }, function () {
				
                // alert("vamos");  
                app.clearScreen();              
                

		    });
        },
        clearScreen: function(){
            this.filtroRollo = "";
            this.almacenOrigen = "SN";
            this.almacenDestino = "SN";

            this.rollosOrigen.splice(0, this.rollosOrigen.length);
            this.rollosDestino.splice(0, this.rollosDestino.length);
        },
        tryGenerarTransferencia: function(){
            var seguir = true;
            
            if (this.almacenOrigen == "SN")
            {
                saInfo("Debe seleccionar almacén origen");
                seguir = false;
            }
    
            if (this.almacenDestino == "SN")
            {
                saInfo("Debe seleccionar almacén destino");
                seguir = false;
            }
    
            if (this.almacenDestino == this.almacenOrigen)
            {
                saInfo("Almacen Origen debe ser diferente a Destino");
                seguir = false;
            }
    
            if (this.rollosDestino.length <= 0)
            {
                saInfo("No ha seleccionado rollos para transferir");
                seguir = false;
            }
    
            if (seguir)
            {
                swal({
                    title: "Atención",
                    text: "Se generará la Transferencia con los rollos seleccionados. Los rollos permanecerán en Tránsito mientras no se acepte o cancele la transferencia.",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Confirmar",
                    cancelButtonText: "Cancelar",
                    closeOnConfirm: false
                }, function () {
                    
                    // alert("vamos");  
                    app.generarTransferencia();              
                    
    
                });
            }
    
        },
        generarTransferencia: function(){
            xajax_generarTransferencia(this.almacenOrigen, this.almacenDestino, this.rollosDestino);
        }
    },
    
});