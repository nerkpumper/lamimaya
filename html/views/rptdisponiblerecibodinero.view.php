<?php
$titlePage = "Reportes";
$breadCum = "Saldo de dinero disponible";
$_lugar = LUGAR_REPORTES;
$_useDataTable = true;
?>
<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<h5>Listado saldo disponible de clientes</h5>				
			</div>
			<div class="ibox-content">
					
	
				<div style="overflow-x:auto;">
					<?php			
					echo $strTablaListado;?>
				</div>
			</div>
		</div>
	</div>
</div>
