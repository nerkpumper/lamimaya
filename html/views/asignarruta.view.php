<?php
// $_showPageHeading = false;

$titlePage = "Asignar Rutas";
$breadCum = "Rutas/Asignar Rutas";
$_lugar = LUGAR_RUTAS_RUTASENVIO;

$_addScript="
		<script src=\"".URL_BASE."assets/inspinia/js/plugins/iCheck/icheck.min.js\"></script>
		
			";
// <link href='".URL_BASE."assets/inspinia/css/plugins/steps/jquery.steps.css' rel='stylesheet'>
$_addHead = "
	
	<link href=\"".URL_BASE."assets/inspinia/css/plugins/iCheck/custom.css\" rel=\"stylesheet\">

    <style>
        .post{
	position:relative;
  margin:1.5em;
	padding:10px 20px;
	background:#f8f8f8;
	-moz-border-radius:10px;
	-webkit-border-radius:10px;
	border-radius:5px;
	width:auto;
	border:1px solid #e8e8e8;
	margin-bottom:20px;
  text-align:center;
	}

.nrkcalendar{
	top:0em;
  left:1em;
	padding-top:5px;
	width:80px;
	background:#ededef;
	background: -webkit-gradient(linear, left top, left bottom, from(#ededef), to(#ccc)); 
	background: -moz-linear-gradient(top,  #ededef,  #ccc); 
	font:bold 30px/60px \"Lucida Sans Unicode\", Arial Black, Arial, Helvetica, sans-serif;
	text-align:center;
	color:#000;
  
	text-shadow:#fff 0 1px 0;	
	-moz-border-radius:3px;
	-webkit-border-radius:3px;
	border-radius:3px;	
	position:relative;
	-moz-box-shadow:0 2px 2px #888;
	-webkit-box-shadow:0 2px 2px #888;
	box-shadow:0 2px 2px #888;
	}


.nrkcalendar em{
	display:block;
	font:12px/30px \"Lucida Sans Unicode\", Arial, Helvetica, sans-serif;
	color:#fff;
	text-shadow:#00365a 0 -1px 0;	
	background:#ff2200;
	background:-webkit-gradient(linear, left top, left bottom, from(#ff2200), to(#ff0000)); 
	background:-moz-linear-gradient(top,  #ff2200,  #ff0000); 
	-moz-border-radius-bottomright:3px;
	-webkit-border-bottom-right-radius:3px;	
	border-bottom-right-radius:3px;
	-moz-border-radius-bottomleft:3px;
	-webkit-border-bottom-left-radius:3px;	
	border-bottom-left-radius:3px;	
	border-top:1px solid #ff2200;
	}

    .nrkcalendar em2{
	display:block;
	font:12px/40px \"Lucida Sans Unicode\", Arial, Helvetica, sans-serif;
	color:#000000;
	text-shadow:#00365a 0 -1px 0;	
    
	
	}

.nrkcalendar:before, .nrkcalendar:after{
	content:'';
	float:left;
	position:absolute;
	top:5px;	
	width:8px;
	height:8px;
	background:#111;
	z-index:1;
	-moz-border-radius:10px;
	-webkit-border-radius:10px;
	border-radius:10px;
	-moz-box-shadow:0 1px 1px #fff;
	-webkit-box-shadow:0 1px 1px #fff;
	box-shadow:0 1px 1px #fff;
	}
.nrkcalendar:before{left:11px;}	
.nrkcalendar:after{right:11px;}

.nrkcalendar em:before, .nrkcalendar em:after{
	content:'';
	float:left;
	position:absolute;
	top:-5px;	
	width:4px;
	height:14px;
	background:#dadada;
	background:-webkit-gradient(linear, left top, left bottom, from(#f1f1f1), to(#aaa)); 
	background:-moz-linear-gradient(top,  #f1f1f1,  #aaa); 
	z-index:2;
	-moz-border-radius:2px;
	-webkit-border-radius:2px;
	border-radius:2px;
	}
.nrkcalendar em:before{left:13px;}	
.nrkcalendar em:after{right:13px;}	

.nrkcalendar2{
	top:1em;
  left:1em;
	padding-top:5px;
	width:80px;
	


	font:bold 30px/60px \"Lucida Sans Unicode\", Arial Black, Arial, Helvetica, sans-serif;
	text-align:center;
	color:#000;
  
	text-shadow:#fff 0 1px 0;	
	-moz-border-radius:3px;
	-webkit-border-radius:3px;
	border-radius:3px;	
	position:relative;
	-moz-box-shadow:0 2px 2px #888;
	-webkit-box-shadow:0 2px 2px #888;
	box-shadow:0 2px 2px #888;
	cursor: pointer;
	}	


    .nrkcalendar2 em2{
	display:block;
	font:12px/20px \"Lucida Sans Unicode\", Arial, Helvetica, sans-serif;
	color:#000000;
	text-shadow:#00365a 0 -1px 0;	
    
	
	}

body {
  font-family: sans-serif;
  font-weight: 100;
  --grey-100: #e4e9f0;
  --grey-200: #cfd7e3;
  --grey-300: #b5c0cd;
  --grey-800: #3e4e63;
  --grid-gap: 1px;
  --day-label-size: 20px;
}



	ol,
li {
  padding: 0;
  margin: 0;
  list-style: none;
}

.calendar-month {
  position: relative;
  background-color: var(--grey-200);
  border: solid 1px var(--grey-200);
}

.calendar-month-header {
  display: flex;
  justify-content: space-between;  
  padding: 10px;
  color: #fff;
  background:#7B77FF;
	background:-webkit-gradient(linear, left top, left bottom, from(#7B77FF), to(#1411FF)); 
	background:-moz-linear-gradient(top,  #7B77FF,  #1411FF); 
}

.calendar-month-header-selected-month {
  font-size: 24px;
  font-weight: 600;
}

.calendar-month-header-selectors {
  display: flex;
  align-items: center;
  justify-content: space-between;
  width: 80px;
}

.calendar-month-header-selectors > * {
  cursor: pointer;
}

.day-of-week {
  color: var(--grey-800);
  font-size: 18px;
  background-color: #fff;
  padding-bottom: 5px;
  padding-top: 10px;

  color: #fff;
  background:#7B77FF;
	background:-webkit-gradient(linear, left top, left bottom, from(#7B77FF), to(#1411FF)); 
	background:-moz-linear-gradient(top,  #7B77FF,  #1411FF); 
}

.day-of-week,
.days-grid {
  display: grid;
  grid-template-columns: repeat(7, 1fr);
}

.day-of-week > * {
  text-align: right;
  padding-right: 5px;
}

.days-grid {
  height: 100%;
  position: relative;
  grid-column-gap: var(--grid-gap);
  grid-row-gap: var(--grid-gap);
  border-top: solid 1px var(--grey-200);
}

.calendar-day {
  position: relative;
  min-height: 100px;
  font-size: 16px;
  background-color: #fff;
  color: var(--grey-800);
  padding: 5px;
  
}

.calendar-day .events{  
  padding-top: 30px;
	
}

.calendar-day > .daynum {
  display: flex;
  justify-content: center;
  align-items: center;
  position: absolute;
  right: 2px;
  width: var(--day-label-size);
  height: var(--day-label-size);
  cursor: pointer;
  font-size: 14px;
  font-weight: 150;
}



    
    </style>
";


?>

<!-- <div class="post"> -->
  <!-- <img src="http://cssglobe.com/lab/nrkcalendar/scheme.gif"> -->
<!-- <p class="nrkcalendar">7 <em>septiembre</em></p> -->

    <!-- </div>  -->

<!-- <pre>
	{{ $data.calendario}}
</pre> -->

<!-- <pre>
	{{ $data.rutas}}
</pre> -->
<!-- 
<pre>
	{{ $data.pedidos }}
</pre> -->

<!-- <pre>
	{{ $data.vehiculos }}
</pre> -->

<!-- <pre>
	{{ $data.rutaenviodetalle }}
</pre> -->

<!-- <pre>
	{{ $data.vehiculosParaEnviar }}
</pre> -->

<!-- <pre>
	{{ $data.rutasenviomes }}
</pre> -->

<!-- <pre>
	{{ $data.vehiculos }}
</pre> -->

<!-- <pre>
	{{ $data.vehiculoRegreso }}
</pre> -->




<div class="modal inmodal fade" id="mdlAsignarVehiculos" tabindex="-1" role="dialog"  aria-hidden="true">
<!-- <div>	 -->
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title">Asignar Veh&iacute;culos
					<button class="btn btn-rounded m-l-lg " :class="envioRutaStep >= 1 ? 'btn-primary' : 'btn-white' " type="button"><i class="fa fa-truck"></i> Trasporte</button>
					<button class="btn btn-rounded " :class="envioRutaStep >= 2  ? 'btn-primary' : 'btn-white' " type="button"><i class="fa fa-sort-numeric-asc"></i> Acomodo</button>
					<button class="btn btn-rounded " :class="envioRutaStep == 3 ? 'btn-primary' : 'btn-white' " type="button"><i class="fa fa-check"></i> Confirmar</button>
				</h4>
				<!-- <small class="font-bold">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</small> -->
			</div>
			<div class="modal-body">
				<!-- <div class="btn-group"> -->
					<!-- <button class="btn btn-rounded " :class="envioRutaStep >= 1 ? 'btn-primary' : 'btn-white' " type="button">1. Trasporte</button>
					<button class="btn btn-rounded " :class="envioRutaStep >= 2  ? 'btn-primary' : 'btn-white' " type="button">2. Acomodo</button>
					<button class="btn btn-rounded " :class="envioRutaStep == 3 ? 'btn-primary' : 'btn-white' " type="button">3. Confirmar</button> -->
				<!-- </div> -->
				<div class=" m-t-xs">
					<div v-show="envioRutaStep == 1">
						<form class="form-horizontal">
							
							<table class="table table-bordered">
								<thead>
									<tr>
										<th></th>
										<th>Transporte</th>
										<th>km Inicial</th>										
									</tr>
								</thead>
								<tbody>
									<tr v-for="ve in vehiculos">
									
										<td><input v-show="ve.estatus == '' || ve.estatus == 'ASIGNADO'" type="checkbox" value="" name="" class="i-checks" v-model="ve.selected"/></td>
										<td>{{ ve.placa }} : {{ ve.descripcion }}</td>										
										<td>
											<!--<input v-show="ve.selected && (ve.estatus == '' || ve.estatus == 'ASIGNADO')" type="text"
												v-model="ve.km" placeholder=""
												oninput="this.value = this.value.replace(/[^0-9\t]/g, '').replace(/(\..*)\./g, '$1');"
												maxlength="9" class="form-control">
											<span v-show="ve.estatus =='ENRUTA' || ve.estatus == 'COMPLETADO'" 
													class="">{{ ve.km }}</span>
											<span v-show="ve.selected && (ve.km == '0' || ve.km == '' || parseInt(ve.km) == 0)" 
													class="text-danger">Ingrese kilometraje</span>-->

											<span  
													class="text-info">Kilometraje Inicial ser&aacute; solicitado al enviar el Transporte</span>													
										</td>
									</tr>								
								</tbody>
							</table>

						
						</form>
					</div>
					<div v-show="envioRutaStep == 2">
						<div class="row">
							<div class="col-md-6">								
								<div class="ibox">
									<div class="ibox-content ibox-heading">
										<span v-show="idVehiculoSelected == 0" class="text-danger">
											<h5>Seleccione un tranporte para asignar el Vale</h5>
										</span>
										<span v-show="idVehiculoSelected > 0">
											<h5>Seleccione un Vale para asignar al Veh&iacute;culo</h5>
										</span>
									</div>
									<div class="ibox-content">
										<div class="feed-activity-list">

											<div v-for="(red, index) in rutaenviodetalle" v-show="red.vehiculoAsignado == 0" class="feed-element">
												<div>
													<!-- <small class="pull-right text-navy">1m ago</small> -->
													<strong>VS {{ red.idValeSalida}}: P {{ red.idPedido }}</strong> {{ red.cliente }}
													<div>{{ red.domicilioEntrega }} {{ red.numeroEntrega }} {{ red.coloniaEntrega }} {{ red.ciudadEntrega }}</div>
													<small class="text-muted">
														<i class="fa fa-info-circle"></i> Max ML: {{ red.maxml }}
														<i class="fa fa-info-circle"></i> Total KG: {{ red.maxkg }}
														<!-- <i class="fa fa-info-circle"></i> Estado: <span  class="label label-primary">{{ red.estado }}</span> -->
													</small>
													
													<button v-show="red.listoParaSalir == 'SI' && idVehiculoSelected > 0"               								 
														class="pull-right btn btn-xs btn-primary"
														@click.prevent="asignarVSaVehiculo(index)"><i class="fa fa-arrow-right"></i>
													</button>
													<span class="text-danger" v-show="red.listoParaSalir == 'NO'"><br>** Este Vale de Salida deber&aacute; ser reasignado a otra Ruta, no esta Autorizado para salir.</span>
													
												</div>
											</div>

											

										</div>
									</div>
								</div>
							</div>
							<div class="col-md-6">

								<div class="ibox">
									<div class="ibox-content ibox-heading">
										<select class="form-control" v-model="idVehiculoSelected"> 
											<option value="0">-- Seleccione Transporte --</option>
											<option v-for="ve in vehiculos" v-show="ve.selected" :value="ve.id">{{ ve.placa }} : {{ ve.descripcion }}</option>

										</select>
									</div>
									<div class="ibox-content">
										<div class="feed-activity-list">

											<div v-for="(red, index) in valesEnVehiculo" class="feed-element">
												<div>
													<!-- <small class="pull-right text-navy">1m ago</small> -->
													<strong>VS {{ red.idValeSalida}}: P {{ red.idPedido }}</strong> {{ red.cliente }}
													<div>{{ red.domicilioEntrega }} {{ red.numeroEntrega }} {{ red.coloniaEntrega }} {{ red.ciudadEntrega }}</div>
													<small class="text-muted">
														<i class="fa fa-info-circle"></i> Max ML: {{ red.maxml }}
														<i class="fa fa-info-circle"></i> Total KG: {{ red.maxkg }}
														<!-- <i class="fa fa-info-circle"></i> Estado: <span  class="label label-primary">{{ red.estado }}</span> -->
													</small>
													<br>
													<!-- v-show="red.idRutaEnvioVehiculo == 0" -->
													<button 
														
														class="btn btn-xs btn-danger"
														@click.prevent="desAsignarVSaVehiculo(red.idRutaEnvioDetalle)"><i class="fa fa-arrow-left"></i>
													</button>
													<span class="text-danger" v-show="red.listoParaSalir == 'NO'"><br>** Este Vale de Salida deber&aacute; ser reasignado a otra Ruta, no esta Autorizado para salir.</span>
													
												</div>
											</div>

											

										</div>
									</div>
								</div>

							</div>
						</div>
					</div>
					<div v-show="envioRutaStep == 3">
						<div class="ibox">
							<div class="ibox-content">
								<div class="panel-group" id="accordion">
									<div v-for="(ve, index) in vehiculos" v-show="ve.selected" class="panel panel-default">
										<div class="panel-heading">
											<h5 class="panel-title">
												<i class="fa fa-truck"></i> <a data-toggle="collapse" data-parent="#accordion" :href="'#collapse' + index">{{ ve.placa }} - {{ ve.descripcion }} <span class="pull-right"> {{ formatNumber(ve.maxml) }} Max ML : {{ formatNumber(ve.kg) }} Kg</span></a>
											</h5>
										</div>
										<div :id="'collapse' + index" class="panel-collapse collapse ">
											<div class="panel-body">
												<div v-for="(red, index) in ve.vs" :id="red.key" class="vote-item">
													<div class="row">
														<div class="col-md-10">
															<div class="vote-actions">
																<a @click.prevent="ordenMenos(index)" v-show="false && index > 0 && blnPuedeAsignarPedidos" href="#">
																	<i class="fa fa-chevron-up"> </i>
																</a>
																<div>{{ index + 1 }}</div>
																<a @click.prevent="ordenMas(index)" v-show="false && index < (rutaenviodetalle.length - 1) && blnPuedeAsignarPedidos" href="#">
																	<i class="fa fa-chevron-down"> </i>
																</a>
															</div>
															<a href="#" class="vote-title">
																<strong class="text-navy">VS {{ red.idValeSalida}}: P {{ red.idPedido }}</strong> {{ red.cliente }}
															</a>
															<a href="#" class="vote-title2 m-l-lg">
																{{ red.domicilioEntrega }} {{ red.numeroEntrega }} {{ red.coloniaEntrega }} {{ red.ciudadEntrega }}
															</a>
															<div class="m-l-lg">
																<i class="fa fa-info-circle"></i> Max ML: {{ red.maxml }}
																<i class="fa fa-info-circle"></i> Total KG: {{ red.maxkg }}
																<!-- <i class="fa fa-info-circle"></i> Estado:  -->
																		<!-- <span v-show="red.estado == 'TERMINADO'" class="label label-primary">{{ red.estado }}</span> -->
																		<!-- <span v-show="red.estado != 'TERMINADO'" class="label label-danger">{{ red.estado }}</span>   										                                      -->
																		<!-- <span  class="label label-primary">{{ red.estado }}</span> -->
															</div>
															<span class="text-danger" v-show="red.listoParaSalir == 'NO'">** El Vale de Salida debe estar Autorizado para Salir para cuando envie esta ruta, de lo contrario, deber&aacute; reasignarlo a otra.</span>
														</div>
														<div class="col-md-2 ">
															<div class="vote-icon">
																<!-- <i class="fa fa-github"> </i> -->
																<!-- <button v-show="blnPuedeAsignarPedidos" @click.prevent="desAsignarPedidoDeRuta(red.idPedido, red.idRutaEnvioDetalle, red.key, index)" class="btn btn-danger btn-xs"><i class="fa fa-times"></i></button> -->
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
						
					</div>
				</div>				
				<!-- <div> -->
					<!-- <button :disabled="!(envioRutaStep == 3)" class="btn btn-primary pull-right m-l-xs">Enviar</button>
					<button :disabled="!(envioRutaStep < 3)" @click.prevent="envioRutaSiguiente" class="btn btn-primary pull-right m-l-xs">Siguiente</button>
					<button :disabled="!(envioRutaStep > 1)" @click.prevent="envioRutaStep--" class="btn btn-primary pull-right">Anterior</button> -->
					<!-- <div class="clearfix"></div> -->
				<!-- </div> -->

				<div>
					<span v-show="msgModalEnvio" class="alert alert-danger">
						{{ msgModalEnvio }}
					</span>
				</div>
				
			</div>

			<div class="modal-footer">
				<button :disabled="!(envioRutaStep == 3)" @click.prevent="asignarVehiculos" class="btn btn-primary pull-right m-l-xs">Asignar</button>
					<button :disabled="!(envioRutaStep < 3)" @click.prevent="prepareAsignarVehiculosSiguiente" class="btn btn-primary pull-right m-l-xs">Siguiente</button>
					<button :disabled="!(envioRutaStep > 1)" @click.prevent="envioRutaStep--" class="btn btn-primary pull-right">Anterior</button>
				<!-- <button type="button" class="btn btn-white" data-dismiss="modal">Close</button> -->
				<!-- <button type="button" class="btn btn-primary">Save changes</button> -->
			</div>
		</div>
	</div>
</div>

<!-- Ruta -->
<div class="modal inmodal fade" id="mdlVerRuta" tabindex="-1" role="dialog"  aria-hidden="true">
<!-- <div> -->
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title">Ruta
					
				</h4>
				<!-- <small class="font-bold">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</small> -->
			</div>
			<div class="modal-body">
				<div class="ibox">
					<div class="ibox-content">						
						<img :src="'<?php echo URL_BASE; ?>img/rutas/' + idRutaShow + '.png'" style="width: 800px"/>
					</div>
				</div>
				
			</div>

			<!-- <div class="modal-footer">
				<button :disabled="!(envioRutaStep == 3)" @click.prevent="asignarVehiculos" class="btn btn-primary pull-right m-l-xs">Enviar</button>
					<button :disabled="!(envioRutaStep < 3)" @click.prevent="prepareAsignarVehiculosSiguiente" class="btn btn-primary pull-right m-l-xs">Siguiente</button>
					<button :disabled="!(envioRutaStep > 1)" @click.prevent="envioRutaStep--" class="btn btn-primary pull-right">Anterior</button> -->
				<!-- <button type="button" class="btn btn-white" data-dismiss="modal">Close</button> -->
				<!-- <button type="button" class="btn btn-primary">Save changes</button> -->
			<!-- </div> -->
		</div>
	</div>
</div>
<!-- FIN Ruta -->

<!-- Salida de Vehículo -->
<div class="modal inmodal fade" id="mdlVehiculoSalida" tabindex="-1" role="dialog"  aria-hidden="true">
<!-- <div> -->
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title">Salida de Veh&iacute;culo
					
				</h4>
				<!-- <small class="font-bold">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</small> -->
			</div>
			<div class="modal-body">
			    <div class="ibox">
				    <div class="ibox-content">
					    <table class="table table-bordered">
							<tbody>
								<tr>
									<td>Placa</td>
									<td>{{ vehiculoSalidaPlaca }}</td>
								</tr>
								<tr>
									<td>Veh&iacute;culo</td>
									<td>{{ vehiculoSalidaNombre }}</td>
								</tr>
								<tr>
									<td>&Uacute;ltimo Km Registrado</td>
									<td>{{ vehiculoSalidaLastKm }}</td>
								</tr>								
								<tr>
									<td>Kilometraje de Salida</td>
									<td>
										<input type="text"
												v-model="vehiculoSalidaKm" placeholder=""
												oninput="this.value = this.value.replace(/[^0-9\t]/g, '').replace(/(\..*)\./g, '$1');"
												maxlength="9" class="form-control">										
										<span v-show="vehiculoSalidaKm == ''" 
													class="text-danger">Ingrese kilometraje</span>
													<br>
										<span v-show="vehiculoSalidaKm < vehiculoSalidaLastKm " 
													class="text-danger">Kilometraje de Salida debe ser mayor o igual al &Uacute;ltimo registrado</span>
									</td>
								</tr>
							</tbody>
						</table>
						<!--<input v-show="ve.selected && (ve.estatus == '' || ve.estatus == 'ASIGNADO')" type="text"
												v-model="ve.km" placeholder=""
												oninput="this.value = this.value.replace(/[^0-9\t]/g, '').replace(/(\..*)\./g, '$1');"
												maxlength="9" class="form-control">
											<span v-show="ve.estatus =='ENRUTA' || ve.estatus == 'COMPLETADO'" 
													class="">{{ ve.km }}</span>
											<span v-show="ve.selected && (ve.km == '0' || ve.km == '' || parseInt(ve.km) == 0)" 
													class="text-danger">Ingrese kilometraje</span>-->
						
					    
					</div>
				</div>
				
				
			</div>

			<div class="modal-footer">
				<!-- <button :disabled="!(envioRutaStep == 3)" @click.prevent="asignarVehiculos" class="btn btn-primary pull-right m-l-xs">Enviar</button>
					<button :disabled="!(envioRutaStep < 3)" @click.prevent="prepareAsignarVehiculosSiguiente" class="btn btn-primary pull-right m-l-xs">Siguiente</button>
					<button :disabled="!(envioRutaStep > 1)" @click.prevent="envioRutaStep--" class="btn btn-primary pull-right">Anterior</button> -->
				<!-- <button type="button" class="btn btn-white" data-dismiss="modal">Close</button> -->
				<button @click.prevent="enviarVehiculo" type="button" class="btn btn-primary">Enviar Veh&iacute;culo</button>
			</div>
		</div>
	</div>
</div>
<!-- FIN Salida de Venículo -->

<!-- Llegada de vehÃ­culo -->
<div class="modal inmodal fade" id="mdlVehiculoRegreso" tabindex="-1" role="dialog"  aria-hidden="true">
<!-- <div> -->
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title">Regreso de Ve&iacute;culo
					
				</h4>
				<!-- <small class="font-bold">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</small> -->
			</div>
			<div class="modal-body">
			    <div class="ibox">
				    <div class="ibox-content">
					    <h3>¿Pedidos Entregados?</h3>
					    <div v-for="(red, indexv) in vehiculoRegreso.vs" :id="red.key" class="vote-item">
											<div class="row">
												<div class="col-md-10">
													<!-- <div class="vote-actions">
														<a @click.prevent="ordenMenos(indexv)" v-show="false && indexv > 0 && blnPuedeAsignarPedidos" href="#">
															<i class="fa fa-chevron-up"> </i>
														</a>
														<div>{{ indexv + 1 }}</div>
														<a @click.prevent="ordenMas(indexv)" v-show="false && indexv < (rutaenviodetalle.length - 1) && blnPuedeAsignarPedidos" href="#">
															<i class="fa fa-chevron-down"> </i>
														</a>
													</div> -->
													<a href="#" class="vote-title">
														<strong class="text-navy">VS {{ red.idValeSalida}}: P {{ red.idPedido }}</strong> {{ red.cliente }}
													</a>
													<a href="#" class="vote-title2 m-l-lg">
														{{ red.domicilioEntrega }} {{ red.numeroEntrega }} {{ red.coloniaEntrega }} {{ red.ciudadEntrega }}
													</a>
													<div class="m-l-lg">
														<i class="fa fa-info-circle"></i> Max ML: {{ red.maxml }}
														<i class="fa fa-info-circle"></i> Total KG: {{ red.maxkg }}
														<!-- <i class="fa fa-info-circle"></i> Estado:  -->
																<!-- <span v-show="red.estado == 'TERMINADO'" class="label label-primary">{{ red.estado }}</span> -->
																<!-- <span v-show="red.estado != 'TERMINADO'" class="label label-danger">{{ red.estado }}</span>   										                                      -->
																<!-- <span  class="label label-primary">{{ red.estado }}</span> -->
													</div>
													<span class="text-danger" v-show="red.listoParaSalir == 'NO'">** El Vale de Salida debe estar Autorizado para Salir para cuando envie esta ruta, de lo contrario, deber&aacute; reasignarlo a otra.</span>
												</div>
												<div class="col-md-2 ">
													<div class="vote-icon">
														<!-- <i class="fa fa-github"> </i> -->
														<!-- <button v-show="blnPuedeAsignarPedidos" @click.prevent="desAsignarPedidoDeRuta(red.idPedido, red.idRutaEnvioDetalle, red.key, indexv)" class="btn btn-danger btn-xs"><i class="fa fa-times"></i></button> -->
														<!-- {{ indexv }} -->
														<!-- <button  @click.prevent="desAsignarPedidoDeVehiculo(red.idValeSalida, red.idPedido, red.idRutaEnvioDetalle, index, indexv)" class="btn btn-danger btn-xs"><i class="fa fa-times"></i></button>  -->
														<!-- <button  @click.prevent="ve.vehiculoAsignado = 0" class="btn btn-default btn-xs"><i class="fa fa-check-square-o"></i></button>
														<button  @click.prevent="ve.vehiculoAsignado = ve.vehiculoAsignadoOriginal" class="btn btn-default btn-xs"><i class="fa fa-square-o"></i></button> -->
														<span v-show="red.vehiculoAsignado > 0" @click.prevent="red.vehiculoAsignado = 0" class="text-navy small" style="cursor: pointer"><i class="fa fa-check-square-o"></i></span>
														<span v-show="red.vehiculoAsignado == 0" @click.prevent="red.vehiculoAsignado = red.vehiculoAsignadoOriginal" class="text-navy small" style="cursor: pointer"><i class="fa fa-square-o"></i></span>
														
														
													</div>
												</div>
											</div>
										</div>
					</div>
				</div>
				<div class="ibox">
					<div class="ibox-content">						
						<form class="form-horizontal">
						<!-- <td><input type="checkbox" value="" name="" class="i-checks" v-model="ve.selected"/></td>
										<td>{{ ve.placa }} : {{ ve.descripcion }}</td>										
										<td>
											<input v-show="ve.selected" type="text"
												v-model="ve.km" placeholder=""
												oninput="this.value = this.value.replace(/[^0-9\t]/g, '').replace(/(\..*)\./g, '$1');"
												maxlength="9" class="form-control">
											<span v-show="ve.selected && (ve.km == '0' || ve.km == '' || parseInt(ve.km) == 0)" 
													class="text-danger">Ingrese kilometraje</span>
										</td> -->
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label class="col-lg-6 control-label">
											Kilometraje Inicial
										</label>
										<label class="col-lg-6 control-label">
											{{ vehiculoRegreso.km }}
										</label>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label class="col-lg-6 control-label">
											Kilometraje Final
										</label>
										<div class="col-lg-6">
											<input  type="text"
													style="text-align: right;"
													v-model="vehiculoRegreso.kmfinal" placeholder=""
													oninput="this.value = this.value.replace(/[^0-9\t]/g, '').replace(/(\..*)\./g, '$1');"
													maxlength="9" class="form-control">

											<span v-show="parseFloat(vehiculoRegreso.km) >= parseFloat(vehiculoRegreso.kmfinal)" 
													class="text-danger">Kilometraje Final debe ser mayor a Kilometraje Inicial</span>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label class="col-lg-6 control-label">
											Carg&oacute; Gasolina
										</label>
										<div class="col-lg-6">
											<input type="checkbox" value="" name="" class="i-checks" v-model="vehiculoRegreso.cargogasolina"/>
											<!-- <span v-show="ve.selected && (ve.km == '0' || ve.km == '' || parseInt(ve.km) == 0)" 
													class="text-danger">Ingrese kilometraje</span> -->
											<!-- <input type="email" placeholder="Email" class="form-control"> -->
											<!-- <span class="help-block m-b-none">Example block-level help text here.</span> -->
										</div>
									</div>
								</div>
							</div>
							<div v-show="vehiculoRegreso.cargogasolina" class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label class="col-lg-6 control-label">
											Litros
										</label>
										<div class="col-lg-6">
											<input  type="text"
												v-model="vehiculoRegreso.litros" placeholder=""
												oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
												maxlength="9" class="form-control">
											<span v-show="vehiculoRegreso.cargogasolina && vehiculoRegreso.litros <= 0" 
													class="text-danger">Ingrese una cantidad mayor a cero
											</span>
										</div>
									</div>
								</div>
							</div>
							<div v-show="vehiculoRegreso.cargogasolina" class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label class="col-lg-6 control-label">
											Tipo Combustible
										</label>
										<div class="col-lg-6">
											<select class="form-control" v-model="vehiculoRegreso.tipocombustible">
												<option value="NA">-- Seleccione tipo --</option>												
												<option value="MAGNA">MAGNA</option>
												<option value="PREMIUM">PREMIUM</option>
												<option value="DIESEL">DIESEL</option>
											</select>
											<span v-show="vehiculoRegreso.cargogasolina && vehiculoRegreso.tipocombustible == 'NA'" 
													class="text-danger">Seleccione el tipo de combustible 
											</span>
										</div>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
				
			</div>

			<div class="modal-footer">
				<!-- <button :disabled="!(envioRutaStep == 3)" @click.prevent="asignarVehiculos" class="btn btn-primary pull-right m-l-xs">Enviar</button>
					<button :disabled="!(envioRutaStep < 3)" @click.prevent="prepareAsignarVehiculosSiguiente" class="btn btn-primary pull-right m-l-xs">Siguiente</button>
					<button :disabled="!(envioRutaStep > 1)" @click.prevent="envioRutaStep--" class="btn btn-primary pull-right">Anterior</button> -->
				<!-- <button type="button" class="btn btn-white" data-dismiss="modal">Close</button> -->
				<button @click.prevent="registrarRegresoVehiculo" type="button" class="btn btn-primary">Registrar el regreso del Veh&iacute;culo</button>
			</div>
		</div>
	</div>
</div>
<!-- FIN Llegada de vehÃ­culo -->


<div class="row">
    <div v-show="!mostrarCalendario || true" :class="mostrarCalendario && false ? 'col-md-12 col-lg-12' : 'col-md-12 col-lg-3'">
        <div class="ibox">
            <div class="ibox-content">
				<div class="tabs-container">
					<ul class="nav nav-tabs">
						<li class="active"><a data-toggle="tab" href="#tab-1"> Para Asignar<span class="badge badge-info">{{ pedidosParaEnrutar.length }}</span></a></li>
						<li class=""><a data-toggle="tab" href="#tab-2"> Para Reasignar<span class="badge badge-warning">{{ pedidosParaReEnrutar.length }}</span></a></li>
					</ul>
					<div class="tab-content">
						<div id="tab-1" class="tab-pane active">
							<ul class="sortable-list connectList agile-list" id="tabporasignar">
								<li v-for="(item, index) in pedidosParaEnrutar"
									:class="(item.listoParaSalir == 'NO' ? 'danger' : 'success') + '-element'">
									{{ item.cliente }}
									<br>
									<span>Max ML: <strong>{{ item.maxml }}</strong></span>
									<span>KG: <strong>{{ item.maxkg  }}</strong></span>
									<br>
									<span>Fecha Abierta: <strong>{{ item.fechaAbierta}}</strong></span>
									<br>
									<span>Hora Recibe: <strong>{{ item.horaRecibe  }}</strong></span>
									<br>
									<span>Fecha Compromiso: <strong>{{ item.fechaCompromiso  }}</strong></span>
									<br>
									<span>Domicilio: <strong>{{ item.domicilioEntrega  }} {{ item.numeroEntrega  }}</strong></span>									
									<br>
									<span>Colonia: <strong>{{ item.coloniaEntrega  }}</strong></span>
									
									<!-- <span v-show="item.explotado == 'SI' && item.explotadook == 'SI' " class="badge badge-success">LISTO PRODUCIR COMPLETO</span>
									<span v-show="item.explotado == 'SI' && item.explotadook == 'NO' && item.puedeProducirse == 'SI' " class="badge badge-primary">LISTO PRODUCIR PARCIAL</span>
									<span v-show="item.explotado == 'SI' && item.explotadook == 'NO' && item.puedeProducirse == 'NO' " class="badge badge-warning">A&Uacute;N NO PUEDE PRODUCIRSE</span>
									<span v-show="item.explotado == 'NO' " class="badge badge-danger">NO EXPLOSIONADO</span> -->

									<!-- <span :class="'badge ' + (item.estado != 'TERMINADO' ? 'badge-danger' : 'badge-default')" >{{ item.estatus  }}</span> -->
									<!-- <span class="badge badge-default" >{{ item.estado  }}</span> -->
																
									<div class="agile-detail">
										<button v-show="idRutaEnvio > 0"               								 
											class="pull-right btn btn-xs btn-primary"
											@click.prevent="asignarValeSalidaARutaEnvio(item.idValeSalida)"><i class="fa fa-arrow-right"></i></button>
										<i class="fa fa-list-alt"></i> <strong>VS {{ item.idValeSalida}}: P {{ item.idPedido }} </strong> 
											<span class="label label-info">{{ item.estado }}</span>
									</div>
								</li>

							</ul>
						</div>
						<div id="tab-2" class="tab-pane">
							<ul class="sortable-list connectList agile-list" id="tabporasignar">
								<li v-for="(item, index2) in pedidosParaReEnrutar"
									:class="(item.listoParaSalir == 'NO' ? 'danger' : 'success') + '-element'">
									{{ item.cliente }}
									<br>
									<span>Max ML: <strong>{{ item.maxml }}</strong></span>
									<span>KG: <strong>{{ item.maxkg  }}</strong></span>
									<br>
									<span>Fecha Abierta: <strong>{{ item.fechaAbierta}}</strong></span>
									<br>
									<span>Hora Recibe: <strong>{{ item.horaRecibe  }}</strong></span>
									<br>
									<span>Fecha Compromiso: <strong>{{ item.fechaCompromiso  }}</strong></span>
									<br>
									<span>Domicilio: <strong>{{ item.domicilioEntrega  }} {{ item.numeroEntrega  }}</strong></span>									
									<br>
									<span>Colonia: <strong>{{ item.coloniaEntrega  }}</strong></span>
									
									<!-- <span v-show="item.explotado == 'SI' && item.explotadook == 'SI' " class="badge badge-success">LISTO PRODUCIR COMPLETO</span>
									<span v-show="item.explotado == 'SI' && item.explotadook == 'NO' && item.puedeProducirse == 'SI' " class="badge badge-primary">LISTO PRODUCIR PARCIAL</span>
									<span v-show="item.explotado == 'SI' && item.explotadook == 'NO' && item.puedeProducirse == 'NO' " class="badge badge-warning">A&Uacute;N NO PUEDE PRODUCIRSE</span>
									<span v-show="item.explotado == 'NO' " class="badge badge-danger">NO EXPLOSIONADO</span> -->

									<!-- <span v-show="item.explotado == 'NO' " class="badge badge-danger">{{ item.estado  }}</span> -->
									<!-- <span :class="'badge ' + (item.estado != 'TERMINADO' ? 'badge-danger' : 'badge-default')" >{{ item.estado  }}</span> -->
									<!-- <span class="badge badge-default" >{{ item.estado  }}</span> -->
																
									<div class="agile-detail">
										<button v-show="idRutaEnvio > 0 && blnPuedeAsignarPedidos && ((turno == 'MATUTINO' && puedeAbrirMatutino) || (turno == 'VESPERTINO' && puedeAbrirVespertino))"                								 
											class="pull-right btn btn-xs btn-primary"
											@click.prevent="asignarValeSalidaARutaEnvio(item.idValeSalida)"><i class="fa fa-arrow-right"></i></button>
										<i class="fa fa-list-alt"></i> <strong>VS {{ item.idValeSalida}}: P {{ item.idPedido }} </strong> 
											<span class="label label-info">{{ item.estado }}</span>
									</div>
								</li>

							</ul>
						</div>
					</div>


				</div>
				
            </div>
        </div>
    </div>
    <div :class="mostrarCalendario && false ? 'col-md-12 col-lg-12' : 'col-md-12 col-lg-9'">
        <div class="ibox">
            <!-- <div class="ibox-title">
            </div> -->
            <div class="ibox-content">

				<div v-show="mostrarCalendario" >
					<div v-show="moverValesDeAqui > 0" class="row m-t-lg m-b-lg">
						<div class="col-md-12">
							<span class="alert alert-info">
								Ha seleccionado mover el detalle de una Ruta a otra distinta, por favor seleccione la Ruta destino
								&nbsp;&nbsp;&nbsp;<button @click.prevent="moverValesDeAqui = 0" class="btn btn-danger btn-xs">Cancelar el movimiento</button>
							</span>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							
							<div class="calendar-month">
								<section class="calendar-month-header">
									<div
									id="selected-month"
									class="calendar-month-header-selected-month"
									>
									{{ nombreMes }} {{ anioCalendario}} <buton v-show="false" class="btn btn-danger btn-xs"><i class="fa fa-calendar-o"></i></buton>
									</div>

									<div class="calendar-month-header-selectors">
									<span @click.prevent="irAMesAnterior" id="previous-month-selector">< </span>
									<span @click.prevent="irAMesActual" id="present-month-selector"> &nbsp;&nbsp;Hoy&nbsp;&nbsp; </span>
									<span @click.prevent="irAMesSiguiente" id="next-month-selector"> ></span>
									</div>
								</section>
								
								<ol
									id="days-of-week"
									class="day-of-week"
								>
									<li>Lunes</li>
									<li>Martes</li>
									<li>Mi&eacute;rcoles</li>
									<li>Jueves</li>
									<li>Viernes</li>
									<li>S&aacute;bado</li>
									<li>Domingo</li>
								</ol>

								<ol
									id="calendar-days"
									class="days-grid"
								>
									<li v-for="(cal, index) in calendario" :class="cal.dia > 0 ? 'calendar-day' : ''" :key="index">
										<span @click.prevent="showDia(cal.dia, true)" v-show="cal.dia > 0" class="daynum " :class="isMesActual && diaActual == cal.dia ? 'badge badge-primary' : ''">{{ cal.dia }}</span>
										<div v-show="cal.rutasenvios.length > 0" class="events">
											<ul class="todo-list small-list">
												<!-- :style="re.enviado == 'SI' ? 'background-color: #1c84c6 !important;  border-color: #1c84c6 !important; color: #FFFFFF;' : ''" -->
												<li v-for="(re, indexre) in cal.rutasenvios"  :key="indexre" v-show="re.nopedidos > 0" >													
													
													<!-- <span class="" :class="re.enviado == 'SI' ? 'todo-completed' : ''"><strong>{{ re.ruta }}</strong></span> -->
													<span class="" ><strong>{{ re.ruta }}</strong></span>
													<span class="" ><span >{{ re.turno }}</span></span>
													<br>
													<span >MAx ML: {{ re.maxml }}</span>
													<br>
													<span >Total KG: {{ re.maxpeso }}</span>
													<br>
													<span >Vales Salida: {{ re.nopedidos }}</span>
													
																										
													<div class="row m-t-xs">														
														<div class="col-md-12">	
															<!-- <button class="btn btn-xs pull-right " :class="re.enviado == 'SI' ? 'btn-info' : 'btn-primary'"><i :class="re.enviado == 'SI' ? 'fa fa-eye' : 'fa fa-pencil'"></i></button>	 -->
															<div class="btn-group">
																<!-- <button data-toggle="dropdown" class="btn btn-md dropdown-toggle " :class="re.estado == 'TERMINADA' ? 'btn-success ' : re.puedeEditarse ? 'btn-warning' : 'btn-danger'"><span v-show="re.estado == 'TERMINADA'">Enviado</span><span v-show="re.estado == 'CREADA'">No Enviado</span> <span class="caret"></span></button> -->
																<button data-toggle="dropdown" class="btn btn-md dropdown-toggle " :class="re.estado == 'TERMINADA' ? 'btn-success ' : re.estado == 'ENRUTA' ? 'btn-info' : re.estado == 'VEHICULOASIGNADO' ? 'btn-warning' : 'btn-danger'"><span v-show="re.estado == 'TERMINADA'">COMPLETADO</span><span v-show="re.estado == 'CREADA'">NO ENVIADO</span> <span v-show="re.estado == 'ENRUTA'">EN RUTA</span><span v-show="re.estado == 'VEHICULOASIGNADO'">VEHICULO ASIGNADO</span>  <span class="caret"></span></button>
																<ul class="dropdown-menu">
																	<li><a @click.prevent="verDetalleIdRutaEnvio(re.idRuta, re.idRutaEnvio, re.dia, re.turno)" href="#"><i class="fa fa-eye"></i>&nbsp;&nbsp;Ver Detalle</a></li>																	
																	<li><a @click.prevent="verRuta(re.idRuta)" href="#"><i class="fa fa-map-marker"></i>&nbsp;&nbsp;Ver Mapa</a></li>																	
																	<li v-show="re.estado == 'CREADA' && re.puedeEditarse && re.nopedidos > 0"><a @click.prevent="prepareAsignarVehiculosDeCalendario(re.idRuta, re.idRutaEnvio, re.dia, re.turno)" href="#"><i class="fa fa-truck"></i>&nbsp;&nbsp;Asignar Veh&iacute;culo</a></li>
																	<li v-show="re.estado == 'CREADA' && re.puedeEditarse && moverValesDeAqui == 0"><a @click.prevent="moverDetalleDeAqui(re.idRutaEnvio)" href="#"><i class="fa fa-upload "></i>&nbsp;&nbsp;Mover Detalle de Esta Ruta</a></li>
																	<li v-show="re.estado == 'CREADA' && re.puedeEditarse && moverValesDeAqui > 0 && moverValesDeAqui != re.idRutaEnvio"><a @click.prevent="moverDetalleHastaAqui(re.idRutaEnvio)" href="#"><i class="fa fa-download"></i>&nbsp;&nbsp;Mover Detalle de Hasta Esta Ruta</a></li>
																	<li v-for="oe in re.oe" :style="oe.estatus == 'ASIGNADO' ? 'pointer-events:none !important; opacity:0.6 !important;' : ''">
																		<a target="_blank" :href="'<?php echo URL_BASE ?>/ordenembarquepdf?id=' + oe.idRutaEnvioVehiculo"><i class="fa fa-print"></i>&nbsp;OE &nbsp;{{ oe.vehiculo }}</a>
																	</li>
																	
																</ul>
															</div>
														</div>
													</div>
												</li>
												
											</ul>
									
										</div>
									</li>
									
								</ol>
							</div>
												
						</div>

					</div>
					<div class="row">
						<br>
						<br>
						<br>
						<br>
						<br>
						<br>
						<br>
						<br>
						<br>
						<br>
						<br>
					</div>
				</div>
               
			   
				<div v-show="!mostrarCalendario" >					
					<div v-show="moverValesDeAqui > 0" class="row m-t-lg m-b-lg">
						<div class="col-md-12">
							<span class="alert alert-info">
								Ha seleccionado mover el detalle de una Ruta a otra distinta, por favor seleccione la Ruta destino
								&nbsp;&nbsp;&nbsp;<button @click.prevent="moverValesDeAqui = 0" class="btn btn-danger btn-xs">Cancelar el movimiento</button>
							</span>
						</div>
					</div>
					<div  class="row">					
						<div class="col-md-2">
							<p class="nrkcalendar"> {{ diaSeleccionado }} <em> {{ nombreMes}}</em></p>
						</div>
						<div class="col-md-7">
							<div class="row">
								<div class="col-md-12">
									<h1 class="font-bold no-margins text-navy">{{ rutaNombre }}</h1>
								</div>
								<div class="col-md-12">
									<h2 class=" no-margins"><strong>{{ nombreDia }}</strong> - Max <strong>{{ rutaEnvioMaxML }} ML</strong> - <strong>{{ rutaEnvioMaxKG }} KG</strong></h2>
								</div>
								<div v-show="rutaSeleccionada > 0" class="col-md-12 m-t-xs">
									<span v-show="rutaEnvioEnviado"><h2 class=" no-margins"><strong>{{ turno }}</strong></h2></span>
									
									<button v-show="blnPuedeAsignarPedidos && !rutaEnvioEnviado && puedeAbrirMatutino" @click.prevent="seleccionarTurno('MATUTINO')" class="btn " :class="turno == 'MATUTINO' ? 'btn-primary' : 'btn-default'">MATUTINO</button>
									<button v-show="blnPuedeAsignarPedidos && !rutaEnvioEnviado && puedeAbrirVespertino" @click.prevent="seleccionarTurno('VESPERTINO')" class="btn " :class="turno == 'VESPERTINO' ? 'btn-primary' : 'btn-default'">VESPERTINO</button>
								</div>
							</div>
							
						</div>
						<div v-show="mostrarRuta && blnPuedeAsignarPedidos" class="col-md-1">
							<button class="btn btn-warning" @click.prevent="showDia(diaSeleccionado)"><i class="fa fa-calendar"></i> Rutas</button>							
						</div>
						<div  class="col-md-1">
							<button class="btn btn-warning m-l-xs" @click.prevent="showCalendario"><i class="fa fa-calendar"></i> Calendario</button>							
						</div>
					</div>
					<div v-show="mostrarDia">
						<div  class="row">
							<!-- <hr> -->
							<h3 class="m-l-lg">Seleccione Zona</h3>
						</div>
						<div  class="row">				

							<div v-for="(ruta, index) in rutas" class="col-lg-4">
								<div  class="widget style1 navy-bg" style="cursor: pointer;" @click.prevent="showRuta(index)">
									<div class="row">
										<div class="col-xs-4">
											<i class="fa fa-road fa-5x"></i>
										</div>
										<div class="col-xs-8 text-right">
											<h4 class="font-bold"> {{ ruta.nombre }} </h4>
											<h4 >{{ ruta.descripcion }}</h4>
										</div>
									</div>
								</div>
							</div>

							

						</div>
					</div>
					<div v-show="mostrarRuta">

						<div v-show="!blnPuedeAsignarPedidos" class="alert alert-danger">
							No puede asignar Vales de Salida a Esta Zona en este D&iacute;a
						</div>

						<div v-show="blnPuedeAsignarPedidos && rutaenviodetalle.length == 0 && turno != ''" class="alert alert-info">
							Agregue alg&uacute;n Vale de Salida a la Zona
						</div>

						<div v-show="blnPuedeAsignarPedidos && turno == ''" class="alert alert-warning">
							Seleccione un Turno para configurar la Zona
						</div>
						
						
						<div v-show="blnPuedeAsignarPedidos" class="row">
							<div class="m-b-lg">
								<button v-show="rutaenviodetalle.length > 0" @click.prevent="prepareAsignarVehiculos" class="btn btn-white btn-bitbucket pull-right m-r-lg">
									<i class="fa fa-truck"></i> Asignar Veh&iacute;culo
								</button>							
								<button @click.prevent="moverDetalleHastaAqui(idRutaEnvio, false)" v-show="moverValesDeAqui > 0 && moverValesDeAqui != idRutaEnvio && turno != '' " class="btn btn-white btn-bitbucket pull-right m-r-xs">
									<i class="fa fa-download"></i> Mover Vales a esta Zona
								</button>							
								
							</div>
						</div>
						
						
						
						<!-- cuando la ruta esta lista para enviarse -->
						<div v-show="rutaEnvioEnviado" class="m-b-md">
							<span class="badge badge-default">VEHICULO ASIGNADO</span>
							<span class="badge badge-warning">VEHICULO EN RUTA</span>
							<span class="badge badge-success">RUTA DE VEHICULO COMPLETADA</span>
							<br>
						</div>
						<div v-show="rutaEnvioEnviado" class="panel-group" id="accordion2">
							<div v-for="(ve, index) in vehiculosParaEnviar" :class="'panel panel-' + (ve.estatus == 'ASIGNADO' ? 'default' : (ve.estatus == 'ENRUTA' ? 'warning' : 'success' ))" v-show="ve.idRutaEnvioVehiculo > 0">
								<div class="panel-heading">
									<h5 class="panel-title">										
										<i class="fa fa-truck"></i> <a data-toggle="collapse" data-parent="#accordion2" :href="'#collapse2' + index">{{ ve.placa }} - {{ ve.descripcion }} <span v-if="ve.km > 0 ">- {{ ve.km }} Km </span> <span class="pull-right"> {{ formatNumber(ve.maxml) }} Max ML : {{ formatNumber(ve.kg) }} Kg</span></a>
									</h5>
								</div>
								<div :id="'collapse2' + index" class="panel-collapse collapse in">
									<div class="row m-t-xs">
										<div class="col-md-12">
											<a @click.prevent="envioCompletado(index)" v-show="ve.estatus == 'ENRUTA'" class="btn btn-white btn-bitbucket pull-right m-l-xs">
												<i class="fa fa-flag-checkered"></i> Envio Completado
											</a>
											<a v-show="ve.estatus != 'ASIGNADO'" target="_blank" :href="'<?php echo URL_BASE ?>/ordenembarquepdf?id=' + ve.idRutaEnvioVehiculo" class="btn btn-white btn-bitbucket pull-right m-l-xs">
												<i class="fa fa-print"></i> Orden de Embarque
											</a>
											<a v-show="ve.estatus == 'ASIGNADO' && ve.disponibilidad == 'DISPONIBLE'" @click.prevent="preEnviarVehiculo(index)"  class="btn btn-white btn-bitbucket pull-right m-l-xs">
												<i class="fa fa-send"></i> Enviar
											</a>

											<span v-show="ve.estatus == 'ASIGNADO' && ve.disponibilidad == 'ENRUTA'" class="badge badge-danger pull-right">Este Veh&iacute;culo no puede enviarse, no ha regresado de su Ruta previa</span>

										</div>
										<div class="clearfix">
										</div>
									</div>

									<div class="panel-body">										
										<div v-for="(red, indexv) in ve.vs" :id="red.key" class="vote-item">
											<div class="row">
												<div class="col-md-10">
													<div class="vote-actions">
														<a @click.prevent="ordenMenos(indexv)" v-show="false && indexv > 0 && blnPuedeAsignarPedidos" href="#">
															<i class="fa fa-chevron-up"> </i>
														</a>
														<div>{{ indexv + 1 }}</div>
														<a @click.prevent="ordenMas(indexv)" v-show="false && indexv < (rutaenviodetalle.length - 1) && blnPuedeAsignarPedidos" href="#">
															<i class="fa fa-chevron-down"> </i>
														</a>
													</div>
													<a href="#" class="vote-title">
														<strong class="text-navy">VS {{ red.idValeSalida}}: P {{ red.idPedido }}</strong> {{ red.cliente }}
													</a>
													<a href="#" class="vote-title2 m-l-lg">
														{{ red.domicilioEntrega }} {{ red.numeroEntrega }} {{ red.coloniaEntrega }} {{ red.ciudadEntrega }}
													</a>
													<div class="m-l-lg">
														<i class="fa fa-info-circle"></i> Max ML: {{ red.maxml }}
														<i class="fa fa-info-circle"></i> Total KG: {{ red.maxkg }}
														<!-- <i class="fa fa-info-circle"></i> Estado:  -->
																<!-- <span v-show="red.estado == 'TERMINADO'" class="label label-primary">{{ red.estado }}</span> -->
																<!-- <span v-show="red.estado != 'TERMINADO'" class="label label-danger">{{ red.estado }}</span>   										                                      -->
																<!-- <span  class="label label-primary">{{ red.estado }}</span> -->
													</div>
													<span class="text-danger" v-show="red.listoParaSalir == 'NO'">** El Vale de Salida debe estar Autorizado para Salir para cuando envie esta ruta, de lo contrario, deber&aacute; reasignarlo a otra.</span>
												</div>
												<div class="col-md-2 ">
													<div class="vote-icon">
														<!-- <i class="fa fa-github"> </i> -->
														<!-- <button v-show="blnPuedeAsignarPedidos" @click.prevent="desAsignarPedidoDeRuta(red.idPedido, red.idRutaEnvioDetalle, red.key, indexv)" class="btn btn-danger btn-xs"><i class="fa fa-times"></i></button> -->
														<!-- {{ indexv }} -->
														<button v-show="ve.estatus == 'ASIGNADO'" @click.prevent="desAsignarPedidoDeVehiculo(red.idValeSalida, red.idPedido, red.idRutaEnvioDetalle, index, indexv)" class="btn btn-danger btn-xs"><i class="fa fa-times"></i></button> 
														
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>

						</div>

						<!-- si hay VS agregados despues de asignar vehiculos -->
						
						

							<div v-show="rutaEnvioEnviado && rutaenviodetalle.filter(x => x.idRutaEnvioVehiculo == 0).length > 0" class="panel panel-danger">
								<div class="panel-heading">
									<h5 class="panel-title">										
										<i class="fa fa-times-o"></i>&nbsp;&nbsp;Vales de Salida NO asignados a Vehiculo
									</h5>
								</div>								

								<div class="panel-body">										
									<div v-show="rutaEnvioEnviado && red.idRutaEnvioVehiculo == 0" v-for="(red, index) in rutaenviodetalle" :id="'xx'+red.key" class="vote-item">
										<div class="row">
											<div class="col-md-10">
												<div class="vote-actions">
													<!-- <a @click.prevent="ordenMenos(index)" v-show="index > 0 && blnPuedeAsignarPedidos" href="#">
														<i class="fa fa-chevron-up"> </i>
													</a> -->
													<div>{{ red.orden }}</div>
													<!-- <a @click.prevent="ordenMas(index)" v-show="index < (rutaenviodetalle.length - 1) && blnPuedeAsignarPedidos" href="#">
														<i class="fa fa-chevron-down"> </i>
													</a> -->
												</div>
												<a href="#" class="vote-title">
													<strong class="text-navy">VS {{ red.idValeSalida}}: P {{ red.idPedido }}</strong> {{ red.cliente }}
												</a>
												<a href="#" class="vote-title2 m-l-lg">
													{{ red.domicilioEntrega }} {{ red.numeroEntrega }} {{ red.coloniaEntrega }} {{ red.ciudadEntrega }}
												</a>
												<div class="m-l-lg">
													<i class="fa fa-info-circle"></i> Max ML: {{ red.maxml }}
													<i class="fa fa-info-circle"></i> Total KG: {{ red.maxkg }}
													<!-- <i class="fa fa-info-circle"></i> Estado:  -->
															<!-- <span v-show="red.estado == 'TERMINADO'" class="label label-primary">{{ red.estado }}</span> -->
															<!-- <span v-show="red.estado != 'TERMINADO'" class="label label-danger">{{ red.estado }}</span>   										                                      -->
															<!-- <span  class="label label-primary">{{ red.estado }}</span> -->
												</div>
												<span class="text-danger" v-show="red.listoParaSalir == 'NO'">** El Vale de Salida debe estar Autorizado para Salir para cuando envie esta ruta, de lo contrario, deber&aacute; reasignarlo a otra.</span>
											</div>
											<div class="col-md-2 ">
												<div class="vote-icon">                                        
													<button v-show="blnPuedeAsignarPedidos" @click.prevent="desAsignarPedidoDeRuta(red.idValeSalida, red.idPedido, red.idRutaEnvioDetalle, red.key, index)" class="btn btn-danger btn-xs"><i class="fa fa-times"></i></button>
												</div>
											</div>
										</div>
									</div>
								</div>
								
							</div>


                        
						<!-- fin Si hay VS agregados despues de asignar vehiculos -->


						<!-- FIN cuando la ruta esta lista para enviarse -->



						<div v-show="!rutaEnvioEnviado" v-for="(red, index) in rutaenviodetalle" :id="red.key" class="vote-item">
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="vote-actions">
                                        <a @click.prevent="ordenMenos(index)" v-show="index > 0 && blnPuedeAsignarPedidos" href="#">
                                            <i class="fa fa-chevron-up"> </i>
                                        </a>
                                        <div>{{ red.orden }}</div>
                                        <a @click.prevent="ordenMas(index)" v-show="index < (rutaenviodetalle.length - 1) && blnPuedeAsignarPedidos" href="#">
                                            <i class="fa fa-chevron-down"> </i>
                                        </a>
                                    </div>
                                    <a href="#" class="vote-title">
                                        <strong class="text-navy">VS {{ red.idValeSalida}}: P {{ red.idPedido }}</strong> {{ red.cliente }}
                                    </a>
									<a href="#" class="vote-title2 m-l-lg">
                                        {{ red.domicilioEntrega }} {{ red.numeroEntrega }} {{ red.coloniaEntrega }} {{ red.ciudadEntrega }}
                                    </a>
                                    <div class="m-l-lg">
                                        <i class="fa fa-info-circle"></i> Max ML: {{ red.maxml }}
                                        <i class="fa fa-info-circle"></i> Total KG: {{ red.maxkg }}
										<i class="fa fa-info-circle"></i> Estado: 
												<!-- <span v-show="red.estado == 'TERMINADO'" class="label label-primary">{{ red.estado }}</span> -->
												<!-- <span v-show="red.estado != 'TERMINADO'" class="label label-danger">{{ red.estado }}</span>   										                                      -->
												<span  class="label label-primary">{{ red.estado }}</span>
                                    </div>
									<span class="text-danger" v-show="red.listoParaSalir == 'NO'">** El Vale de Salida debe estar Autorizado para Salir para cuando envie esta ruta, de lo contrario, deber&aacute; reasignarlo a otra.</span>
                                </div>
                                <div class="col-md-2 ">
                                    <div class="vote-icon">
                                        <!-- <i class="fa fa-github"> </i> -->
										<button v-show="blnPuedeAsignarPedidos" @click.prevent="desAsignarPedidoDeRuta(red.idValeSalida, red.idPedido, red.idRutaEnvioDetalle, red.key, index)" class="btn btn-danger btn-xs"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>
                             </div>
                        </div>
					
					</div>
				</div>			   

               
					<div class="col-md-5">
					</div>
                </div>
                <div class="clearfix"></div>
                
            </div>
        </div>
    </div>
</div>