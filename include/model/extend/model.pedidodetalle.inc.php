<?php

	require FOLDER_MODEL_BASE . "model.base.pedidodetalle.inc.php";
	require_once FOLDER_MODEL. "model.pedido.inc.php";

	class ModeloPedidodetalle extends ModeloBasePedidodetalle
	{
		#------------------------------------------------------------------------------------------------------#
		#----------------------------------------------Propiedades---------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		var $_nombreClase="ModeloBasePedidodetalle";

		var $__ss=array();
		var $__primaryKey="idPedidoDetalle";				
		var $__tableName="pedidodetalle";
		var $__tableEdit="pedidodetalleedit";
		var $__tableDelete="pedidodetalledelete";	

		var $_Old;			

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



		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Querys------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Otras-------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		
		public function validarDatos()
		{
			return true;
		}

		public function SaveOriginalValues()
		{
			$this->_Old = new stdClass();
			$this->_Old->despachado = $this->despachado;			
		}

		public function AfterUpdate()
		{
			if ($this->_Old->despachado == "NO" && $this->despachado == "SI")
			{
				$sql = "SELECT ifnull(count(*), 0) despachados, cliente.idUsuarioPromotor, pedido.id_usuario_capturado 
					      FROM pedidodetalle 
					      inner join pedido on pedido.idpedido = pedidodetalle.idpedido
					      inner join cliente on cliente.idcliente = pedido.idcliente
						 WHERE pedidodetalle.idpedido = ".$this->IdPedido."
					       AND pedidodetalle.despachado = 'NO'; ";
				
				$ds = $this->getDataSet($sql);

				// print_r($ds);

				if ($ds != null)
				{
					if (intval($ds[0]["despachados"]) == 0)
					{
						// echo "<br>AQUI";
						$idPromotor = $ds[0]["idUsuarioPromotor"];
						$idCapturado = $ds[0]["id_usuario_capturado"];
						$pedido = new ModeloPedido();
						$pedido->setIdPedido($this->IdPedido);
						$pedido->setDespachadoSI();
						$pedido->setEstadoTERMINADO();
						$pedido->setFecha_terminado($this->fecha_despachado);
						$pedido->setId_usuario_terminado($this->id_usuario_despachado);

						$pedido->Guardar();

						if (!$pedido->getError())
						{
							$idsToSend = array();
							array_push($idsToSend, $idCapturado);
							if ($idPromotor != $idCapturado)
							{
								array_push($idsToSend, $idPromotor);
							}
								
							NotificationManager::WA_EstatusPedido($idsToSend, $this->IdPedido, "TERMINADO");
// echo "<br>test " . __LINE__;
						}

					}
				}


				
				
				
			}
		}



	}

