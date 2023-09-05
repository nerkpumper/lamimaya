
var app = new Vue({
	el: '#app',
	data:{
		
		totalSinLeer: 0,
		totalLeidas: 0,
		totalBorradas: 0,
		
		
		//mostrando
		mostrandoSinLeer: false,
		mostrandoLeidas: false,
		mostrandoBorradas: false,
	
		//notificaciones
		notificaciones: []
		
	},
	mounted: function(){
		this.cargarSinLeer();
		setInterval(function(){ app.updateNotificacionesVisibles(); }, 10000);
	},
	methods: {		
		cargarSinLeer: function(){
			this.mostrandoSinLeer = true;
			this.mostrandoLeidas = false;
			this.mostrandoBorradas = false;
			
			xajax_cargarNotificaciones("SINLEER");
		},
		cargarLeidas: function(){
			this.mostrandoSinLeer = false;
			this.mostrandoLeidas = true;
			this.mostrandoBorradas = false;
			
			xajax_cargarNotificaciones("LEIDAS");
		},
		cargarBorradas: function(){
			this.mostrandoSinLeer = false;
			this.mostrandoLeidas = false;
			this.mostrandoBorradas = true;
			
			xajax_cargarNotificaciones("BORRADAS");
		},
		marcarComoLeida: function(index){

			xajax_marcarComo(index, this.notificaciones[index].idNotificacion, "LEIDA");
		},
		marcarComoNoLeida: function(index){
			
			xajax_marcarComo(index, this.notificaciones[index].idNotificacion, "SINLEER");
		},
		marcarComoBorrada: function(index){		
			swal({
		        title: "Confirme",
		        text: "La notificación se borrará",
		        type: "warning",
		        showCancelButton: true,
		        confirmButtonColor: "#DD6B55",
		        confirmButtonText: "Si",
		        cancelButtonText: "No",
		        closeOnConfirm: false
		    }, function () {
		    	swal.close();
		    	xajax_marcarComo(index, app.notificaciones[index].idNotificacion, "BORRAR");
		    });	
			
		},
		updateNotificacionesVisibles: function(){
			
			if (this.mostrandoSinLeer == true)
			{
				xajax_cargarNotificaciones("SINLEER");	
			}
			else if(this.mostrandoLeidas == true)
			{
				xajax_cargarNotificaciones("LEIDAS");	
			}
			else if(this.mostrandoBorradas == true)
			{
				xajax_cargarNotificaciones("BORRADAS");	
			}
		}
		
	}
	
	
});