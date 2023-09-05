
var app = new Vue({
	methods: {
		setValue:function(){
			//this.$data.oldPeople=_.cloneDeep(this.$data.people);
			//this.oldPeople=_.cloneDeep(this.people);
			//this.oldPeople=cloneDeep(this.people);
			this.oldPeople = JSON.parse(JSON.stringify(this.people));
//			var i;
//			
//			this.oldPeople.splice(0, this.oldPeople.length);
//			
//			for (i = 0; i < this.people.length ; i++)
//			{
//				this.oldPeople.push(this.people[i]);
//			}
		},
	},
	mounted() {
		this.setValue();
	},
	el: '#app',
	data: {
		people: [
		         {id: 0, name: 'Bob', age: 27},
		         {id: 1, name: 'Frank', age: 32},
		         {id: 2, name: 'Joe', age: 38}
		         ],
		oldPeople:[]
	}, 
	watch: {
    
		people: {
			handler: function (after, before) {
			// Return the object that changed
//			var vm=this;
//       
//			let changed = after.filter( function( p, idx ) {
//				return Object.keys(p).some( function( prop ) {
//					//return p[prop] !== vm.$data.oldPeople[idx][prop];
//					console.log("Col:  " + prop + "   -   " + p[prop] + "  -  " + vm.oldPeople[idx][prop]);
//					return p[prop] !== vm.oldPeople[idx][prop];
//				});
//			});
        // Log it
				
			var i;
			
			for (i = 0; i < this.people.length ; i++)
			{
				if (this.people[i].age != this.oldPeople[i].age)
				{
					console.log("Ha cambiado la edad de " + i);
				}
			}
				
				
			this.setValue();
//			console.log(changed);
			},
      deep: true,
	}
  }
});