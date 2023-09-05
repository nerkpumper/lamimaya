<?php
// $_showPageHeading = false;

$titlePage = "Descuentos a Clientes ";
$breadCum = "Administraci&oacute;n/Descuentos a Clientes";
$_lugar = LUGAR_ADMINISTRACION_DESCTOSCTES;
?>

<div class="modal inmodal fade" id="modalIndicaDescuento" tabindex="-1"
	role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
				</button>
				<h4 class="modal-title">Indique el Porcentaje de descuento a Aplicar</h4>
				<small class="font-bold">{{ nombreCliente }}</small>
				<br>
				<small class="font-bold">{{ empresaCliente }}</small>
			</div>
			<div class="modal-body">
				<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
					<div class="input-group">
						<span class="input-group-addon">%</span> <input type="text"
							v-model="descuentoCliente"
							oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
							maxlength="8" class="form-control text-right">
	
					</div>
				</div>
				<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
					<button @click.prevent="asignarDescuento" class="btn btn-primary"> Asignar</button>
				</div>
				
				<div class="clearfix"></div>
			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-white" data-dismiss="modal">Cerrar</button>				
			</div>
		</div>
	</div>
</div>



<!-- Buscar Cliente -->
<div v-show="seleccionandoCliente">

	


	<div class="panel-rec">
		<h3>Listado de Clientes</h3>
		<div class="row">
			<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
				<select class="form-control" v-model="filtroDescuento">
					<option value="TODOS">-- Todos --</option>
					<option value="CONDESCTO">Con descuento por aplicar</option>
					<option value="SINDESCTO">Sin descuento asignado</option>					
				</select>
			</div>
			<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
				<button @click.prevent="cargarClientes" class="btn btn-primary">Obtener</button>
			</div>					
		</div>
		
		<hr>
		<div class="row">
		
		
			<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
				<input type="text" class="form-control"	v-model="filtroNombreCliente"	 		
		 		placeholder="filtrar nombre cliente">
			</div>			
			
		</div>
		
		<br>
		
	
	
		<div class="table-responsive">
			<table class="table table-bordered table-striped table-hover">
				<thead>
					<tr>
						<th>Nombre</th>
						<th>Empresa</th>
						<th>EMail</th>
						<th>Telefono</th>
						<th>Descto. A Aplicar</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<tr v-for="(cli, index) in clientesFiltradosPorNombre">
<!-- 						<td class="client-avatar"><img alt="image" src="img/a2.jpg"></td> -->
						<td><a data-toggle="tab" href="#contact-1" class="client-link">{{ cli.nombre }}</a></td>
						<td>{{ cli.empresa }}</td>						
						<td><span class="contact-type"><i v-show="cli.email" class="fa fa-envelope"></i></span> {{ cli.email }}</td>						
						<td><span class="contact-type"><i v-show="cli.telefonos" class="fa fa-phone"> </i></span> {{ cli.telefonos }}</td>
						<td><h3><span ><i  class="fa fa-dollar"> </i></span> {{ cli.porDescuento }}</h3></td>
						<td class="client-status"><button @click.prevent="seleccionarCliente(index)" class="btn btn-primary btn-xs">Asignar Descuento</button></td>
					</tr>					
<!-- 					<tr> -->
<!-- <!-- 						<td class="client-avatar"><img alt="image" src="img/a4.jpg"></td> --> 
<!-- 						<td><a data-toggle="tab" href="#contact-3" class="client-link">Lionel -->
<!-- 								Mcmillan</a></td> -->
<!-- 						<td>Et Industries</td> -->
<!-- 						<td class="contact-type"><i class="fa fa-phone"> </i></td> -->
<!-- 						<td>+432 955 908</td> -->
<!-- 						<td class="client-status"></td> -->
					</tr>					
				</tbody>
			</table>
		</div>
	</div>
	
</div>

<!-- <pre>{{ $data }}</pre> -->