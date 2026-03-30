<?php

	require FOLDER_MODEL_BASE . "model.base.precioxdobles.inc.php";

	class ModeloPrecioxdobles extends ModeloBasePrecioxdobles
	{
		#------------------------------------------------------------------------------------------------------#
		#----------------------------------------------Propiedades---------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		var $_nombreClase="ModeloBasePrecioxdobles";

		var $__ss=array();
		var $__primaryKey="idPrecioXDobles";				
		var $__tableName="precioxdobles";
		var $__tableEdit="precioxdoblesedit";
		var $__tableDelete="precioxdoblesdelete";				

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

		public function setPrecioById($id, $precio)
		{			
			switch ($id)
			{
				case 1 :
					$this->precio1 = $precio;
					break;
				case 2 :
					$this->precio2 = $precio;
					break;
				case 3 :
					$this->precio3 = $precio;
					break;
				case 4 :
					$this->precio4 = $precio;
					break;
				case 5 :
					$this->precio5 = $precio;
					break;
				case 6 :
					$this->precio6 = $precio;
					break;
				case 7 :
					$this->precio7 = $precio;
					break;
				case 8 :
					$this->precio8 = $precio;
					break;
				case 9 :
					$this->precio9 = $precio;
					break;
				case 10 :
					$this->precio10 = $precio;
					break;
			
			}
			
			return;
		}

		#------------------------------------------------------------------------------------------------------#
		#-----------------------------------------------Unsetter-----------------------------------------------#
		#------------------------------------------------------------------------------------------------------#



		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Getter------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		
		public function getPreciosByDesarrolloTipoPrecio()
		{
			try
			{
				$SQL="SELECT
						idPrecioXDobles,tipoPrecio,desarrollo,calibre,precio1,precio2,precio3,precio4,precio5,precio6,precio7,precio8,precio9,precio10,idUsuario
					FROM " . $this->__tableName . "
					WHERE tipoPrecio = '". mysqli_real_escape_string($this->dbLink,$this->tipoPrecio) ."' 
					  AND desarrollo = '" . mysqli_real_escape_string($this->dbLink,$this->desarrollo) . "' 
					  AND calibre = '" . mysqli_real_escape_string($this->dbLink,$this->calibre) . "'";
				
				
// 					return $SQL;
					
					
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la obtencion de detalles de registro.","[ModeloBasePrecioxdobles::getDatos][" . $SQL . "][" . mysqli_error($this->dbLink) . "]");
		
		
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
							$this->$campo= mb_convert_encoding($v, 'ISO-8859-1', 'UTF-8');
						}
					}
					return true;
			}
			catch (Exception $e)
			{
				return $this->setErrorCatch($e);
			}
		}

		public function getPrecioById($id)
		{
			$precio = 0;
			switch ($id)
			{
				case 1 :
					$precio = $this->precio1;
					break;
				case 2 :
					$precio = $this->precio2;
					break;
				case 3 :
					$precio = $this->precio3;
					break;
				case 4 :
					$precio = $this->precio4;
					break;
				case 5 :
					$precio = $this->precio5;
					break;
				case 6 :
					$precio = $this->precio6;
					break;
				case 7 :
					$precio = $this->precio7;
					break;
				case 8 :
					$precio = $this->precio8;
					break;
				case 9 :
					$precio = $this->precio9;
					break;
				case 10 :
					$precio = $this->precio10;
					break;
						
			}
				
			return $precio;
		}


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


	}

