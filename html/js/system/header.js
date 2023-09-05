//alert("estoy en header");

var globalHeaderNotificaciones = function()
{	
//	console.log("entrando a funcion global header");
	var form_data = new FormData();
    form_data.append('_IDUSUARIO', _IDUSUARIO);
//    console.log("ya form a idusuario " + _IDUSUARIO);
//    console.log(URL_BASE + 'notificaciones.get.php');
    
	$.ajax({
        url: URL_BASE + 'notificaciones.get.php', // point to server-side PHP script 
        dataType: 'json',  // what to expect back from the PHP script, if anything
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,                         
        type: 'post',
        success: function(resp){
//        	console.dir(resp);
        	if (!resp.error)
        	{
//        		console.log(resp.debug);
        		
        		if (resp.numeroNotificaciones == 0)
        		{
        			$("#headerNoNotificaciones").html("");
        		}
        		else
        		{
        			$("#headerNoNotificaciones").html("<span class='label label-primary'>"+resp.numeroNotificaciones+"</span>");
        		}
        		
//            	$("#headerNoNotificaciones").html(resp.numeroNotificaciones);
            	$("#headerListadoNotificaciones").html(resp.notificaciones);
            	
        	}
        	        	
        },
        error: function (request, status, error) {
            console.log("ERROR: " + request.responseText);
        	console.dir(error);
        }
        
    });
};
//console.log("entrando a header");

$(document).ready(function(){ 
//	globalHeaderNotificaciones();
//	setInterval(function(){ globalHeaderNotificaciones(); }, 30000);
});
