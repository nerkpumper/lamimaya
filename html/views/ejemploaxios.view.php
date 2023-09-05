<h3>Ejemplo para dejar de utilizar xajax</h3>
<br>
<button class="btn btn-primary" @click.prevent="pruebaerrorllamada">Pulsa aqui para que veas en consola un error que retorna la api</button>
<br><br>
<br>
<hr>
<button class="btn btn-primary" @click.prevent="prueba1">Prueba 1 axios, llamada GET</button>
<br>
<label>{{ retornoapi1 }}</label>

<br><br><br>
<hr>
<input type="text" class="form-control" v-model="datopost">
<br>
<button placeholder="mete texto aqui" class="btn btn-primary" @click.prevent="prueba2">Prueba 2 axios, llamada POST</button>
<br>
<label>{{ retornoapi2 }}</label>

<br><br><br><br>
<hr>
<button class="btn btn-primary" @click.prevent="prueba3">Ejemplo para recibir un array</button>
<br>
<table class="table">
    <thead>
        <tr>
            <th>Dato 1</th>
            <th>Dato 2</th>
        </tr>
    </thead>
    <tbody>
        <tr v-for="row in array">
            <td>{{ row.dato1 }}</td>
            <td>{{ row.dato2 }}</td>
        </tr>
    </tbody>
</table>
<pre>
    {{ $data.array}}
</pre>