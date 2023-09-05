
	
	
	
	var login=function()
	{
		
		var email=$("#txtEmail").val().trim();
		var pass=$("#txtPass").val().trim();
		
		if(email=="")
		{			
			mostrarAviso("Ingresa tu correo electr&oacute;nico.");
			return false;
		}
		
		if(pass=="")
		{
			mostrarAviso("Captura tu contrase&ntilde;a.");
			return false;
		}
	
		mostrarEspera("Ingresando al sistema...");
		
		//pasHash=hex_sha512(pass); 
		xajax_ingresar(email,pass);
		
		
		return false;
	};
	var inicializarControles=function()
	{	
		
		$("#btnLogin").click(login);//Accion del boton Iniciar Sesion
		$("#frmLogin").submit(login);//Accion del formulario
		
		$("#txtEmail").on("keypress", function(e) 
		{	
	        if (e.keyCode == 13)
	        {
	        	$("#txtPass").focus();
	        }
		});
		
		$("#txtPass").on("keypress", function(e) 
		{	
	        if (e.keyCode == 13)
	        {
	        	return login();
	        }
		});
		
	};
	$(document).ready(function(){inicializarControles()});