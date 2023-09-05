<?php
$titlePage = "Asignar Factura a Pedido";
$breadCum = "Asignar Factura a Pedido";
$_lugar = LUGAR_CXC_PEDIDOSACEPTAFACTURAR;
// $_useDataTable = true;

$_addHead = "
 		<link href='" . URL_BASE . "assets/inspinia/css/plugins/footable/footable.core.css' rel='stylesheet'> 		
 		";

$_addScript = " 		
 		<script src=\"" . URL_BASE . "assets/inspinia/js/plugins/footable/footable.all.min.js\"></script>
 		";
?>

<!-- <p><span class='label label-warning'>CAPTURADO</span></p> -->
<!-- <p><span class='label'>AUTORIZA CxC</span></p> -->
<!-- <p><span class='label label-info'>PRODUCCI&Oacute;N</span></p> -->
<!-- <p><span class='label label-primary'>TERMINADO</span></p> -->
<!-- <p><span class='label label-success'>ENTREGADO</span></p> -->
<!-- <p><span class='label label-danger'>CANCELADO</span></p> -->

<!-- <pre>{{ $data }}</pre> -->


<!-- Capturar Motivo Autorizaci�n -->
<div class="modal inmodal fade" id="modalIndicaMotivoAutorizacion"
	tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
				</button>
				<h4 class="modal-title">Asignar Factura a Pedido</h4>
				<!-- 				<small class="font-bold"></small> -->
				<!-- 				<br> -->
				<!-- 				<small class="font-bold"></small> -->
			</div>
			<div class="modal-body">

<input type="hidden" v-model="pedidoAAutorizar" id="pedidoAAutorizar" name="pedidoAAutorizar" maxlength="50" >


				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="row">

							<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
								<div class="form-group"
									v-bind:class="{'has-error': errFacRazonSocial}">
									<label class="control-label" for="facRazonSocial">Raz&oacute;n
										Social</label> <input v-model='facRazonSocial'
										ref='facRazonSocial' type="text" id="facRazonSocial"
										name="facRazonSocial" class="form-control" disabled="disabled">
									<span v-if='errFacRazonSocial' class='help-block'> <strong> {{
											errFacRazonSocial }}</strong>
									</span>
								</div>
							</div>
							<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
								<div class="form-group" v-bind:class="{'has-error': errFacRFC}">
									<label class="control-label" for="facRFC">R. F. C.</label> <input
										v-model='facRFC' ref='facRFC' maxlength="13" type="text"
										id="facRFC" name="facRFC" class="form-control"
										disabled="disabled"> <span v-if='errFacRFC' class='help-block'>
										<strong> {{ errFacRFC }}</strong>
									</span>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
								<div class="form-group"
									v-bind:class="{'has-error': errFacDomicilio }">
									<label class="control-label" for="facDomicilio">Domicilio
										Fiscal</label> <input v-model="facDomicilio"
										ref="facDomicilio" type="text" id="facDomicilio"
										name="facDomicilio" class="form-control" disabled="disabled">
									<span v-if='errFacDomicilio' class='help-block'> <strong> {{
											errFacDomicilio }}</strong>
									</span>
								</div>
							</div>
							<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
								<div class="form-group"
									v-bind:class="{'has-error': errFacNumero}">
									<label class="control-label" for="facNumero">No.</label> <input
										v-model="facNumero" ref="facNumero" type="text" id="facNumero"
										name="facNumero" class="form-control" disabled="disabled"> <span
										v-if='errFacNumero' class='help-block'> <strong> {{
											errFacNumero }}</strong>
									</span>
								</div>
							</div>
						</div>

						<div class="row">

							<div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
								<div class="form-group"
									v-bind:class="{'has-error': errFacColonia}">
									<label class="control-label" for="facColonia">Colonia</label> <input
										v-model="facColonia" ref="facColonia" type="text"
										id="facColonia" name="facColonia" class="form-control"
										disabled="disabled"> <span v-if='errFacColonia'
										class='help-block'> <strong> {{ errFacColonia }}</strong>
									</span>
								</div>
							</div>
							<div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
								<div class="form-group"
									v-bind:class="{'has-error': errFacCiudad}">
									<label class="control-label" for="facCiudad">Ciudad</label> <input
										v-model="facCiudad" ref="facCiudad" type="text" id="facCiudad"
										name="facCiudad" class="form-control" disabled="disabled"> <span
										v-if='errFacCiudad' class='help-block'> <strong> {{
											errFacCiudad }}</strong>
									</span>
								</div>
							</div>
							<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
								<div class="form-group" v-bind:class="{'has-error': errFacCP}">
									<label class="control-label" for="facCP">C.P.</label> <input
										v-model="facCP" ref="facCP" maxlength="9"
										oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');"
										type="text" id="facCP" name="facCP" class="form-control"
										disabled="disabled"> <span v-if='errFacCP' class='help-block'>
										<strong> {{ errFacCP }}</strong>
									</span>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
								<div class="form-group"
									v-bind:class="{'has-error': errFacTelefono}">
									<label class="control-label" for="Telefonos">Telefono</label> <input
										v-model="facTelefono" ref="facTelefono" type="text"
										id="facTelefono" name="facTelefono" class="form-control"
										disabled="disabled"> <span v-if='errFacTelefono'
										class='help-block'> <strong> {{ errFacTelefono }}</strong>
									</span>
								</div>
							</div>
							<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
								<div class="form-group"
									v-bind:class="{'has-error': errFacEmail}">
									<label class="control-label" for="facEmail">EMail</label> <input
										v-model="facEmail" ref="facEmail" type="email" id="facEmail"
										name="facEmail" class="form-control" disabled="disabled"
										pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" required> <span
										v-if='errFacEmail' class='help-block'> <strong> {{ errFacEmail
											}}</strong>
									</span>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-lg-12">
								<label class="control-label" for="facCFDI">Uso CFDI</label> <select
									id="facCFDI" name="facCFDI" class="form-control"
									v-model="facCFDI" disabled="disabled">
									<option value="0">-- Seleccione Uso CFDI --</option>
								<?php
									foreach ($lstUsoCFDI as $u) {
										echo "<option value=\"" . $u["value"] . "\">" . $u["theoption"] . "</option>";
									}
									
									?> 
							</select> <span v-if='errFacCFDI' class='help-block'> <strong> {{
										errFacCFDI }}</strong>
								</span>

							</div>

						</div>
						<div class="row">
							<div class="col-lg-12">
								<label class="control-label" for="facRegimenFiscal">R&eacute;gimen</label> <select
									id="facRegimenFiscal" name="facRegimenFiscal" class="form-control"
									v-model="facRegimenFiscal" disabled="disabled">									
								<?php
									foreach ($lstRegimenFiscal as $u) {
										echo "<option value=\"" . $u["value"] . "\">" . $u["theoption"] . "</option>";
									}
									
									?> 
							</select> 

							</div>

						</div>
						
						<div class="row">
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<div class="form-group pull-right">
									
									<h2><small>Total: </small> <strong> {{ formatNumber(facTotal) }}</strong> </h2> 
									
								</div>
							</div>
							
						</div>
					</div>
				</div>

				<hr>

				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

				    <input type="text" v-model="factura" id="factura" name="factura" maxlength="50"
							class="form-control" v-bind="countdown()" > 
							<p class='text-right text-small'>{{count}}</p>
					<label v-if="!factura"
							class="text-danger">Ingresa la(s) Factura(s)</label>

					</div>
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</div>

					<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
						<button @click.prevent="autorizarPedido" class="btn btn-success">
							Asignar Factura</button>
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

