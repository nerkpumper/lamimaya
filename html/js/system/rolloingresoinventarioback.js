

var app = new Vue({
	el: '#app',
	data: {		
		idRollo: 0,
		codigo: 'codigo',
		descripcion: 'desc',
		proveedor: 'prove',
		remision: '',
		almacen: "NS",
		comprador: "NS",
		noRollo: '',
		kilos: '',
		
		//rollo calibre y pies
		rollocalibre: 0,
		rollopies: 0,
		
		errRemision: '',
		errAlmacen: '',
		errNoRollo: '',
		errKilos: '',
		errComprador: '',
		
		ingresos: [],
		
		blnNoRegistrados: false,
		blnProcesado: false
		
	},
	mounted: function () {
		if (typeof param1 !== 'undefined') {
			this.idRollo = param1;					  
//			alert("a cargar rollo");
//			xajax_cargarRollo(this.idRollo);	
//			setTimeout(function(){xajax_cargarRollo(app.idRollo);}, 1000);
			this.cargarRollo();
		}
		
		this.$refs.remision.focus();
	},	
	watch: {
		noRollo: function(val){
			this.noRollo = val.toUpperCase();
		},
		remision: function(val){
			this.remision = val.toUpperCase();
			if (this.remision != "")
			{
				this.errRemision = "";
			}
		},
		ingresos: function(){
			this.blnNoRegistrados = false;
		},
		comprador: function(val){
			if (this.comprador != "NS")
				this.errComprador = "";
		},
		almacen: function(val){
			if (this.almacen != "NS")
				this.errAlmacen = "";
		}
	},
	methods:{	
		enlistarNoRollo: function(){
//			alert("Enlistar Rollo");
			var qr = this.noRollo;
			var datosqr = qr.split(",");
			var calibre = 0;
			var pies = 0;
			var kilos = 0;
			
			console.log(datosqr);
			console.log(datosqr.length);
			
			if (datosqr.length == 4 || datosqr.length == 3)
				{
				
					var calibrepies = "";
				
					if (datosqr.length == 4)
					{
						kilos = datosqr[3];
						calibrepies = datosqr[1] + datosqr[2];						
					}
					else
					{
						kilos = datosqr[2];
						calibrepies = datosqr[1];
					}
					
					if (isNaN(kilos) || kilos <=0)
					{
						saInfo("Parece que los Kilos del registro que ha capturado no son correctos");
						return;
					}
					
					console.log(calibrepies);
					calibrepies = calibrepies.replace(" ", "");
					
					calibrepies = calibrepies.replace("CAL", "");					
					calibrepies = calibrepies.replace("MM", "");					
					
//					if (calibrepies.includes("MM") && calibrepies.includes("CAL") && calibrepies.includes("X"))
//					{
						var datoscalibrepies = calibrepies.replace("CAL", "").replace("MM", "").split("X");
						
						console.log(datoscalibrepies);
						console.log(datoscalibrepies[1]);
						console.log(datoscalibrepies[1] / 304.8);
						// .68 .86
						
						if (calibre >= 0.68 && calibre <= 0.86)
							{
							calibre = 22;
							}
						
						
						
						calibre = datoscalibrepies[0];
						pies = Math.trunc(datoscalibrepies[1] / 304.8);
//						ABC001,26CALX1,22MM,5.6
						this.ingresos.push({
							qr: qr,
							norollo: datosqr[0],
							kilos: kilos * 1000,
							calibre: calibre,
							pies: pies,
							okcalibre: (this.rollocalibre == calibre ? 'SI' : 'NO'),
							okpies: (this.rollopies == pies ? 'SI' : 'NO'),
							oksistema: 'SI',
							oklista: 'NO',
							insertado: 'NO'
						});
						
						this.noRollo = "";			
						this.buscarRepetidosEnLista();
						xajax_verificaExistenciaRolloEnSistema(this.ingresos.length - 1, datosqr[0]);
						this.$refs.noRollo.focus();
//					}
//					else
//					{
//						saError("Código no valido, al parecer no contiene los datos de CAL y MM. Verifique");
//					}
					
					
				}
			else
				{
					saError("Código no valido, no contiene los datos necesarios para el proceso. Verifique");
				}			
		},
		buscarRepetidosEnLista: function(){
			
			for (i = 0 ; i < this.ingresos.length ; i++)
				{
					this.ingresos[i].oklista = 'SI';
					for (i2 = 0 ; i2 < this.ingresos.length ; i2++)
					    {
							
					        if(this.ingresos[i].norollo == this.ingresos[i2].norollo && i != i2)
					        	 {
					        		this.ingresos[i].oklista = 'NO';
					        	 }
					    }
				}
			
		},
		cargarRollo: function(){
//			alert("a cargar rollo");
			xajax_cargarRollo(this.idRollo);
		},
		
		nuevaRecepcion: function(){
			this.blnProcesado = false;
			this.ingresos.splice(0, this.ingresos.length);
			this.limpiaDatos();
			this.$refs.remision.focus();	
		},
		
		registrarIngreso: function(){
			this.blnNoRegistrados = false;
			
			this.errAlmacen = "";
			this.errRemision = "";
			this.errComprador = "";
			
			if (this.comprador != "NS")
			{
				if (this.almacen != "NS")
				{
					if (this.remision != "")
					{
						if (this.datosNoRolloValidos())
						{
//							alert("vamos");
							xajax_registrarIngresos(this.idRollo, this.almacen, this.comprador, this.remision, this.ingresos);
						}
						else
						{
							saInfo("No se pueden registrar los No Rollos deseados, verifique la lista el porqué no se pueden ingresar.");
							return;
						}
						
							
					}
					else
					{
						this.errRemision = "Ingrese Remisión";
						saInfo("Debe Ingresar Remisión.");
					}
					
				}
				else
				{
					this.errAlmacen = "Seleccione Almacén";
					saInfo("Debe Seleccionar un Almacén.");
				}	
			}
			else
			{
				this.errComprador = "Seleccione Comprador";
				saInfo("Debe Seleccionar un Comprador.");
			}
			
			
			
		},
		datosNoRolloValidos: function(){
			var result = true;
			
			
			for(var i = 0; i < this.ingresos.length ; i ++)
			{
				
			      if (this.ingresos[i].okcalibre == 'NO' ||
			          this.ingresos[i].okpies == 'NO' ||
			    	  this.ingresos[i].oksistema == 'NO' ||
			    	  this.ingresos[i].oklista == 'NO' )
			    	 {
			    	  	result = false;
			    	  	break;
			    	 }
			}
			
			return result;
		},
		probarIndex: function(){
			this.blnNoRegistrados = true;
			this.ingresos[2].estatusLabel = "<span class='label label-danger'>El N&uacute;mero de Rollo ya se encuentra registrado.</span>";
			this.blnProcesado = true;
		},
		quitarIngreso: function(index){
			this.ingresos.splice(index, 1);
			
			this.buscarRepetidosEnLista();
		},
		limpiaDatos: function(){
			this.remision = '';
			this.noRollo = '';
			this.kilos = '';
		},
		limpiaErrores: function(){
			this.errRemision = '';
			this.errNoRollo = '';
			this.errKilos = '';
		},
		fnRegresarAListado: function(){
						
			window.location = URL_BASE + "rollo";
		}
	}
  
});


$(document).ready(function()
		{
		    $("#collapseLeftMenu").click();
		});
