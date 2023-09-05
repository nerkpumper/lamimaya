<?php
// $_showPageHeading = false;

$titlePage = "Pedido / Facturas";
// $breadCum = "Ventas/Pedido/Nuevo";
$_lugar = LUGAR_VENTAS_FACTURASFILES;

$_addStyle = "<style>
		.btn-file {
	        position: relative;
	        overflow: hidden;
	    }
	    .btn-file input[type=file] {
	        position: absolute;
	        top: 0;
	        right: 0;
	        min-width: 100%;
	        min-height: 100%;
	        font-size: 100px;
	        text-align: right;
	        filter: alpha(opacity=0);
	        opacity: 0;
	        outline: none;
	        background: white;
	        cursor: inherit;
	        display: block;
	    }
	</style>	";

$_addHead="
 		<link href='".URL_BASE."assets/inspinia/css/plugins/dropzone/basic.css' rel='stylesheet'>
         <link href='".URL_BASE."assets/inspinia/css/plugins/dropzone/dropzone.css' rel='stylesheet'>
 		

 		";

$_addScript="
 		<script src=\"".URL_BASE."assets/inspinia/js/plugins/dropzone/dropzone.js\"></script>
 		

		 ";
		 

?>


<div v-show="seleccionarPedido">
    <h2 class="m-l">No. Pedido:</h2>
    <div class="col-sm-3 m-b-xs">
        <div class="input-group">
            <input type="text" class="form-control input-lg" v-model="idPedido" v-on:keypress.enter="cargarDatosPedido"
                oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');" maxlength='8'>
            <span class="input-group-btn">
                <button @click.prevent="cargarDatosPedido" class="btn btn-primary btn-lg " type="button">
                    <i class="fa fa-check"></i><span class="bold"></span>
                </button>
            </span>
        </div>
    </div>
</div>

<div v-show="!seleccionarPedido" class="wrapper wrapper-content">
    <button @click.prevent="seleccionarOtroPedido" class="btn btn-warning">Seleccionar otro Pedido</button>
    <div class="row">
        <div class="col-lg-4">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <div class="file-manager">
                        <h2>
							Pedido: <span class="text-navy pull-right m-b">{{ idPedido }}</span>
						</h2>
                        <h5 ><small>Cliente: </small> <strong class=" m-b" >{{ cliente }}</strong></h5>
                        <h5 ><small>Total: </small> <strong class="" >${{ formatNumber(totalPedido) }}</strong></h5>
                        <div class="hr-line-dashed"></div>
                        <h5>Folders</h5>
                        <ul class="folder-list" style="padding: 0">
                            <li><i class="fa fa-folder"></i> Facturas</li>                            
                        </ul>
                        <div class="hr-line-dashed"></div>

                        <?php if (ModeloUsuario::amIRoot() || Permisos::userIsThisRol(Permisos::$rol_ADMINISTRADOR) || Permisos::userIsThisRol(Permisos::$rol_CXCVIEW)): ?>
                            <button v-show="!uploadingFile" @click="showUploadFile" class="btn btn-primary btn-block">Subir Archivo</button>
                        <?php endif; ?>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
        <div v-show="uploadingFile" class="col-lg-8 animated fadeInRight">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <form id="frmBuscarFoto" class="form-horizontal" method="post" enctype="multipart/form-data">

                        <div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-btn"> <span class="btn btn-primary btn-file"> Buscar<input
                                                    type="file" id="archivo" name="archivo" multiple="multiple">
                                            </span>
                                        </span> <input id="filename" name="filename" type="text" class="form-control"
                                            placeholder="Archivo..." disabled>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    
                                    <!-- <button id="btnUpload" name="btnUpload" class="btn btn-primary">Obtener Nombres de Columna</button> -->
                                    <button id="btnUpload" name="btnUpload" v-on:click.prevent="uploadFile"
                                        class="btn btn-primary">Aceptar</button>

                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2 col-md-offset-9">
                                <a id="btnCancelUpload" name="btnCancelUpload" @click.prevent="cancelUpload"
                                    class="btn btn-danger">Regresar</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div v-show="!uploadingFile" class="col-lg-8 animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                    <div v-for="file in facturas" class="file-box">
                        <div class="file">
                            <a target="_blank" :href="URL_BASE+'f1lem4ua6312/'+ idPedido + '/' + file.fileName">
                                <span class="corner"></span>

                                <div class="icon">
                                    <i class="fa fa-file-pdf-o"></i>
                                </div>
                                <div class="file-name">
                                    {{ file.fileName }}
                                    <br />
                                    <small>Guardado: {{ file.creation }} </small>
                                </div>
                            </a>
                        </div>

                    </div>
                    

                </div>
            </div>
        </div>
    </div>
</div>
