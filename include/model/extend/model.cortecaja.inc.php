<?php

	require FOLDER_MODEL_BASE . "model.base.cortecaja.inc.php";
	require_once FOLDER_MODEL. "model.sucursal.inc.php";
	require_once FOLDER_MODEL . "model.notificacionescortes.inc.php";

	class ModeloCortecaja extends ModeloBaseCortecaja
	{
		#------------------------------------------------------------------------------------------------------#
		#----------------------------------------------Propiedades---------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		var $_nombreClase="ModeloBaseCortecaja";

		var $__ss=array();
		var $__primaryKey="idCorteCaja";				
		var $__tableName="cortecaja";
		var $__tableEdit="cortecajaedit";
		var $__tableDelete="cortecajadelete";				

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

		public function NotificarPasarPorEfectivo($idSucursal)
		{
			if ($idSucursal > 0)
			{				
				// Validar si enviamos la notificacion o no
				$hora = intval(date("H"));
				// echo "<br><br>";
				// echo $hora;
				$turno = "";
				if ($hora >= 16)
				{
					$turno = "V";
				}
				else
				{
					if ($hora >= 10)
					{
						$turno = "M";
					}
				}

				if ($turno == "")
				{
					return;
				}

				// echo "<br><br>Turno: ".$turno;

				$sql = "SELECT id 
						FROM notificacionescortes 
						WHERE DATE_FORMAT(fecha, '%Y-%m-%d') = DATE_FORMAT(NOW(), '%Y-%m-%d')
						AND idSucursal = " .$idSucursal . 
						" AND turno = '".$turno."'";


				$nc = new ModeloNotificacionescortes();

				$regs = $nc->getDataSet($sql);

				// echo "<br><br>Count: " . count($regs);	
				
				if (count($regs) > 0)
				{
					// echo "hay datos, regresar";
					return;
				}

				// echo "Sin datos, mandar notificacion y guardar";
				$nc->setIdSucursal($idSucursal);
				$nc->setFecha($nc->NOW());
				$nc->setTurno($turno);

				$nc->Guardar();

				// Fin validar si enviamos la notificacion o no

				$sql = "SELECT * FROM cortecaja WHERE idSucursal = " . $idSucursal." AND estado = 'ABIERTO'";

				$corteCaja = new ModeloCortecaja();
				
				$rs = $corteCaja->getDataSet($sql);

				if (!$rs)
				{
					return;
				}

				$objCorteCaja = $rs[0];

				$fechaApertura = $objCorteCaja["fecha_apertura"];
				
				
				$sql = "SELECT (
								SELECT SUM(cxc.monto) 
								FROM cxc   
								LEFT JOIN pedido ON cxc.idPedido = pedido.idpedido AND pedido.fecha_capturado > '".$fechaApertura."' 
								INNER JOIN usuario on usuario.idUsuario = cxc.id_usuario_movimiento
								WHERE cxc.fecha_movimiento > '".$fechaApertura."' 
								AND cxc.movimiento = 'ABONO'
								AND cxc.formaPago = 1
								AND usuario.idSucursal = ".$idSucursal."
								AND pedido.idPedido IS NOT NULL) as venta,
						(
						SELECT SUM(cxc.monto) 
								FROM cxc   
								LEFT JOIN pedido ON cxc.idPedido = pedido.idpedido AND pedido.fecha_capturado > '".$fechaApertura."' 
								INNER JOIN usuario on usuario.idUsuario = cxc.id_usuario_movimiento
								WHERE cxc.fecha_movimiento > '".$fechaApertura."'
								AND cxc.movimiento = 'ABONO'
								AND cxc.formaPago = 1
								AND usuario.idSucursal = ".$idSucursal."
								AND pedido.idPedido IS NULL) as abono,
						(
						SELECT IFNULL(SUM(gasto.monto), 0)
								FROM gasto                         
								WHERE gasto.fecha_insert > '".$fechaApertura."' 
								AND gasto.idSucursal = " .$idSucursal .") as gastos,
						(
						SELECT  IFNULL(SUM(recibodinero.monto), 0)
								FROM recibodinero                      
								INNER JOIN usuario ON recibodinero.id_usuario_captura = usuario.idUsuario     
								WHERE recibodinero.fecha_captura > '".$fechaApertura."' 
								AND recibodinero.formaPago = 1 
								AND usuario.idSucursal = ".$idSucursal.") recibodinero
						
						";
				
				
				$rsEfectivos = $corteCaja->getDataSet($sql)[0];

				$venta = $rsEfectivos["venta"];
				$abono = $rsEfectivos["abono"];
				$gastos = $rsEfectivos["gastos"];
				$recibodinero = $rsEfectivos["recibodinero"];

				$totalEfectivo = floatval($venta) + floatval($abono) - floatval($gastos) + floatval($recibodinero);
				if ($totalEfectivo >= 25000)
				{
					$sucursal = new ModeloSucursal();

					$sucursal->setIdSucursal($idSucursal);										
					$idsToSend = array();
				
					array_push($idsToSend, 2);
					array_push($idsToSend, 6);
					array_push($idsToSend, 41);
					if ($idSucursal == 1)
					{
						array_push($idsToSend, 14);
					}
					NotificationManager::WA_CorteCaja($idsToSend, $sucursal->getNombre(), floatval($totalEfectivo));
					
				}
			}
		}


	}

