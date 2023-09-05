

var app = new Vue({
	el: '#app',
	data: {		
		idUsuario: 0,
		username: '',
		email: '',
		nombre: '',       
		apellidoPaterno: '',
		apellidoMaterno: '',
		estatus: '0',
		idRol: '0',
		tipoComision: 'BAJO',
		cobraComision: '',
       
		password: '',
		confirmar: '',
              	
		errUsername: '',
		errEmail: '',
		errNombre: '',       
		errApellidoPaterno: '',
		errApellidoMaterno: '',
		errEstatus: '',
		errIdRol: '',
		errPassword: '',
		errConfirmar: '',
		errTipoComision: '',
		errCobraComision: '',
       
		accionModulo: 'Nuevo'
	},
	mounted: function () {
		if (typeof param1 !== 'undefined') {
			this.idUsuario = param1;
			this.accionModulo = 'Actualizar';		  
			xajax_cargarUsuario(this.idUsuario);
		}
	},
	watch: {
		password: function(val){
			if (this.password.trim() != this.confirmar.trim())
			{
				this.errConfirmar = "Password no coinciden.";			  
			}  
			else
			{
				this.errConfirmar = "";
			}
		},
		confirmar: function(val){
			if (this.password.trim() != this.confirmar.trim())
			{
				this.errConfirmar = "Password no coinciden.";			  
			}  
			else
			{
				this.errConfirmar = "";
			}
		}
	  
	},
	methods:{
		guardarUsuario: function(){
			var seguir = true;
		  
			this.limpiaErrores();
		  
			if (this.username.trim() == "")
			{
				this.errUsername = "Debe especificar un nombre de Usuario.";
				seguir = false;
			}
		  
			if (this.email.trim() == "")
			{
				this.errEmail = "Debe especificar un EMail.";
				seguir = false;
			}
			else
			{
				if (!isEmail (this.email.trim()))
				{
					this.errEmail = "El dato EMail no tiene un formato correcto.";
					seguir = false;
				}
			}
			
			if (this.nombre.trim() == "")
			{
				this.errNombre = "Debe especificar un Nombre.";
				seguir = false;
			}
			
			if (this.apellidoPaterno.trim() == "")
			{
				this.errApellidoPaterno = "Debe especificar un Apellido Paterno.";
				seguir = false;
			}
			
			if (this.estatus.trim() == "0")
			{
				this.errEstatus = "Debe especificar un Estatus.";
				seguir = false;
			}
			
			if (this.idRol.trim() == "0")
			{
				this.errIdRol = "Debe especificar un Estatus.";
				seguir = false;
			}
			
			if (this.tipoComision == "0")
			{
				this.errTipoComision = "Debe especificar un Tipo Comisión";
				seguir = false;
			}

			if (this.cobraComision == "0")
			{
			this.errCobraComision = "Debe especificar si el usuario Cobra Comisión";
				seguir = false;
			}
			
			if (this.idUsuario == 0)
			{
				if (this.password.trim() == "")
				{
					this.errPassword = "Debe especificar un Password.";
					seguir = false;
				}  
				
				if (this.password.trim() != this.confirmar.trim())
				{
					seguir = false;
				} 
			}
			
			if (seguir)
			{				
				xajax_guardarUsuario(this.idUsuario, this.username.trim(), this.email.trim(), this.nombre.trim(), this.apellidoPaterno.trim(), this.apellidoMaterno.trim(),this.estatus, this.idRol, this.password.trim(), this.tipoComision, this.cobraComision);
			}
			
			
			
			
			//xajax_guardar(this.id, this.nombre, this.apellidoPaterno, this.apellidoMaterno);
		},
		limpiaDatos: function(){
			this.idUsuario = 0;
			this.username = '';
			this.nombre = '';
			this.apellidoPaterno = ''; 
			this.apellidoMaterno = '';
			this.email = '';
			this.estatus = '0';       
			this.idRol = '0';
	      
			this.password = '';
			this.confirmar = '';
		},
		limpiaErrores: function(){
			this.errUsername = '';
			this.errEmail = '';
			this.errNombre = '';       
			this.errApellidoPaterno = '';
			this.errApellidoMaterno = '';
			this.errEstatus = '';
			this.errIdRol = '';
			this.errTipoComision = '';
			this.errCobraComision = '';
			
			this.errPassword = '';
		},
		fnRegresarAListado: function(){
			window.location = URL_BASE + "usuario";
		}
	}
  
});