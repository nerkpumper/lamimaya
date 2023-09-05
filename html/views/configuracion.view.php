<?php
$titlePage = "Configuraci&oacute;n";
$breadCum = "Administraci&oacute;n/Configuraci&oacute;n";
$_lugar = LUGAR_ADMINISTRACION_CONFIGURACION;

$_addHead="
 		<link href='".URL_BASE."assets/inspinia/css/plugins/sweetalert/sweetalert.css' rel='stylesheet'>
 		";

$_addScript="

 		<script src=\"".URL_BASE."assets/inspinia/js/plugins/sweetalert/sweetalert.min.js\"></script>
 		";

?>
<!-- <button @click.prevent="pruebaGetNotificaciones">prueba notificaciones</button> -->

<div class="row">
	<!-- Peso X ML X Calibre -->
	<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
		<div class="ibox-title">
			<h5>
				<i class="fa fa-flask"></i> Peso KG X ML X Calibre
			</h5>
		</div>
		<div class="ibox-content">
			<div class="row">
				<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
					<div >
						<label>Peso X Calibre 20</label>
						<h2 v-if="!editPesoXCalibre">{{ configPesoCalibre20 }}</h2>
						<div v-else>
							<input v-model="editConfigPesoCalibre20" type="text" placeholder="Peso en KG" class="form-control text-right" maxlength="8" oninput="this.value = this.value.replace(/[^0-9.\t]/g, '').replace(/(\..*)\./g, '$1');">

						</div>
					</div>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
					<div >
						<label>Peso X Calibre 22</label>
						<h2 v-if="!editPesoXCalibre">{{ configPesoCalibre22 }}</h2>
						<div v-else>
							<input v-model="editConfigPesoCalibre22" type="text" placeholder="Peso en KG" class="form-control text-right" maxlength="8" oninput="this.value = this.value.replace(/[^0-9.\t]/g, '').replace(/(\..*)\./g, '$1');">

						</div>
					</div>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
					<div>
						<label>Peso X Calibre 24</label>
						<h2 v-if="!editPesoXCalibre">{{ configPesoCalibre24 }}</h2>
						<div v-else>
							<input v-model="editConfigPesoCalibre24" type="text" placeholder="Peso en KG" class="form-control text-right" maxlength="8" oninput="this.value = this.value.replace(/[^0-9.\t]/g, '').replace(/(\..*)\./g, '$1');">
						</div>
					</div>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
					<div>
						<label>Peso X Calibre 26</label>
						<h2 v-if="!editPesoXCalibre">{{ configPesoCalibre26 }}</h2>
						<div v-else>
							<input v-model="editConfigPesoCalibre26" type="text" placeholder="Peso en KG" class="form-control text-right" maxlength="8" oninput="this.value = this.value.replace(/[^0-9.\t]/g, '').replace(/(\..*)\./g, '$1');">
						</div>
					</div>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
					<div>
						<label>Peso X Calibre 28</label>
						<h2 v-if="!editPesoXCalibre">{{ configPesoCalibre28 }}</h2>
						<div v-else>
							<input v-model="editConfigPesoCalibre28" type="text" placeholder="Peso en KG" class="form-control text-right" maxlength="8" oninput="this.value = this.value.replace(/[^0-9.\t]/g, '').replace(/(\..*)\./g, '$1');">
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div v-if="errorPesoXCalibre" class="row m-t-md">
						<div v-html="errorPesoXCalibre" class="alert alert-danger"></div>
					</div>
				</div>

			</div>
		</div>
		<div class="ibox-footer">
			<span v-if="editPesoXCalibre" class="pull-right">
				<button @click.prevent="guardarPesoXCalibre" class="btn btn-success"> Guardar</button>
			</span>
			<button v-if="editPesoXCalibre" @click.prevent="desactivarPesoXCalibre" class="btn btn-warning">Cancelar</button>
			<button v-if="!editPesoXCalibre" @click.prevent="activarPesoXCalibre" class="btn btn-primary">Activar Edici&oacute;n</button>
			<div class="clearfix"></div>
		</div>
	</div>

	<!-- Fin Peso X ML X Calibre -->

	<!-- 	Descuento con el cual jugar -->
	<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
		<div class="ibox-title">
			<h5>
				<i class="fa fa-arrows-v"></i> Pedido
			</h5>
		</div>
		<div class="ibox-content">
			<div class="row">
				<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
					<div >
						<label>Descuento Pesos</label>
					</div>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
					<h2 v-if="!editPedido">{{ configPedidoDescuento }}</h2>
					<div v-else>
						<input v-model="editConfigPedidoDescuento" type="text" placeholder="Descuento" class="form-control text-right" maxlength="8" oninput="this.value = this.value.replace(/[^0-9.\t]/g, '').replace(/(\..*)\./g, '$1');">
					</div>
				</div>
			</div>
		</div>
		<div class="ibox-footer">
			<span v-if="editPedido" class="pull-right">
				<button @click.prevent="guardarPedido" class="btn btn-success"> Guardar</button>
			</span>
			<button v-if="editPedido" @click.prevent="desactivarPedido" class="btn btn-warning">Cancelar</button>
			<button v-if="!editPedido" @click.prevent="activarPedido" class="btn btn-primary">Activar Edici&oacute;n</button>
			<div class="clearfix"></div>
		</div>
	</div>

