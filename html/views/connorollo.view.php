<?php
$titlePage = "N&uacute;mero de rollo";
$breadCum = "Consultas/N&uacute;mero de Rollo";
//$buttonAction = "Regresar al Listado/fnRegresarAListado";
$_lugar = LUGAR_CONSULTAS_NOROLLO;
?>

<!-- <button class="btn btn-primary" @click.prevent="addRollo">Add Rollo</button> -->
<!-- <br> -->
<!-- <br> -->

<!-- <div v-for="(item, index) in rollos"> -->

<!-- 	<div class="col-lg-1"> -->
<!-- 	<button @click.prevent="addHijo(index)" class="btn btn-success btn-xs">+ hijo a {{ item.descripcion }}</button> -->
<!-- 	</div> -->
	

<!-- </div> -->


<div>
	<div class="row">
		<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
			<h2>No. Rollo</h2>
		</div>

		<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
			<div class="m-b-xs">
				<div class="input-group" style="padding-top: 10px;">
					<input type="text" class="form-control input-lg"
						v-model="noRollo" 
						v-on:keypress.enter="app.cargarDatosNoRollo();"> <span class="input-group-btn">
						<button @click.prevent="cargarDatosNoRollo"
							class="btn btn-primary btn-lg " type="button">
							<i class="fa fa-search"></i><span class="bold"></span>
						</button>
					</span>
				</div>
			</div>
		</div>
	</div>

</div>


<div v-if="msgError">
	<div class="text-center animated fadeInRight alert alert-danger" >        
        {{ msgError }}
    </div>
</div>

<!-- <div > -->
<!-- 	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> -->
<!-- 		<div class="ibox"> -->
<!-- 	    	<div class="ibox-content"> -->
<div v-for="r in rollos" class="panel-rec m-b">
	<h2>
		<span class="text-navy"> {{ r.codigo }}</span> {{ r.descripcion }}
	</h2>
	<div class="table-responsive">
		<table class="table table-striped table-bordered">
			<thead>
				<tr>
					<th># Rollo</th>
					<th>Registro</th>
					<th>Remisi&oacute;n</th>
					<th>Almacen</th>
					<th>Kilos</th>
					<th>Disponible</th>
					<th>Estado</th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="remi in r.noRollos">
					<td><h3>{{ remi.noRollo }}</h3></td>
					<td>{{ remi.fecha }}</td>
					<td>{{ remi.remision }}</td>
					<td>{{ remi.almacen }}</td>
					<td>{{ remi.kilos.toLocaleString() }}</td>
					<td>{{ remi.disponible.toLocaleString() }}</td>
					<td>{{ remi.estado }}</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
<!-- 	    	</div> -->
<!-- 	    </div> -->
<!-- 	</div> -->
<!-- </div> -->

<!-- <pre>{{ $data }}</pre> -->