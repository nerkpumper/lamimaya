<?php

	class ModeloBaseDatosfacturacion extends clsBasicCommon
	{
		#------------------------------------------------------------------------------------------------------#
		#----------------------------------------------Propiedades---------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		var $_nombreClase="base.ModeloBaseDatosfacturacion";

		
		var $idDatosFacturacion=0;
		var $rfc='';
		var $email='';
		var $razonSocial='';
		var $domicilio='';
		var $codigoPostal='';
		var $colonia='';
		var $numero='';
		var $ciudad='';
		var $idUsoCfdi=0;
		var $idRegimenFiscal=0;
		var $credito='0.00';
		var $capacidadPago='0.00';
		var $privado='NO';
		var $fecha_insert='0000-00-00 00:00:00';
		var $id_usuario_insert=0;
		var $fecha_update='0000-00-00 00:00:00';
		var $id_usuario_update=0;

		var $__s=array("idDatosFacturacion",
                       "rfc",
                       "email",
                       "razonSocial",
                       "domicilio",
                       "codigoPostal",
                       "colonia",
                       "numero",
                       "ciudad",
                       "idUsoCfdi",
                       "idRegimenFiscal",
                       "credito",
                       "capacidadPago",
                       "privado",
                       "fecha_insert",
                       "id_usuario_insert",
                       "fecha_update",
                       "id_usuario_update");
				
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

		
		public function setIdDatosFacturacion($idDatosFacturacion)
		{
			if($idDatosFacturacion==0||$idDatosFacturacion==""||!is_numeric($idDatosFacturacion)|| (is_string($idDatosFacturacion)&&!ctype_digit($idDatosFacturacion)))return $this->setError("Tipo de dato incorrecto para idDatosFacturacion.");
			$this->idDatosFacturacion=$idDatosFacturacion;
			$this->getDatos();
		}
		public function setRfc($rfc)
		{
			
			$this->rfc=$rfc;
		}
		public function setEmail($email)
		{
			
			$this->email=$email;
		}
		public function setRazonSocial($razonSocial)
		{
			
			$this->razonSocial=$razonSocial;
		}
		public function setDomicilio($domicilio)
		{
			
			$this->domicilio=$domicilio;
		}
		public function setCodigoPostal($codigoPostal)
		{
			
			$this->codigoPostal=$codigoPostal;
		}
		public function setColonia($colonia)
		{
			
			$this->colonia=$colonia;
		}
		public function setNumero($numero)
		{
			
			$this->numero=$numero;
		}
		public function setCiudad($ciudad)
		{
			
			$this->ciudad=$ciudad;
		}
		public function setIdUsoCfdi($idUsoCfdi)
		{
			
			$this->idUsoCfdi=$idUsoCfdi;
		}
		public function setIdRegimenFiscal($idRegimenFiscal)
		{
			
			$this->idRegimenFiscal=$idRegimenFiscal;
		}
		public function setCredito($credito)
		{
			$this->credito=$credito;
		}
		public function setCapacidadPago($capacidadPago)
		{
			$this->capacidadPago=$capacidadPago;
		}
		public function setPrivado($privado)
		{
			
			$this->privado=$privado;
		}
		public function setPrivadoSI()
		{
			$this->privado='SI';
		}
		public function setPrivadoNO()
		{
			$this->privado='NO';
		}
		public function setFecha_insert($fecha_insert)
		{
			$this->fecha_insert=$fecha_insert;
		}
		public function setId_usuario_insert($id_usuario_insert)
		{
			
			$this->id_usuario_insert=$id_usuario_insert;
		}
		public function setFecha_update($fecha_update)
		{
			$this->fecha_update=$fecha_update;
		}
		public function setId_usuario_update($id_usuario_update)
		{
			
			$this->id_usuario_update=$id_usuario_update;
		}

		#------------------------------------------------------------------------------------------------------#
		#-----------------------------------------------Unsetter-----------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Getter------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		
		public function getIdDatosFacturacion()
		{
			return $this->idDatosFacturacion;
		}
		public function getRfc()
		{
			return $this->rfc;
		}
		public function getEmail()
		{
			return $this->email;
		}
		public function getRazonSocial()
		{
			return $this->razonSocial;
		}
		public function getDomicilio()
		{
			return $this->domicilio;
		}
		public function getCodigoPostal()
		{
			return $this->codigoPostal;
		}
		public function getColonia()
		{
			return $this->colonia;
		}
		public function getNumero()
		{
			return $this->numero;
		}
		public function getCiudad()
		{
			return $this->ciudad;
		}
		public function getIdUsoCfdi()
		{
			return $this->idUsoCfdi;
		}
		public function getIdRegimenFiscal()
		{
			return $this->idRegimenFiscal;
		}
		public function getCredito()
		{
			return $this->credito;
		}
		public function getCapacidadPago()
		{
			return $this->capacidadPago;
		}
		public function getPrivado()
		{
			return $this->privado;
		}
		public function getFecha_insert()
		{
			return $this->fecha_insert;
		}
		public function getId_usuario_insert()
		{
			return $this->id_usuario_insert;
		}
		public function getFecha_update()
		{
			return $this->fecha_update;
		}
		public function getId_usuario_update()
		{
			return $this->id_usuario_update;
		}

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Querys------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Otras-------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		protected function limpiarPropiedades()
		{
			
			$this->idDatosFacturacion=0;
			$this->rfc='';
			$this->email='';
			$this->razonSocial='';
			$this->domicilio='';
			$this->codigoPostal='';
			$this->colonia='';
			$this->numero='';
			$this->ciudad='';
			$this->idUsoCfdi=0;
			$this->idRegimenFiscal=0;
			$this->credito='0.00';
			$this->capacidadPago='0.00';
			$this->privado='NO';
			$this->fecha_insert='0000-00-00 00:00:00';
			$this->id_usuario_insert=0;
			$this->fecha_update='0000-00-00 00:00:00';
			$this->id_usuario_update=0;
		}

		

		
		protected function Insertar()
		{
			try
			{
				$SQL="INSERT INTO " . $this->__tableName . " (rfc,
				                                              email,
				                                              razonSocial,
				                                              domicilio,
				                                              codigoPostal,
				                                              colonia,
				                                              numero,
				                                              ciudad,
				                                              idUsoCfdi,
				                                              idRegimenFiscal,
				                                              credito,
				                                              capacidadPago,
				                                              privado,
				                                              fecha_insert,
				                                              id_usuario_insert,
				                                              fecha_update,
				                                              id_usuario_update)
						VALUES('" . mysqli_real_escape_string($this->dbLink,$this->rfc) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->email) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->razonSocial) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->domicilio) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->codigoPostal) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->colonia) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->numero) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->ciudad) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idUsoCfdi) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idRegimenFiscal) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->credito) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->capacidadPago) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->privado) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->fecha_insert) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_insert) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->fecha_update) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_update) . "')";
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la insercion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseDatosfacturacion::Insertar]");
				
				$this->idDatosFacturacion=mysqli_insert_id($this->dbLink);
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
				$SQL="UPDATE " . $this->__tableName . " SET rfc='" . mysqli_real_escape_string($this->dbLink,$this->rfc) . "',
	                                              email='" . mysqli_real_escape_string($this->dbLink,$this->email) . "',
	                                              razonSocial='" . mysqli_real_escape_string($this->dbLink,$this->razonSocial) . "',
	                                              domicilio='" . mysqli_real_escape_string($this->dbLink,$this->domicilio) . "',
	                                              codigoPostal='" . mysqli_real_escape_string($this->dbLink,$this->codigoPostal) . "',
	                                              colonia='" . mysqli_real_escape_string($this->dbLink,$this->colonia) . "',
	                                              numero='" . mysqli_real_escape_string($this->dbLink,$this->numero) . "',
	                                              ciudad='" . mysqli_real_escape_string($this->dbLink,$this->ciudad) . "',
	                                              idUsoCfdi='" . mysqli_real_escape_string($this->dbLink,$this->idUsoCfdi) . "',
	                                              idRegimenFiscal='" . mysqli_real_escape_string($this->dbLink,$this->idRegimenFiscal) . "',
	                                              credito='" . mysqli_real_escape_string($this->dbLink,$this->credito) . "',
	                                              capacidadPago='" . mysqli_real_escape_string($this->dbLink,$this->capacidadPago) . "',
	                                              privado='" . mysqli_real_escape_string($this->dbLink,$this->privado) . "',
	                                              fecha_insert='" . mysqli_real_escape_string($this->dbLink,$this->fecha_insert) . "',
	                                              id_usuario_insert='" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_insert) . "',
	                                              fecha_update='" . mysqli_real_escape_string($this->dbLink,$this->fecha_update) . "',
	                                              id_usuario_update='" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_update) . "'
					WHERE idDatosFacturacion=" . $this->idDatosFacturacion;
				
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la actualizacion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseDatosfacturacion::Update]");
				
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
				WHERE idDatosFacturacion=" . mysqli_real_escape_string($this->dbLink,$this->idDatosFacturacion);
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en el borrado de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseDatosfacturacion::Borrar]");
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
						idDatosFacturacion,
						rfc,
						email,
						razonSocial,
						domicilio,
						codigoPostal,
						colonia,
						numero,
						ciudad,
						idUsoCfdi,
						idRegimenFiscal,
						credito,
						capacidadPago,
						privado,
						fecha_insert,
						id_usuario_insert,
						fecha_update,
						id_usuario_update
					FROM " . $this->__tableName . " 
					WHERE idDatosFacturacion=" . mysqli_real_escape_string($this->dbLink,$this->idDatosFacturacion);
					
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la obtencion de detalles de registro.","[ModeloBaseDatosfacturacion::getDatos][" . $SQL . "][" . mysqli_error($this->dbLink) . "]");
				

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
			if($this->idDatosFacturacion==0)
				$this->Insertar();
			else
				$this->Actualizar();
			if($this->getError())
				return false;
			return true;
		}
		
	}

?>