<!-- 	Fin Descuento con el cual jugar -->


</div>

<div class="row">

	<!-- 	Descuento con el cual jugar -->
	<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
		<div class="ibox-title">
			<h5>
				<i class="fa fa-sliders"></i> Comisiones
			</h5>
		</div>
		<div class="ibox-content">
			<?php
			Form::row ();

			// Comision Alta
			Form::col ();
			Form::alignLabelCenter ();
			Form::setCols ( "l12|m12|s12|x12", "l12|m12|s12|x12", "l12|m12|s12|x12" );
			Form::label ( "configComisionAlta", "COMISION ALTA", "text-primary" );

			Form::alignLabelLeft ();
			Form::alignTextRight ();

			Form::endCol ();

			Form::col ("l3|m3|s12|x12");
					?>

					<div v-if="!editComisiones">
						<?php
						Form::labelH("h2", "configComision1Rango1", "Rango 1");
						?>
					</div>
					<div v-else>
						<?php
 						Form::text("editConfigComision1Rango1", "Rango 1", "8", false, false, "oninput=\"this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');\"" );
						?>
					</div>


					<?php
			Form::endCol();

			Form::col ( "l3|m3|s12|x12");
			?>

					<div v-if="!editComisiones">
						<?php
						Form::labelH("h2", "configComision1Rango2", "Rango 2");
						?>
					</div>
					<div v-else>
						<?php
							Form::text("editConfigComision1Rango2", "Rango 2", "8", false, false, "oninput=\"this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');\"" );
						?>
					</div>


			<?php
			Form::endCol();

			Form::col ( "l3|m3|s12|x12");
			?>

					<div v-if="!editComisiones">
						<?php
						Form::labelH("h2", "configComision1Rango3", "Rango 3");
						?>
					</div>
					<div v-else>
						<?php
							Form::text("editConfigComision1Rango3", "Rango 3", "8", false, false, "oninput=\"this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');\"" );
						?>
					</div>


			<?php
			Form::endCol();
			
			Form::col ( "l3|m3|s12|x12");
			?>

					<div v-if="!editComisiones">
						<?php
						Form::labelH("h2", "configComision1Rango4", "Rango 4");
						?>
					</div>
					<div v-else>
						<?php
							Form::text("editConfigComision1Rango4", "Rango 4", "8", false, false, "oninput=\"this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');\"" );
						?>
					</div>


			<?php
			Form::endCol();


			// Fin Comision Alta

			Form::line();

			// Comision Media
			Form::col ();
			Form::alignLabelCenter ();
			Form::setCols ( "l12|m12|s12|x12", "l12|m12|s12|x12", "l12|m12|s12|x12" );
			Form::label ( "configComisionMedia", "COMISION MEDIA", "text-primary" );

			Form::alignLabelLeft ();
			Form::alignTextRight ();

			Form::endCol ();

			Form::col ("l3|m3|s12|x12");
			?>

					<div v-if="!editComisiones">
						<?php
						Form::labelH("h2", "configComision2Rango1", "Rango 1");
						?>
					</div>
					<div v-else>
						<?php
 						Form::text("editConfigComision2Rango1", "Rango 1", "8", false, false, "oninput=\"this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');\"" );
						?>
					</div>


					<?php
			Form::endCol();

			Form::col ( "l3|m3|s12|x12");
			?>

					<div v-if="!editComisiones">
						<?php
						Form::labelH("h2", "configComision2Rango2", "Rango 2");
						?>
					</div>
					<div v-else>
						<?php
							Form::text("editConfigComision2Rango2", "Rango 2", "8", false, false, "oninput=\"this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');\"" );
						?>
					</div>


			<?php
			Form::endCol();

			Form::col ( "l3|m3|s12|x12");
			?>

					<div v-if="!editComisiones">
						<?php
						Form::labelH("h2", "configComision2Rango3", "Rango 3");
						?>
					</div>
					<div v-else>
						<?php
							Form::text("editConfigComision2Rango3", "Rango 3", "8", false, false, "oninput=\"this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');\"" );
						?>
					</div>


			<?php
			Form::endCol();
			
			Form::col ( "l3|m3|s12|x12");
			?>

					<div v-if="!editComisiones">
						<?php
						Form::labelH("h2", "configComision2Rango4", "Rango 4");
						?>
					</div>
					<div v-else>
						<?php
							Form::text("editConfigComision2Rango4", "Rango 4", "8", false, false, "oninput=\"this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');\"" );
						?>
					</div>


			<?php
			Form::endCol();


			// Fin Comision Media


			Form::line();

			// Comision Baja
			Form::col ();
			Form::alignLabelCenter ();
			Form::setCols ( "l12|m12|s12|x12", "l12|m12|s12|x12", "l12|m12|s12|x12" );
			Form::label ( "configComisionMedia", "COMISION BAJA", "text-primary" );

			Form::alignLabelLeft ();
			Form::alignTextRight ();

			Form::endCol ();

			Form::col ("l3|m3|s12|x12");
			?>

					<div v-if="!editComisiones">
						<?php
						Form::labelH("h2", "configComision3Rango1", "Rango 1");
						?>
					</div>
					<div v-else>
						<?php
 						Form::text("editConfigComision3Rango1", "Rango 1", "8", false, false, "oninput=\"this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');\"" );
						?>
					</div>


					<?php
			Form::endCol();

			Form::col ( "l3|m3|s12|x12");
			?>

					<div v-if="!editComisiones">
						<?php
						Form::labelH("h2", "configComision3Rango2", "Rango 2");
						?>
					</div>
					<div v-else>
						<?php
							Form::text("editConfigComision3Rango2", "Rango 2", "8", false, false, "oninput=\"this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');\"" );
						?>
					</div>


			<?php
			Form::endCol();

			Form::col ( "l3|m3|s12|x12");
			?>

					<div v-if="!editComisiones">
						<?php
						Form::labelH("h2", "configComision3Rango3", "Rango 3");
						?>
					</div>
					<div v-else>
						<?php
							Form::text("editConfigComision3Rango3", "Rango 3", "8", false, false, "oninput=\"this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');\"" );
						?>
					</div>


			<?php
			Form::endCol();
			
			Form::col ( "l3|m3|s12|x12");
			?>

					<div v-if="!editComisiones">
						<?php
						Form::labelH("h2", "configComision3Rango4", "Rango 4");
						?>
					</div>
					<div v-else>
						<?php
							Form::text("editConfigComision3Rango4", "Rango 4", "8", false, false, "oninput=\"this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');\"" );
						?>
					</div>


			<?php
			Form::endCol();

			//Fin Comision Media

			Form::endRow();

				?>


			<div v-show="errComisiones">

				<div  class="row m-b-xs m-t-xs">
					<div v-html="errComisiones" class="alert alert-danger"></div>
				</div>
				<div class="clearfix"></div>

			</div>

		</div>
		<div class="ibox-footer">
			<span v-if="editComisiones" class="pull-right">
				<button @click.prevent="guardarComisiones" class="btn btn-success"> Guardar</button>
			</span>
			<button v-if="editComisiones" @click.prevent="desactivarComisiones" class="btn btn-warning">Cancelar</button>
			<button v-if="!editComisiones" @click.prevent="activarComisiones" class="btn btn-primary">Activar Edici&oacute;n</button>
			<div class="clearfix"></div>
		</div>
	</div>

