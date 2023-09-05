
var app = new Vue({
	el: '#app',
	data: {
		elementos: [],
		id: 0

	},
	mounted: function(){
	    $('.footable').footable();
	},
	methods:{
		addElement: function(){
			this.id++;
			this.elementos.push({id: this.id, customer: 'Cliente ' + this.id, amount: '10', dateadd: '01/01/2017', datemod: '02/02/2017', status: 'Pendiente'});
			//$('.footable').footable();
			setTimeout(function(){ $('.footable').trigger('footable_redraw')}, 5);
		}
	}
});




