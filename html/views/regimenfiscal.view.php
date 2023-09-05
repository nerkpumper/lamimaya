<?php
$titlePage = "Cat&aacute;logos";
$breadCum = "Cat&aacute;logos/Regimen Fiscal/Editar";
$_lugar = LUGAR_CATALOGOS_REGIMENFISCAL;

$_addScript ="
    
			<script src=\"".URL_BASE."js/components/concepto-gasto-selector.vue.js\"></script>
            <script src=\"".URL_BASE."js/components/concepto-gasto-new-edit.vue.js\"></script>
			
            ";



?>

<div >  
    <div class="ibox">
        <div class="ibox-title">
            <h5>Gastos Registrados</h5>
           
        </div>
        <div class="ibox-content m-b-sm border-bottom">               
            <div class="table-responsive">
                <table class="table table-striped">

                    <thead>
                        <tr>
                            <th>C&oacute;digo</th>
                            <th>Descripci&oacute;n</th>
                            
                            <th>Acciones</th>
                        </tr>                    
                    </thead>
                    <tbody>
                        <tr v-for="(rf,index) in regimenesfiscales">                            
                            <td style="width: 15%">
                                <input type="text" v-model="rf.codigo" 
                                        placeholder="" maxlength="10" class="form-control"
                                        >   
                            </td>                            
                            <td style="width: 70%">
                                <input type="text" v-model="rf.descripcion" placeholder="" maxlength="100" class="form-control"
                                        >
                            </td>
                            
                            <td style="width: 15%">
                                <button v-if="rf.id == 0 || (rf.codigo != rf.codigoAux || rf.descripcion != rf.descripcionAux)" 
                                    class="btn btn-info btn-xs m-t-xs"
                                    @click.prevent="saveRegimen(index)">
                                    <i class="fa fa-pencil"></i>
                                </button>
                                <button v-if="rf.id == 0"
                                    class="btn btn-danger btn-xs m-t-xs" @click.prevent="deleteNewRegimen(index)">
                                    <i class="fa fa-trash"></i>
                                </button>
                                
                                
                            </td>
                        </tr>    
                        
                    
                    </tbody>
                </table>
                <button class="btn btn-primary " @click.prevent="addNewRegimen"> Agregar R&eacute;gimen</button>                
            </div>
        </div>
    </div>

    

    
</div>