<!-- 	Fin Descuento con el cual jugar -->



	<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
		<div class="ibox-title">
			<h5>
				<i class="fa fa-crosshairs"></i> Rangos ML para Precios
			</h5>
<!-- 			<div class="ibox-tools"> -->
<!-- 				<a class="collapse-link"> <i class="fa fa-chevron-up"></i> -->
<!-- 				</a> <a class="dropdown-toggle" data-toggle="dropdown" href="#"> <i -->
<!-- 					class="fa fa-wrench"></i> -->
<!-- 				</a> -->
<!-- 				<ul class="dropdown-menu dropdown-user"> -->
<!-- 					<li><a href="#">Config option 1</a></li> -->
<!-- 					<li><a href="#">Config option 2</a></li> -->
<!-- 				</ul> -->
<!-- 				<a class="close-link"> <i class="fa fa-times"></i> -->
<!-- 				</a> -->
<!-- 			</div> -->
		</div>
		<div class="ibox-content">
			<?php
			Form::row ();

			// Rango 1
			Form::col ();
			Form::alignLabelCenter ();
			Form::setCols ( "l12|m12|s12|x12", "l12|m12|s12|x12", "l12|m12|s12|x12" );
			Form::label ( "configRangoM21", "Rango 1", "text-primary" );

			Form::alignLabelLeft ();
			Form::alignTextRight ();

			Form::endCol ();

			Form::col ( "l6|m6|s12|x12");
					?>

					<div >
						<?php
						Form::labelH("h2", "configRangoM21Inicio", "Inicio");
						?>
					</div>
