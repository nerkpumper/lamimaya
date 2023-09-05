<?php

	require FOLDER_MODEL_BASE . "model.base.configuracion.inc.php";
	
	class ModeloConfiguracion extends ModeloBaseConfiguracion
	{
		#------------------------------------------------------------------------------------------------------#
		#----------------------------------------------Propiedades---------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		var $_nombreClase="ModeloBaseConfiguracion";

		var $__ss=array();
		var $__primaryKey="idConfiguracion";				
		var $__tableName="configuracion";
		var $__tableEdit="configuracionedit";
		var $__tableDelete="configuraciondelete";				

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

		public function getPesoXCalibre($calibre)
		{
			$peso = 0;
			
			if ($calibre == 22)
			{
				$peso = $this->getPesoXCalibre22();
			}
			else if ($calibre == 24)
			{
				$peso = $this->getPesoXCalibre24();
			}
			else if ($calibre == 26)
			{
				$peso = $this->getPesoXCalibre26();
			}
			else if ($calibre == 27)
			{
				$peso = $this->getPesoXCalibre28();
			}
			else if ($calibre == 20)
			{
				$peso = $this->getPesoXCalibre20();
			}
			
			return $peso;
		}


		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Querys------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Otras-------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		public function updateLastCheckUpdatePrecios()
		{
			if($this->getError())
				return false;
			try
			{
				$SQL="update " . $this->__tableName . " set lastCheckUpdatePrecios = NOW()
				WHERE idConfiguracion= 1";
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en el borrado de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseConfiguracion::Borrar]");
			}
			catch (Exception $e)
			{
				return $this->setErrorCatch($e);
			}
		}

		public function lastCheckUpdatePrecios()
		{
			try
			{
				$SQL="SELECT				        						
						idConfiguracion,						
						lastCheckUpdatePrecios,
						rolloprodlastupdate					
					FROM " . $this->__tableName . " 
					WHERE idConfiguracion= 1 ";
					// echo $SQL;
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la obtencion de detalles de registro.","[ModeloBaseConfiguracion::getDatos][" . $SQL . "][" . mysqli_error($this->dbLink) . "]");
				

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
				return $this->getLastCheckUpdatePrecios();
			}
			catch (Exception $e)
			{
				return $this->setErrorCatch($e);
			}
		}

		public function haCambiadoPreciosEnProductosORollos()
		{
			try
			{
				if ($this->idConfiguracion > 0)	
				{
					
					return strtotime($this->getRolloprodlastupdate()) > strtotime($this->getLastCheckUpdatePrecios()) ;
					

				}


				$SQL="SELECT				        						
						idConfiguracion,						
						lastCheckUpdatePrecios,
						rolloprodlastupdate					
					FROM " . $this->__tableName . " 
					WHERE idConfiguracion= 1 ";
					// echo $SQL;
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la obtencion de detalles de registro.","[ModeloBaseConfiguracion::getDatos][" . $SQL . "][" . mysqli_error($this->dbLink) . "]");
				

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
				return strtotime($this->getRolloprodlastupdate()) > strtotime($this->getLastCheckUpdatePrecios()) ;
			}
			catch (Exception $e)
			{
				return $this->setErrorCatch($e);
			}
		}



		public function updateLastIdPedidoChecked($idPedido)
		{
			if($this->getError())
				return false;
			try
			{
				$SQL="update " . $this->__tableName . " set lastIdPedidoChecked = ". $idPedido.
				" WHERE idConfiguracion= 1";
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en el borrado de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseConfiguracion::Borrar]");
			}
			catch (Exception $e)
			{
				return $this->setErrorCatch($e);
			}
		}

		public function lastIdPedidoChecked()
		{
			try
			{
				$SQL="SELECT						
						lastIdPedidoChecked					
					FROM " . $this->__tableName . " 
					WHERE idConfiguracion= 1 ";
					// echo $SQL;
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la obtencion de detalles de registro.","[ModeloBaseConfiguracion::getDatos][" . $SQL . "][" . mysqli_error($this->dbLink) . "]");
				

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
				return $this->getLastIdPedidoChecked();
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

