
var app = new Vue({
	el: '#app',
	data: {		
		idRollo: 0,
		rolloEliminado: false,
		
		codigo: '',		
		material: '',
		proveedor: '',		
		calibre: '',
		pies: '',
		descripcion: '',
		existencia: ''		
		
	},
	created: function () {
		if (typeof param1 !== 'undefined') {
			this.idRollo = param1;				  
			xajax_cargarRollo(this.idRollo);
			
		}
		else
		{
			window.location = URL_BASE + "rollo";
		}
	},
	watch: {
		
	},
	methods:{
		eliminarRollo: function(){
			xajax_eliminarRollo(this.idRollo);
		},
		limpiaDatos: function(){
			//this.idProducto = 0;
			
			this.codigo = '';			
			this.material = '';
			this.proveedor =  '';
			this.calibre = '';
			this.pies = '';
			this.descripcion = '';
			this.cantidad = '';
			this.observaciones = '';
						
			
		},		
		limpiaErrores: function(){
			
		},
		fnRegresarAListado: function(){
			window.location = URL_BASE + "rollo";
		}
	}
  
});