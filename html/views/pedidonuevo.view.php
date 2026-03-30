<?php
// $_showPageHeading = false;

$titlePage = "Capturar Cotizaci&oacute;n / Pedido";
// $breadCum = "Ventas/Pedido/Nuevo";
$_lugar = LUGAR_VENTAS_NUEVOPEDIDO;

$_addHead="
 		<link href='".URL_BASE."assets/inspinia/css/plugins/toastr/toastr.min.css' rel='stylesheet'>
 		<link href='".URL_BASE."assets/inspinia/css/plugins/footable/footable.core.css' rel='stylesheet'>
 		<link href='".URL_BASE."assets/inspinia/css/plugins/datapicker/datepicker3.css' rel='stylesheet'>
 		<link href='".URL_BASE."assets/inspinia/css/plugins/clockpicker/clockpicker.css' rel='stylesheet'>

        <link href=\"".URL_BASE."assets/inspinia/css/plugins/iCheck/custom.css\" rel=\"stylesheet\">
        <link href=\"".URL_BASE."assets/inspinia/css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css\" rel=\"stylesheet\">
		
		<style>
		.blink_me {
			animation: blinker 1.5s linear infinite;
		  }

		  @keyframes blinker {
			50% {
			  opacity: 0;
			}
		  }
		  
		</style>

 		";

$_addScript="
 		<script src=\"".URL_BASE."assets/inspinia/js/plugins/toastr/toastr.min.js\"></script>
 		<script src=\"".URL_BASE."assets/inspinia/js/plugins/footable/footable.all.min.js\"></script>
 		<script src=\"".URL_BASE."assets/inspinia/js/plugins/datapicker/bootstrap-datepicker.js\"></script>

		<script src=\"".URL_BASE."assets/inspinia/js/plugins/clockpicker/clockpicker.js\"></script>

		<script src=\"".URL_BASE."assets/inspinia/js/plugins/iCheck/icheck.min.js\"></script>
		
		<script src=\"".URL_BASE."assets/inspinia/js/plugins/peity/jquery.peity.min.js\"></script>
		<script src=\"".URL_BASE."assets/inspinia/js/demo/peity-demo.js\"></script>

		<script src=\"".URL_BASE."js/components/cliente-dirfiscales-new-edit.vue.js\"></script>
		<script src=\"".URL_BASE."js/components/cliente-dirfiscales-listado.vue.js\"></script>
		<script src=\"".URL_BASE."js/components/cliente-dirfiscales-selector.vue.js\"></script>

        

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
    
        // echo "<pre>{{ \$data.otrosCargos[6] }}</pre>";
// //     //  echo "<pre>{{ \$data.productos }}</pre>";
// // //     echo "<pre>{{ \$data.listadoPedido }}</pre>";
// }


$_isPedidoPage = true; 

?>
<!-- 
<button @click.prevent="levantarOConvertirAPedido('LEVANTAR_PEDIDO')" class="btn btn-primary">
	getinfocte
</button> -->
<cliente-dirfiscales-selector @on-select="onDirSelected($event)" 
							ref="nuevaDireccionExistente"
							shownombrecliente="true"
							seleccionarsinrfcs="true"
							leyendashow="Seleccione RFC para asignarlo al Pedido">
</cliente-dirfiscales-selector>

<div v-if="idCotizacion > 0 && !imprimirPedido" class="row">
	<div class="col-md-3"></div>
	<div class="col-md-6">
		<div class="alert alert-danger text-center">
			<h4>
				Usted esta editando la Cotizaci&oacute;n con folio: <span class="alert-link blink_me">{{ idCotizacion}}</span>
			</h4>

			<a href="<?php echo URL_BASE?>pedidonuevo"
								class="btn btn-primary btn-lg"><i class="fa fa-shopping-cart"></i>
								Nuevo Pedido/Cotizaci&oacute;n</a>
        </div>
	</div>
	<div class="col-md-3"></div>
</div>

<!-- <button class="btn btn-primary" @click.prevent="LoadCotizacion">LoadPedido</button> -->

<!-- {{ idClienteSeleccionado }}
<br>
{{ clienteSeleccionado }}
<br>
{{ clienteTipoRangoSeleccionado }} -->

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
<!-- 				<i class="fa fa-shopping-cart modal-icon"></i> -->
				<h4 class="modal-title"><span v-show="!molIsMaquila">Molduras</span><span v-show="molIsMaquila">Maquila</span></h4>
				<div v-show="!molIsMaquila">
					<!-- 				Pies: {{ molPiesXDesarrollo }} -- Div: {{ molDividirLamina }} --  Material {{ molIdMaterial }} -- IdRollo: {{ molIdRollo  }} -- Precio: {{ molPrecioRollo }} -- Precio a Dar: {{ molPrecioADar }} -->
<!--     				Precio L&aacute;mina completa: {{ molPrecioRollo }} -->
<!--     				<br> -->
<!--     				Precio ML (Sin Corte ni Dobleces): {{ molPrecioMetroMoldura }} -->
    <!-- 				<br> -->
<!--      				{{ molCostoCorte }} - {{ molCostoDobles }}  -->
    <!-- 				<br> -->
    <!-- 				{{ molStrTemp }} -->
				</div>


				<div v-show="molIsMaquila">
				</div>
				
				
				<!-- 						<br> -->
				<!-- 						tp {{ tipoPrecioModal }} su {{ shortUnidadModal }} Cant {{ cantidadModal }} dT {{ desarrolloTModal }} dI {{ desarrolloIModal }} do {{ doblecesModal }} -->
			</div>
			<div class="modal-body">
				
				
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b">
						<div class="well">
							<div class="row  text-center">
								<h3>MEDIDAS DE LA L&Aacute;MINA </h3>
							</div>
							<div class="row ">
								<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 m-b">
									<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            							<div class="form-group">
                							<label class="control-label">Ancho (1 - 122 cm)</label> 
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
								<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 m-b">
									<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            							<div class="form-group">
            								<label class="control-label">Longitud (Metros Lineales)</label> <input
            									type="text" v-model="molCantUnidad" placeholder=""
            									oninput="this.value = this.value.replace(/[^0-9.\t]/g, '').replace(/(\..*)\./g, '$1');"
            									maxlength="9" class="form-control">
            								<div v-show="molCantUnidad > 8.1 || molCantUnidad <= 0" class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
                    							<div class="alert alert-danger">
                    								Este valor debe ser mayor a cero y menor a 8.1 
                    							</div>
                    						</div>
            							</div>
            						</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				
				
				<div class="row m-b-xs">
					<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12 m-b">
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
					<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 m-b">
						<!-- 											metros cuad piezas (int) kg ml -->
<!-- 						METROS LINEALES  -->

						<p>Orientaci&oacute;n del Dobles</p>
                                        <div class="radio radio-info radio-inline">
                                            <input type="radio" id="inlineRadio1" value="L" name="radioInline" v-model="molLongitudinal">
                                            <label for="inlineRadio1"> Longitudinal</label>
                                        </div>
                                        <div class="radio radio-info radio-inline">
                                            <input type="radio" id="inlineRadio2" value="A" v-model="molLongitudinal"  name="radioInline">
                                            <label for="inlineRadio2"> A lo Ancho</label>
                                        </div>

					</div>
					<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12 m-b">
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
									<option value="21">21</option>
    								<option value="22">22</option>
    								<option value="23">23</option>
    								<option value="24">24</option>
    								<option value="25">25</option>
    								<option value="26">26</option>
    								<option value="27">27</option>
    								<option value="28">28</option>
    								<option value="29">29</option>
    								<option value="30">30</option>
    								<option value="31">31</option>
									<option value="32">32</option>
    								<option value="33">33</option>
    								<option value="34">34</option>
    								<option value="35">35</option>
    								<option value="36">36</option>
    								<option value="37">37</option>
    								<option value="38">38</option>
    								<option value="39">39</option>
    								<option value="40">40</option>
    								<option value="41">41</option>
    								<option value="42">42</option>
									<option value="43">43</option>
    								<option value="44">44</option>
    								<option value="45">45</option>
    								<option value="46">46</option>
    								<option value="47">47</option>
    								<option value="48">48</option>
    								<option value="49">49</option>
    								<option value="50">50</option>
    							</select>
    						</div>
						</div>
					</div>
					<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12 m-b">
						Incluir Corte
						<div class="switch">
                            		<div class="onoffswitch">
                            			<input type="checkbox" class="onoffswitch-checkbox"
                            				id="molIncluirCorte" v-model="molIncluirCorte"> <label class="onoffswitch-label" for="molIncluirCorte"> <span
                            				class="onoffswitch-inner"></span> <span class="onoffswitch-switch"></span>
                            			</label>
                            		</div>
                            	</div>
					</div>
				</div>
				<div class="row m-b-xs">
					
					<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
<!-- 						DESARROLLO -->
						
					</div>
					
					<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
<!-- 						dobleces -->
						
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
        				<i>ROLLO 4'</i>: Molduras x rollo = <strong>{{ molXLaminas4Pies }}</strong>; laminas a utilizar = <strong>{{ molXLaminas4PiesAUsarCompletas}}</strong>; sobrante total cobrado = <strong>{{ formatNumber( molSobrante4PiesPSPP ) }} cm</strong><br><br>
        				
        				<strong>MINICOILS</strong><br>
<!--         				molXLaminas3Pies: {{ molXLaminas3Pies }} <br> -->
<!--         				moldurasSueltas3Pies: {{ moldurasSueltas3Pies }} <br> -->
<!--         				molXLaminas3PiesAUsarCompletas: {{ molXLaminas3PiesAUsarCompletas }} <br> -->
<!--         				molXLaminas3PiesAUsar: {{ molXLaminas3PiesAUsar }} <br> -->
<!--         				molSobrante3Pies: {{ molSobrante3Pies }} <br> -->
        				
        				<i>ROLLO 3.76'</i>: Molduras x rollo = <strong>{{ molXLaminas376Pies }}</strong>; laminas a utilizar = <strong>{{ molXLaminas376PiesAUsarCompletas}}</strong>; sobrante total cobrado = <strong>{{ formatNumber( molSobrante376Pies ) }} cm</strong><br>
        				
<!--         				molXLaminas4Pies: {{ molXLaminas4Pies }} <br> -->
<!--         				moldurasSueltas4Pies: {{ moldurasSueltas4Pies }} <br> -->
<!--         				molXLaminas4PiesAUsarCompletas: {{ molXLaminas4PiesAUsarCompletas }} <br> -->
<!--         				molXLaminas4PiesAUsar: {{ molXLaminas4PiesAUsar }} <br> -->
<!--         				molSobrante4Pies: {{ molSobrante4Pies }} <br> -->
        				<i>ROLLO 3.48'</i>: Molduras x rollo = <strong>{{ molXLaminas348Pies }}</strong>; laminas a utilizar = <strong>{{ molXLaminas348PiesAUsarCompletas}}</strong>; sobrante total cobrado = <strong>{{ formatNumber( molSobrante348Pies ) }} cm</strong><br>
        				
        				<br>
        				<i><strong>Nota: </strong> A menor sobrante total cobrado, menor costo de las molduras.</i>
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

						<div class="row">
							<div v-show="!molIsMaquila"  class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
    							<div class="form-group">
        							<label class="control-label">Calibre</label> <select
        								v-model="molCalibreFiltroRollo"
        								 class="form-control">
        								<option value="0">--Seleccione Calibre--</option>
        								<option value='28'>28</option>
                                        <option value='26'>26</option>
                                        <option value='24'>24</option>
                                        <option value='22'>22</option>
                                        <option value='20'>20</option>
                                        <option value='18'>18</option>
                                        <option value='16'>16</option>
                                        <option value='14'>14</option>
                                        <option value='12'>12</option>
                                        <option value='10'>10</option>
                                        <option value='1/8"'>1/8"</option>
                                        <option value='3/16"'>3/16"</option>
    
        								
        							</select>
    <!--     							<div v-show="molPiesXDesarrolloSugerido > 0" class="col-lg-12 col-md-12 col-sm-6 col-xs-12"> -->
    <!--         							<div class="alert alert-info"> -->
    <!--         								Se sugiere un Rollo de {{ molPiesXDesarrolloSugerido }} Pies <span v-show="molIsMaquila"> (Este dato es s&oacute;olo informatico)</span> -->
    <!--         							</div> -->
    <!--         						</div> -->
        						</div>
    						</div>
    						
    						<div v-show="!molIsMaquila"  class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
    							<div class="form-group">
        							<label class="control-label">Material</label> <select
        								v-model="molMaterialFiltroRollo"
        								 class="form-control">
        								<option value="0">--Seleccione Material--</option>
        								<option value='5'>GALVANIZADO</option>
                                        <option value='27'>NEGRA</option>
                                        <option value='13'>PINTRO POLIESTER</option>
                                        <option value='2'>PINTRO SULTANA</option>
                                        <option value='4'>ZINTRO ALUM</option>
        								<?php 