<!-- Actualizar Motivo Autorizaci�n -->
<div class="modal inmodal fade" id="modalLoad"
	tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
				</button>
				<h4 class="modal-title">Actualizar Observaci&oacute;n de
					Autorizaci&oacute;n</h4>
				<!-- 				<small class="font-bold"></small> -->
				<!-- 				<br> -->
				<!-- 				<small class="font-bold"></small> -->
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

						Cargando
					</div>
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</div>


					<div class="clearfix"></div>

				</div>

			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-white" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>
<!-- Button trigger modal -->
<div class="ibox-content m-b-sm border-bottom">
	<div class="row">
		<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
			<div class="form-group">
				<label class="control-label" for="order_id">No Pedido</label> <input
					v-model="noPedido" type="text" id="order_id" name="order_id"
					value="" placeholder="-- TODOS --" class="form-control">
			</div>
		</div>
		<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
			<div class="form-group">



				<label class="control-label" for="status">Estatus</label> <select
					v-model="estatus" class="form-control">
					<option value='0'>-- Todos --</option>
					
					<?php echo $listaEstatus; ?>
					
					
					
										
					
					
				</select>
			</div>
		</div>
		<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
			<div class="form-group">
				<label class="control-label" for="customer">Cliente</label> <input
					v-model="cliente" type="text" id="customer" name="customer"
					value="" placeholder="-- Todos --" class="form-control">
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
			<button @click.prevent="filtrar" class="btn btn-primary">Filtrar</button>
		</div>
	</div>
	<!-- 	<div class="row"> -->
	<!-- 		<div class="col-sm-4"> -->
	<!-- 			<div class="form-group"> -->
	<!-- 				<label class="control-label" for="date_added">Date added</label> -->
	<!-- 				<div class="input-group date"> -->
	<!-- 					<span class="input-group-addon"><i class="fa fa-calendar"></i></span><input -->
	<!-- 						id="date_added" type="text" class="form-control" -->
	<!-- 						value="03/04/2014"> -->
	<!-- 				</div> -->
	<!-- 			</div> -->
	<!-- 		</div> -->
	<!-- 		<div class="col-sm-4"> -->
	<!-- 			<div class="form-group"> -->
	<!-- 				<label class="control-label" for="date_modified">Date modified</label> -->
	<!-- 				<div class="input-group date"> -->
	<!-- 					<span class="input-group-addon"><i class="fa fa-calendar"></i></span><input -->
	<!-- 						id="date_modified" type="text" class="form-control" -->
	<!-- 						value="03/06/2014"> -->
	<!-- 				</div> -->
	<!-- 			</div> -->
	<!-- 		</div> -->
	<!-- 		<div class="col-sm-4"> -->
	<!-- 			<div class="form-group"> -->
	<!-- 				<label class="control-label" for="amount">Amount</label> <input -->
	<!-- 					type="text" id="amount" name="amount" value="" placeholder="Amount" -->
	<!-- 					class="form-control"> -->
	<!-- 			</div> -->
	<!-- 		</div> -->
	<!-- 	</div> -->

</div>
<div class="modal" tabindex="-1" role="dialog" id="openmodal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Cargando informaci&oauten</h4>
      </div>
      <div class="modal-body">
        <p>Por favor espere</p>
        <div class="progress">
  <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
    <span class="sr-only">100% Complete (danger)</span>
  </div>
</div>
      </div>
      <div class="modal-footer">
        
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div class="row">
	<div class="col-lg-12">
		<div class="ibox">
			<div class="ibox-content">
				<div style="overflow-x: auto;">
					<div id="listadoPedidos"></div>
				</div>
			</div>
		</div>
	</div>
</div>