
var app = new Vue ({
	el: '#app',
	data:{
		
		
		asunto: '',
		errAsunto: '',
		msg: '',
		errMsg: '',
		
		msgDestinoIdUsuario: 0,
		msgDestinoToken: '',
		msgDestinoNombre: '',
		
		contactos: []
	},
	watch:{
		asunto: function(val){
			this.asunto = val.toUpperCase();
		}
	},
	mounted: function() {
		xajax_cargarUsuarios();
	},
	methods: {
		getImg: function(index){
			return "<img alt='image' class='img-circle m-t-xs img-responsive'  src='"+this.contactos[index].image+"'>";
		},
		enviarmsg: function(index){
			
			this.msgDestinoIdUsuario = this.contactos[index].idusuario;
			this.msgDestinoToken = this.contactos[index].token;
			this.msgDestinoNombre = this.contactos[index].nombre + ' ' + this.contactos[index].apellidoPaterno + ' ' +this.contactos[index].apellidoMaterno;
			
			this.asunto = '';
			this.msg = '';
			
			$("#modalEnviaMsg").modal();
		},
		envia: function(){
			var seguir = true;
			
			
			this.errAsunto = '';
			this.errMsg = '';
			
			if (this.asunto == '')
			{
				this.errAsunto = 'Debe agregar un asunto';
				seguir = false;
			}
			
			if (this.msg == '')
			{
				this.errMsg = 'Debe agregar un mensaje';
				seguir = false;
			}
			
			if (seguir)
			{
				$("#modalEnviaMsg").modal('toggle');	
				xajax_enviaMsg(this.msgDestinoIdUsuario, this.asunto, this.msg);
							
			}
		}
	}
});