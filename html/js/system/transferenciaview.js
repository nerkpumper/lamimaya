
var app = new Vue({
    el: "#app",
    data: {
        idTransferencia: 0,

        estatus: '',

        almacenOrigen: "SN",
        almacenDestino: "SN",
        generadaPor: "",
        aceptadaPor: "",

        rollos: []
    },    
    mounted: function(){
		if (typeof param1 !== 'undefined') {
			this.idTransferencia = param1;
						
			this.cargarDatosTransferencia();					
		}
    },
    methods: {
        cargarDatosTransferencia: function(){
            xajax_cargarDatosTransferencia(this.idTransferencia);
        },
        aceptarTransferencia: function(){
            xajax_aceptarTransferencia(this.idTransferencia);
        },
        tryAceptaTransferencia: function(){
            swal({
                title: "Atención",
                text: "Los rollos pasaran de TRANSITO al Almacen indicado en la Transferencia. ¿Desea continuar?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Confirmar",
                cancelButtonText: "Cancelar",
                closeOnConfirm: false
            }, function () {
                
                // alert("vamos");  
                app.aceptarTransferencia();              
                

            });
        },
        frRegresarATransferencias: function(){
            window.location = URL_BASE +"transferenciaslistado";
        }
    },
    
});