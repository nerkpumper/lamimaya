
var app = new Vue({
	el: '#app',
	data: {
		
	},
	mounted: function(){
		
	},
	methods: {
		obtenerReporte: function(){
			
			createCookie("vari", "el nerk pumper changed this", 1);
			
			var fcampos = "Fecha Movimiento, Empleado, Documento, Referencia, Movimiento, Existencia Anterior, Cantidad, Existencia Actual, Observaciones";
			var fselect = "fecha_movimiento, concat(nombre, ' ', apellidoPaterno, ' ' , apellidoMaterno) as usrMovimiento, documento, referencia, movimiento, existenciaRollo, cantidad, IF(movimiento = 'ENTRADA', existenciaRollo + cantidad, existenciaRollo - cantidad) as saldo, observaciones";
			var ftabla = "invzmovrollo";
			var finner = "INNER JOIN usuario as u ON u.idUsuario = id_usuario_movimiento";
			var fwhere = "";
			
						
			fwhere = "idRollo = 3";
			
				
			var fgroup = "";
			var forder = "idInvzmovRollo DESC";
			
			createCookie("vari", "el nerk pumper changed this", 1);
			prepareCookieQuery (fcampos, fselect, ftabla, finner, fwhere, fgroup, forder);	
//			document.cookie = "miGalleta=deChocolate";
			window.open("reporteador");
			
			
//			$.post( "views/reporteador.view.php", null)
//			  .done(function( data ) {
//			    alert( "Reporte cargado, url: " + URL_BASE + data );
////				  window.location.href= URL_BASE + data;
//			  });
		}
	}
	
});