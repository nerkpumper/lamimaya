<?php
$titlePage = "Aportaciones Mendez";
$breadCum = "Administracion/Aportaciones Mendez";
$_lugar = "LUGAR_ADMINNISTRACION_APORTACIONESMENDEZ";
?>

<div v-show="isUserMendez" >

	<div>
		<div class="row">
			<div class="col-lg-12">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<h5>Aportaciones Mendez</h5>
					</div>
					<div class="ibox-content">
						<div>
							<div class="row">
								<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
									<div class="form-group"
										v-bind:class="{'has-error': errMonto}">
										<label class="control-label" for="price">Monto</label> <input
											type="text" v-model="monto" class="form-control"
											maxlength="15" ref="monto"
											oninput="this.value = this.value.replace(/[^0-9.\t]/g, '').replace(/(\..*)\./g, '$1');">
										<span class='help-block'> <strong> {{errMonto}} </strong>
										</span>
									</div>
								</div>
								<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
									<div class="form-group"
										v-bind:class="{'has-error': errReferencia}">
										<label class="control-label" for="price">Referencia</label> <input
											type="text" v-model="referencia" class="form-control"
											maxlength="65" ref="referencia">
										<span class='help-block'> <strong> {{errReferencia}} </strong>
										</span>
									</div>
								</div>
							</div>
						</div>
						<div>
							<button  class="btn btn-primary" @click.prevent="guardarAportacion">Generar Movimiento</button>
	<!-- 						<button class="btn btn-primary pull-right" @click.prevent="sendToExcel">Enviar a Excel</button> -->
											<hr>		
							<div class="row">
								<div class="col-lg-12">
									<div class="table-responsive">
										<table id="tablaToExcel" class="table table-bordered table-hover ">
											<thead>
												<tr>														
													<th>Usuario</th>
													<th>Referencia</th>
													<th>fecha Captura</th>
													<th class="text-right">Monto</th>													
												</tr>
											</thead>
											<tbody>
												<tr v-for="(apor, index) in lstAportaciones" >
													<td> {{apor.usuario}}  </td>
													<td> {{apor.referencia}} </td>
													<td> {{apor.fecha_capturado }} </td>
													<td class="text-right text-success">$ {{apor.monto}} </td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>
</div>

<div v-show="!isUserMendez" >
	<h2 class="text text-warning"> No tienes permisos en esta pagina</h2>
</div>