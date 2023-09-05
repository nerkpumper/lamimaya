<?php
$titlePage = "Cr&eacute;dito a Clientes";
$breadCum = "Cliente/Cr&eacute;dito a Cliente";
$_lugar = LUGAR_ADMINISTRACION_CREDITOCLIENTES;

?>

<div class="modal inmodal fade" id="modalSetCredito" tabindex="-1"
	role="dialog" aria-hidden="true">
	<div class="modal-dialog ">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
				</button>
				<h4 class="modal-title">Indique Cr&eacute;dito a asignar al Cliente</h4>
				<h3>{{ clienteSeleccionado }}</h3>
<!-- 				<small class="font-bold"></small> -->
<!-- 				<br> -->
<!-- 				<small class="font-bold"></small> -->
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">

						<form class="form-horizontal">
							<div class="form-group">
								<label class="col-lg-6 control-label">Cr&eacute;dito</label>
								<div class="col-lg-6">
									<input type="text"
										v-model="creditoAAsignar"								
										maxlength="8" oninput="this.value = this.value.replace(/[^0-9.\t]/g, '').replace(/(\..*)\./g, '$1');" 
										class="form-control text-right">
									<label v-if="creditoAAsignar == ''" class="text-danger">Ingrese Cantidad</label>
								</div>
							</div>
						</form>
						
					</div>
					<div class="col-md-12">

						<form class="form-horizontal">
							<div class="form-group">
								<label class="col-lg-6 control-label">Capacidad Pago</label>
								<div class="col-lg-6">
									<input type="text"
										v-model="capacidadPagoAAsignar"								
										maxlength="8" oninput="this.value = this.value.replace(/[^0-9.\t]/g, '').replace(/(\..*)\./g, '$1');" 
										class="form-control text-right">
									<label v-if="capacidadPagoAAsignar == ''" class="text-danger">Ingrese Cantidad</label>
								</div>
							</div>
						</form>
						
					</div>
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						&nbsp;
					</div>				
										
					<div class="col-md-12 " >
						<button @click.prevent="saveCreditoCliente" class="btn btn-success pull-right"> Asignar</button>
					</div>
					
					<div class="clearfix"></div>
				
				</div>
				
			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-white" data-dismiss="modal">Cerrar</button>				
			</div>
		</div>
	</div>
</div>


<!-- Buscar Cliente -->
<div v-show="seleccionandoCliente">

	<div v-show="idCliente > 0" >
		<button @click.prevent="dejarCliente" class="btn btn-warning">Conservar este Cliente</button>
		<div class="row m-b-lg m-t-lg">
			<div class="col-md-6">

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
		</div>
		
		<br>
		
	
	
		<div class="table-responsive">
			<table class="table table-bordered table-striped table-hover">
				<thead>
					<th>Cliente</th>
					<th>Empresa</th>
					<th></th>
					<th>Correo</th>
					<th></th>
					<th>Telefonos</th>
					<th>Cr&eacute;dito</th>
					<th>Capacidad de Pago</th>
					<th>&Uacute;ltimo Proceso</th>
					
					<!-- <th>Debe</th> -->
					<!-- <th>Disponible</th> -->
					<th></th>
				</thead>
				<tbody>
					<tr v-for="(cli, index) in clientesFiltradosPorNombre">
<!-- 						<td class="client-avatar"><img alt="image" src="img/a2.jpg"></td> -->
						<td><a data-toggle="tab" href="#contact-1" class="client-link">{{ cli.nombre }}</a></td>
						<td>{{ cli.empresa }}</td>
						<td class="contact-type">
							<i v-show="cli.email" class="fa fa-envelope"></i>
						</td>
						<td>{{ cli.email }}</td>
						<td class="contact-type"><i v-show="cli.telefonos" class="fa fa-phone"> </i></td>
						<td>{{ cli.telefonos }}</td>
						<td><h3 class="text-navy text-right">{{ cli.credito }}</h3></td>
						<td><h3 class="text-navy text-right">{{ cli.capacidadpago }}</h3></td>
						
						<td>{{ cli.ultimo_proceso }} <a target="_blank" class="btn btn-primary btn-xs" :href="'<?php echo URL_BASE; ?>admincreditoclientesview/' + cli.idCliente"><i class="fa fa-eye"></i></a></td>
						<!-- <td><h3 class="text-danger  text-right">{{ cli.usado }}</h3></td> -->
						<!-- <td><h3 class="text-success  text-right">{{ cli.disponible }}</h3></td> -->
						<td class="client-status"><button @click.prevent="setearCreditoACliente(index)" class="btn btn-primary btn-xs">Asignar Cr&eacute;dito</button></td>
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
