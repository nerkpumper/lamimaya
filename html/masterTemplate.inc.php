<!DOCTYPE html>
<html lang="en">
<head>
<!-- start: Meta -->
<meta charset="utf-8">
<title>Galvamex</title>
<meta name="description" content="">
<meta name="author" content="">
<meta name="keyword" content="">
<!-- end: Meta -->

<link rel="shortcut icon" type="image/x-icon" href="<?php echo URL_BASE;?>img/galvaicon.ico" />

<!-- start: Mobile Specific -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- end: Mobile Specific -->

<!-- <link href="assets/css/bootstrap.min.css" rel="stylesheet"> -->

<link href="<?php echo URL_BASE;?>assets/inspinia/css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo URL_BASE;?>assets/inspinia/font-awesome/css/font-awesome.css" rel="stylesheet">

<!-- Toastr style -->
<!--  <link href="assets/inspinia/css/plugins/toastr/toastr.min.css" rel="stylesheet">  -->

<!-- Gritter -->
<!-- <link href="assets/inspinia/js/plugins/gritter/jquery.gritter.css" rel="stylesheet"> -->

<!-- Datatables -->
<link href="<?php echo URL_BASE;?>assets/inspinia/css/plugins/dataTables/datatables.min.css" rel="stylesheet">

<link href="<?php echo URL_BASE;?>assets/inspinia/css/animate.css" rel="stylesheet">
<link href="<?php echo URL_BASE;?>assets/inspinia/css/style.css" rel="stylesheet">

<link href='<?php echo URL_BASE;?>assets/inspinia/css/plugins/sweetalert/sweetalert.css' rel='stylesheet'>




<?php

 	if(isset ($_addHead))
 	{
		echo $_addHead;
 	}
                
?>

<?php 
 if(isset ($_addStyle))
 {
	echo $_addStyle;
 }
                
?>

<?php

 	if(!isset ($_showPageHeading))
 	{
		$_showPageHeading = true;
 	}
                
?>

</head>

<body  >

<!-- start: Wrapper -->
<div id="wrapper" >

<!-- start: Main Menu -->
<?php include "mainMenu.inc.php";?>
		<!-- end: Main Menu -->		
	
		<!-- start: Header -->
		<?php include "header.inc.php";?>
		<!-- end: Header -->
	<div id="app" ><!-- start: Header -->
		<!-- start: wrapper up border-->
			<?php 
				if($_showPageHeading):
			
			?>
			<div class="row wrapper border-bottom white-bg page-heading">
		
		
	            <div class="col-sm-4">
	                <h2><?php 
	                       if(isset ($titlePage))
	                       {
	                       		echo $titlePage;
	                       }
	                
	                ?></h2>                      
	                    
	                    <?php 
	                         if (isset($breadCum))
	                         {
	                         	echo "<ol class='breadcrumb'>";
	                         	echo "<li>";
	                         	echo "<a href='" . URL_BASE . "index'>Inicio</a>";
	                         	echo "</li>";
	                         	
	                         	$elementos = explode("/", $breadCum);
	                         	
	                         	$noElementos = count($elementos);
	                         	$i = 1;
	                         	foreach ($elementos as $ele)
	                         	{
	                         		echo "<li" . ($i == $noElementos ? " class='active'><strong>" . $ele . "</strong></li>" : ">" . $ele . "</li>");
	                         		
	                         		$i++;
	                         	}
	                         	
	                         	echo "</ol>";
	                         }
	                    
	                    ?>
	<!--                     <li class="active"> -->
	<!--                         <strong>Dashboard</strong> -->
	<!--                     </li> -->
	                
	            </div>
            
            
            
            
	            <?php 
	               
	            	if (isset($buttonAction))
	            	{
	            		$elementos = explode("/", $buttonAction);
	            		$titleButtonAction = "";
	            		$actionButtonAction = "";
	            		
	            		if (isset($elementos[0]))
	            		{
	            			$titleButtonAction = $elementos[0];
	            		}
	            		
	            		if (isset($elementos[1]))
	            		{
	            			$actionButtonAction = $elementos[1];
	            		}
	            		
	            		echo "<div class='col-sm-8'>";
	            		echo "  <div class='title-action'>";
	            		echo "    <button class='btn btn-primary' v-on:click.prevent='" . $actionButtonAction . "'>" . $titleButtonAction . "</button>";
	            		echo "  </div>";
	            		echo "</div>";
	            	}
	            	
	            	if (isset($buttonCustom))
	            	{
	            	    echo "<div class='col-sm-8'>";
	            	    echo "  <div class='title-action'>";
	            	    echo $buttonCustom;
	            	    echo "  </div>";
	            	    echo "</div>";
	            	}
	            
	            ?>
            
            
            
        	</div>
		<?php endif;?>        	
        <!-- end: wrapper up border-->
		
		<!-- start: page-wrapper -->
		<div class="wrapper wrapper-content animated fadeInRight">
			<!-- start: page-wrapper -> row -->
			<div class="row">
				<!-- start: page-wrapper -> row -> col -->
				<div class="col-lg-12"  >					
					
					<!-- -------------------------------------------------------------------------------------------------------------------------------- -->
					<!-- -----------------------------------------------Contenido principal de la seccion------------------------------------------------ -->
					<!-- -------------------------------------------------------------------------------------------------------------------------------- -->
					
