var i;

var app = new Vue({
    el: '#app',
    data: {
        noRollo: '',
        msgError: '',
        rollos: [],        
    },
    created: function() {
        i = 1;
    },
    watch: {
        noRollo: function(val){
            this.noRollo = val.toUpperCase();
        }
    },
    methods: {
        cargarDatosNoRollo: function(){
            if (this.noRollo != "")
            {
                this.msgError = '';
                xajax_cargarNoRemisiones(this.noRollo);
            }
            else
            {
                saTexto("Debes introducir un Número de Rollo");
            }
        },
        cambiaralmacen: function(){
            
        	alert(this.almacendestino); 
        	
        	if(this.almacendestino != "SN"){
                this.almacenorigen =this.almacendestino;
                alert('este ahora es el valor de almacen de origen '+ this.almacenorigen);
            }else{
                alert('esto funciona bien en el error');
            }

        },
        cambiaralmacenByIndex: function(indexrollo, indexnorollo){
        	//alert("cambiar " + this.rollos[indexrollo].noRollos[indexnorollo].almacendestino);
        	if (this.rollos[indexrollo].noRollos[indexnorollo].almacendestino == "SN")
        	{
        		saInfo("Si desea cambiar de almacen al No Rollo " + this.rollos[indexrollo].noRollos[indexnorollo].noRollo + " debe seleccionar un Almacen Destino." );
        	}
        	else
        	{                              //index rollo, index no rollo, objeto noRollo
        		xajax_cambiarNoRolloAAlmacen(indexrollo, indexnorollo, this.rollos[indexrollo].noRollos[indexnorollo]);
        	}
        },
        addRollo: function(){
            this.rollos.push({idRollo: i, codigo: 'codigo', descripcion: 'rollito ' + i, noRollos: []});
            i++;
        },
        addHijo: function(index){
            var hijos = this.rollos[index].noRollos.length;
            hijos++;
            this.rollos[index].noRollos.push({ idNoRollo: hijos, noRollo: 'no rollo' + hijos, fecha: hijos, remision: hijos, almacen: hijos, kilos: hijos, disponible: hijos  });

        },
    }
});