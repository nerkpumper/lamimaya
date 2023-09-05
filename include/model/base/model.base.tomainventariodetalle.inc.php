<?php

	class ModeloBaseTomainventariodetalle extends clsBasicCommon
	{
		#------------------------------------------------------------------------------------------------------#
		#----------------------------------------------Propiedades---------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		var $_nombreClase="base.ModeloBaseTomainventariodetalle";

		
		var $idTomaInventarioDetalle=0;
		var $idTomaInventario=0;
		var $idRemisionRollo=0;
		var $idProducto=0;
		var $norollo='';
		var $idRolloOriginal=0;
		var $idRolloUpdate=0;
		var $kilosOriginal='0.00';
		var $kilosUpdate='0.00';
		var $almacenOriginal='ALMACEN PRINCIPAL';
		var $almacenUpdate='ALMACEN PRINCIPAL';
		var $existenciaOriginal='0.00';
		var $existenciaUpdate='0.00';
		var $fecha_captura='0000-00-00 00:00:00';
		var $id_usuario_captura=0;
		var $tipotoma='UPDATE';
		var $tipoproducto='ROLLO';

		var $__s=array("idTomaInventarioDetalle",
                       "idTomaInventario",
                       "idRemisionRollo",
                       "idProducto",
                       "norollo",
                       "idRolloOriginal",
                       "idRolloUpdate",
                       "kilosOriginal",
                       "kilosUpdate",
                       "almacenOriginal",
                       "almacenUpdate",
                       "existenciaOriginal",
                       "existenciaUpdate",
                       "fecha_captura",
                       "id_usuario_captura",
                       "tipotoma",
                       "tipoproducto");
				
		var $__ss=array();

		#------------------------------------------------------------------------------------------------------#
		#--------------------------------------------Inicializacion--------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		function __construct()
		{
			global $dbLink;
			if(is_null($dbLink))
			{
				trigger_error("La coneccion a la base de datos no esta establecida.",E_ERROR);
				return;
			}
			$this->dbLink=$dbLink;
			$this->link=$dbLink;
		}

		function __destruct()
		{
			
		}

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Setter------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		
		public function setIdTomaInventarioDetalle($idTomaInventarioDetalle)
		{
			if($idTomaInventarioDetalle==0||$idTomaInventarioDetalle==""||!is_numeric($idTomaInventarioDetalle)|| (is_string($idTomaInventarioDetalle)&&!ctype_digit($idTomaInventarioDetalle)))return $this->setError("Tipo de dato incorrecto para idTomaInventarioDetalle.");
			$this->idTomaInventarioDetalle=$idTomaInventarioDetalle;
			$this->getDatos();
		}
		public function setIdTomaInventario($idTomaInventario)
		{
			
			$this->idTomaInventario=$idTomaInventario;
		}
		public function setIdRemisionRollo($idRemisionRollo)
		{
			
			$this->idRemisionRollo=$idRemisionRollo;
		}
		public function setIdProducto($idProducto)
		{
			
			$this->idProducto=$idProducto;
		}
		public function setNorollo($norollo)
		{
			
			$this->norollo=$norollo;
		}
		public function setIdRolloOriginal($idRolloOriginal)
		{
			
			$this->idRolloOriginal=$idRolloOriginal;
		}
		public function setIdRolloUpdate($idRolloUpdate)
		{
			
			$this->idRolloUpdate=$idRolloUpdate;
		}
		public function setKilosOriginal($kilosOriginal)
		{
			$this->kilosOriginal=$kilosOriginal;
		}
		public function setKilosUpdate($kilosUpdate)
		{
			$this->kilosUpdate=$kilosUpdate;
		}
		public function setAlmacenOriginal($almacenOriginal)
		{
			
			$this->almacenOriginal=$almacenOriginal;
		}
		public function setAlmacenOriginalALMACENA()
		{
			$this->almacenOriginal='ALMACEN A';
		}
		public function setAlmacenOriginalALMACENB()
		{
			$this->almacenOriginal='ALMACEN B';
		}
		public function setAlmacenOriginalALMACENPRINCIPAL()
		{
			$this->almacenOriginal='ALMACEN PRINCIPAL';
		}
		public function setAlmacenOriginalMCM()
		{
			$this->almacenOriginal='MCM';
		}
		public function setAlmacenOriginalALPES()
		{
			$this->almacenOriginal='ALPES';
		}
		public function setAlmacenOriginalCASA()
		{
			$this->almacenOriginal='CASA';
		}
		public function setAlmacenOriginalNARCISO()
		{
			$this->almacenOriginal='NARCISO';
		}
		public function setAlmacenUpdate($almacenUpdate)
		{
			
			$this->almacenUpdate=$almacenUpdate;
		}
		public function setAlmacenUpdateALMACENA()
		{
			$this->almacenUpdate='ALMACEN A';
		}
		public function setAlmacenUpdateALMACENB()
		{
			$this->almacenUpdate='ALMACEN B';
		}
		public function setAlmacenUpdateALMACENPRINCIPAL()
		{
			$this->almacenUpdate='ALMACEN PRINCIPAL';
		}
		public function setAlmacenUpdateMCM()
		{
			$this->almacenUpdate='MCM';
		}
		public function setAlmacenUpdateALPES()
		{
			$this->almacenUpdate='ALPES';
		}
		public function setAlmacenUpdateCASA()
		{
			$this->almacenUpdate='CASA';
		}
		public function setAlmacenUpdateNARCISO()
		{
			$this->almacenUpdate='NARCISO';
		}
		public function setExistenciaOriginal($existenciaOriginal)
		{
			$this->existenciaOriginal=$existenciaOriginal;
		}
		public function setExistenciaUpdate($existenciaUpdate)
		{
			$this->existenciaUpdate=$existenciaUpdate;
		}
		public function setFecha_captura($fecha_captura)
		{
			$this->fecha_captura=$fecha_captura;
		}
		public function setId_usuario_captura($id_usuario_captura)
		{
			
			$this->id_usuario_captura=$id_usuario_captura;
		}
		public function setTipotoma($tipotoma)
		{
			
			$this->tipotoma=$tipotoma;
		}
		public function setTipotomaNUEVO()
		{
			$this->tipotoma='NUEVO';
		}
		public function setTipotomaUPDATE()
		{
			$this->tipotoma='UPDATE';
		}
		public function setTipoproducto($tipoproducto)
		{
			
			$this->tipoproducto=$tipoproducto;
		}
		public function setTipoproductoROLLO()
		{
			$this->tipoproducto='ROLLO';
		}
		public function setTipoproductoPRODUCTO()
		{
			$this->tipoproducto='PRODUCTO';
		}

		#------------------------------------------------------------------------------------------------------#
		#-----------------------------------------------Unsetter-----------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Getter------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		
		public function getIdTomaInventarioDetalle()
		{
			return $this->idTomaInventarioDetalle;
		}
		public function getIdTomaInventario()
		{
			return $this->idTomaInventario;
		}
		public function getIdRemisionRollo()
		{
			return $this->idRemisionRollo;
		}
		public function getIdProducto()
		{
			return $this->idProducto;
		}
		public function getNorollo()
		{
			return $this->norollo;
		}
		public function getIdRolloOriginal()
		{
			return $this->idRolloOriginal;
		}
		public function getIdRolloUpdate()
		{
			return $this->idRolloUpdate;
		}
		public function getKilosOriginal()
		{
			return $this->kilosOriginal;
		}
		public function getKilosUpdate()
		{
			return $this->kilosUpdate;
		}
		public function getAlmacenOriginal()
		{
			return $this->almacenOriginal;
		}
		public function getAlmacenUpdate()
		{
			return $this->almacenUpdate;
		}
		public function getExistenciaOriginal()
		{
			return $this->existenciaOriginal;
		}
		public function getExistenciaUpdate()
		{
			return $this->existenciaUpdate;
		}
		public function getFecha_captura()
		{
			return $this->fecha_captura;
		}
		public function getId_usuario_captura()
		{
			return $this->id_usuario_captura;
		}
		public function getTipotoma()
		{
			return $this->tipotoma;
		}
		public function getTipoproducto()
		{
			return $this->tipoproducto;
		}

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Querys------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Otras-------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		protected function limpiarPropiedades()
		{
			
			$this->idTomaInventarioDetalle=0;
			$this->idTomaInventario=0;
			$this->idRemisionRollo=0;
			$this->idProducto=0;
			$this->norollo='';
			$this->idRolloOriginal=0;
			$this->idRolloUpdate=0;
			$this->kilosOriginal='0.00';
			$this->kilosUpdate='0.00';
			$this->almacenOriginal='ALMACEN PRINCIPAL';
			$this->almacenUpdate='ALMACEN PRINCIPAL';
			$this->existenciaOriginal='0.00';
			$this->existenciaUpdate='0.00';
			$this->fecha_captura='0000-00-00 00:00:00';
			$this->id_usuario_captura=0;
			$this->tipotoma='UPDATE';
			$this->tipoproducto='ROLLO';
		}

		

		
		protected function Insertar()
		{
			try
			{
				$SQL="INSERT INTO " . $this->__tableName . " (idTomaInventario,
				                                              idRemisionRollo,
				                                              idProducto,
				                                              norollo,
				                                              idRolloOriginal,
				                                              idRolloUpdate,
				                                              kilosOriginal,
				                                              kilosUpdate,
				                                              almacenOriginal,
				                                              almacenUpdate,
				                                              existenciaOriginal,
				                                              existenciaUpdate,
				                                              fecha_captura,
				                                              id_usuario_captura,
				                                              tipotoma,
				                                              tipoproducto)
						VALUES('" . mysqli_real_escape_string($this->dbLink,$this->idTomaInventario) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idRemisionRollo) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idProducto) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->norollo) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idRolloOriginal) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idRolloUpdate) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->kilosOriginal) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->kilosUpdate) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->almacenOriginal) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->almacenUpdate) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->existenciaOriginal) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->existenciaUpdate) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->fecha_captura) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_captura) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->tipotoma) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->tipoproducto) . "')";
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la insercion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseTomainventariodetalle::Insertar]");
				
				$this->idTomaInventarioDetalle=mysqli_insert_id($this->dbLink);
				return true;
			}
			catch (Exception $e)
			{
				return $this->setErrorCatch($e);
			}
		}
		

		
		protected function Actualizar()
		{
			try
			{
				$SQL="UPDATE " . $this->__tableName . " SET idTomaInventario='" . mysqli_real_escape_string($this->dbLink,$this->idTomaInventario) . "',
	                                              idRemisionRollo='" . mysqli_real_escape_string($this->dbLink,$this->idRemisionRollo) . "',
	                                              idProducto='" . mysqli_real_escape_string($this->dbLink,$this->idProducto) . "',
	                                              norollo='" . mysqli_real_escape_string($this->dbLink,$this->norollo) . "',
	                                              idRolloOriginal='" . mysqli_real_escape_string($this->dbLink,$this->idRolloOriginal) . "',
	                                              idRolloUpdate='" . mysqli_real_escape_string($this->dbLink,$this->idRolloUpdate) . "',
	                                              kilosOriginal='" . mysqli_real_escape_string($this->dbLink,$this->kilosOriginal) . "',
	                                              kilosUpdate='" . mysqli_real_escape_string($this->dbLink,$this->kilosUpdate) . "',
	                                              almacenOriginal='" . mysqli_real_escape_string($this->dbLink,$this->almacenOriginal) . "',
	                                              almacenUpdate='" . mysqli_real_escape_string($this->dbLink,$this->almacenUpdate) . "',
	                                              existenciaOriginal='" . mysqli_real_escape_string($this->dbLink,$this->existenciaOriginal) . "',
	                                              existenciaUpdate='" . mysqli_real_escape_string($this->dbLink,$this->existenciaUpdate) . "',
	                                              fecha_captura='" . mysqli_real_escape_string($this->dbLink,$this->fecha_captura) . "',
	                                              id_usuario_captura='" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_captura) . "',
	                                              tipotoma='" . mysqli_real_escape_string($this->dbLink,$this->tipotoma) . "',
	                                              tipoproducto='" . mysqli_real_escape_string($this->dbLink,$this->tipoproducto) . "'
					WHERE idTomaInventarioDetalle=" . $this->idTomaInventarioDetalle;
				
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la actualizacion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseTomainventariodetalle::Update]");
				
				return true;
			}
			catch (Exception $e)
			{
				return $this->setErrorCatch($e);
			}
		}
		

		
		public function Borrar()
		{
			if($this->getError())
				return false;
			try
			{
				$SQL="DELETE FROM " . $this->__tableName . "
				WHERE idTomaInventarioDetalle=" . mysqli_real_escape_string($this->dbLink,$this->idTomaInventarioDetalle);
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en el borrado de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseTomainventariodetalle::Borrar]");
			}
			catch (Exception $e)
			{
				return $this->setErrorCatch($e);
			}
		}
		

		
		public function getDatos()
		{
			try
			{
				$SQL="SELECT
						idTomaInventarioDetalle,
						idTomaInventario,
						idRemisionRollo,
						idProducto,
						norollo,
						idRolloOriginal,
						idRolloUpdate,
						kilosOriginal,
						kilosUpdate,
						almacenOriginal,
						almacenUpdate,
						existenciaOriginal,
						existenciaUpdate,
						fecha_captura,
						id_usuario_captura,
						tipotoma,
						tipoproducto
					FROM " . $this->__tableName . " 
					WHERE idTomaInventarioDetalle=" . mysqli_real_escape_string($this->dbLink,$this->idTomaInventarioDetalle);
					
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la obtencion de detalles de registro.","[ModeloBaseTomainventariodetalle::getDatos][" . $SQL . "][" . mysqli_error($this->dbLink) . "]");
				

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
		

		
		public function Guardar()
		{
			if(!$this->validarDatos())
				return false;
			if($this->getError())
				return false;
			if($this->idTomaInventarioDetalle==0)
				$this->Insertar();
			else
				$this->Actualizar();
			if($this->getError())
				return false;
			return true;
		}
		
	}

?>