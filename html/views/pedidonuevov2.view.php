<?php
// $_showPageHeading = false;

$titlePage = "Pedido";
// $breadCum = "Ventas/Pedido/Nuevo";
$_lugar = LUGAR_VENTAS_NUEVOPEDIDO;

$_addHead="
 		<link href='".URL_BASE."assets/inspinia/css/plugins/toastr/toastr.min.css' rel='stylesheet'>
 		<link href='".URL_BASE."assets/inspinia/css/plugins/footable/footable.core.css' rel='stylesheet'>
 		<link href='".URL_BASE."assets/inspinia/css/plugins/datapicker/datepicker3.css' rel='stylesheet'>
 		<link href='".URL_BASE."assets/inspinia/css/plugins/clockpicker/clockpicker.css' rel='stylesheet'>

        <link href=\"".URL_BASE."assets/inspinia/css/plugins/iCheck/custom.css\" rel=\"stylesheet\">
        <link href=\"".URL_BASE."assets/inspinia/css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css\" rel=\"stylesheet\">

 		";

$_addScript="
 		<script src=\"".URL_BASE."assets/inspinia/js/plugins/toastr/toastr.min.js\"></script>
 		<script src=\"".URL_BASE."assets/inspinia/js/plugins/footable/footable.all.min.js\"></script>
 		<script src=\"".URL_BASE."assets/inspinia/js/plugins/datapicker/bootstrap-datepicker.js\"></script>

		<script src=\"".URL_BASE."assets/inspinia/js/plugins/clockpicker/clockpicker.js\"></script>

        <script src=\"".URL_BASE."assets/inspinia/js/plugins/iCheck/icheck.min.js\"></script>

 		";

// if (Permisos::userIsThisRol(Permisos::$idROOTUSER))
// {
//     echo "<pre>Token: {{ \$data.token }}
// TokenDone: {{ \$data.tokenDone }}
//          </pre>";
    
//     echo "<pre>";
    
//     echo "molPrecioCorteBase: {{ \$data.molPrecioCorteBase }} <br><br>";
//     echo "molIndexMoldura: {{ \$data.molIndexMoldura}} <br>";
//     echo "molIdProducto: {{ \$data.molIdProducto}} <br>";
//     echo "molCantidad: {{ \$data.molCantidad}} <br>";
//     echo "molMoldurasXLaminas: {{ \$data.molMoldurasXLaminas}} <br>";
//     echo "molMoldurasXLaminaTodo: {{ \$data.molMoldurasXLaminaTodos}} <br>";
//     echo "molCantUnidad: {{ \$data.molCantUnidad}} <br>";
//     echo "molDesarrollo: {{ \$data.molDesarrollo}} <br>";
//     echo "molDesarrolloV2: {{ \$data.molDesarrolloV2}} <br>";
//     echo "molIdRollo: {{ \$data.molIdRollo}} <br>";
//     echo "molIdRolloV2: {{ \$data.molIdRolloV2}} <br>";
//     echo "molDescripcion: {{ \$data.molDescripcion}} <br>";
//     echo "molStrTemp: {{ \$data.molStrTemp}} <br>";
//     echo "molDobleces: {{ \$data.molDobleces}} <br>";
//     echo "molPies: {{ \$data.molPies}} <br>";
//     echo "molPiesXDesarrollo: {{ \$data.molPiesXDesarrollo}} <br>";
//     echo "molCalibre: {{ \$data.molCalibre}} <br>";
//     echo "molDividirLamina: {{ \$data.molDividirLamina}} <br>";
//     echo "molPrecioRollo: {{ \$data.molPrecioRollo}} <br>";
//     echo "molPrecioCM: {{ \$data.molPrecioCM}} <br>";
//     echo "molPrecioADar: {{ \$data.molPrecioADar}} <br>";
//     echo "molPrecioMetroMoldura: {{ \$data.molPrecioMetroMoldura}} <br>";
//     echo "molIdMaterial: {{ \$data.molIdMaterial}} <br>";
//     echo "molCostoCorte: {{ \$data.molCostoCorte}} <br>";
//     echo "molCostoDobles: {{ \$data.molCostoDobles}} <br>";
//     echo "molCostoCorteMaquila: {{ \$data.molCostoCorteMaquila}} <br>";
//     echo "molCostoDoblesMaquila: {{ \$data.molCostoDoblesMaquila}} <br>";
//     echo "molError: {{ \$data.molError}} <br>";
//     echo "molMsgAgregarMasMolduras: {{ \$data.molMsgAgregarMasMolduras}} <br>";
//     echo "molTextoBotonAddMoldura: {{ \$data.molTextoBotonAddMoldura}} <br>";
//     echo "molTextoBotonCancelAddMoldura: {{ \$data.molTextoBotonCancelAddMoldura}} <br>";
    
//     echo "molPrecioADar: {{ \$data.molPrecioADar}} <br>";
//     echo "molPrecioCM: {{ \$data.molPrecioCM}} <br>";
//     echo "molIsScrap: {{ \$data.molIsScrap}} <br>";
    
//     echo "molTotalCMScrap: {{ \$data.molTotalCMScrap}} <br>";
    
    
    
//         echo "</pre>";
// //     //     echo "<pre>{{ \$data }}</pre>";
    
// //     //     echo "<pre>{{ \$data.otrosCargos }}</pre>";
// //     //  echo "<pre>{{ \$data.productos }}</pre>";
// // //     echo "<pre>{{ \$data.listadoPedido }}</pre>";
// }
?>



<!-- <pre>{{molLaminasCobrar}}</pre> -->

<!-- <button class="btn btn-primary" @click.prevent="agregarMoldura">Moldura</button> -->

<!-- Agregar Producto MOLDURA VERSION 2 -->
<div class="modal inmodal" id="modalAgregarMolduraV2" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
<!-- <div> -->
	<div class="modal-dialog modal-lg">
		<div class="modal-content animated bounceInRight">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
				</button>
				<i class="fa fa-shopping-cart modal-icon"></i>
				<h4 class="modal-title"><span v-show="!molIsMaquila">Molduras</span><span v-show="molIsMaquila">Maquila</span></h4>
				<div v-show="!molIsMaquila">
					<!-- 				Pies: {{ molPiesXDesarrollo }} -- Div: {{ molDividirLamina }} --  Material {{ molIdMaterial }} -- IdRollo: {{ molIdRollo  }} -- Precio: {{ molPrecioRollo }} -- Precio a Dar: {{ molPrecioADar }} -->
<!--     				Precio L&aacute;mina completa: {{ molPrecioRollo }} -->
<!--     				<br> -->
<!--     				Precio ML (Sin Corte ni Dobleces): {{ molPrecioMetroMoldura }} -->
    <!-- 				<br> -->
    <!-- 				{{ molCostoCorte }} - {{ molCostoDobles }} -->
    <!-- 				<br> -->
    <!-- 				{{ molStrTemp }} -->
				</div>


				<div v-show="molIsMaquila">
				</div>
				
				
				<!-- 						<br> -->
				<!-- 						tp {{ tipoPrecioModal }} su {{ shortUnidadModal }} Cant {{ cantidadModal }} dT {{ desarrolloTModal }} dI {{ desarrolloIModal }} do {{ doblecesModal }} -->
			</div>
			<div class="modal-body">
				
				<div class="row m-b-xs">
					<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 m-b">
						<!-- 											metros cuad piezas (int) kg ml -->
						<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
							<div class="form-group">
								<label class="control-label">Cantidad</label> <input type="text"
									v-model="molCantidad" placeholder=""
									oninput="this.value = this.value.replace(/[^0-9\t]/g, '').replace(/(\..*)\./g, '$1');"
									maxlength="9" class="form-control">
							</div>
						</div>
					</div>
					<div 
						class="col-lg-6 col-md-12 col-sm-12 col-xs-12 m-b">
						<!-- 											metros cuad piezas (int) kg ml -->
						<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
							<div class="form-group">
								<label class="control-label">Metros Lineales</label> <input
									type="text" v-model="molCantUnidad" placeholder=""
									oninput="this.value = this.value.replace(/[^0-9.\t]/g, '').replace(/(\..*)\./g, '$1');"
									maxlength="9" class="form-control">
							</div>
						</div>
					</div>
				</div>
				<div class="row m-b-xs">
					
					<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
						<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
							<div class="form-group">
    							<label class="control-label">Desarrollo (1 - 122 cm)</label> 
    							<input
									type="text" v-model="molDesarrolloV2" placeholder=""
									oninput="this.value = this.value.replace(/[^0-9.\t]/g, '').replace(/(\..*)\./g, '$1');"
									maxlength="9" class="form-control">
									
								<div v-show="!ismolDesarrolloV2Valido" class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
        							<div class="alert alert-danger">
        								El Desarrollo debe estar entre 1 y 122 cm
        							</div>
        						</div>
<!--     							<select -->
<!--     								v-model="molDesarrollo" class="form-control"> -->
<!--     								<option value="0">--Seleccione--</option> -->
<!--     								<option v-for="des in desarrollosTernium" -->
<!--     									:value="des.desarrollo">{{ des.desarrollo }}</option> -->
<!--     							</select> -->
    						</div>
						</div>
						
					</div>
					
					<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
						<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
							<div class="form-group">
    							<label class="control-label">S&oacute;lo Dobleces</label> <select
    								v-model="molDoblecesV2" class="form-control">
    								<option value="0">--Seleccione--</option>
    								<option value="1">1</option>
    								<option value="2">2</option>
    								<option value="3">3</option>
    								<option value="4">4</option>
    								<option value="5">5</option>
    								<option value="6">6</option>
    								<option value="7">7</option>
    								<option value="8">8</option>
    								<option value="9">9</option>
    								<option value="10">10</option>
    								<option value="11">11</option>
    								<option value="12">12</option>
    								<option value="13">13</option>
    								<option value="14">14</option>
    								<option value="15">15</option>
    								<option value="16">16</option>
    								<option value="17">17</option>
    								<option value="18">18</option>
    								<option value="19">19</option>
    								<option value="20">20</option>
    							</select>
    						</div>
						</div>
						
					</div>
					

				</div>
				
				<div v-show="molDesarrolloV2 > 0 && !molIsMaquila" class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
        			<div class="alert alert-info">
        				<strong>GALVANIZADA Y ZINTRO ALUM</strong><br>
