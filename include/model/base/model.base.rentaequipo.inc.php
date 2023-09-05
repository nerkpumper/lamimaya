<?php

	class ModeloBaseRentaequipo extends clsBasicCommon
	{
		#------------------------------------------------------------------------------------------------------#
		#----------------------------------------------Propiedades---------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		var $_nombreClase="base.ModeloBaseRentaequipo";

		
		var $idRentaEquipo=0;
		var $folio='';
		var $fecha_captura='';
		var $nombreOperario1='';
		var $sueldoHr1='';
		var $nombreOperario2='';
		var $sueldoHr2='';
		var $horasTrabajadas='';
		var $ayudante='';
		var $sueldoAyudante='';
		var $tipoCombustible='';
		var $costoLitro='';
		var $litrosConsumidos='';
		var $totalRentaEquipo='';
		var $totaHrsOperario='';
		var $totalCombustible='';
		var $total='';

		var $__s=array("idRentaEquipo",
                       "folio",
                       "fecha_captura",
                       "nombreOperario1",
                       "sueldoHr1",
                       "nombreOperario2",
                       "sueldoHr2",
                       "horasTrabajadas",
                       "ayudante",
                       "sueldoAyudante",
                       "tipoCombustible",
                       "costoLitro",
                       "litrosConsumidos",
                       "totalRentaEquipo",
                       "totaHrsOperario",
                       "totalCombustible",
                       "total");
				
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

		
		public function setIdRentaEquipo($idRentaEquipo)
		{
			if($idRentaEquipo==0||$idRentaEquipo==""||!is_numeric($idRentaEquipo)|| (is_string($idRentaEquipo)&&!ctype_digit($idRentaEquipo)))return $this->setError("Tipo de dato incorrecto para idRentaEquipo.");
			$this->idRentaEquipo=$idRentaEquipo;
			$this->getDatos();
		}
		public function setFolio($folio)
		{
			
			$this->folio=$folio;
		}
		public function setFecha_captura($fecha_captura)
		{
			$this->fecha_captura=$fecha_captura;
		}
		public function setNombreOperario1($nombreOperario1)
		{
			
			$this->nombreOperario1=$nombreOperario1;
		}
		public function setSueldoHr1($sueldoHr1)
		{
			$this->sueldoHr1=$sueldoHr1;
		}
		public function setNombreOperario2($nombreOperario2)
		{
			
			$this->nombreOperario2=$nombreOperario2;
		}
		public function setSueldoHr2($sueldoHr2)
		{
			$this->sueldoHr2=$sueldoHr2;
		}
		public function setHorasTrabajadas($horasTrabajadas)
		{
			$this->horasTrabajadas=$horasTrabajadas;
		}
		public function setAyudante($ayudante)
		{
			
			$this->ayudante=$ayudante;
		}
		public function setSueldoAyudante($sueldoAyudante)
		{
			$this->sueldoAyudante=$sueldoAyudante;
		}
		public function setTipoCombustible($tipoCombustible)
		{
			
			$this->tipoCombustible=$tipoCombustible;
		}
		public function setCostoLitro($costoLitro)
		{
			$this->costoLitro=$costoLitro;
		}
		public function setLitrosConsumidos($litrosConsumidos)
		{
			$this->litrosConsumidos=$litrosConsumidos;
		}
		public function setTotalRentaEquipo($totalRentaEquipo)
		{
			$this->totalRentaEquipo=$totalRentaEquipo;
		}
		public function setTotaHrsOperario($totaHrsOperario)
		{
			$this->totaHrsOperario=$totaHrsOperario;
		}
		public function setTotalCombustible($totalCombustible)
		{
			$this->totalCombustible=$totalCombustible;
		}
		public function setTotal($total)
		{
			$this->total=$total;
		}

		#------------------------------------------------------------------------------------------------------#
		#-----------------------------------------------Unsetter-----------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Getter------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		
		public function getIdRentaEquipo()
		{
			return $this->idRentaEquipo;
		}
		public function getFolio()
		{
			return $this->folio;
		}
		public function getFecha_captura()
		{
			return $this->fecha_captura;
		}
		public function getNombreOperario1()
		{
			return $this->nombreOperario1;
		}
		public function getSueldoHr1()
		{
			return $this->sueldoHr1;
		}
		public function getNombreOperario2()
		{
			return $this->nombreOperario2;
		}
		public function getSueldoHr2()
		{
			return $this->sueldoHr2;
		}
		public function getHorasTrabajadas()
		{
			return $this->horasTrabajadas;
		}
		public function getAyudante()
		{
			return $this->ayudante;
		}
		public function getSueldoAyudante()
		{
			return $this->sueldoAyudante;
		}
		public function getTipoCombustible()
		{
			return $this->tipoCombustible;
		}
		public function getCostoLitro()
		{
			return $this->costoLitro;
		}
		public function getLitrosConsumidos()
		{
			return $this->litrosConsumidos;
		}
		public function getTotalRentaEquipo()
		{
			return $this->totalRentaEquipo;
		}
		public function getTotaHrsOperario()
		{
			return $this->totaHrsOperario;
		}
		public function getTotalCombustible()
		{
			return $this->totalCombustible;
		}
		public function getTotal()
		{
			return $this->total;
		}

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Querys------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Otras-------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		protected function limpiarPropiedades()
		{
			
			$this->idRentaEquipo=0;
			$this->folio='';
			$this->fecha_captura='';
			$this->nombreOperario1='';
			$this->sueldoHr1='';
			$this->nombreOperario2='';
			$this->sueldoHr2='';
			$this->horasTrabajadas='';
			$this->ayudante='';
			$this->sueldoAyudante='';
			$this->tipoCombustible='';
			$this->costoLitro='';
			$this->litrosConsumidos='';
			$this->totalRentaEquipo='';
			$this->totaHrsOperario='';
			$this->totalCombustible='';
			$this->total='';
		}

		

		
		protected function Insertar()
		{
			try
			{
				$SQL="INSERT INTO " . $this->__tableName . " (folio,
				                                              fecha_captura,
				                                              nombreOperario1,
				                                              sueldoHr1,
				                                              nombreOperario2,
				                                              sueldoHr2,
				                                              horasTrabajadas,
				                                              ayudante,
				                                              sueldoAyudante,
				                                              tipoCombustible,
				                                              costoLitro,
				                                              litrosConsumidos,
				                                              totalRentaEquipo,
				                                              totaHrsOperario,
				                                              totalCombustible,
				                                              total)
						VALUES('" . mysqli_real_escape_string($this->dbLink,$this->folio) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->fecha_captura) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->nombreOperario1) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->sueldoHr1) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->nombreOperario2) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->sueldoHr2) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->horasTrabajadas) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->ayudante) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->sueldoAyudante) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->tipoCombustible) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->costoLitro) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->litrosConsumidos) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->totalRentaEquipo) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->totaHrsOperario) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->totalCombustible) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->total) . "')";
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la insercion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseRentaequipo::Insertar]");
				
				$this->idRentaEquipo=mysqli_insert_id($this->dbLink);
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
				$SQL="UPDATE " . $this->__tableName . " SET folio='" . mysqli_real_escape_string($this->dbLink,$this->folio) . "',
	                                              fecha_captura='" . mysqli_real_escape_string($this->dbLink,$this->fecha_captura) . "',
	                                              nombreOperario1='" . mysqli_real_escape_string($this->dbLink,$this->nombreOperario1) . "',
	                                              sueldoHr1='" . mysqli_real_escape_string($this->dbLink,$this->sueldoHr1) . "',
	                                              nombreOperario2='" . mysqli_real_escape_string($this->dbLink,$this->nombreOperario2) . "',
	                                              sueldoHr2='" . mysqli_real_escape_string($this->dbLink,$this->sueldoHr2) . "',
	                                              horasTrabajadas='" . mysqli_real_escape_string($this->dbLink,$this->horasTrabajadas) . "',
	                                              ayudante='" . mysqli_real_escape_string($this->dbLink,$this->ayudante) . "',
	                                              sueldoAyudante='" . mysqli_real_escape_string($this->dbLink,$this->sueldoAyudante) . "',
	                                              tipoCombustible='" . mysqli_real_escape_string($this->dbLink,$this->tipoCombustible) . "',
	                                              costoLitro='" . mysqli_real_escape_string($this->dbLink,$this->costoLitro) . "',
	                                              litrosConsumidos='" . mysqli_real_escape_string($this->dbLink,$this->litrosConsumidos) . "',
	                                              totalRentaEquipo='" . mysqli_real_escape_string($this->dbLink,$this->totalRentaEquipo) . "',
	                                              totaHrsOperario='" . mysqli_real_escape_string($this->dbLink,$this->totaHrsOperario) . "',
	                                              totalCombustible='" . mysqli_real_escape_string($this->dbLink,$this->totalCombustible) . "',
	                                              total='" . mysqli_real_escape_string($this->dbLink,$this->total) . "'
					WHERE idRentaEquipo=" . $this->idRentaEquipo;
				
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la actualizacion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseRentaequipo::Update]");
				
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
				WHERE idRentaEquipo=" . mysqli_real_escape_string($this->dbLink,$this->idRentaEquipo);
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en el borrado de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseRentaequipo::Borrar]");
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
						idRentaEquipo,
						folio,
						fecha_captura,
						nombreOperario1,
						sueldoHr1,
						nombreOperario2,
						sueldoHr2,
						horasTrabajadas,
						ayudante,
						sueldoAyudante,
						tipoCombustible,
						costoLitro,
						litrosConsumidos,
						totalRentaEquipo,
						totaHrsOperario,
						totalCombustible,
						total
					FROM " . $this->__tableName . " 
					WHERE idRentaEquipo=" . mysqli_real_escape_string($this->dbLink,$this->idRentaEquipo);
					
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la obtencion de detalles de registro.","[ModeloBaseRentaequipo::getDatos][" . $SQL . "][" . mysqli_error($this->dbLink) . "]");
				

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
			if($this->idRentaEquipo==0)
				$this->Insertar();
			else
				$this->Actualizar();
			if($this->getError())
				return false;
			return true;
		}
		
	}

?>