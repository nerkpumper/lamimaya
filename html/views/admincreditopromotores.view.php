<?php
$titlePage = "Cr&eacute;dito a Promotores";
$breadCum = "Promotores/Cr&eacute;dito a Promotores";
$_lugar = LUGAR_ADMINISTRACION_CREDITOPROMOTORES;

?>

<div class="modal inmodal fade" id="modalSetCredito" tabindex="-1"
	role="dialog" aria-hidden="true">
	<div class="modal-dialog ">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
				</button>
				<h4 class="modal-title">Indique Cr&eacute;dito a asignar al Promotor</h4>
				<h3>{{ promotorSeleccionado }}</h3>
<!-- 				<small class="font-bold"></small> -->
<!-- 				<br> -->
<!-- 				<small class="font-bold"></small> -->
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
						
							<input type="text"
								v-model="creditoAAsignar"								
								maxlength="8" oninput="this.value = this.value.replace(/[^0-9.\t]/g, '').replace(/(\..*)\./g, '$1');" 
								class="form-control text-right">
							<label v-if="creditoAAsignar == ''" class="text-danger">Ingrese Cantidad</label>
						
					</div>
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						&nbsp;
					</div>				
										
					<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
						<button @click.prevent="saveCreditoPromotor" class="btn btn-success"> Asignar</button>
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


<!-- Buscar Promotor -->
<div v-show="seleccionandoPromotor">

	<div v-show="idPromotor > 0" >
		<button @click.prevent="dejarPromotor" class="btn btn-warning">Conservar este Promotor</button>
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
<!-- 							<h4>{{ empresa }}</h4> -->
<!-- 							<small> {{ domicilio1}} {{ domicilio2 }} </small> <br> <small> {{ telefonos }} </small> -->
						</div>
					</div>
				</div>
			</div>			

		</div>
	</div>


	<div class="panel-rec">
		<h3>Seleccione Promotor</h3>
		<div class="row">
			<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
				<input type="text" class="form-control"	v-model="filtroNombrePromotor"	 		
		 		placeholder="filtrar">
			</div>			
		</div>
		
		<br>
		
	
	
		<div class="table-responsive">
			<table class="table table-bordered table-striped table-hover">
				<thead>
					<th>Promotor</th>
					<th>Usuario</th>					
					<th>Cr&eacute;dito</th>
					<th>Debe</th>
					<th>Disponible</th>
					<th></th>
				</thead>
				<tbody>
					<tr v-for="(pro, index) in promotoresFiltradosPorNombre">
<!-- 						<td class="client-avatar"><img alt="image" src="img/a2.jpg"></td> -->
						<td><a data-toggle="tab" href="#contact-1" class="client-link">{{ pro.nombre }}</a></td>
						<td>{{ pro.username }}</td>						
						<td><h3 class="text-navy text-right">{{ pro.credito }}</h3></td>
						<td><h3 class="text-danger  text-right">{{ pro.usado }}</h3></td>
						<td><h3 class="text-success  text-right">{{ pro.disponible }}</h3></td>
						<td class="client-status"><button @click.prevent="setearCreditoAPromotor(index)" class="btn btn-primary btn-xs">Asignar Cr&eacute;dito</button></td>
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


<?php Form::frmExportarExcel();?>

<!-- <form action=" -->
<?php //echo URL_BASE;?>
<!-- reporteadorbytabla" method="post" target="_blank" id="FormularioExportacion"> -->
<!-- 	<input type="hidden" id="ptituloReporte" name="ptituloReporte" /> -->
<!-- 	<input type="hidden" id="psubTituloReporte" name="psubTituloReporte"/> -->
<!-- 	<input type="hidden" id="pexcluir" name="pexcluir"/> -->
<!-- 	<input type="hidden" id="pnombreReporte" name="pnombreReporte"/> -->

<!-- 	<input type="hidden" id="pTableHeader" name="pTableHeader" />     -->
<!-- 	<input type="hidden" id="pTableBody" name="pTableBody" /> -->
<!-- </form> -->


<!-- <pre>{{ $data }}</pre> -->
<!-- <pre>{{ $data.pedidos }}</pre> -->