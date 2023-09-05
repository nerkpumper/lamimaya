<?php

	require FOLDER_MODEL_BASE . "model.base.inventariosucursal.inc.php";

	class ModeloInventariosucursal extends ModeloBaseInventariosucursal
	{
		#------------------------------------------------------------------------------------------------------#
		#----------------------------------------------Propiedades---------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		var $_nombreClase="ModeloBaseInventariosucursal";

		var $__ss=array();
		var $__primaryKey="idInventarioSucursal";				
		var $__tableName="inventariosucursal";
		var $__tableEdit="inventariosucursaledit";
		var $__tableDelete="inventariosucursaldelete";				

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
		
		public function getDatosProductoSucursal($idProducto, $idSucursal)
		{
		    try
		    {
		        $SQL="SELECT
						idInventarioSucursal,
						idSucursal,
						idProducto,
						existencia,
						apartado
					FROM " . $this->__tableName . "
					WHERE idProducto=" . mysqli_real_escape_string($this->dbLink,$idProducto) . "
		        and  idSucursal=" . mysqli_real_escape_string($this->dbLink,$idSucursal);
		        
		        $result=mysqli_query($this->dbLink,$SQL);
		        if(!$result)
		            return $this->setSystemError("Error en la obtencion de detalles de registro.","[ModeloBaseInventariosucursal::getDatos][" . $SQL . "][" . mysqli_error($this->dbLink) . "]");
		            
		            
		            if(mysqli_num_rows($result)==0)
		            {
		                $this->limpiarPropiedades();
		            }
		            else
		            {
		                $datos=mysqli_fetch_assoc($result);
		                foreach($datos as $k=>$v)
		                {
		                    $campo="" . $k;
		                    $this->$campo=$v;
		                }
		            }
		            return true;
		    }
		    catch (Exception $e)
		    {
		        return $this->setErrorCatch($e);
		    }
		}
		
		public function validarDatos()
		{
			return true;
		}


	}

