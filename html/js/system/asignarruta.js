var app = new Vue({
	el: '#app',
	data: {

        isMesActual: false,        
        mesCalendario: 0,
        anioCalendario: 0,
        primerDiaCalendario: 0,
        ultimoDiaCalendario: 0,
        primerDiaSemana: 0,
        diaActual: 0,
        anioActual: 0,
        mesActual: 0,

        //kilometraje se salida
        vehiculoSalidaIndex: 0,
        vehiculoSalidaPlaca: "",
        vehiculoSalidaNombre: "",
        vehiculoSalidaKm: 0,
        vehiculoSalidaLastKm: 0,

        //para manejar el dia
        puedeAbrirMatutino: true,
        puedeAbrirVespertino: true,
        esHoy: false,

        //mover vales de una ruta a otra
        moverValesDeAqui: 0,
        moverValesAAqui: 0,

        diaSeleccionado: 0,
        blnPuedeAsignarPedidos: true,

        currentDate: '',

        //para enviar la ruta
        msgModalEnvio: '',

        //transporte
        idVehiculoSelected: 0,
        
        //idruta show
        idRutaShow: 0,

        //envio
        envioRutaStep: 1,
        detalleEnvio: {
                idRutaEnvio: 0,
                vehiculos: [],
                vsNoEnviados: []
            },

        //rutaEnvio
        idRutaEnvio: 0,
        rutaEnvioMaxML: 0,
        rutaEnvioMaxKG: 0,
        rutaEnvioEnviado: false,
        

        turno: 'MATUTINO',
        rutaSeleccionada: 0,
        rutaNombre: '',

        // motrar
        mostrarCalendario: true,
        mostrarDia: false,
        mostrarRuta: false,
        mostrarRutaDetalle: false,

        rutas: [],
        pedidos: [],
        calendario: [],
        rutasenviomes: [],
        rutaenviodetalle: [],
        vehiculos: [],
        vehiculosParaEnviar: [],
        vehiculoRegreso: {},

		dragging: -1
	},
    mounted: function(){
        // console.log("mounted")

        var date = new Date();
        primerdia = new Date(date.getFullYear(), date.getMonth(), 1);
        ultimodia = new Date(date.getFullYear(), date.getMonth() + 1, 0);
        this.primerDiaCalendario = primerdia.getDate()
        this.ultimoDiaCalendario = ultimodia.getDate()
        this.isMesActual = true
        this.primerDiaSemana = primerdia.getDay()
        this.mesCalendario = date.getMonth()
        this.mesActual = date.getMonth()
        this.anioCalendario = date.getFullYear()
        this.anioActual = date.getFullYear()
        this.diaActual = date.getDate()

        this.llenarCalendario()
        // this.showDia(6)
        this.obtenerRutas()
        this.cargarPedidosParaAsignar()
        setInterval(function(){ app.cargarPedidosParaAsignar() }, 5000); // cda 5 segundos

        setTimeout(function() { app.idRutaShow ++ }, 1000)
        setTimeout(function() { app.idRutaShow ++ }, 2000)
        setTimeout(function() { app.idRutaShow ++ }, 3000)

        
    },
    computed: {
    
        valesEnVehiculo: function(){
            if (this.idVehiculoSelected == 0){
                return []
            }
            else{
                var index = this.vehiculos.findIndex(x => x.id == this.idVehiculoSelected)

                if (index >= 0){
                    return this.vehiculos[index].vs
                }

            }
        },
        // valesEnVehiculo: function(){
        //     if (this.idVehiculoSelected == 0){
        //         return []
        //     }
        //     else{
        //         var index = this.vehiculos.findIndex(x => x.id == this.idVehiculoSelected)

        //         if (index >= 0){
        //             return this.vehiculos[index].vs
        //         }

        //     }
        // },
        pedidosParaEnrutar: function(){

            var self=this;
	    	 
	    	 return this.pedidos.filter(function(cust){
	    		
	    		return cust.tipoRuta == 'SINRUTA';

	    	 });
        },
        pedidosParaReEnrutar: function(){

            var self=this;
	    	 
	    	 return this.pedidos.filter(function(cust){
	    		
	    		return cust.tipoRuta == 'REENRUTAR';

	    	 });
        },
        nombreDia: function(){
            var mes = this.mesCalendario + 1
            var dia = this.diaSeleccionado;            
            if(dia<10)
                dia='0'+dia; //agrega cero si el menor de 10
            if(mes<10)
                mes='0'+mes //agrega cero si el menor de 10

            var fec = mes+"/"+dia+"/"+this.anioCalendario;
            var day = new Date(fec).getDay();
            // console.log(fec)
            // console.log(day)

            switch(day){
                case 0:
                    return "DOMINGO"
                case 1:
                    return "LUNES"
                case 2:
                    return "MARTES"
                case 3:
                    return "MIERCOLES"
                case 4:
                    return "JUEVES"
                case 5:
                    return "VIERNES"
                case 6:
                    return "SABADO"
            }
        },
        nombreMes: function(){
            switch(this.mesCalendario){
                case 0:
                    return "ENERO"
                case 1:
                    return "FEBRERO"
                case 2:
                    return "MARZO"
                case 3:
                    return "ABRIL"
                case 4:
                    return "MAYO"
                case 5:
                    return "JUNIO"
                case 6:
                    return "JULIO"
                case 7:
                    return "AGOSTO"
                case 8:
                    return "SEPTIEMBRE"
                case 9:
                    return "OCTUBRE"
                case 10:
                    return "NOVIEMBRE"
                case 11:
                    return "DICIEMBRE"
            }

        }
    },
	methods: {  
        llenarCalendario: function(){

        //     mesCalendario: 0,
        // anioCalendario: 0,
        // primerDiaCalendario: 0,
        // ultimoDiaCalendario: 0,
        // primerDiaSemana: 0,
        // diaActual: 0,
        // anioActual: 0,
        // mesActual: 0,

            // console.log(this.primerDiaCalendario)
            // console.log(this.ultimoDiaCalendario)

            this.calendario.splice(0, this.calendario.length);

            var i = 0
            if (this.primerDiaSemana > 0)
            {
                for (i = 1; i < this.primerDiaSemana ; i++)
                {
                    this.calendario.push({
                            dia: 0,
                            rutasenvios: []
                        })
                }
            }
            else
            {
                for (i = 0; i < 6 ; i++)
                {
                    this.calendario.push({
                            dia: 0,
                            rutasenvios: []
                        })
                }
            }

            for (i = this.primerDiaCalendario; i <= this.ultimoDiaCalendario ; i++)
            {
                this.calendario.push({
                        dia: i,
                        rutasenvios: []
                    })
            }

            
            this.cargarRutasEnviosMesCalendario()

            
             
            
        },
        cargarRutasEnviosMesCalendario: function(){
            // alert("vamos por las rutas del mes " + this.anioCalendario + ' '  + this.mesCalendario)
            mdlShowWait()
            xajax_getEnvioRutasMes(this.anioCalendario, this.mesCalendario)
        },
        ponerRutasEnvioEnCalendario: function(){
            this.calendario.forEach(element => {
                element.rutasenvios.splice(0, element.rutasenvios.length)
            })

            var index = 0
            var lastDay = 0
            
            this.rutasenviomes.forEach(element => {

                if (lastDay != element.dia)
                {
                    index = this.calendario.findIndex(c => c.dia == element.dia)
                    lastDay = element.dia
                }

                this.calendario[index].rutasenvios.push(element)
                // console.log(element.idRutaEnvio  + " el dia " + element.dia + " esta en index cal " + index)
                // console.log(element)

                // element.rutasenvios.splice(0, element.rutasenvios.length)
            });

            mdlExitWait();
        },
        showCalendario: function(){ //muestra el calendario
            this.mostrarCalendario = true
            this.mostrarDia = false
            this.mostrarRuta = false
            this.mostrarRutaDetalle = false
            this.idRutaEnvio = 0
            this.cargarRutasEnviosMesCalendario();
        },
        showDia: function(dia, desdeCalendadio = false){ //muestra la lista de rutas

            var mes = this.mesCalendario + 1
            var edia = dia;            
            if(edia<10)
                edia='0'+edia; //agrega cero si el menor de 10
            if(mes<10)
                mes='0'+mes //agrega cero si el menor de 10


            var f1 = new Date()

            var f1year    = f1.getFullYear();
            var f1month   = f1.getMonth()+1; 
            var f1day     = f1.getDate();
            var f1hour    = f1.getHours();
            var f1minute  = f1.getMinutes();
            var f1second  = f1.getSeconds(); 

            if (f1month < 10)
                f1month = '0' + f1month
            
            if (f1day < 10)
                f1day = '0' + f1day

            var f2 = new Date(this.anioCalendario, this.mesCalendario, dia)
                
            // console.log(f1)
            // console.log(f2)
            

            var f2year    = f2.getFullYear();
            var f2month   = f2.getMonth()+1; 
            var f2day     = f2.getDate();
            var f2hour    = f2.getHours();
            var f2minute  = f2.getMinutes();
            var f2second  = f2.getSeconds(); 

            if (f2month < 10)
                f2month = '0' + f2month
            
            if (f2day < 10)
                f2day = '0' + f2day

            // console.log(f1year)
            // console.log(f1month)
            // console.log(f1day)
            // console.log(f1hour)
            // console.log(f1minute)
            // console.log(f1second)

            // console.log(f2year)
            // console.log(f2month)
            // console.log(f2day)
            // console.log(f2hour)
            // console.log(f2minute)
            // console.log(f2second)

            var strf1 = parseInt(f1year + '' + f1month + '' + f1day)
            var strf2 = parseInt(f2year + '' + f2month + '' + f2day)
            
            // console.log(strf1)
            // console.log(strf2)                

            this.puedeAbrirMatutino = true
            this.puedeAbrirVespertino = true
            this.esHoy = false

            if (strf1 == strf2){
                this.esHoy = true

                if(f1hour >= 12){
                    this.puedeAbrirMatutino = false
                }

                // if(f1hour >= 17){
                //     this.puedeAbrirVespertino = false
                // }
            }

            if (desdeCalendadio)
            {                
                

                if(strf1 > strf2){
                    saInfo("No puedes agregar rutas a días pasados.")
                    return
                }
            }

            this.blnPuedeAsignarPedidos=true
            this.currentDate =edia +"/"+mes+"/"+this.anioCalendario;

            this.diaSeleccionado = dia
            this.mostrarCalendario = false
            this.mostrarDia = true
            this.mostrarRuta = false
            
            this.rutaSeleccionada = 0
            this.rutaNombre = ''
            this.turno = ''
            this.idRutaEnvio = 0

            this.rutaenviodetalle.splice(0, this.rutaenviodetalle.length)

            
        },
        showRuta: function(index){  //muestra la ruta, donde seleccionan el turno
            
            this.idRutaEnvio = 0
            this.mostrarCalendario = false
            this.mostrarDia = false
            this.mostrarRuta = true
            
            this.rutaSeleccionada = 0
            this.rutaNombre = ''
            this.turno = ''
            this.rutaEnvioEnviado = false

            this.rutaNombre = this.rutas[index].nombre + ' ' + this.rutas[index].descripcion
            this.rutaSeleccionada = this.rutas[index].id
        },        
        obtenerRutas: function(){
            // console.log("a obtener rutas")
            xajax_obtenerRutas();
            
        },
        seleccionarTurno: function(turno){

            if (!this.blnPuedeAsignarPedidos)
            {   
                saInfo("No puedes agregar rutas a días pasados.")
                return
            }

            this.turno = turno

            // this.diaSeleccionado
            // this.mesCalendario
            // this.anioCalendario

            mdlShowWait('Obteniendo datos de la Ruta en el Turno seleccionado')
            xajax_getIdRutaEnvio(this.diaSeleccionado, this.mesCalendario, this.anioCalendario, this.rutaSeleccionada, this.turno)

        },
        irAMesAnterior: function(){
            var mes = this.mesCalendario 
            var anio = this.anioActual

            if (mes == 0)
            {
                mes = 12
                anio = anio - 1
            }

            var dia = '01'            

            

        
            var fec = mes+"/"+dia+"/"+ anio;
            var date = new Date(fec);
            primerdia = new Date(date.getFullYear(), date.getMonth(), 1);
            ultimodia = new Date(date.getFullYear(), date.getMonth() + 1, 0);
            this.primerDiaCalendario = primerdia.getDate()
            this.ultimoDiaCalendario = ultimodia.getDate()
            this.isMesActual = false
            this.primerDiaSemana = date.getDay()
            this.mesCalendario = date.getMonth()
            this.anioCalendario = date.getFullYear()

            if (this.mesCalendario == this.mesActual){
                this.isMesActual = true
            }
            
            // this.mesActual = date.getMonth()            
            // this.anioActual = date.getFullYear()
            // this.diaActual = date.getDate()

            this.llenarCalendario();
            // this.cargarRutasEnviosMesCalendario();
        },
        irAMesActual: function(){

            if (this.isMesActual)
            {   
                console.log("ya estas en mes actual")
                return;
            }

            var date = new Date();
            primerdia = new Date(date.getFullYear(), date.getMonth(), 1);
            ultimodia = new Date(date.getFullYear(), date.getMonth() + 1, 0);
            this.primerDiaCalendario = primerdia.getDate()
            this.ultimoDiaCalendario = ultimodia.getDate()
            this.isMesActual = true
            this.primerDiaSemana = primerdia.getDay()
            this.mesCalendario = date.getMonth()
            this.mesActual = date.getMonth()
            this.anioCalendario = date.getFullYear()
            this.anioActual = date.getFullYear()
            this.diaActual = date.getDate()

            this.llenarCalendario();
            // this.cargarRutasEnviosMesCalendario();
        },
        irAMesSiguiente: function(){
            var mes = this.mesCalendario + 2
            var anio = this.anioActual

            if (mes > 12)
            {
                mes = 1
                anio = anio + 1
            }

            var dia = '01'   

            var fec = mes+"/"+dia+"/"+ anio;
            var date = new Date(fec);
            primerdia = new Date(date.getFullYear(), date.getMonth(), 1);
            ultimodia = new Date(date.getFullYear(), date.getMonth() + 1, 0);
            this.primerDiaCalendario = primerdia.getDate()
            this.ultimoDiaCalendario = ultimodia.getDate()
            this.isMesActual = false
            this.primerDiaSemana = date.getDay()
            this.mesCalendario = date.getMonth()
            this.anioCalendario = date.getFullYear()
            
            if (this.mesCalendario == this.mesActual){
                this.isMesActual = true
            }


            // this.mesActual = date.getMonth()            
            // this.anioActual = date.getFullYear()
            // this.diaActual = date.getDate()

            this.llenarCalendario();
            // this.cargarRutasEnviosMesCalendario();
        },
        cargarPedidosParaAsignar: function(){
            // console.log("cargando")
            xajax_cargarPedidosParaAsignar()
        },
        asignarValeSalidaARutaEnvio: function(idValeSalida){
            var index = -1

            index = this.pedidos.findIndex( e => e.idValeSalida == idValeSalida)
            console.log("index: " + index)
            if (index >= 0)
            {
                mdlShowWait();
                xajax_asignarValeSalidaARutaEnvio(index, this.idRutaEnvio, idValeSalida,  this.pedidos[index].idPedido, this.pedidos[index].maxml, this.pedidos[index].maxkg, this.currentDate, this.nombreDia, this.pedidos[index].cliente, this.turno, this.rutaNombre, this.pedidos[index].idUsuarioVenta, this.pedidos[index].idPromotor)
                // this.pedidos.splice(index, 1)
            }
        
        },
        verDetalleIdRutaEnvio: function(idRuta, idRutaEnvio, dia, turno){
            var index = -1

            index = this.rutas.findIndex(e => e.id == idRuta)
            if (index >= 0) 
            {
                this.showDia(dia)
                this.showRuta(index)   
                this.idRutaEnvio = idRutaEnvio
                this.turno = turno
                this.cargarRutaEnvioDetalle()

            }
        },
        cargarRutaEnvioDetalle: function(){
            // console.log("cargamos detalle   ")
            xajax_cargarRutaEnvioDetalle(this.idRutaEnvio)
        },
        desAsignarPedidoDeRuta: function(idValeSalida, idPedido, idRutaEnvioDetalle, key, index){

            var vm = this
            swal({
		        title: "Atención",
		        text: "Se desasignará el pedido seleccionado.",
		        type: "warning",
		        showCancelButton: true,
		        confirmButtonColor: "#DD6B55",
		        confirmButtonText: "Continuar",
		        cancelButtonText: "Cancelar",
		        closeOnConfirm: true
		    }, function () {
				                
				// alert("vamos");
				// $('#' + key).removeAttr('class').attr('class', '');
                // var animation = 'bounceOutLeft'
                // $('#' + key).addClass('vote-item');
                // $('#' + key).addClass('animated');
                // $('#' + key).addClass(animation);

                // setTimeout(function(){
                //     $('#' + key).removeAttr('class').attr('class', '');
                //     var animation = 'fadeIn'
                //     $('#' + key).addClass('vote-item');
                //     $('#' + key).addClass('animated');
                //     $('#' + key).addClass(animation);
                // }, 1500)
                
                setTimeout(function(){ 
                    // alert("vamos");
                    mdlShowWait();
                    xajax_desAsignarPedidoDeRuta(vm.idRutaEnvio, idRutaEnvioDetalle, idValeSalida, idPedido, vm.currentDate, vm.nombreDia, vm.rutaenviodetalle[index].cliente, vm.turno, vm.rutaNombre, vm.rutaenviodetalle[index].idUsuarioVenta, vm.rutaenviodetalle[index].idPromotor)
                    // vm.cargarRutaEnvioDetalle(); 
                    // vm.cargarPedidosParaAsignar(); 
                    
                    // alert("vamos");
				// $('#rutaenviodetalleid' + index).removeAttr('class').attr('class', '');
                // var animation = 'bounceInLeft'
                // $('#rutaenviodetalleid' + index).addClass('vote-item');
                // $('#rutaenviodetalleid' + index).addClass('animated');
                // $('#rutaenviodetalleid' + index).addClass(animation);
                }, 500)

		    });

            
        },
        desAsignarPedidoDeVehiculo: function(idValeSalida, idPedido, idRutaEnvioDetalle, index, indexv){

        // console.log("index  " + index +   "   indexv: " + indexv)
        
            var vm = this
            swal({
		        title: "Atención",
		        text: "Se desasignará el pedido seleccionado.",
		        type: "warning",
		        showCancelButton: true,
		        confirmButtonColor: "#DD6B55",
		        confirmButtonText: "Continuar",
		        cancelButtonText: "Cancelar",
		        closeOnConfirm: true
		    }, function () {
				                
			
                
                setTimeout(function(){ 
                    // alert("vamos");
                    mdlShowWait();
                    xajax_desAsignarPedidoDeRuta(vm.idRutaEnvio, idRutaEnvioDetalle, idValeSalida, idPedido, vm.currentDate, vm.nombreDia, vm.vehiculosParaEnviar[index].vs[indexv].cliente, vm.turno, vm.rutaNombre, vm.vehiculosParaEnviar[index].vs[indexv].idUsuarioVenta, vm.vehiculosParaEnviar[index].vs[indexv].idPromotor)
                    // vm.cargarRutaEnvioDetalle(); 
                    // vm.cargarPedidosParaAsignar(); 
                    
                    // alert("vamos");
				
                }, 500)

		    });

            
        },
        
        ordenMas: function(index){
            // alert("mover este para abajo");
            xajax_ordenMas(this.rutaenviodetalle[index].idRutaEnvioDetalle, this.rutaenviodetalle[index + 1].idRutaEnvioDetalle)
        },
        ordenMenos: function(index){
        // alert("mover este para arriba");
            xajax_ordenMas(this.rutaenviodetalle[index - 1].idRutaEnvioDetalle, this.rutaenviodetalle[index].idRutaEnvioDetalle)
        },
        prepareAsignarVehiculosDeCalendario: function(idRuta, idRutaEnvio, dia, turno){
            this.verDetalleIdRutaEnvio(idRuta, idRutaEnvio, dia, turno)

            setTimeout(function(){ app.prepareAsignarVehiculos() }, 250)

        },
        prepareAsignarVehiculos: function(){
            // alert("enviar a ruta")            
            this.envioRutaStep = 1
            this.idVehiculoSelected = 0
            // xajax_obtenerVehiculos()

            this.rutaenviodetalle.forEach(x => {

                if (x.idRutaEnvioVehiculo == 0)
                    x.vehiculoAsignado = 0
            })


            xajax_obtenerVehiculosRutaEnvio(this.idRutaEnvio, "vehiculos")
            // this.items.push({...this.newItem});
            // this.vehiculos = JSON.parse(JSON.stringify(this.vehiculosParaEnviar))
            // this.vehiculos.push ({...this.vehiculosParaEnviar})
            // this.vehiculos.push( JSON.parse( JSON.stringify( this.vehiculosParaEnviar ) ) );
            // this.vehiculosParaEnviar.forEach(x => this.vehiculos.push( Object.assign({} , x) ))
            $("#mdlAsignarVehiculos").modal()
        },
        prepareAsignarVehiculosSiguiente: function(){
            // console.log("envioRutaSiguiente")
            this.msgModalEnvio = ""

            if (this.envioRutaStep == 1)
            {
                var seguir = true
                var noSelected = 0
                this.vehiculos.forEach(element => {
                    if (element.selected){
                        noSelected++
                        
                        // if (element.km == '0' || element.km == ''){
                        //     seguir = false
                        // }
                    }
                    else{
                        if (element.vs.length > 0){
                            this.rutaenviodetalle.forEach(e => {
                                if (e.vehiculoAsignado == element.id){
                                    e.vehiculoAsignado = 0
                                }
                            });

                            element.vs = []
                            element.vsid = []
                        }
                    }
                    
                });

                if (noSelected == 0){
                    this.msgModalEnvio = "Debe seleccionar al menos un Vehículo"
                    return
                }

                this.idVehiculoSelected = 0

                if (seguir)
                    this.envioRutaStep++

                
            }
            else
            {
                if (this.envioRutaStep == 2){

                    var noAsigned = 0
                    this.rutaenviodetalle.forEach(element => {
                        if (element.listoParaSalir == 'SI' && element.vehiculoAsignado == 0){
                            noAsigned ++
                        }
                        
                    });


                    if (noAsigned > 0){
                        this.msgModalEnvio = "Hay algunos Vales de salida sin asignar a Vehículo"
                        return
                    }

                    var vehiculoEmpty = false

                    this.vehiculos.forEach(element => {
                        var maxml = 0
                        var kg = 0
                        element.vs.forEach(vs => {
                            if (vs.maxml > maxml){
                                maxml = vs.maxml
                            }

                            kg += vs.maxkg
                        });

                        if (element.vs.length == 0 && element.selected) vehiculoEmpty = true

                        element.maxml = maxml
                        element.kg = kg
                    });

                    if (vehiculoEmpty){
                        this.msgModalEnvio = "Todos los Vehículos seleccionados deben tener al menos un Vale de Salida."
                        return
                    }


                    this.envioRutaStep++
                }
                
            }

        },
        asignarVSaVehiculo: function(index){
            this.msgModalEnvio = ""
            // console.log("asignarVSaVehiculo " + this.idVehiculoSelected)
            var indexVehiculo = this.vehiculos.findIndex(x => x.id == this.idVehiculoSelected)

            if (indexVehiculo >= 0){
                // console.log("asignarVSaVehiculo en index " + indexVehiculo)
                this.rutaenviodetalle[index].vehiculoAsignado = this.idVehiculoSelected
                this.vehiculos[indexVehiculo].vs.push(this.rutaenviodetalle[index])
                // this.vehiculos[indexVehiculo].vsid.push({ 
                //         "idRutaEnvioDetalle": this.rutaenviodetalle[index].idRutaEnvioDetalle,
                //         "idValeSalida": this.rutaenviodetalle[index].idValeSalida
                //     })
                
            }
        },
        desAsignarVSaVehiculo: function(idRutaEnvioDetalle){
console.log("deasignando de aqui")
            this.msgModalEnvio = ""
            var indexVehiculo = this.vehiculos.findIndex(x => x.id == this.idVehiculoSelected)
            var indexVehiculoRutaEnvioDetalle = this.vehiculos[indexVehiculo].vs.findIndex(x => x.idRutaEnvioDetalle == idRutaEnvioDetalle)
            var indexRutaEnvioDetalle = this.rutaenviodetalle.findIndex(x => x.idRutaEnvioDetalle == idRutaEnvioDetalle)

            this.rutaenviodetalle[indexRutaEnvioDetalle].vehiculoAsignado = 0
            this.vehiculos[indexVehiculo].vs.splice(indexVehiculoRutaEnvioDetalle, 1)
            // this.vehiculos[indexVehiculo].vsid.splice(indexVehiculoRutaEnvioDetalle, 1)
        },
        asignarVehiculos: function(){

            this.detalleEnvio.idRutaEnvio = this.idRutaEnvio
            this.detalleEnvio.vehiculos = []
            this.detalleEnvio.vsNoEnviados = []
                           
            this.vehiculos.forEach(element => {
                // if (element.selected){
                    this.detalleEnvio.vehiculos.push({
                    
                        "id": element.id,
                        "selected": element.selected,
                        "placa": element.placa,
                        "descripcion": element.descripcion,
                        "km": element.km,
                        "vs": element.vs,
                        "idRutaEnvioVehiculo": element.idRutaEnvioVehiculo,
                    })
                // }
            });

            this.rutaenviodetalle.forEach(element => {
                if (element.listoParaSalir == 'NO' || element.vehiculoAsignado == 0){
                    this.detalleEnvio.vsNoEnviados.push({
                        element
                    
                    })                
                }
                
            });
            
            $("#mdlAsignarVehiculos").modal('toggle')

            mdlShowWait("Asignando Mercancía en Vehículos");
            xajax_asignarVehiculos(this.detalleEnvio, this.rutaNombre, this.nombreDia, this.currentDate, this.turno )
        },
        verRuta: function(idRuta){
            this.idRutaShow = idRuta
            $("#mdlVerRuta").modal()
        },
        preEnviarVehiculo: function(index){
            this.vehiculoSalidaIndex = index
            this.vehiculoSalidaPlaca = this.vehiculosParaEnviar[index].placa
            this.vehiculoSalidaNombre = this.vehiculosParaEnviar[index].descripcion
            this.vehiculoSalidaKm = this.vehiculosParaEnviar[index].km
            this.vehiculoSalidaLastKm = 0

            xajax_getLastKm(this.vehiculosParaEnviar[index].id)

            $("#mdlVehiculoSalida").modal()
        },
        enviarVehiculo: function(){
        
            var seguir = true
            
            if (this.vehiculoSalidaKm == '0' || this.vehiculoSalidaKm == '' || this.vehiculoSalidaKm < this.vehiculoSalidaLastKm){
                            seguir = false
                        }

            if (seguir)
            {
                $("#mdlVehiculoSalida").modal('toggle')

                var vm = this
                swal({
                    title: "Atención",
                    text: "Se marcará como enviado el vehículo seleccionado.",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Continuar",
                    cancelButtonText: "Cancelar",
                    closeOnConfirm: true
                }, function () {
                                    
                    setTimeout(function(){ 
                        
                        mdlShowWait("Enviando Vehículo");
                        xajax_enviarVehiculo(vm.vehiculosParaEnviar[vm.vehiculoSalidaIndex], vm.rutaNombre, vm.nombreDia, vm.currentDate, vm.turno, vm.vehiculoSalidaKm )
                    }, 100)

                });
            
            }
            else
            {
                saInfo("No se puede procesar la solicitud. Verifique")
            }
            

        },
        envioCompletado: function(index){
            this.vehiculoRegreso = this.vehiculosParaEnviar[index]
            $("#mdlVehiculoRegreso").modal()
        },
        registrarRegresoVehiculo: function(){
            var seguir = true

            if ((parseFloat(this.vehiculoRegreso.km) >= parseFloat(this.vehiculoRegreso.kmfinal)) || 
                (this.vehiculoRegreso.cargogasolina && this.vehiculoRegreso.litros <= 0) ||
                (this.vehiculoRegreso.cargogasolina && this.vehiculoRegreso.tipocombustible == 'NA') )
            {
                seguir = false
            }

            if (seguir){
                // alert(this.vehiculoRegreso.idRutaEnvioVehiculo)
                $("#mdlVehiculoRegreso").modal('toggle')

                mdlShowWait()
                xajax_regresoDeVehiculo(this.vehiculoRegreso, this.rutaNombre, this.nombreDia, this.currentDate, this.turno )

            }   
        
        },
        moverDetalleDeAqui: function(idRutaDesde){
            this.moverValesDeAqui = idRutaDesde
            saInfo("Para mover los Vales de Salida de la Ruta seleccionada, seleccione la nueva Ruta donde desea colocarlos")
        },
        moverDetalleHastaAqui: function(idRutaHasta, isInCalendario = true){
            this.moverValesAAqui = idRutaHasta

            var vm = this
            swal({
		        title: "Atención",
		        text: "Se moveran los Vales de Salida asignados de la ruta origen a la destino.",
		        type: "warning",
		        showCancelButton: true,
		        confirmButtonColor: "#DD6B55",
		        confirmButtonText: "Continuar",
		        cancelButtonText: "Cancelar",
		        closeOnConfirm: true
		    }, function () {
				                
				setTimeout(function(){ 
                    
                    mdlShowWait();
                    xajax_moverDetalle(vm.moverValesDeAqui, vm.moverValesAAqui, isInCalendario)
                }, 100)

		    });
            
        }

		
		
		
	}
});

$(document).ready(function(){
    $("#collapseLeftMenu").click();	


    

            

    // $("#wizard").steps();
// 	$(document).ready(function(){
            
//             $("#todo, #inprogress, #todo2").sortable({
//                 connectWith: ".connectList",
//                 update: function( event, ui ) {
// 				//console.log(event.target.id)
// // console.log(Object.values(event))
// //console.log(event)
// //if (ui.sender != null)
// //	console.log(ui.sender.context)
// //console.log(ui.item.id)
//                     var todo = $( "#todo" ).sortable( "toArray" );
//                     var inprogress = $( "#inprogress" ).sortable( "toArray" );
//                     var todo2 = $( "#todo2" ).sortable( "toArray" );
//                     console.log(todo2)
//                     // var completed = $( "#completed" ).sortable( "toArray" );
//                     $('.output').html("ToDo: " + window.JSON.stringify(todo) + "<br/>" + "In Progress: " + window.JSON.stringify(inprogress) + "<br/>" );
//                 }
//             }).disableSelection();

//         });

});