<!-- 					<div v-else> -->
						<?php
// 						Form::text("editConfigRangoM21Inicio", "Inicio", "8", true, false, "oninput=\"this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');\"" );
						?>
<!-- 					</div> -->


					<?php
					Form::endCol();

					Form::col("l6|m6|s12|x12");
					?>

					<div v-show="!editRangoM2">
						<?php
						Form::labelH("h2", "configRangoM21Fin", "Fin");
						?>
					</div>
					<div v-show="editRangoM2">
						<?php
						Form::text("editConfigRangoM21Fin", "Fin", "8", true, false, "oninput=\"this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');\"" );
						?>
					</div>

					<?php
					Form::endCol();
					// Fin Rango 1

// 					Form::colnbsp();


					// Rango 2
					Form::line();

					Form::col();
					Form::alignLabelCenter();
					Form::setCols("l12|m12|s12|x12", "l12|m12|s12|x12", "l12|m12|s12|x12");
					Form::label("configRangoM22","Rango 2");

					Form::alignLabelLeft();
					Form::alignTextRight();

					Form::endCol();



					Form::col("l6|m6|s12|x12");

					?>

					<div v-if="!editRangoM2">
						<?php
						Form::labelH("h2", "configRangoM22Inicio", "Inicio");
						?>
					</div>
					<div v-else>
						<?php
						Form::text("editConfigRangoM22Inicio", "Inicio", "8", true, false, "oninput=\"this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');\"" );
						?>
					</div>

					<?php
					Form::endCol();

					Form::col("l6|m6|s12|x12");
					?>

					<div v-if="!editRangoM2">
						<?php
						Form::labelH("h2", "configRangoM22Fin", "Fin");
						?>
					</div>
					<div v-else>
						<?php
						Form::text("editConfigRangoM22Fin", "Fin", "8", true, false, "oninput=\"this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');\"" );
						?>
					</div>

					<?php
					Form::endCol();
					// Fin Rango 2

