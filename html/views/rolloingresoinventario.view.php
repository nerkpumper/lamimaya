<?php
$titlePage = "Ingreso de Rollos";
$breadCum = "Productos/Rollo/Ingreso de Rollos";
$buttonAction = "Regresar al Listado/fnRegresarAListado";
$_lugar = LUGAR_PRODUCTOS_ROLLO;

?>



<div class="row" >
	<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <div class="ibox">
            <div class="ibox-content m-b-sm border-bottom">
            	<div class="">            		
            		<h1 class="text-success">{{ codigo }}</h1>
            		<h3><span><strong>{{ descripcion }}</strong></span></h3>
            <!-- 		<br> -->
            <!-- 		<span><strong>Proveedor:&nbsp;&nbsp;&nbsp;&nbsp;</strong>{{ proveedor }}</span> -->
            	</div>
            </div>
        </div>
	</div>
	<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <div class="ibox">
            <div class="ibox-content m-b-sm border-bottom">
            	<div class="row">
    				<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
    					<div class="form-group" v-bind:class="{'has-error': errRemision}">
    						<label class="control-label" for="price">Remisi&oacute;n</label> <input
    							type="text" id="remision" name="remision" v-model="remision"
    							ref="remision" placeholder="Remisi&oacute;n" class="form-control"
    							maxlength="20" 
    							onKeypress="if (event.keyCode < 48 || event.keyCode > 57) event.returnValue = false;">
    						<span class='help-block'> <strong>{{ errRemision }}</strong>
    						</span>
    					</div>
    				</div>
    				<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
    					<div class="form-group" v-bind:class="{'has-error': errAlmacen}">
    						<label class="control-label" for="almacen">Almac&eacute;n</label> 
    						<select class="form-control" v-model="almacen">
    							<option value="NS">-- Seleccione --</option>
    							<option value="ALMACEN PRINCIPAL">ALMACEN PRINCIPAL</option>
    							<option value="MCM">MCM</option>
    							<option value="ALPES">ALPES</option>
    							<option value="CASA">CASA</option>
    							<option value="NARCISO">NARCISO</option>    							
								<option value="LAGOS">LAGOS</option>    							
    						</select>
    						<span class='help-block'> <strong>{{ errAlmacen }}</strong>
    						</span>
    					</div>
    				</div>
    				<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
    					<div class="form-group" v-bind:class="{'has-error': errComprador}">
    						<label class="control-label" for="comprador">Comprador</label> 
    						<select class="form-control" v-model="comprador	">
    							<option value="NS">-- Seleccione --</option>
    							<option value="GALVAMEX">GALVAMEX</option>
    							<option value="MENDEZ">MENDEZ</option>
    							    							
    						</select>
    						<span class='help-block'> <strong>{{ errComprador }}</strong>
    						</span>
    					</div>
    				</div>
    			</div>
            	
            </div>
        </div>
	</div>
</div>

<div class="row" >
	<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <div class="ibox">
            <div class="ibox-content m-b-sm border-bottom">
            	<div class="p-xs">
            		<div class="col-lg-3 ">
            			<div class="pull-left m-r-md">
                			<i class="fa fa-qrcode text-navy mid-icon"></i>
                		</div>
            		</div>
            		<div class="col-lg-8">
            		            		
            			<input
    							type="text" id="noRollo" name="noRollo" v-model="noRollo"
    							ref="noRollo" placeholder="Leer QR" maxlength="40"
    							v-on:keypress.enter="enlistarNoRollo"    							
    							class="form-control input-lg"> 
    					<span class='help-block'> 
    						<strong>{{
    								errNoRollo }}</strong>
    					</span>
            		</div>
            		
            		
            		
            	</div>
            	
            	<div class="clearfix"></div>
            </div>
        </div>
	</div>
</div>


<!-- <div class="row" v-if="!blnProcesado"> -->
<!-- 	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> -->
<!-- 		<div class="ibox"> -->
<!--     		<div class="ibox-content m-b-sm border-bottom"> -->
    		
<!--     			<div class="row"> -->
<!--     				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-6"> -->
<!--     					<div class="form-group" v-bind:class="{'has-error': errRemision}"> -->
<!--     						<label class="control-label" for="price">Remisi&oacute;n</label> <input -->
<!--     							type="text" id="remision" name="remision" v-model="remision" -->
<!--     							ref="remision" placeholder="Remisi&oacute;n" class="form-control" -->
<!--     							maxlength="20" v-on:keypress.enter="app.$refs.noRollo.focus();" -->
<!--     							onKeypress="if (event.keyCode < 48 || event.keyCode > 57) event.returnValue = false;"> -->
<!--     						<span class='help-block'> <strong>{{ errRemision }}</strong> -->
<!--     						</span> -->
<!--     					</div> -->
<!--     				</div> -->
    		
<!--     				<div class="col-lg-4 col-md-4 col-sm-6 col-xs-6"> -->
<!--     					<div class="form-group" v-bind:class="{'has-error': errNoRollo}"> -->
<!--     						<label class="control-label" for="price">Rollo</label>  -->
<!--     						</span> -->
<!--     					</div> -->
<!--     				</div> -->
    		
