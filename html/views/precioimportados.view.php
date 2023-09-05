<?php
$titlePage = "Precios";
$breadCum = "Precios/Importados";
//$buttonAction = "";
$_lugar = LUGAR_PRECIOS_IMPORTADOS;

$_addStyle = "<style>
                 .tablaoscuro{
	              background-color: #F5F5F6;
	              border-bottom-width: 1px;
				  text-align:  center;
				  font-weight: bold;
                 }
			
			     
		      </style>";



function drawTablaPrecios(){
	$precios = "";
	$desarrollos = 6;
	
	for($i = 0 ; $i < $desarrollos ; $i++)
	{
		$precios .= "<tr class='tablaoscuro'>";
		$precios .= "  <td>Desarrollo</td>";
	 	$precios .= "  <td>1</td><td>2</td><td>3</td><td>4</td><td>5</td><td>6</td><td>7</td><td>8</td><td>9</td><td>10</td>";
 		$precios .= "</tr>";
		$precios .= "<tr style='text-align: center;'>";
		$precios .= "  <td><h3>{{ precios[".$i."].desarrollo }}</h3></td>";
		$precios .= "  <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>";
		$precios .= "</tr>";
		
		$precios .= "<tr>";
// 		$precios .= "  <td>CAL 26 -- {{ precios[".$i."].calibre26[0].id }}</td>";		
		$precios .= "  <td>CAL 26</td>";
		for ($j=1 ; $j <= 10 ; $j++)
		{
			$precios .= "  <td>";
			$precios .= "    <input type='text' class='form-control text-right' v-model='precios[".$i."].calibre26[0].precio".$j."' oninput=\"this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');\" maxlength='8'>";			
			$precios .= "  </td>";
		}				
		$precios .= "</tr>";
		
		$precios .= "<tr>";
// 		$precios .= "  <td>CAL 24 -- {{ precios[".$i."].calibre24[0].id }}</td>";
		$precios .= "  <td>CAL 24</td>";
		for ($j=1 ; $j <= 10 ; $j++)
		{
			$precios .= "  <td>";
			$precios .= "    <input type='text' class='form-control text-right' v-model='precios[".$i."].calibre24[0].precio".$j."' oninput=\"this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');\" maxlength='8'>";
			$precios .= "  </td>";
		}
		$precios .= "</tr>";
		

		
	}
	
	
	
	echo $precios;
}


?>


<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<h5>Lista de Precios por Dobleces Importados</h5>				
			</div>
			<div class="ibox-content">
				<table class="table table-bordered">					
					<thead>
						<tr>
							<th></th>
							<th colspan="10" style="text-align: center;">DOBLECES</th>
						</tr>
						<tr style="text-align: center;">

					</thead>
					<tbody>
					
						<?php drawTablaPrecios();?>
						

					</tbody>
				</table>
				
				<div align="right"><button class="btn btn-primary" @click.prevent="guardarPrecios">Guardar Precios</button></div>

<!-- 				<button class="btn btn-primary" @click.prevent="probarArreglo">Probar Arreglo</button> -->
<!-- 				<button class="btn btn-success" @click.prevent="modificarPrecio">Modifica Precio</button> -->

				
						
			</div>
		</div>
	</div>
</div>

<!-- <pre> -->
<!-- 	{{ $data}} -->
<!-- </pre> -->