//         								    foreach ($lstMateriales as $mat)
//         								    {
//         								        echo "<option value=\"".$mat["value"]."\">".$mat["option"]."</option>";
//         								    }
        								
        								?>
        								
        							</select>
    <!--     							<div v-show="molPiesXDesarrolloSugerido > 0" class="col-lg-12 col-md-12 col-sm-6 col-xs-12"> -->
    <!--         							<div class="alert alert-info"> -->
    <!--         								Se sugiere un Rollo de {{ molPiesXDesarrolloSugerido }} Pies <span v-show="molIsMaquila"> (Este dato es s&oacute;olo informatico)</span> -->
    <!--         							</div> -->
    <!--         						</div> -->
        						</div>
    						</div>
						
						</div>
						
						
						<div v-show="!molIsMaquila" class="col-lg-11 col-md-11 col-sm-11 col-xs-12">
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
						
						<div v-show="molIsMaquila"  class="col-lg-11 col-md-11 col-sm-11 col-xs-12">
							<div class="form-group">
    							<label class="control-label">Calibre</label> <select
    								v-model="molCalibreV2"
    								 class="form-control">
    								<option value="0">--Seleccione Calibre--</option>
    								<option value='28'>28</option>
                                    <option value='26'>26</option>
                                    <option value='24'>24</option>
                                    <option value='22'>22</option>
                                    <option value='20'>20</option>
                                    <option value='18'>18</option>
                                    <option value='16'>16</option>
                                    <option value='14'>14</option>
                                    <option value='12'>12</option>
                                    <option value='10'>10</option>
                                    <option value='1/8"'>1/8"</option>
                                    <option value='3/16"'>3/16"</option>

    								
    							</select>
<!--     							<div v-show="molPiesXDesarrolloSugerido > 0" class="col-lg-12 col-md-12 col-sm-6 col-xs-12"> -->
<!--         							<div class="alert alert-info"> -->
<!--         								Se sugiere un Rollo de {{ molPiesXDesarrolloSugerido }} Pies <span v-show="molIsMaquila"> (Este dato es s&oacute;olo informatico)</span> -->
<!--         							</div> -->
<!--         						</div> -->
    						</div>
						</div>
						
						<div v-show="molIsMaquila"  class="col-lg-11 col-md-11 col-sm-11 col-xs-12">
							<div class="form-group">
    							<label class="control-label">Material</label> <select
    								v-model="molIdMaterialV2"
    								 class="form-control">
    								<option value="0">--Seleccione Material--</option>
    								<option value='5'>GALVANIZADO</option>
                                    <option value='27'>NEGRA</option>
                                    <option value='13'>PINTRO POLIESTER</option>
                                    <option value='2'>PINTRO SULTANA</option>
                                    <option value='4'>ZINTRO ALUM</option>


    								
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
    									
										<!-- <div v-show="!ismolDesarrolloV2Valido" class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
                    							<div class="alert alert-danger">
                    								El Scrap debe ser mayor o igual al Ancho ingresado
                    							</div>
                    					</div> -->
    
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
			<button type="button" @click.prevent="checarSiHayMercanciaIsocindu" class="btn btn-warning" data-dismiss="modal">{{ molTextoBotonCancelAddMoldura  }}</button>		
				<button @click.prevent="agregarMolduraAPedidoV2" type="button"
					class="btn btn-primary">{{ molTextoBotonAddMoldura }}</button>
			</div>
		</div>
	</div>
</div>
<!-- Fin Agregar Producto MOLDURA VERSION 2 -->

<!-- <pre>{{ $data.rollosExistencias.length }}</pre> -->
<!-- <br> -->
<!-- <pre>{{ $data.rollosExistencias }}</pre> -->

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
			<button type="button" @click.prevent="checarSiHayMercanciaIsocindu" class="btn btn-warning" data-dismiss="modal">{{ molTextoBotonCancelAddMoldura  }}</button>		
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
						<div v-if="oc.automatico == 'NO' || (oc.automatico == 'SI' && oc.cantidad > 0)" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="form-group">
								<label class="col-lg-6 col-md-6  control-label text-right">{{ oc.descripcion }}</label>
								<div class="col-lg-3 col-md-3 ">
									
									<input type="text"
									v-model="oc.cantidad"
									 :placeholder="oc.solicitar"
									:disabled="oc.automatico == 'SI' ? true : false"
									oninput="this.value = this.value.replace(/[^0-9.\t]/g, '').replace(/(\..*)\./g, '$1'); "	
									maxlength="9" class="form-control text-right">
									<span v-show="oc.automatico == 'SI'" class="text-danger">**NO editable</span>

										
								</div> 
								
								<div class="col-lg-3 col-md-3 ">
<!-- 									<input type="text" -->
<!-- 									v-model="oc.monto" -->
<!-- 									 placeholder="" -->
<!-- 									oninput="this.value = this.value.replace(/[^0-9.\t]/g, '').replace(/(\..*)\./g, '$1'); "	 -->
<!-- 									maxlength="9" class="form-control text-right"> -->
										<h3 class="control-label text-right">{{ formatNumber(oc.monto) }}</h3>
								</div> 
								
							</div>
						</div>
<!-- 					</div> -->
					
				</div>
				
				<hr>
				
				<div class="row m-b-xs" >
<!-- 					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b"> -->
						<!-- 											metros cuad piezas (int) kg ml -->
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
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

<!-- Apartar Mercancia ? -->
<!-- <div class="modal inmodal" id="modalApartarMercancia" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
	<div class="modal-dialog ">
		<div class="modal-content animated bounceInRight">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
				</button>

				<h4 class="modal-title">¿Desea que el Pedido aparte mercanc&iacute;a?</h4>
				
				
			</div>
			<div class="modal-body">
				<div class="row m-b text-center">
					<div class="text-center">
						<div class="onoffswitch">
							<input type="checkbox" class="onoffswitch-checkbox"
								id="chkPedidoApartaMercancia" v-model="pedidoApartaMercancia"> <label class="onoffswitch-label" for="chkPedidoApartaMercancia"> 
								<span
								class="onoffswitch-inner"></span> <span class="onoffswitch-switch"></span>
							</label>
						</div>
					</div>
				</div>
				
				
				
			</div>
			<div class="modal-footer">				

					<button  type="button" @click.prevent="$('#modalApartarMercancia').modal('toggle');"
					class="btn btn-danger pull-left">Cancelar</button>

					<button  type="button" @click.prevent="apartadosLevantarPedido"
					class="btn btn-primary pull-right">Aceptar</button>
			</div>
		</div>
	</div>
</div> -->


<!-- Fin Apartar Mercancia ? -->

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
					<input type="text" id="defaultfn" v-model="filtroNombreCliente"
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
						<i class="fa fa-thumbs-up fa-2x"></i> 
						<span v-show="wasPedido">Pedido Generado</span> 
						<span v-show="wasCotizacion">Cotizaci&oacute;n Generada</span>
						<span v-show="wasPedido && wasCotizacion">Se ha generado Pedido y Cotizaci&oacute;n</span>

					</h2>
				</div>
				<div class="ibox-content">
					<div class="row">
						<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
							<h1 v-if="wasPedido">Folio Pedido: {{ pedidoFolio }}</h1>
							<h1 v-if="wasCotizacion">Folio Cotizaci&oacute;n: {{ idCotizacion }}</h1>
						</div>
					</div>
					<div  class="row">
						<div v-if="idCotizacion == 0 || isCotiPedido" class="col-lg-3 col-md-3 col-sm-12 col-xs-12"
							style="padding-top: 10px">
							<a 
								:href="'<?php echo URL_BASE;?>pedidopdf?id=' + pedidoFolio"
								target="_blank" class="btn btn-success btn-lg"><i
								class="fa fa-print"></i> Imprimir Pedido</a>

							
						</div>
						<div v-if="idCotizacion > 0 || isCotiPedido" class="col-lg-3 col-md-3 col-sm-12 col-xs-12"
							style="padding-top: 10px">
							<a 
								:href="'<?php echo URL_BASE;?>cotizacionpdf?id=' + idCotizacion"
								target="_blank" class="btn btn-success btn-lg"><i
								class="fa fa-thumb-tack"></i> Imprimir Cotizaci&oacute;n</a>
							
						</div>
						<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12"
							style="padding-top: 10px">
							<button v-if="idCotizacion == 0" @click.prevent="sendPedidoACliente"
								class="btn btn-success btn-lg">
								<i class="fa fa-envelope"></i> Enviar a Cliente
							</button>
						</div>
						<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12"
							style="padding-top: 10px">
							<a href="<?php echo URL_BASE?>pedidonuevo"
								class="btn btn-primary btn-lg"><i class="fa fa-shopping-cart"></i>
								Nuevo Pedido/Cotizaci&oacute;n</a>
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
				<!-- <i class="fa fa-shopping-cart modal-icon"></i> -->
				<h4 class="modal-title">({{	idProductoModal}})&nbsp;{{ descripcionModal }}</h4>
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

                <!-- Inicio Otros productos Comercializados -->
                <div v-show="productosDePadreComercializados.length > 0" class="ibox">  
                    <div class="ibox-title">
                        Otras medidas del Producto
                    </div> 
                    <div class="ibox-content">
                        <div class="row">
                            <div v-for="prod in productosDePadreComercializados" class="col-md-6" v-show="codigoModal != prod.codigo">
                                <div   class="btn-group m-l-md m-b-md">
                                    <!-- <button class="btn btn-white btn-xs" ><i class="text-danger fa fa-heart-o"></i> ID: {{ med.idProducto}}</button>                                                         -->
                                    <button @click.prevent="addRemoveFromFavoritos(prod.idProducto, prod.favorito)" class="btn btn-white btn-xs" :class="prod.favorito == 'SI' ? 'text-danger' : ''" ><i class="fa " :class="prod.favorito == 'SI' ? 'fa-heart' : 'fa-heart-o'"></i></button>                                                        
                                    <button @click.prevent="mostrarOtroProductoEnModal(prod.idProducto)" class="btn btn-primary btn-xs m-l-md m-b-md">
                                    (ID: {{ prod.idProducto }})&nbsp;&nbsp;&nbsp;<strong v-show="prod.mlpieza == 0.0"> ? ml</strong><strong v-show="prod.mlpieza > 0">{{ prod.mlpieza }} ml</strong></button>
                                    <!-- <button class="btn btn-white btn-xs" ><i class="text-primary fa fa-plus"></i></button> -->
                                </div>                                
                            </div>
                        </div>
                    </div>
                
                </div>
                <!-- FIN Inicio Otros productos Comercializados -->

				<div v-show="modalMostrarMsgAgregarMas" class="row m-b-xs">
					<div class="alert alert-info">
						Producto Agregado, puede agregar el mismo producto con otras cantidades si lo desea.
					</div>
				</div>

			</div>
			<div class="modal-footer">
				<button type="button" @click.prevent="checarSiHayMercanciaIsocindu" class="btn btn-warning" data-dismiss="modal">{{ textBotonCancelModal }}</button>
				<button @click.prevent="enlistaProductoDeModal" type="button"
					class="btn btn-primary">{{ textBotonAddModal }}</button>
			</div>
		</div>
	</div>