<!--         				molXLaminas3Pies: {{ molXLaminas3Pies }} <br> -->
<!--         				moldurasSueltas3Pies: {{ moldurasSueltas3Pies }} <br> -->
<!--         				molXLaminas3PiesAUsarCompletas: {{ molXLaminas3PiesAUsarCompletas }} <br> -->
<!--         				molXLaminas3PiesAUsar: {{ molXLaminas3PiesAUsar }} <br> -->
<!--         				molSobrante3Pies: {{ molSobrante3Pies }} <br> -->
        				
        				<i>ROLLO 3'</i>: Molduras x rollo = <strong>{{ molXLaminas3Pies }}</strong>; laminas a utilizar = <strong>{{ molXLaminas3PiesAUsarCompletas}}</strong>; sobrante total cobrado = <strong>{{ formatNumber( molSobrante3Pies ) }} cm</strong><br>
        				
<!--         				molXLaminas4Pies: {{ molXLaminas4Pies }} <br> -->
<!--         				moldurasSueltas4Pies: {{ moldurasSueltas4Pies }} <br> -->
<!--         				molXLaminas4PiesAUsarCompletas: {{ molXLaminas4PiesAUsarCompletas }} <br> -->
<!--         				molXLaminas4PiesAUsar: {{ molXLaminas4PiesAUsar }} <br> -->
<!--         				molSobrante4Pies: {{ molSobrante4Pies }} <br> -->
        				<i>ROLLO 4'</i>: Molduras x rollo = <strong>{{ molXLaminas4Pies }}</strong>; laminas a utilizar = <strong>{{ molXLaminas4PiesAUsarCompletas}}</strong>; sobrante total cobrado = <strong>{{ formatNumber( molSobrante4Pies ) }} cm</strong><br><br>
        				
        				<strong>PINTRO POLIESTER Y SULTANA</strong><br>
<!--         				molXLaminas3Pies: {{ molXLaminas3Pies }} <br> -->
<!--         				moldurasSueltas3Pies: {{ moldurasSueltas3Pies }} <br> -->
<!--         				molXLaminas3PiesAUsarCompletas: {{ molXLaminas3PiesAUsarCompletas }} <br> -->
<!--         				molXLaminas3PiesAUsar: {{ molXLaminas3PiesAUsar }} <br> -->
<!--         				molSobrante3Pies: {{ molSobrante3Pies }} <br> -->
        				
        				<i>ROLLO 3'</i>: Molduras x rollo = <strong>{{ molXLaminas3Pies }}</strong>; laminas a utilizar = <strong>{{ molXLaminas3PiesAUsarCompletas}}</strong>; sobrante total cobrado = <strong>{{ formatNumber( molSobrante3PiesPSPP ) }} cm</strong><br>
        				
<!--         				molXLaminas4Pies: {{ molXLaminas4Pies }} <br> -->
<!--         				moldurasSueltas4Pies: {{ moldurasSueltas4Pies }} <br> -->
<!--         				molXLaminas4PiesAUsarCompletas: {{ molXLaminas4PiesAUsarCompletas }} <br> -->
<!--         				molXLaminas4PiesAUsar: {{ molXLaminas4PiesAUsar }} <br> -->
<!--         				molSobrante4Pies: {{ molSobrante4Pies }} <br> -->
        				<i>ROLLO 4'</i>: Molduras x rollo = <strong>{{ molXLaminas4Pies }}</strong>; laminas a utilizar = <strong>{{ molXLaminas4PiesAUsarCompletas}}</strong>; sobrante total cobrado = <strong>{{ formatNumber( molSobrante4PiesPSPP ) }} cm</strong><br>
        				
        				
<!--         				<i>ROLLO 3'</i>: Molduras x rollo = <strong>{{ molXLaminas3Pies }}</strong>; laminas a utilizar = <strong>{{ molXLaminas3PiesAUsarCompletas}}</strong> laminas a usar completas: {{ molXLaminas3PiesAUsar }} sobra indi: {{ (91.44 - (molXLaminas3Pies * molDesarrolloV2))  }} ; sobrante = <strong>{{ formatNumber( molSobrante3Pies ) }} cm</strong><br> -->
<!--         				<i>ROLLO 4'</i>: Molduras x rollo = <strong>{{ molXLaminas4Pies }}</strong>; laminas a utilizar = <strong>{{ molXLaminas4PiesAUsarCompletas }}</strong> laminas a usar completas: {{ molXLaminas4PiesAUsar }} sobra indi: {{ (122 - (molXLaminas4Pies * molDesarrolloV2))  }} ; sobrante = <strong>{{ formatNumber( molSobrante4Pies ) }} cm</strong> -->
        				
<!--         				<i>ROLLO 3'</i>: Molduras x rollo = <strong>{{ molXLaminas3Pies }}</strong>; laminas a utilizar = <strong>{{ molXLaminas3PiesAUsarCompletas}}</strong>; sobrante total cobrado = <strong>{{ formatNumber( molSobrante3Pies + ((91.44 - (molXLaminas3Pies * molDesarrolloV2)) * Math.trunc(molCantidad / molXLaminas3Pies)) ) }} cm</strong><br> -->
<!--         				<i>ROLLO 4'</i>: Molduras x rollo = <strong>{{ molXLaminas4Pies }}</strong>; laminas a utilizar = <strong>{{ molXLaminas4PiesAUsarCompletas}}</strong>; sobrante total cobrado = <strong>{{ formatNumber( molSobrante4Pies + ((122   - (molXLaminas4Pies * molDesarrolloV2)) * Math.trunc(molCantidad / molXLaminas4Pies)) ) }} cm</strong><br> -->
        				
        				 
<!--         				Molduras X Rollo 3": <strong>{{ molXLaminas3Pies }}</strong>, Sobrante de <strong>Rollo 3"</strong> : <strong>{{ formatNumber( molSobrante3Pies ) }} cm</strong> <br> -->
<!--         				Molduras X Rollo 4": <strong>{{ molXLaminas4Pies }}</strong>, Sobrante de <strong>Rollo 4"</strong> : <strong>{{ formatNumber( molSobrante4Pies ) }} cm</strong> <br> -->
        			</div>
        		</div>
				
				
				<div class="row m-b-xs">
					
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
<!-- 						<div v-show="molDesarrolloV2 == '0' || molDesarrolloV2 == '' " class="col-lg-6 col-md-6 col-sm-6 col-xs-12"> -->
<!-- 						<div  class="col-lg-6 col-md-6 col-sm-6 col-xs-12"> -->
<!-- 							<div class="alert alert-warning"> -->
<!-- 								Indique un Desarrollo para seleccionar el Rollo -->
<!-- 							</div> -->
<!-- 						</div> -->
<!-- 						<div v-show="molDesarrolloV2 > '0' " class="col-lg-11 col-md-11 col-sm-11 col-xs-12"> -->
						<div  class="col-lg-11 col-md-11 col-sm-11 col-xs-12">
							<div class="form-group">
    							<label class="control-label">Rollo</label> <select
    								v-model="molIdRolloV2"
    								 class="form-control">
    								<option value="0">--Seleccione Rollo--</option>
    								<option v-for="ro in rollosExistenciasXDesarrollo34"
    									:value="ro.idrollo">{{ ro.descauto }}</option>
    							</select>
<!--     							<div v-show="molPiesXDesarrolloSugerido > 0" class="col-lg-12 col-md-12 col-sm-6 col-xs-12"> -->
<!--         							<div class="alert alert-info"> -->
<!--         								Se sugiere un Rollo de {{ molPiesXDesarrolloSugerido }} Pies <span v-show="molIsMaquila"> (Este dato es s&oacute;olo informatico)</span> -->
<!--         							</div> -->
<!--         						</div> -->
    						</div>
						</div>
						
					</div>
					

				</div>
				
				<hr>
				
				<div v-show="!molIsMaquila">
					<div class="row m-b-xs">
					
						
                    	
                    	
                    	<?php if ($objSession->getIdUsuario() != 9 && $objSession->getIdUsuario() != 10 && $objSession->getIdUsuario() != 13):?>
                    	
                    	
                    		<div class="col-sm-2">
    <!--                 		Forzar que el cliente salde sus Pedidos para Autorizar su Producci&oacute;n -->
        						Producto de Scrap
                        	</div>
                    	
                        	<div class="col-sm-2">
                        		<div class="switch">
                            		<div class="onoffswitch">
                            			<input type="checkbox" class="onoffswitch-checkbox"
                            				id="molIsScrap" v-model="molIsScrap"> <label class="onoffswitch-label" for="molIsScrap"> <span
                            				class="onoffswitch-inner"></span> <span class="onoffswitch-switch"></span>
                            			</label>
                            		</div>
                            	</div>
                        	</div>
                        <?php endif;?>
                    	
                    	
                    </div>
                    
                    <div v-show="molIsScrap" class="row">
                    	<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
    						<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
    							<div class="form-group">
        							<label class="control-label">Total de cm a utilizar en Scrap</label> 
        							<input
    									type="text" v-model="molTotalCMScrap" placeholder=""
    									oninput="this.value = this.value.replace(/[^0-9.\t]/g, '').replace(/(\..*)\./g, '$1');"
    									maxlength="9" class="form-control">
    									
<!--     								<div v-show="!ismolDesarrolloV2Valido" class="col-lg-12 col-md-12 col-sm-6 col-xs-12"> -->
<!--             							<div class="alert alert-danger"> -->
<!--             								El Desarrollo debe estar entre 1 y 121.92 cm -->
<!--             							</div> -->
<!--             						</div> -->
    
        						</div>
    						</div>
    						
    					</div>
                    </div>
				</div>
				
				
				
				<div v-show="molError" class="row m-b-xs">
					<div v-html="molError" class="alert alert-danger"></div>
				</div>

				<div v-show="molMsgAgregarMasMolduras" class="row m-b-xs">
					<div v-show="!molIsMaquila" class="alert alert-info">
						Moldura Agregada, puede agregar otra Moldura si lo desea.
					</div>
					<div v-show="molIsMaquila" class="alert alert-info">
						Maquila Agregada, puede agregar otra Maquila si lo desea.
					</div>
					
				</div>
				
			</div>
			<div class="modal-footer">		
			<button type="button" class="btn btn-warning" data-dismiss="modal">{{ molTextoBotonCancelAddMoldura  }}</button>		
				<button @click.prevent="agregarMolduraAPedidoV2" type="button"
					class="btn btn-primary">{{ molTextoBotonAddMoldura }}</button>
			</div>
		</div>
	</div>
</div>
<!-- Fin Agregar Producto MOLDURA VERSION 2 -->

