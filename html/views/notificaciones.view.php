<?php
$titlePage = "Notificaciones";
$breadCum = "Notificaciones";

// $_lugar = LUGAR_PRODUCTOS_ROLLO;

$_addHead="
 		<link href='".URL_BASE."assets/inspinia/css/plugins/toastr/toastr.min.css' rel='stylesheet'> 		
 		";

$_addScript="
 		<script src=\"".URL_BASE."assets/inspinia/js/plugins/toastr/toastr.min.js\"></script>
 		
 		";

?>



<div class="row">
	<div class="col-lg-3 col-md-3 col-sm-12 col-sm-12">
		<div class="ibox float-e-margins">
			<div class="ibox-content mailbox-content">
				<div class="file-manager">					
					
					<h5>Notificaciones</h5>
					<ul class="folder-list m-b-md" style="padding: 0">
						<li>
							<a @click.prevenr="cargarSinLeer" href="#"> <i class="fa fa-inbox "></i> Sin leer 
								<span class="label label-primary pull-right">{{ totalSinLeer }}</span>
							</a>
						</li>
						<li>
							<a @click.prevent="cargarLeidas" href="#"> <i class="fa fa-eye"></i> Le&iacute;das
								<span class="label label-info pull-right">{{ totalLeidas }}</span>
							</a>
						</li>						
						<li>
							<a @click.prevent="cargarBorradas" href=""> <i class="fa fa-trash-o"></i> Eliminadas
								<span class="label label-danger pull-right">{{ totalBorradas }}</span>
							</a>
						</li>
					</ul>
					
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-lg-9 col-md-9 col-sm-12 col-sm-12">
	
		<div v-show="mostrandoSinLeer">		
		
			<h4 v-show="notificaciones.length <= 0">No hay notificaciones Sin Leer</h4>
			<h3 v-show="notificaciones.length > 0">Sin Leer</h3>
			

		</div>
		<div v-show="mostrandoLeidas">
			<h4 v-show="notificaciones.length <= 0">No hay notificaciones Le&iacute;dos</h4>
			<h3 v-show="notificaciones.length > 0">Le&iacute;das</h3>
			
		</div>
		<div v-show="mostrandoBorradas">
			<h4 v-show="notificaciones.length <= 0">No hay notificaciones Borradas</h4>
			<h3 v-show="notificaciones.length > 0">Borradas</h3>
			
		</div>
		
		<div v-for="(noti,index) in notificaciones" class="social-feed-box">

<!-- 				<div class="pull-right social-action dropdown"> -->
<!-- 					<button data-toggle="dropdown" class="dropdown-toggle btn-white"> -->
<!-- 						<i class="fa fa-angle-down"></i> -->
<!-- 					</button> -->
<!-- 					<ul class="dropdown-menu m-t-xs"> -->
<!-- 						<li><a href="#">Config</a></li> -->
<!-- 					</ul> -->
<!-- 				</div> -->
				<div class="social-avatar">
					<a href="" class="pull-left"> <img alt="image" :src="noti.imagen">
					</a>
					<div class="media-body">
						<a href="#"> {{ noti.usuario }} </a> 
						<small class="text-muted">{{ noti.fecha }}</small>
					</div>
				</div>
				<div class="social-body">
					<h5>{{ noti.tema }}</h5>
				
					<p v-html="noti.contenido"></p>

					<div class="btn-group">
						<button v-show="mostrandoSinLeer || mostrandoBorradas" @click.prevent="marcarComoLeida(index)" class="btn btn-white btn-xs">
							<i class="fa fa-eye"></i> Marcar como Le&iacute;da
						</button>	
						<button v-show="mostrandoLeidas || mostrandoBorradas" @click.prevent="marcarComoNoLeida(index)" class="btn btn-white btn-xs">
							<i class="fa fa-inbox"></i> Marcar como No Le&iacute;da
						</button>					
						<button v-show="mostrandoSinLeer || mostrandoLeidas" @click.prevent="marcarComoBorrada(index)" class="btn btn-danger btn-xs">
							<i class="fa fa-trash-o"></i> Borrar
						</button>
						
								
					</div>
				</div>


			</div>
	
<!-- 		<div class="social-feed-box"> -->

<!-- 			<div class="pull-right social-action dropdown"> -->
<!-- 				<button data-toggle="dropdown" class="dropdown-toggle btn-white"> -->
<!-- 					<i class="fa fa-angle-down"></i> -->
<!-- 				</button> -->
<!-- 				<ul class="dropdown-menu m-t-xs"> -->
<!-- 					<li><a href="#">Config</a></li> -->
<!-- 				</ul> -->
<!-- 			</div> -->
<!-- 			<div class="social-avatar"> -->
<!-- 				<a href="" class="pull-left"> <img alt="image" src="img/a1.jpg"> -->
<!-- 				</a> -->
<!-- 				<div class="media-body"> -->
<!-- 					<a href="#"> Andrew Williams </a> <small class="text-muted">Today -->
<!-- 						4:21 pm - 12.06.2014</small> -->
<!-- 				</div> -->
<!-- 			</div> -->
<!-- 			<div class="social-body"> -->
<!-- 				<p>Many desktop publishing packages and web page editors now use -->
<!-- 					Lorem Ipsum as their default model text, and a search for 'lorem -->
<!-- 					ipsum' will uncover many web sites still in their infancy. Packages -->
<!-- 					and web page editors now use Lorem Ipsum as their default model -->
<!-- 					text.</p> -->

<!-- 				<div class="btn-group"> -->
<!-- 					<button class="btn btn-white btn-xs"> -->
<!-- 						<i class="fa fa-thumbs-up"></i> Like this! -->
<!-- 					</button> -->
<!-- 					<button class="btn btn-white btn-xs"> -->
<!-- 						<i class="fa fa-comments"></i> Comment -->
<!-- 					</button> -->
<!-- 					<button class="btn btn-white btn-xs"> -->
<!-- 						<i class="fa fa-share"></i> Share -->
<!-- 					</button> -->
<!-- 				</div> -->
<!-- 			</div> -->


<!-- 		</div> -->

	


	</div>
</div>


<!-- <pre>{{ $data.notificaciones }}</pre> -->
<!-- <pre>{{ $data }}</pre> -->