<!-- 					<div class="middle-box text-center animated fadeInRightBig"> -->
<!-- 	                    <h3 class="font-bold">This is page content</h3> -->
<!-- 	                    <div class="error-desc"> -->
<!-- 	                        You can create here any grid layout you want. And any variation layout you imagine:) Check out -->
<!-- 	                        main dashboard and other site. It use many different layout. -->
<!-- 	                        <br/><a href="#" class="btn btn-primary m-t">Dashboard</a> -->
<!-- 	                    </div> -->
<!-- 	                </div>			 -->
					<?php 
					
					
					
					
					echo $view_content;?>
					
					
                    
						
					<!-- -------------------------------------------------------------------------------------------------------------------------------- -->
					<!-- -----------------------------------------------F I N Contenido principal de la seccion------------------------------------------ -->
					<!-- -------------------------------------------------------------------------------------------------------------------------------- -->
						

				</div>
				<!-- end: page-wrapper -> row -> col -->				
			</div>
			<!-- end: page-wrapper -> row -->				
		</div>
		<!-- end: page-wrapper -->

		<!-- start: footer -->
		<div class="footer">
			<?php include "footer.inc.php"?>
		</div>		
		<!-- end: footer -->					
		
	</div>
	<!-- end: Wrapper -->				
	
</div><!-- end: app -->		
	
	<!-- ----------------------------------------------------------------------------------------- -->
	<!-- --------------------------Seccion de alertas y mensajes modales-------------------------- -->
	<!-- ----------------------------------------------------------------------------------------- -->

	<div class="modal" tabindex="-1" role="dialog" id="mdlEsperar">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
<!-- 					<button type="button" class="close" data-dismiss="modal" -->
<!-- 						aria-label="Close"> -->
<!-- 						<span aria-hidden="true">&times;</span> -->
<!-- 					</button> -->
					<h4 id="mdlWaitTitle"  class="modal-title">Cargando informaci&oacuten</h4>
				</div>
				<div class="modal-body">
					<p id="mdlWaitSubTitle">Por favor espere</p>
					<div class="progress">
						<div class="progress-bar progress-bar-striped active"
							role="progressbar" aria-valuenow="100" aria-valuemin="0"
							aria-valuemax="100" style="width: 100%">
							<span class="sr-only">100% Complete (danger)</span>
						</div>
					</div>
				</div>
				<div class="modal-footer"></div>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->

	<button id="_alertShow" type="button" class="btn btn-primary" data-toggle="modal" data-target="#_modalAlertShow" style="display: none;"></button>                                
                                        
    <div class="modal inmodal fade" data-backdrop="static" data-keyboard="false" id="_modalAlertShow" tabindex="-1" tabindex="-1" role="dialog"  aria-hidden="true">
    	<div class="modal-dialog modal-lg">
        	<div class="modal-content animated bounceInRight">
            	<div class="modal-header">