// 					Form::colnbsp();

					// Rango 3
					Form::line();

					Form::col();
					Form::alignLabelCenter();
					Form::setCols("l12|m12|s12|x12", "l12|m12|s12|x12", "l12|m12|s12|x12");
					Form::label("configRangoM23","Rango 3");

					Form::alignLabelLeft();
					Form::alignTextRight();

					Form::endCol();

					Form::col("l6|m6|s12|x12");
					?>

					<div v-if="!editRangoM2">
						<?php
						Form::labelH("h2", "configRangoM23Inicio", "Inicio");
						?>
					</div>
					<div v-else>
						<?php
						Form::text("editConfigRangoM23Inicio", "Inicio", "8", true, false, "oninput=\"this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');\"" );
						?>
					</div>


					<?php
					Form::endCol();

					Form::col("l6|m6|s12|x12");
					?>

					<div >
						<label class="control-label">Fin</label>
						<h3><i class="fa fa-arrow-right"></i></h3>

					</div>
<!-- 					<div v-else> -->
						<?php
						//Form::text("editConfigRangoM23Fin", "Fin", "8", true, false, "oninput=\"this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');\"" );
						?>
<!-- 					</div>					 -->

					<?php
					Form::endCol();
					// Fin Rango 3

// 					Form::colnbsp();
					Form::line();

// 					Form::col();
// 					Form::buttonPrimary("Guardar", "guardarRangoM2", "", " pull-right", "l12");
// 					Form::endCol();


					Form::endRow();

				?>

		</div>
		<div class="ibox-footer">
			<span v-if="editRangoM2" class="pull-right">
				<button @click.prevent="guardarRangoM2" class="btn btn-success"> Guardar</button>
			</span>
			<button v-if="editRangoM2" @click.prevent="desactivarEdicionRangoM2" class="btn btn-warning">Cancelar</button>
			<button v-if="!editRangoM2" @click.prevent="activarEdicionRangoM2" class="btn btn-primary">Activar Edici&oacute;n</button>
			<div class="clearfix"></div>
		</div>
	</div>

    <!-- Rangos AcryOpa -->
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
		<div class="ibox-title">
			<h5>
				<i class="fa fa-crosshairs"></i> Rangos ML Acrylit Opalit para Precios
			</h5>

		</div>
		<div class="ibox-content">
			<?php
			Form::row ();

			// Rango 1
			Form::col ();
			Form::alignLabelCenter ();
			Form::setCols ( "l12|m12|s12|x12", "l12|m12|s12|x12", "l12|m12|s12|x12" );
			Form::label ( "configRangoAcryOpa1", "Rango 1", "text-primary" );

			Form::alignLabelLeft ();
			Form::alignTextRight ();

			Form::endCol ();

			Form::col ( "l6|m6|s12|x12");
					?>

					<div >
						<?php
						Form::labelH("h2", "configRangoAcryOpa1Inicio", "Inicio");
						?>
					</div>
<!-- 					<div v-else> -->
						<?php
// 						Form::text("editConfigRangoM21Inicio", "Inicio", "8", true, false, "oninput=\"this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');\"" );
						?>
<!-- 					</div> -->


					<?php
					Form::endCol();

					Form::col("l6|m6|s12|x12");
					?>

					<div v-if="!editRangoAcryOpa">
						<?php
						Form::labelH("h2", "configRangoAcryOpa1Fin", "Fin");
						?>
					</div>
					<div v-else>
						<?php
						Form::text("editConfigRangoAcryOpa1Fin", "Fin", "8", true, false, "oninput=\"this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');\"" );
						?>
					</div>

					<?php
					Form::endCol();
					// Fin Rango 1

