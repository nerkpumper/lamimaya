<?php

 	if(!isset ($_showPageHeading))
 	{
		$_showPageHeading = true;
 	}
                
?>


<div id="page-wrapper" class="gray-bg dashbard-1">
	<div class="row border-bottom">
		<nav class="navbar navbar-static-top <?php echo ($_showPageHeading ? "" : " white-bg"); ?>" role="navigation"
			style="margin-bottom: 0">
			<div class="navbar-header">
				<a id="collapseLeftMenu"
					class="navbar-minimalize minimalize-styl-2 btn btn-primary "
					href="#"><i class="fa fa-bars"></i> </a>
				<!--             <form role="search" class="navbar-form-custom" action="search_results.html"> -->
				<!--                 <div class="form-group"> -->
				<!--                     <input type="text" placeholder="Search for something..." class="form-control" name="top-search" id="top-search"> -->
				<!--                 </div> -->
				<!--             </form> -->
			</div>
			<ul class="nav navbar-top-links navbar-right">
				<li><span class="m-r-sm text-muted welcome-message"><strong> <?php if(isset($objSession)) echo $objSession->getFullName()?></strong></span>
				</li>
<!-- 				                 <li class="dropdown">  -->
<!-- 				                     <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">  -->
<!-- 				                         <i class="fa fa-envelope"></i>  <span class="label label-warning"></span>  -->
<!-- 				                     </a>  -->
<!-- 				                     <ul class="dropdown-menu dropdown-messages">  -->
<!-- 				                         <li>  -->
<!-- 				                             <div class="dropdown-messages-box">  -->
<!-- 				                                 <a href="profile.html" class="pull-left">  -->
<!-- 				                                     <img alt="image" class="img-circle" src="img/3.jpg">  -->
<!-- 				                                 </a>  -->
<!-- 				                                 <div class="media-body">  -->
<!-- 				                                     <small class="pull-right">46h ago</small>  -->
<!-- 				                                     <strong>Mike Loreipsum</strong> started following <strong>Monica Smith</strong>. <br>  -->
<!-- 				                                     <small class="text-muted">3 days ago at 7:58 pm - 10.06.2014</small>  -->
<!-- 				                                 </div>  -->
<!-- 				                             </div>  -->
<!-- 				                         </li>  -->
<!-- 				                         <li class="divider"></li>  -->
<!-- 				                         <li>  -->
<!-- 				                             <div class="dropdown-messages-box">  -->
<!-- 				                                 <a href="profile.html" class="pull-left">  -->
<!-- 				                                     <img alt="image" class="img-circle" src="img/3.jpg">  -->
<!-- 				                                 </a>  -->
<!-- 				                                 <div class="media-body ">  -->
<!-- 				                                     <small class="pull-right text-navy">5h ago</small>  -->
<!-- 				                                     <strong>Chris Johnatan Overtunk</strong> started following <strong>Monica Smith</strong>. <br>  -->
<!-- 				                                     <small class="text-muted">Yesterday 1:21 pm - 11.06.2014</small>  -->
<!-- 				                                 </div>  -->
<!-- 				                             </div>  -->
<!-- 				                         </li>  -->
<!-- 				                         <li class="divider"></li>  -->
<!-- 				                         <li>  -->
<!-- 				                             <div class="dropdown-messages-box">  -->
<!-- 				                                 <a href="profile.html" class="pull-left">  -->
<!-- 				                                     <img alt="image" class="img-circle" src="img/3.jpg">  -->
<!-- 				                                 </a>  -->
<!-- 				                                 <div class="media-body ">  -->
<!-- 				                                     <small class="pull-right">23h ago</small>  -->
<!-- 				                                     <strong>Monica Smith</strong> love <strong>Kim Smith</strong>. <br>  -->
<!-- 				                                     <small class="text-muted">2 days ago at 2:30 am - 11.06.2014</small>  -->
<!-- 				                                 </div>  -->
<!-- 				                             </div>  -->
<!-- 				                         </li>  -->
<!-- 				                         <li class="divider"></li>  -->
<!-- 				                         <li>  -->
<!-- 				                             <div class="text-center link-block">  -->
<!-- 				                                 <a href="mailbox.html">  -->
<!-- 				                                     <i class="fa fa-envelope"></i> <strong>Read All Messages</strong>  -->
<!-- 				                                 </a>  -->
<!-- 				                             </div>  -->
<!-- 				                         </li>  -->
<!-- 				                     </ul>  -->
<!-- 				                 </li>  -->
<!-- 				                 <li class="dropdown">  -->
				                 
				                 
				                 
				                 
<!-- 				                     <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">  -->
<!-- 				                         <i class="fa fa-bell"></i> -->
<!-- 				                         <div id="headerNoNotificaciones">   -->
					                          
<!-- 				                         </div> -->
<!-- 				                     </a>  -->
<!-- 				                     <ul id="headerListadoNotificaciones" class="dropdown-menu dropdown-alerts">  -->
				                     	
				                     
				                    
				                     
<!-- 				                         <li>  -->
<!-- 				                             <div class="text-center link-block">  -->
<!-- 				                                 				                                 <a href="-->


				                                 <!-- notificaciones">  -->
<!-- 				                                     <strong>Ver todas las Notificaciones</strong>  -->
<!-- 				                                     <i class="fa fa-angle-right"></i>  -->
<!-- 				                                 </a>  -->
<!-- 				                             </div>  -->
<!-- 				                         </li>  -->
<!-- 				                     </ul>  -->
<!-- 				                 </li>  -->


				<li><a href="<?php echo URL_BASE . "salir"?>"> <i
						class="fa fa-sign-out"></i> Salir
				</a></li>				

				<?php if (isset($_isPedidoPage) && $_isPedidoPage == true): ?>
					<li>
						<a class="right-sidebar-toggle">
							<i class="fa fa-tasks"></i>
						</a>
					</li>
				
				<?php endif; ?>


			</ul>

		</nav>
	</div>

