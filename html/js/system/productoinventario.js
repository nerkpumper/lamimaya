
var app = new Vue({
	el: '#app',
	data: {		
		idProducto: 0,
		idSucursal: 0,
		
		mostrarDatos: false,
		
		codigo: '',
		tipoProducto: '',
		unidad: '',
		aplicacion: '',
		material: '',
		idrollo: 0,
		rollo: '',
		calibre: '',
		descripcion: '',
		existencia: '',
		movimiento: '0',
		cantidad: '',
		observaciones: '',
		fullDescripcion: '',
		
		lblSumaResta: '',
		
		reportMovimiento: 'ES',
		fechaInicio: '',
		fechaFin: '',
		
		errCantidad: '',
		errObservaciones: '',
		errMovimiento: '',
		errFechaInicio: '',
		errFechaFin: ''
	},
	created: function () {
		if (typeof param1 !== 'undefined') {
			this.idProducto = param1;				  
			xajax_cargarProducto(this.idProducto, this.idSucursal);
//			setTimeout(function(){app.cargarUltimosMovimientos();}, 1000);
		}
		else
		{
			window.location = URL_BASE + "producto";
		}
	},
	watch: {
		idSucursal: function(val){
			this.mostrarDatos = false;
		},
		movimiento: function(val){
			if (val == "ENTRADA")
			{
				this.lblSumaResta = " a Sumar";
			}
			else if(val == "SALIDA")
			{
				this.lblSumaResta = " a Restar";
			}
			else
			{
				this.lblSumaResta = "";
			}
		}
	},
	methods:{
		exportarReporte: function(){ 
			var desde = $("#dtFechaInicio").val();
			var hasta = $("#dtFechaFin").val();
			var seguir = true;
			
			sendToExcel("tblReporte", "Reporte de Movimientos", "Movimientos de Inventario de Producto de: " + desde + " a: " + hasta, this.fullDescripcion);
			
//			
//			this.limpiaErrores();
//			
//			var strFechaInicial = desde.substring(6, 10) + '' + desde.substring(3, 5) + '' + desde.substring(0, 2);
//			var strFechaFinal = hasta.substring(6, 10) + '' + hasta.substring(3, 5) + '' + hasta.substring(0, 2);
//					
////			alert(  strFechaInicial + ' ' + strFechaFinal);
//						
////			if (hasta < desde)
//			if (parseInt(strFechaFinal) < parseInt(strFechaInicial))
//			{
//				this.errFechaFin = "Fecha Final debe ser mayor a Inicial"; 
//				seguir = false;
//			}
//			
//			if (seguir)
//			{
//				var fcampos = "Fecha Movimiento, Empleado, Documento, Referencia, Movimiento, Existencia Anterior, Cantidad, Existencia Actual, Observaciones";
//				var fselect = "fecha_movimiento, concat(nombre, ' ', apellidoPaterno, ' ' , apellidoMaterno) as usrMovimiento, documento, referencia, movimiento, existenciaProducto, cantidad, IF(movimiento = 'ENTRADA', existenciaProducto [PLUS] cantidad, existenciaProducto - cantidad) as saldo, observaciones";
//				var ftabla = "invzmov";
//				var finner = "INNER JOIN usuario as u ON u.idUsuario = id_usuario_movimiento";
//				var fwhere = "";
//				
//				
//				
//				if (this.reportMovimiento == "ES")
//				{
//					fwhere = "movimiento IN ('ENTRADA','SALIDA') ";
//				}
//				else if (this.reportMovimiento == "E")
//				{
//					fwhere = "movimiento IN ('ENTRADA') ";
//				}
//				else
//				{
//					fwhere = "movimiento IN ('SALIDA') ";
//				}
//				
//				fwhere = "idProducto = " + this.idProducto + " AND " + fwhere;
//				fwhere = fwhere + " AND date_format(fecha_movimiento, '%d/%m/%Y') BETWEEN '"+desde+"' AND '"+hasta+"' ";
//				
//					
//				var fgroup = "";
//				var forder = "idInvzmov DESC";
//				var titulo = "Inventario Producto: " + this.fullDescripcion;
//				var subtitulo = "Del " + desde + " al " + hasta;
//				
////				createCookie("vari", "el nerk pumper changed this", 1);
//				prepareCookieQuery (titulo, subtitulo, fcampos, fselect, ftabla, finner, fwhere, fgroup, forder);				
//				window.open(URL_BASE + "reporteador");
////				window.open("reporteador");
//				
////				xajax_obtenerReporte(this.idRollo, this.reportMovimiento, desde, hasta);
//			}
			
			
		},
		generarMovimiento: function(){
			
			var seguir = true;
			
			this.limpiaErrores();
			
			if (this.movimiento == "0")
			{
				this.errMovimiento = "Debe seleccionar movimiento";
				seguir = false;
			}
			
			if (this.cantidad == "")
			{
				this.errCantidad = "No ha especificado cantidad";
				seguir = false;
			}
			
			if (this.observaciones == "")
			{
				this.errObservaciones = "Debe indicar una observación";
				seguir = false;
			}	
			
			if (seguir)
			{
				xajax_guardarMovimiento(this.idProducto, this.idSucursal, this.movimiento, this.cantidad, this.observaciones);
			}
				
		},
		obtenerReporte: function(){
			var desde = $("#dtFechaInicio").val();
			var hasta = $("#dtFechaFin").val();
			var seguir = true;
			
			this.limpiaErrores();
			
			var strFechaInicial = desde.substring(6, 10) + '' + desde.substring(3, 5) + '' + desde.substring(0, 2);
			var strFechaFinal = hasta.substring(6, 10) + '' + hasta.substring(3, 5) + '' + hasta.substring(0, 2);
					
//			alert(  strFechaInicial + ' ' + strFechaFinal);
						
//			if (hasta < desde)
			if (parseInt(strFechaFinal) < parseInt(strFechaInicial))
			{
				this.errFechaFin = "Fecha Final debe ser mayor a Inicial"; 
				seguir = false;
			}
//			
//			if (hasta < desde)
//			{
//				alert("hasta < desde");
//			}
//			
//			if (hasta == desde)
//			{
//				alert("hasta == desde");
//			}
			
			if (seguir)
			{
				xajax_obtenerReporte(this.idProducto,this.idSucursal, this.reportMovimiento, desde, hasta);
			}
			
			
		},
		cargarUltimosMovimientos: function(){
			xajax_cargarUltimosMovimientos(this.idProducto, this.idSucursal);
		},
		obtenerInformacion: function(){
			if (this.idSucursal > 0)
			{
				this.mostrarDatos = true;
				this.reload();
			}
			else
			{
				saInfo ("Debe seleccionar una sucursal");
			}
			
		},
		reload: function(){
			xajax_cargarProducto(this.idProducto, this.idSucursal);
			xajax_cargarUltimosMovimientos(this.idProducto, this.idSucursal);
		},
		limpiaDatos: function(){
			//this.idProducto = 0;
			
			this.codigo = '';
			this.tipoProducto = '';
			this.unidad = '';
			this.aplicacion = '';
			this.material = '';
			this.rollo =  '';
			this.calibre = '';
			this.descripcion = '';
			this.cantidad = '';
			this.observaciones = '';
			this.movimiento = '0';
			this.fullDescripcion = '';
			this.reportMovimiento = 'ES';
			
		},		
		limpiaErrores: function(){
			this.errCantidad = '';
			this.errObservaciones = '';
			this.errMovimiento = '';
			this.errFechaInicio = '';
			this.errFechaFin = '';
		},
		fnRegresarAListado: function(){
			window.location = URL_BASE + "producto";
		}
	}
  
});


$(document).ready(function(){
	$('#dtFechaInicio').datepicker({
	    todayBtn: "linked",
	    keyboardNavigation: false,
	    forceParse: false,
	    calendarWeeks: true,
	    autoclose: true,
	    format: 'dd/mm/yyyy'
	});
	
	$('#dtFechaFin').datepicker({
	    todayBtn: "linked",
	    keyboardNavigation: false,
	    forceParse: false,
	    calendarWeeks: true,
	    autoclose: true,
	    format: 'dd/mm/yyyy'
	});
});

