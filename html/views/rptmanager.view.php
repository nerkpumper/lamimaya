<?php
$titlePage = "Reportes";
$breadCum = "Reportes";
$_lugar = LUGAR_REPORTES;
// $_useDataTable = true;
?>



<div class="row">

	<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
		<div class="ibox ">
			<div class="ibox-content">
			
			
				<?php 
				
// 				ReportManager::fillLista();
				
// 				$lstPadres = ReportManager::getParents();
				
// 				foreach ($lstPadres as $parent)
// 				{
// // 					#f9f9f9

// 					if (Routes::moduleAllow($parent["id"]))
// 					{
// // 						$lstChildren = ReportManager::getChildren($parent["id"]);
// // 						<span class=\"badge badge-primary pull-right\"> 0</span>
							
// 						echo "<div class=\"dd-handle \"
// 						       style=\"padding: 12px 10px !important; margin: 2px 0 !important; background-color: #ffffff !important;\">						     
// 		                     <span class=\"text-success\" style=\"margin-right: 10px; font-size: 18px\">
// 		                     <i  class=\"fa ".$parent["icon"]."\"></i></span> ".$parent["nombre"]."
// 						  </div>";
// 					}										
	
// 				}
				
				
									
				?>
				<div v-for="(padre, index) in categorias">
					<div @click.prevent="seleccionaPadre(index);" class="dd-handle "
						style="padding: 12px 10px !important; margin: 2px 0 !important; background-color: #ffffff !important;">
						<span class="text-success"
							style="margin-right: 10px; font-size: 18px"> <i
							:class="padre.icon"></i></span> {{ padre.nombre }}
					</div>
				</div>
				

			</div>
		</div>
	</div>
	<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
		<div class="ibox ">
			<div class="ibox-content">			
				<h3 class="text-success"><i style="font-size: 24px" :class="iconChildren"></i>&nbsp;&nbsp;{{ nombreParent }}</h3>
				<hr>
				<div v-for="(child, index) in children">
					<div @click.prevent="seleccionaHijo(index);" class="dd-handle "
						style="padding: 12px 10px !important; margin: 2px 0 !important; background-color: #ffffff !important;">
						<span class="text-success"
							style="margin-right: 10px; font-size: 18px"> <i
							:class="child.icon"></i></span> {{ child.nombre }}
					</div>
				</div>
			</div>
		</div>
		
	</div>
</div>

<!-- <pre>{{ $data }}</pre> -->