// 					Form::colnbsp();


					// Rango 2
					Form::line();

					Form::col();
					Form::alignLabelCenter();
					Form::setCols("l12|m12|s12|x12", "l12|m12|s12|x12", "l12|m12|s12|x12");
					Form::label("configRangoAcryOpa2","Rango 2");

					Form::alignLabelLeft();
					Form::alignTextRight();

					Form::endCol();



					Form::col("l6|m6|s12|x12");

					?>

					<div v-if="!editRangoAcryOpa">
						<?php
						Form::labelH("h2", "configRangoAcryOpa2Inicio", "Inicio");
						?>
					</div>
					<div v-else>
						<?php
						Form::text("editConfigRangoAcryOpa2Inicio", "Inicio", "8", true, false, "oninput=\"this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');\"" );
						?>
					</div>

					<?php
					Form::endCol();

					Form::col("l6|m6|s12|x12");
					?>

					<div v-if="!editRangoAcryOpa">
						<?php
						Form::labelH("h2", "configRangoAcryOpa2Fin", "Fin");
						?>
					</div>
					<div v-else>
						<?php
						Form::text("editConfigRangoAcryOpa2Fin", "Fin", "8", true, false, "oninput=\"this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');\"" );
						?>
					</div>

					<?php
					Form::endCol();
					// Fin Rango 2

// 					Form::colnbsp();

					// Rango 3
					Form::line();

					Form::col();
					Form::alignLabelCenter();
					Form::setCols("l12|m12|s12|x12", "l12|m12|s12|x12", "l12|m12|s12|x12");
					Form::label("configRangoAcryOpa3","Rango 3");

					Form::alignLabelLeft();
					Form::alignTextRight();

					Form::endCol();

					Form::col("l6|m6|s12|x12");
					?>

					<div v-if="!editRangoAcryOpa">
						<?php
						Form::labelH("h2", "configRangoAcryOpa3Inicio", "Inicio");
						?>
					</div>
					<div v-else>
						<?php
						Form::text("editConfigRangoAcryOpa3Inicio", "Inicio", "8", true, false, "oninput=\"this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');\"" );
						?>
					</div>


					<?php
					Form::endCol();

					Form::col("l6|m6|s12|x12");
					?>

					<div >
						<label class="control-label">Fin</label>
						<h3><i class="fa fa-arrow-right"></i></h3>

					</div>
<!-- 					<div v-else> -->
						<?php
						//Form::text("editConfigRangoM23Fin", "Fin", "8", true, false, "oninput=\"this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');\"" );
						?>
<!-- 					</div>					 -->

					<?php
					Form::endCol();
					// Fin Rango 3

// 					Form::colnbsp();
					Form::line();

// 					Form::col();
// 					Form::buttonPrimary("Guardar", "guardarRangoM2", "", " pull-right", "l12");
// 					Form::endCol();


					Form::endRow();

				?>

		</div>
		<div class="ibox-footer">
			<span v-if="editRangoAcryOpa" class="pull-right">
				<button @click.prevent="guardarRangoAcryOpa" class="btn btn-success"> Guardar</button>
			</span>
			<button v-if="editRangoAcryOpa" @click.prevent="desactivarEdicionRangoAcryOpa" class="btn btn-warning">Cancelar</button>
			<button v-if="!editRangoAcryOpa" @click.prevent="activarEdicionRangoAcryOpa" class="btn btn-primary">Activar Edici&oacute;n</button>
			<div class="clearfix"></div>
		</div>
	</div>
    <!-- Fin Rangos AcryOpa -->

    <!-- Rangos Multipanel -->
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
		<div class="ibox-title">
			<h5>
				<i class="fa fa-crosshairs"></i> Rangos ML Multipanel para Precios
			</h5>

		</div>
		<div class="ibox-content">
			<?php
			Form::row ();

			// Rango 1
			Form::col ();
			Form::alignLabelCenter ();
			Form::setCols ( "l12|m12|s12|x12", "l12|m12|s12|x12", "l12|m12|s12|x12" );
			Form::label ( "configRangoMultipanel1", "Rango 1", "text-primary" );

			Form::alignLabelLeft ();
			Form::alignTextRight ();

			Form::endCol ();

			Form::col ( "l6|m6|s12|x12");
					?>

					<div >
						<?php
						Form::labelH("h2", "configRangoMultipanel1Inicio", "Inicio");
						?>
					</div>
<!-- 					<div v-else> -->
						<?php
// 						Form::text("editConfigRangoM21Inicio", "Inicio", "8", true, false, "oninput=\"this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');\"" );
						?>
