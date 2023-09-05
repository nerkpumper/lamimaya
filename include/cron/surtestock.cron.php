<?php



if (isset($_SERVER['HTTP_HOST']))

	define("isCONSOLE",false);

	else

		define("isCONSOLE",true);



		function myLog($msg = "")

		{

			echo (isCONSOLE ? "\n" : "<br>").$msg;

		}



// 		define('FOLDER_INCLUDE', '../');

		//define('FOLDER_INCLUDE', '/home/nerkpump/includeappgalvamex/');

//		 define('FOLDER_INCLUDE', '/home/galvamex/appgalvamex/include/');

		require_once 'configinclude.cron.php';



		define("FOLDER_MODEL_BASE",FOLDER_INCLUDE . "model/base/");

		define("FOLDER_MODEL",FOLDER_INCLUDE . "model/extend/");

		define("LIB_CONEXION",FOLDER_INCLUDE . "lib/Conexion/Conexion.inc.php");

		define("LIB_CONEXION_MYSQL",FOLDER_INCLUDE . "lib/Conexion/ConexionMySQL.inc.php");



		require_once LIB_CONEXION;

		require_once FOLDER_INCLUDE . 'model/clsBasicCommon.inc.php';



		require_once FOLDER_MODEL . "model.pedido.inc.php";

		require_once FOLDER_MODEL. "model.pedidodetalle.inc.php";

		require_once FOLDER_MODEL. "model.invzmov.inc.php";





		$pd = new ModeloPedidodetalle();



		$lstDetalle = $pd->getAll("pedido.id_usuario_capturado, idPedidoDetalle, renglon, pedido.idPedido, pedidodetalle.idProducto, partida, cantidad, cantidadReal, producto.producto_unidad_idUnidad as idUnidad, producto.descripcion as producto ",

				"inner join pedido on pedidodetalle.idpedido = pedido.idpedido

                           inner join producto on producto.idProducto = pedidodetalle.idProducto ",

				" pedido.estado = 'PRODUCCION'

                            AND producto_unidad_idUnidad = 4

                            AND pedidodetalle.listo_para_producir = 'SI'

                            AND pedidodetalle.despachado = 'NO'",

				" pedido.idpedido");



		$idPedido = "0";

		$idPedidoAnterior = "0";



		myLog();

		myLog(date("Y-m-d H:i:s"). "    -              -- C O M I E N Z A ---------------------------------------------");



		foreach ($lstDetalle as $pedidodetalle)

		{

			// 	echo "<br><br>";

			// 	print_r($pedidodetalle);



			$blnDoCommit = true;

			$errores = "";

			$pd->transaccionIniciar();





			$idPedido = $pedidodetalle["idPedido"];



			if ($idPedidoAnterior != $idPedido)

			{

				myLog();

				myLog("---------------------------------------------------------------------------------------------------------------------------------------------");

				myLog("INICIO Pedido: <h1>" . $idPedido . "</h1>");

				myLog();



				$idPedidoAnterior = $idPedido;

			}



			myLog();

			myLog("R E N G L O N : " . $pedidodetalle["renglon"] ."        -idPedidoDetalle: ".$pedidodetalle["idPedidoDetalle"]."    -idProducto: ".$pedidodetalle["idProducto"]."    -partida: ".$pedidodetalle["partida"]."    -cantidad: ".$pedidodetalle["cantidad"]."    -cantidadReal: ".$pedidodetalle["cantidadReal"]);

			myLog();

			myLog("PRODUCTO: " . $pedidodetalle["producto"]);



			$inv = new ModeloInvzmov();



			$idPedidoDetalle = $pedidodetalle["idPedidoDetalle"];



			$inv->setIdProducto($pedidodetalle["idProducto"]);

			$inv->setDocumentoPEDIDO();

			$inv->setReferencia($idPedido);

			$inv->setMovimientoSALIDA();

			$inv->setSalidaDespachoSI();

			$inv->setCantidad($pedidodetalle["partida"]);

			$inv->setObservaciones("Despacho automático de pedido");

			$inv->setIdPedidoDetalle($idPedidoDetalle);



			$inv->setId_usuario_movimiento($pedidodetalle["id_usuario_capturado"]);

			$inv->setFecha_movimiento(date("Y-m-d H:i:s"));





			$inv->Guardar();



			if (!$inv->getError())

			{

				$pd = new ModeloPedidodetalle();



				$pd->setIdPedidoDetalle($idPedidoDetalle);



				if ($pd->getIdPedidoDetalle() <= 0)

				{

					$errores .= "No se pudo obtener el detalle del pedido.";

					$blnDoCommit = false;

				}

				else

				{

					if (($pd->getTotalExplotar() - $pd->getExplotadoReal()) <= 0)

					{

						$pd->setDespachadoSI();



						$pd->setId_usuario_despachado($pedidodetalle["id_usuario_capturado"]);

						$pd->setFecha_despachado(date("Y-m-d H:i:s"));





						myLog(" --> Producto D E S P A C H A D O");



						$pd->Guardar();



						if ($pd->getError())

						{

							$blnDoCommit = false;

							$errores .= $pd->getStrError();

						}

					}

				}



			}

			else

			{

				$blnDoCommit = false;

			}





			// 	echo "<br><br><br>" . $errores;



// 			$blnDoCommit = false;

			if ($blnDoCommit)

			{

				$pd->transaccionCommit();

				myLog("  ==::::::::::::::::::::::::::::> O K  <::::::::::::::::::::::::::::==");

				// 	$r->script("

				//  					    app.pedidoDetalle[app.indexDespachando].despachado = 'SI';

				//  						setTimeout(function() {xajax_cargarPedidoDetalle(".$idPedidoDetalle.", false);}, 10);

				//  						saSuccess(\"El movimiento se ha realizado de manera correcta.\");

				//  					    ");

			}

			else

			{

				$pd->transaccionRollback();



				myLog(" :::: Errores: " . $errores);

				// 	$r->script("saError(\"Ha ocurrido un error. ".$errores."\");");

			}



		}

		

		

		myLog();

		myLog();

		myLog();

		myLog(date("Y-m-d H:i:s"). "    -              -- C O M I E N Z A  M O L D U R A S---------------------------------------------");

		

		$pedidos = new ModeloPedido();

		

		$query = "

    SELECT distinct pd.idpedidodetalle