<!--                 	<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button> -->
                    <h4 class="modal-title" id="_alertTitle">Modal title</h4>
                    <small class="font-bold" id="_alertSubtitle"></small>
                </div>
                <div class="modal-body" id="_alertBody"></div>
                <div class="modal-footer">
                	<button type="button" class="btn btn-white" data-dismiss="modal" id="_alertClose">Close</button>                                    
                </div>
            </div>
        </div>
    </div>
	
			
	<!-- ----------------------------------------------------------------------------------------- -->
	<!-- ----------------------Fin de seccion de alertas y mensajes modales----------------------- -->		
	<!-- ----------------------------------------------------------------------------------------- -->
	

	<!-- Mainly scripts -->
	<script src="<?php echo URL_BASE;?>assets/inspinia/js/jquery-2.1.1.js"></script>
	<script src="<?php echo URL_BASE;?>assets/inspinia/js/bootstrap.min.js"></script>
	<script	src="<?php echo URL_BASE;?>assets/inspinia/js/plugins/metisMenu/jquery.metisMenu.js"></script>
	<script	src="<?php echo URL_BASE;?>assets/inspinia/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

	<!-- Flot -->
<!-- 	<script src="assets/inspinia/js/plugins/flot/jquery.flot.js"></script> -->
<!-- 	<script -->
<!-- 		src="assets/inspinia/js/plugins/flot/jquery.flot.tooltip.min.js"></script> -->
<!-- 	<script src="assets/inspinia/js/plugins/flot/jquery.flot.spline.js"></script> -->
<!-- 	<script src="assets/inspinia/js/plugins/flot/jquery.flot.resize.js"></script> -->
<!-- 	<script src="assets/inspinia/js/plugins/flot/jquery.flot.pie.js"></script> -->

	<!-- Peity -->
<!-- 	<script src="assets/inspinia/js/plugins/peity/jquery.peity.min.js"></script> -->
<!-- 	<script src="assets/inspinia/js/demo/peity-demo.js"></script> -->
	
	<!-- Custom and plugin javascript -->
	<script src="<?php echo URL_BASE;?>assets/inspinia/js/inspinia.js"></script>
	<script src="<?php echo URL_BASE;?>assets/inspinia/js/plugins/pace/pace.min.js"></script>
	
	<?php 
	
		if(isset ($_useDataTable))
		{
			if ($_useDataTable)
			{   
				//<!-- Datatables -->
				echo "<script src='" . URL_BASE . "assets/inspinia/js/plugins/dataTables/datatables.min.js'></script>";
			}
			
		}
	
	?>
	
	
	

	<!-- jQuery UI -->
	<script src="<?php echo URL_BASE;?>assets/inspinia/js/plugins/jquery-ui/jquery-ui.min.js"></script>
	
	
	
	

	<!-- GITTER -->
<!-- 	<script -->
<!-- 		src="assets/inspinia/js/plugins/gritter/jquery.gritter.min.js"></script> -->

	<!-- Sparkline -->
<!-- 	<script -->
<!-- 		src="assets/inspinia/js/plugins/sparkline/jquery.sparkline.min.js"></script> -->

	<!-- Sparkline demo data  -->
<!-- 	<script src="assets/inspinia/js/demo/sparkline-demo.js"></script> -->

	<!-- ChartJS-->
<!-- 	<script src="assets/inspinia/js/plugins/chartJs/Chart.min.js"></script> -->

	<!-- Toastr -->
 	<script src="<?php echo URL_BASE;?>assets/inspinia/js/plugins/toastr/toastr.min.js"></script> 


<!-- Vue Min -->
	<script src="<?php echo URL_BASE;?>js/lib/vue.min.js"></script>
<!-- 	<script src=" -->
	
	
	<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
	<script src="<?php echo URL_BASE;?>assets/inspinia/js/plugins/sweetalert/sweetalert.min.js"></script>
	
	<?php

	 	if(isset ($_addScript))
	 	{
			echo $_addScript;
	 	}
	                
	?>

</body>
</html>
	