

var app = new Vue({
	el: '#app',
	data: {		
		idCliente: 0,
		nombre: '',
		apellidos: '',
		empresa: '',
		domicilio1: '',
		domicilio2: '',
		domicilioFiscal: '',
		numero: '',
		numeroFiscal: '',
		colonia: '',
		coloniaFiscal: '',
		ciudad: '',
		ciudadFiscal: '',
		telefonos: '',
		email: '',
		rfc: '',
		estado: 'ACTIVO',
		usuarioPromotor: '0',
		razonSocial: '',
		CP: '',
		CPFiscal: '',
		usoCFDI: '22',
		mostrarUsuarioPromotor: true,
		
		chkFacturable: false,
		chkSameData : false,

		errNombre: '',
		errApellidos: '',
		errEmpresa: '',
		errDomicilio1: '',
		errDomicilio2: '',
		errDomicilioFiscal: '',
		errNumero: '',
		errNumeroFiscal: '',
		errColonia: '',
		errColoniaFiscal: '',
		errCiudad: '',
		errCiudadFiscal: '',
		errTelefonos: '',
		errEmail: '',
		errRfc: '',
		errEstado: '',
		errUsuarioPromotor: '',
		errRazonSocial: '',
		errCP: '',
		errCPFiscal: '',
		errUsoCFDI: '',
       
		accionModulo: 'Nuevo'
	},
	mounted: function () {
		if (typeof param1 !== 'undefined') {
			this.idCliente = param1;
			this.accionModulo = 'Actualizar';		  
			xajax_cargarCliente(this.idCliente);

			setTimeout(function(){ app.$refs.direccionesListado.start(app.idCliente, app.nombre + ' ' + app.apellidos); }, 700);
			
		}
		
		setTimeout(function(){ xajax_setPromotor(); }, 500);
	},	
	watch: {
		rfc: function(val){
			this.rfc = val.toUpperCase();
		}
	},
	methods:{
		modalNuevaDireccion: function(){
			
			app.$refs.nuevaDireccion.show(this.idCliente, this.nombre); 
		},
		modalSelector: function(){
			app.$refs.dirfiscalesselector.start(this.idCliente, this.nombre);
		},
		onSelect: function(event){
			console.log("onSelect clienteedit.js");
			console.log(event);
		},
		onDireccionEdited: function(event){
			// console.log("direction edited");
			alert("Direccion Edited");
		},
		elClick: function(count, other){
			console.log("Click en clienteedit: ", count, " --- ", other);
		},
		guardarCliente: function(){
			var seguir = true;
		  
			this.limpiaErrores();
		  
			if (this.nombre.trim() == "")
			{
				this.errNombre = "Debe especificar un Nombre de Cliente.";
				seguir = false;
			}
			
			if (this.apellidos.trim() == "")
			{
				this.errApellidos = "Debe especificar Apellido(s) del Cliente.";
				seguir = false;
			}		
			
			if (this.usuarioPromotor == "0")
			{
				this.errUsuarioPromotor = "Debe especificar el Promotor asociado";
				seguir = false;
			}
			
			
			
			if (this.chkFacturable)
			{
				if (this.domicilio1.trim() == "")
				{
					this.errDomicilio1 = "Debe especificar Dirección.";
					seguir = false;
				}
				
				if (this.numero.trim() == "")
				{
					this.errNumero = "Debe especificar Número.";
					seguir = false;
				}
				if (this.numeroFiscal.trim() == "")
				{
					this.errNumeroFiscal = "Debe especificar Número Fiscal.";
					seguir = false;
				}
				
				if (this.colonia.trim() == "")
				{
					this.errColonia = "Debe especificar Colonia.";
					seguir = false;
				}
				
				if (this.ciudad.trim() == "")
				{
					this.errCiudad = "Debe especificar Ciudad.";
					seguir = false;
				}
				
				if (this.coloniaFiscal.trim() == "")
				{
					this.errColoniaFiscal = "Debe especificar Colonia Fiscal.";
					seguir = false;
				}
				
				if (this.ciudadFiscal.trim() == "")
				{
					this.errCiudadFiscal = "Debe especificar Ciudad Fiscal.";
					seguir = false;
				}
				
//				if (this.telefonos.trim() == "")
//				{
//					this.errTelefonos = "Debe especificar Telefono(s).";
//					seguir = false;
//				}
			  
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
				
				if (this.rfc.trim() == "")
				{
					this.errRfc = "Debe especificar R.F.C.";
					seguir = false;
				}
				
				if (this.estado.trim() == "0")
				{
					this.errEstado = "Debe especificar un Estatus.";
					seguir = false;
				}
				
				
				
				if (this.domicilioFiscal == '')
				{
					this.errDomicilioFiscal = "Debe especificar el Domicilio Fical";
					seguir = false;
				}	
				
				if (this.usoCFDI == '0')
				{
					this.errUsoCFDI = "Debe especificar el Uso CFDI";
					seguir = false;
				}	
				
				if (this.razonSocial == '')
				{
					this.errRazonSocial = "Debe especificar Razón Social";
					seguir = false;
				}
				
				if (this.CP == '')
				{
					this.errCP = "Debe especificar CP";
					seguir = false;
				}
				
				if (this.CPFiscal == '')
				{
					this.errCPFiscal = "Debe especificar CP Fiscal";
					seguir = false;
				}
				
			}
			else
			{
				this.usoCFDI = '22'
			}
			
				
			
			
			if (seguir)
			{		
//				alert("GUARDAR");
				xajax_guardarCliente(this.idCliente, 
				                       this.nombre.trim(), 
				                       this.apellidos.trim(), 
				                       this.empresa.trim(), 
				                       this.domicilio1.trim(), 
				                       this.domicilio2.trim(), 
				                       this.numero.trim(), 
				                       this.colonia.trim(), 
				                       this.ciudad.trim(), 
				                       this.telefonos.trim(), 
				                       this.email.trim(), 
				                       this.rfc.trim(), 
				                       this.estado, 
				                       this.usuarioPromotor,
				                       this.chkFacturable,
				                       this.razonSocial,
				                       this.domicilioFiscal,
				                       this.CP,
				                       this.CPFiscal,
				                       this.usoCFDI,
				                       this.chkSameData,
				                       this.coloniaFiscal,
				                       this.ciudadFiscal,
				                       this.numeroFiscal);
			}	
			
			//xajax_guardar(this.id, this.nombre, this.apellidoPaterno, this.apellidoMaterno);
		},
		limpiaDatos: function(){
			this.idCliente = 0;
			this.nombre = '';
			this.apellidos = '';
			this.empresa = '';
			this.domicilio1 = '';
			this.domicilio2 = '';
			this.numero = '';
			this.numeroFiscal = '';
			this.colonia = '';
			this.ciudad = '';
			this.coloniaFiscal = '';
			this.ciudadFiscal = '';
			this.telefonos = '';
			this.email = '';
			this.rfc = '';
			this.estado = 'ACTIVO';
			this.usuarioPromotor = '0';
			this.razonSocial = '';
			this.domicilioFiscal = '';
			this.CP = '';
			this.CPFiscal = '';
		},
		limpiaErrores: function(){
			this.errNombre = '';
			this.errApellidos = '';
			this.errEmpresa = '';
			this.errDomicilio1 = '';
			this.errDomicilio2 = '';
			this.errDomicilioFiscal = '';
			this.errNumero = '';
			this.errNumeroFiscal = '';
			this.errColonia = '';
			this.errColoniaFiscal = '';
			this.errCiudad = '';
			this.errCiudadFiscal = '';
			this.errTelefonos = '';
			this.errEmail = '';
			this.errRfc = '';
			this.errEstado = '';
			this.errUsuarioPromotor = '';
			this.errRazonSocial = '';
			this.errCP = '';
			this.errCPFiscal = '';
			this.errUsoCFDI = '';
			
		},
		fnRegresarAListado: function(){
			window.location = URL_BASE + "cliente";
		},
		fnSameData:  function() {
			//if (this.chkSameData){
			/*this.razonSocial = this.empresa;
			this.domicilioFiscal = this.domicilio1;
			this.CPFiscal = this.CP;
			this.numeroFiscal= this.numero;
			this.coloniaFiscal=this.colonia;
			this.ciudadFiscal= this.ciudad;*/
			//}
			
			this.empresa = this.razonSocial ;
			this.domicilio1 = this.domicilioFiscal ;
			this.CP = this.CPFiscal;
			this.numero = this.numeroFiscal;
			this.colonia = this.coloniaFiscal;
			this.ciudad = this.ciudadFiscal;
		}		
	}
  
});