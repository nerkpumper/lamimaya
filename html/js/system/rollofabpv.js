//alert("iniciamos");

var app = new Vue({
	el: "#app",
	data: {
		
		seleccionarRollo: true,
		editing: false,
		
		
		seleccionado: {
			idRolloSeleccionado: 0,
			rollo: 'hola mundo',
			material: '0',
			proveedor: '0'
		},
		
		pesokgmtDeTabla: '0.00',
		debeGuardarPesoKgMt: false,
			
		campos: {
			recubrimiento: '',
			calibre: '',
			pies: '',
			origen: '',
			proveedor: '',
			
			iva: '',
			prodmes: '',
			porutilidad: '',
			porcomision: '',
			descuento: '',
			costoflete: '',
			costokg: '',

			pesokgmt: '',
			pesocu: '',
			pesoimporte: '',
			pesoparti: '',

			mod: '',
			moi: '',
			gastosfab: '',
			comisiones: '',
			comisionesR2: '',
			comisionesR3: '',
			gastosventa: '',
			gastosfinancieros: '',
			gastosadmon: '',
			totalessummes: '',

			modiva: '',
			moiiva: '',
			gastosfabiva: '',
			comisionesiva: '',
			gastosventaiva: '',
			gastosfinancierosiva: '',
			gastosadmoniva: '',
			totalessumkg: '',
			
			//participaciones
			modparti: '',
			moiparti: '',
			gastosfabparti: '',
			comisionesparti: '',
			gastosventaparti: '',
			gastosfinancierosparti: '',
			gastosadmonparti: '',
			
			
			//Renglon 29
			totalespeso: '', //totalespeso
			totalesfab: '', //totalesfab
						
			totalcostofab: '',
			totalpreciovta: '',
			totalpreciovtaR2: '',
			totalpreciovtaR3: '',			
		},
		
		datos: {			
			formula: 'formula',
			
			iva: '',
			prodmes: '',
			porutilidad: '',
			porcomision: '',
			descuento: '',
			costoflete: '',
			costokg: '',

			mod: '',
			moi: '',
			gastosfab: '',

			gastosventa: '',
			gastosfinancieros: '',
			gastosadmon: '',
		
		},
		
		productos: [],
		
		rollos: []
	},
	mounted: function(){
//		this.rollos.push ({id: 1, codigo: 'codiguillo', desc: 'descrip'});
//		this.rollos.push ({id: 2, codigo: 'codiguillo2', desc: 'descrip2'});
//		this.rollos.push ({id: 3, codigo: 'codiguillo3', desc: 'descrip3'});
		
//		this.cargarDatosRollo(31);
//		this.cargarDatosRollo(2);
		
//		this.productos.push({
//			idProducto: 1,
//			codigo: 'codigo1',
//			descripcion: 'producto 1',
//			unidad: 1,
//			ml: 0,
//			shortunidad: 'ML',
//			isRollo: false,
//			isRango: false,
//			heredarPrecio: true,
//			precio1: '0',
//			precio2: '0',
//			precio3: '0',
//			posibleprecio1: '0',
//			posibleprecio2: '0',
//			posibleprecio3: '0',
//			originalprecio1: '1',
//			originalprecio2: '0',
//			originalprecio3: '0'	
//		});
//		
//		this.productos.push({
//			idProducto: 2,
//			codigo: 'codigo2',
//			descripcion: 'producto 2',
//			unidad: 4,
//			ml: 7,
//			shortunidad: 'PZA',
//			isRollo: false,
//			isRango: false,
//			heredarPrecio: true,
//			precio1: '0',
//			precio2: '0',
//			precio3: '0',
//			posibleprecio1: '0',
//			posibleprecio2: '0',
//			posibleprecio3: '0',
//			originalprecio1: '2',
//			originalprecio2: '0',
//			originalprecio3: '0'	
//		});
//		
//		this.productos.push({
//			idProducto: 33,
//			codigo: 'codigo33',
//			descripcion: 'producto 33',
//			unidad: 1,
//			ml: 0,
//			shortunidad: 'ML',
//			isRollo: false,
//			isRango: true,
//			heredarPrecio: true,
//			precio1: '0',
//			precio2: '0',
//			precio3: '0',
//			posibleprecio1: '0',
//			posibleprecio2: '0',
//			posibleprecio3: '0',
//			originalprecio1: '3',
//			originalprecio2: '4',
//			originalprecio3: '5'	
//		});
//		
//		this.productos.push({
//			idProducto: 1,
//			codigo: 'codigo3',
//			descripcion: 'rollo 3',
//			unidad: 5,
//			ml: 0,
//			shortunidad: 'KG',
//			isRollo: true,
//			isRango: false,
//			heredarPrecio: true,
//			precio1: '0',
//			precio2: '0',
//			precio3: '0',
//			posibleprecio1: '0',
//			posibleprecio2: '0',
//			posibleprecio3: '0',
//			originalprecio1: '6',
//			originalprecio2: '0',
//			originalprecio3: '0'	
//		});
		
//		this.setPreciosProductosAll();
		
	},
	computed: {
		fiva(){
			return this.campos.iva;
		},
		fprodmes(){
			return this.campos.prodmes;
		},
		fporutilidad(){
			return this.campos.porutilidad;
		},
		fporcomision(){
			return this.campos.porcomision;
		},
		fdescuento(){
			return this.campos.descuento;
		},
		fcostoflete(){
			return this.campos.costoflete;
		},		
		fcostokg(){
			return this.campos.costokg;
		},
		fmod(){
			return this.campos.mod;
		},
		fmoi(){
			return this.campos.moi;
		},
		fgastosfab(){
			return this.campos.gastosfab;
		},
		fgastosventa(){
			return this.campos.gastosventa;
		},
		fgastosfinancieros(){
			return this.campos.gastosfinancieros;
		},
		fgastosadmon(){
			return this.campos.gastosadmon;
		}
	},
	watch: {
		fiva(){
			setTimeout(function() {app.calcularValores();}, 100);
		},
		fprodmes(){
			setTimeout(function() {app.calcularValores();}, 100);
		},
		fporutilidad(){
			setTimeout(function() {app.calcularValores();}, 100);
		},
		fporcomision(){
			setTimeout(function() {app.calcularValores();}, 100);
		},
		fdescuento(){
			setTimeout(function() {app.calcularValores();}, 100);
		},
		fcostoflete(){
			setTimeout(function() {app.calcularValores();}, 100);
		},
		fcostokg(){
			setTimeout(function() {app.calcularValores();}, 100);			
		},
		fmod(){
			setTimeout(function() {app.calcularValores();}, 100);
		},
		fmoi(){
			setTimeout(function() {app.calcularValores();}, 100);
		},
		fgastosfab(){
			setTimeout(function() {app.calcularValores();}, 100);
		},
		fgastosventa(){
			setTimeout(function() {app.calcularValores();}, 100);
		},
		fgastosfinancieros(){
			setTimeout(function() {app.calcularValores();}, 100);
		},
		fgastosadmon(){
			setTimeout(function() {app.calcularValores();}, 100);
		},
	},
	methods: {
		cargarDatosRollo: function(idRollo){
			xajax_cargarRollo(idRollo);
			
		},
		recargarDatosRollo: function(){
			this.cargarDatosRollo(this.seleccionado.idRolloSeleccionado);			
		},
		filtrar: function(){
			xajax_cargarRollos(this.seleccionado.material, this.seleccionado.proveedor);
		},
		swappesokgmt: function(){
			this.campos.pesokgmt = this.pesokgmtDeTabla;
			this.calcularValores();
			this.debeGuardarPesoKgMt = true;
		},
		simularValores: function(){
			this.editing = false;
			this.setPreciosProductosAll();
		},
		activarEdicion: function() {
			this.datos.iva = this.campos.iva;
			this.datos.prodmes = this.campos.prodmes;
			this.datos.porutilidad = this.campos.porutilidad;
			this.datos.porcomision = this.campos.porcomision;
			this.datos.descuento = this.campos.descuento;
			this.datos.costoflete = this.campos.costoflete;
			this.datos.costokg = this.campos.costokg;

			this.datos.mod = this.campos.mod;
			this.datos.moi = this.campos.moi;
			this.datos.gastosfab = this.campos.gastosfab;

			this.datos.gastosventa = this.campos.gastosventa;
			this.datos.gastosfinancieros = this.campos.gastosfinancieros;
			this.datos.gastosadmon = this.campos.gastosadmon;
			
			this.editing = true;
		},
		cancelarEdicion: function(){
			this.editing = false;
			this.campos.iva = this.datos.iva;
			this.campos.prodmes = this.datos.prodmes;
			this.campos.porutilidad = this.datos.porutilidad;
			this.campos.porcomision = this.datos.porcomision;
			this.campos.descuento = this.datos.descuento;
			this.campos.costoflete = this.datos.costoflete;
			this.campos.costokg = this.datos.costokg;

			this.campos.mod = this.datos.mod;
			this.campos.moi = this.datos.moi;
			this.campos.gastosfab = this.datos.gastosfab;

			this.campos.gastosventa = this.datos.gastosventa;
			this.campos.gastosfinancieros = this.datos.gastosfinancieros;
			this.campos.gastosadmon = this.datos.gastosadmon;
			
			setTimeout(function() {app.calcularValores();}, 200);			
			
		},
		calcularValores: function(){
//console.log("calculamos...");
			// C.U. (con IVA)
			this.campos.pesocu = formatNumber((parseFloat(this.campos.costokg) * (1 - (parseFloat(this.campos.descuento) / 100) ) + parseFloat(this.campos.costoflete)) * 1.16);
			
			// IMPORTE
			this.campos.pesoimporte = formatNumber(this.campos.pesokgmt * this.campos.pesocu);
			
//			this.campos.comisiones = (((parseFloat(this.campos.pesoimporte)/0.9)/(1-(parseFloat(this.campos.porutilidad / 100))))/parseFloat(this.campos.pesokgmt))*parseFloat(this.campos.prodmes)*(parseFloat(this.campos.porcomision) / 100);
//			var valorcillo = 0;
//			valorcillo = parseFloat((parseFloat(this.campos.pesoimporte)/0.9));
//			console.log ("pesoimporte ("+parseFloat(this.campos.pesoimporte)+") / .9 = " + valorcillo);
//			
//			valorcillo = valorcillo / (1-(parseFloat(this.campos.porutilidad) / 100));
//			console.log ("valor / 1 - utilidad ("+(parseFloat(this.campos.porutilidad) / 100)+") = " + valorcillo);
//			
//			valorcillo = valorcillo / parseFloat(this.campos.pesokgmt);
//			console.log ("valor / pesokm ("+parseFloat(this.campos.pesokgmt)+") " + valorcillo);
//			
//			valorcillo = valorcillo * parseFloat(this.campos.prodmes);
//			console.log ("valor * prodmes ("+parseFloat(this.campos.prodmes)+") " + valorcillo);
//			
//			valorcillo = valorcillo * (parseFloat(this.campos.porcomision) / 100);
//			console.log ("valor * por comision ("+(parseFloat(this.campos.porcomision) / 100)+") " + valorcillo);
			
//			console.log((parseFloat(this.campos.pesoimporte)/0.9));
//			console.log((1-(parseFloat(this.campos.porutilidad / 100))));
//			console.log(parseFloat(this.campos.pesokgmt));
//			console.log(parseFloat(this.campos.prodmes));
//			console.log((parseFloat(this.campos.porcomision) / 100));
			
//			var impo9 =  (parseFloat(this.campos.pesoimporte) / 0.9);
//			var porcutil = ( 1 - (parseFloat(this.campos.porutilidad).toPrecision(4) / 100) );
//			var pesotabla = parseFloat(this.campos.pesokgmt);
//			var prodmes = parseFloat(this.campos.prodmes);
//			var porcomi = ((parseFloat(this.campos.porcomision) / 100));
//			
////			var impo9 = 166.93333333333334;
////			var porcutil = 0.9;
////			var pesotabla = 5.42;
////			var prodmes = 165000 ;
////			var porcomi =  0.02;
//			
//			console.log(" ---  ");
//			console.log("impo9 = " + impo9);
//			console.log("porcutil = " + porcutil);
//			console.log("pesotabla = " + pesotabla);
//			console.log("prodmes = " + prodmes);
//			console.log("porcomi = " + porcomi);
//			console.log("eee: " + parseFloat(impo9/porcutil/pesotabla*prodmes*porcomi));
//			console.log("test: " + (34.22167555008884*165000));
			
			//Comisiones
			this.campos.comisiones = parseFloat(
                    (
                     (
                      ( parseFloat(this.campos.pesoimporte).toFixed(2) / 0.9) 
                      / 
                      ( 1 - (parseFloat(this.campos.porutilidad).toFixed(2) / 100) ) 
                     ) 
                     / 
                       parseFloat(this.campos.pesokgmt).toFixed(2) 
                    )
                    *
                     parseFloat(this.campos.prodmes).toFixed(2) 
                    *
                     (parseFloat(this.campos.porcomision).toFixed(2) / 100) 
                   ).toFixed(2);
			
			this.campos.comisionesR2 = parseFloat(
                    (
                     (
                      ( parseFloat(this.campos.pesoimporte).toFixed(2) / 0.9) 
                      / 
                      ( 1 - (parseFloat(this.campos.porutilidad - 1).toFixed(2) / 100) ) 
                     ) 
                     / 
                       parseFloat(this.campos.pesokgmt).toFixed(2) 
                    )
                    *
                     parseFloat(this.campos.prodmes).toFixed(2) 
                    *
                     (parseFloat(this.campos.porcomision).toFixed(2) / 100) 
                   ).toFixed(2);
			
			this.campos.comisionesR3 = parseFloat(
                    (
                     (
                      ( parseFloat(this.campos.pesoimporte).toFixed(2) / 0.9) 
                      / 
                      ( 1 - (parseFloat(this.campos.porutilidad - 2).toFixed(2) / 100) ) 
                     ) 
                     / 
                       parseFloat(this.campos.pesokgmt).toFixed(2) 
                    )
                    *
                     parseFloat(this.campos.prodmes).toFixed(2) 
                    *
                     (parseFloat(this.campos.porcomision).toFixed(2) / 100) 
                   ).toFixed(2);
			
			
//			console.log("valor calculado: " + ((((150.25/0.9)/(1-0.1))/5.42)*165000*0.02));
			
			//Parte de MOD
			this.campos.modiva = formatNumber( parseFloat(this.campos.mod) / parseFloat(this.campos.prodmes) * (1  + (parseFloat(this.campos.iva) / 100) )) ;
			this.campos.moiiva = formatNumber( parseFloat(this.campos.moi) / parseFloat(this.campos.prodmes) * (1  + (parseFloat(this.campos.iva) / 100) )) ;
			this.campos.gastosfabiva = formatNumber( parseFloat(this.campos.gastosfab) / parseFloat(this.campos.prodmes) * (1  + (parseFloat(this.campos.iva) / 100) )) ;
			this.campos.comisionesiva = formatNumber( parseFloat(this.campos.comisiones) / parseFloat(this.campos.prodmes) * (1  + (parseFloat(this.campos.iva) / 100) )) ;
			this.campos.gastosventaiva = formatNumber( parseFloat(this.campos.gastosventa) / parseFloat(this.campos.prodmes) * (1  + (parseFloat(this.campos.iva) / 100) )) ;
			this.campos.gastosfinancierosiva = formatNumber( parseFloat(this.campos.gastosfinancieros) / parseFloat(this.campos.prodmes) * (1  + (parseFloat(this.campos.iva) / 100) )) ;
			this.campos.gastosadmoniva = formatNumber( parseFloat(this.campos.gastosadmon) / parseFloat(this.campos.prodmes) * (1  + (parseFloat(this.campos.iva) / 100) )) ;
			
			this.campos.totalessummes = formatNumber( parseFloat(this.campos.mod) +
									parseFloat(this.campos.moi) +
									parseFloat(this.campos.gastosfab) +
									parseFloat(this.campos.comisiones) +
									parseFloat(this.campos.gastosventa) +
									parseFloat(this.campos.gastosfinancieros) +
									parseFloat(this.campos.gastosadmon));
			
			this.campos.totalessumkg = formatNumber( parseFloat(this.campos.modiva) +
									parseFloat(this.campos.moiiva) +
									parseFloat(this.campos.gastosfabiva) +
									parseFloat(this.campos.comisionesiva) +
									parseFloat(this.campos.gastosventaiva) +
									parseFloat(this.campos.gastosfinancierosiva) +
									parseFloat(this.campos.gastosadmoniva));
			
			
			this.campos.totalespeso = formatNumber(parseFloat(this.campos.pesokgmt) * parseFloat(this.campos.totalessumkg));
			
			
			this.campos.totalcostofab = formatNumber(parseFloat(this.campos.pesoimporte) + parseFloat(this.campos.totalespeso));
			
			this.campos.totalesfab = formatNumber(parseFloat(this.campos.totalespeso) / parseFloat(this.campos.totalcostofab) * 100);
			
			this.campos.totalpreciovta = formatNumber(parseFloat(this.campos.totalcostofab) / (1 - (parseFloat(this.campos.porutilidad) / 100)) );
			this.campos.totalpreciovtaR2 = formatNumber(parseFloat(this.campos.totalcostofab) / (1 - (parseFloat(this.campos.porutilidad - 1) / 100)) );
			this.campos.totalpreciovtaR3 = formatNumber(parseFloat(this.campos.totalcostofab) / (1 - (parseFloat(this.campos.porutilidad - 2) / 100)) );
			
			//Parte de Participación
			this.campos.pesoparti = formatNumber((parseFloat(this.campos.pesoimporte) / parseFloat(this.campos.totalcostofab) * 100));
			
			//Participaciones MOD
			this.campos.modparti = formatNumber(parseFloat(this.campos.modiva) / parseFloat(this.campos.totalessumkg) * parseFloat(this.campos.totalesfab));
			this.campos.moiparti = formatNumber(parseFloat(this.campos.moiiva) / parseFloat(this.campos.totalessumkg) * parseFloat(this.campos.totalesfab));
			this.campos.gastosfabparti = formatNumber(parseFloat(this.campos.gastosfabiva) / parseFloat(this.campos.totalessumkg) * parseFloat(this.campos.totalesfab));
			this.campos.comisionesparti = formatNumber(parseFloat(this.campos.comisionesiva) / parseFloat(this.campos.totalessumkg) * parseFloat(this.campos.totalesfab));
			this.campos.gastosventaparti = formatNumber(parseFloat(this.campos.gastosventaiva) / parseFloat(this.campos.totalessumkg) * parseFloat(this.campos.totalesfab));
			this.campos.gastosfinancierosparti = formatNumber(parseFloat(this.campos.gastosfinancierosiva) / parseFloat(this.campos.totalessumkg) * parseFloat(this.campos.totalesfab));
			this.campos.gastosadmonparti = formatNumber(parseFloat(this.campos.gastosadmoniva) / parseFloat(this.campos.totalessumkg) * parseFloat(this.campos.totalesfab));
			
//			modparti: '',
//			moiparti: '',
//			gastosfabparti: '',
//			comisionesparti: '',
//			gastosventaparti: '',
//			gastosfinancierosparti: '',
//			gastosadmonparti: '',
			
		},
		guardarTodo: function(){
			if (isNaN(this.campos.totalpreciovta) || 
				isNaN(this.campos.totalpreciovtaR2) ||
				isNaN(this.campos.totalpreciovtaR3))
			{
				saError("No se han calculado correctamente los Precios para guardar la Información. Favor de verificar.");
			}
			else
			{
				xajax_guardarDatosRollo(this.seleccionado.idRolloSeleccionado, this.campos, this.productos);
			}
		},
		clickHeredar: function(index){
			console.log("click en " + index + " valor: " + this.productos[index].heredarPrecio);
			this.productos[index].heredarPrecio = !this.productos[index].heredarPrecio;
			console.log("valor ahora: " + this.productos[index].heredarPrecio);
			
			if (this.productos[index].heredarPrecio)
			{//console.log("ponemos precios calculados");
				this.productos[index].heredandoPrecio = '1';
				
				if (this.productos[index].unidad == 4)
				{
					this.productos[index].precio1 = formatNumber( parseFloat (this.campos.totalpreciovta * parseFloat(this.productos[index].ml) ));	
				}
				else
				{
					this.productos[index].precio1 = this.campos.totalpreciovta;
				}
				
				
				if (this.productos[index].isRango)
				{
					if (this.productos[index].unidad == 4)
					{
						this.productos[index].precio2 = formatNumber( parseFloat ( this.campos.totalpreciovtaR2 * parseFloat(this.productos[index].ml) ));
						this.productos[index].precio3 = formatNumber( parseFloat (this.campos.totalpreciovtaR3 * parseFloat(this.productos[index].ml) ));	
					}
					else
					{
						this.productos[index].precio2 = this.campos.totalpreciovtaR2;
						this.productos[index].precio3 = this.campos.totalpreciovtaR3;
					}
						
				}
				else
				{
					this.productos[index].precio2 = '0';
					this.productos[index].precio3 = '0';
				}
				
			}
			else
			{//console.log("ponemos precios originales");
				this.productos[index].heredandoPrecio = '0';
				this.productos[index].precio1 = this.productos[index].originalprecio1;
				this.productos[index].precio2 = this.productos[index].originalprecio2;
				this.productos[index].precio3 = this.productos[index].originalprecio3;
			}
		},
		setPreciosProductosAll: function(){						
			var i = 0;
			console.log("entrando a setPreciosProductosAll");
			for (i = 0; i < this.productos.length ; i++)
			{
				if (this.productos[i].heredarPrecio)
				{//console.log("heredar : " + i);
					
					this.productos[i].heredandoPrecio = '1';
					
					if (this.productos[i].unidad == 4)
					{
						this.productos[i].precio1 = formatNumber( parseFloat( this.campos.totalpreciovta * parseFloat(this.productos[i].ml) ));	
					}
					else
					{
						this.productos[i].precio1 = this.campos.totalpreciovta;
					}
					
					
					if (this.productos[i].isRango)
					{
						if (this.productos[i].unidad == 4)
						{
							this.productos[i].precio2 = formatNumber( parseFloat( this.campos.totalpreciovtaR2 * parseFloat(this.productos[i].ml) ));
							this.productos[i].precio3 = formatNumber( parseFloat( this.campos.totalpreciovtaR3 * parseFloat(this.productos[i].ml) ));	
						}
						else
						{
							this.productos[i].precio2 = this.campos.totalpreciovtaR2;
							this.productos[i].precio3 = this.campos.totalpreciovtaR3;
						}
						
						
							
					}
					else
					{
						this.productos[i].precio2 = '0';
						this.productos[i].precio3 = '0';
					}
					
				}
				else
				{//console.log("originales : " + i);
					this.productos[i].heredandoPrecio = '0';
					this.productos[i].precio1 = this.productos[i].originalprecio1;
					this.productos[i].precio2 = this.productos[i].originalprecio2;
					this.productos[i].precio3 = this.productos[i].originalprecio3;
				}
			}
		},
		seleccionarNuevoRollo: function(){
			this.seleccionado.idRolloSeleccionado = 0;
			this.seleccionarRollo = true;
		}
	},
	
});