</div>

<!-- 	</div> -->
<!-- </div> -->

<!-- PASAR COTIZACION A PEDIDO -->
<div id="secCotizacionAPedidoID" v-show="secCotizacionAPedido" class="row" >
	<div class="col-md-12">
		<div class="ibox" >
			<div class="ibox-title">				
				<h5>Convertir Cotizaci&oacute;n a Pedido</h5>
			</div>
			<div class="ibox-content" >
			<h3>
				<!-- <button @click.prevent="refreshDatosClienteSeleccionado" v-show="idClienteSeleccionado > 0" class="btn btn-primary"><i class="fa fa-refresh"></i></button> -->
				<i class="fa fa-user"></i> {{ clienteSeleccionado }} <small> {{ clienteTipoRangoSeleccionado }}</small>
				<span v-if="idClienteSeleccionado == 137" class="badge badge-info"> CLIENTE MENDEZ, PRECIO ESPECIAL</span>

			</h3>
				
				<div class="table-responsive">
					<table id="tblPedidoShortcotitopedi"
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

								<th data-sort-ignore="true" class="text-right">Puede Surtirse</th>
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
									
									<!-- <div v-show="item.idTipoProducto == 1 && (item.idAplicacion == 3 || item.idAplicacion == 9 || item.idAplicacion == 30) && item.idRollo > 1">
										<button  @click.prevent="curvarProducto(index)" class="btn btn-primary btn-xs"><i class="fa fa-moon-o"></i> Combar</button>
										<button  v-show="item.curva != ''" @click.prevent="quitarCurvaAProducto(index)" class="btn btn-danger btn-xs"><i class="fa fa-moon-o"></i> Quitar Curva</button>
									</div> -->
									
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

												<span v-show="!item.molIsScrap">
													Precio Secci&oacute;n &oacute; L&aacute;mina: ${{ formatNumber(item.precio1 * item.cantidad * item.cantUnidadReal)}}
												</span>
												<span v-show="item.molIsScrap">
													Precio ({{ molTotalCMScrap }} cm) Scrap: ${{ formatNumber(item.precio1 * item.cantidad * item.cantUnidadReal)}}
												</span>
												
											</span>
											<br>

												Dobleces ML: ${{ formatNumber(item.molDobles * item.dobleces) }} (* PZAS: ${{ formatNumber(item.cantidad * item.molDobles * item.dobleces) }})
											<br>

												Corte ML: ${{ formatNumber(item.molCorte) }} (* PZAS: ${{ formatNumber(item.cantidad * item.molCorte) }})
											<br>
												<span v-show="(item.molLongitudinal == 'L' && item.desarrolloT >= 100) || (item.molLongitudinal == 'A' && item.cantUnidad >= 1.00 && item.cantUnidad < 2.00) " class="badge badge-info"> +50% Corte/Dobles </span>
												<span v-show="(item.molLongitudinal == 'A' && item.cantUnidad >= 2.00) " class="badge badge-info"> +100% Corte/Dobles </span>
										</small>
									</div>
									
									<div v-show="item.idProducto == molIdMaquila && !molIsScrap">
										
										<small>

												Dobleces: ${{ formatNumber(item.molDobles * item.dobleces) }}

											<br>

												Corte: ${{ formatNumber(item.molCorte) }}

										</small>
									</div>
									
									<div v-show="item.molIsScrap">
										
										<small> 						
																			
												Scrap {{ formatNumber(item.molTotalCMScrap) }} cm

											<br>

													${{ formatNumber(item.precio1 * item.cantUnidadReal	) }}
													
													<br>

												Dobleces ML: ${{ formatNumber(item.molDobles * item.dobleces) }} (* PZAS: ${{ formatNumber(item.cantidad * item.molDobles * item.dobleces) }})
											<br>

												Corte ML: ${{ formatNumber(item.molCorte) }} (* PZAS: ${{ formatNumber(item.cantidad * item.molCorte) }})

										</small>
									</div>
									
									


									<div v-if="item.sugerirStock.length > 0 "  class="alert alert-info" style="margin-top: 2px; margin-bottom: 2px">
										<strong>Stock sugerido</strong><br>
										<div v-for="ss in item.sugerirStock">
											<span class="badge badge-warning">
												{{ ss.idProducto }} </span> <strong> {{ ss.codigo }}</strong> - {{ ss.descauto }} <i>({{ ss.disponible }} Pzas Disponibles)</i>
										</div>
										
										
									</div>
									


									<!-- <div v-if="!item.productoCantidadDisponible && item.shortUnidad != 'PZA' "  class="alert alert-danger" style="margin-top: 2px; margin-bottom: 2px">
										<span class="badge badge-info">{{ item.idRollo }}</span> Disponible de Rollo no cubre su solicitud.
									</div>

									<div v-if="!item.productoCantidadDisponible && item.shortUnidad == 'PZA' "  class="alert alert-danger" style="margin-top: 2px; margin-bottom: 2px">
										<span class="badge badge-warning">{{ item.idProducto }}</span> Disponible de Piezas no cubre su solicitud.
									</div>
									 -->
									


								</td>

								<td>{{ item.cantidad }}</td>

								<td>
									<span v-if="item.shortUnidad != 'PZA'"> {{ item.cantUnidad }} <span v-if="item.shortUnidad == 'M2'">ML ({{ formatNumber(item.cantUnidadReal) }} M2)</span> </span>

									<span v-else-if="item.longitud">{{ item.longitud }}</span>
									<span v-else>-</span>

								<td>
									<span v-if="item.desarrolloT != '' ">
											<div v-if="item.desarrolloT != '0'">{{ item.desarrolloT }}</div>
											<div v-else>-</div>
									</span> 
									

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

									<i v-if="item.debug == 'SI'" class="fa fa-check-circle fa-2x text-navy"></i>
									<i v-if="item.debug == 'NO'" class="fa fa-times-circle-o fa-2x text-danger"></i>
																
								</td>

							</tr>
						</tbody>

					</table>
				</div>
				<div class="row">
				    <br>
					<div v-show="RDNoSeSurteTodo"  class="alert alert-danger pull-right" style="margin-top: 2px; margin-bottom: 2px">
						Tenga en cuenta que <strong>NO</strong> todo puede surtirse en el pedido
					</div>
					<br>
					
				</div>
				<br>
				<div class="row">
					<div class="table-responsive">
						<table class="table invoice-total">
							<tbody>
	<!-- 											<tr v-show="porDescuento > 0"> -->
								<tr>
									<td><strong>SUBTOTAL :</strong></td>
									<td><h3>${{ formatNumber(subtotalPedido) }}</h3></td>
								</tr>
								
	<!-- 											<tr v-show="listadoPedido.length > 0 || totalOtrosCargos > 0"> -->
								<tr>
									<td>
										<!-- <button class="btn btn-primary btn-xs" @click.prevent="agregarOtrosGastos"><i class="fa fa-plus"></i></button> -->
										&nbsp;<strong>OTROS SERVICIOS:</strong>
									</td>
									<td><h3>${{ formatNumber(totalOtrosCargos) }}</h3></td>
								</tr>
								
								
								<tr v-show="promobuenfin">
									<td>
										<strong>TIPO DE PAGO:</strong>
									</td>
									<td>
										<select v-model="buenfintipopago" class="form-control">
										<option value="0">--Seleccione Tipo--</option>
										<option value="99">CONTADO (BUEN FIN PROMOCI&Oacute;N)</option>
										<option value="22">OTRO</option>
									</select>
									</td>
								</tr>
								
								<tr v-show="descuentoPedido > 0">												
								<td><img v-if="promobuenfin" src="<?php echo URL_BASE;?>\img\buenfin.png" style="width: 64px;"><strong>DESCUENTO {{ porDescuento }} %:</strong></td>
									<td><h3>${{ formatNumber(descuentoPedido) }}</h3></td>
								</tr>
								<tr>
									<td><strong>TOTAL nerkpumper :</strong></td>
									<td><h1 class="font-bold">${{ formatNumber(totalPedido) }}</h1></td>
									
								</tr>
								<tr v-if="idCotizacion > 0">
									<td colspan="2">
										<button class="btn btn-warning " @click.prevent="updateAllToCurrentPrices">Recalcular Total con Precios Actuales</button>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<br>
				<div class="row">
					<div class="col-lg-6 col-md-offset-3">
						<div class="panel panel-primary">
							<div class="panel-heading">
								Disponible cliente bajo plan protecci&oacute;n
							</div>
							<div class="panel-body">
								<div class="table-responsive">
									<table class="table">
										<tbody>											
											<tr>
												<td><strong>SALDO DISPONIBLE TOTAL:</strong></td>
												<td><h2 class="font-bold text-success">$ {{ formatNumber(saldoRD) }}</h2></td>
											</tr>
											<tr>
												<td><strong>SALDO DISPONIBLE ANTES DE LA COTIZACI&Oacute;N:</strong></td>
												<td><h3 class="font-bold text-success">$ {{ formatNumber(RDTotal) }}</h3></td>
											</tr>
											
											<tr>
												<td>SALDO DE 0 A 30 D&Iacute;AS:</td>
												<td><h4 class="font-bold">$ {{ formatNumber(saldoRD030) }}</h4></td>
											</tr>
											<tr>
												<td>SALDO DE 31 A 60 D&Iacute;AS:</td>
												<td><h4 class="font-bold">$ {{ formatNumber(saldoRD3160) }}</h4></td>
											</tr>
											<tr>
												<td>SALDO DE 60 D&Iacute;AS O M&Aacute;S:</td>
												<td><h4 class="font-bold">$ {{ formatNumber(saldoRDmas60) }}</h4></td>
											</tr>
											<tr>
												<td><strong>TOTAL QUE AMPARA EL SALDO:</strong></td>
												<td><h2 class="font-bold text-success">$ {{ formatNumber(RDTotalAAmparar) }}</h2></td>
											</tr>
											
										</tbody>
									</table>
								</div>
								
								<div v-show="!RDCubreCotizacion && RDTotalAAmparar > 0"  class="alert alert-danger" style="margin-top: 2px; margin-bottom: 2px">
									La Cantidad que ampara su Saldo Disponible es <strong>$ {{ formatNumber(RDTotalAAmparar) }}</strong>, su Cotizaci&oacute;n tiene un Total de <strong>$ {{ formatNumber(totalPedido) }}</strong>.
									<br>
									Debe reducir del Total de la Cotizaci&oacute;n la cantidad de <strong>$ {{ formatNumber(totalPedido - RDTotalAAmparar) }}</strong>.
								</div>
								
								<div v-show="!RDCubreCotizacion && RDTotal > 0"  class="alert alert-info" style="margin-top: 2px; margin-bottom: 2px">
									El Saldo Disponible del Cliente <strong>NO</strong> Ampara el Total de la Cotizaci&oacute;n. <strong>El Pedido generado deber&aacute; ser Autorizado por el personal o proceso correspondiente para su seguimiento</strong>.
								</div>
								
								<div v-show="RDCubreCotizacion"  class="alert alert-info " style="margin-top: 2px; margin-bottom: 2px">
									El Saldo Disponible del Cliente <strong>SI</strong> Ampara el Total de la Cotizaci&oacute;n. <strong>El Pedido generado ser&aacute; Autorizado de manera autom&aacute;tica para agilizar su producci&oacute;n</strong>.
								</div>
								
								<div v-show="RDTotalAAmparar > 0 && !RDCubreCotizacion && RDDebeActualizarPrecios && haCambiadoPrecioCotizacion == 'SI'"  class="alert alert-warning" style="margin-top: 2px; margin-bottom: 2px">
									Si utiliza este PLAN DE PROTECCI&Oacute;N, no es necesario actualizar los precios a los actuales.
								</div>

								<!-- @click.prevent="preLevantarPedido(true, true, false, true)" -->
								<button v-show="mostrarBotonGuardar && idCotizacion > 0									
												&& ( (RDCubreCotizacion && RDTotalAAmparar > 0) 										 
												|| id_usuario_autorizaimpresion > 0)" @click.prevent="levantarOConvertirAPedido('CONVERTIR_A_PEDIDO_CON_PLAN')"
										class="btn btn-primary btn-lg btn-block" style="margin-top: 5px;">
										<i class="fa fa-link"></i> 											
										<span v-if="idCotizacion > 0">Convertir en Pedido con PLAN DE PROTECCI&Oacute;N</span>
								</button>
							</div>
						</div>
						<div v-show="!RDPreciosActualizados && haCambiadoPrecioCotizacion == 'SI'"  class="alert alert-warning " style="margin-top: 2px; margin-bottom: 2px">
							Se ha detectado que alguno de los productos en la Cotizaci&oacute;n han cambiado de precio desde su creaci&oacute;n. Debe actualizar los precios para continuar SIN EL PLAN DE PROTECCI&Oacute;N.
						</div>

					</div>					
				</div>
				
            </div>



            <div class="ibox-footer" >
				
				<button v-show="!RDPreciosActualizados && haCambiadoPrecioCotizacion == 'SI'" class="btn btn-warning btn-lg pull-left" @click.prevent="updateAllToCurrentPrices">Recalcular Total con Precios Actuales</button>

				<!-- @click.prevent="preLevantarPedido(true, true)" -->
				<button v-show="(RDPreciosActualizados && haCambiadoPrecioCotizacion == 'SI') || (haCambiadoPrecioCotizacion == 'NO') " 
					@click.prevent="levantarOConvertirAPedido('CONVERTIR_A_PEDIDO_SIN_PLAN')"
					class="btn btn-primary btn-lg pull-left" style="margin-top: 5px;">
										<i class="fa fa-link"></i> 											
					<span>Convertir en Pedido SIN PLAN DE PROTECCI&Oacute;N</span>
							
				</button>
				
				<button  @click.prevent="backPantallaPasarAPedido"
							class="btn btn-danger btn-lg pull-right">
							<i class="fa fa-back"></i> 											
							<span v-if="idCotizacion > 0">Regresar a Editar mi Cotizaci&oacute;n</span>
				</button>
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
</div>		


