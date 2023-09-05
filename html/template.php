<?php
require_once "masterIncludeLogin.inc.php";
$_lugar="inicio";
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<!-- start: Meta -->
	<meta charset="utf-8">
	<title>Dashboard Campus Virtual</title>
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="keyword" content="">
	<!-- end: Meta -->
	
	<!-- start: Mobile Specific -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- end: Mobile Specific -->
	
	<!-- <link href="assets/css/bootstrap.min.css" rel="stylesheet"> -->
	
 	<link href="assets/inspinia/css/bootstrap.min.css" rel="stylesheet"> 
    <link href="assets/inspinia/font-awesome/css/font-awesome.css" rel="stylesheet">

    <!-- Toastr style -->
    <link href="assets/inspinia/css/plugins/toastr/toastr.min.css" rel="stylesheet">

    <!-- Gritter -->
    <link href="assets/inspinia/js/plugins/gritter/jquery.gritter.css" rel="stylesheet">
    
    <!-- Datatables -->
    <link href="assets/inspinia/css/plugins/dataTables/datatables.min.css" rel="stylesheet">

    <link href="assets/inspinia/css/animate.css" rel="stylesheet">
    <link href="assets/inspinia/css/style.css" rel="stylesheet">	

</head>

<body>

	<!-- start: Wrapper -->
	<div id="wrapper">
	
		<!-- start: Main Menu -->
		<?php include "mainMenu.inc.php";?>			
		<!-- end: Main Menu -->		
	
		<!-- start: Header -->
		<?php include "header.inc.php";?>
		<!-- end: Header -->
		
		<!-- start: wrapper up border-->
		<div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-sm-4">
                <h2>Campus Virtual</h2>
                <ol class="breadcrumb">
                    <li>
                        <a href="index.html">Dash Campus Virtual</a>
                    </li>
                    <li class="active">
                        <strong>Dashboard</strong>
                    </li>
                </ol>
            </div>
            <div class="col-sm-8">
                <div class="title-action">
                    <a href="" class="btn btn-primary">This is action area</a>
                </div>
            </div>
            
        </div>
        <!-- end: wrapper up border-->
		
		<!-- start: page-wrapper -->
		<div class="wrapper wrapper-content animated fadeInRight">
			<!-- start: page-wrapper -> row -->
			<div class="row">
				<!-- start: page-wrapper -> row -> col -->
				<div class="col-lg-12">					
						
					<!-- -------------------------------------------------------------------------------------------------------------------------------- -->
					<!-- -----------------------------------------------Contenido principal de la seccion------------------------------------------------ -->
					<!-- -------------------------------------------------------------------------------------------------------------------------------- -->
					
					<div class="middle-box text-center animated fadeInRightBig">
	                    <h3 class="font-bold">This is page content</h3>
	                    <div class="error-desc">
	                        You can create here any grid layout you want. And any variation layout you imagine:) Check out
	                        main dashboard and other site. It use many different layout.
	                        <br/><a href="#" class="btn btn-primary m-t">Dashboard</a>
	                    </div>
	                </div>			
						
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
	
		
	
	<!-- ----------------------------------------------------------------------------------------- -->
	<!-- --------------------------Seccion de alertas y mensajes modales-------------------------- -->
	<!-- ----------------------------------------------------------------------------------------- -->
		
	<button id="_alertShow" type="button" class="btn btn-primary" data-toggle="modal" data-target=".aviso-modal-sm" style="display:none">&nbsp;</button>
			
	<div id="_modalDiv" class="modal fade aviso-modal-sm">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"  id="_alertCloseUp">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title" id="_alertTitle">Aviso</h4>
				</div>
				<div class="modal-body" id="_alertBody"></div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal" id="_alertClose">Cerrar</button>
				</div>
			</div>
		</div>
	</div>
			
	<!-- ----------------------------------------------------------------------------------------- -->
	<!-- ----------------------Fin de seccion de alertas y mensajes modales----------------------- -->		
	<!-- ----------------------------------------------------------------------------------------- -->
	

	<!-- Mainly scripts -->
	<script src="assets/inspinia/js/jquery-2.1.1.js"></script>
	<script src="assets/inspinia/js/bootstrap.min.js"></script>
	<script
		src="assets/inspinia/js/plugins/metisMenu/jquery.metisMenu.js"></script>
	<script
		src="assets/inspinia/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

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
	<script src="assets/inspinia/js/inspinia.js"></script>
	<script src="assets/inspinia/js/plugins/pace/pace.min.js"></script>
	
	<!-- Datatables -->
	<script src="assets/inspinia/js/plugins/dataTables/datatables.min.js"></script>

	<!-- jQuery UI -->
	<script src="assets/inspinia/js/plugins/jquery-ui/jquery-ui.min.js"></script>

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
<!-- 	<script src="assets/inspinia/js/plugins/toastr/toastr.min.js"></script> -->


	<script type="text/javascript">
		$(document).ready(function()
				{
					//alert ("entrando");
					//mostrarAviso("probando Ajax");
				});		
			
	</script>
	
	<script type="text/javascript">
		$(document).ready(function(){			

			$('#tblDispositivos').DataTable({
//                 dom: '<"html5buttons"B>lTfgitp',
//                 buttons: [
//                     {extend: 'copy'},
//                     {extend: 'csv'},
//                     {extend: 'excel', title: 'ExampleFile'},
//                     {extend: 'pdf', title: 'ExampleFile'},

//                     {extend: 'print',
//                      customize: function (win){
//                             $(win.document.body).addClass('white-bg');
//                             $(win.document.body).css('font-size', '10px');

//                             $(win.document.body).find('table')
//                                     .addClass('compact')
//                                     .css('font-size', 'inherit');
//                     	}
//                     }
//                 ]

            });
			
					//alert ("entrando");
					//mostrarAviso("probando Ajax");
				});
		
			//window.jQuery || document.write("<script src='assets/js/jquery-2.1.0.min.js'>"+"<"+"/script>");
	</script>

	
	<?php
		echo $_JAVASCRIPT_CSS;
	?>
	

</body>
</html>
