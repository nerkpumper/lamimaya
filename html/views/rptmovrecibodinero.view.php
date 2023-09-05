<?php
$titlePage = "Movimientos recibo dinero";
$breadCum = "Cxc/MovReciboDinero";
$_useDataTable = true;
?>


<!-- Buscar Cliente -->
<div v-show="seleccionandoCliente">

	<div v-show="idCliente > 0" >
		<button @click.prevent="dejarCliente" class="btn btn-warning">Conservar este Cliente</button>
		<div class="row m-b-lg m-t-lg">
			<div class="col-md-6">
				<h3>Cliente:</h3>
				<div class="profile-image">
					<img src="<?php echo URL_BASE;?>img/noimage.png"
						class="img-circle circle-border m-b-md" alt="profile">
				</div>
				<div class="profile-info">
					<div class="">
						<div>
							<h2 class="no-margins">{{ nombre }}</h2>
							<h4>{{ empresa }}</h4>
							<small> {{ domicilio1}} {{ domicilio2 }} </small> <br> <small> {{ telefonos }} </small>
						</div>
					</div>
				</div>
			</div>			

		</div>
	</div>

 
	<div class="panel-rec">		
	
		<h3>Seleccione Cliente</h3>
		<div class="row">
			<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
				<input type="text" class="form-control"	v-model="filtroNombreCliente"	 		
		 		placeholder="filtrar">
			</div>
			<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
				<div class="checkbox checkbox-primary">
					<input id="chkConSaldo" type="checkbox" v-model="chkConSaldo" value ='false'>
					<label for="chkConSaldo">
						Mostrar solo con saldo 
					</label>
				</div> 
			</div>	
			<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
					<button @click.prevent="cargarClientes(app.chkconsaldo)" class="btn btn-primary ">Filtrar</button>
			</div>			
		</div>
		
		<br>
		<hr>
	
	
		<div class="table-responsive">
			<table class="table table-bordered table-striped table-hover">
			<thead>
							<tr>
								<th>ID</th>								
								<th>Nombre Cliente</th>
								<th>Empresa</th>
								<th></th>
                                <th>Correo</th>
								<th></th>
								<th>Telefono</th>
								<th>Saldo Recibo</th>
								<th>Ver Detalle</th>								
							</tr>
						</thead>
				
				<tbody>
					<tr v-for="(cli, index) in clientesFiltradosPorNombre">
<!-- 						<td class="client-avatar"><img alt="image" src="img/a2.jpg"></td> -->
						<td>{{ cli.idCliente }}</td>
						<td><a data-toggle="tab" href="#contact-1" class="client-link">{{ cli.nombre }}</a></td>
						<td>{{ cli.empresa }}</td>
						<td class="contact-type">
							<i v-show="cli.email" class="fa fa-envelope"></i>
						</td>
						<td>{{ cli.email }}</td>
						<td class="contact-type"><i v-show="cli.telefonos" class="fa fa-phone"> </i></td>
						<td>{{ cli.telefonos }}</td>
						<td v-show = 'cli.saldoRecibo > 0' class=' text-success'>${{ (cli.saldoRecibo) }}</td>
						<td v-show = 'cli.saldoRecibo == 0'class='text-danger'>${{ (cli.saldoRecibo) }}</td>
						
						<td class="client-status"><button @click.prevent="seleccionarCliente(cli.idCliente)" class="btn btn-primary btn-xs">Seleccionar</button></td>
					</tr>					

					</tr>					
				</tbody>
			</table>
		</div>
	</div>
	
</div>

<!-- Datos Cliente -->
<div v-show="!seleccionandoCliente">

	<div>
		<button @click.prevent="seleccionarOtroCliente" class="btn btn-warning">Seleccionar otro Cliente</button>
		<div class="row m-b-lg m-t-lg">
			<div class="col-md-6">
				<h3>Cliente:</h3>
				<div class="profile-image">
					<img src="<?php echo URL_BASE;?>img/noimage.png"
						class="img-circle circle-border m-b-md" alt="profile">
				</div>
				<div class="profile-info">
					<div class="">
						<div>
							<h2 class="no-margins">{{ nombre }}</h2>
							<h4>{{ empresa }}</h4>
							<small> {{ domicilio1}} {{ domicilio2 }} </small> <br> <small> {{ telefonos }} </small>
						</div>	
					</div>
				</div>
			</div>
		</div>			
	</div>
	<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	<div class="ibox-content">
		<h3>Listado movimientos recibo dinero</h3><br>
		<h4 v-show="movimientos.length == 0" >No se han encontrado Movimientos.</h4>
		<div class="row">
		<div v-show="movimientos.length > 0" class="col-lg-12">							
		<table class="table table-bordered table-striped table-hover">
			<thead>
				<tr>
					<th class="text-center">ID</th>	
					<th class="text-center">Movimiento</th>
					<th class="text-center">No Recibo</th>			
					<th class="text-center">Pedido</th>
					<th class="text-center">Saldo Anterior</t>
					<th class="text-center">Monto</t>
					<th class="text-center">Usuario</t>
					<th class="text-center"  style="width:500px">observaciones</t>
				</tr>
			</thead>
				<tbody>
					<tr v-for="(mov, index) in movimientos">
						<td class="text-center ">{{ mov.idReciboDinero }}</td>
						<td class="text-center ">{{ mov.movimiento }}</td>
						<td class="text-center ">{{ mov.idReciboDinero }}</td>
						<td class="text-center ">{{ mov.idPedido }}</td>
						<td class="text-center ">{{ mov.saldoActual }}</td>
						<td class="text-center ">{{ mov.monto }}</td>
						<td class="text-center ">{{ mov.usuario }}</td>
						
						<td class="text-rigth " style="width:500px">{{ mov.observaciones }}</td>					
					</tr>
				</tbody>

		</table>
		</div>
		</div>
	</div>		
	</div>
</div>


  
</div>