from pedidodetalle as pd

inner join pedido as p

on p.idpedido = pd.idpedido

where p.estado  IN ('PRODUCCION', 'AUTORIZADO')

and (

    pd.idproducto in (187,329,330,331,171,188,189,211,381)

    and pd.listo_para_producir = 'NO' and pd.despachado = 'NO')

    or (

		    

        pd.idproducto in (360)

        and pd.listo_para_producir = 'SI' and pd.despachado = 'NO'

        );

		    

";

		

		$lstPedidos = $pedidos->getDataSet($query);

		

		foreach ($lstPedidos as $pd)

		{

		    $pedidoDetalle = new ModeloPedidodetalle();

		    

		    $pedidoDetalle->setIdPedidoDetalle($pd["idpedidodetalle"]);

		    

		    if ($pedidoDetalle->getIdPedidoDetalle() > 0)

		    {

		        $pedidoDetalle->setPartidaDespachada($pedidoDetalle->getPartida());

		        $pedidoDetalle->setListo_para_producirSI();

		        $pedidoDetalle->setDespachadoSI();

		        $pedidoDetalle->setFecha_despachado(date("Y-m-d H:i:s"));

		        $pedidoDetalle->setId_usuario_despachado(2);

		        

		        $pedidoDetalle->Guardar();

		        

		        if ($pedidoDetalle->getError())

		        {

		            myLog("Error Al actualizar en molduras: idPedidoDetalle  " . $pd["idpedidodetalle"]);

		        }

		        else

		        {

		            myLog("Moldura Despachada idPedidoDetalle  " . $pd["idpedidodetalle"]);

		        }

		    }

		    

		    

		}

