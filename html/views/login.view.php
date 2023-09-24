<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login</title>
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo URL_BASE;?>img/lamimayaicon.ico" />


    <link href="<?php echo URL_BASE;?>assets/inspinia/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo URL_BASE;?>assets/inspinia/font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="<?php echo URL_BASE;?>assets/inspinia/css/animate.css" rel="stylesheet">
    <link href="<?php echo URL_BASE;?>assets/inspinia/css/style.css" rel="stylesheet">

</head>

<body class="gray-bg">

    <div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
            <div>
				<img alt="Galvamex" src="<?php echo URL_BASE . "img/lamimayalogo.png";?>" style="width: 100%;">
                <!-- <h2 class="">Lamimaya</h2> -->

            </div>
<!--             <h3>Welcome to Company</h3> -->
<!--             <p>Perfectly designed and precisely prepared admin theme with over 50 pages with extra new web app views. -->
                <!--Continually expanded and constantly improved Inspinia Admin Them (IN+)-->
<!--             </p> -->
<!--             <p>Login in. To see it in action.</p> -->
            <form id="frmLogin" class="m-t" role="form" action="">
                <div class="form-group">
                    <input id="txtEmail" type="text" class="form-control" placeholder="Username" required="">
                </div>
                <div class="form-group">
                    <input id="txtPass" type="password" class="form-control" placeholder="Password" required="">
                </div>
                <button id="btnLogin" type="submit" class="btn btn-primary block full-width m-b">Ingresar</button>

<!--                 <a href="#"><small>Forgot password?</small></a> -->
<!--                 <p class="text-muted text-center"><small>Do not have an account?</small></p> -->
<!--                 <a class="btn btn-sm btn-white btn-block" href="register.html">Create an account</a> -->
            </form>
<!--             <p class="m-t"> <small>Inspinia we app framework base on Bootstrap 3 &copy; 2014</small> </p> -->
        </div>
    </div>
    
    <!-- ----------------------------------------------------------------------------------------- -->
	<!-- --------------------------Seccion de alertas y mensajes modales-------------------------- -->
	<!-- ----------------------------------------------------------------------------------------- -->
	
	<button id="_alertShow" type="button" class="btn btn-primary" data-toggle="modal" data-target="#_modalAlertShow" style="display: none;"></button>                                
                                        
    <div class="modal inmodal fade" id="_modalAlertShow" tabindex="-1" role="dialog"  aria-hidden="true">
    	<div class="modal-dialog modal-lg">
        	<div class="modal-content animated bounceInRight">
            	<div class="modal-header">
                	<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
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

    <!-- Mainly scripts -->
    <script src="<?php echo URL_BASE;?>assets/inspinia/js/jquery-2.1.1.js"></script>
    <script src="<?php echo URL_BASE;?>assets/inspinia/js/bootstrap.min.js"></script>

</body>

</html>
