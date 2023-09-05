<?php

	class ModeloBaseRegistroproduccion extends clsBasicCommon
	{
		#------------------------------------------------------------------------------------------------------#
		#----------------------------------------------Propiedades---------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		var $_nombreClase="base.ModeloBaseRegistroproduccion";

		
		var $idRegistroProduccion=0;
		var $idRemisionRollo=0;
		var $consecutivoNoRollo=0;
		var $kilos='0.00';
		var $kilosMaquilados='0.00';
		var $totalml='0.00';
		var $factor='0.00';
		var $rendimiento='0.00';
		var $terminado='NO';
		var $fecha_creacion='0000-00-00 00:00:00';
		var $id_usuario_creacion=0;
		var $fecha_termina='0000-00-00 00:00:00';
		var $id_usuario_termina=0;
		var $espesor='0';
		var $largoRollo='0';

		var $__s=array("idRegistroProduccion",
                       "idRemisionRollo",
                       "consecutivoNoRollo",
                       "kilos",
                       "kilosMaquilados",
                       "totalml",
                       "factor",
                       "rendimiento",
                       "terminado",
                       "fecha_creacion",
                       "id_usuario_creacion",
                       "fecha_termina",
                       "id_usuario_termina",
                       "espesor",
                       "largoRollo");
				
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

		
		public function setIdRegistroProduccion($idRegistroProduccion)
		{
			if($idRegistroProduccion==0||$idRegistroProduccion==""||!is_numeric($idRegistroProduccion)|| (is_string($idRegistroProduccion)&&!ctype_digit($idRegistroProduccion)))return $this->setError("Tipo de dato incorrecto para idRegistroProduccion.");
			$this->idRegistroProduccion=$idRegistroProduccion;
			$this->getDatos();
		}
		public function setIdRemisionRollo($idRemisionRollo)
		{
			
			$this->idRemisionRollo=$idRemisionRollo;
		}
		public function setConsecutivoNoRollo($consecutivoNoRollo)
		{
			
			$this->consecutivoNoRollo=$consecutivoNoRollo;
		}
		public function setKilos($kilos)
		{
			$this->kilos=$kilos;
		}
		public function setKilosMaquilados($kilosMaquilados)
		{
			$this->kilosMaquilados=$kilosMaquilados;
		}
		public function setTotalml($totalml)
		{
			$this->totalml=$totalml;
		}
		public function setFactor($factor)
		{
			$this->factor=$factor;
		}
		public function setRendimiento($rendimiento)
		{
			$this->rendimiento=$rendimiento;
		}
		public function setTerminado($terminado)
		{
			
			$this->terminado=$terminado;
		}
		public function setTerminadoSI()
		{
			$this->terminado='SI';
		}
		public function setTerminadoNO()
		{
			$this->terminado='NO';
		}
		public function setFecha_creacion($fecha_creacion)
		{
			$this->fecha_creacion=$fecha_creacion;
		}
		public function setId_usuario_creacion($id_usuario_creacion)
		{
			
			$this->id_usuario_creacion=$id_usuario_creacion;
		}
		public function setFecha_termina($fecha_termina)
		{
			$this->fecha_termina=$fecha_termina;
		}
		public function setId_usuario_termina($id_usuario_termina)
		{
			
			$this->id_usuario_termina=$id_usuario_termina;
		}
		public function setEspesor($espesor)
		{
			$this->espesor=$espesor;
		}
		public function setLargoRollo($largoRollo)
		{
			$this->largoRollo=$largoRollo;
		}

		#------------------------------------------------------------------------------------------------------#
		#-----------------------------------------------Unsetter-----------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Getter------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		
		public function getIdRegistroProduccion()
		{
			return $this->idRegistroProduccion;
		}
		public function getIdRemisionRollo()
		{
			return $this->idRemisionRollo;
		}
		public function getConsecutivoNoRollo()
		{
			return $this->consecutivoNoRollo;
		}
		public function getKilos()
		{
			return $this->kilos;
		}
		public function getKilosMaquilados()
		{
			return $this->kilosMaquilados;
		}
		public function getTotalml()
		{
			return $this->totalml;
		}
		public function getFactor()
		{
			return $this->factor;
		}
		public function getRendimiento()
		{
			return $this->rendimiento;
		}
		public function getTerminado()
		{
			return $this->terminado;
		}
		public function getFecha_creacion()
		{
			return $this->fecha_creacion;
		}
		public function getId_usuario_creacion()
		{
			return $this->id_usuario_creacion;
		}
		public function getFecha_termina()
		{
			return $this->fecha_termina;
		}
		public function getId_usuario_termina()
		{
			return $this->id_usuario_termina;
		}
		public function getEspesor()
		{
			return $this->espesor;
		}
		public function getLargoRollo()
		{
			return $this->largoRollo;
		}

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Querys------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Otras-------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		protected function limpiarPropiedades()
		{
			
			$this->idRegistroProduccion=0;
			$this->idRemisionRollo=0;
			$this->consecutivoNoRollo=0;
			$this->kilos='0.00';
			$this->kilosMaquilados='0.00';
			$this->totalml='0.00';
			$this->factor='0.00';
			$this->rendimiento='0.00';
			$this->terminado='NO';
			$this->fecha_creacion='0000-00-00 00:00:00';
			$this->id_usuario_creacion=0;
			$this->fecha_termina='0000-00-00 00:00:00';
			$this->id_usuario_termina=0;
			$this->espesor='0';
			$this->largoRollo='0';
		}

		

		
		protected function Insertar()
		{
			try
			{
				$SQL="INSERT INTO " . $this->__tableName . " (idRemisionRollo,
				                                              consecutivoNoRollo,
				                                              kilos,
				                                              kilosMaquilados,
				                                              totalml,
				                                              factor,
				                                              rendimiento,
				                                              terminado,
				                                              fecha_creacion,
				                                              id_usuario_creacion,
				                                              fecha_termina,
				                                              id_usuario_termina,
				                                              espesor,
				                                              largoRollo)
						VALUES('" . mysqli_real_escape_string($this->dbLink,$this->idRemisionRollo) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->consecutivoNoRollo) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->kilos) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->kilosMaquilados) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->totalml) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->factor) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->rendimiento) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->terminado) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->fecha_creacion) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_creacion) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->fecha_termina) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_termina) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->espesor) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->largoRollo) . "')";
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la insercion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseRegistroproduccion::Insertar]");
				
				$this->idRegistroProduccion=mysqli_insert_id($this->dbLink);
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
	                                              consecutivoNoRollo='" . mysqli_real_escape_string($this->dbLink,$this->consecutivoNoRollo) . "',
	                                              kilos='" . mysqli_real_escape_string($this->dbLink,$this->kilos) . "',
	                                              kilosMaquilados='" . mysqli_real_escape_string($this->dbLink,$this->kilosMaquilados) . "',
	                                              totalml='" . mysqli_real_escape_string($this->dbLink,$this->totalml) . "',
	                                              factor='" . mysqli_real_escape_string($this->dbLink,$this->factor) . "',
	                                              rendimiento='" . mysqli_real_escape_string($this->dbLink,$this->rendimiento) . "',
	                                              terminado='" . mysqli_real_escape_string($this->dbLink,$this->terminado) . "',
	                                              fecha_creacion='" . mysqli_real_escape_string($this->dbLink,$this->fecha_creacion) . "',
	                                              id_usuario_creacion='" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_creacion) . "',
	                                              fecha_termina='" . mysqli_real_escape_string($this->dbLink,$this->fecha_termina) . "',
	                                              id_usuario_termina='" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_termina) . "',
	                                              espesor='" . mysqli_real_escape_string($this->dbLink,$this->espesor) . "',
	                                              largoRollo='" . mysqli_real_escape_string($this->dbLink,$this->largoRollo) . "'
					WHERE idRegistroProduccion=" . $this->idRegistroProduccion;
				
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la actualizacion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseRegistroproduccion::Update]");
				
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
				WHERE idRegistroProduccion=" . mysqli_real_escape_string($this->dbLink,$this->idRegistroProduccion);
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en el borrado de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseRegistroproduccion::Borrar]");
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
						idRegistroProduccion,
						idRemisionRollo,
						consecutivoNoRollo,
						kilos,
						kilosMaquilados,
						totalml,
						factor,
						rendimiento,
						terminado,
						fecha_creacion,
						id_usuario_creacion,
						fecha_termina,
						id_usuario_termina,
						espesor,
						largoRollo
					FROM " . $this->__tableName . " 
					WHERE idRegistroProduccion=" . mysqli_real_escape_string($this->dbLink,$this->idRegistroProduccion);
					
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la obtencion de detalles de registro.","[ModeloBaseRegistroproduccion::getDatos][" . $SQL . "][" . mysqli_error($this->dbLink) . "]");
				

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
			if($this->idRegistroProduccion==0)
				$this->Insertar();
			else
				$this->Actualizar();
			if($this->getError())
				return false;
			return true;
		}
		
	}

?>