<!-- Agregar Producto MOLDURA -->
<div class="modal inmodal" id="modalAgregarMoldura" tabindex="-1" role="dialog"
	aria-hidden="true" data-backdrop="static">
	<div class="modal-dialog modal-lg">
		<div class="modal-content animated bounceInRight">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
				</button>
				<i class="fa fa-shopping-cart modal-icon"></i>
				<h4 class="modal-title"><span v-show="!molIsMaquila">Molduras</span><span v-show="molIsMaquila">Maquila</span></h4>
				<div v-show="!molIsMaquila">
					<!-- 				Pies: {{ molPiesXDesarrollo }} -- Div: {{ molDividirLamina }} --  Material {{ molIdMaterial }} -- IdRollo: {{ molIdRollo  }} -- Precio: {{ molPrecioRollo }} -- Precio a Dar: {{ molPrecioADar }} -->
    				Precio L&aacute;mina completa: {{ molPrecioRollo }}
    				<br>
    				Precio ML (Sin Corte y Dobleces): {{ molPrecioMetroMoldura }}
    <!-- 				<br> -->
    <!-- 				{{ molCostoCorte }} - {{ molCostoDobles }} -->
    <!-- 				<br> -->
    <!-- 				{{ molStrTemp }} -->
				</div>


				<div v-show="molIsMaquila">
				</div>
				
				
				<!-- 						<br> -->
				<!-- 						tp {{ tipoPrecioModal }} su {{ shortUnidadModal }} Cant {{ cantidadModal }} dT {{ desarrolloTModal }} dI {{ desarrolloIModal }} do {{ doblecesModal }} -->
			</div>
			<div class="modal-body">
				
				<div class="row m-b-xs">
					<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 m-b">
						<!-- 											metros cuad piezas (int) kg ml -->
						<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
							<div class="form-group">
								<label class="control-label">Cantidad</label> 
<!-- 								<input type="text" -->
<!-- 									v-model="molCantidad" placeholder="" -->
<!-- 									oninput="this.value = this.value.replace(/[^0-9\t]/g, '').replace(/(\..*)\./g, '$1');" -->
<!-- 									maxlength="9" class="form-control"> -->
							</div>
						</div>
					</div>
					<div 
						class="col-lg-6 col-md-12 col-sm-12 col-xs-12 m-b">
						<!-- 											metros cuad piezas (int) kg ml -->
						<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
							<div class="form-group">
								<label class="control-label">Metros Lineales</label> <input
									type="text" v-model="molCantUnidad" placeholder=""
									oninput="this.value = this.value.replace(/[^0-9.\t]/g, '').replace(/(\..*)\./g, '$1');"
									maxlength="9" class="form-control">
							</div>
						</div>
					</div>
				</div>
				<div class="row m-b-xs">
					
					<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
						<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
							<div class="form-group">
    							<label class="control-label">Desarrollo</label> <select
    								v-model="molDesarrollo" class="form-control">
    								<option value="0">--Seleccione--</option>
    								<option v-for="des in desarrollosTernium"
    									:value="des.desarrollo">{{ des.desarrollo }}</option>
    							</select>
    						</div>
						</div>
						
					</div>
					
					<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
						<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
							<div class="form-group">
    							<label class="control-label">S&oacute;lo Dobleces</label> <select
    								v-model="molDobleces" class="form-control">
    								<option value="0">--Seleccione--</option>
    								<option value="1">1</option>
    								<option value="2">2</option>
    								<option value="3">3</option>
    								<option value="4">4</option>
    								<option value="5">5</option>
    								<option value="6">6</option>
    								<option value="7">7</option>
    								<option value="8">8</option>
    								<option value="9">9</option>
    								<option value="10">10</option>
    								<option value="11">11</option>
    								<option value="12">12</option>
    								<option value="13">13</option>
    								<option value="14">14</option>
    								<option value="15">15</option>
    								<option value="16">16</option>
    								<option value="17">17</option>
    								<option value="18">18</option>
    								<option value="19">19</option>
    								<option value="20">20</option>
    							</select>
    						</div>
						</div>
						
					</div>
					

				</div>
				
				
				<div class="row m-b-xs">
					
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div v-show="molDesarrollo == '0' " class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<div class="alert alert-warning">
								Seleccione un Desarrollo
							</div>
						</div>
						<div v-show="molDesarrollo != '0' " class="col-lg-11 col-md-11 col-sm-11 col-xs-12">
							<div class="form-group">
    							<label class="control-label">Rollo</label> <select
    								v-model="molIdRollo"
    								 class="form-control">
    								<option value="0">--Seleccione Rollo--</option>
    								<option v-for="ro in rollosExistenciasXDesarrollo"
    									    									
    									:value="ro.idrollo">{{ ro.descauto }}</option>
    							</select>
    						</div>
						</div>
						
					</div>
					

				</div>
				
				
				
				
				<div v-show="molError" class="row m-b-xs">
					<div v-html="molError" class="alert alert-danger"></div>
				</div>

				<div v-show="molMsgAgregarMasMolduras" class="row m-b-xs">
					<div v-show="!molIsMaquila" class="alert alert-info">
						Moldura Agregada, puede agregar otra Moldura si lo desea.
					</div>
					<div v-show="molIsMaquila" class="alert alert-info">
						Maquila Agregada, puede agregar otra Maquila si lo desea.
					</div>
					
				</div>
				
			</div>
			<div class="modal-footer">		
			<button type="button" class="btn btn-warning" data-dismiss="modal">{{ molTextoBotonCancelAddMoldura  }}</button>		
				<button @click.prevent="agregarMolduraAPedido" type="button"
					class="btn btn-primary">{{ molTextoBotonAddMoldura }}</button>
			</div>
		</div>
	</div>
</div>
<!-- Fin Agregar Producto MOLDURA -->


<!-- <button class="btn btn-primary" @click.prevent="agregarOtrosGastos">Otros Cargos</button> -->

<!-- Manejo de Materiales -->
<div class="modal inmodal" id="modalOtrosCargos" tabindex="-1" role="dialog"
	aria-hidden="true" data-backdrop="static">
	<div class="modal-dialog ">
		<div class="modal-content animated bounceInRight">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
				</button>
<!-- 				<i class="fa fa-shopping-cart modal-icon"></i> -->
				<h4 class="modal-title">Otros Servicios</h4>
				
				
				<!-- 						<br> -->
				<!-- 						tp {{ tipoPrecioModal }} su {{ shortUnidadModal }} Cant {{ cantidadModal }} dT {{ desarrolloTModal }} dI {{ desarrolloIModal }} do {{ doblecesModal }} -->
			</div>
			<div class="modal-body">
				
				<div class="row m-b-xs" v-for="oc in otrosCargos">
<!-- 					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b"> -->
						<!-- 											metros cuad piezas (int) kg ml -->
						<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
							<div class="form-group">
								<label class="col-lg-6 col-md-6  control-label text-right">{{ oc.descripcion }}</label>
								<div class="col-lg-6 col-md-6 ">
									<input type="text"
									v-model="oc.monto"
									 placeholder=""
									oninput="this.value = this.value.replace(/[^0-9.\t]/g, '').replace(/(\..*)\./g, '$1'); "	
									maxlength="9" class="form-control text-right">
								</div> 
								
							</div>
						</div>
<!-- 					</div> -->
					
				</div>
				
				<hr>
				
				<div class="row m-b-xs" >
<!-- 					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b"> -->
						<!-- 											metros cuad piezas (int) kg ml -->
						<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
							<div class="form-group">
								<label class="col-lg-6 control-label text-right">Total</label>
								<h3 class="col-lg-6 control-label text-right">{{ formatNumber(totalOtrosCargos) }}</h3>
								
							</div>
						</div>
<!-- 					</div> -->
					
				</div>
				
				<div v-show="errorModal" class="row m-b-xs">
					<div v-html="errorModal" class="alert alert-danger"></div>
				</div>
				
			</div>
			<div class="modal-footer">				
				<button  type="button"
					class="btn btn-primary" @click.prevent="aceptaOtrosCargos">Aceptar</button>
					<button  type="button" @click.prevent="quitarOtrosCargos"
					class="btn btn-warning pull-left">Quitar todo</button>
			</div>
		</div>
	</div>
</div>
<!-- Fin Manejo de Material -->


<!-- Manejo de Curvatura -->
<div class="modal inmodal" id="modalCurvar" tabindex="-1" role="dialog"
	aria-hidden="true" data-backdrop="static">
	<div class="modal-dialog ">
		<div class="modal-content animated bounceInRight">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
				</button>
<!-- 				<i class="fa fa-shopping-cart modal-icon"></i> -->
				<h4 class="modal-title">Indicar Curvatura a Producto</h4>
				<small>Curva Actual: <strong>{{ curvaActual }}</strong></small>
				
			</div>
			<div class="modal-body">
				<div class="row m-b">
					<div class="text-center">
						<button @click.prevent="setCurva('10-15')" class="btn btn-success btn-block">10-15</button>
					</div>
				</div>
				<div class="row m-b">
					<div class="text-center">
						<button @click.prevent="setCurva('15-20')" class="btn btn-success btn-block">15-20</button>
					</div>
				</div>
				<div class="row m-b">
					<div class="text-center">
						<button @click.prevent="setCurva('20-25')" class="btn btn-success btn-block">20-25</button>
					</div>
				</div>
				
				
			</div>
			<div class="modal-footer">				
<!-- 				<button  type="button" -->
<!-- 					class="btn btn-primary" @click.prevent="aceptaOtrosCargos">Aceptar</button> -->
					<button  type="button" @click.prevent="setCurva('')"
					class="btn btn-danger pull-left">NO Combar</button>
			</div>
		</div>
	</div>
</div>


<!-- Fin Manejo de Curvatura -->

<div v-show="seleccionaCliente" :class="claseTotalClienteSegunPantalla">
	<div class="ibox float-e-margins">
		<div class="ibox-title">
			<h5>Cliente</h5>
		</div>
		<div class="ibox-content ibox-heading">
			<h3>
				<i class="fa fa-user"></i> {{ clienteSeleccionado }}
				<button v-show="idClienteSeleccionado > 0" @click.prevent="dejarClienteSeleccionado" class="btn btn-warning pull-right"><i class="fa fa-check-square-o"> Conservar</i></button>
			</h3>
			<small><i class="fa fa-tim"></i> {{ promotorClienteSeleccionado }}</small>
		</div>
		<div class="ibox-content">

			<div>
				<button v-show="!seleccionandoCliente"
					@click.prevent="seleccionarCliente"
					class="btn btn-primary pull-right">Seleccionar Existente</button>
					
