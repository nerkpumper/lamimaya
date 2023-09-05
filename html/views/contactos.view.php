<?php
$titlePage = "Contactos";
$breadCum = "Contactos";

// $_lugar = LUGAR_ADMINISTRACION_CONFIGURACION;


?>

<div class="modal inmodal" id="modalEnviaMsg" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
<!-- <div> -->
	<div class="modal-dialog">
		<div class="modal-content animated bounceInRight">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
				</button>
				<i class="fa fa-comments modal-icon"></i>
				<h6 class="modal-title"><small>Enviar Msg a</small> <br><strong>{{ msgDestinoNombre }}</strong></h6>
				
			</div>
			<div class="modal-body">
				
				
				
				<div v-show="msgDestinoToken != ''">
				
					
    				<?php 
    				    
    				Form::setColsGroup ( "l12|m12|s12|x12" );
    				Form::setColsLabel ( "l12|m12|s12|x12" );
    				Form::setColsInput("l12|m12|s12|x12");
    				
    				Form::text("asunto", "Asunto","30", true, false );
    // 				Form::setMargin("m-t");
    				    Form::textarea("msg", "Mensaje", "4", "", "250", true);
    				
    				?>
				</div>
				
				<div v-show="msgDestinoToken == ''">
					El Usuario no tiene asignado un dispositivo para enviar mensajes.
				</div>
				
				
				<div class="clearfix"></div>
			</div>
			<div class="modal-footer">		
				
				<div v-show="msgDestinoToken != ''">
					<button @click.prevent="envia" type="button"
					class="btn btn-primary">Enviar</button>
				</div>	
				
			</div>
		</div>
	</div>
</div>


<div class="row">	
	<div v-for="(con, index) in contactos" class="col-lg-4 m-b">
		<div class="contact-box">
			
				<div class="col-sm-4">
					
					<div v-html="getImg(index)" class="text-center">
<!-- 						<img alt="image" class="img-circle m-t-xs img-responsive" -->
<!-- 							src="img/a3.jpg"> -->
<!-- 						<div class="m-t-xs font-bold">CEO</div> -->
					</div>
				</div>
				<div class="col-sm-8">
					<h3>
						<strong>{{ con.nombre }} {{ con.apellidoPaterno }} {{ con.apellidoMaterno }}</strong>
					</h3>
					<div class="m-t-xs font-bold">{{ con.rol }}</div>
					<p>
						<i class="fa fa-user"></i> {{ con.username }}
					</p>
					
					<address>
						<strong>{{ con.email }}</strong><br> 
					</address>
					
					<button v-show="con.token != ''" class="btn btn-md btn-primary"  @click.prevent="enviarmsg(index)"><i class="fa fa-comments"></i> Enviar Msg</button>
					
					<button v-show="con.token == ''" disabled class="btn btn-md btn-primary"  ><i class="fa fa-comments"></i> Enviar Msg</button>
				</div>
				<div class="clearfix"></div>
			
		</div>
	</div>

</div>


<!-- <pre>{{ $data }}</pre> -->