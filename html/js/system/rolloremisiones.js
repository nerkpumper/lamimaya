
var app = new Vue({
	el: '#app',
	data: {
		//CHK
		chkTerminado: true,
		
		//para detalle
		mostrarRollo: true,
		mostrarDetalle: true,
		
		//Remision Rollo
		idRemisionRollo: 0,
		noRollo: '',
		existenciaNoRollo: 0,
		
		//para datos de rollo
		idRollo: 0,
		codigo: '',
		material: '',
		proveedor: '',
		calibre: '',
		pies: '',
		existencia: 0,
		rolloFullDescripcion: '',
		filtroNoRollo: '',

		reportMovimiento: 'ES',
		fechaInicio: '',
		fechaFin: '',
		reportMovimientoRemisionRollo: 'ES',
		fechaInicioRemisionRollo: '',
		fechaFinRemisionRollo: '',
		
		errFechaInicio: '',
		errFechaFin: '',
		errFechaInicioRemisionRollo: '',
		errFechaFinRemisionRollo: '',
		
		remisiones: []
		
	},
	mounted: function () {
		if (typeof param1 !== 'undefined') {
			this.idRollo = param1;
			
			xajax_cargarRollo(this.idRollo);		
		}
		
		
	},
	created: function(){
//		this.remisiones.push({idRemision: 1, remision: 123, noRollo: 'ABC001', kilos: 100, disponible: 20});
//		this.remisiones.push({idRemision: 2, remision: 123, noRollo: 'ABC002', kilos: 100, disponible: 20});
//		this.remisiones.push({idRemision: 3, remision: 123, noRollo: 'ABC003', kilos: 100, disponible: 20});
//		this.remisiones.push({idRemision: 4, remision: 124, noRollo: 'ABC004', kilos: 100, disponible: 20});
//		this.remisiones.push({idRemision: 5, remision: 124, noRollo: 'ABC005', kilos: 100, disponible: 20});
//		alert("created");
	},
	watch: {
		filtroNoRollo: function(val){
			this.filtroNoRollo = val.toUpperCase();
		}
	},
	computed: {
		noRollosFiltrados:function(){
	    	
			var self=this;
	    	 return this.remisiones.filter(function(cust){
	    		 
	    		 //return cust.nombre == self.filtroNombreCliente;
	    		 var str = cust.noRollo;
	    		 var find = self.filtroNoRollo;
	    		 
	    		
	    		 
	    		 return str.includes(find) ;
	    		 
	    	 });
	    },
	},
	methods: {
		cargarSoloRollo: function(idRollo){
			xajax_cargarSoloRollo(idRollo);
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
			
			if (seguir)
			{
				xajax_obtenerReporte(this.idRollo, this.reportMovimiento, desde, hasta);
			}
			
			
		},
		exportarReporte: function(){ 
			var desde = $("#dtFechaInicio").val();
			var hasta = $("#dtFechaFin").val();
			var seguir = true;
			
			this.limpiaErrores();
			var strFechaInicial = desde.substring(6, 10) + '' + desde.substring(3, 5) + '' + desde.substring(0, 2);
			var strFechaFinal = hasta.substring(6, 10) + '' + hasta.substring(3, 5) + '' + hasta.substring(0, 2);
			
			var strFI = desde.substring(6, 10) + '-' + desde.substring(3, 5) + '-' + desde.substring(0, 2);
			var strFF = hasta.substring(6, 10) + '-' + hasta.substring(3, 5) + '-' + hasta.substring(0, 2);
					
//			alert(  strFechaInicial + ' ' + strFechaFinal);
						
//			if (hasta < desde)
			if (parseInt(strFechaFinal) < parseInt(strFechaInicial))
			{
				this.errFechaFin = "Fecha Final debe ser mayor a Inicial"; 
				seguir = false;
			}
			
			if (seguir)
			{
//				var fcampos = "Fecha Movimiento, Empleado, Documento, Referencia, Movimiento, Existencia Anterior, Cantidad, Existencia Actual, Observaciones";
//				var fselect = "fecha_movimiento, concat(nombre, ' ', apellidoPaterno, ' ' , apellidoMaterno) as usrMovimiento, documento, referencia, movimiento, existenciaRollo, cantidad, IF(movimiento = 'ENTRADA', existenciaRollo [PLUS] cantidad, existenciaRollo - cantidad) as saldo, observaciones";
//				var ftabla = "invzmovrollo";
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
//				fwhere = "idRollo = " + this.idRollo + " AND " + fwhere;
//				fwhere = fwhere + " AND date_format(fecha_movimiento, '%d/%m/%Y') BETWEEN '"+desde+"' AND '"+hasta+"' ";
//				
//					
//				var fgroup = "";
//				var forder = "idInvzmovRollo DESC";
//				var titulo = "Inventario Rollo: " + this.codigo + " Rollo " + this.material + " Calibre " + this.calibre + " " + this.pies + " Pies " + this.proveedor;
//				var subtitulo = "Del " + desde + " al " + hasta;
//				
////				createCookie("vari", "el nerk pumper changed this", 1);
//				prepareCookieQuery (titulo, subtitulo, fcampos, fselect, ftabla, finner, fwhere, fgroup, forder);				
				window.open(URL_BASE + "reporteador/mod/rolloremisiones/fn/movimientorollo/idrollo/"+this.idRollo+"/mov/"+this.reportMovimiento+"/desde/"+strFI+"/hasta/" + strFF+"/letitle/"+"Inventario Rollo: " + this.codigo + " Rollo " + this.material + " Calibre " + this.calibre + " " + this.pies + " Pies " + this.proveedor+"/lesubtitle/"+"Del " + strFI + " al " + strFF);
//				window.open("reporteador");
				
//				xajax_obtenerReporte(this.idRollo, this.reportMovimiento, desde, hasta);
			}
			
			
		},
		cargarRemisiones: function(){			
			xajax_cargarRemisiones(this.idRollo);
		},
		inventarioRemisionRollo: function(idRemisionRollo, index){
//			idRemisionRollo
//			alert('movimientos inventario: ' + idRemisionRollo);
			this.mostrarDetalle = true;
			this.mostrarRollo = false;
			
			this.idRemisionRollo = idRemisionRollo;
			
			xajax_cargarRemisionRollo(idRemisionRollo);
//			alert('movimientos inventario: ');
		},
		borrarRemisionRollo: function(idRemisionRollo, index){
//			alert('borrar remision rollo: ' + idRemisionRollo);
			swal({
		        title: "Confirme",
		        text: "Se dará salida al total de kilos de No. Rollo seleccionado",
		        type: "warning",
		        showCancelButton: true,
		        confirmButtonColor: "#DD6B55",
		        confirmButtonText: "Si",
		        cancelButtonText: "No",
		        closeOnConfirm: false
		    }, function () {
//		    	xajax_darSalidaARollo(app.proIdRollo, app.remisionIdRemisionRollo, app.remisionCantidadSacar, app.idPedidoDetalle, app.idPedido);
		    	//alert('borrar idremisionrollo: ' +idRemisionRollo + ' con index: ' + index);
		    	xajax_borrarRemisionRollo(app.idRollo, idRemisionRollo, index);
		    });	
			
		},
		limpiaErrores: function(){
			this.errFechaInicio = '';
			this.errFechaFin = '';		
			this.errFechaInicioRemisionRollo = '';
			this.errFechaFinRemisionRollo = '';
		},
		noMostrarDetalle: function(){
			this.mostrarDetalle = false;
			this.mostrarRollo = true;
		},
		obtenerReporteRemisionRollo: function(){ 
			var desde = $("#dtFechaInicioRemisionRollo").val();
			var hasta = $("#dtFechaFinRemisionRollo").val();
			var seguir = true;
			
			this.limpiaErrores();

			var strFechaInicial = desde.substring(6, 10) + '' + desde.substring(3, 5) + '' + desde.substring(0, 2);
			var strFechaFinal = hasta.substring(6, 10) + '' + hasta.substring(3, 5) + '' + hasta.substring(0, 2);
			
			
						
//			alert(  strFechaInicial + ' ' + strFechaFinal);
						
//			if (hasta < desde)
			if (parseInt(strFechaFinal) < parseInt(strFechaInicial))
			{				
				this.errFechaFinRemisionRollo = "Fecha Final debe ser mayor a Inicial"; 
				seguir = false;
			}
			
				
			if (seguir)
			{
				xajax_obtenerReporteRemisionRollo(this.idRemisionRollo, this.reportMovimientoRemisionRollo, desde, hasta);
			}
			
			
		},
		exportarReporteRemisionRollo: function(){ 
			var desde = $("#dtFechaInicioRemisionRollo").val();
			var hasta = $("#dtFechaFinRemisionRollo").val();
			var seguir = true;
			
			this.limpiaErrores();
			
			var strFechaInicial = desde.substring(6, 10) + '' + desde.substring(3, 5) + '' + desde.substring(0, 2);
			var strFechaFinal = hasta.substring(6, 10) + '' + hasta.substring(3, 5) + '' + hasta.substring(0, 2);
				
			var strFI = desde.substring(6, 10) + '-' + desde.substring(3, 5) + '-' + desde.substring(0, 2);
			var strFF = hasta.substring(6, 10) + '-' + hasta.substring(3, 5) + '-' + hasta.substring(0, 2);
			
//			alert(  strFechaInicial + ' ' + strFechaFinal);
						
//			if (hasta < desde)
			if (parseInt(strFechaFinal) < parseInt(strFechaInicial))
			{
				this.errFechaFinRemisionRollo = "Fecha Final debe ser mayor a Inicial"; 
				seguir = false;
			}
			
			if (seguir)
			{
//				var fcampos = "Fecha Movimiento, Empleado, Documento, Referencia, Movimiento, Existencia Anterior, Cantidad, Existencia Actual, Observaciones";
//				var fselect = "fecha_movimiento, concat(nombre, ' ', apellidoPaterno, ' ' , apellidoMaterno) as usrMovimiento, documento, referencia, movimiento, existenciaNoRollo, cantidad, IF(movimiento = 'ENTRADA', existenciaNoRollo [PLUS] cantidad, existenciaNoRollo - cantidad) as saldo, observaciones ";
//				var ftabla = "invzmovrollo";
//				var finner = "INNER JOIN usuario as u ON u.idUsuario = id_usuario_movimiento";
//				var fwhere = "";
//				
//				
//				
//				if (this.reportMovimientoRemisionRollo == "ES")
//				{
//					fwhere = "movimiento IN ('ENTRADA','SALIDA') ";
//				}
//				else if (this.reportMovimientoRemisionRollo == "E")
//				{
//					fwhere = "movimiento IN ('ENTRADA') ";
//				}
//				else
//				{
//					fwhere = "movimiento IN ('SALIDA') ";
//				}
//				
//				fwhere = "idRemisionRollo = " + this.idRemisionRollo + " AND " + fwhere;
//				fwhere = fwhere + " AND date_format(fecha_movimiento, '%d/%m/%Y') BETWEEN '"+desde+"' AND '"+hasta+"' ";
//				
//					
//				var fgroup = "";
//				var forder = "idInvzmovRollo DESC";
//				var titulo = "Inventario Rollo: " + this.codigo + " # Rollo " + this.noRollo;
//				var subtitulo = "Del " + desde + " al " + hasta;
//				
////				createCookie("vari", "el nerk pumper changed this", 1);
//				
////				createCookie("isDebug", "1", 0.3);
//				
//				prepareCookieQuery (titulo, subtitulo, fcampos, fselect, ftabla, finner, fwhere, fgroup, forder);				
//				window.open(URL_BASE + "reporteador");
				window.open(URL_BASE + "reporteador/mod/rolloremisiones/fn/movimientoremisionrollo/idremisionrollo/"+this.idRemisionRollo+"/mov/"+this.reportMovimiento+"/desde/"+strFI+"/hasta/" + strFF + "/letitle/"+"Inventario Rollo: " + this.codigo + " No. Rollo " + this.noRollo+"/lesubtitle/"+"Del " + strFI + " al " + strFF);
//				window.open("reporteador");
				
//				xajax_obtenerReporte(this.idRollo, this.reportMovimiento, desde, hasta);
			}
			
			
		},
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
	
	
	
	$('#dtFechaInicioRemisionRollo').datepicker({
	    todayBtn: "linked",
	    keyboardNavigation: false,
	    forceParse: false,
	    calendarWeeks: true,
	    autoclose: true,
	    format: 'dd/mm/yyyy'
	});
	
	$('#dtFechaFinRemisionRollo').datepicker({
	    todayBtn: "linked",
	    keyboardNavigation: false,
	    forceParse: false,
	    calendarWeeks: true,
	    autoclose: true,
	    format: 'dd/mm/yyyy'
	});
	
//	alert("jquery");
	setTimeout(function(){app.mostrarDetalle = false;}, 2);
	
	
});

