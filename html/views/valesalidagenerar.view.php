<?php
$titlePage = "Generar Vale de Salida";
$breadCum = "Producci&oacute;n/Generar Vale";

$_lugar = LUGAR_PRODUCCION_VALESALIDAGENERAR;



$_addHead=" 		
 		<link href='".URL_BASE."assets/inspinia/css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css' rel='stylesheet'>
 		";

$_addScript="
 		<script src=\"".URL_BASE."assets/inspinia/js/plugins/toastr/toastr.min.js\"></script>
 		<script src=\"".URL_BASE."assets/inspinia/js/plugins/footable/footable.all.min.js\"></script>
 		<script src=\"".URL_BASE."assets/inspinia/js/plugins/datapicker/bootstrap-datepicker.js\"></script>
 		
		<script src=\"".URL_BASE."assets/inspinia/js/plugins/clockpicker/clockpicker.js\"></script>
 		";

?>

<div v-show="seleccionarPedido">
	<h2 class="m-l">No. Pedido:</h2>
	<div class="col-sm-3 m-b-xs">
		<div class="input-group">
			<input type="text" class="form-control input-lg" v-model="idPedido"
				v-on:keypress.enter="cargarDatosPedido"
				oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');"
				maxlength='8'> <span class="input-group-btn">
				<button @click.prevent="cargarDatosPedido"
					class="btn btn-primary btn-lg " type="button">
					<i class="fa fa-check"></i><span class="bold"></span>
				</button>
			</span>
		</div>
	</div>
	
	<div class="clearfix"></div>
</div>



<div v-show="!seleccionarPedido">
	<button @click.prevent="seleccionarOtroPedido" class="btn btn-warning">Seleccionar otro Pedido</button>	
	<div class="row">
		<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
			<div class="ibox float-e-margins">
				<div class="ibox-content">
					<div class="file-manager">
						<h2>
							Pedido <span class="text-navy pull-right m-b">{{ idPedido }}</span>
						</h2>
						<div class="hr-line-dashed"></div>
						<div class="">
							<div>
								<h2 class="no-margins">{{ cteNombre }} {{ cteApellidos }}</h2>
								<h4>{{ cteEmpresa }}</h4>
								<small> {{ cteDomicilio1 }} {{ cteDomicilio2 }} </small> <br> <small>
									{{ cteTelefonos }} </small>
							</div>
						</div>
						<div class="hr-line-dashed"></div>
						<!-- 						<a href="#" class="file-control active">Ale</a> <a href="#" -->
						<!-- 							class="file-control">Documents</a> <a href="#" -->
						<!-- 							class="file-control">Audio</a> <a href="#" class="file-control">Images</a> -->
						<!-- 						<div class="hr-line-dashed"></div> -->
						<button v-show="promotorAutorizaValeSalida == 'SI'" @click.prevent="mostrarPartidasSinValeSalida" class="btn btn-primary btn-block">Mostrar partidas sin	
							salida</button>
						<div class="hr-line-dashed"></div>
						<h5>Salidas Generadas</h5>
						<ul class="folder-list" style="padding: 0">
							<li v-for="vale in valesSalida">
								<a href="#" @click.prevent="cargarValeSalida(vale.idValeSalida)">
									<i class="fa fa-truck"></i> Vale Salida: {{ vale.idValeSalida}}
<!-- 									<span class="badge badge-info pull-right m-r">{{ vale.estado }}</span> -->
								</a>
							</li>							
						</ul>
						<!-- 						<h5 class="tag-title">Tags</h5> -->
						<ul class="tag-list" style="padding: 0">
							<!-- 							<li><a href="">Family</a></li> -->
							<!-- 							<li><a href="">Work</a></li> -->
							<!-- 							<li><a href="">Home</a></li> -->
							<!-- 							<li><a href="">Children</a></li> -->
							<!-- 							<li><a href="">Holidays</a></li> -->
							<!-- 							<li><a href="">Music</a></li> -->
							<!-- 							<li><a href="">Photography</a></li> -->
							<!-- 							<li><a href="">Film</a></li> -->
							<!-- 						</ul> -->
							<div class="clearfix"></div>
					
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 animated fadeInRight">
			
			
			
			<div v-show="mostrarSinValeSalida && promotorAutorizaValeSalida == 'SI'"  class="panel-rec">
				<h3 v-show="mercanciaSinVale.length > 0">Mercanc&iacute;a atendida sin vale de salida</h3>
				<h3 v-show="mercanciaSinVale.length == 0">No existe mercanc&iacute;a atendida sin vale de salida</h3>
				<div v-show="mercanciaSinVale.length > 0" class="table responsive">
					<?php //Form::btnExportarExcel("exportarSinVale");?>
					<table id="tablaToExcel" class="table table-bordered table-hover ">
						<thead>
							<tr>
								<th></th>
								<th>Producto</th>
								<th>Perfil</th>
								<th>Material</th>
								<th>Calibre</th>
								<th>Pzas</th>
								<th>Mts</th>
								<th>T ML</th>
								<th>Kilos</th>								
							</tr>
						</thead>
						<tbody>	
							<tr v-for="item in mercanciaSinVale">
								<td>
									<div class="checkbox checkbox-primary">
										<input :id="'chk' + item.idValeSalidaDetalle" type="checkbox" v-model="item.selected" > 
										<label :for="'chk' + item.idValeSalidaDetalle">  </label>
									</div>
								</td>
								<td>{{ item.descripcion }}</td>
								<td>{{ item.aplicacion }}</td>
								<td>{{ item.material }}</td>
								<td>{{ item.calibre }}</td>
								<td>{{ item.cantidad }}</td>
								<td>{{ item.mlkg }}</td>
								<td>{{ formatNumber(item.cantidad * item.mlkg) }}</td>
								<td>{{ formatNumber(item.cantidad * item.explotarUnidad) }}</td>
							</tr>						
						</tbody>
					</table>
				</div>
				<button v-show="mercanciaSinVale.length > 0" @click.prevent="generarvaleSalida" class="btn btn-primary">Generar Vale de Salida para elementos seleccionados</button>
				
			</div>
			
			<div v-show="mostrarValeSalida && promotorAutorizaValeSalida == 'SI' " class="panel-rec">
				<h3>Vale Salida: <span class="text-navy">{{ idValeSalida }}</span> </h3>
				