<!-- FIN PASAR COTIZACION A PEDIDO -->

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



<div v-show="vistaPedido" >

	<div class="ibox-content ibox-heading">

		<h3>
			<button @click.prevent="refreshDatosClienteSeleccionado()" v-show="idClienteSeleccionado > 0" class="btn btn-primary"><i class="fa fa-refresh"></i></button>
			<i class="fa fa-user"></i> {{ clienteSeleccionado }} <small> {{ clienteTipoRangoSeleccionado }}</small>
			<span v-if="idClienteSeleccionado == 137" class="badge badge-info"> CLIENTE MENDEZ, PRECIO ESPECIAL</span>
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


    

    

	<div class="row" >
		<div class="col-md-12">
			<div class="ibox" >
				<div class="ibox-title">
					<!-- 				<span class="pull-right">(<strong>5</strong>) items -->
					<!-- 				</span> -->
					<h5>Seleccionar Productos</h5>
				</div>
				<div class="ibox-content" >

                    

					<div v-if="idCotizacion > 0" class="row">
						<div class="col-md-3"></div>
						<div class="col-md-6">
							<div class="alert alert-danger text-center">
								<h4>
									Usted esta editando la Cotizaci&oacute;n con folio: <span class="alert-link blink_me">{{ idCotizacion}}</span>
								</h4>
							</div>
						</div>
						<div class="col-md-3"></div>
					</div>
					<div class="row">
						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 form-group">
							<!-- 				<label for="default">Pick a programming language</label> -->
                            <!-- <span>NAN {{ isNaN(productoAEnlistar) }}</span> -->
							<input type="text" id="default" list="lstProductos"
								v-model="productoAEnlistar" placeholder="INTRODUZCA EL ID, CÓDIGO O DESCRIPCIÓN DEL PRODUCTO"
								class="form-control input-lg"
								v-on:keypress.enter="setTimeout(function(){app.prepararProducto();}, 200);">

							<datalist id="lstProductos">
								<option v-for="item in productosParaFiltro"
									:value="item.fullDescripcionCode"
									:label="item.fullDescripcionCode">{{item.idProducto}}
									{{item.fullDescripcion}}</option>
							</datalist>
						</div>
						<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
							<button @click.prevent="prepararProducto"
								class="btn btn-primary btn-lg m-b-md" type="button">
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
					<!-- hi -->
					<div class="row">
						<h3 class="m-l-lg">FILTROS DE B&Uacute;SQUEDA</h3>
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group">
                            <button  :class="seleccionarLaminaMetalica ? 'btn btn-default m-b-md' : 'btn btn-primary m-b-md'" @click.prevent="selectorLaminaMetalica"
                                data-toggle="tooltip" data-placement="left" title="Metros y Rollos"
                                ><i :class="seleccionarLaminaMetalica ? 'fa fa-angle-up' : 'fa fa-angle-down'"></i> L&aacute;mina Met&aacute;lica</button>
                            <button  :class="seleccionarComercializados ? 'btn btn-default m-b-md' : 'btn btn-primary m-b-md'" @click.prevent="selectorComercializados"
                                data-toggle="tooltip" data-placement="left" title="Opalit, Acrylit, Panel, Tizacril"
                                ><i :class="seleccionarComercializados ? 'fa fa-angle-up' : 'fa fa-angle-down'"></i> Comercializados</button>
							<button class="btn btn-primary m-b-md" @click.prevent="agregarMolduraV2"
                                data-toggle="tooltip" data-placement="left" title="Molduras"
                                >Moldura</button>
							<button class="btn btn-primary m-b-md" @click.prevent="agregarMaquilaV2"
                                data-toggle="tooltip" data-placement="left" title="Maquilas"
                                >Maquila de Moldura</button>
                            <button  :class="seleccionarAccesorios ? 'btn btn-default m-b-md' : 'btn btn-primary m-b-md'" @click.prevent="selectorAccesorios"
                                data-toggle="tooltip" data-placement="left" title="Accesorios"
                                ><i :class="seleccionarAccesorios ? 'fa fa-angle-up' : 'fa fa-angle-down'"></i> Accesorios</button>
                            <button  :class="seleccionarMasVendidos ? 'btn btn-default m-b-md' : 'btn btn-primary m-b-md'" @click.prevent="selectorMasVendidos"
                                data-toggle="tooltip" data-placement="left" title="Productos Más Vendidos"
                                ><i :class="seleccionarMasVendidos ? 'fa fa-angle-up' : 'fa fa-angle-down'"></i> Los Mas Vendidos</button>
                            <button  :class="seleccionarFavoritos ? 'btn btn-default m-b-md' : 'btn btn-white m-b-md'" @click.prevent="selectorFavoritos"
                                data-toggle="tooltip" data-placement="left" title="Productos que ha marcado como sus favoritos"
                                ><i :class="seleccionarFavoritos ? 'fa fa-angle-up' : 'fa fa-angle-down'"></i> Favoritos <i class='fa fa-heart text-danger'></i> <span class="badge badge-info "> {{ productosNuevoFiltroFavoritos.length }} </span> </button>
                            
						</div>
						
					</div>
                    <!-- Nuevo selector de productos -->
                    <div class="row" >
						
                        <!-- <div v-show="mostrarTiposProducto"> -->
                        <div v-show="seleccionarLaminaMetalica" id="tableroSeleccionarLaminaMetalica" class="ibox m-l-sm m-r-l" >
                            <hr>
                        
                            <!-- <buton class="btn btn-primary btn-outline">el boton&nbsp;&nbsp;&nbsp;&nbsp; <span class="label label-success pull-right">16</span></buton> -->
                            <h2><button @click.prevent="seleccionarLaminaMetalica = false" class="btn btn-danger btn-xs"><i class="fa fa-angle-up"></i></button>  L&aacute;minas Met&aacute;licas</h2>
                            
                            <div class="row">                               

                                
                                <div class="col-lg-2">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">                                                    
                                            <h6 class="panel-title">
                                                <i @click.prevent="selectAll('Acanalado')" class="fa fa-check-square-o pointer" data-toggle="tooltip" data-placement="left" title="Seleccionar todo"></i>
                                                <i @click.prevent="unselectAll('Acanalado')" class="fa fa-square-o pointer" data-toggle="tooltip" data-placement="left" title="Deseleccionar todo"></i>                                                        
                                                <a data-toggle="collapse" @click.prevent="expandedAcanalados = !expandedAcanalados" data-parent="#accordion" href="#collapse1"><strong>Acanalado</strong><i :class="expandedAcanalados ? 'fa fa-angle-up pull-right' : 'fa fa-angle-down pull-right'"></i></a>
                                            </h6>
                                        </div>
                                        <div id="collapse1" class="panel-collapse collapse " :class="expandedAcanalados ? 'in' : ''">
                                            <div class="panel-body">
                                                <!-- <button @click.prevent="testAcanalado" class="btn btn-primary btn-xs">Test</button> -->
                                                <div v-for="(aca, index) in lstAcanalados" class="checkbox checkbox-primary">
                                                    <input :id="'checkboxaca' + aca.id" type="checkbox" v-model="aca.checked"> 
                                                        <!-- :checked="index % 2 == 0 ? 'checked' : ''">  -->
                                                    <label :for="'checkboxaca' + aca.id ">
                                                        {{ aca.value }}
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                                    
                                <div class="col-lg-2">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h6 class="panel-title">
                                                <i @click.prevent="selectAll('Material')" class="fa fa-check-square-o pointer" data-toggle="tooltip" data-placement="left" title="Seleccionar todo"></i>
                                                <i @click.prevent="unselectAll('Material')" class="fa fa-square-o pointer" data-toggle="tooltip" data-placement="left" title="Deseleccionar todo"></i>                                                        
                                                <a data-toggle="collapse" @click.prevent="expandedMateriales = !expandedMateriales" data-parent="#accordion" href="#collapse2"><strong>Material</strong><i :class="expandedMateriales ? 'fa fa-angle-up pull-right' : 'fa fa-angle-down pull-right'"></i></a>
                                            </h6>
                                        </div>
										<!-- los materiales -->
                                        <div id="collapse2" class="panel-collapse collapse " :class="expandedMateriales ? 'in' : ''">
                                            <div class="panel-body">
                                                <div v-for="(mate, index) in lstMateriales" class="checkbox checkbox-primary">
                                                    <input :id="'checkboxmate' + mate.id" type="checkbox" v-model="mate.checked"> 
                                                        <!-- :checked="index % 2 == 0 ? 'checked' : ''">  -->
                                                    <label :for="'checkboxmate' + mate.id ">
                                                        {{ mate.value }}
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                    
                                <div class="col-lg-2">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h6 class="panel-title">
                                                <i @click.prevent="selectAll('Calibre')" class="fa fa-check-square-o pointer" data-toggle="tooltip" data-placement="left" title="Seleccionar todo"></i>
                                                <i @click.prevent="unselectAll('Calibre')" class="fa fa-square-o pointer" data-toggle="tooltip" data-placement="left" title="Deseleccionar todo"></i>                                                        
                                                <a data-toggle="collapse" @click.prevent="expandedCalibres = !expandedCalibres" data-parent="#accordion" href="#collapse3"><strong>Calibre</strong><i :class="expandedCalibres ? 'fa fa-angle-up pull-right' : 'fa fa-angle-down pull-right'"></i></a>
                                            </h6>
                                        </div>
                                        <div id="collapse3" class="panel-collapse collapse " :class="expandedCalibres ? 'in' : ''">
                                            <div class="panel-body">
                                                <div v-for="(cali, index) in lstCalibres" class="checkbox checkbox-primary">
                                                    <input :id="'checkboxcali' + cali.id" type="checkbox" v-model="cali.checked"> 
                                                        <!-- :checked="index % 2 == 0 ? 'checked' : ''">  -->
                                                    <label :for="'checkboxcali' + cali.id ">
                                                        {{ cali.value }}
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                    
                                <div class="col-lg-2">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h6 class="panel-title">
                                                <i @click.prevent="selectAll('Ancho')" class="fa fa-check-square-o pointer" data-toggle="tooltip" data-placement="left" title="Seleccionar todo"></i>
                                                <i @click.prevent="unselectAll('Ancho')" class="fa fa-square-o pointer" data-toggle="tooltip" data-placement="left" title="Deseleccionar todo"></i>                                                        
                                                <a data-toggle="collapse" @click.prevent="expandedEspesores = !expandedEspesores" data-parent="#accordion" href="#collapse4"><strong>Ancho</strong><i :class="expandedEspesores ? 'fa fa-angle-up pull-right' : 'fa fa-angle-down pull-right'"></i></a>
                                            </h6>
                                        </div>
                                        <div id="collapse4" class="panel-collapse collapse " :class="expandedEspesores ? 'in' : ''">
                                            <div class="panel-body">
                                                <div v-for="(espe, index) in lstEspesores" class="checkbox checkbox-primary">
                                                    <input :id="'checkboxespe' + espe.id" type="checkbox" v-model="espe.checked"> 
                                                        <!-- :checked="index % 2 == 0 ? 'checked' : ''">  -->
                                                    <label :for="'checkboxespe' + espe.id ">
                                                        {{ espe.value }}
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                    
                                <div class="col-lg-2">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h6 class="panel-title">
                                                <i @click.prevent="selectAll('Proveedor')" class="fa fa-check-square-o pointer" data-toggle="tooltip" data-placement="left" title="Seleccionar todo"></i>
                                                <i @click.prevent="unselectAll('Proveedor')" class="fa fa-square-o pointer" data-toggle="tooltip" data-placement="left" title="Deseleccionar todo"></i>                                                        
                                                <a data-toggle="collapse" @click.prevent="expandedProveedores = !expandedProveedores" data-parent="#accordion" href="#collapse5"><strong>Proveedor</strong><i :class="expandedProveedores ? 'fa fa-angle-up pull-right' : 'fa fa-angle-down pull-right'"></i></a>
                                            </h6>
                                        </div>
                                        <div id="collapse5" class="panel-collapse collapse " :class="expandedProveedores ? 'in' : ''">
                                            <div class="panel-body">
                                                <div v-for="(prov, index) in lstProveedores" class="checkbox checkbox-primary">
                                                    <input :id="'checkboxprov' + prov.id" type="checkbox" v-model="prov.checked"> 
                                                    <!-- :checked="index % 2 == 0 ? 'checked' : ''">  -->
                                                    <label :for="'checkboxprov' + prov.id ">
                                                        {{ prov.value }}
                                                    </label>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                    
                                
                            </div>
                            <div class="row">
                                <div v-show="productosFiltradosLaminas.length <= 0" class="col-lg-12">
                                    <h3 class="m-l-lg">No se han encontrado Productos con los filtros indicados</h3>
                                </div>                                
                                <div v-show="productosFiltradosLaminas.length > 0" class="col-lg-12">
                                    <!-- <button @click.prevent="saveCookie" class="btn btn-primary">Save Cookie</button>
                                    <button @click.prevent="getCookie" class="btn btn-primary">Get Cookie</button> -->
                                    <table id="tblProductosFiltradosLamina"
                                        class="table table-stripped table-bordered toggle-arrow-tiny" data-page-size="10">
                                        <thead>
                                            <tr>
                                                <th data-sort-ignore="true">ID</th>
                                                <th data-sort-ignore="true">C&oacute;digo</th>
                                                <th data-sort-ignore="true" data-hide="phone">Descripi&oacute;n</th>
                                                <th data-sort-ignore="true" data-hide="phone">Unidad</th>                                                
                                                <th data-sort-ignore="true" class="text-right">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(prod, index) in productosFiltradosLaminas">
                                                <td>{{ prod.idProducto }}</td>
                                                <td>{{ prod.codigo }}</td>
                                                <td>{{ prod.fullDescripcion }} <span v-if="prod.shortUnidad == 'PZA'" class="badge badge-info "> {{ prod.existenciaEstimada }} </span></td>
                                                <td>{{ prod.shortUnidad }}</td>                                                
                                                <td class="text-right">
                                                    <!-- 																<button @click.prevent="prepararProductoDesdeGrid(prod.codigo);" class="btn btn-outline btn-primary dim btn-xs" type="button"><i class="fa fa-pencil"></i></button> -->

                                                    <button @click.prevent="addRemoveFromFavoritos(prod.idProducto, prod.favorito)"
                                                        data-toggle="tooltip" data-placement="top" :title="prod.favorito == 'SI' ? 'Quitar de Mis Favoritos' : 'Agregar a Mis Favoritos'"
                                                        class="btn btn-outline btn-white btn-xs" :class=" prod.favorito == 'SI' ? 'text-danger' : ''" type="button">
                                                        <i class="fa " :class="prod.favorito == 'SI' ? 'fa-heart' : 'fa-heart-o'"></i>
                                                    </button>

                                                    <button @click.prevent="prepararProductoDesdeGrid(prod.codigo);"
                                                        data-toggle="tooltip" data-placement="top" title="Agregar a la lista de compra"
                                                        class="btn btn-outline btn-primary btn-xs " type="button">
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



                            <!-- <hr> -->
                        </div> <!-- FIN LAMINA METALICA-->

                        <div v-show="seleccionarComercializados" id="tableroSeleccionarComercializados" class="ibox m-l-sm m-r-l" >
                            <hr>
                        
                            <!-- <buton class="btn btn-primary btn-outline">el boton&nbsp;&nbsp;&nbsp;&nbsp; <span class="label label-success pull-right">16</span></buton> -->
                            <h2><button @click.prevent="seleccionarLaminaMetalica = false" class="btn btn-danger btn-xs"><i class="fa fa-angle-up"></i></button>  Comercializados</h2>
                            
                            <div class="row">                               

                                
                                <div class="col-lg-2">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">                                                    
                                            <h6 class="panel-title">
                                                <i @click.prevent="selectAll('AcanaladoComer')" class="fa fa-check-square-o pointer" data-toggle="tooltip" data-placement="left" title="Seleccionar todo"></i>
                                                <i @click.prevent="unselectAll('AcanaladoComer')" class="fa fa-square-o pointer" data-toggle="tooltip" data-placement="left" title="Deseleccionar todo"></i>                                                        
                                                <a data-toggle="collapse" @click.prevent="expandedAcanaladosComer = !expandedAcanaladosComer" data-parent="#accordion" href="#collapsecom1"><strong>Acanalado</strong><i :class="expandedAcanaladosComer ? 'fa fa-angle-up pull-right' : 'fa fa-angle-down pull-right'"></i></a>
                                            </h6>
                                        </div>
                                        <div id="collapsecom1" class="panel-collapse collapse " :class="expandedAcanaladosComer ? 'in' : ''">
                                            <div class="panel-body">
                                                <!-- <button @click.prevent="testAcanalado" class="btn btn-primary btn-xs">Test</button> -->
                                                <div v-for="(aca, index) in lstAcanaladosComer" class="checkbox checkbox-primary">
                                                    <input :id="'checkboxaca' + aca.id" type="checkbox" v-model="aca.checked"> 
                                                        <!-- :checked="index % 2 == 0 ? 'checked' : ''">  -->
                                                    <label :for="'checkboxaca' + aca.id ">
                                                        {{ aca.value }}
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                                    
                                <div class="col-lg-2">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h6 class="panel-title">
                                                <i @click.prevent="selectAll('MaterialComer')" class="fa fa-check-square-o pointer" data-toggle="tooltip" data-placement="left" title="Seleccionar todo"></i>
                                                <i @click.prevent="unselectAll('MaterialComer')" class="fa fa-square-o pointer" data-toggle="tooltip" data-placement="left" title="Deseleccionar todo"></i>                                                        
                                                <a data-toggle="collapse" @click.prevent="expandedMaterialesComer = !expandedMaterialesComer" data-parent="#accordion" href="#collapsecom2"><strong>Material</strong><i :class="expandedMaterialesComer ? 'fa fa-angle-up pull-right' : 'fa fa-angle-down pull-right'"></i></a>
                                            </h6>
                                        </div>
                                        <div id="collapsecom2" class="panel-collapse collapse " :class="expandedMaterialesComer ? 'in' : ''">
                                            <div class="panel-body">
                                                <div v-for="(mate, index) in lstMaterialesComer" class="checkbox checkbox-primary">
                                                    <input :id="'checkboxmate' + mate.id" type="checkbox" v-model="mate.checked"> 
                                                        <!-- :checked="index % 2 == 0 ? 'checked' : ''">  -->
                                                    <label :for="'checkboxmate' + mate.id ">
                                                        {{ mate.value }}
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                    
                                <div class="col-lg-2">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h6 class="panel-title">
                                                <i @click.prevent="selectAll('CalibreComer')" class="fa fa-check-square-o pointer" data-toggle="tooltip" data-placement="left" title="Seleccionar todo"></i>
                                                <i @click.prevent="unselectAll('CalibreComer')" class="fa fa-square-o pointer" data-toggle="tooltip" data-placement="left" title="Deseleccionar todo"></i>                                                        
                                                <a data-toggle="collapse" @click.prevent="expandedCalibresComer = !expandedCalibresComer" data-parent="#accordion" href="#collapsecom3"><strong>Calibre</strong><i :class="expandedCalibresComer ? 'fa fa-angle-up pull-right' : 'fa fa-angle-down pull-right'"></i></a>
                                            </h6>
                                        </div>
                                        <div id="collapsecom3" class="panel-collapse collapse " :class="expandedCalibresComer ? 'in' : ''">
                                            <div class="panel-body">
                                                <div v-for="(cali, index) in lstCalibresComer" class="checkbox checkbox-primary">
                                                    <input :id="'checkboxcali' + cali.id" type="checkbox" v-model="cali.checked"> 
                                                        <!-- :checked="index % 2 == 0 ? 'checked' : ''">  -->
                                                    <label :for="'checkboxcali' + cali.id ">
                                                        {{ cali.value }}
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-2">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h6 class="panel-title">
                                                <i @click.prevent="selectAll('MedidaEspecialComer')" class="fa fa-check-square-o pointer" data-toggle="tooltip" data-placement="left" title="Seleccionar todo"></i>
                                                <i @click.prevent="unselectAll('MedidaEspecialComer')" class="fa fa-square-o pointer" data-toggle="tooltip" data-placement="left" title="Deseleccionar todo"></i>                                                        
                                                <a data-toggle="collapse" @click.prevent="expandedMedidaEspecialComer = !expandedMedidaEspecialComer" data-parent="#accordion" href="#collapsecom4"><strong>Medida Especial</strong><i :class="expandedMedidaEspecialComer ? 'fa fa-angle-up pull-right' : 'fa fa-angle-down pull-right'"></i></a>
                                            </h6>
                                        </div>
                                        <div id="collapsecom4" class="panel-collapse collapse " :class="expandedMedidaEspecialComer ? 'in' : ''">
                                            <div class="panel-body">
                                                <div v-for="(me, index) in lstMedidaEspecialComer" class="checkbox checkbox-primary">
                                                    <input :id="'checkboxme' + me.id" type="checkbox" v-model="me.checked"> 
                                                        <!-- :checked="index % 2 == 0 ? 'checked' : ''">  -->
                                                    <label :for="'checkboxme' + me.id ">
                                                        {{ me.value }}
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                    
                                
                                    
                                
                            </div>
                            <div class="row">
                                <div v-show="productosFiltradosComercializados.length <= 0" class="col-lg-12">
                                    <h3 class="m-l-lg">No se han encontrado Productos con los filtros indicados</h3>
                                </div>                                
                                <div v-show="productosFiltradosComercializados.length > 0" class="col-lg-12">
                                    <!-- <button @click.prevent="saveCookie" class="btn btn-primary">Save Cookie</button>
                                    <button @click.prevent="getCookie" class="btn btn-primary">Get Cookie</button> -->
                                    <table id="tblProductosFiltradosComercializados"
                                        class="table table-stripped table-bordered toggle-arrow-tiny" data-page-size="10">
                                        <thead>
                                            <tr>
                                                <!-- <th data-sort-ignore="true">ID</th>
                                                <th data-sort-ignore="true">C&oacute;digo</th> -->
                                                <th data-sort-ignore="true" >Descripi&oacute;n</th>
                                                <!-- <th data-sort-ignore="true" data-hide="phone">Unidad</th>                                                
                                                <th data-sort-ignore="true" class="text-right">Action</th> -->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(prod, index) in productosFiltradosComercializados">
                                                <!-- <td></td>
                                                <td></td> -->
                                                <td>
                                                    <h4>
                                                        {{ prod.fullDescripcion }} 
                                                    </h4>
                                                    <!-- <br> -->
                                                    <!-- <button v-for="med in prod.productos" class="btn btn-primary btn-xs m-l-xs">{{ med.mlpieza}}</button>     -->
                                                    <div class="row">
                                                        <div v-for="med in prod.productos" class="col-md-2">
                                                            <div   class="btn-group m-l-md m-b-md">
                                                                <!-- <button class="btn btn-white btn-xs" ><i class="text-danger fa fa-heart-o"></i> ID: {{ med.idProducto}}</button>                                                         -->
                                                                <button @click.prevent="addRemoveFromFavoritos(med.idProducto, med.favorito)" class="btn btn-white btn-xs" :class="med.favorito == 'SI' ? 'text-danger' : ''"
                                                                    data-toggle="tooltip" data-placement="top" :title="med.favorito == 'SI' ? 'Quitar de Mis Favoritos' : 'Agregar a Mis Favoritos'"
                                                                     ><i class="fa " :class="med.favorito == 'SI' ? 'fa-heart' : 'fa-heart-o'"></i></button>                                                        
                                                                <button @click.prevent="prepararProductoDesdeGrid(med.codigo, index)" class="btn btn-primary btn-xs" 
                                                                    data-toggle="tooltip" data-placement="top" :title="med.fullDescripcion">
                                                                        (ID: {{ med.idProducto}})&nbsp;&nbsp;&nbsp;<strong v-show="med.mlpieza > 0.0">{{ med.mlpieza }} ml</strong><strong v-show="med.mlpieza == 0.0"> ? ml</strong>
                                                                        <span v-if="med.shortUnidad == 'PZA'" class="badge badge-info "> {{ med.existenciaEstimada }} </span>
                                                                </button>
                                                                <!-- <button class="btn btn-white btn-xs" ><i class="text-primary fa fa-plus"></i></button> -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <!-- <td></td>                                                
                                                <td class="text-right"> -->
                                                    <!-- 																<button @click.prevent="prepararProductoDesdeGrid(prod.codigo);" class="btn btn-outline btn-primary dim btn-xs" type="button"><i class="fa fa-pencil"></i></button> -->
                                                    <!-- <button @click.prevent="prepararProductoDesdeGrid(prod.codigo);"
                                                        class="btn btn-outline btn-primary " type="button">
                                                        <i class="fa fa-plus"></i>
                                                    </button> -->
                                                <!-- </td> -->
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



                            <!-- <hr> -->
                        </div> <!-- FIN COMERCIALIZADOS-->

                        <div v-show="seleccionarAccesorios" id="tableroSeleccionarAccesorios" class="ibox m-l-sm m-r-l" >
                            <hr>
                        
                            <!-- <buton class="btn btn-primary btn-outline">el boton&nbsp;&nbsp;&nbsp;&nbsp; <span class="label label-success pull-right">16</span></buton> -->
                            <h2><button @click.prevent="seleccionarAccesorios = false" class="btn btn-danger btn-xs"><i class="fa fa-angle-up"></i></button> Accesorios</h2>

                            <div class="row">                               
                                <div class="col-lg-6">
                                    <div class="input-group m-b"><span class="input-group-addon"><i class="fa fa-search"></i></span> <input type="text" v-model="filtroAccesorios"  class="form-control"></div>
                                </div>
                            </div>
                            <div class="row">                               

                                <div v-show="productosFiltradosAccesorios.length <= 0" class="col-lg-12">
                                    <h3 class="m-l-lg">No se han encontrado Productos con los filtros indicados</h3>
                                </div>                                
                                <div v-show="productosFiltradosAccesorios.length > 0" class="col-lg-12">
                                    <!-- <button @click.prevent="saveCookie" class="btn btn-primary">Save Cookie</button>
                                    <button @click.prevent="getCookie" class="btn btn-primary">Get Cookie</button> -->
                                    <table id="tblProductosFiltradosAccesorios"
                                        class="table table-stripped table-bordered toggle-arrow-tiny" data-page-size="10">
                                        <thead>
                                            <tr>
                                                <th data-sort-ignore="true">ID</th>
                                                <th data-sort-ignore="true">C&oacute;digo</th>
                                                <th data-sort-ignore="true" data-hide="phone">Descripi&oacute;n</th>
                                                <th data-sort-ignore="true" data-hide="phone">Unidad</th>                                                
                                                <th data-sort-ignore="true" class="text-right">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(prod, index) in productosFiltradosAccesorios">
                                                <td>{{ prod.idProducto }}</td>
                                                <td>{{ prod.idAplicacion }} {{ prod.codigo }}</td>
                                                <td>{{ prod.fullDescripcion }} <span v-if="prod.shortUnidad == 'PZA'" class="badge badge-info "> {{ prod.existenciaEstimada }} </span></td>
                                                <td>{{ prod.shortUnidad }}</td>                                                
                                                <td class="text-right">
                                                    <!-- 																<button @click.prevent="prepararProductoDesdeGrid(prod.codigo);" class="btn btn-outline btn-primary dim btn-xs" type="button"><i class="fa fa-pencil"></i></button> -->
                                                    <button @click.prevent="addRemoveFromFavoritos(prod.idProducto, prod.favorito)" class="btn btn-white btn-xs" :class="prod.favorito == 'SI' ? 'text-danger' : ''"
                                                                    data-toggle="tooltip" data-placement="top" :title="prod.favorito == 'SI' ? 'Quitar de Mis Favoritos' : 'Agregar a Mis Favoritos'"
                                                                     ><i class="fa " :class="prod.favorito == 'SI' ? 'fa-heart' : 'fa-heart-o'"></i></button>                                                        
                                                    <button @click.prevent="prepararProductoDesdeGrid(prod.codigo);"
                                                        class="btn btn-outline btn-primary btn-xs " type="button">
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



                            <!-- <hr> -->
                        </div> <!-- FIN ACCESORIOS-->

                        <div v-show="seleccionarMasVendidos" id="tableroSeleccionarMasVendidos" class="ibox m-l-sm m-r-l" >
                            <hr>
                        
                            <!-- <buton class="btn btn-primary btn-outline">el boton&nbsp;&nbsp;&nbsp;&nbsp; <span class="label label-success pull-right">16</span></buton> -->
                            <h2><button @click.prevent="seleccionarMasVendidos = false" class="btn btn-danger btn-xs"><i class="fa fa-angle-up"></i></button> Mas Vendidos</h2>

                            <div class="row">                               
                                <div class="col-lg-6">
                                    <div class="input-group m-b"><span class="input-group-addon"><i class="fa fa-search"></i></span> <input type="text" v-model="filtroMasVendidos"  class="form-control"></div>
                                </div>
                            </div>
                            <div class="row">                               

                                <div v-show="productosFiltradosMasVendidos.length <= 0" class="col-lg-12">
                                    <h3 class="m-l-lg">No se han encontrado Productos con los filtros indicados</h3>
                                </div>                                
                                <div v-show="productosFiltradosMasVendidos.length > 0" class="col-lg-12">
                                    <!-- <button @click.prevent="saveCookie" class="btn btn-primary">Save Cookie</button>
                                    <button @click.prevent="getCookie" class="btn btn-primary">Get Cookie</button> -->
                                    <table id="tblProductosFiltradosMasVendidos"
                                        class="table table-stripped table-bordered toggle-arrow-tiny" data-page-size="10">
                                        <thead>
                                            <tr>
                                                <th data-sort-ignore="true">ID</th>
                                                <th data-sort-ignore="true">C&oacute;digo</th>
                                                <th data-sort-ignore="true" data-hide="phone">Descripi&oacute;n</th>
                                                <th data-sort-ignore="true" data-hide="phone">Eventos</th>                                                
                                                <th data-sort-ignore="true" class="text-right">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(prod, index) in productosFiltradosMasVendidos">
                                                <td>{{ prod.idProducto }}</td>
                                                <td>{{ prod.codigo }}</td>
                                                <td>{{ prod.fullDescripcion }} <span v-if="prod.shortUnidad == 'PZA'" class="badge badge-info "> {{ prod.existenciaEstimada }} </span></td>
                                                <td>{{ formatNumber(prod.vendidos) }}</td>                                                
                                                <td class="text-right">
                                                    <!-- 																<button @click.prevent="prepararProductoDesdeGrid(prod.codigo);" class="btn btn-outline btn-primary dim btn-xs" type="button"><i class="fa fa-pencil"></i></button> -->
                                                    <button @click.prevent="addRemoveFromFavoritos(prod.idProducto, prod.favorito)" class="btn btn-white btn-xs" :class="prod.favorito == 'SI' ? 'text-danger' : ''"
                                                                    data-toggle="tooltip" data-placement="top" :title="prod.favorito == 'SI' ? 'Quitar de Mis Favoritos' : 'Agregar a Mis Favoritos'"
                                                                     ><i class="fa " :class="prod.favorito == 'SI' ? 'fa-heart' : 'fa-heart-o'"></i></button>                                                        
                                                    <button @click.prevent="prepararProductoDesdeGrid(prod.codigo);"
                                                        class="btn btn-outline btn-primary btn-xs" type="button">
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



                            <!-- <hr> -->
                        </div> <!-- FIN MAS VENDIDOS-->



                        <div v-show="seleccionarFavoritos" id="tableroSeleccionarFavoritos" class="ibox m-l-sm m-r-l" >
                            <hr>
                        
                            <!-- <buton class="btn btn-primary btn-outline">el boton&nbsp;&nbsp;&nbsp;&nbsp; <span class="label label-success pull-right">16</span></buton> -->
                            <h2><button @click.prevent="seleccionarFavoritos = false" class="btn btn-danger btn-xs"><i class="fa fa-angle-up"></i></button> Favoritos </h2>

                            <div v-show="productosFiltradosFavoritos.length > 0" class="row">                               
                                <div class="col-lg-6">
                                    <div class="input-group m-b"><span class="input-group-addon"><i class="fa fa-search"></i></span> <input type="text" v-model="filtroFavoritos"  class="form-control"></div>
                                </div>
                            </div>
                            <div class="row">                               

                                <div v-show="productosFiltradosFavoritos.length <= 0" class="col-lg-12">
                                    <h3>No tienes registrados productos favoritos  <i class="fa fa-frown-o"></i></h3>
                                </div>
                                <div v-show="productosFiltradosFavoritos.length > 0" class="col-lg-12">
                                    <!-- <button @click.prevent="saveCookie" class="btn btn-primary">Save Cookie</button>
                                    <button @click.prevent="getCookie" class="btn btn-primary">Get Cookie</button> -->
                                    <table id="tblProductosFiltradosFavoritos"
                                        class="table table-stripped table-bordered toggle-arrow-tiny" data-page-size="10">
                                        <thead>
                                            <tr>
                                                <th data-sort-ignore="true">ID</th>
                                                <th data-sort-ignore="true">C&oacute;digo</th>
                                                <th data-sort-ignore="true" data-hide="phone">Descripi&oacute;n</th>
                                                <th data-sort-ignore="true" data-hide="phone">Unidad</th>                                                
                                                <th data-sort-ignore="true" class="text-right">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(prod, index) in productosFiltradosFavoritos">
                                                <td>{{ prod.idProducto }}</td>
                                                <td>{{ prod.idAplicacion }} {{ prod.codigo }}</td>
                                                <td>{{ prod.fullDescripcion }} <span v-if="prod.shortUnidad == 'PZA'" class="badge badge-info "> {{ prod.existenciaEstimada }} </span></td>
                                                <td>{{ prod.shortUnidad }}</td>                                                
                                                <td class="text-right">
                                                    <!-- 																<button @click.prevent="prepararProductoDesdeGrid(prod.codigo);" class="btn btn-outline btn-primary dim btn-xs" type="button"><i class="fa fa-pencil"></i></button> -->
                                                    <button @click.prevent="addRemoveFromFavoritos(prod.idProducto, prod.favorito)" class="btn btn-white btn-xs" :class="prod.favorito == 'SI' ? 'text-danger' : ''"
                                                                    data-toggle="tooltip" data-placement="top" :title="prod.favorito == 'SI' ? 'Quitar de Mis Favoritos' : 'Agregar a Mis Favoritos'"
                                                                     ><i class="fa " :class="prod.favorito == 'SI' ? 'fa-heart' : 'fa-heart-o'"></i></button>                                                        
                                                    <button @click.prevent="prepararProductoDesdeGrid(prod.codigo);"
                                                        class="btn btn-outline btn-primary btn-xs " type="button">
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



                            <!-- <hr> -->
                        </div> <!-- FIN FAVORITOS-->
                    </div>
                    <!--FIN  Nuevo selector de productos -->



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
				<div class="ibox-content" >


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
											
                                            <h3 class="text-navy">                                                
                                                {{ item.idProducto }} - {{ item.codigo }}
                                            </h3>
                                            <button @click.prevent="addRemoveFromFavoritos(item.idProducto, item.favorito)" class="btn btn-white btn-xs" :class="item.favorito == 'SI' ? 'text-danger' : ''" 
                                                                    data-toggle="tooltip" data-placement="top" :title="item.favorito == 'SI' ? 'Quitar de Mis Favoritos' : 'Agregar a Mis Favoritos'"
                                                                     ><i class="fa " :class="item.favorito == 'SI' ? 'fa-heart' : 'fa-heart-o'"></i></button>                                                        

                                            <!-- <br><br>
                                            <i class="fa fa-heart text-danger icon-10 pointer"></i>
                                            <i class="fa fa-heart text-danger icon-20 pointer"></i>
                                            <i class="fa fa-heart text-danger icon-30 pointer"></i>
                                            <i class="fa fa-heart text-danger icon-40 pointer"></i>
                                            <i class="fa fa-heart text-danger icon-50 pointer"></i>
                                            <i class="fa fa-heart text-danger icon-60 pointer"></i> -->

                                            
										</td>

										<td>
											{{ item.fullDescripcion }}
											
											&nbsp;&nbsp;&nbsp;
											<span v-show="item.curva != ''"> Curva: {{ item.curva }}</span>
											
											&nbsp;&nbsp;&nbsp;
											
											<div v-show="item.idTipoProducto == 1 && (item.idAplicacion == 3 || item.idAplicacion == 9 || item.idAplicacion == 30) && item.idRollo > 1">
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
													<br>
														<span v-show="(item.molLongitudinal == 'L' && item.desarrolloT >= 100) || (item.molLongitudinal == 'A' && item.cantUnidad >= 1.00 && item.cantUnidad < 2.00) " class="badge badge-info"> +50% Corte/Dobles </span>
														<span v-show="(item.molLongitudinal == 'A' && item.cantUnidad >= 2.00) " class="badge badge-info"> +100% Corte/Dobles </span>
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