<!--     				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-6"> -->
<!--     					<div class="form-group" v-bind:class="{'has-error': errKilos}"> -->
<!--     						<label class="control-label" for="price">Kilos</label> <input -->
<!--     							type="text" id="kilos" name="kilos" v-model="kilos" ref="kilos" -->
<!--     							placeholder="Kilos" v-on:keypress.enter="listarIngreso" -->
<!--     							oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" -->
<!--     							class="form-control" maxlength="5"> <span class='help-block'> <strong>{{ -->
<!--     								errKilos }}</strong> -->
<!--     						</span> -->
<!--     					</div> -->
<!--     				</div> -->
    		
<!--     				<div class="col-lg-2 col-md-2 col-sm-6 col-xs-6"> 
    					<div class="form-group" style="margin-top: 20px;">-->				
    								<?php
    								
//     								Form::buttonPrimary ( "Enlistar", "listarIngreso" );
    								
//     								?>
<!--     							</div> -->
<!--     				</div> -->
    				
    				
    		
<!--     			</div> -->
    		
<!--     		</div> -->
<!--     	</div> -->
				
<!-- 	</div> -->
	
<!-- </div> -->

<div v-if="blnProcesado">
	<?php
								
		Form::buttonPrimary ( "Nueva Recepci&oacute;n", "nuevaRecepcion" );
								
	?>
	<br>	
	<br>
</div>


<div class="ibox">
	<div class="ibox-content">
		<div style="overflow-x: auto;">
			<div v-if="blnNoRegistrados" class="alert alert-danger">
            	No se han registrado la recepci&oacute;n de los rollos. Favor de verificar.
            </div>

			<table class="table table-hover table-striped no-margins">
				<thead>
					<tr>
						<th># Rollo</th>
						<th>Kilos</th>
						<th class="text-center">&iquest;Corresponde Calibre?</th>
						<th class="text-center">&iquest;Corresponde Pies?</th>
						<th class="text-center">&iquest;Puede ingresar al Sistema?</th>
						<th class="text-center">&iquest;&Uacute;nico en lista?</th>
						<th>Msg</th>
						<th>Acci&oacute;n</th>
					</tr>
				</thead>
				<tbody>
					<tr v-for="(item, index) in ingresos">
						 
						<td class="text-navy"><h3>{{ item.norollo }}</h3></td>
						<td>{{ item.kilos }}</td>
						<td class="text-center">
							 {{ item.calibre }} &nbsp;
							<i v-show="item.okcalibre == 'SI'" class="fa fa-check fa-lg text-navy"></i>
							<i v-show="item.okcalibre == 'NO'" class="fa fa-times fa-lg text-danger"></i>
						</td>
						<td  class="text-center">
							{{ item.pies }} &nbsp;
							<i v-show="item.okpies == 'SI'" class="fa fa-check fa-lg text-navy"></i>
							<i v-show="item.okpies == 'NO'" class="fa fa-times fa-lg text-danger"></i>
						</td>
						<td class="text-center">
							<i v-show="item.oksistema == 'SI'" class="fa fa-check fa-lg text-navy"></i>
							<i v-show="item.oksistema == 'NO'" class="fa fa-times fa-lg text-danger"></i>
						</td>
						<td class="text-center">
							<i v-show="item.oklista == 'SI'" class="fa fa-check fa-lg text-navy"></i>
							<i v-show="item.oklista == 'NO'" class="fa fa-times fa-lg text-danger"></i>
						</td>
						<td>
							<span v-show="item.okcalibre == 'NO'" class="badge badge-danger">CALIBRE NO CORRESPONDE AL ROLLO</span>
							<span v-show="item.okpies == 'NO'" class="badge badge-danger">PIES NO CORRESPONDE AL ROLLO</span>
							<span v-show="item.oklista == 'NO'" class="badge badge-warning"># ROLLO SE HA ENLISTADO MAS DE UNA VEZ</span>
							<span v-show="item.oksistema == 'NO'" class="badge badge-danger">-- # ROLLO YA EXISTE EN EL SISTEMA --</span>
							
							<span v-show="item.okcalibre == 'SI' && item.okpies == 'SI' && item.oklista == 'SI' && item.oksistema == 'SI' && item.insertado == 'NO'" class="badge badge-primary">OK</span>
							
							<span v-show="item.insertado == 'SI'" class="badge badge-primary">INGRESADO A SISTEMA</span>
						</td>
						<td >			
							<div v-show="item.insertado == 'NO'">
								<?php Form::singleButtonDanger("X", "quitarIngreso(index)", "!blnProcesado", "btn-xs");?>
							</div>				
							
<!-- 							<div v-if="blnProcesado" v-html="getIconProceso(index)"> -->
<!-- 							</div> -->
						</td>
					</tr>
				</tbody>
			</table>

			<div style="margin-top: 3%;">
				<hr>
						<?php
						
						Form::openGroupForButtons ();
						Form::singleButtonPrimary ( "Registrar No Rollos al Sistema", "registrarIngreso", "ingresos.length > 0 && !blnProcesado", "", "l2" );
						Form::closeGroupForButtons ();
						
						?>
					</div>
		</div>
	</div>
</div>


<!-- <pre> -->
<!-- 	{{ $data }} -->
<!-- </pre> -->