<!--     				<div v-show="generarValeSalida == 'NO'" > -->
<!--     					<br> -->
<!--     					<div class="alert alert-danger"> -->
<!--                            El <strong>Promotor</strong> a&uacute;n no ha indicado si se debe Imprimir o NO el Vale de Salida. -->
<!--                         </div> -->
<!--     				</div> -->
<!--     				<div v-show="generarValeSalida == 'AUNNO'" > -->
<!--     					<br> -->
<!--     					<div class="alert alert-warning"> -->
<!--                         	El <strong>Promotor </strong> ha indicado que no se Imprima el Vale de Salida por lo pronto. Motivo: <strong>{{observacionAunNo }} </strong> -->
<!--                         </div> -->
<!--     				</div> -->
<!--     				<div v-show="generarValeSalida == 'SI'" > -->
    					<br>
    					<a target="_blank" :href="'valesalidapdf?id=' + idValeSalida  + '&it=1'" class="btn btn-primary btn-sm m-l"><i class="fa fa-print"></i> Impresi&oacute;n con Saldo</a>
						<a target="_blank" :href="'valesalidapdf?id=' + idValeSalida" class="btn btn-primary btn-sm m-l"><i class="fa fa-print"></i> Impresi&oacute;n simple</a>
<!--     				</div> -->
    				
				
				
				
								
				<?php Form::btnExportarExcel("exportarVale");?>
				<table id="tablaValeSalida" class="table table-bordered table-hover ">
					<thead>
						<tr>				
							<th>FECHA</th>
							<th>PED.</th>			
							<th>CLIENTE</th>
							<th>PERFIL</th>
							<th>MATERIAL</th>
							<th>CALIBRE</th>
							<th>PZAS</th>
							<th>MTS</th>
							<th>T ML</th>
							<th>KILOS</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="item in mercanciaVale">							
							<td>{{ item.fecha_despacho }}</td>
							<td>{{ item.pedido }}</td>
							<td>{{ item.cliente }}</td>							
							<td>{{ item.aplicacion }}</td>
							<td>{{ item.material }}</td>
							<td>{{ item.calibre }}</td>
							<td>{{ item.cantidad }}</td>
							<td>{{ item.mlkg }}</td>
							<td>{{ formatNumber(item.cantidad * item.mlkg) }}</td>
							<td>{{ formatNumber(item.cantidad * item.explotarUnidad) }}</td>
						</tr>
					</tbody>
				</table>
				<h3>Total Kilos: <span class="text-navy">{{ formatNumber(totalKilos) }}</span></h3>
				
<!-- 				<table id="tablaValeSalidaDetalle" class="table table-bordered table-hover "> -->
<!-- 					<thead> -->
<!-- 						<tr>				 -->
<!-- 							<th>Piezas</th> -->
<!-- 							<th>Descripci&oacute;n</th>			 -->
<!-- 							<th>Total</th> -->
<!-- 							<th>Unidad</th> -->
							
<!-- 						</tr> -->
<!-- 					</thead> -->
<!-- 					<tbody> -->
<!-- 						<tr v-for="item in valeSalidaDetalle">							 -->
<!-- 							<td>{{ item.piezas }}</td> -->
<!-- 							<td>{{ item.descripcion }}</td> -->
<!-- 							<td>{{ item.total }}</td>							 -->
<!-- 							<td>{{ item.unidad }}</td>							 -->
<!-- 						</tr> -->
<!-- 					</tbody> -->
<!-- 				</table> -->
			</div>
		</div>
	</div>
</div>

<?php Form::frmExportarExcel();?>

<!-- <pre>{{ $data.mercanciaSinVale }}</pre> -->

<!-- <pre> {{ $data }}</pre> -->