<!-- 											Productos sugeridos Stock -->

											<div v-if="item.sugerirStock.length > 0 "  class="alert alert-info" style="margin-top: 2px; margin-bottom: 2px">
												<strong>Stock sugerido</strong><br>
												<div v-for="ss in item.sugerirStock">
													<span class="badge badge-warning">
														{{ ss.idProducto }} </span> <strong> {{ ss.codigo }}</strong> - {{ ss.descauto }} <i>({{ ss.disponible }} Pzas Disponibles)</i>
												</div>
												
												
											</div>
											
<!-- 											Fin Productos sugeridos stock -->

<!-- 											Inventario Sucursal -->
											<div v-if="item.inventarioSucursal.length > 0 " class="row">
												<br>
                                                <div class="col-lg-12">
                                                    <table class="table table-bordered  margin bottom">
                                                        <thead>
                                                            <tr>                                                                
                                                                <th>Sucursal</th>
                                                                <th class="text-right">Existencia</th>
                                                                <th class="text-right">Disponible</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr v-for="invsuc in item.inventarioSucursal.filter(isu => isu.sucursal != 'NOASIGNADOS')">                                                                
                                                                <td> {{ invsuc.sucursal }}
                                                                    </td>
                                                                <td class="text-right">{{ invsuc.existencia }}</td>
                                                                <td class="text-right">{{ invsuc.disponible }}</td>
