<?php



	// ----------------------------------------------------------------------------------------------------------------------#

	// -------------------------------------------------------Includes-------------------------------------------------------#

	// ----------------------------------------------------------------------------------------------------------------------#



	require_once FOLDER_MODEL. "model.rollo.inc.php";

	require_once FOLDER_MODEL. "model.viewrollos.inc.php";	

	require_once FOLDER_MODEL. "model.remisionrollo.inc.php";

	require_once FOLDER_MODEL. "model.invzmovrollo.inc.php";

	

	// ----------------------------------------------------------------------------------------------------------------------#

	// -------------------------------------------------------Funciones------------------------------------------------------#

	// ----------------------------------------------------------------------------------------------------------------------#





	// ----------------------------------------------------------------------------------------------------------------------#

	// -----------------------------------------------------Seccion AJAX-----------------------------------------------------#

	// ----------------------------------------------------------------------------------------------------------------------#

	$xajax = new xajax();

// 	$xajax->setCharEncoding('ISO-8859-1');

	//$xajax->de decodeUTF8InputOn();

	

//  	ob_start();	

// 	echo "hola mundito";

// 	$debug = ob_get_clean();

// 	$r->mostrarMsgs($debug);

		

	function obtenerReporte($idRollo, $reportMovimientos, $desde, $hasta)

	{

		$r = new xajaxResponse();

	

		$movimientos = new ModeloInvzmovrollo();

	

		$addWhere = "";

	

		if ($reportMovimientos == "ES")

		{

			$addWhere .= "movimiento IN ('ENTRADA','SALIDA') ";

		}

		elseif ($reportMovimientos == "E")

		{

			$addWhere .= "movimiento IN ('ENTRADA') ";

		}

		else

		{

			$addWhere .= "movimiento IN ('SALIDA') ";

		}

	

	

		if ($desde != "" && $hasta != "")

		{

			$desde = substr($desde, 6, 10) . "-" . substr($desde, 3, 2) . "-" . substr($desde, 0, 2);

			$hasta = substr($hasta, 6, 10) . "-" . substr($hasta, 3, 2) . "-" . substr($hasta, 0, 2);

				

			$addWhere .= " AND date_format(fecha_movimiento, '%Y-%m-%d') BETWEEN '".$desde."' AND '".$hasta."' ";

		}

			

// 		$sql = $movimientos->getAllQUERY("fecha_movimiento, concat(nombre, ' ', apellidoPaterno, ' ' , apellidoMaterno) as usrMovimiento, documento, referencia, movimiento, 

//                                      existenciaRollo, cantidad, IF(movimiento = 'ENTRADA', existenciaRollo + cantidad, existenciaRollo - cantidad) as saldo,

//                                      observaciones",

// 				                   " INNER JOIN usuario as u ON u.idUsuario = id_usuario_movimiento ", " idRollo = " . $idRollo ." AND " . $addWhere, " idInvzmovRollo DESC ");

		$lst = $movimientos->getAll("fecha_movimiento, concat(nombre, ' ', apellidoPaterno, ' ' , apellidoMaterno) as usrMovimiento, documento, referencia, movimiento, 

                                     existenciaRollo, cantidad, IF(movimiento = 'ENTRADA', existenciaRollo + cantidad, existenciaRollo - cantidad) as saldo,

                                     observaciones",

				                   " INNER JOIN usuario as u ON u.idUsuario = id_usuario_movimiento ", " idRollo = " . $idRollo ." AND " . $addWhere, " idInvzmovRollo DESC ");

	

		$datosTabla = "";

	

		foreach ($lst as $row)

		{

			$referencia = "";

			

			if ($row["documento"] == "PEDIDO")

			{

				$referencia = "PEDIDO " . $row["referencia"];

			}

			else if ($row["documento"] == "REMISION")

			{

				$referencia = "REMISION " . $row["referencia"];

			}

			else

			{

				$referencia = "";

			}

			

			

			

			$datosTabla .= "<tr>";

			$datosTabla .= " <td>". clsUtilerias::formatoFecha(substr($row["fecha_movimiento"], 0, 16))."</td>";

			$datosTabla .= " <td>".$row["usrMovimiento"]."</td>";

			$datosTabla .= " <td>".$referencia."</td>";

			$datosTabla .= " <td>".number_format($row["existenciaRollo"], 2)."</td>";

			$datosTabla .= " <td>".($row["movimiento"] == "SALIDA" ? "-" : ""). number_format($row["cantidad"], 2)."</td>";

			$datosTabla .= " <td>".number_format($row["saldo"], 2)."</td>";

			$datosTabla .= " <td>".$row["observaciones"]."</td>";

			$datosTabla .= "</tr>";

		}

	

		$r->assign("tblMovimientosTodosBody", "innerHTML", ($datosTabla != "" ? $datosTabla : "No se encontraron coincidencias" ));

// 		$r->assign("tblMovimientosTodosBody", "innerHTML", $sql);

	

		return $r;

	}

	$xajax->registerFunction("obtenerReporte");

	

	

	function cargarRollo($idRollo)

	{

		$r = new xajaxResponse();

		

		$rollo= new ModeloViewrollos();

					

		if ($idRollo <= 0)

		{

			$r->saError("No se han podido cargar los datos del rollo.");

			$r->redirect(URL_BASE . "rollo", 2);

			return $r;

		}			

		

		$rollo->getView($idRollo);

		

		//verifica si el rollo fue cargado

		if ($rollo->getIdRollo() <= 0)

		{

			$r->saError("No se han podido cargar los datos del rollo.");

			$r->redirect(URL_BASE . "rollo", 2);

			return $r;

		}

		

		$proveedor = $rollo->getProveedor();

		$proveedor = str_replace("--NO APLICA--", "", $proveedor);

		

		//$r->saSuccess($rollo->getIdRollo()); return $r;

		//$rollo->varDump($rollo);

		

		 	

		

		$r->script("								

                    app.codigo = '" . $rollo->getCodigo() . "';

					app.material = '" . $rollo->getMaterial() . "';

					app.proveedor = '" . $proveedor . "';

					app.calibre = '" . $rollo->getCalibre() . "';

					app.pies = '" . $rollo->getPies() . "';

                    app.descripcion = '" . $rollo->getDescripcion() . "'; 

					app.existencia = ".round($rollo->getExistencia(),2).";

					app.cargarRemisiones();

				  ");

		

		

		return $r;

	}	

	$xajax->registerFunction("cargarRollo");

	

	function cargarSoloRollo($idRollo)

	{

		$r = new xajaxResponse();

	

		$rollo= new ModeloViewrollos();

			

		if ($idRollo <= 0)

		{

			$r->saError("No se han podido cargar los datos del rollo.");

			$r->redirect(URL_BASE . "rollo", 2);

			return $r;

		}

	

		$rollo->getView($idRollo);

	

		//verifica si el rollo fue cargado

		if ($rollo->getIdRollo() <= 0)

		{

			$r->saError("No se han podido cargar los datos del rollo.");

			$r->redirect(URL_BASE . "rollo", 2);

			return $r;

		}

	

		$proveedor = $rollo->getProveedor();

		$proveedor = str_replace("--NO APLICA--", "", $proveedor);

	

		$r->script("

                    app.codigo = '" . $rollo->getCodigo() . "';

					app.material = '" . $rollo->getMaterial() . "';

					app.proveedor = '" . $proveedor . "';

					app.calibre = '" . $rollo->getCalibre() . "';

					app.pies = '" . $rollo->getPies() . "';

                    app.descripcion = '" . $rollo->getDescripcion() . "';

					app.existencia = ".round($rollo->getExistencia(),2).";					

				  ");

	

	

		return $r;

	}

	$xajax->registerFunction("cargarSoloRollo");

	

	function cargarRemisiones($idRollo)

	{

		$r = new xajaxResponse();

	

		$rollo= new ModeloRemisionrollo();

// 		$r->mostrarAviso("Rollos"); return $r;

		if ($idRollo <= 0)

		{

			$r->saError("No se han podido cargar los datos del rollo.");

			$r->redirect(URL_BASE . "rollo", 2);

			return $r;

		}

	

				

// 		$lst = $rollo->getAll("",""," remisionRollo_rollo_idRollo = ".$idRollo." AND existencia > 0 "," existencia asc " );

		$lst = $rollo->getAll("idRemisionRollo, remision, almacen, noRollo, kilos, existencia, ts, estado ","","estado <> 'BAJA' and remisionRollo_rollo_idRollo = ".$idRollo."  "," existencia asc " );

//		$r->mostrarAviso($rollo->getAllQUERY("",""," remisionRollo_rollo_idRollo = ".$idRollo."  "," existencia asc " ));

		$pushes = "";

		

		foreach ($lst as $row)

		{

			$pushes .= "app.remisiones.push({idRemisionRollo: ".$row["idRemisionRollo"].", remision: '".$row["remision"]."', almacen: '".$row["almacen"]."', noRollo: '".$row["noRollo"]."', kilos: ".$row["kilos"].", disponible: ".$row["existencia"].", fecha: '".$row["ts"]."', estado: '".$row["estado"]."'});";

		}

	

		$r->script("app.remisiones.splice(0, app.remisiones.length); " .$pushes);

	

		return $r;

	}

	$xajax->registerFunction("cargarRemisiones");

	

	function borrarRemisionRollo($idRollo, $idRemisionRollo, $index)

	{		

		$r = new xajaxResponse();

		

		$remisionRollo = new ModeloRemisionrollo();

		

		$remisionRollo->setIdRemisionRollo($idRemisionRollo);

		

		if ($remisionRollo->getIdRemisionRollo() <= 0)

		{

			$r->saError("No se han podido cargar los datos del no. rollo.");			

			return $r;

		}

		

		$mov = new ModeloInvzmovrollo();

		

		$mov->setIdRollo($idRollo);

		$mov->setIdRemisionRollo($idRemisionRollo);

		$mov->setDocumentoNINGUNO();

		$mov->setReferencia("R: " . $remisionRollo->getRemision() . " #: " . $remisionRollo->getNoRollo());

		$mov->setMovimientoSALIDA();

		$mov->setSalidaDespachoNO();

		$mov->setCantidad($remisionRollo->getExistencia());

		$mov->setObservaciones("Eliminacion de No. Rollo");

		$mov->setDateAndUser("movimiento");

		

		$remisionRollo->setNoRollo($remisionRollo->getNoRollo() . "_del_".date("YmdHis"));

		$remisionRollo->setEstadoBAJA();

		$remisionRollo->setDateAndUser("baja");

		$remisionRollo->setRemisionRollo_rollo_idRollo($remisionRollo->getRemisionRollo_rollo_idRollo() + 1000);

		

		

		$mov->Guardar();

		

		if (!$mov->getError())		

		{

		

		    $remisionRollo->Guardar();

		    

		    

		    

		    if (!$remisionRollo->getError())

		    {

		        $r->script("

				   app.remisiones.splice(".$index.", 1);

				   app.cargarSoloRollo(".$idRollo.");

				   setTimeout(function() { xajax_cargarRollo(app.idRollo); }, 200);

				   saSuccess(\"El No. Rollo ha sido eliminado de manera correcta.\");

				");

		    }

		    else

		    {

		        $r->script("

				   app.remisiones.splice(".$index.", 1);

				   app.cargarSoloRollo(".$idRollo.");

				   setTimeout(function() { xajax_cargarRollo(app.idRollo); }, 200);

				   saInfo(\"El No. Rollo ha sido descontado pero no se elimin�.\");

				");

		    }

		    

			

		}

		else

		{

			$r->saError("Ocurri� un error al intentar eliminar el No. Rollo. " . $mov->getStrError());

		}

	

// 		this.ingresos.splice(index, 1);

		

	

		return $r;

	}

	$xajax->registerFunction("borrarRemisionRollo");

	

	function cargarRemisionRollo($idRemisionRollo)

	{

		$r = new xajaxResponse();

	

		$remisionRollo= new ModeloRemisionrollo();

			

		if ($idRemisionRollo <= 0)

		{

			$r->saError("No se han podido cargar los datos del No Rollo.");

			

			return $r;

		}

	

		$remisionRollo->setIdRemisionRollo($idRemisionRollo);

	

		//verifica si el rollo fue cargado

		if ($remisionRollo->getIdRemisionRollo() <= 0)

		{

			$r->saError("No se han podido cargar los datos del No. Rollo.");

			

			return $r;

		}



		$r->script("

                    app.noRollo = '" . $remisionRollo->getNoRollo() . "';					

					app.existenciaNoRollo = ".$remisionRollo->getExistencia().";

					

				  ");

	

	

		return $r;

	}

	$xajax->registerFunction("cargarRemisionRollo");

	

	function obtenerReporteRemisionRollo($idRemisionRollo, $reportMovimientos, $desde, $hasta)

	{

		$r = new xajaxResponse();

	

		$movimientos = new ModeloInvzmovrollo();

	

		$addWhere = "";

	

		if ($reportMovimientos == "ES")

		{

			$addWhere .= "movimiento IN ('ENTRADA','SALIDA') ";

		}

		elseif ($reportMovimientos == "E")

		{

			$addWhere .= "movimiento IN ('ENTRADA') ";

		}

		else

		{

			$addWhere .= "movimiento IN ('SALIDA') ";

		}

	

	

		if ($desde != "" && $hasta != "")

		{

			$desde = substr($desde, 6, 10) . "-" . substr($desde, 3, 2) . "-" . substr($desde, 0, 2);

			$hasta = substr($hasta, 6, 10) . "-" . substr($hasta, 3, 2) . "-" . substr($hasta, 0, 2);

	

			$addWhere .= " AND date_format(fecha_movimiento, '%Y-%m-%d') BETWEEN '".$desde."' AND '".$hasta."' ";

		}

			

		$lst = $movimientos->getAll("fecha_movimiento, concat(nombre, ' ', apellidoPaterno, ' ' , apellidoMaterno) as usrMovimiento, documento, referencia, 

									movimiento, existenciaNoRollo, cantidad, IF(movimiento = 'ENTRADA', existenciaNoRollo + cantidad, existenciaNoRollo - cantidad) as saldo, observaciones ",

							" INNER JOIN usuario as u ON u.idUsuario = id_usuario_movimiento ", " idRemisionRollo = " . $idRemisionRollo ." AND " . $addWhere, " idInvzmovRollo DESC ");

	

		$datosTabla = "";

	

		foreach ($lst as $row)

		{

			$referencia = "";

				

			if ($row["documento"] == "PEDIDO")

			{

				$referencia = "PEDIDO " . $row["referencia"];

			}

			else if ($row["documento"] == "REMISION")

			{

				$referencia = "REMISION " . $row["referencia"];

			}

			else

			{

				$referencia = "";

			}

				

				

				

			$datosTabla .= "<tr>";

			$datosTabla .= " <td>".clsUtilerias::formatoFecha(substr($row["fecha_movimiento"], 0, 16))."</td>";

			$datosTabla .= " <td>".$row["usrMovimiento"]."</td>";

			$datosTabla .= " <td>".$referencia."</td>";

			$datosTabla .= " <td>".$row["existenciaNoRollo"]."</td>";

			$datosTabla .= " <td>".($row["movimiento"] == "SALIDA" ? "-" : "").$row["cantidad"]."</td>";

			$datosTabla .= " <td>".$row["saldo"]."</td>";

			$datosTabla .= " <td>".$row["observaciones"]."</td>";

			$datosTabla .= "</tr>";

		}

	

		$r->assign("tblMovimientosRemisionRolloTodosBody", "innerHTML", ($datosTabla != "" ? $datosTabla : "No se encontraron coincidencias" ));

	

		return $r;

	}

	$xajax->registerFunction("obtenerReporteRemisionRollo");



	

	$xajax->processRequest();



	#----------------------------------------------------------------------------------------------------------------------#

	#---------------------------------------------Procesamiento de formulario----------------------------------------------#

	#----------------------------------------------------------------------------------------------------------------------#





	#----------------------------------------------------------------------------------------------------------------------#

	#---------------------------------------------Inicializacion de variables----------------------------------------------#

	#----------------------------------------------------------------------------------------------------------------------#

	



	#----------------------------------------------------------------------------------------------------------------------#

	#-------------------------------------------------Salida de Javascript-------------------------------------------------#

	#----------------------------------------------------------------------------------------------------------------------#

		