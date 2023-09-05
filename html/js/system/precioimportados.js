

var app = new Vue({
	el : '#app',
	data : {
		tipoPrecio: 'I',

		precios : [ {
			desarrollo : '1-15',
			calibre26 : [ {
				id: 0,
				precio1 : 0,
				precio2 : 0,
				precio3 : 0,
				precio4 : 0,
				precio5 : 0,
				precio6 : 0,
				precio7 : 0,
				precio8 : 0,
				precio9 : 0,
				precio10 : 0
			} ],
			calibre24 : [ {
				id: 0,
				precio1 : 0,
				precio2 : 0,
				precio3 : 0,
				precio4 : 0,
				precio5 : 0,
				precio6 : 0,
				precio7 : 0,
				precio8 : 0,
				precio9 : 0,
				precio10 : 0
			} ]
		},
		{
			desarrollo : '16-20',
			calibre26 : [ {
				id: 0,
				precio1 : 0,
				precio2 : 0,
				precio3 : 0,
				precio4 : 0,
				precio5 : 0,
				precio6 : 0,
				precio7 : 0,
				precio8 : 0,
				precio9 : 0,
				precio10 : 0
			} ],
			calibre24 : [ {
				id: 0,
				precio1 : 0,
				precio2 : 0,
				precio3 : 0,
				precio4 : 0,
				precio5 : 0,
				precio6 : 0,
				precio7 : 0,
				precio8 : 0,
				precio9 : 0,
				precio10 : 0
			} ]
		},		
		{
			desarrollo : '21-30',
			calibre26 : [ {
				id: 0,
				precio1 : 0,
				precio2 : 0,
				precio3 : 0,
				precio4 : 0,
				precio5 : 0,
				precio6 : 0,
				precio7 : 0,
				precio8 : 0,
				precio9 : 0,
				precio10 : 0
			} ],
			calibre24 : [ {
				id: 0,
				precio1 : 0,
				precio2 : 0,
				precio3 : 0,
				precio4 : 0,
				precio5 : 0,
				precio6 : 0,
				precio7 : 0,
				precio8 : 0,
				precio9 : 0,
				precio10 : 0
			} ]
		},		
		{
			desarrollo : '31-40',
			calibre26 : [ {
				id: 0,
				precio1 : 0,
				precio2 : 0,
				precio3 : 0,
				precio4 : 0,
				precio5 : 0,
				precio6 : 0,
				precio7 : 0,
				precio8 : 0,
				precio9 : 0,
				precio10 : 0
			} ],
			calibre24 : [ {
				id: 0,
				precio1 : 0,
				precio2 : 0,
				precio3 : 0,
				precio4 : 0,
				precio5 : 0,
				precio6 : 0,
				precio7 : 0,
				precio8 : 0,
				precio9 : 0,
				precio10 : 0
			} ]
		},
		{
			desarrollo : '41-61',
			calibre26 : [ {
				id: 0,
				precio1 : 0,
				precio2 : 0,
				precio3 : 0,
				precio4 : 0,
				precio5 : 0,
				precio6 : 0,
				precio7 : 0,
				precio8 : 0,
				precio9 : 0,
				precio10 : 0
			} ],
			calibre24 : [ {
				id: 0,
				precio1 : 0,
				precio2 : 0,
				precio3 : 0,
				precio4 : 0,
				precio5 : 0,
				precio6 : 0,
				precio7 : 0,
				precio8 : 0,
				precio9 : 0,
				precio10 : 0
			} ]
		},
		{
			desarrollo : '62-1.22',
			calibre26 : [ {
				id: 0,
				precio1 : 0,
				precio2 : 0,
				precio3 : 0,
				precio4 : 0,
				precio5 : 0,
				precio6 : 0,
				precio7 : 0,
				precio8 : 0,
				precio9 : 0,
				precio10 : 0
			} ],
			calibre24 : [ {
				id: 0,
				precio1 : 0,
				precio2 : 0,
				precio3 : 0,
				precio4 : 0,
				precio5 : 0,
				precio6 : 0,
				precio7 : 0,
				precio8 : 0,
				precio9 : 0,
				precio10 : 0
			} ]
		}

		]

	// idMaterial: 0,
	// nombre: '',
	// clave: '',
	//		              	
	// errNombre: '',
	// errClave: '',
	//		
	// accionModulo: 'Nuevo'
	},
	mounted : function() {
		// if (typeof param1 !== 'undefined') {
		// this.idMaterial = param1;
		// this.accionModulo = 'Actualizar';
		// xajax_cargarMaterial(this.idMaterial);
		// }
		//		
		// this.$refs.nombre.focus();
		
		xajax_cargarPrecios(this.tipoPrecio);
	},
	// watch: {
	// clave: function(val){
	// this.clave = val.toUpperCase();
	// }
	// },
	methods : {
		probarArreglo : function() {
			xajax_probarArreglo(this.precios);
		},
		modificarPrecio: function(){			
			this.precios[0].calibre24[0].precio2 = 2;
		},
		guardarPrecios : function() {
			xajax_guardarPrecios(this.tipoPrecio, this.precios);
		}

	}

});