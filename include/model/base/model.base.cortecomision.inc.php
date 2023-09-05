<?php

	class ModeloBaseCortecomision extends clsBasicCommon
	{
		#------------------------------------------------------------------------------------------------------#
		#----------------------------------------------Propiedades---------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		var $_nombreClase="base.ModeloBaseCortecomision";

		
		var $idCorteComision=0;
		var $tipo='M';
		var $anio=0;
		var $mes=0;
		var $idPromotor=0;
		var $fecha_creacion='0000-00-00 00:00:00';
		var $id_usuario_creacion=0;
		var $total='0.00';
		var $porcentajeObjetivoVenta='0.00';
		var $incentivo='0.00';
		var $comisionAdelantada='0.00';
		var $aPagar='0.00';
		var $saldo='0.00';
		var $fechaInicio='';
		var $fechaFin='';
		var $pagada='NO';
		var $fecha_pagada='0000-00-00 00:00:00';
		var $id_usuario_pagada=0;

		var $__s=array("idCorteComision",
                       "tipo",
                       "anio",
                       "mes",
                       "idPromotor",
                       "fecha_creacion",
                       "id_usuario_creacion",
                       "total",
                       "porcentajeObjetivoVenta",
                       "incentivo",
                       "comisionAdelantada",
                       "aPagar",
                       "saldo",
                       "fechaInicio",
                       "fechaFin",
                       "pagada",
                       "fecha_pagada",
                       "id_usuario_pagada");
				
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

		
		public function setIdCorteComision($idCorteComision)
		{
			if($idCorteComision==0||$idCorteComision==""||!is_numeric($idCorteComision)|| (is_string($idCorteComision)&&!ctype_digit($idCorteComision)))return $this->setError("Tipo de dato incorrecto para idCorteComision.");
			$this->idCorteComision=$idCorteComision;
			$this->getDatos();
		}
		public function setTipo($tipo)
		{
			
			$this->tipo=$tipo;
		}
		public function setTipoM()
		{
			$this->tipo='M';
		}
		public function setTipoT()
		{
			$this->tipo='T';
		}
		public function setTipoA()
		{
			$this->tipo='A';
		}
		public function setAnio($anio)
		{
			
			$this->anio=$anio;
		}
		public function setMes($mes)
		{
			
			$this->mes=$mes;
		}
		public function setIdPromotor($idPromotor)
		{
			
			$this->idPromotor=$idPromotor;
		}
		public function setFecha_creacion($fecha_creacion)
		{
			$this->fecha_creacion=$fecha_creacion;
		}
		public function setId_usuario_creacion($id_usuario_creacion)
		{
			
			$this->id_usuario_creacion=$id_usuario_creacion;
		}
		public function setTotal($total)
		{
			$this->total=$total;
		}
		public function setPorcentajeObjetivoVenta($porcentajeObjetivoVenta)
		{
			$this->porcentajeObjetivoVenta=$porcentajeObjetivoVenta;
		}
		public function setIncentivo($incentivo)
		{
			$this->incentivo=$incentivo;
		}
		public function setComisionAdelantada($comisionAdelantada)
		{
			$this->comisionAdelantada=$comisionAdelantada;
		}
		public function setAPagar($aPagar)
		{
			$this->aPagar=$aPagar;
		}
		public function setSaldo($saldo)
		{
			$this->saldo=$saldo;
		}
		public function setFechaInicio($fechaInicio)
		{
			
			$this->fechaInicio=$fechaInicio;
		}
		public function setFechaFin($fechaFin)
		{
			
			$this->fechaFin=$fechaFin;
		}
		public function setPagada($pagada)
		{
			
			$this->pagada=$pagada;
		}
		public function setPagadaNO()
		{
			$this->pagada='NO';
		}
		public function setPagadaSI()
		{
			$this->pagada='SI';
		}
		public function setFecha_pagada($fecha_pagada)
		{
			$this->fecha_pagada=$fecha_pagada;
		}
		public function setId_usuario_pagada($id_usuario_pagada)
		{
			
			$this->id_usuario_pagada=$id_usuario_pagada;
		}

		#------------------------------------------------------------------------------------------------------#
		#-----------------------------------------------Unsetter-----------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Getter------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		
		public function getIdCorteComision()
		{
			return $this->idCorteComision;
		}
		public function getTipo()
		{
			return $this->tipo;
		}
		public function getAnio()
		{
			return $this->anio;
		}
		public function getMes()
		{
			return $this->mes;
		}
		public function getIdPromotor()
		{
			return $this->idPromotor;
		}
		public function getFecha_creacion()
		{
			return $this->fecha_creacion;
		}
		public function getId_usuario_creacion()
		{
			return $this->id_usuario_creacion;
		}
		public function getTotal()
		{
			return $this->total;
		}
		public function getPorcentajeObjetivoVenta()
		{
			return $this->porcentajeObjetivoVenta;
		}
		public function getIncentivo()
		{
			return $this->incentivo;
		}
		public function getComisionAdelantada()
		{
			return $this->comisionAdelantada;
		}
		public function getAPagar()
		{
			return $this->aPagar;
		}
		public function getSaldo()
		{
			return $this->saldo;
		}
		public function getFechaInicio()
		{
			return $this->fechaInicio;
		}
		public function getFechaFin()
		{
			return $this->fechaFin;
		}
		public function getPagada()
		{
			return $this->pagada;
		}
		public function getFecha_pagada()
		{
			return $this->fecha_pagada;
		}
		public function getId_usuario_pagada()
		{
			return $this->id_usuario_pagada;
		}

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Querys------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Otras-------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		protected function limpiarPropiedades()
		{
			
			$this->idCorteComision=0;
			$this->tipo='M';
			$this->anio=0;
			$this->mes=0;
			$this->idPromotor=0;
			$this->fecha_creacion='0000-00-00 00:00:00';
			$this->id_usuario_creacion=0;
			$this->total='0.00';
			$this->porcentajeObjetivoVenta='0.00';
			$this->incentivo='0.00';
			$this->comisionAdelantada='0.00';
			$this->aPagar='0.00';
			$this->saldo='0.00';
			$this->fechaInicio='';
			$this->fechaFin='';
			$this->pagada='NO';
			$this->fecha_pagada='0000-00-00 00:00:00';
			$this->id_usuario_pagada=0;
		}

		

		
		protected function Insertar()
		{
			try
			{
				$SQL="INSERT INTO " . $this->__tableName . " (tipo,
				                                              anio,
				                                              mes,
				                                              idPromotor,
				                                              fecha_creacion,
				                                              id_usuario_creacion,
				                                              total,
				                                              porcentajeObjetivoVenta,
				                                              incentivo,
				                                              comisionAdelantada,
				                                              aPagar,
				                                              saldo,
				                                              fechaInicio,
				                                              fechaFin,
				                                              pagada,
				                                              fecha_pagada,
				                                              id_usuario_pagada)
						VALUES('" . mysqli_real_escape_string($this->dbLink,$this->tipo) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->anio) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->mes) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idPromotor) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->fecha_creacion) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_creacion) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->total) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->porcentajeObjetivoVenta) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->incentivo) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->comisionAdelantada) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->aPagar) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->saldo) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->fechaInicio) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->fechaFin) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->pagada) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->fecha_pagada) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_pagada) . "')";
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la insercion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseCortecomision::Insertar]");
				
				$this->idCorteComision=mysqli_insert_id($this->dbLink);
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
				$SQL="UPDATE " . $this->__tableName . " SET tipo='" . mysqli_real_escape_string($this->dbLink,$this->tipo) . "',
	                                              anio='" . mysqli_real_escape_string($this->dbLink,$this->anio) . "',
	                                              mes='" . mysqli_real_escape_string($this->dbLink,$this->mes) . "',
	                                              idPromotor='" . mysqli_real_escape_string($this->dbLink,$this->idPromotor) . "',
	                                              fecha_creacion='" . mysqli_real_escape_string($this->dbLink,$this->fecha_creacion) . "',
	                                              id_usuario_creacion='" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_creacion) . "',
	                                              total='" . mysqli_real_escape_string($this->dbLink,$this->total) . "',
	                                              porcentajeObjetivoVenta='" . mysqli_real_escape_string($this->dbLink,$this->porcentajeObjetivoVenta) . "',
	                                              incentivo='" . mysqli_real_escape_string($this->dbLink,$this->incentivo) . "',
	                                              comisionAdelantada='" . mysqli_real_escape_string($this->dbLink,$this->comisionAdelantada) . "',
	                                              aPagar='" . mysqli_real_escape_string($this->dbLink,$this->aPagar) . "',
	                                              saldo='" . mysqli_real_escape_string($this->dbLink,$this->saldo) . "',
	                                              fechaInicio='" . mysqli_real_escape_string($this->dbLink,$this->fechaInicio) . "',
	                                              fechaFin='" . mysqli_real_escape_string($this->dbLink,$this->fechaFin) . "',
	                                              pagada='" . mysqli_real_escape_string($this->dbLink,$this->pagada) . "',
	                                              fecha_pagada='" . mysqli_real_escape_string($this->dbLink,$this->fecha_pagada) . "',
	                                              id_usuario_pagada='" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_pagada) . "'
					WHERE idCorteComision=" . $this->idCorteComision;
				
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la actualizacion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseCortecomision::Update]");
				
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
				WHERE idCorteComision=" . mysqli_real_escape_string($this->dbLink,$this->idCorteComision);
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en el borrado de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseCortecomision::Borrar]");
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
						idCorteComision,
						tipo,
						anio,
						mes,
						idPromotor,
						fecha_creacion,
						id_usuario_creacion,
						total,
						porcentajeObjetivoVenta,
						incentivo,
						comisionAdelantada,
						aPagar,
						saldo,
						fechaInicio,
						fechaFin,
						pagada,
						fecha_pagada,
						id_usuario_pagada
					FROM " . $this->__tableName . " 
					WHERE idCorteComision=" . mysqli_real_escape_string($this->dbLink,$this->idCorteComision);
					
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la obtencion de detalles de registro.","[ModeloBaseCortecomision::getDatos][" . $SQL . "][" . mysqli_error($this->dbLink) . "]");
				

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
			if($this->idCorteComision==0)
				$this->Insertar();
			else
				$this->Actualizar();
			if($this->getError())
				return false;
			return true;
		}
		
	}

?>