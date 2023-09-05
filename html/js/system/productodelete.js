
var app = new Vue({
	el: '#app',
	data: {		
		idProducto: 0,
		productoEliminado: false,
		
		codigo: '',
		tipoProducto: '',
		unidad: '',
		aplicacion: '',
		material: '',
		rollo: '',
		calibre: '',
		descripcion: '',
		existencia: '',
		movimiento: '0',
		cantidad: '',
		observaciones: '',
		fullDescripcion: '',
		
	},
	created: function () {
		if (typeof param1 !== 'undefined') {
			this.idProducto = param1;				  
			xajax_cargarProducto(this.idProducto);
			
		}
		else
		{
			window.location = URL_BASE + "producto";
		}
	},
	watch: {
		
	},
	methods:{
		eliminarProducto: function(){
			xajax_eliminarProducto(this.idProducto);
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
			
		},		
		limpiaErrores: function(){
			
		},
		fnRegresarAListado: function(){
			window.location = URL_BASE + "producto";
		}
	}
  
});