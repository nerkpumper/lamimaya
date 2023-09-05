<?php
$titlePage = "Zonas";
$breadCum = "Zonas/Registro";
$buttonAction = "Regresar al Listado/fnRegresarAListado";
$_lugar = LUGAR_RUTAS_RUTAS;

$_addHead = "
    <style>
            .file-input-wrapper {
            height: 30px;
            margin: 2px;
            overflow: hidden;
            position: relative;
            width: 118px;
            background-color: #fff;
            cursor: pointer;
            }

            .file-input-wrapper>input[type=\"file\"] {
            font-size: 40px;
            position: absolute;
            top: 0;
            right: 0;
            opacity: 0;
            cursor: pointer;
            }

            .file-input-wrapper>.btn-file-input {
            background-color: #494949;
            border-radius: 4px;
            color: #fff;
            display: inline-block;
            height: 34px;
            margin: 0 0 0 -1px;
            padding-left: 0;
            width: 121px;
            cursor: pointer;
            }

            .file-input-wrapper:hover>.btn-file-input {
            //background-color: #494949;
            }
        </style>
";

?>

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<h5>Zonas <small>{{ accionModulo }}</small></h5>				
			</div>
			<div class="ibox-content">
                <div class="row">
                    <div class="col-lg-6">
                                                                            
                        <?php
                            
                            Form::open("frmMaterial");
                                    
                            Form::hidden("idMaterial");
                            
                            Form::setColsInput("l12|m12|s12|x12");
                            Form::text("nombre", "Nombre", "43", true);
                            Form::text("descripcion", "Descripcion", "250", true);
                            
                            
                            // Form::text("clave", "Clave", "3", true);
                            
                            
                            

                        ?>

                        <div class="row">
                            <div class="col-lg-8">
                                
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">{{ selImagen}}</label>
                                    <div class="col-sm-8">
                                        <div  v-if="true || !image" class="input-group mb15 file-input-wrapper">
                                            <span class="input-group-btn">
                                                <button v-show="!image" type="button" @click.prevent="app.$refs.openImage.click()" class="btn btn-default"><i class="fa fa-upload"></i></button>                                        
                                            </span>
                                            <!-- <input type="text"  class="form-control" /> -->
                                                
                                                <input  id="fileImage" name="file" ref="openImage" type="file" @change="onFileChange" class="form-control">
                                            

                                        </div><!-- input-group -->
                                        <div v-show="image">
                                            <img :src="image" style="width: 400px; height: 300px;" />
                                            <br>
                                            <br>
                                            <button class="btn btn-danger" @click="removeImage">Seleccionar otra imagen</button>
                                        </div>
                                    </div>
                                    
                                </div><!-- form-group -->
                            </div>
                        </div>

                        <?php
                                        
                                Form::buttonPrimary("Guardar", "guardarRuta");	
                            Form::close();
                        ?>
                    </div>
                    <div v-show="idRuta > 0" class="col-lg-6">
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Imagen Actual</label>
                        </div>
                        <img :src="imgURL" style="width: 400px; height: 300px;" />
                    </div>
                </div>
							
<!-- 				<input type="hidden" v-model="id" class="form-control input-md" > -->
								
			</div>
		</div>
	</div>
</div>

<!-- <pre> -->
<!-- 	{{ $data}} -->
<!-- </pre> -->

