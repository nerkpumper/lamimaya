

var card = new Vue({
	el: '#card',
	data: {
		title: 'Dinosaurios',
		dino: '',
		items: [
		        { text: 'Velociraptor', fuerza: 10},
		        { text: 'Triceratops', fuerza: 20},
		        { text: 'Stegosaurus', fuerza: 20}
		        ]
	},
	methods: {
		addItem: function(){
			if (this.dino != "")
			{
				this.items.push({ text: this.dino, fuerza: 5});
				this.dino = '';
			}
		},
		deleteItem: function(index){
			this.items.splice(index, 1);
		},
		checaDatos: function(){
			xajax_checarDatos(this.items);
		}
		
	}
});