<!-- 				<button class="btn btn-success" @click.prevent="registrarNuevoCliente">Registrar Nuevo Cliente</button> -->
					
				<button v-show="seleccionandoCliente" @click.prevent="cancelarSeleccionarCliente"
					class="btn btn-danger pull-right ">Cancelar</button>
			</div>

			<div v-show="seleccionandoCliente">
				<div>
					<input type="text" id="default" v-model="filtroNombreCliente"
						placeholder="Cliente" class="form-control input-lg">
				</div>

				<div class="hr-line-dashed"></div>

				<div class="feed-activity-list">
					<div v-for="cte in clientesFiltradosPorNombre" class="feed-element">
						<div>
							<!-- 									<small class="pull-right text-navy">1m ago</small>-->
							<strong>{{ cte.nombre }}</strong>
							<div>{{ cte.promotor }}</div>
							<small class="text-muted pull-right"><button
									@click.prevent="setClienteSelected(cte.id);"
									class="btn btn-primary btn-xs">Seleccionar</button></small>
						</div>
					</div>
				</div>
			</div>

			<div class="clearfix"></div>

		</div>
	</div>
</div>

<!-- <div v-if="imprimirPedido"> -->
<div id="secImprimirONuevo">
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

			<div class="ibox">
				<div class="ibox-title">
					<h2>
						<i class="fa fa-thumbs-up fa-2x"></i> Pedido Generado
					</h2>
				</div>
				<div class="ibox-content">
					<div class="row">
						<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
							<h1>Folio {{ pedidoFolio }}</h1>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12"
							style="padding-top: 10px">
							<a
								:href="'<?php echo URL_BASE;?>pedidopdf?id=' + pedidoFolio"
								target="_blank" class="btn btn-success btn-lg"><i
								class="fa fa-print"></i> Imprimir</a>
						</div>
						<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12"
							style="padding-top: 10px">
							<button @click.prevent="sendPedidoACliente"
								class="btn btn-success btn-lg">
								<i class="fa fa-envelope"></i> Enviar a Cliente
							</button>
						</div>
						<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12"
							style="padding-top: 10px">
							<a href="<?php echo URL_BASE?>pedidonuevo"
								class="btn btn-primary btn-lg"><i class="fa fa-shopping-cart"></i>
								Nuevo Pedido</a>
						</div>
						<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12"
							style="padding-top: 10px">
							<a href="pedido" class="btn btn-warning btn-lg"><i
								class="fa fa-list"></i> Ir a Listado de Pedidos</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>




<!-- <h1>Pedidos</h1> -->

<!-- <div class="ibox "> -->
<!-- 	<div class="ibox-title"> -->
<!-- 		<h5>Inspinia modal window</h5> -->

<!-- 	</div> -->
<!-- 	<div class="ibox-content"> -->

<!-- 		<div class="text-center"> -->
<!-- 			<button id="btnModalLauncher" type="button" class="btn btn-primary" -->
<!-- 				data-toggle="modal" data-target="#myModal">Launch demo modal</button> -->
<!-- 			<button @click.prevent="lanzaModal" class="btn btn-success">Lanza -->
<!-- 				Modal</button> -->
<!-- 		</div> -->
<div class="modal inmodal" id="myModal" tabindex="-1" role="dialog"
	aria-hidden="true" data-backdrop="static">
	<div class="modal-dialog">
		<div class="modal-content animated bounceInRight">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
				</button>
				<i class="fa fa-shopping-cart modal-icon"></i>
				<h4 class="modal-title">{{ descripcionModal }}</h4>
				<small class="font-bold">{{ codigoModal }}</small> <br>
				<small>
					Unidad <strong>{{ unidadModal }}</strong>
					<span v-show="shortUnidadModal == 'M2'" class="text-danger"><br>Ingrese en Metros Lineales, el sistema realizar&aacute; la conversi&oacute;n a M2.</span>
				</small>
				<!-- 						<br> -->
				<!-- 						tp {{ tipoPrecioModal }} su {{ shortUnidadModal }} Cant {{ cantidadModal }} dT {{ desarrolloTModal }} dI {{ desarrolloIModal }} do {{ doblecesModal }} -->
			</div>
			<div class="modal-body">

				<div class="row m-b-xs">
					<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 m-b">
						<!-- 											metros cuad piezas (int) kg ml -->
						<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
							<div class="form-group">
								<label class="control-label">Cantidad</label> <input type="text"
									v-model="cantidadModal" placeholder=""
									oninput="this.value = this.value.replace(/[^0-9\t]/g, '').replace(/(\..*)\./g, '$1');"
									maxlength="9" class="form-control">
							</div>
						</div>
					</div>
					<div v-show="mostrarUnidadEnModal"
						class="col-lg-6 col-md-12 col-sm-12 col-xs-12 m-b">
						<!-- 											metros cuad piezas (int) kg ml -->
						<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
							<div class="form-group">
								<label class="control-label">{{ labelUnidadEnModal }}</label> <input
									type="text" v-model="cantUnidadModal" placeholder=""
									oninput="this.value = this.value.replace(/[^0-9.\t]/g, '').replace(/(\..*)\./g, '$1');"
									maxlength="9" class="form-control">
							</div>
						</div>
					</div>
				</div>
				<div class="row m-b-xs">
					<div v-show="tipoPrecioModal != 'G'"
						class="col-lg-6  col-md-12 col-sm-12 col-xs-12 m-b">
						<div v-show="tipoPrecioModal == 'T'">
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<div class="form-group">
									<label class="control-label">Desarrollo</label> <select
										v-model="desarrolloTModal" class="form-control">
										<option value="0">--Seleccione--</option>
										<option v-for="des in desarrollosTernium"
											:value="des.desarrollo">{{ des.desarrollo }}</option>
									</select>
								</div>
							</div>
						</div>
						<div v-show="tipoPrecioModal == 'I'">
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<div class="form-group">
									<label class="control-label">Desarrollo</label> <select
										v-model="desarrolloIModal" class="form-control">
										<option value="0">--Seleccione--</option>
										<option v-for="des in desarrollosImportados"
											:value="des.desarrollo">{{ des.desarrollo }}</option>
									</select>
								</div>
							</div>
						</div>
					</div>
					<div v-show="tipoPrecioModal == 'T' || tipoPrecioModal == 'I'"
						class="col-lg-6 col-md-12 col-sm-12 col-xs-12  m-b">
						<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
							<div class="form-group">
								<label class="control-label">Dobleces</label> <select
									v-model="doblecesModal" class="form-control">
									<option value="0">--Seleccione--</option>
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
									<option value="5">5</option>
									<option value="6">6</option>
									<option value="7">7</option>
									<option value="8">8</option>
									<option value="9">9</option>
									<option value="10">10</option>
								</select>
							</div>
						</div>
					</div>

				</div>
				<div v-show="errorModal" class="row m-b-xs">
					<div v-html="errorModal" class="alert alert-danger"></div>
				</div>

				<div v-show="modalMostrarMsgAgregarMas" class="row m-b-xs">
					<div class="alert alert-info">
						Producto Agregado, puede agregar el mismo producto con otras cantidades si lo desea.
					</div>
				</div>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-warning" data-dismiss="modal">{{ textBotonCancelModal }}</button>
				<button @click.prevent="enlistaProductoDeModal" type="button"
					class="btn btn-primary">{{ textBotonAddModal }}</button>
			</div>
		</div>
	</div>
</div>

<!-- 	</div> -->
<!-- </div> -->


<!-- Modal Registrar Cliente -->
<div class="modal inmodal" id="modalRegistrarCliente" tabindex="-1" role="dialog"
	aria-hidden="true" data-backdrop="static">
	<div class="modal-dialog">
		<div class="modal-content animated bounceInRight">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
				</button>
<!-- 				<i class="fa fa-shopping-cart modal-icon"></i> -->
				<h4 class="modal-title">Registrar Nuevo Cliente</h4>
				
				<!-- 						<br> -->
				<!-- 						tp {{ tipoPrecioModal }} su {{ shortUnidadModal }} Cant {{ cantidadModal }} dT {{ desarrolloTModal }} dI {{ desarrolloIModal }} do {{ doblecesModal }} -->
			</div>
			<div class="modal-body">
				<?php
					
					Form::open("frmCliente");
							
					Form::setColsGroup("l12|m12|s12|x12");
					
					Form::hidden("idCliente");
					
					Form::row();
					Form::text("nombre", "Nombre", "60", true);
					Form::endRow();
					
					Form::row();
					Form::text("apellidos", "Apellidos", "60", true);
					Form::endRow();
					
				?>
				
				
				
				
			    
			    <?php 
					
					Form::row();
					Form::select("usuarioPromotor", "Promotor", $lstPromotores, "", "", false, false, "mostrarUsuarioPromotor");
					Form::endRow();
					
				?>
				
				<div class="row">
					
                	<div class="col-sm-2">
                		<div class="switch">
                    		<div class="onoffswitch">
                    			<input type="checkbox" class="onoffswitch-checkbox"
                    				id="chkFacturable" v-model="chkFacturable"> <label class="onoffswitch-label" for="chkFacturable"> <span
                    				class="onoffswitch-inner"></span> <span class="onoffswitch-switch"></span>
                    			</label>
                    		</div>
                    	</div>
                	</div>
                	<div class="col-sm-8">
                		Cliente facturable
                	</div>
                	
                </div>
				<br>
				
				<div v-show="chkFacturable">
				
				<?php 
					
					Form::row();
					Form::text("empresa", "Empresa", "60", true);
					Form::endRow();
					
					Form::row();
					Form::text("domicilio1", "Domicilio 1", "60", true);
					Form::endRow();
					
					Form::row();
					Form::text("domicilio2", "Domicilio 2", "60", true);
					Form::endRow();
					
					Form::row();
					Form::setColsInput("l3|m3|s12|x12");
					Form::text("numero", "N&uacute;mero", "60", true);
					Form::endRow();
					
					
					
					Form::row();					
