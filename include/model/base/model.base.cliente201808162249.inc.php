<?php

	class ModeloBaseCliente extends clsBasicCommon
	{
		#------------------------------------------------------------------------------------------------------#
		#----------------------------------------------Propiedades---------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		var $_nombreClase="base.ModeloBaseCliente";

		
		var $idCliente=0;
		var $nombre='';
		var $apellidos='';
		var $empresa='';
		var $domicilio1='';
		var $domicilio2='';
		var $numero='';
		var $colonia='';
		var $ciudad='';
		var $telefonos='';
		var $email='';
		var $rfc='';
		var $idUsuarioPromotor=0;
		var $estado='ACTIVO';
		var $fecha_creacion='0000-00-00 00:00:00';
		var $idUsuarioCrea=0;
		var $fecha_modifica='0000-00-00 00:00:00';
		var $idUsuarioModifica=0;
		var $fecha_baja='0000-00-00 00:00:00';
		var $idUsuarioBaja=0;
		var $porDescuento='';
		var $idUsoCfdi=0;
		var $credito='';
		var $usado='';
		var $creditopromotor='';
		var $razonsocial='';
		var $domiciliofiscal='';
		var $codigopostal='';

		var $__s=array("idCliente",
                       "nombre",
                       "apellidos",
                       "empresa",
                       "domicilio1",
                       "domicilio2",
                       "numero",
                       "colonia",
                       "ciudad",
                       "telefonos",
                       "email",
                       "rfc",
                       "idUsuarioPromotor",
                       "estado",
                       "fecha_creacion",
                       "idUsuarioCrea",
                       "fecha_modifica",
                       "idUsuarioModifica",
                       "fecha_baja",
                       "idUsuarioBaja",
                       "porDescuento",
                       "idUsoCfdi",
                       "credito",
                       "usado",
                       "creditopromotor",
                       "razonsocial",
                       "domiciliofiscal",
                       "codigopostal");
				
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

		
		public function setIdCliente($idCliente)
		{
			if($idCliente==0||$idCliente==""||!is_numeric($idCliente)|| (is_string($idCliente)&&!ctype_digit($idCliente)))return $this->setError("Tipo de dato incorrecto para idCliente.");
			$this->idCliente=$idCliente;
			$this->getDatos();
		}
		public function setNombre($nombre)
		{
			
			$this->nombre=$nombre;
		}
		public function setApellidos($apellidos)
		{
			
			$this->apellidos=$apellidos;
		}
		public function setEmpresa($empresa)
		{
			
			$this->empresa=$empresa;
		}
		public function setDomicilio1($domicilio1)
		{
			
			$this->domicilio1=$domicilio1;
		}
		public function setDomicilio2($domicilio2)
		{
			
			$this->domicilio2=$domicilio2;
		}
		public function setNumero($numero)
		{
			
			$this->numero=$numero;
		}
		public function setColonia($colonia)
		{
			
			$this->colonia=$colonia;
		}
		public function setCiudad($ciudad)
		{
			
			$this->ciudad=$ciudad;
		}
		public function setTelefonos($telefonos)
		{
			
			$this->telefonos=$telefonos;
		}
		public function setEmail($email)
		{
			
			$this->email=$email;
		}
		public function setRfc($rfc)
		{
			
			$this->rfc=$rfc;
		}
		public function setIdUsuarioPromotor($idUsuarioPromotor)
		{
			
			$this->idUsuarioPromotor=$idUsuarioPromotor;
		}
		public function setEstado($estado)
		{
			
			$this->estado=$estado;
		}
		public function setEstadoACTIVO()
		{
			$this->estado='ACTIVO';
		}
		public function setEstadoBAJA()
		{
			$this->estado='BAJA';
		}
		public function setFecha_creacion($fecha_creacion)
		{
			$this->fecha_creacion=$fecha_creacion;
		}
		public function setIdUsuarioCrea($idUsuarioCrea)
		{
			
			$this->idUsuarioCrea=$idUsuarioCrea;
		}
		public function setFecha_modifica($fecha_modifica)
		{
			$this->fecha_modifica=$fecha_modifica;
		}
		public function setIdUsuarioModifica($idUsuarioModifica)
		{
			
			$this->idUsuarioModifica=$idUsuarioModifica;
		}
		public function setFecha_baja($fecha_baja)
		{
			$this->fecha_baja=$fecha_baja;
		}
		public function setIdUsuarioBaja($idUsuarioBaja)
		{
			
			$this->idUsuarioBaja=$idUsuarioBaja;
		}
		public function setPorDescuento($porDescuento)
		{
			$this->porDescuento=$porDescuento;
		}
		public function setIdUsoCfdi($idUsoCfdi)
		{
			
			$this->idUsoCfdi=$idUsoCfdi;
		}
		public function setCredito($credito)
		{
			$this->credito=$credito;
		}
		public function setUsado($usado)
		{
			$this->usado=$usado;
		}
		public function setCreditopromotor($creditopromotor)
		{
			$this->creditopromotor=$creditopromotor;
		}
		public function setRazonsocial($razonsocial)
		{
			
			$this->razonsocial=$razonsocial;
		}
		public function setDomiciliofiscal($domiciliofiscal)
		{
			
			$this->domiciliofiscal=$domiciliofiscal;
		}
		public function setCodigopostal($codigopostal)
		{
			
			$this->codigopostal=$codigopostal;
		}

		#------------------------------------------------------------------------------------------------------#
		#-----------------------------------------------Unsetter-----------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Getter------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		
		public function getIdCliente()
		{
			return $this->idCliente;
		}
		public function getNombre()
		{
			return $this->nombre;
		}
		public function getApellidos()
		{
			return $this->apellidos;
		}
		public function getEmpresa()
		{
			return $this->empresa;
		}
		public function getDomicilio1()
		{
			return $this->domicilio1;
		}
		public function getDomicilio2()
		{
			return $this->domicilio2;
		}
		public function getNumero()
		{
			return $this->numero;
		}
		public function getColonia()
		{
			return $this->colonia;
		}
		public function getCiudad()
		{
			return $this->ciudad;
		}
		public function getTelefonos()
		{
			return $this->telefonos;
		}
		public function getEmail()
		{
			return $this->email;
		}
		public function getRfc()
		{
			return $this->rfc;
		}
		public function getIdUsuarioPromotor()
		{
			return $this->idUsuarioPromotor;
		}
		public function getEstado()
		{
			return $this->estado;
		}
		public function getFecha_creacion()
		{
			return $this->fecha_creacion;
		}
		public function getIdUsuarioCrea()
		{
			return $this->idUsuarioCrea;
		}
		public function getFecha_modifica()
		{
			return $this->fecha_modifica;
		}
		public function getIdUsuarioModifica()
		{
			return $this->idUsuarioModifica;
		}
		public function getFecha_baja()
		{
			return $this->fecha_baja;
		}
		public function getIdUsuarioBaja()
		{
			return $this->idUsuarioBaja;
		}
		public function getPorDescuento()
		{
			return $this->porDescuento;
		}
		public function getIdUsoCfdi()
		{
			return $this->idUsoCfdi;
		}
		public function getCredito()
		{
			return $this->credito;
		}
		public function getUsado()
		{
			return $this->usado;
		}
		public function getCreditopromotor()
		{
			return $this->creditopromotor;
		}
		public function getRazonsocial()
		{
			return $this->razonsocial;
		}
		public function getDomiciliofiscal()
		{
			return $this->domiciliofiscal;
		}
		public function getCodigopostal()
		{
			return $this->codigopostal;
		}

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Querys------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Otras-------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		protected function limpiarPropiedades()
		{
			
			$this->idCliente=0;
			$this->nombre='';
			$this->apellidos='';
			$this->empresa='';
			$this->domicilio1='';
			$this->domicilio2='';
			$this->numero='';
			$this->colonia='';
			$this->ciudad='';
			$this->telefonos='';
			$this->email='';
			$this->rfc='';
			$this->idUsuarioPromotor=0;
			$this->estado='ACTIVO';
			$this->fecha_creacion='0000-00-00 00:00:00';
			$this->idUsuarioCrea=0;
			$this->fecha_modifica='0000-00-00 00:00:00';
			$this->idUsuarioModifica=0;
			$this->fecha_baja='0000-00-00 00:00:00';
			$this->idUsuarioBaja=0;
			$this->porDescuento='';
			$this->idUsoCfdi=0;
			$this->credito='';
			$this->usado='';
			$this->creditopromotor='';
			$this->razonsocial='';
			$this->domiciliofiscal='';
			$this->codigopostal='';
		}

		

		
		protected function Insertar()
		{
			try
			{
				$SQL="INSERT INTO " . $this->__tableName . " (nombre,
				                                              apellidos,
				                                              empresa,
				                                              domicilio1,
				                                              domicilio2,
				                                              numero,
				                                              colonia,
				                                              ciudad,
				                                              telefonos,
				                                              email,
				                                              rfc,
				                                              idUsuarioPromotor,
				                                              estado,
				                                              fecha_creacion,
				                                              idUsuarioCrea,
				                                              fecha_modifica,
				                                              idUsuarioModifica,
				                                              fecha_baja,
				                                              idUsuarioBaja,
				                                              porDescuento,
				                                              idUsoCfdi,
				                                              credito,
				                                              usado,
				                                              creditopromotor,
				                                              razonsocial,
				                                              domiciliofiscal,
				                                              codigopostal)
						VALUES('" . mysqli_real_escape_string($this->dbLink,$this->nombre) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->apellidos) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->empresa) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->domicilio1) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->domicilio2) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->numero) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->colonia) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->ciudad) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->telefonos) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->email) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->rfc) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idUsuarioPromotor) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->estado) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->fecha_creacion) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idUsuarioCrea) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->fecha_modifica) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idUsuarioModifica) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->fecha_baja) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idUsuarioBaja) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->porDescuento) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idUsoCfdi) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->credito) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->usado) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->creditopromotor) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->razonsocial) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->domiciliofiscal) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->codigopostal) . "')";
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la insercion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseCliente::Insertar]");
				
				$this->idCliente=mysqli_insert_id($this->dbLink);
				return true;
			}
			catch (Exception $e)
			{
				return $this->setErrorCatch($e);
			}
		}

		
		public function getInsertQuery()
		{
			try
			{
				$SQL="INSERT INTO " . $this->__tableName . " (nombre,
				                                              apellidos,
				                                              empresa,
				                                              domicilio1,
				                                              domicilio2,
				                                              numero,
				                                              colonia,
				                                              ciudad,
				                                              telefonos,
				                                              email,
				                                              rfc,
				                                              idUsuarioPromotor,
				                                              estado,
				                                              fecha_creacion,
				                                              idUsuarioCrea,
				                                              fecha_modifica,
				                                              idUsuarioModifica,
				                                              fecha_baja,
				                                              idUsuarioBaja,
				                                              porDescuento,
				                                              idUsoCfdi,
				                                              credito,
				                                              usado,
				                                              creditopromotor,
				                                              razonsocial,
				                                              domiciliofiscal,
				                                              codigopostal)
						VALUES('" . mysqli_real_escape_string($this->dbLink,$this->nombre) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->apellidos) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->empresa) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->domicilio1) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->domicilio2) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->numero) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->colonia) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->ciudad) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->telefonos) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->email) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->rfc) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idUsuarioPromotor) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->estado) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->fecha_creacion) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idUsuarioCrea) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->fecha_modifica) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idUsuarioModifica) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->fecha_baja) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idUsuarioBaja) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->porDescuento) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idUsoCfdi) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->credito) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->usado) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->creditopromotor) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->razonsocial) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->domiciliofiscal) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->codigopostal) . "')";
				return $SQL;
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
				$SQL="UPDATE " . $this->__tableName . " SET nombre='" . mysqli_real_escape_string($this->dbLink,$this->nombre) . "',
	                                              apellidos='" . mysqli_real_escape_string($this->dbLink,$this->apellidos) . "',
	                                              empresa='" . mysqli_real_escape_string($this->dbLink,$this->empresa) . "',
	                                              domicilio1='" . mysqli_real_escape_string($this->dbLink,$this->domicilio1) . "',
	                                              domicilio2='" . mysqli_real_escape_string($this->dbLink,$this->domicilio2) . "',
	                                              numero='" . mysqli_real_escape_string($this->dbLink,$this->numero) . "',
	                                              colonia='" . mysqli_real_escape_string($this->dbLink,$this->colonia) . "',
	                                              ciudad='" . mysqli_real_escape_string($this->dbLink,$this->ciudad) . "',
	                                              telefonos='" . mysqli_real_escape_string($this->dbLink,$this->telefonos) . "',
	                                              email='" . mysqli_real_escape_string($this->dbLink,$this->email) . "',
	                                              rfc='" . mysqli_real_escape_string($this->dbLink,$this->rfc) . "',
	                                              idUsuarioPromotor='" . mysqli_real_escape_string($this->dbLink,$this->idUsuarioPromotor) . "',
	                                              estado='" . mysqli_real_escape_string($this->dbLink,$this->estado) . "',
	                                              fecha_creacion='" . mysqli_real_escape_string($this->dbLink,$this->fecha_creacion) . "',
	                                              idUsuarioCrea='" . mysqli_real_escape_string($this->dbLink,$this->idUsuarioCrea) . "',
	                                              fecha_modifica='" . mysqli_real_escape_string($this->dbLink,$this->fecha_modifica) . "',
	                                              idUsuarioModifica='" . mysqli_real_escape_string($this->dbLink,$this->idUsuarioModifica) . "',
	                                              fecha_baja='" . mysqli_real_escape_string($this->dbLink,$this->fecha_baja) . "',
	                                              idUsuarioBaja='" . mysqli_real_escape_string($this->dbLink,$this->idUsuarioBaja) . "',
	                                              porDescuento='" . mysqli_real_escape_string($this->dbLink,$this->porDescuento) . "',
	                                              idUsoCfdi='" . mysqli_real_escape_string($this->dbLink,$this->idUsoCfdi) . "',
	                                              credito='" . mysqli_real_escape_string($this->dbLink,$this->credito) . "',
	                                              usado='" . mysqli_real_escape_string($this->dbLink,$this->usado) . "',
	                                              creditopromotor='" . mysqli_real_escape_string($this->dbLink,$this->creditopromotor) . "',
	                                              razonsocial='" . mysqli_real_escape_string($this->dbLink,$this->razonsocial) . "',
	                                              domiciliofiscal='" . mysqli_real_escape_string($this->dbLink,$this->domiciliofiscal) . "',
	                                              codigopostal='" . mysqli_real_escape_string($this->dbLink,$this->codigopostal) . "'
					WHERE idCliente=" . $this->idCliente;
				
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la actualizacion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseCliente::Update]");
				
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
				WHERE idCliente=" . mysqli_real_escape_string($this->dbLink,$this->idCliente);
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en el borrado de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseCliente::Borrar]");
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
						idCliente,
						nombre,
						apellidos,
						empresa,
						domicilio1,
						domicilio2,
						numero,
						colonia,
						ciudad,
						telefonos,
						email,
						rfc,
						idUsuarioPromotor,
						estado,
						fecha_creacion,
						idUsuarioCrea,
						fecha_modifica,
						idUsuarioModifica,
						fecha_baja,
						idUsuarioBaja,
						porDescuento,
						idUsoCfdi,
						credito,
						usado,
						creditopromotor,
						razonsocial,
						domiciliofiscal,
						codigopostal
					FROM " . $this->__tableName . " 
					WHERE idCliente=" . mysqli_real_escape_string($this->dbLink,$this->idCliente);
					
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la obtencion de detalles de registro.","[ModeloBaseCliente::getDatos][" . $SQL . "][" . mysqli_error($this->dbLink) . "]");
				

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
			if($this->idCliente==0)
				$this->Insertar();
			else
				$this->Actualizar();
			if($this->getError())
				return false;
			return true;
		}
		
	}

?>