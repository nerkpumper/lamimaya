

var app = new Vue({
	el: '#app',
	data: {
        retornoapi1: 'Aqui se pondra lo que recibimos de la api, en la variable retorno1',
        datopost: "",
        retornoapi2: 'Respuesta de ejemplo POST',
        array: []
    },
    methods: {
        pruebaerrorllamada: function(){
            axios.get(URL_BASE + 'api/ejemploapi.api.php?method=metodonoexistente')
                .then(function (response) {
                    
                    console.log(response.data);                   
                    
                })
                .catch(function (error) {
                    // si hubo un error, lo imprimimos
                    console.log(error);
                });
        },
        prueba1: function(){
            
            // mandamos llamar el api que esta en el sistema
            // en la carpeta de api
            // para este ejemplo se llama ejemploapi.api.php
            // utilizamos axios, esta libreria ya esta cargada en la html principal
            axios.get(URL_BASE + 'api/ejemploapi.api.php?method=metodo1')
                .then(function (response) {
                    // lo que recibimos en la response, son muchos datos, lo que retornamos de la 
                    // api, esta en data
                    console.log(response.data);

                    // cuando ocupamos manipular una variable o llamar un metodo del objeto de Vue
                    // en este caso llamado app, no podemos llamar a this.variable
                    // o this.methodo, desde axios, asi que usamos app.

                    app.retornoapi1 = response.data.retorno1;

                    
                })
                .catch(function (error) {
                    // si hubo un error, lo imprimimos
                    console.log(error);
                });
        },
        prueba2: function(){
            
            var data = new FormData();
            data.append("dato", this.datopost);

            axios.post(URL_BASE + 'api/ejemploapi.api.php?method=metodo2', data)
                .then(function (response) {
                    // lo que recibimos en la response, son muchos datos, lo que retornamos de la 
                    // api, esta en data
                    console.log(response.data);

                    app.retornoapi2 = response.data.retorno2;

                    
                })
                .catch(function (error) {
                    // si hubo un error, lo imprimimos
                    console.log(error);
                });
        },
        prueba3: function(){
            
            

            axios.get(URL_BASE + 'api/ejemploapi.api.php?method=regresaarreglo')
                .then(function (response) {
                    // lo que recibimos en la response, son muchos datos, lo que retornamos de la 
                    // api, esta en data
                    console.log(response.data.elarreglo);

                    app.array.splice(0, app.array.length);
                    response.data.elarreglo.forEach(element => {
                        app.array.push(element);
                    });;

                    
                })
                .catch(function (error) {
                    // si hubo un error, lo imprimimos
                    console.log(error);
                });
        }
    }
});