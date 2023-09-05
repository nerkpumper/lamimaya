<?php

	class ModeloBaseRemisionrollohistory extends clsBasicCommon
	{
		#------------------------------------------------------------------------------------------------------#
		#----------------------------------------------Propiedades---------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		var $_nombreClase="base.ModeloBaseRemisionrollohistory";

		
		var $idRemisionRolloHistory=0;
		var $idRemisionRollo=0;
		var $remision='0';
		var $remisionRollo_rollo_idRollo=0;
		var $noRollo='0';
		var $kilos='0.00';
		var $existencia='0.00';
		var $almacen='ALMACEN A';
		var $almacenOriginal='ALMACEN A';
		var $idPedidoObra=0;
		var $comprador='GALVAMEX';
		var $fecha='0';
		var $hora='0';
		var $remisionRollo_usuario_idUsuario=0;
		var $ts='';
		var $norollooriginal='';
		var $idrollooriginal=0;
		var $usuario_baja=0;
		var $fecha_baja='0000-00-00';
		var $estado='ACTIVO';
		var $fecha_update='0000-00-00 00:00:00';
		var $costokg='0.00';

		var $__s=array("idRemisionRolloHistory",
                       "idRemisionRollo",
                       "remision",
                       "remisionRollo_rollo_idRollo",
                       "noRollo",
                       "kilos",
                       "existencia",
                       "almacen",
                       "almacenOriginal",
                       "idPedidoObra",
                       "comprador",
                       "fecha",
                       "hora",
                       "remisionRollo_usuario_idUsuario",
                       "ts",
                       "norollooriginal",
                       "idrollooriginal",
                       "usuario_baja",
                       "fecha_baja",
                       "estado",
                       "fecha_update",
                       "costokg");
				
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

		
		public function setIdRemisionRolloHistory($idRemisionRolloHistory)
		{
			if($idRemisionRolloHistory==0||$idRemisionRolloHistory==""||!is_numeric($idRemisionRolloHistory)|| (is_string($idRemisionRolloHistory)&&!ctype_digit($idRemisionRolloHistory)))return $this->setError("Tipo de dato incorrecto para idRemisionRolloHistory.");
			$this->idRemisionRolloHistory=$idRemisionRolloHistory;
			$this->getDatos();
		}
		public function setIdRemisionRollo($idRemisionRollo)
		{
			
			$this->idRemisionRollo=$idRemisionRollo;
		}
		public function setRemision($remision)
		{
			
			$this->remision=$remision;
		}
		public function setRemisionRollo_rollo_idRollo($remisionRollo_rollo_idRollo)
		{
			
			$this->remisionRollo_rollo_idRollo=$remisionRollo_rollo_idRollo;
		}
		public function setNoRollo($noRollo)
		{
			
			$this->noRollo=$noRollo;
		}
		public function setKilos($kilos)
		{
			$this->kilos=$kilos;
		}
		public function setExistencia($existencia)
		{
			$this->existencia=$existencia;
		}
		public function setAlmacen($almacen)
		{
			
			$this->almacen=$almacen;
		}
		public function setAlmacenALMACENA()
		{
			$this->almacen='ALMACEN A';
		}
		public function setAlmacenALMACENB()
		{
			$this->almacen='ALMACEN B';
		}
		public function setAlmacenALMACENPRINCIPAL()
		{
			$this->almacen='ALMACEN PRINCIPAL';
		}
		public function setAlmacenMCM()
		{
			$this->almacen='MCM';
		}
		public function setAlmacenALPES()
		{
			$this->almacen='ALPES';
		}
		public function setAlmacenCASA()
		{
			$this->almacen='CASA';
		}
		public function setAlmacenNARCISO()
		{
			$this->almacen='NARCISO';
		}
		public function setAlmacenDELTA()
		{
			$this->almacen='DELTA';
		}
		public function setAlmacenOBRA()
		{
			$this->almacen='OBRA';
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
		public function setAlmacenOriginalDELTA()
		{
			$this->almacenOriginal='DELTA';
		}
		public function setIdPedidoObra($idPedidoObra)
		{
			
			$this->idPedidoObra=$idPedidoObra;
		}
		public function setComprador($comprador)
		{
			
			$this->comprador=$comprador;
		}
		public function setCompradorGALVAMEX()
		{
			$this->comprador='GALVAMEX';
		}
		public function setCompradorMENDEZ()
		{
			$this->comprador='MENDEZ';
		}
		public function setFecha($fecha)
		{
			
			$this->fecha=$fecha;
		}
		public function setHora($hora)
		{
			
			$this->hora=$hora;
		}
		public function setRemisionRollo_usuario_idUsuario($remisionRollo_usuario_idUsuario)
		{
			
			$this->remisionRollo_usuario_idUsuario=$remisionRollo_usuario_idUsuario;
		}
		public function setTs($ts)
		{
			$this->ts=$ts;
		}
		public function setNorollooriginal($norollooriginal)
		{
			
			$this->norollooriginal=$norollooriginal;
		}
		public function setIdrollooriginal($idrollooriginal)
		{
			
			$this->idrollooriginal=$idrollooriginal;
		}
		public function setUsuario_baja($usuario_baja)
		{
			
			$this->usuario_baja=$usuario_baja;
		}
		public function setFecha_baja($fecha_baja)
		{
			$this->fecha_baja=$fecha_baja;
		}
		public function setEstado($estado)
		{
			
			$this->estado=$estado;
		}
		public function setEstadoACTIVO()
		{
			$this->estado='ACTIVO';
		}
		public function setEstadoPRODUCCION()
		{
			$this->estado='PRODUCCION';
		}
		public function setEstadoTERMINADO()
		{
			$this->estado='TERMINADO';
		}
		public function setEstadoBAJA()
		{
			$this->estado='BAJA';
		}
		public function setFecha_update($fecha_update)
		{
			$this->fecha_update=$fecha_update;
		}
		public function setCostokg($costokg)
		{
			$this->costokg=$costokg;
		}

		#------------------------------------------------------------------------------------------------------#
		#-----------------------------------------------Unsetter-----------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Getter------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		
		public function getIdRemisionRolloHistory()
		{
			return $this->idRemisionRolloHistory;
		}
		public function getIdRemisionRollo()
		{
			return $this->idRemisionRollo;
		}
		public function getRemision()
		{
			return $this->remision;
		}
		public function getRemisionRollo_rollo_idRollo()
		{
			return $this->remisionRollo_rollo_idRollo;
		}
		public function getNoRollo()
		{
			return $this->noRollo;
		}
		public function getKilos()
		{
			return $this->kilos;
		}
		public function getExistencia()
		{
			return $this->existencia;
		}
		public function getAlmacen()
		{
			return $this->almacen;
		}
		public function getAlmacenOriginal()
		{
			return $this->almacenOriginal;
		}
		public function getIdPedidoObra()
		{
			return $this->idPedidoObra;
		}
		public function getComprador()
		{
			return $this->comprador;
		}
		public function getFecha()
		{
			return $this->fecha;
		}
		public function getHora()
		{
			return $this->hora;
		}
		public function getRemisionRollo_usuario_idUsuario()
		{
			return $this->remisionRollo_usuario_idUsuario;
		}
		public function getTs()
		{
			return $this->ts;
		}
		public function getNorollooriginal()
		{
			return $this->norollooriginal;
		}
		public function getIdrollooriginal()
		{
			return $this->idrollooriginal;
		}
		public function getUsuario_baja()
		{
			return $this->usuario_baja;
		}
		public function getFecha_baja()
		{
			return $this->fecha_baja;
		}
		public function getEstado()
		{
			return $this->estado;
		}
		public function getFecha_update()
		{
			return $this->fecha_update;
		}
		public function getCostokg()
		{
			return $this->costokg;
		}

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Querys------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Otras-------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		protected function limpiarPropiedades()
		{
			
			$this->idRemisionRolloHistory=0;
			$this->idRemisionRollo=0;
			$this->remision='0';
			$this->remisionRollo_rollo_idRollo=0;
			$this->noRollo='0';
			$this->kilos='0.00';
			$this->existencia='0.00';
			$this->almacen='ALMACEN A';
			$this->almacenOriginal='ALMACEN A';
			$this->idPedidoObra=0;
			$this->comprador='GALVAMEX';
			$this->fecha='0';
			$this->hora='0';
			$this->remisionRollo_usuario_idUsuario=0;
			$this->ts='';
			$this->norollooriginal='';
			$this->idrollooriginal=0;
			$this->usuario_baja=0;
			$this->fecha_baja='0000-00-00';
			$this->estado='ACTIVO';
			$this->fecha_update='0000-00-00 00:00:00';
			$this->costokg='0.00';
		}

		

		
		protected function Insertar()
		{
			try
			{
				$SQL="INSERT INTO " . $this->__tableName . " (idRemisionRollo,
				                                              remision,
				                                              remisionRollo_rollo_idRollo,
				                                              noRollo,
				                                              kilos,
				                                              existencia,
				                                              almacen,
				                                              almacenOriginal,
				                                              idPedidoObra,
				                                              comprador,
				                                              fecha,
				                                              hora,
				                                              remisionRollo_usuario_idUsuario,
				                                              ts,
				                                              norollooriginal,
				                                              idrollooriginal,
				                                              usuario_baja,
				                                              fecha_baja,
				                                              estado,
				                                              fecha_update,
				                                              costokg)
						VALUES('" . mysqli_real_escape_string($this->dbLink,$this->idRemisionRollo) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->remision) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->remisionRollo_rollo_idRollo) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->noRollo) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->kilos) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->existencia) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->almacen) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->almacenOriginal) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idPedidoObra) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->comprador) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->fecha) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->hora) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->remisionRollo_usuario_idUsuario) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->ts) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->norollooriginal) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idrollooriginal) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->usuario_baja) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->fecha_baja) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->estado) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->fecha_update) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->costokg) . "')";
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la insercion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseRemisionrollohistory::Insertar]");
				
				$this->idRemisionRolloHistory=mysqli_insert_id($this->dbLink);
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
				$SQL="UPDATE " . $this->__tableName . " SET idRemisionRollo='" . mysqli_real_escape_string($this->dbLink,$this->idRemisionRollo) . "',
	                                              remision='" . mysqli_real_escape_string($this->dbLink,$this->remision) . "',
	                                              remisionRollo_rollo_idRollo='" . mysqli_real_escape_string($this->dbLink,$this->remisionRollo_rollo_idRollo) . "',
	                                              noRollo='" . mysqli_real_escape_string($this->dbLink,$this->noRollo) . "',
	                                              kilos='" . mysqli_real_escape_string($this->dbLink,$this->kilos) . "',
	                                              existencia='" . mysqli_real_escape_string($this->dbLink,$this->existencia) . "',
	                                              almacen='" . mysqli_real_escape_string($this->dbLink,$this->almacen) . "',
	                                              almacenOriginal='" . mysqli_real_escape_string($this->dbLink,$this->almacenOriginal) . "',
	                                              idPedidoObra='" . mysqli_real_escape_string($this->dbLink,$this->idPedidoObra) . "',
	                                              comprador='" . mysqli_real_escape_string($this->dbLink,$this->comprador) . "',
	                                              fecha='" . mysqli_real_escape_string($this->dbLink,$this->fecha) . "',
	                                              hora='" . mysqli_real_escape_string($this->dbLink,$this->hora) . "',
	                                              remisionRollo_usuario_idUsuario='" . mysqli_real_escape_string($this->dbLink,$this->remisionRollo_usuario_idUsuario) . "',
	                                              ts='" . mysqli_real_escape_string($this->dbLink,$this->ts) . "',
	                                              norollooriginal='" . mysqli_real_escape_string($this->dbLink,$this->norollooriginal) . "',
	                                              idrollooriginal='" . mysqli_real_escape_string($this->dbLink,$this->idrollooriginal) . "',
	                                              usuario_baja='" . mysqli_real_escape_string($this->dbLink,$this->usuario_baja) . "',
	                                              fecha_baja='" . mysqli_real_escape_string($this->dbLink,$this->fecha_baja) . "',
	                                              estado='" . mysqli_real_escape_string($this->dbLink,$this->estado) . "',
	                                              fecha_update='" . mysqli_real_escape_string($this->dbLink,$this->fecha_update) . "',
	                                              costokg='" . mysqli_real_escape_string($this->dbLink,$this->costokg) . "'
					WHERE idRemisionRolloHistory=" . $this->idRemisionRolloHistory;
				
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la actualizacion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseRemisionrollohistory::Update]");
				
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
				WHERE idRemisionRolloHistory=" . mysqli_real_escape_string($this->dbLink,$this->idRemisionRolloHistory);
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en el borrado de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseRemisionrollohistory::Borrar]");
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
						idRemisionRolloHistory,
						idRemisionRollo,
						remision,
						remisionRollo_rollo_idRollo,
						noRollo,
						kilos,
						existencia,
						almacen,
						almacenOriginal,
						idPedidoObra,
						comprador,
						fecha,
						hora,
						remisionRollo_usuario_idUsuario,
						ts,
						norollooriginal,
						idrollooriginal,
						usuario_baja,
						fecha_baja,
						estado,
						fecha_update,
						costokg
					FROM " . $this->__tableName . " 
					WHERE idRemisionRolloHistory=" . mysqli_real_escape_string($this->dbLink,$this->idRemisionRolloHistory);
					
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la obtencion de detalles de registro.","[ModeloBaseRemisionrollohistory::getDatos][" . $SQL . "][" . mysqli_error($this->dbLink) . "]");
				

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
			if($this->idRemisionRolloHistory==0)
				$this->Insertar();
			else
				$this->Actualizar();
			if($this->getError())
				return false;
			return true;
		}
		
	}

?>