// 					Form::setColsDefault();
					Form::setColsGroup("l12|m12|s12|x12");
					Form::setColsInput("l8|m8|s12|x12");
					Form::text("colonia", "Colonia", "60", true);
					Form::text("ciudad", "Ciudad", "60", true);
					Form::endRow();
					//Form::text("domicilio2", "Domicilio 2", "60", true);
					
					
				?>
					
				<hr>
				<h3>Datos de Facturaci&oacute;n</h3>
					
				<?php 
				
    				Form::row();
    				Form::text("razonSocial", "Raz&oacute;n Social", "250", true);
    				Form::endRow();
				
    				Form::row();
    				Form::text("domicilioFiscal", "Domicilio Fiscal", "250", true);
    				Form::endRow();
    				
    				Form::row();
    				Form::text("CP", "C. P.", "30", true);
    				Form::endRow();
				
				    Form::row();				
					Form::text("telefonos", "Telefonos", "60", true);
					Form::endRow();
					
					Form::row();
					Form::email("email", "EMail","48", true);
					Form::endRow();
					
					Form::row();
					Form::text("rfc", "R.F.C.", "98", true);
					Form::endRow();
					
					Form::row();
					Form::select("usoCFDI", "Uso CFDI", $lstUsoCFDI, "", "", false, false);
					Form::endRow();
					
				
								
				?>
				</div>
				<?php 	
					
// 					Form::buttonPrimary("Guardar", "guardarCliente");
							
				    
					Form::close();
				?>	
				

			</div>
			<div class="modal-footer">				
				<button @click.prevent="guardarCliente" type="button"
					class="btn btn-primary">Registrar y seleccionar</button>
			</div>
		</div>
	</div>
</div>
<!-- Fin Modal Registrar Cliente -->



<div v-if="debugging" class="well" v-html="debug"></div>



<div v-show="vistaPedido">

	<div class="ibox-content ibox-heading">

		<h3>
			<button @click.prevent="refreshDatosClienteSeleccionado" v-show="idClienteSeleccionado > 0" class="btn btn-primary"><i class="fa fa-refresh"></i></button>
			<i class="fa fa-user"></i> {{ clienteSeleccionado }}
			<button @click.prevent="seleccionarOtroCliente" class="btn btn-warning pull-right"><i class="fa fa-users"></i> Seleccionar otro Cliente</button>
		</h3>
		<small><i class="fa fa-tim"></i> {{ promotorClienteSeleccionado }}</small>


	</div>

	<div class="ibox-content p-xl" id="tablero">



		<div v-show="mostrarTiposProducto">
			<h3>Selecciona Tipo de Producto</h3>


			<div v-show="!isPantallaGrande">
				<div v-for="tipo in tiposProducto"
					class="col-lg-2 col-md-2 col-sm-12 col-xs-12"
					style="cursor: pointer;" v-on:click="listarProductos(tipo.id);">
					<!-- 			<div class="widget navy-bg text-center" > -->
					<!-- 				<div class="m-b-md"> -->
					<!-- 					<i class="fa fa-cubes fa-4x"></i> -->
					<!-- 					<h1 class="m-xs">{{ tipo.nombre }}</h1> -->
					<!-- 				</div> -->
					<!-- 			</div> -->
					<div class="widget navy-bg">
						<div class="row vertical-align">
							<div class="col-xs-3">
								<i class="fa fa-tags"></i>
							</div>
							<div class="col-xs-9 text-right">
								<strong>{{ tipo.nombre }}</strong>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div v-show="!mostrarTiposProducto">
			<h3>Selecciona Producto</h3>

			<div v-show="!isPantallaGrande">
				<div class="col-lg-2 col-md-2 col-sm-12 col-xm-12">
					<div class="btn btn-warning"
						@click.prevent="showSectionTiposProductos">
						<i class="fa fa-angle-double-left"></i> Regresar
					</div>
				</div>
				<div class="col-lg-8 col-md-8 col-sm-12 col-xm-12">
					<input type="text"
								v-model="filtroDescripcion" placeholder="Filtrar Descripci&oacute;n"
								class="form-control ">
				</div>
				<br>

				<!-- 				<button class="btn btn-primary" @click.prevent="addElement">add</button> -->

				<table id="tblProductosFiltrados"
					class="table table-stripped table-bordered toggle-arrow-tiny" data-page-size="10">
					<thead>
						<tr>
							<th data-sort-ignore="true">C&oacute;digo</th>
							<th data-sort-ignore="true" data-hide="phone">Descripi&oacute;n</th>
							<th data-sort-ignore="true" data-hide="phone">Unidad</th>
							<th data-sort-ignore="true" data-hide="phone">Tpo. Precio</th>

							<th data-sort-ignore="true" class="text-right">Action</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="(prod, index) in productosFiltradosPorTipo">
							<td>{{ prod.codigo }}</td>
							<td>{{ prod.fullDescripcion }} <span v-if="prod.shortUnidad == 'PZA'" class="badge badge-info "> {{ prod.existenciaEstimada }} </span></td>
							<td>{{ prod.shortUnidad }}</td>
							<td>
								<span v-show="prod.tipoPrecio == 'G'">GALVAMEX</span>
								<span v-show="prod.tipoPrecio == 'I'">IMPORTADOS</span>
								<span v-show="prod.tipoPrecio == 'T'">TERNIUM</span></td>
							<td class="text-right">
								<!-- 																<button @click.prevent="prepararProductoDesdeGrid(prod.codigo);" class="btn btn-outline btn-primary dim btn-xs" type="button"><i class="fa fa-pencil"></i></button> -->
								<button @click.prevent="prepararProductoDesdeGrid(prod.codigo);"
									class="btn btn-outline btn-primary " type="button">
									<i class="fa fa-plus"></i>
								</button>
							</td>
						</tr>
					</tbody>
					<tfoot>
						<tr>
							<td colspan="7">
								<ul class="pagination pull-right"></ul>
							</td>
						</tr>
					</tfoot>
				</table>
			</div>

		</div>



		<div class="clearfix"></div>
	</div>
<!-- <pre>{{ $data.productoAEnlistar }}</pre> -->

	<div class="row">
		<div class="col-md-12">
			<div class="ibox">
				<div class="ibox-title">
					<!-- 				<span class="pull-right">(<strong>5</strong>) items -->
					<!-- 				</span> -->
					<h5>Seleccionar Productos</h5>
				</div>
				<div class="ibox-content">
					<div class="row">
						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 form-group">
							<!-- 				<label for="default">Pick a programming language</label> -->
							<input type="text" id="default" list="lstProductos"
								v-model="productoAEnlistar" placeholder="Producto"
								class="form-control input-lg"
								v-on:keypress.enter="setTimeout(function(){app.prepararProducto();}, 200);">

							<datalist id="lstProductos">
								<option v-for="item in productos"
									:value="item.fullDescripcionCode"
									:label="item.fullDescripcionCode">{{item.idProducto}}
									{{item.fullDescripcion}}</option>
							</datalist>
						</div>
						<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
							<button @click.prevent="prepararProducto"
								class="btn btn-primary btn-lg " type="button">
								<i class="fa fa-check"></i><span class="bold"></span>
							</button>
						</div>
						<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
							<button @click.prevent="showHideGrid"
								class="btn btn-primary btn-lg " type="button">
								<i class="fa fa-th-large"></i>&nbsp;&nbsp;<span class="bold">{{
									textShowGrid }}</span>
							</button>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 form-group">
							<button class="btn btn-primary" @click.prevent="agregarMolduraV2">Agregar Moldura</button>
							<button class="btn btn-primary" @click.prevent="agregarMaquilaV2">Agregar Maquila de Moldura</button>
						</div>
						
					</div>



				</div>
			</div>
		</div>
	</div>


	<!-- <div class="row"> -->
	<!-- 	<div class="col-md-9"> -->
	<!-- 		<div class="ibox"> -->
	<!-- 			<div class="ibox-title"> -->
	<!-- <!-- 				<span class="pull-right">(<strong>5</strong>) items -->
	<!-- <!-- 				</span> -->
	<!-- 				<h5>Items in your cart</h5> -->
	<!-- 			</div> -->
	<!-- 			<div class="ibox-content"> -->
	<!-- 			</div> -->
	<!-- 		</div> -->
	<!-- 	</div> -->
	<!-- </div> -->




	<div class="row">
		<div :class="clasePedidoSegunPantalla">

			<div class="ibox">
				<div class="ibox-title">
					<span class="pull-right">(<strong>{{ noElementosEnPedido }}</strong>)
						Elementos
					</span>
					<h5 style="margin-top: 7px">Productos Pedido</h5>
					<div v-show="false">

						<div class="col-lg-3 col-md-3 col-sm-8 col-xs-8" >
							<select v-model="selTipoPedido" class="form-control">
								<option value="0">-- Seleccione Tipo --</option>
								<option value="AT">AT</option>
								<option value="D">D</option>
							</select>
						</div>
					</div>

					<div class="clearfix"></div>

				</div>
				<div class="ibox-content">


					<div v-show="!isPantallaGrande">
						<div class="table-responsive">
							<table id="tblPedidoShort"
								class="table table-stripped table-bordered toggle-arrow-tiny"
								data-page-size="100">
								<thead>
									<tr>
										<th data-sort-ignore="true">C&oacute;digo</th>
										<th data-sort-ignore="true" data-hide="phone">Descripci&oacute;n</th>
										<th data-sort-ignore="true" data-hide="phone">Cnt.</th>
										<th data-sort-ignore="true" data-hide="phone">M/KG</th>
										<th data-sort-ignore="true" data-hide="phone">Des</th>
										<th data-sort-ignore="true" data-hide="phone">Dobles</th>
										<th data-sort-ignore="true" data-hide="phone,tablet">Unidad</th>
										<th data-sort-ignore="true" data-hide="phone,tablet">Tpo Precio</th>
										<th data-sort-ignore="true" data-hide="phone,tablet">$/ML</th>
										<th data-sort-ignore="true">Subtotal</th>

										<th data-sort-ignore="true" class="text-right">Action</th>
									</tr>
								</thead>
								<tbody>
									<tr v-for="(item, index) in listadoPedido">
										<td>
											<h3 class="text-navy">{{ item.idProducto }} - {{ item.codigo }}</h3>
										</td>

										<td>
											{{ item.fullDescripcion }}
											
											&nbsp;&nbsp;&nbsp;
											<span v-show="item.curva != ''"> Curva: {{ item.curva }}</span>
											
											&nbsp;&nbsp;&nbsp;
											
											<div v-show="item.idTipoProducto == 1 && item.idAplicacion == 3 && item.idRollo > 1">
												<button  @click.prevent="curvarProducto(index)" class="btn btn-primary btn-xs"><i class="fa fa-moon-o"></i> Combar</button>
												<button  v-show="item.curva != ''" @click.prevent="quitarCurvaAProducto(index)" class="btn btn-danger btn-xs"><i class="fa fa-moon-o"></i> Quitar Curva</button>
											</div>
											
											<div v-show="item.idProducto == molIdProducto && !item.molIsScrap">
												
												<small>
													<span v-show="item.idRollo != 2 && item.idRollo != 9 && item.idRollo != 13 && item.idRollo != 15 &&	item.idRollo != 25 && item.idRollo != 26 && item.idRollo != 33 && item.idRollo != 35">
													<br>
														L&aacute;minas A Utilizar: {{ item.molLaminasATomar }} 
														<br>
														<span v-show="!item.molIsScrap">
															Precio L&aacute;minas: ${{ formatNumber(item.molPrecioLamina * item.cantUnidadReal) }}
														</span>
														
														<span v-show="item.molIsScrap">
															Precio ({{ molTotalCMScrap }} cm) Scrap: ${{ formatNumber(item.molPrecioLamina * item.cantUnidadReal) }}
														</span>
													</span>
													
													<span v-show="item.idRollo == 2 || item.idRollo == 9 || item.idRollo == 13 || item.idRollo == 15 ||	item.idRollo == 25 || item.idRollo == 26 || item.idRollo == 33 || item.idRollo == 35">
													<br>
														L&aacute;minas A Utilizar: {{ item.molLaminasATomar }}
														<br>
