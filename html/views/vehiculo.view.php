<?php
$titlePage = "Vehiculos";
$breadCum = "Rutas/Vehiculos";
$_lugar = LUGAR_RUTAS_VEHICULOS;
$_useDataTable = true;
?>

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<h5>Listado</h5>				
			</div>
			<div class="ibox-content">
			
				<div style="overflow-x:auto;">
					<a href="<?php echo URL_BASE;?>vehiculoedit" class="btn btn-primary">Nuevo</a>
						
					<?php			
					
					echo $strTablaListado;?>
				</div>
				
			</div>
		</div>
	</div>
</div>

