
var app = new Vue({
    el: "#app",
    data: {
        sucursalOrigen: 0,
        sucursalDestino: 0,

        filtroProducto: '',

        stockOrigen: [],
        stockDestino: [],
    },
    mounted: function(){
        setTimeout(function() { $("#collapseLeftMenu").click()}, 250);
    },
    computed: {
        stockOrigenFiltered: function(){

            var self=this;
            return this.stockOrigen.filter(function(f){

                var producto = f.producto.toUpperCase();                                
                var find = self.filtroProducto.toUpperCase();

                return find == "" || producto.includes(find);

            });

       }
    },
    watch: {
        sucursalOrigen: function(value){
            if (value == 0)
            {
                this.stockOrigen.splice(0, this.stockOrigen.length);
            }
            else
            {
                // console.log("cargando remisiones");
                xajax_cargarStockDeSucursal(this.sucursalOrigen);
            }
        }
    },
    methods: {
        addToTarget: function(idProducto){

            var index = 0;
            for(index=0 ; index < this.stockOrigen.length ; index++)
            {
                if (this.stockOrigen[index].idProducto == idProducto)
                {
                    if ((this.stockOrigen[index].disponible - this.stockOrigen[index].porTransferir) > 0)
                    {
                        this.stockOrigen[index].porTransferir ++;
                        this.addProductToTarget(this.stockOrigen[index]);
                        // this.stockDestino.push({ index ,...this.stockOrigen[index]});
                    }
                    break;
                }
            }
            
        },
        addAllToTarget: function(idProducto){

            var index = 0;
            for(index=0 ; index < this.stockOrigen.length ; index++)
            {
                if (this.stockOrigen[index].idProducto == idProducto)
                {
                    if ((this.stockOrigen[index].disponible - this.stockOrigen[index].porTransferir) > 0)
                    {
                        this.stockOrigen[index].porTransferir = this.stockOrigen[index].disponible ;
                        this.addProductToTarget(this.stockOrigen[index]);
                        // this.stockDestino.push({ index ,...this.stockOrigen[index]});
                    }
                    break;
                }
            }
            
        },
        addProductToTarget: function(product){
            var index = 0;
            var existe = false;
            // console.log("buscar si existe producto en destino");
            for(index=0 ; index < this.stockDestino.length ; index++)
            {
                if (this.stockDestino[index].idProducto == product.idProducto)
                {
                    console.log("producto existe en destino, por transferir", product.porTransferir);
                    this.stockDestino[index].porTransferir = product.porTransferir;
                    existe = true;
                }
            }
            if (!existe)
            {

                this.stockDestino.push({
                    idProducto: product.idProducto,
                    producto: product.producto,
                    porTransferir: product.porTransferir
                });
            }
        },
        removeFromTarget: function(idProducto, indexTgt){

            var index = 0;
            for(index=0 ; index < this.stockOrigen.length ; index++)
            {
                if (this.stockOrigen[index].idProducto == idProducto)
                {
                    this.stockOrigen[index].porTransferir = 0;
                    this.stockDestino.splice(indexTgt, 1);
                    break;
                }
            }

        },
        removeOneFromTarget: function(idProducto, indexTgt){

            var index = 0;
            if (this.stockDestino[indexTgt].porTransferir > 1)
            {
                for(index=0 ; index < this.stockOrigen.length ; index++)
                {
                    if (this.stockOrigen[index].idProducto == idProducto)
                    {
                        this.stockOrigen[index].porTransferir --;
                        this.stockDestino[indexTgt].porTransferir --;                        
                        break;
                    }
                }
            }
            else
            {
                this.removeFromTarget(idProducto, indexTgt);
            }


        },
        cambiarOrigen: function(){
            swal({
		        title: "Atención",
		        text: "Los listados se limpiarán y tendrá que hacer su selección de nuevo. Ningun cambio ha sido guardado.",
		        type: "warning",
		        showCancelButton: true,
		        confirmButtonColor: "#DD6B55",
		        confirmButtonText: "Si, Seleccionar otra sucursal",
		        cancelButtonText: "Cancelar",
		        closeOnConfirm: true
		    }, function () {
				
                // alert("vamos");  
                app.clearScreen();              
                

		    });
        },
        clearScreen: function(){
            this.filtroProducto = "";
            this.sucursalOrigen = 0;
            this.sucursalDestino = 0;

            this.stockOrigen.splice(0, this.stockOrigen.length);
            this.stockDestino.splice(0, this.stockDestino.length);
        },
        tryGenerarTransferencia: function(){
            var seguir = true;
            
            if (this.sucursalOrigen == 0)
            {
                saInfo("Debe seleccionar sucursal origen");
                seguir = false;
            }
    
            if (this.sucursalDestino == 0)
            {
                saInfo("Debe seleccionar sucursal destino");
                seguir = false;
            }
    
            if (this.sucursalDestino == this.sucursalOrigen)
            {
                saInfo("Sucursal Origen debe ser diferente a Destino");
                seguir = false;
            }
    
            if (this.stockDestino.length <= 0)
            {
                saInfo("No ha seleccionado rollos para transferir");
                seguir = false;
            }
    
            if (seguir)
            {
                swal({
                    title: "Atención",
                    text: "Se generará la Transferencia con los productos seleccionados. Los productos permanecerán en Tránsito mientras no se acepte o cancele la transferencia.",
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
            xajax_generarTransferencia(this.sucursalOrigen, this.sucursalDestino, this.stockDestino);
        }
    },
    
});