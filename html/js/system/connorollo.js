var i;

var app = new Vue({
	el: '#app',
	data: {
		noRollo: '',
		
		msgError: '',
			
		rollos: []
	},
	created: function() {
		i = 1;
	},
	watch: {
		noRollo: function(val){
			this.noRollo = val.toUpperCase();
		}
	},
	methods: {
		cargarDatosNoRollo: function(){
			if (this.noRollo != "")
			{			
				this.msgError = '';
				xajax_cargarNoRemisiones(this.noRollo);
			}
			else
			{
				saTexto("Debes introducir un Número de Rollo");
			}
		},
		addRollo: function(){
			this.rollos.push({idRollo: i, codigo: 'codigo', descripcion: 'rollito ' + i, noRollos: []});
			i++;
		},
		addHijo: function(index){
			var hijos = this.rollos[index].noRollos.length;
			hijos++;
			this.rollos[index].noRollos.push({ idNoRollo: hijos, noRollo: 'no rollo' + hijos, fecha: hijos, remision: hijos, almacen: hijos, kilos: hijos, disponible: hijos });
		}
	}
});