<!--                                                                 	<td class="text-center"><span class="label label-info">{{ invsuc.existencia }}</span></td> -->
<!--                                                                 	<td class="text-center"><span class="label label-primary">{{ invsuc.disponible }}</span></td> -->
        
                                                            </tr>
                                                        
                                                        </tbody>
                                                    </table>
                                                </div>
												<div class="col-lg-12">
													<div v-for="invsuc in item.inventarioSucursal.filter(isu => isu.sucursal == 'NOASIGNADOS')">
														<div class="alert alert-warning" style="margin-top: 2px; margin-bottom: 2px">                                                                
															Considere que <strong>{{ invsuc.existencia }}</strong> Productos no han sido asignados a alguna Sucursal a&uacute;n</span>
														</div>
														<div class="clearfix"></div>		
													</div>
												</div>
                                                
                                        	</div>


<!-- 											Fin Inventario Sucursal -->


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

											<button v-if="1==2" @click.prevent="updateIndividualToCurrentPrices(index)"
												class="btn btn-warning btn-xs" type="button">
												<i class="fa fa-refresh"></i>
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
											<option v-show="maxTipoPrecioGalvamex > 3 " value="4">Rango 4</option>
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
											<option v-show="maxTipoPrecioGalvamexAcryOpa > 3 " value="4">Rango 4</option>
										</select>
									</div>
								</div>
							</div>
						</div>
                        <!-- Fin Select para Rango de precios AcryOpa -->
                        
                        <!-- Select para Rango de precios MULTIPANEL C v-show="idClienteSeleccionado == 137" -->
                        <div class="row" >
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
											<option v-show="maxTipoPrecioGalvamexMultipanel > 3 " value="4">Rango 4</option>
										</select>
									</div>
								</div>
							</div>
						</div>
                        <!-- Fin Select para Rango de precios MULTIPANEL C -->
                        
                        <!-- Select para Rango de precios Galvateja D v-show="idClienteSeleccionado == 137"--> 
                        <div class="row" >
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
											<option v-show="maxTipoPrecioGalvamexGalvateja > 3 " value="4">Rango 4</option>
										</select>
									</div>
								</div>
							</div>
						</div>
                        <!-- Fin Select para Rango de precios Galvateja D -->
                        
                        <!-- Select para Rango de precios Rollo Kilo R v-show="idClienteSeleccionado == 137"-->
                        <div class="row" >
							<div  v-show="maxTipoPrecioGalvamexRolloKilo > 1" class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
								<div class="row">
									<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
										<h3>Rango Precios Rollo KG</h3>
									</div>
									<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
										<select v-model="tipoPrecioGalvamexRolloKilo" class="form-control">
											<option value="1">Rango 1</option>
											<option v-show="maxTipoPrecioGalvamexRolloKilo > 1  " value="2">Rango 2</option>
											<option v-show="maxTipoPrecioGalvamexRolloKilo > 2 " value="3">Rango 3</option>
											<option v-show="maxTipoPrecioGalvamexRolloKilo > 3 " value="4">Rango 4</option>
										</select>
									</div>
								</div>
							</div>
						</div>
						<!-- Fin Select para Rango de precios Rollo Kilo R -->
						<div v-if="idCotizacion > 0" class="row">
							<div class="col-md-3"></div>
							<div class="col-md-6">
								<div class="alert alert-danger text-center">
									<h4>
										Usted esta editando la Cotizaci&oacute;n con folio: <span class="alert-link blink_me">{{ idCotizacion}}</span>
									</h4>
								</div>
							</div>
							<div class="col-md-3"></div>
						</div>


						<br>
						<div class="row" >
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
											
