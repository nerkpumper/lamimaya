
<?php
$titlePage = "Anticipo Cliente";
$breadCum = "CXC/Anticipo Cliente";
//$_lugar = LUGAR_CXC_RECIBODINERO;

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
		</div>
		
		<br>
		<hr>
	
	
		<div class="table-responsive">
			<table class="table table-bordered table-striped table-hover">
				
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
						<td class="client-status"><button @click.prevent="seleccionarCliente(cli.idCliente)" class="btn btn-primary btn-xs">Seleccionar</button></td>
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
		<div class="row">
		<div class="col-lg-3">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>Total recibos</h5>
				</div>
				<div class="ibox-content">
					<h1 class="no-margins">$ {{ formatNumber(totalCargos) }}</h1>
<!-- 					<div class="stat-percent font-bold text-success"> -->
<!-- 						98% <i class="fa fa-bolt"></i> -->
<!-- 					</div> -->
					<small>Total</small>
				</div>
			</div>
		</div>
		<div class="col-lg-3">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>Total disponible</h5>
				</div>
				<div class="ibox-content">
					<h1 class="no-margins">$ {{ formatNumber(totalAbonos) }}</h1>
<!-- 					<div class="stat-percent font-bold text-info"> -->
<!-- 						20% <i class="fa fa-level-up"></i> -->
<!-- 					</div> -->
					<small>Total</small>
				</div>
			</div>
		</div>
		
	</div>



<div class="row">
	<div class="col-lg-12">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					
<!-- 					<div class="ibox-tools"> -->
<!-- 						<a class="collapse-link"> <i class="fa fa-chevron-up"></i> -->
<!-- 						</a> <a class="close-link"> <i class="fa fa-times"></i> -->
<!-- 						</a> -->
<!-- 					</div> -->
					<button  class="btn btn-primary" @click.prevent="generarMovimiento" >Capturar recibo</button>
				</div>
				
				<div class="ibox-content" v-show="ingresarMovimiento">
					<div >
						<div class="row">

							<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
								<div class="form-group"
									>
									<label class="control-label" for="price">Monto</label> <input
										type="text"  v-model="monto" class="form-control"
										maxlength="9" 
										oninput="this.value = this.value.replace(/[^0-9.\t]/g, '').replace(/(\..*)\./g, '$1');">
									<span class='help-block'> <strong>{{ errmonto }}</strong>
									</span>
								</div>
							</div>
							<div  class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
								<div class="form-group"
									v-bind:class="{'has-error': errformapago}">
									<label class="control-label" >Forma Pago</label> <select
										class="form-control" v-model="formapago">
										<option value="0">--Seleccione--</option>

									<?php
									foreach ( $listaFormaPago as $fp ) {
										echo "<option value='" . $fp ["idFormaPago"] . "'>" . $fp ["formapago"] . "</option>";
									}

									?>

<!-- 									<option value="ABONO">ABONO</option> -->
										<!-- 									<option value="CARGO">CARGO</option> -->
									</select> <span class='help-block'> <strong>{{
											errformapago }}</strong>
									</span>
								</div>
							</div>
							<div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
								<div class="form-group"
									>
									<label class="control-label"  >Referencia</label> <input
										type="text" v-model="referencia" class="form-control"
										maxlength="250" ref="referencia">
									<span class='help-block'> <strong>{{ errreferencia }}</strong>
									</span>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<button class="btn btn-success pull-right m-l" @click.prevent="guardarMovimiento">Guardar</button>
								<button class="btn btn-danger pull-right" @click.prevent="cancelarMovimiento">Cancelar</button>
							</div>
						</div>
</div>

		</div>			


	<div class="ibox-content">
		<h3>listado recibos</h3><br>
		<h4 v-show="movimientos.length == 0" >No se han encontrado Movimientos.</h4>
		<div class="row">
		<div v-show="movimientos.length > 0" class="col-lg-12">							
		<table class="table table-bordered table-striped table-hover">
			<thead>
				<tr>
					<th class="text-center">ID</th>					
					<th class="text-center">Forma Pago</th>
					<th class="text-center">Monto</th>
					<th class="text-center">Saldo Disponible</th>
					<th class="text-center">Fecha Captura</th>
					<th class="text-center">Referencia</t
				</tr>
			</thead>
				<tbody>
					<tr v-for="(mov, index) in movimientos">
						<td class="text-center ">{{ mov.idReciboDinero }} <a target="_blank" :href="URL_BASE+'recibodineropdf/'  + mov.idReciboDinero" class="btn btn-primary btn-xs"><i class="fa fa-print"></i> </a></td>
						<td class="text-center ">{{ mov.formaPago }}</td>
						<td class="text-center " style="width:100px">${{ formatNumber(mov.monto) }}</td>
						<td class="text-center " style="width:100px">${{ formatNumber(mov.disponible) }}</td>
						<td class="text-center ">{{ mov.fecha_captura }}</td>
						<td class="text-center ">{{ mov.referencia }}</td>				
					</tr>
				</tbody>

		</table>
		</div>
		</div>
	</div>						
					
 <!--  <pre>{{ $data }}</pre> -->