<!-- 														Precio Secci&oacute;n &oacute; L&aacute;mina: ${{ formatNumber(item.molPrecioLamina * item.cantidad)}} -->
														<span v-show="!item.molIsScrap">
															Precio Secci&oacute;n &oacute; L&aacute;mina: ${{ formatNumber(item.precio1 * item.cantidad * item.cantUnidadReal)}}
														</span>
														<span v-show="item.molIsScrap">
															Precio ({{ molTotalCMScrap }} cm) Scrap: ${{ formatNumber(item.precio1 * item.cantidad * item.cantUnidadReal)}}
														</span>
														
													</span>
													<br>
<!-- 													Dobleces ML/PZAS: ${{ formatNumber(item.cantidad * molCostoDobles * item.dobleces) }} -->
<!-- 														Dobleces: ${{ formatNumber(molCostoDobles * item.dobleces) }} -->
														Dobleces ML: ${{ formatNumber(item.molDobles * item.dobleces) }} (* PZAS: ${{ formatNumber(item.cantidad * item.molDobles * item.dobleces) }})
													<br>
<!-- 														Corte ML/PZAS: ${{ formatNumber(item.cantidad * molCostoCorte) }} -->
<!-- 														Corte: ${{ formatNumber(molCostoCorte) }} -->
														Corte ML: ${{ formatNumber(item.molCorte) }} (* PZAS: ${{ formatNumber(item.cantidad * item.molCorte) }})
												</small>
											</div>
											
											<div v-show="item.idProducto == molIdMaquila && !molIsScrap">
												
												<small>
<!-- 													<span v-show="item.idRollo != 2 && item.idRollo != 9 && item.idRollo != 13 && item.idRollo != 15 &&	item.idRollo != 25 && item.idRollo != 26 && item.idRollo != 33 && item.idRollo != 35"> -->
<!-- 													<br> -->
<!-- 														L&aacute;minas A Utilizar: {{ item.molLaminasATomar }}  -->
<!-- 														<br> -->
<!-- 														Precio L&aacute;mina: ${{ item.molPrecioLamina }} -->
<!-- 													</span> -->
													
<!-- 													<span v-show="item.idRollo == 2 || item.idRollo == 9 || item.idRollo == 13 || item.idRollo == 15 ||	item.idRollo == 25 || item.idRollo == 26 || item.idRollo == 33 || item.idRollo == 35"> -->
<!-- 													<br> -->
<!-- 														L&aacute;minas A Utilizar: {{ item.molLaminasATomar }} -->
<!-- 														<br> -->
<!-- 														Precio Secci&oacute;n L&aacute;mina: ${{ item.molPrecioLamina }} -->
<!-- 													</span> -->
<!-- 													<br> -->
<!-- 													Dobleces: ${{ formatNumber(item.cantidad * molCostoDobles * item.dobleces) }} -->
														Dobleces: ${{ formatNumber(item.molDobles * item.dobleces) }}
<!-- 														Dobleces ML: ${{ formatNumber(molCostoDobles * item.dobleces) }} (* PZAS: ${{ formatNumber(item.cantidad * molCostoDobles * item.dobleces) }}) -->
													<br>
<!-- 														Corte: ${{ formatNumber(item.cantidad * molCostoCorte) }} -->
														Corte: ${{ formatNumber(item.molCorte) }}
<!-- 														Corte ML: ${{ formatNumber(molCostoCorte) }} (* PZAS: ${{ formatNumber(item.cantidad * molCostoCorte) }}) -->
												</small>
											</div>
											
											<div v-show="item.molIsScrap">
												
												<small> 						
																					
														Scrap {{ formatNumber(item.molTotalCMScrap) }} cm

													<br>

														 ${{ formatNumber(item.precio1 * item.cantUnidadReal	) }}
														 
														 <br>
<!-- 													Dobleces ML/PZAS: ${{ formatNumber(item.cantidad * molCostoDobles * item.dobleces) }} -->
<!-- 														Dobleces: ${{ formatNumber(molCostoDobles * item.dobleces) }} -->
														Dobleces ML: ${{ formatNumber(item.molDobles * item.dobleces) }} (* PZAS: ${{ formatNumber(item.cantidad * item.molDobles * item.dobleces) }})
													<br>
<!-- 														Corte ML/PZAS: ${{ formatNumber(item.cantidad * molCostoCorte) }} -->
<!-- 														Corte: ${{ formatNumber(molCostoCorte) }} -->
														Corte ML: ${{ formatNumber(item.molCorte) }} (* PZAS: ${{ formatNumber(item.cantidad * item.molCorte) }})

												</small>
											</div>
											
											
											<!-- <span class="badge badge-danger"> <span class="badge badge-info">{{ item.idRollo }}</span> La Existencia de este rollo no cubre la cantidad deseada en este pedido</span> -->


											<div v-if="!item.productoCantidadDisponible && item.shortUnidad != 'PZA' "  class="alert alert-danger" style="margin-top: 2px; margin-bottom: 2px">
												<span class="badge badge-info">{{ item.idRollo }}</span> Disponible de Rollo no cubre su solicitud.
											</div>

											<div v-if="!item.productoCantidadDisponible && item.shortUnidad == 'PZA' "  class="alert alert-danger" style="margin-top: 2px; margin-bottom: 2px">
												<span class="badge badge-warning">{{ item.idProducto }}</span> Disponible de Piezas no cubre su solicitud.
											</div>


										</td>

										<td>{{ item.cantidad }}</td>

										<td>
											<span v-if="item.shortUnidad != 'PZA'"> {{ item.cantUnidad }} <span v-if="item.shortUnidad == 'M2'">ML ({{ formatNumber(item.cantUnidadReal) }} M2)</span> </span>
<!-- 											<span v-else>-</span></td> -->
											<span v-else-if="item.longitud">{{ item.longitud }}</span>
											<span v-else>-</span>

										<td>
    										<span v-if="item.desarrolloT != '' ">
    												<div v-if="item.desarrolloT != '0'">{{ item.desarrolloT }}</div>
    												<div v-else>-</div>
    										</span> 
    										