<!-- 											<tr v-show="listadoPedido.length > 0 || totalOtrosCargos > 0"> -->
											<tr>
												<td>
    												<button class="btn btn-primary btn-xs" @click.prevent="agregarOtrosGastos"><i class="fa fa-plus"></i></button>
    												&nbsp;<strong>OTROS SERVICIOS:</strong>
												</td>
												<td><h3>${{ formatNumber(totalOtrosCargos) }}</h3></td>
											</tr>
											
											
											<tr v-show="promobuenfin">
												<td>
    												<strong>TIPO DE PAGO:</strong>
												</td>
												<td>
													<select v-model="buenfintipopago" class="form-control">
        											<option value="0">--Seleccione Tipo--</option>
        											<option value="99">CONTADO (BUEN FIN PROMOCI&Oacute;N)</option>
        											<option value="22">OTRO</option>
        										</select>
												</td>
											</tr>
											
											<tr v-show="descuentoPedido > 0">												
											<td><img v-if="promobuenfin" src="<?php echo URL_BASE;?>\img\buenfin.png" style="width: 64px;"><strong>DESCUENTO {{ porDescuento }} %:</strong></td>
												<td><h3>${{ formatNumber(descuentoPedido) }}</h3></td>
											</tr>
											<tr>
												<td><strong>TOTAL:</strong></td>
												<td><h1 class="font-bold">${{ formatNumber(totalPedido) }}</h1></td>
											</tr>
											<tr v-if="idCotizacion > 0">
												<td colspan="2">
													<button class="btn btn-warning " @click.prevent="updateAllToCurrentPrices">Recalcular Total con Precios Actuales</button>
												</td>
											</tr>
										</tbody>
									</table>
								</div>

						<div class="row">
							<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"></div>
							<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
								<div class="form-group has-success" >
									<label class="control-label" for="observacionPedido"> Observaci&oacute;n </label>
									<input type="text" v-model="observacionPedido" class="form-control"
											maxlength="200" /> <span class='help-block'> Si lo desea, capture alguna Observaci&oacute;n del Pedido
										</span>


								</div>
							</div>
						</div>
						<div>
							<div class="panel panel-default">
	                            <div class="panel-heading">
    							Recepci&oacute;n
                                </div>
                                <div class="panel-body">
                                	<div class="row">
    									<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
    										El Pedido
    									</div>
    									<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
    										<select v-model="selRecogeRecibe" class="form-control">
    											<option value="NOSEL">-- Seleccione --</option>
    											<option value="RECOGE">RECOGE EL CLIENTE</option>
    											<option value="ENTREGA">SE ENVIA AL CLIENTE</option>
    											<option value="OBRA">SE FABRICA EN OBRA</option>
    										</select>
    									</div>
    									
    									<div v-show="selRecogeRecibe == 'ENTREGA' || selRecogeRecibe == 'OBRA' " class="col-lg-4 col-md-4 col-sm-12 col-xs-12" >
    										    <div class="checkbox" >
    	                                            <input id="checkbox1" type="checkbox" v-model="chkUsarInformacionCliente">
    	                                            <label for="checkbox1">
    	                                                Utilizar datos registrados del Cliente.
    	                                            </label>
    	                                        </div>
    										</div>
    								</div>
									<div v-if="selRecogeRecibe == 'ENTREGA' && (msgCotizarManiobras || msgCotizarFlete)" class="row">
										<br>
										<div v-if="msgCotizarFlete"  class="col-lg-4">
											<div class="alert alert-danger">{{ msgCotizarFlete }}</div>
										</div>
										<div v-if="msgCotizarManiobras" class="col-lg-4">
											<div class="alert alert-danger">{{ msgCotizarManiobras }}</div>
										</div>
									</div>
									
    								<div v-show="selRecogeRecibe == 'OBRA'" >
    									<hr>
    									<div class="row">
        									<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
        										Tipo Obra
        									</div>
        									<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
        										
            										<select v-model="selTipoObra" class="form-control">
            											<option value="NINGUNO">-- Seleccione --</option>
            											<option value="PISO">EN PISO</option>
            											<option value="CUBIERTA">EN CUBIERTA</option>											
            										</select>
            										
            									
        									</div>											
											<div v-show="selTipoObra == 'CUBIERTA'" class="col-sm-6">
												<div class="row">
													<div class="col-sm-4">
														¿Galvamex proporcionar&aacute; la gr&uacute;a?
													</div>
													<div class="col-sm-2">
														<div  class="switch">
															
															<div class="onoffswitch" style="margin-top: 6px">
																<input type="checkbox" class="onoffswitch-checkbox"
																	id="chkSeUsaGrua" v-model="chkSeUsaGrua"> <label class="onoffswitch-label" for="chkSeUsaGrua"> 
																	<span
																	class="onoffswitch-inner"></span> <span class="onoffswitch-switch"></span>
																</label>
															</div>
															
														</div>
													</div>
												</div>												
											</div>
        								</div>
        							</div>
    								<div v-show="selRecogeRecibe == 'RECOGE'">
    									<hr>
    									<div class="row">
        									<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
        										Sucursal de Preferencia del Cliente
        									</div>
        									<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
        										<select v-model="selSucursalPreferencia" class="form-control">
        											<option value="-1">-- Seleccione --</option>
        											<option value="0">Por Confirmar</option>	
        											<?php
        											     foreach ($lstSucursales as $suc)
        											     {
        											         echo "<option value='".$suc["idSucursal"]."'>".$suc["nombre"]."</option>";
        											     }
        											    
        											?>
        										</select>
        									</div>
        									<div v-show="selRecogeRecibe == 'ENTREGA' || selRecogeRecibe == 'OBRA' " class="col-lg-4 col-md-4 col-sm-12 col-xs-12" >
        										    <div class="checkbox" >
        	                                            <input id="checkbox1" type="checkbox" v-model="chkUsarInformacionCliente">
        	                                            <label for="checkbox1">
        	                                                Utilizar la registrada en Cliente.
        	                                            </label>
        	                                        </div>
        										</div>
        								</div>
        								
    								</div>
    								<div >
    									<hr>
    									<div class="row" v-show="selRecogeRecibe == 'ENTREGA' || selRecogeRecibe == 'OBRA' ">
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
    									<div class="row" v-show="selRecogeRecibe == 'ENTREGA' || selRecogeRecibe == 'OBRA' ">
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
    									<div class="row" v-show="selRecogeRecibe == 'ENTREGA' || selRecogeRecibe == 'OBRA' ">
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
    										<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" v-show=" selRecogeRecibe == 'OBRA' || selRecogeRecibe == 'ENTREGA' || selRecogeRecibe == 'RECOGE' ">
    											<div class="form-group" v-bind:class="{'has-error': errFechaEntrega}">
    				                                <label class="control-label">Fecha Entrega</label>
    				                                <div v-show="!chkFechaEntregaPorDefinir" class="input-group date">
    				                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
    				                                    <input v-modal="fechaEntrega" id="dtFechaEntrega" type="text" class="form-control"  value="<?php echo date("d/m/Y");?>
    				                                    ">
    				                                </div>
													<div v-if="selRecogeRecibe == 'RECOGE'" >
														<div class="alert alert-danger">Aseg&uacute;rese de poner fecha y hora de entrega real en las Observaci&oacute;nes.</div>
														</div>
													
    				                                <div class="checkbox" v-show="selRecogeRecibe == 'ENTREGA' || selRecogeRecibe == 'OBRA' ">
            	                                            <input id="checkbox2" type="checkbox" v-model="chkFechaEntregaPorDefinir">
            	                                            <label for="checkbox2">
            	                                                Por definir
            	                                            </label>
            	                                        </div>
    				                                <span v-if='errFechaEntrega' class='help-block'>
    														<strong>{{ errFechaEntrega }} </strong>
    												</span>
    				                            </div>
    										</div>
    										<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" v-show="selRecogeRecibe == 'ENTREGA' || selRecogeRecibe == 'OBRA' ">
    											<div class="form-group" v-bind:class="{'has-error': errFechaAbierta}">
        											<label class="control-label">Fecha Abierta</label>
        											<select v-model="fechaAbierta" class="form-control">
        												<option value="NOSEL">- Seleccione -</option>
        												<option value="SI">SI</option>
        												<option value="NO">NO</option>
        											</select>
        											<span v-if='errFechaAbierta' class='help-block'>
        														<strong>{{ errFechaAbierta }} </strong>
        											</span>
        										</div>
    										</div>
    									</div>
    									<div class="row" v-show="selRecogeRecibe == 'ENTREGA' || selRecogeRecibe == 'OBRA' ">
    										<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
    											<label class="control-label">Pedido Express</label>
    											<select v-model="pedidoExpress" class="form-control">												
    												<option value="NO">NO</option>
    												<option value="SI">SI</option>
    											</select>
    										</div>
    										<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
    											<label class="control-label">Hora Entrega</label>
    											<select v-model="horaEntrega" class="form-control">
    												<option value="NOSEL">-</option>
    												<option value="MATUTINO">MATUTINO</option>
    												<option value="VESPERTINO">VESPERTINO</option>
    											</select>
    										</div>
    									</div>
    <!-- 									<div class="row"> -->
    <!-- 										<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"> -->
    											
    											
    <!-- 												<input type="text" v-model="horaEntrega"  id="txtHoraEntrega" -->
    <!-- 													       class="form-control" maxlength="45"/> -->
    <!-- 											<div class="input-group clockpicker" data-autoclose="true">												 -->
    <!-- 				                                <input id="txtHoraEntrega" type="text" class="form-control" v-model='horaEntrega' > -->
    <!-- 				                                <span class="input-group-addon"> -->
    <!-- 				                                    <span class="fa fa-clock-o"></span> -->
    <!-- 				                                </span> -->
    <!-- 				                            </div> -->
    <!-- 										</div> -->
    <!-- 										<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"> -->
    											
    <!-- 										</div> -->
    
    <!-- 									</div> -->
    
    								</div>
                                </div>
                              </div>
						</div>

						<div v-if="idCotizacion > 0" class="row">
							<div class="col-md-3"></div>
							<div class="col-md-6">
								<div class="alert alert-danger text-center">
									<h4>
										Usted esta editando la Cotizaci&oacute;n con folio: <span class="alert-link blink_me">{{ idCotizacion}}</span>
									</h4>
								</div>
							</div>
							<div class="col-md-3"></div>
						</div>

						
						
						<div class="row">
							<div class="col-md-6">								
								<button v-show="mostrarBotonGuardar && idCotizacion > 0" @click.prevent="showPantallaPasarAPedido"
											class="btn btn-primary btn-lg pull-left">
											<i class="fa fa-link"></i> 											
											<span v-if="idCotizacion > 0">Convertir Cotizaci&oacute;n en Pedido</span>
								</button>
							</div>
							<div class="col-md-6">
								<button v-show="mostrarBotonGuardar" @click.prevent="preLevantarPedido(true, false)"
											class="btn btn-primary btn-lg pull-right">
											<i class="fa fa-calculator"></i> 
											<span v-if="idCotizacion == 0">Guardar como Cotizaci&oacute;n</span>
											<span v-if="idCotizacion > 0">Actualizar Cotizaci&oacute;n</span>
								</button>
							</div>
						</div>
						<hr>
						<div v-if="idCotizacion == 0" class="row">
							<div class="col-md-12">
								<!-- @click.prevent="preLevantarPedido(false, false)" -->
								<button v-show="mostrarBotonGuardar" @click.prevent="levantarOConvertirAPedido('LEVANTAR_PEDIDO')"
									class="btn btn-primary btn-lg pull-right">
									<i class="fa fa-shopping-cart"></i> Levantar Pedido
								</button>
							</div>
						</div>


						
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
				<div id="zsecCliente">

				</div>

			</div>

		</div>
	</div>
