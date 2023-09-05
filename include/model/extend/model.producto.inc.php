<?php

	require FOLDER_MODEL_BASE . "model.base.producto.inc.php";
	require_once FOLDER_MODEL. "model.tipoproducto.inc.php";	
	require_once FOLDER_MODEL. "model.aplicacion.inc.php";	
	require_once FOLDER_MODEL. "model.material.inc.php";	
	require_once FOLDER_MODEL. "model.rollo.inc.php";
	

	class ModeloProducto extends ModeloBaseProducto
	{
		#------------------------------------------------------------------------------------------------------#
		#----------------------------------------------Propiedades---------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		var $_nombreClase="ModeloBaseProducto";

		var $__ss=array();
		var $__primaryKey="idProducto";				
		var $__tableName="producto";
		var $__tableEdit="productoedit";
		var $__tableDelete="productodelete";	

		var $favorito= 'NO';			

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

		public function setFavorito($favorito)
		{
			
			$this->favorito = $favorito;
		}


		#------------------------------------------------------------------------------------------------------#
		#-----------------------------------------------Unsetter-----------------------------------------------#
		#------------------------------------------------------------------------------------------------------#




		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Getter------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		public function getFavorito()
		{
			
			return $this->favorito;
		}

		public function getDatosReferencia()		
		{		
			$this->TipoProducto=new ModeloTipoproducto();
		
			if($this->getProducto_tipoProducto_idTipoProducto() !=0)
		
			{
		
				$this->TipoProducto->setIdTipoProducto($this->getProducto_tipoProducto_idTipoProducto());
		
			}			
		
			$this->Aplicacion=new ModeloAplicacion();
		
			if($this->getProducto_aplicacion_idAplicacion() !=0)
		
			{
		
				$this->Aplicacion->setIdAplicacion($this->getProducto_aplicacion_idAplicacion());
		
			}				
		
			$this->Material=new ModeloMaterial();
		
			if($this->getProducto_material_idMaterial() !=0)
		
			{
		
				$this->Material->setIdMaterial($this->getProducto_material_idMaterial());
		
			}			
		
			$this->Rollo=new ModeloRollo();
		
			if($this->getProducto_rollo_idRollo() !=0)
		
			{
		
				$this->Rollo->setIdRollo($this->getProducto_rollo_idRollo());
		
			}
		
		
		}
		

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Querys------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Otras-------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		
		public function addApartar($cantidad)
		{
			$this->apartado += $cantidad;
		}
		
		public function desApartar($cantidad)
		{
			$this->apartado -= $cantidad;
		}
		
		public function desApartarReal($cantidad)
		{
			$this->apartadoReal -= $cantidad;
		}
		
		public function validarDatos()
		{
			return true;
		}


	}