<!-- 					</div> -->


					<?php
					Form::endCol();

					Form::col("l6|m6|s12|x12");
					?>

					<div v-if="!editRangoMultipanel">
						<?php
						Form::labelH("h2", "configRangoMultipanel1Fin", "Fin");
						?>
					</div>
					<div v-else>
						<?php
						Form::text("editConfigRangoMultipanel1Fin", "Fin", "8", true, false, "oninput=\"this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');\"" );
						?>
					</div>

					<?php
					Form::endCol();
					// Fin Rango 1

// 					Form::colnbsp();


					// Rango 2
					Form::line();

					Form::col();
					Form::alignLabelCenter();
					Form::setCols("l12|m12|s12|x12", "l12|m12|s12|x12", "l12|m12|s12|x12");
					Form::label("configRangoMultipanel2","Rango 2");

					Form::alignLabelLeft();
					Form::alignTextRight();

					Form::endCol();



					Form::col("l6|m6|s12|x12");

					?>

					<div v-if="!editRangoMultipanel">
						<?php
						Form::labelH("h2", "configRangoMultipanel2Inicio", "Inicio");
						?>
					</div>
					<div v-else>
						<?php
						Form::text("editConfigRangoMultipanel2Inicio", "Inicio", "8", true, false, "oninput=\"this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');\"" );
						?>
					</div>

					<?php
					Form::endCol();

					Form::col("l6|m6|s12|x12");
					?>

					<div v-if="!editRangoMultipanel">
						<?php
						Form::labelH("h2", "configRangoMultipanel2Fin", "Fin");
						?>
					</div>
					<div v-else>
						<?php
						Form::text("editConfigRangoMultipanel2Fin", "Fin", "8", true, false, "oninput=\"this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');\"" );
						?>
					</div>

					<?php
					Form::endCol();
					// Fin Rango 2

// 					Form::colnbsp();

					// Rango 3
					Form::line();

					Form::col();
					Form::alignLabelCenter();
					Form::setCols("l12|m12|s12|x12", "l12|m12|s12|x12", "l12|m12|s12|x12");
					Form::label("configRangoMultipanel3","Rango 3");

					Form::alignLabelLeft();
					Form::alignTextRight();

					Form::endCol();

					Form::col("l6|m6|s12|x12");
					?>

					<div v-if="!editRangoMultipanel">
						<?php
						Form::labelH("h2", "configRangoMultipanel3Inicio", "Inicio");
						?>
					</div>
					<div v-else>
						<?php
						Form::text("editConfigRangoMultipanel3Inicio", "Inicio", "8", true, false, "oninput=\"this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');\"" );
						?>
					</div>


					<?php
					Form::endCol();

					Form::col("l6|m6|s12|x12");
					?>

					<div >
						<label class="control-label">Fin</label>
						<h3><i class="fa fa-arrow-right"></i></h3>

					</div>
<!-- 					<div v-else> -->
						<?php
						//Form::text("editConfigRangoM23Fin", "Fin", "8", true, false, "oninput=\"this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');\"" );
						?>
<!-- 					</div>					 -->

					<?php
					Form::endCol();
					// Fin Rango 3

// 					Form::colnbsp();
					Form::line();

// 					Form::col();
// 					Form::buttonPrimary("Guardar", "guardarRangoM2", "", " pull-right", "l12");
// 					Form::endCol();


					Form::endRow();

				?>

		</div>
		<div class="ibox-footer">
			<span v-if="editRangoMultipanel" class="pull-right">
				<button @click.prevent="guardarRangoMultipanel" class="btn btn-success"> Guardar</button>
			</span>
			<button v-if="editRangoMultipanel" @click.prevent="desactivarEdicionRangoMultipanel" class="btn btn-warning">Cancelar</button>
			<button v-if="!editRangoMultipanel" @click.prevent="activarEdicionRangoMultipanel" class="btn btn-primary">Activar Edici&oacute;n</button>
			<div class="clearfix"></div>
		</div>
	</div>
    <!-- Fin Rangos Multipanel -->


</div>


<!--
<pre>
{{ $data  }}
</pre> -->