<!--     										<span v-if="item.tipoPrecio != 'G'"> -->
<!--     												<div v-if="item.tipoPrecio == 'T'">{{ item.desarrolloT }}</div> -->
<!--     												<div v-else>{{ item.desarrolloI }}</div> -->
<!--     										</span> <span v-else>-</span> -->
										</td>

										<td>
										
											<span v-if="item.dobleces != '0'"> {{ item.dobleces }} </span>
											<span v-else>-</span>
											
										</td>

										<td>{{ item.unidad }}</td>

										<td><span v-if="item.tipoPrecio == 'G'">GALVAMEX</span> <span
											v-else-if="item.tipoPrecio == 'I'">IMPORTADOS</span> <span
											v-else>TERNIUM</span></td>

										<td>
											$ {{ formatNumber(item.precioRenglon) }}
											<span v-show="item.idProducto == molIdProducto">
												(Moldura)
											</span>
											<span v-show="item.idProducto == molIdMaquila">
												(Maquila)
											</span> 
										
										</td>

										<td><strong>$ {{ formatNumber(item.totalRenglon) }}</strong></td>

										<td>
											<button v-show="!item.isMoldura" @click.prevent="updateProductoLista(index)"
												class="btn btn-primary btn-xs" type="button">
												<i class="fa fa-pencil"></i>
											</button>
											<button v-show="item.isMoldura && item.idProducto == molIdProducto" @click.prevent="updateMolduraV2(index)"
												class="btn btn-primary btn-xs" type="button">
												<i class="fa fa-pencil"></i>
											</button>
											<button v-show="item.isMoldura && item.idProducto == molIdMaquila" @click.prevent="updateMaquilaV2(index)"
												class="btn btn-primary btn-xs" type="button">
												<i class="fa fa-pencil"></i>
											</button>
											<button @click.prevent="quitarElementoDePedido(index);"
												class="btn btn-danger btn-xs" type="button">
												<i class="fa fa-trash-o"></i>
											</button> <!-- 									<div class="btn btn-warning" @click.prevent="showSectionTiposProductos"><i class="fa fa-angle-double-left"></i> Regresar</div> -->
										</td>

									</tr>
								</tbody>
	<!-- 							<tfoot> -->
	<!-- 								<tr> -->
	<!-- 									<td colspan="11"> -->
	<!-- 										<ul class="pagination pull-right"></ul> -->
	<!-- 									</td> -->
	<!-- 								</tr> -->
	<!-- 							</tfoot> -->
							</table>
						</div>

						<div class="row">
							<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
								<div class="row">
									<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
										<h3>Descuento Individual</h3>
									</div>
									<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
										<select v-html="getOptionsDescuentoIndividual()" v-model="selDescuentoIndividual" class="form-control">
										</select>
									</div>
								</div>
							</div>
                        </div>
                        <br>
                        <!-- Select para Rango de precios normal -->
                        <div class="row">
							<div  v-show="maxTipoPrecioGalvamex > 1" class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
								<div class="row">
									<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
										<h3>Rango Precios</h3>
									</div>
									<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
										<select v-model="tipoPrecioGalvamex" class="form-control">
											<option value="1">Rango 1</option>
											<option v-show="maxTipoPrecioGalvamex > 1  " value="2">Rango 2</option>
											<option v-show="maxTipoPrecioGalvamex > 2 " value="3">Rango 3</option>
										</select>
									</div>
								</div>
							</div>
						</div>
                        <!-- Fin Select para Rango de precios normal -->
                        <br>
                        <!-- Select para Rango de precios AcryOpa -->
                        <div class="row">
							<div  v-show="maxTipoPrecioGalvamexAcryOpa > 1" class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
								<div class="row">
									<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
										<h3>Rango Precios Acrylit Opalit</h3>
									</div>
									<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
										<select v-model="tipoPrecioGalvamexAcryOpa" class="form-control">
											<option value="1">Rango 1</option>
											<option v-show="maxTipoPrecioGalvamexAcryOpa > 1  " value="2">Rango 2</option>
											<option v-show="maxTipoPrecioGalvamexAcryOpa > 2 " value="3">Rango 3</option>
										</select>
									</div>
								</div>
							</div>
						</div>
                        <!-- Fin Select para Rango de precios AcryOpa -->
                        
                        <!-- Select para Rango de precios MULTIPANEL C -->
                        <div class="row">
							<div  v-show="maxTipoPrecioGalvamexMultipanel > 1" class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
								<div class="row">
									<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
										<h3>Rango Precios Multipanel</h3>
									</div>
									<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
										<select v-model="tipoPrecioGalvamexMultipanel" class="form-control">
											<option value="1">Rango 1</option>
											<option v-show="maxTipoPrecioGalvamexMultipanel > 1  " value="2">Rango 2</option>
											<option v-show="maxTipoPrecioGalvamexMultipanel > 2 " value="3">Rango 3</option>
										</select>
									</div>
								</div>
							</div>
						</div>
                        <!-- Fin Select para Rango de precios MULTIPANEL C -->
                        
                        <!-- Select para Rango de precios Galvateja D -->
                        <div class="row">
							<div  v-show="maxTipoPrecioGalvamexGalvateja > 1" class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
								<div class="row">
									<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
										<h3>Rango Precios Galvateja</h3>
									</div>
									<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
										<select v-model="tipoPrecioGalvamexGalvateja" class="form-control">
											<option value="1">Rango 1</option>
											<option v-show="maxTipoPrecioGalvamexGalvateja > 1  " value="2">Rango 2</option>
											<option v-show="maxTipoPrecioGalvamexGalvateja > 2 " value="3">Rango 3</option>
										</select>
									</div>
								</div>
							</div>
						</div>
                        <!-- Fin Select para Rango de precios Galvateja D -->

						<br>
						<div class="row">
						    <div v-for="rollo in rollosExistencias" class="col-lg-12">
								
								<div  v-if="rollo.nosepuede && rollo.rolloenpedido" class="alert alert-danger" style="margin-top: 2px; margin-bottom: 2px">
								<!-- <div   class="alert alert-danger" style="margin-top: 2px; margin-bottom: 2px"> -->
									<span class="badge badge-info">{{ rollo.idrollo }}</span> El Rollo <strong>{{ rollo.codigo }} - {{ rollo.descauto }} </strong> no cubrir&aacute; su solicitud. 
									Existencia disponible: <strong>{{ rollo.disponible }}</strong> KG. En este Pedido: <strong>{{ rollo.enpedido }}</strong> KG.
								</div>								
							</div>

							<div v-for="pza in piezasExistencias" class="col-lg-12">
								
								<div  v-if="pza.nosepuede && pza.productoenpedido" class="alert alert-danger" style="margin-top: 2px; margin-bottom: 2px">
								<!-- <div   class="alert alert-danger" style="margin-top: 2px; margin-bottom: 2px"> -->
									<span class="badge badge-warning">{{ pza.idProducto }}</span> El Producto <strong>{{ pza.codigo }} - {{ pza.fullDescripcion }} </strong> no cubrir&aacute; su solicitud. 
									Existencia disponible: <strong>{{ pza.existencia }}</strong> PZAS. En este Pedido: <strong>{{ pza.enpedido }}</strong> PZAS.
								</div>								
							</div>
						</div>

                        <br>
						<div class="table-responsive">
									<table class="table invoice-total">
										<tbody>
<!-- 											<tr v-show="porDescuento > 0"> -->
											<tr>
												<td><strong>SUBTOTAL :</strong></td>
												<td><h3>${{ formatNumber(subtotalPedido) }}</h3></td>
											</tr>
											
											<tr v-show="listadoPedido.length > 0 || totalOtrosCargos > 0">
												<td>
    												<button class="btn btn-primary btn-xs" @click.prevent="agregarOtrosGastos"><i class="fa fa-plus"></i></button>
    												&nbsp;<strong>OTROS SERVICIOS:</strong>
												</td>
												<td><h3>${{ formatNumber(totalOtrosCargos) }}</h3></td>
											</tr>
											
											<tr v-show="porDescuento > 0">
												<td><strong>DESCUENTO {{ porDescuento }} %:</strong></td>
												<td><h3>${{ formatNumber(descuentoPedido) }}</h3></td>
											</tr>
											<tr>
												<td><strong>TOTAL :</strong></td>
												<td><h1 class="font-bold">${{ formatNumber(totalPedido) }}</h1></td>
											</tr>
										</tbody>
									</table>
								</div>

						<div class="row">
							<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"></div>
							<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
								<div class="form-group has-success">
									<label class="control-label" for="observacionPedido"> Observaci&oacute;n </label>
									<input type="text" v-model="observacionPedido" class="form-control"
											maxlength="200" /> <span class='help-block'> Si lo desea, capture alguna Observaci&oacute;n del Pedido
										</span>


								</div>
							</div>
						</div>

						<button v-show="mostrarBotonGuardar" @click.prevent="levantarPedido"
											class="btn btn-primary btn-lg pull-right">
											<i class="fa fa-shopping-cart"></i> Levantar Pedido
										</button>
						<div class="clearfix"></div>
					</div>
				</div>

				<!-- 			<div class="ibox-content"> -->

				<!-- 				<button class="btn btn-primary pull-right"> -->
				<!-- 					<i class="fa fa fa-shopping-cart"></i> Checkout -->
				<!-- 				</button> -->
				<!-- 				<button class="btn btn-white"> -->
				<!-- 					<i class="fa fa-arrow-left"></i> Continue shopping -->
				<!-- 				</button> -->

				<!-- 			</div> -->
			</div>

		</div>
		<div :class="claseTotalAndClienteSegunPantalla">

			<div id="secIzquierda"></div>
			<div id="secDerecha"></div>

			<div class="row">
<!-- 				<div id="secTotalPedido"> -->
<!-- 					<div :class="claseTotalClienteSegunPantalla"> -->
<!-- 						<div class="ibox"> -->
<!-- 							<div class="ibox-title"> -->
<!-- 								<h5>Total Pedido</h5> -->
<!-- 							</div> -->
<!-- 							<div class="ibox-content"> -->
								<!-- 						<span> Total </span> -->
<!-- 								<h1 class="font-bold">$ {{ totalPedido }}</h1> -->


<!-- 								<hr /> -->
								<!-- 						<span class="text-muted small"> *For United States, France and -->
								<!-- 							Germany applicable sales tax will be applied </span> -->
<!-- 								<div class="m-t-sm"> -->
<!-- 									<div class="btn-group"> -->
<!-- 										<button @click.prevent="levantarPedido" -->
<!-- 											class="btn btn-primary btn-lg"> -->
<!-- 											<i class="fa fa-shopping-cart"></i> Levantar Pedido -->
<!-- 										</button> -->
										<!-- 									<a href="#" -->
										<!-- 									class="btn btn-white btn-sm"> Cancel</a> -->
<!-- 									</div> -->
<!-- 								</div> -->
<!-- 							</div> -->
<!-- 						</div> -->
<!-- 					</div> -->
<!-- 				</div> -->

			</div>

			<div class="row">
				<div id="zsecCliente">
<!-- 					<div :class="claseTotalClienteSegunPantalla"> -->
<!-- 						<div class="ibox float-e-margins"> -->
<!-- 							<div class="ibox-title"> -->
<!-- 								<h5>Cliente</h5> -->
<!-- 							</div> -->
<!-- 							<div class="ibox-content ibox-heading"> -->
<!-- 								<h3> -->
<!-- 									<i class="fa fa-user"></i> {{ clienteSeleccionado }} -->
<!-- 								</h3> -->
<!-- 								<small><i class="fa fa-tim"></i> {{ promotorClienteSeleccionado -->
<!-- 									}}</small> -->
<!-- 							</div> -->
<!-- 							<div class="ibox-content"> -->

<!-- 								<div> -->
<!-- 									<button v-if="!seleccionandoCliente" -->
<!-- 										@click.prevent="seleccionarCliente" -->
<!-- 										class="btn btn-primary pull-right">Seleccionar Cliente</button> -->
<!-- 									<button v-else @click.prevent="cancelarSeleccionarCliente" -->
<!-- 										class="btn btn-danger pull-right ">Cancelar</button> -->
<!-- 								</div> -->

<!-- 								<div v-if="seleccionandoCliente"> -->
<!-- 									<div> -->
<!-- 										<input type="text" id="default" v-model="filtroNombreCliente" -->
<!-- 											placeholder="Cliente" class="form-control input-lg"> -->
<!-- 									</div> -->

<!-- 									<div class="hr-line-dashed"></div> -->

<!-- 									<div class="feed-activity-list"> -->
<!-- 										<div v-for="cte in clientesFiltradosPorNombre" -->
<!-- 											class="feed-element"> -->
<!-- 											<div> -->
												<!-- 									<small class="pull-right text-navy">1m ago</small>-->
<!-- 												<strong>{{ cte.nombre }}</strong> -->
<!-- 												<div>{{ cte.promotor }}</div> -->
<!-- 												<small class="text-muted pull-right"><button -->
<!-- 														@click.prevent="setClienteSelected(cte.id);" -->
<!-- 														class="btn btn-primary btn-xs">Seleccionar</button></small> -->
<!-- 											</div> -->
<!-- 										</div> -->
<!-- 									</div> -->
<!-- 								</div> -->

<!-- 								<div class="clearfix"></div> -->

