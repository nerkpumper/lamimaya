//xajax_saludar("38");
//alert('param1 desde js: ' + param1);

//var jsNombre = "nombre en var js";

var app = new Vue({
  el: '#app',
  data: {
    message: 'Kamisama',
    nombre: 'holita'
    
  },
  created: function () {
	    // `this` points to the vm instance
	    xajax_saludar("666");
	  }
});



//console.log(app["data"]);



//xajax_saludar("89");