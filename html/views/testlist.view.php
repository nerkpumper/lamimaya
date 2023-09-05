<div id="card">
	<header>{{ title }}</header>
	<div>
		<input v-model="dino" v-on:keypress.enter="addItem">
		<button v-on:click="addItem">Add Dinosaurio</button>
	</div>
	<ul>
		<li v-for="(item, index) in items">
			<button v-on:click="deleteItem(index)">X</button>
			{{ item.fuerza }} - {{ item.text }}
		</li>
	</ul>
	
	<br><br>
	<button v-on:click="checaDatos">Checa Dato</button>
	
	<pre>

{{ $data }}

</pre>
	
</div>

