<?php

	class ModeloBaseCortecaja extends clsBasicCommon
	{
		#------------------------------------------------------------------------------------------------------#
		#----------------------------------------------Propiedades---------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		var $_nombreClase="base.ModeloBaseCortecaja";

		
		var $idCorteCaja=0;
		var $fondoCajaApertura='0.00';
		var $ventas='0.00';
		var $abonos='0.00';
		var $entradas='0.00';
		var $salidas='0.00';
		var $fondoCajaAlCorte='0.00';
		var $idSucursal=0;
		var $estado='ABIERTO';
		var $id_usuario_apertura=0;
		var $fecha_apertura='0000-00-00 00:00:00';
		var $id_usuario_corte=0;
		var $fecha_corte='0000-00-00 00:00:00';

		var $__s=array("idCorteCaja",
                       "fondoCajaApertura",
                       "ventas",
                       "abonos",
                       "entradas",
                       "salidas",
                       "fondoCajaAlCorte",
                       "idSucursal",
                       "estado",
                       "id_usuario_apertura",
                       "fecha_apertura",
                       "id_usuario_corte",
                       "fecha_corte");
				
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

		
		public function setIdCorteCaja($idCorteCaja)
		{
			if($idCorteCaja==0||$idCorteCaja==""||!is_numeric($idCorteCaja)|| (is_string($idCorteCaja)&&!ctype_digit($idCorteCaja)))return $this->setError("Tipo de dato incorrecto para idCorteCaja.");
			$this->idCorteCaja=$idCorteCaja;
			$this->getDatos();
		}
		public function setFondoCajaApertura($fondoCajaApertura)
		{
			$this->fondoCajaApertura=$fondoCajaApertura;
		}
		public function setVentas($ventas)
		{
			$this->ventas=$ventas;
		}
		public function setAbonos($abonos)
		{
			$this->abonos=$abonos;
		}
		public function setEntradas($entradas)
		{
			$this->entradas=$entradas;
		}
		public function setSalidas($salidas)
		{
			$this->salidas=$salidas;
		}
		public function setFondoCajaAlCorte($fondoCajaAlCorte)
		{
			$this->fondoCajaAlCorte=$fondoCajaAlCorte;
		}
		public function setIdSucursal($idSucursal)
		{
			
			$this->idSucursal=$idSucursal;
		}
		public function setEstado($estado)
		{
			
			$this->estado=$estado;
		}
		public function setEstadoREALIZADO()
		{
			$this->estado='REALIZADO';
		}
		public function setEstadoABIERTO()
		{
			$this->estado='ABIERTO';
		}
		public function setId_usuario_apertura($id_usuario_apertura)
		{
			
			$this->id_usuario_apertura=$id_usuario_apertura;
		}
		public function setFecha_apertura($fecha_apertura)
		{
			$this->fecha_apertura=$fecha_apertura;
		}
		public function setId_usuario_corte($id_usuario_corte)
		{
			
			$this->id_usuario_corte=$id_usuario_corte;
		}
		public function setFecha_corte($fecha_corte)
		{
			$this->fecha_corte=$fecha_corte;
		}

		#------------------------------------------------------------------------------------------------------#
		#-----------------------------------------------Unsetter-----------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Getter------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		
		public function getIdCorteCaja()
		{
			return $this->idCorteCaja;
		}
		public function getFondoCajaApertura()
		{
			return $this->fondoCajaApertura;
		}
		public function getVentas()
		{
			return $this->ventas;
		}
		public function getAbonos()
		{
			return $this->abonos;
		}
		public function getEntradas()
		{
			return $this->entradas;
		}
		public function getSalidas()
		{
			return $this->salidas;
		}
		public function getFondoCajaAlCorte()
		{
			return $this->fondoCajaAlCorte;
		}
		public function getIdSucursal()
		{
			return $this->idSucursal;
		}
		public function getEstado()
		{
			return $this->estado;
		}
		public function getId_usuario_apertura()
		{
			return $this->id_usuario_apertura;
		}
		public function getFecha_apertura()
		{
			return $this->fecha_apertura;
		}
		public function getId_usuario_corte()
		{
			return $this->id_usuario_corte;
		}
		public function getFecha_corte()
		{
			return $this->fecha_corte;
		}

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Querys------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Otras-------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		protected function limpiarPropiedades()
		{
			
			$this->idCorteCaja=0;
			$this->fondoCajaApertura='0.00';
			$this->ventas='0.00';
			$this->abonos='0.00';
			$this->entradas='0.00';
			$this->salidas='0.00';
			$this->fondoCajaAlCorte='0.00';
			$this->idSucursal=0;
			$this->estado='ABIERTO';
			$this->id_usuario_apertura=0;
			$this->fecha_apertura='0000-00-00 00:00:00';
			$this->id_usuario_corte=0;
			$this->fecha_corte='0000-00-00 00:00:00';
		}

		

		
		protected function Insertar()
		{
			try
			{
				$SQL="INSERT INTO " . $this->__tableName . " (fondoCajaApertura,
				                                              ventas,
				                                              abonos,
				                                              entradas,
				                                              salidas,
				                                              fondoCajaAlCorte,
				                                              idSucursal,
				                                              estado,
				                                              id_usuario_apertura,
				                                              fecha_apertura,
				                                              id_usuario_corte,
				                                              fecha_corte)
						VALUES('" . mysqli_real_escape_string($this->dbLink,$this->fondoCajaApertura) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->ventas) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->abonos) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->entradas) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->salidas) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->fondoCajaAlCorte) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idSucursal) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->estado) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_apertura) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->fecha_apertura) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_corte) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->fecha_corte) . "')";
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la insercion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseCortecaja::Insertar]");
				
				$this->idCorteCaja=mysqli_insert_id($this->dbLink);
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
				$SQL="UPDATE " . $this->__tableName . " SET fondoCajaApertura='" . mysqli_real_escape_string($this->dbLink,$this->fondoCajaApertura) . "',
	                                              ventas='" . mysqli_real_escape_string($this->dbLink,$this->ventas) . "',
	                                              abonos='" . mysqli_real_escape_string($this->dbLink,$this->abonos) . "',
	                                              entradas='" . mysqli_real_escape_string($this->dbLink,$this->entradas) . "',
	                                              salidas='" . mysqli_real_escape_string($this->dbLink,$this->salidas) . "',
	                                              fondoCajaAlCorte='" . mysqli_real_escape_string($this->dbLink,$this->fondoCajaAlCorte) . "',
	                                              idSucursal='" . mysqli_real_escape_string($this->dbLink,$this->idSucursal) . "',
	                                              estado='" . mysqli_real_escape_string($this->dbLink,$this->estado) . "',
	                                              id_usuario_apertura='" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_apertura) . "',
	                                              fecha_apertura='" . mysqli_real_escape_string($this->dbLink,$this->fecha_apertura) . "',
	                                              id_usuario_corte='" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_corte) . "',
	                                              fecha_corte='" . mysqli_real_escape_string($this->dbLink,$this->fecha_corte) . "'
					WHERE idCorteCaja=" . $this->idCorteCaja;
				
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la actualizacion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseCortecaja::Update]");
				
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
				WHERE idCorteCaja=" . mysqli_real_escape_string($this->dbLink,$this->idCorteCaja);
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en el borrado de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseCortecaja::Borrar]");
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
						idCorteCaja,
						fondoCajaApertura,
						ventas,
						abonos,
						entradas,
						salidas,
						fondoCajaAlCorte,
						idSucursal,
						estado,
						id_usuario_apertura,
						fecha_apertura,
						id_usuario_corte,
						fecha_corte
					FROM " . $this->__tableName . " 
					WHERE idCorteCaja=" . mysqli_real_escape_string($this->dbLink,$this->idCorteCaja);
					
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la obtencion de detalles de registro.","[ModeloBaseCortecaja::getDatos][" . $SQL . "][" . mysqli_error($this->dbLink) . "]");
				

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
			if($this->idCorteCaja==0)
				$this->Insertar();
			else
				$this->Actualizar();
			if($this->getError())
				return false;
			return true;
		}
		
	}

?>