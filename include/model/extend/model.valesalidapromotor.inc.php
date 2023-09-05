<?php

	require FOLDER_MODEL_BASE . "model.base.valesalidapromotor.inc.php";
	require_once FOLDER_MODEL. "model.valesalida.inc.php";
	require_once FOLDER_MODEL. "model.valesalidadetalle.inc.php";

	class ModeloValesalidapromotor extends ModeloBaseValesalidapromotor
	{
		#------------------------------------------------------------------------------------------------------#
		#----------------------------------------------Propiedades---------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		var $_nombreClase="ModeloBaseValesalidapromotor";

		var $__ss=array();
		var $__primaryKey="idValeSalidaPromotor";				
		var $__tableName="valesalidapromotor";
		var $__tableEdit="valesalidapromotoredit";
		var $__tableDelete="valesalidapromotordelete";				

		#------------------------------------------------------------------------------------------------------#
		#--------------------------------------------Inicializacion--------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		function __construct()
		{
			parent::__construct();
		}

		function __destruct()
		{
			
		}

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Setter------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#



		#------------------------------------------------------------------------------------------------------#
		#-----------------------------------------------Unsetter-----------------------------------------------#
		#------------------------------------------------------------------------------------------------------#



		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Getter------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#



		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Querys------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Otras-------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		
		public function validarDatos()
		{
			return true;
		}
		
		public function GenerarValeSalidaReal($idValeSalidaPromotor)
		{
		    $this->setIdValeSalidaPromotor($idValeSalidaPromotor);
		    
		    
		    $vs = new ModeloValesalida();
		    
		    $vs->setIdPedido($this->getIdPedido());
		    $vs->setEstadoCREADO();
		    $vs->setIdSucursal($this->getIdSucursal());
		    $vs->setDateAndUser("creado");
		    
		    $vs->Guardar();
// 		    echo "empezamos<br>"; 
		    if (!$vs->getError())
		    {
		        $lst = $vs->getDataSet("select * from valesalidapromotordetalle where idvalesalidapromotor = ". $idValeSalidaPromotor);
		        $blnError = false;
// 		        echo "<br> a por el detalle "; 
		        foreach ($lst as $row)
		        {
// 		            echo "<br>        -----  detalle "; 
		            $valeSalidaDetalle = new ModeloValesalidadetalle();
// 		            echo "<br>                 +++++++   detalle leido "; return;
		            $valeSalidaDetalle->setIdValeSalida($vs->getIdValeSalida());
		            $valeSalidaDetalle->setIdPedidoDetalle($row["idPedidoDetalle"]);
		            $valeSalidaDetalle->setIdPedido($row["idPedido"]);
		            
		            
		            $valeSalidaDetalle->setIdProducto($row["idProducto"]);
		            $valeSalidaDetalle->setCantidad($row["cantidad"]);
		            $valeSalidaDetalle->setFecha_despacho($row["fecha_despacho"]);
		            $valeSalidaDetalle->setId_usuario_despacho($row["id_usuario_despacho"]);
		            $valeSalidaDetalle->setIdSucursalDespachado($row["idSucursalDespachado"]);
		            
// 		            echo "<br>                 +++++++   detalle leido "; return; 
		            
		            $valeSalidaDetalle->Guardar();
		            
		            if ($valeSalidaDetalle->getError())
		            {
		                $blnError = true;
		            }
		            
		        }
		        
// 		        echo "<br>  <br>  se ha guardado el  detalle "; return;
		        if (!$blnError)
		        {
		            $this->setEstadoSALIDA();
		            $this->setIdValeSalida($vs->getIdValeSalida());
		            
// 		            echo "<br>  <br>     ¿¿¿¿¿¿ Marcamos el Vale salida Promotor ";
		            
		            $this->Guardar();
		            
		            if (!$this->getError())
		            {
		                return true;
		            }
		            
		        }
		        
		        return false;
		        
		    }
		    else
		    {
		        return false;
		    }
		}


	}