</div>



<div id="divdebug">

	{{debug}}
</div>

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
    
    // echo "<pre>{{ \$data.otrosCargos }}</pre>";
  echo "<pre>{{ \$data.productos }}</pre>";
  echo "<pre>{{ \$data.productosNuevoFiltro }}</pre>";
//  echo "<pre>{{ \$data.productosNuevoFiltroComercializados }}</pre>";
//  echo "<pre>{{ \$data.productosNuevoFiltroComercializadosAgruped }}</pre>";
//  echo "<pre>{{ \$data.productosNuevoFiltroMasVendidos }}</pre>";
// echo "<pre>{{ \$data.productosNuevoFiltroFavoritos }}</pre>";
 

// echo "<pre>{{ \$data.lstAcanalados }}</pre>";
// echo "<pre>{{ \$data.lstMateriales }}</pre>";
//  echo "<pre>{{ \$data.lstCalibres }}</pre>";
//  echo "<pre>{{ \$data.lstEspesores }}</pre>";
//  echo "<pre>{{ \$data.lstProveedores }}</pre>";
//  echo "<pre>{{ \$data.lstMedidaEspecialComer }}</pre>";
 

  	// echo "<pre>{{ \$data.listadoPedido }}</pre>";
//  	echo "<pre>{{ \$data.listadoPedidoShort }}</pre>";
//  	echo "<pre>{{ \$data.rollosExistencias }}</pre>";
    // echo "<pre>{{ \$data.clientes }}</pre>";
// 	echo "<pre>{{ \$data.piezasExistencias }}</pre>";
	
	 echo "<pre>{{ \$data.productos }}</pre>";
}


?>