<!-- 							</div> -->
<!-- 						</div> -->
<!-- 					</div> -->
					<div :class="claseRecepcionSegunPantalla">
						<div class="ibox float-e-margins">
							<div class="ibox-title">
								<h5>Recepci&oacute;n</h5>
							</div>
							<div class="ibox-content">
								<div class="row">
									<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
										El Pedido
									</div>
									<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
										<select v-model="selRecogeRecibe" class="form-control">
											<option value="NOSEL">-- Seleccione --</option>
											<option value="RECOGE">RECOGE EL CLIENTE</option>
											<option value="ENTREGA">SE ENVIA AL CLIENTE</option>
										</select>
									</div>
									<div v-show="selRecogeRecibe == 'ENTREGA'" class="col-lg-4 col-md-4 col-sm-12 col-xs-12" >
										    <div class="checkbox" >
	                                            <input id="checkbox1" type="checkbox" v-model="chkUsarInformacionCliente">
	                                            <label for="checkbox1">
	                                                Utilizar la registrada en Cliente.
	                                            </label>
	                                        </div>
										</div>
								</div>
								<div v-show="selRecogeRecibe == 'ENTREGA'">
									<hr>
									<div class="row">
										<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
											<div class="form-group" v-bind:class="{'has-error': errCteDireccion}">
												<label class="control-label" for="price">
													Persona
												</label>
												<div v-show="chkUsarInformacionCliente">
													{{ clienteSeleccionado }}
												</div>
												<div v-show="!chkUsarInformacionCliente">
													<input type="text" v-model="ctePersona"
													       class="form-control" maxlength="200"/>
													<span class='help-block'>
														<strong>{{ errCtePersona }}</strong>
													</span>
												</div>


											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
											<div class="form-group" v-bind:class="{'has-error': errCteDireccion}">
												<label class="control-label" for="price">
													Direci&oacute;n
												</label>
												<div v-show="chkUsarInformacionCliente">
													{{ cteSelDomicilio1 }} {{ cteSelDomicilio2 }}
												</div>
												<div v-show="!chkUsarInformacionCliente">
													<input type="text" v-model="cteDireccion"
													       class="form-control" maxlength="60"/>
													<span class='help-block'>
														<strong>{{ errCteDireccion }}</strong>
													</span>
												</div>


											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
											<div class="form-group" v-bind:class="{'has-error': errCteNumero}">
												<label class="control-label" for="price">
													N&uacute;mero
												</label>
												<div v-show="chkUsarInformacionCliente">
													{{ cteSelNumero }}
												</div>
												<div v-show="!chkUsarInformacionCliente">
													<input type="text" v-model="cteNumero"
													       class="form-control" maxlength="60"/>
													<span class='help-block'>
														<strong>{{ errCteNumero }}</strong>
													</span>
												</div>

											</div>
										</div>
										<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
											<div class="form-group" v-bind:class="{'has-error': errCteColonia}">
												<label class="control-label" for="price">
													Colonia
												</label>
												<div v-show="chkUsarInformacionCliente">
													{{ cteSelColonia }}
												</div>
												<div v-show="!chkUsarInformacionCliente">
													<input type="text" v-model="cteColonia"
													       class="form-control" maxlength="60"/>
													<span class='help-block'>
														<strong>{{ errCteColonia }}</strong>
													</span>
												</div>

											</div>
										</div>
										<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
											<div class="form-group" v-bind:class="{'has-error': errCteCiudad}">
												<label class="control-label" for="price">
													Ciudad
												</label>
												<div v-show="chkUsarInformacionCliente">
													{{ cteSelCiudad }}
												</div>
												<div v-show="!chkUsarInformacionCliente">
													<input type="text" v-model="cteCiudad"
													       class="form-control" maxlength="60"/>
													<span class='help-block'>
														<strong>{{ errCteCiudad	 }}</strong>
													</span>
												</div>

											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
											<label class="control-label">Hora Entrega</label>
												<input type="text" v-model="horaEntrega"  id="txtHoraEntrega"
													       class="form-control" maxlength="45"/>
<!-- 											<div class="input-group clockpicker" data-autoclose="true">												 -->
<!-- 				                                <input id="txtHoraEntrega" type="text" class="form-control" v-model='horaEntrega' > -->
<!-- 				                                <span class="input-group-addon"> -->
<!-- 				                                    <span class="fa fa-clock-o"></span> -->
<!-- 				                                </span> -->
<!-- 				                            </div> -->
										</div>
										<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
											<div class="form-group" v-bind:class="{'has-error': errFechaEntrega}">
				                                <label class="control-label">Fecha Entrega</label>
				                                <div class="input-group date">
				                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
				                                    <input v-modal="fechaEntrega" id="dtFechaEntrega" type="text" class="form-control"  value="<?php echo date("d/m/Y");?>
				                                    ">
				                                </div>
				                                <span v-if='errFechaEntrega' class='help-block'>
														<strong>{{ errFechaEntrega }} </strong>
												</span>
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

<div id="divdebug"></div>

<?php 
// if (Permisos::userIsThisRol(Permisos::$idROOTUSER) && false): 
?>

<!-- <pre> -->
<!-- DescuentoPedido: {{ descuentoPedido }} -->


<!-- TotalML: {{ $data.totalML }} -->
<!-- <br> -->
<!-- TotalMLAcryOpa: {{ $data.totalMLAcryOpa}} -->
<!-- <br> -->
<!-- maxTipoPrecioGalvamex: {{maxTipoPrecioGalvamex}} -->
<!-- <br> -->
<!-- tipoPrecioGalvamex: {{tipoPrecioGalvamex}} -->
<!-- <br><br> -->

<!-- maxTipoPrecioGalvamexAcryOpa: {{maxTipoPrecioGalvamexAcryOpa}} -->
<!-- <br> -->
<!-- tipoPrecioGalvamexAcryOpa: {{tipoPrecioGalvamexAcryOpa}} -->
<!-- <br><br> -->

<!-- ComisionR1: {{ comisionR1 }} -->
<!-- ComisionR2: {{ comisionR2 }} -->
<!-- ComisionR3: {{ comisionR3 }} -->

<!-- MaxTipoPrecioGalvamex {{ $data.maxTipoPrecioGalvamex }} -->
<!-- TipoPrecioGalvamex {{ $data.tipoPrecioGalvamex }} -->
<!--
Rango1Inicio: {{ $data.rango1Inicio }}
<br>
Rango1Fin: {{ $data.rango1Fin }}
<br>
<br>
Rango2Inicio: {{ $data.rango2Inicio }}
<br>
Rango2Fin: {{ $data.rango2Fin }}
<br>
<br>
Rango3Inicio: {{ $data.rango3Inicio }}
<br><br><br>

Rango1InicioAcryOpa: {{ $data.rango1InicioAcryOpa }}
<br>
Rango1FinAcryOpa: {{ $data.rango1FinAcryOpa }}
<br>
<br>
Rango2InicioAcryOpa: {{ $data.rango2InicioAcryOpa }}
<br>
Rango2FinAcryOpa: {{ $data.rango2FinAcryOpa }}
<br>
<br>
Rango3InicioAcryOpa: {{ $data.rango3InicioAcryOpa }}
<br><br><br>

Rango1InicioMultipanel: {{ $data.rango1InicioMultipanel }}
<br>
Rango1FinMultipanel: {{ $data.rango1FinMultipanel }}
<br>
<br>
Rango2InicioMultipanel: {{ $data.rango2InicioMultipanel }}
<br>
Rango2FinMultipanel: {{ $data.rango2FinMultipanel }}
<br>
<br>
Rango3InicioMultipanel: {{ $data.rango3InicioMultipanel }} -->

<!-- MaxDescuentoIndividual: {{ $data.maxDescuentoIndividual }} -->

<!-- DescuentoIndividual: {{ $data.selDescuentoIndividual }} -->

<!-- </pre> -->

<!-- <pre>{{ $data.listadoPedido }}</pre> -->
<!-- <pre>{{ $data }}</pre> -->

<!-- <pre>{{ $data.productos }}</pre> -->

<?php 

// endif; 

?>

<?php

if (Permisos::userIsThisRol(Permisos::$idROOTUSER))
{
// //         echo "<pre>{{ \$data.token }}</pre>";
    
//     echo "<pre>";
    
//     echo "molPrecioCorteBase: {{ \$data.molPrecioCorteBase }} <br><br>";
//     echo "molIndexMoldura: {{ \$data.molIndexMoldura}} <br>";
//     echo "molIdProducto: {{ \$data.molIdProducto}} <br>";
//     echo "molCantidad: {{ \$data.molCantidad}} <br>";
//     echo "molMoldurasXLaminas: {{ \$data.molMoldurasXLaminas}} <br>";
//     echo "molCantUnidad: {{ \$data.molCantUnidad}} <br>";
//     echo "molDesarrollo: {{ \$data.molDesarrollo}} <br>";
//     echo "molIdRollo: {{ \$data.molIdRollo}} <br>";
//     echo "molDescripcion: {{ \$data.molDescripcion}} <br>";
//     echo "molStrTemp: {{ \$data.molStrTemp}} <br>";
//     echo "molDobleces: {{ \$data.molDobleces}} <br>";
//     echo "molPies: {{ \$data.molPies}} <br>";
//     echo "molPiesXDesarrollo: {{ \$data.molPiesXDesarrollo}} <br>";
//     echo "molCalibre: {{ \$data.molCalibre}} <br>";
//     echo "molDividirLamina: {{ \$data.molDividirLamina}} <br>";
//     echo "molPrecioRollo: {{ \$data.molPrecioRollo}} <br>";
//     echo "molPrecioADar: {{ \$data.molPrecioADar}} <br>";
//     echo "molPrecioMetroMoldura: {{ \$data.molPrecioMetroMoldura}} <br>";
//     echo "molIdMaterial: {{ \$data.molIdMaterial}} <br>";
//     echo "molCostoCorte: {{ \$data.molCostoCorte}} <br>";
//     echo "molCostoDobles: {{ \$data.molCostoDobles}} <br>";
//     echo "molCostoCorteMaquila: {{ \$data.molCostoCorteMaquila}} <br>";
//     echo "molCostoDoblesMaquila: {{ \$data.molCostoDoblesMaquila}} <br>";
//     echo "molError: {{ \$data.molError}} <br>";
//     echo "molMsgAgregarMasMolduras: {{ \$data.molMsgAgregarMasMolduras}} <br>";
//     echo "molTextoBotonAddMoldura: {{ \$data.molTextoBotonAddMoldura}} <br>";
//     echo "molTextoBotonCancelAddMoldura: {{ \$data.molTextoBotonCancelAddMoldura}} <br>";
    
// //     echo "</pre>";
// //     echo "<pre>{{ \$data }}</pre>";
    
// //     echo "<pre>{{ \$data.otrosCargos }}</pre>";
// //  echo "<pre>{{ \$data.productos }}</pre>";
 	echo "<pre>{{ \$data.listadoPedido }}</pre>";
// // 	echo "<pre>{{ \$data.rollosExistencias }}</pre>";
// //     echo "<pre>{{ \$data.clientes }}</pre>";
// // 	echo "<pre>{{ \$data.piezasExistencias }}</pre>";
}


?>
