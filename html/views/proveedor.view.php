<?php
$titlePage = "Proveedores";
$breadCum = "Cat&aacute;logos/Proveedor";
$_lugar = LUGAR_CATALOGOS_PROVEEDOR;
$_useDataTable = true;
?>

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<h5>Listado</h5>				
			</div>
			<div class="ibox-content">
				<a href="<?php echo URL_BASE;?>proveedoredit" class="btn btn-primary">Nuevo</a>
					
				<?php			
				
				echo $strTablaListado;?>
				
			</div>
		</div>
	</div>
</div>

