<?php

	class ModeloBaseProducto extends clsBasicCommon
	{
		#------------------------------------------------------------------------------------------------------#
		#----------------------------------------------Propiedades---------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		var $_nombreClase="base.ModeloBaseProducto";

		
		var $idProducto=0;
		var $codigo='0';
		var $longitud='';
		var $mlpieza='0.00';
		var $producto_tipoProducto_idTipoProducto=0;
		var $producto_aplicacion_idAplicacion=0;
		var $producto_material_idMaterial=0;
		var $producto_rollo_idRollo=0;
		var $producto_unidad_idUnidad=0;
		var $calibre=0;
		var $pies=0;
		var $origen='N';
		var $descripcion='';
		var $existencia='0.00';
		var $apartado='0';
		var $apartadoReal='0';
		var $tipoPrecio='';
		var $isRango='';
		var $tipoRango='';
		var $isRollo='';
		var $heredarPrecio='SI';
		var $cf='0.00';
		var $precio1='0.00';
		var $precio2='0.00';
		var $precio3='0.00';
		var $precio4='0.00';
		var $preciomendez='0.00';
		var $estado='ACTIVO';
		var $fecha_creacion='0000-00-00 00:00:00';
		var $idUsuarioCrea=0;
		var $fecha_modifica='0000-00-00 00:00:00';
		var $idUsuarioModifica=0;
		var $fecha_baja='0000-00-00 00:00:00';
		var $idUsuarioBaja=0;
		var $isRoofing='NO';
		var $medidaespecial='';
		var $costo='0';
		var $isSegunda='NO';
		var $lastUpdate='';
		var $idProveedor=0;
		var $resurtir='NO';

		var $__s=array("idProducto",
                       "codigo",
                       "longitud",
                       "mlpieza",
                       "producto_tipoProducto_idTipoProducto",
                       "producto_aplicacion_idAplicacion",
                       "producto_material_idMaterial",
                       "producto_rollo_idRollo",
                       "producto_unidad_idUnidad",
                       "calibre",
                       "pies",
                       "origen",
                       "descripcion",
                       "existencia",
                       "apartado",
                       "apartadoReal",
                       "tipoPrecio",
                       "isRango",
                       "tipoRango",
                       "isRollo",
                       "heredarPrecio",
                       "cf",
                       "precio1",
                       "precio2",
                       "precio3",
					   "precio4",
                       "preciomendez",
                       "estado",
                       "fecha_creacion",
                       "idUsuarioCrea",
                       "fecha_modifica",
                       "idUsuarioModifica",
                       "fecha_baja",
                       "idUsuarioBaja",
                       "isRoofing",
                       "medidaespecial",
                       "costo",
                       "isSegunda",
                       "lastUpdate",
                       "idProveedor",
                       "resurtir");
				
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

		
		public function setIdProducto($idProducto)
		{
			if($idProducto==0||$idProducto==""||!is_numeric($idProducto)|| (is_string($idProducto)&&!ctype_digit($idProducto)))return $this->setError("Tipo de dato incorrecto para idProducto.");
			$this->idProducto=$idProducto;
			$this->getDatos();
		}
		public function setCodigo($codigo)
		{
			
			$this->codigo=$codigo;
		}
		public function setLongitud($longitud)
		{
			
			$this->longitud=$longitud;
		}
		public function setMlpieza($mlpieza)
		{
			$this->mlpieza=$mlpieza;
		}
		public function setProducto_tipoProducto_idTipoProducto($producto_tipoProducto_idTipoProducto)
		{
			
			$this->producto_tipoProducto_idTipoProducto=$producto_tipoProducto_idTipoProducto;
		}
		public function setProducto_aplicacion_idAplicacion($producto_aplicacion_idAplicacion)
		{
			
			$this->producto_aplicacion_idAplicacion=$producto_aplicacion_idAplicacion;
		}
		public function setProducto_material_idMaterial($producto_material_idMaterial)
		{
			
			$this->producto_material_idMaterial=$producto_material_idMaterial;
		}
		public function setProducto_rollo_idRollo($producto_rollo_idRollo)
		{
			
			$this->producto_rollo_idRollo=$producto_rollo_idRollo;
		}
		public function setProducto_unidad_idUnidad($producto_unidad_idUnidad)
		{
			
			$this->producto_unidad_idUnidad=$producto_unidad_idUnidad;
		}
		public function setCalibre($calibre)
		{
			
			$this->calibre=$calibre;
		}
		public function setPies($pies)
		{
			
			$this->pies=$pies;
		}
		public function setOrigen($origen)
		{
			
			$this->origen=$origen;
		}
		public function setOrigenN()
		{
			$this->origen='N';
		}
		public function setOrigenI()
		{
			$this->origen='I';
		}
		public function setDescripcion($descripcion)
		{
			
			$this->descripcion=$descripcion;
		}
		public function setExistencia($existencia)
		{
			$this->existencia=$existencia;
		}
		public function setApartado($apartado)
		{
			$this->apartado=$apartado;
		}
		public function setApartadoReal($apartadoReal)
		{
			$this->apartadoReal=$apartadoReal;
		}
		public function setTipoPrecio($tipoPrecio)
		{
			$this->tipoPrecio=$tipoPrecio;
		}
		public function setIsRango($isRango)
		{
			$this->isRango=$isRango;
		}
		public function setTipoRango($tipoRango)
		{
			$this->tipoRango=$tipoRango;
		}
		public function setIsRollo($isRollo)
		{
			$this->isRollo=$isRollo;
		}
		public function setHeredarPrecio($heredarPrecio)
		{
			
			$this->heredarPrecio=$heredarPrecio;
		}
		public function setHeredarPrecioSI()
		{
			$this->heredarPrecio='SI';
		}
		public function setHeredarPrecioNO()
		{
			$this->heredarPrecio='NO';
		}
		public function setCf($cf)
		{
			$this->cf=$cf;
		}
		public function setPrecio1($precio1)
		{
			$this->precio1=$precio1;
		}
		public function setPrecio2($precio2)
		{
			$this->precio2=$precio2;
		}
		public function setPrecio3($precio3)
		{
			$this->precio3=$precio3;
		}
		public function setPrecio4($precio4)
		{
			$this->precio4=$precio4;
		}
		public function setPreciomendez($preciomendez)
		{
			$this->preciomendez=$preciomendez;
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
		public function setIsRoofing($isRoofing)
		{
			
			$this->isRoofing=$isRoofing;
		}
		public function setIsRoofingNO()
		{
			$this->isRoofing='NO';
		}
		public function setIsRoofingSI()
		{
			$this->isRoofing='SI';
		}
		public function setMedidaespecial($medidaespecial)
		{
			
			$this->medidaespecial=$medidaespecial;
		}
		public function setCosto($costo)
		{
			$this->costo=$costo;
		}
		public function setIsSegunda($isSegunda)
		{
			
			$this->isSegunda=$isSegunda;
		}
		public function setIsSegundaSI()
		{
			$this->isSegunda='SI';
		}
		public function setIsSegundaNO()
		{
			$this->isSegunda='NO';
		}
		public function setLastUpdate($lastUpdate)
		{
			$this->lastUpdate=$lastUpdate;
		}
		public function setIdProveedor($idProveedor)
		{
			
			$this->idProveedor=$idProveedor;
		}
		public function setResurtir($resurtir)
		{
			
			$this->resurtir=$resurtir;
		}
		public function setResurtirNO()
		{
			$this->resurtir='NO';
		}
		public function setResurtirSI()
		{
			$this->resurtir='SI';
		}

		#------------------------------------------------------------------------------------------------------#
		#-----------------------------------------------Unsetter-----------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Getter------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		
		public function getIdProducto()
		{
			return $this->idProducto;
		}
		public function getCodigo()
		{
			return $this->codigo;
		}
		public function getLongitud()
		{
			return $this->longitud;
		}
		public function getMlpieza()
		{
			return $this->mlpieza;
		}
		public function getProducto_tipoProducto_idTipoProducto()
		{
			return $this->producto_tipoProducto_idTipoProducto;
		}
		public function getProducto_aplicacion_idAplicacion()
		{
			return $this->producto_aplicacion_idAplicacion;
		}
		public function getProducto_material_idMaterial()
		{
			return $this->producto_material_idMaterial;
		}
		public function getProducto_rollo_idRollo()
		{
			return $this->producto_rollo_idRollo;
		}
		public function getProducto_unidad_idUnidad()
		{
			return $this->producto_unidad_idUnidad;
		}
		public function getCalibre()
		{
			return $this->calibre;
		}
		public function getPies()
		{
			return $this->pies;
		}
		public function getOrigen()
		{
			return $this->origen;
		}
		public function getDescripcion()
		{
			return $this->descripcion;
		}
		public function getExistencia()
		{
			return $this->existencia;
		}
		public function getApartado()
		{
			return $this->apartado;
		}
		public function getApartadoReal()
		{
			return $this->apartadoReal;
		}
		public function getTipoPrecio()
		{
			return $this->tipoPrecio;
		}
		public function getIsRango()
		{
			return $this->isRango;
		}
		public function getTipoRango()
		{
			return $this->tipoRango;
		}
		public function getIsRollo()
		{
			return $this->isRollo;
		}
		public function getHeredarPrecio()
		{
			return $this->heredarPrecio;
		}
		public function getCf()
		{
			return $this->cf;
		}
		public function getPrecio1()
		{
			return $this->precio1;
		}
		public function getPrecio2()
		{
			return $this->precio2;
		}
		public function getPrecio3()
		{
			return $this->precio3;
		}
		public function getPrecio4()
		{
			return $this->precio4;
		}
		public function getPreciomendez()
		{
			return $this->preciomendez;
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
		public function getIsRoofing()
		{
			return $this->isRoofing;
		}
		public function getMedidaespecial()
		{
			return $this->medidaespecial;
		}
		public function getCosto()
		{
			return $this->costo;
		}
		public function getIsSegunda()
		{
			return $this->isSegunda;
		}
		public function getLastUpdate()
		{
			return $this->lastUpdate;
		}
		public function getIdProveedor()
		{
			return $this->idProveedor;
		}
		public function getResurtir()
		{
			return $this->resurtir;
		}

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Querys------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Otras-------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		protected function limpiarPropiedades()
		{
			
			$this->idProducto=0;
			$this->codigo='0';
			$this->longitud='';
			$this->mlpieza='0.00';
			$this->producto_tipoProducto_idTipoProducto=0;
			$this->producto_aplicacion_idAplicacion=0;
			$this->producto_material_idMaterial=0;
			$this->producto_rollo_idRollo=0;
			$this->producto_unidad_idUnidad=0;
			$this->calibre=0;
			$this->pies=0;
			$this->origen='N';
			$this->descripcion='';
			$this->existencia='0.00';
			$this->apartado='0';
			$this->apartadoReal='0';
			$this->tipoPrecio='';
			$this->isRango='';
			$this->tipoRango='';
			$this->isRollo='';
			$this->heredarPrecio='SI';
			$this->cf='0.00';
			$this->precio1='0.00';
			$this->precio2='0.00';
			$this->precio3='0.00';
			$this->precio4='0.00';
			$this->preciomendez='0.00';
			$this->estado='ACTIVO';
			$this->fecha_creacion='0000-00-00 00:00:00';
			$this->idUsuarioCrea=0;
			$this->fecha_modifica='0000-00-00 00:00:00';
			$this->idUsuarioModifica=0;
			$this->fecha_baja='0000-00-00 00:00:00';
			$this->idUsuarioBaja=0;
			$this->isRoofing='NO';
			$this->medidaespecial='';
			$this->costo='0';
			$this->isSegunda='NO';
			$this->lastUpdate='';
			$this->idProveedor=0;
			$this->resurtir='NO';
		}

		

		
		protected function Insertar()
		{
			try
			{
				$SQL="INSERT INTO " . $this->__tableName . " (codigo,
				                                              longitud,
				                                              mlpieza,
				                                              producto_tipoProducto_idTipoProducto,
				                                              producto_aplicacion_idAplicacion,
				                                              producto_material_idMaterial,
				                                              producto_rollo_idRollo,
				                                              producto_unidad_idUnidad,
				                                              calibre,
				                                              pies,
				                                              origen,
				                                              descripcion,
				                                              existencia,
				                                              apartado,
				                                              apartadoReal,
				                                              tipoPrecio,
				                                              isRango,
				                                              tipoRango,
				                                              isRollo,
				                                              heredarPrecio,
				                                              cf,
				                                              precio1,
				                                              precio2,
				                                              precio3,
															  precio4,
				                                              preciomendez,
				                                              estado,
				                                              fecha_creacion,
				                                              idUsuarioCrea,
				                                              fecha_modifica,
				                                              idUsuarioModifica,
				                                              fecha_baja,
				                                              idUsuarioBaja,
				                                              isRoofing,
				                                              medidaespecial,
				                                              costo,
				                                              isSegunda,
				                                              lastUpdate,
				                                              idProveedor,
				                                              resurtir)
						VALUES('" . mysqli_real_escape_string($this->dbLink,$this->codigo) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->longitud) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->mlpieza) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->producto_tipoProducto_idTipoProducto) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->producto_aplicacion_idAplicacion) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->producto_material_idMaterial) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->producto_rollo_idRollo) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->producto_unidad_idUnidad) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->calibre) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->pies) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->origen) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->descripcion) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->existencia) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->apartado) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->apartadoReal) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->tipoPrecio) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->isRango) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->tipoRango) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->isRollo) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->heredarPrecio) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->cf) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->precio1) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->precio2) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->precio3) . "',
							    '" . mysqli_real_escape_string($this->dbLink,$this->precio4) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->preciomendez) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->estado) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->fecha_creacion) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idUsuarioCrea) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->fecha_modifica) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idUsuarioModifica) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->fecha_baja) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idUsuarioBaja) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->isRoofing) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->medidaespecial) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->costo) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->isSegunda) . "',
				               " . mysqli_real_escape_string($this->dbLink,"now()") . ",
				               '" . mysqli_real_escape_string($this->dbLink,$this->idProveedor) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->resurtir) . "')";
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la insercion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseProducto::Insertar]");
				
				$this->idProducto=mysqli_insert_id($this->dbLink);
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
				$SQL="UPDATE " . $this->__tableName . " SET codigo='" . mysqli_real_escape_string($this->dbLink,$this->codigo) . "',
	                                              longitud='" . mysqli_real_escape_string($this->dbLink,$this->longitud) . "',
	                                              mlpieza='" . mysqli_real_escape_string($this->dbLink,$this->mlpieza) . "',
	                                              producto_tipoProducto_idTipoProducto='" . mysqli_real_escape_string($this->dbLink,$this->producto_tipoProducto_idTipoProducto) . "',
	                                              producto_aplicacion_idAplicacion='" . mysqli_real_escape_string($this->dbLink,$this->producto_aplicacion_idAplicacion) . "',
	                                              producto_material_idMaterial='" . mysqli_real_escape_string($this->dbLink,$this->producto_material_idMaterial) . "',
	                                              producto_rollo_idRollo='" . mysqli_real_escape_string($this->dbLink,$this->producto_rollo_idRollo) . "',
	                                              producto_unidad_idUnidad='" . mysqli_real_escape_string($this->dbLink,$this->producto_unidad_idUnidad) . "',
	                                              calibre='" . mysqli_real_escape_string($this->dbLink,$this->calibre) . "',
	                                              pies='" . mysqli_real_escape_string($this->dbLink,$this->pies) . "',
	                                              origen='" . mysqli_real_escape_string($this->dbLink,$this->origen) . "',
	                                              descripcion='" . mysqli_real_escape_string($this->dbLink,$this->descripcion) . "',
	                                              existencia='" . mysqli_real_escape_string($this->dbLink,$this->existencia) . "',
	                                              apartado='" . mysqli_real_escape_string($this->dbLink,$this->apartado) . "',
	                                              apartadoReal='" . mysqli_real_escape_string($this->dbLink,$this->apartadoReal) . "',
	                                              tipoPrecio='" . mysqli_real_escape_string($this->dbLink,$this->tipoPrecio) . "',
	                                              isRango='" . mysqli_real_escape_string($this->dbLink,$this->isRango) . "',
	                                              tipoRango='" . mysqli_real_escape_string($this->dbLink,$this->tipoRango) . "',
	                                              isRollo='" . mysqli_real_escape_string($this->dbLink,$this->isRollo) . "',
	                                              heredarPrecio='" . mysqli_real_escape_string($this->dbLink,$this->heredarPrecio) . "',
	                                              cf='" . mysqli_real_escape_string($this->dbLink,$this->cf) . "',
	                                              precio1='" . mysqli_real_escape_string($this->dbLink,$this->precio1) . "',
	                                              precio2='" . mysqli_real_escape_string($this->dbLink,$this->precio2) . "',
	                                              precio3='" . mysqli_real_escape_string($this->dbLink,$this->precio3) . "',
												  precio4='" . mysqli_real_escape_string($this->dbLink,$this->precio4) . "',
	                                              preciomendez='" . mysqli_real_escape_string($this->dbLink,$this->preciomendez) . "',
	                                              estado='" . mysqli_real_escape_string($this->dbLink,$this->estado) . "',
	                                              fecha_creacion='" . mysqli_real_escape_string($this->dbLink,$this->fecha_creacion) . "',
	                                              idUsuarioCrea='" . mysqli_real_escape_string($this->dbLink,$this->idUsuarioCrea) . "',
	                                              fecha_modifica='" . mysqli_real_escape_string($this->dbLink,$this->fecha_modifica) . "',
	                                              idUsuarioModifica='" . mysqli_real_escape_string($this->dbLink,$this->idUsuarioModifica) . "',
	                                              fecha_baja='" . mysqli_real_escape_string($this->dbLink,$this->fecha_baja) . "',
	                                              idUsuarioBaja='" . mysqli_real_escape_string($this->dbLink,$this->idUsuarioBaja) . "',
	                                              isRoofing='" . mysqli_real_escape_string($this->dbLink,$this->isRoofing) . "',
	                                              medidaespecial='" . mysqli_real_escape_string($this->dbLink,$this->medidaespecial) . "',
	                                              costo='" . mysqli_real_escape_string($this->dbLink,$this->costo) . "',
	                                              isSegunda='" . mysqli_real_escape_string($this->dbLink,$this->isSegunda) . "',
	                                              lastUpdate='" . mysqli_real_escape_string($this->dbLink,$this->lastUpdate) . "',
	                                              resurtir='" . mysqli_real_escape_string($this->dbLink,$this->resurtir) . "'
												  WHERE idProducto=" . $this->idProducto;
												  // return $SQL;
	                                            //   idProveedor='" . mysqli_real_escape_string($this->dbLink,$this->idProveedor) . "',
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la actualizacion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseProducto::Update]");
				
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
				WHERE idProducto=" . mysqli_real_escape_string($this->dbLink,$this->idProducto);
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en el borrado de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseProducto::Borrar]");
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
						idProducto,
						codigo,
						longitud,
						mlpieza,
						producto_tipoProducto_idTipoProducto,
						producto_aplicacion_idAplicacion,
						producto_material_idMaterial,
						producto_rollo_idRollo,
						producto_unidad_idUnidad,
						calibre,
						pies,
						origen,
						descripcion,
						existencia,
						apartado,
						apartadoReal,
						tipoPrecio,
						isRango,
						tipoRango,
						isRollo,
						heredarPrecio,
						cf,
						precio1,
						precio2,
						precio3,
						precio4,
						preciomendez,
						estado,
						fecha_creacion,
						idUsuarioCrea,
						fecha_modifica,
						idUsuarioModifica,
						fecha_baja,
						idUsuarioBaja,
						isRoofing,
						medidaespecial,
						costo,
						isSegunda,
						lastUpdate,
						idProveedor,
						resurtir
					FROM " . $this->__tableName . " 
					WHERE idProducto=" . mysqli_real_escape_string($this->dbLink,$this->idProducto);
					
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la obtencion de detalles de registro.","[ModeloBaseProducto::getDatos][" . $SQL . "][" . mysqli_error($this->dbLink) . "]");
				

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
			if($this->idProducto==0)
				$this->Insertar();
			else
				 $this->Actualizar();
			if($this->getError())
				return false;
			return true;
		}
		
	}

?>