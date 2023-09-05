
var app = new Vue({
	el: '#app',
	data: {
		idParent: '',
		iconChildren: 'fa fa-angle-double-left',		
		nombreParent: 'Seleccione categoría',
		
		categorias: [],
		children: []
	},
	mounted: function(){
		
		setTimeout(function() { xajax_cargarParents(); }, 100);
	},
	methods: {
		seleccionaPadre: function(index){
			this.idParent = this.categorias[index].id;
			this.nombreParent = this.categorias[index].nombre;
			this.iconChildren = this.categorias[index].icon;
			
			
			xajax_cargarHijos(this.idParent);
		},
		seleccionaHijo: function(index){
			window.location = URL_BASE + this.children[index].id;
		}
	}
});