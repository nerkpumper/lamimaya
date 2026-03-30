<?php

function salir()
{
	echo "<script>
					window.close();
		</script>";
	return;
}

function normaliza ($cadena){
//  	$originales  = 'Ãƒâ‚¬Ãƒï¿½Ãƒâ€šÃƒÆ’Ãƒâ€žÃƒâ€¦Ãƒâ€ Ãƒâ€¡ÃƒË†Ãƒâ€°ÃƒÅ Ãƒâ€¹ÃƒÅ’Ãƒï¿½ÃƒÅ½Ãƒï¿½Ãƒï¿½Ãƒâ€˜Ãƒâ€™Ãƒâ€œÃƒâ€�Ãƒâ€¢Ãƒâ€“ÃƒËœÃƒâ„¢ÃƒÅ¡Ãƒâ€ºÃƒÅ“Ãƒï¿½ÃƒÅ¾ÃƒÅ¸ÃƒÂ ÃƒÂ¡ÃƒÂ¢ÃƒÂ£ÃƒÂ¤ÃƒÂ¥ÃƒÂ¦ÃƒÂ§ÃƒÂ¨ÃƒÂ©ÃƒÂªÃƒÂ«ÃƒÂ¬ÃƒÂ­ÃƒÂ®ÃƒÂ¯ÃƒÂ°ÃƒÂ±ÃƒÂ²ÃƒÂ³ÃƒÂ´ÃƒÂµÃƒÂ¶ÃƒÂ¸ÃƒÂ¹ÃƒÂºÃƒÂ»ÃƒÂ½ÃƒÂ½ÃƒÂ¾ÃƒÂ¿Ã…â€�Ã…â€¢Ã¯Â¿Â½';
//  	$modificadas = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRro';

  	$originales  = 'Ã ,Ã¡,Ã¢,Ã£,Ã¤,Ã§,Ã¨,Ã©,Ãª,Ã«,Ã¬,Ã­,Ã®,Ã¯,Ã±,Ã²,Ã³,Ã´,Ãµ,Ã¶,Ã¹,Ãº,Ã»,Ã¼,Ã½,Ã¿,Ã€,Ã�,Ã‚,Ãƒ,Ã„,Ã‡,Ãˆ,Ã‰,ÃŠ,Ã‹,ÃŒ,Ã�,ÃŽ,Ã�,Ã‘,Ã’,Ã“,Ã”,Ã•,Ã–,Ã™,Ãš,Ã›,Ãœ,Ã�';
  	$modificadas = 'a,a,a,a,a,c,e,e,e,e,i,i,i,i,n,o,o,o,o,o,u,u,u,u,y,y,A,A,A,A,A,C,E,E,E,E,I,I,I,I,N,O,O,O,O,O,U,U,U,U,Y';

  	$cadena = mb_convert_encoding($cadena, 'ISO-8859-1', 'UTF-8');
 	$cadena = strtr($cadena, mb_convert_encoding($originales, 'ISO-8859-1', 'UTF-8'), $modificadas);
  	$cadena = strtolower($cadena);
	
	return $cadena;
}

$idCorteCaja = 0;
$fechaInicial = '';
$fechaFinal = '';
$idSucursal = 0;

if (isset($_GET['idCorteCaja']))
{
    $idCorteCaja = $_GET['idCorteCaja'];

	if ($idCorteCaja <= 0)
	{
		echo "Id Corte Caja invalido";
		return;
	}
}
else
{
	echo "Id Corte Caja invalido";
	return;
}

if (isset($_GET['fechaFinal']))
{
	$fechaFinal = $_GET['fechaFinal'];
}




if (PHP_SAPI == 'cli')
	die('Este archivo solo se puede ver desde un navegador web');

/** Se agrega la libreria PHPExcel */
require_once FOLDER_INCLUDE . 'lib/PHPExcel/PHPExcel.php';
require_once LIB_CONEXION_MYSQL;

// Se crea el objeto PHPExcel
$objPHPExcel = new PHPExcel();
	
		
		$estiloTituloReporte = array(
        	'font' => array(
	        	'name'      => 'Arial',
    	        'bold'      => true,
        	    'italic'    => false,
                'strike'    => false,
               	'size' =>16,
	            	'color'     => array(
    	            	'rgb' => '000000'
        	       	)
            ), 
            'alignment' =>  array(
        			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        			'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        			'rotation'   => 0,
        			'wrap'          => TRUE
    		)
        );

		$estiloSobresaliente = array(
        	'font' => array(
	        	'name'      => 'Arial',
    	        'bold'      => true,
        	    'italic'    => false,
                'strike'    => false,
               	'size' =>12,
	            	'color'     => array(
    	            	'rgb' => '000000'
        	       	)
            )
        );
		
		$estiloHeader = array(
				'font' => array(
						'name'      => 'Arial',
						'bold'      => true,
						'italic'    => false,
						'strike'    => false,
						'size' =>10,
						'color'     => array(
								'rgb' => '000000'
						)
				),				
				'alignment' =>  array(
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
						'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
						'rotation'   => 0,
						'wrap'          => TRUE
				)
		);		
		
		$estiloDatosLabelRollo = array(
				'font' => array(
						'name'      => 'Arial',
						'bold'      => true,
						'italic'    => false,
						'strike'    => false,
						'size' =>10,
						'color'     => array(
								'rgb' => '000000'
						)
				),
				'alignment' =>  array(
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
						'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
						'rotation'   => 0,
						'wrap'          => TRUE
				)
		);
		
		$estiloDatosRollo = array(
				'font' => array(
						'name'      => 'Arial',
						'bold'      => false,
						'italic'    => false,
						'strike'    => false,
						'size' =>10,
						'color'     => array(
								'rgb' => '000000'
						)
				),
				'alignment' =>  array(
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
						'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
						'rotation'   => 0,
						'wrap'          => TRUE
				)
		);


       	$styleArray = array(
       				'borders' => array(
       						'allborders' => array(
       								'style' => PHPExcel_Style_Border::BORDER_THIN,
       								'color' => array('argb' => 'FF000000'),
       						),
       				)
       		);
       	
       	$estiloFirma = array(
       			'borders' => array(
       					'top' => array(
       							'style' => PHPExcel_Style_Border::BORDER_THIN,
       							'color' => array('argb' => 'FF000000'),
       					),
       			),
       			'alignment' =>  array(
       					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
       					'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
       					'rotation'   => 0,
       					'wrap'          => TRUE
       			)
       	);


		// Se asignan las propiedades del libro
$objPHPExcel->getProperties()->setCreator("Galvamex App") //Autor
					 ->setLastModifiedBy("Galvamex App") //Ultimo usuario que lo modificÃƒÆ’Ã‚Â³
					 ->setTitle("Reporte Detalle Corte Caja")
					 ->setSubject("Reporte Detalle Corte Caja")
					 ->setDescription("Reporte Detalle Corte Caja")
					 ->setKeywords("reporte detalle corte cierre caja")
					 ->setCategory("Reporte Galvamex");

$objPHPExcel->getActiveSheet()
				 ->getPageSetup()
				 ->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);

$objPHPExcel->getActiveSheet()
				 ->getPageSetup()
				 ->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
				 

					 

$tituloReporte = "REPORTE DETALLADO DE CORTE DE CAJA";
$titulosColumnas = array('PEDIDO', 'FACTURAS', 'MONTO', 'FECHA MOVIMIENTO', 'CLIENTE', 'USUARIO');

$currentRow = 0;		
for ($i = 1 ; $i <= 2 ; $i++)
{
	$currentRow ++;
	$objPHPExcel->setActiveSheetIndex(0)
      		    ->mergeCells('C'.$i.':E'.$i);


}

$rowFechas = $currentRow++;
$rowFolio = $currentRow++;
$rowSucursal = $currentRow++;
$rowFondoCaja = $currentRow++;
$rowVentas = $currentRow++;
$rowAbonos = $currentRow++;
$rowEntradas = $currentRow++;
$rowSalidas = $currentRow++;
$rowTotalEfectivo = $currentRow++;
$rowDejaCaja = $currentRow++;
$rowTotalRetirar = $currentRow++;

$fondoCaja = 0;


$totalEfectivo = 0;
$totalVentas = 0;
$totalAbonos = 0;
$totalEntradas = 0;
$totalSalidas = 0;
$fondoDejadoEnCaja = 0;
$estado = '';
$sucursal = '';

if ($idCorteCaja > 0)
{
	$query = "SELECT cortecaja.* , sucursal.nombre as sucursal
				FROM cortecaja 
			   INNER JOIN sucursal on cortecaja.idSucursal = sucursal.idSucursal
				WHERE  idCorteCaja = " . $idCorteCaja;

	$cnn = new clsConexionMySQL();

	$datos = $cnn->getDataSet($query);

	// $query = "SELECT * FROM cortecaja WHERE idSucursal = " . $idSucursal." AND estado = 'ABIERTO' AND idCorteCaja = " . $idCorteCaja;
	if (count($datos))
	{
		$fondoCaja = $datos[0]["fondoCajaApertura"];
		$fechaInicial = $datos[0]["fecha_apertura"];
		$estado = $datos[0]["estado"];
		$idSucursal = $datos[0]["idSucursal"];
		$sucursal = $datos[0]["sucursal"];

		if ($estado === 'ABIERTO')
		{
			if ($fechaFinal === '')
			{
				echo "No se puede imprimir el detalle del corte de caja, no se ha hecho el cierre por lo que se ocupa indicar una fecha final del corte.";
				return;
			}
		}
		else
		{
			$fondoDejadoEnCaja = $datos[0]["fondoCajaAlCorte"];
			$fechaFinal = $datos[0]["fecha_corte"];
		}
	}
}





$objPHPExcel->setActiveSheetIndex(0)						
			->setCellValue('C'.$rowFechas,  "FECHAS")
			->setCellValue('C'.$rowFolio,  "Folio")
			->setCellValue('C'.$rowSucursal,  "Sucursal")
			->setCellValue('C'.$rowFondoCaja,  "Fondo de Caja")
			->setCellValue('C'.$rowVentas,  "Ventas en Efectivo")
			->setCellValue('C'.$rowAbonos,  "Abonos en Efectivo")
			->setCellValue('C'.$rowEntradas,  "Entradas")
			->setCellValue('C'.$rowSalidas,  "Salidas")
			->setCellValue('C'.$rowTotalEfectivo,  "Total Efectivo")
			->setCellValue('C'.$rowDejaCaja,  "Mantener en Caja Chica")
			->setCellValue('C'.$rowTotalRetirar,  "Total a Retirar")
			;


//Ventas
$currentRow++;

$objPHPExcel->setActiveSheetIndex(0)
      		    ->mergeCells('A'.$currentRow.':E'.$currentRow);				  				  				  
  		    
$objPHPExcel->getActiveSheet()->getStyle('A1:M1')->applyFromArray($estiloTituloReporte);
						
// $objPHPExcel->getActiveSheet()->getStyle('C3:D'.$currentRow)->applyFromArray($estiloFirma);

// Se agregan los titulos del reporte
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('C1',$tituloReporte)
			->setCellValue('A'.$currentRow,  "VENTAS");

$objPHPExcel->getActiveSheet()->getStyle('A'.$currentRow.':E'.$currentRow)->applyFromArray($estiloTituloReporte);

$currentRow++;

$objPHPExcel->setActiveSheetIndex(0)			
   		    ->setCellValue('A'.$currentRow, $titulosColumnas[0])
            ->setCellValue('B'.$currentRow, $titulosColumnas[1])
   		    ->setCellValue('C'.$currentRow, $titulosColumnas[2])
       		->setCellValue('D'.$currentRow, $titulosColumnas[3])
       		->setCellValue('E'.$currentRow, $titulosColumnas[4])
       		->setCellValue('F'.$currentRow, $titulosColumnas[5]);

//Headers
$objPHPExcel->getActiveSheet()->getStyle('A'.$currentRow.':F'.$currentRow)->applyFromArray($styleArray);  
$objPHPExcel
->getActiveSheet()
->getStyle('A'.$currentRow.':F'.$currentRow)
->getFill()
->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
->getStartColor()
->setRGB('E0E0E0');			

// DATOS V E N T A S E 
$query = "SELECT cxc.idPedido, cxc.monto, pedido.factura, DATE_FORMAT(cxc.fecha_movimiento, '%d/%m/%Y %h:%i:%s') fecha,
                concat(cliente.nombre, ' ', cliente.apellidos) cliente,
                concat(usuario.nombre, ' ' , usuario.apellidoPaterno, ' ', usuario.apellidoMaterno) usuario            
            FROM cxc   
            LEFT JOIN pedido ON cxc.idPedido = pedido.idpedido AND pedido.fecha_capturado > '".$fechaInicial."' AND pedido.fecha_capturado <= '".$fechaFinal."'
            INNER JOIN usuario ON cxc.id_usuario_movimiento = usuario.idUsuario 
            INNER JOIN cliente ON cxc.idCliente = cliente.idCliente
            WHERE cxc.fecha_movimiento > '".$fechaInicial."' AND cxc.fecha_movimiento <= '".$fechaFinal."'
            AND cxc.movimiento = 'ABONO'
            AND cxc.formaPago = 1
            AND usuario.idSucursal =  ".$idSucursal."
            AND pedido.idPedido IS NOT NULL                 
            ORDER BY cxc.fecha_movimiento;";
       	
$cnn = new clsConexionMySQL();

$datos = $cnn->getDataSet($query);
$row = ++$currentRow;
$totalVentas = 0;
foreach ($datos as $item)
{
	
		
	$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('A' . $row,  $item["idPedido"])
		->setCellValue('B' . $row,  $item["factura"])
		->setCellValue('C' . $row,  $item["monto"])
		->setCellValue('D' . $row,  $item["fecha"])
		->setCellValue('E' . $row,  $item["cliente"])
		->setCellValue('F' . $row,  $item["usuario"])
		;
	
	$totalVentas += (float) $item["monto"];
		
	$row++;
}


$currentRow = $row + 2 ;



// A B O N O S

$objPHPExcel->setActiveSheetIndex(0)
      		    ->mergeCells('A'.$currentRow.':E'.$currentRow);				  				  				  
  		    
$objPHPExcel->getActiveSheet()->getStyle('A1:M1')->applyFromArray($estiloTituloReporte);
						
// $objPHPExcel->getActiveSheet()->getStyle('C3:D'.$currentRow)->applyFromArray($estiloFirma);

// Se agregan los titulos del reporte
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('C1',$tituloReporte)
			->setCellValue('A'.$currentRow,  "ABONOS");

$objPHPExcel->getActiveSheet()->getStyle('A'.$currentRow.':E'.$currentRow)->applyFromArray($estiloTituloReporte);

$currentRow++;

$objPHPExcel->setActiveSheetIndex(0)			
   		    ->setCellValue('A'.$currentRow, $titulosColumnas[0])
            ->setCellValue('B'.$currentRow, $titulosColumnas[1])
   		    ->setCellValue('C'.$currentRow, $titulosColumnas[2])
       		->setCellValue('D'.$currentRow, $titulosColumnas[3])
       		->setCellValue('E'.$currentRow, $titulosColumnas[4])
       		->setCellValue('F'.$currentRow, $titulosColumnas[5]);

//Headers
$objPHPExcel->getActiveSheet()->getStyle('A'.$currentRow.':F'.$currentRow)->applyFromArray($styleArray);  
$objPHPExcel
->getActiveSheet()
->getStyle('A'.$currentRow.':F'.$currentRow)
->getFill()
->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
->getStartColor()
->setRGB('E0E0E0');		

// DATOS A B O N O S 
$query = "SELECT cxc.idPedido, cxc.monto, pedido.factura, DATE_FORMAT(cxc.fecha_movimiento, '%d/%m/%Y %h:%i:%s') fecha,
                concat(cliente.nombre, ' ', cliente.apellidos) cliente,
                concat(usuario.nombre, ' ' , usuario.apellidoPaterno, ' ', usuario.apellidoMaterno) usuario            
            FROM cxc   
            LEFT JOIN pedido ON cxc.idPedido = pedido.idpedido AND pedido.fecha_capturado > '".$fechaInicial."' AND pedido.fecha_capturado <= '".$fechaFinal."'
            INNER JOIN usuario ON cxc.id_usuario_movimiento = usuario.idUsuario 
            INNER JOIN cliente ON cxc.idCliente = cliente.idCliente
            WHERE cxc.fecha_movimiento > '".$fechaInicial."' AND cxc.fecha_movimiento <= '".$fechaFinal."'
            AND cxc.movimiento = 'ABONO'
            AND cxc.formaPago = 1
            AND usuario.idSucursal =  ".$idSucursal."
            AND pedido.idPedido IS NULL                 
            ORDER BY cxc.fecha_movimiento;";
       	
$cnn = new clsConexionMySQL();

$datos = $cnn->getDataSet($query);
$row = ++$currentRow;
$totalAbonos = 0;
foreach ($datos as $item)
{
	
		
	$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('A' . $row,  $item["idPedido"])
		->setCellValue('B' . $row,  $item["factura"])
		->setCellValue('C' . $row,  $item["monto"])
		->setCellValue('D' . $row,  $item["fecha"])
		->setCellValue('E' . $row,  $item["cliente"])
		->setCellValue('F' . $row,  $item["usuario"])
		;
	
	$totalAbonos += (float) $item["monto"];
		
	$row++;
}




$currentRow = $row + 2 ;


// E N T R A D A S

$objPHPExcel->setActiveSheetIndex(0)
      		    ->mergeCells('A'.$currentRow.':E'.$currentRow);				  				  				  
  		    
$objPHPExcel->getActiveSheet()->getStyle('A1:M1')->applyFromArray($estiloTituloReporte);
						
// $objPHPExcel->getActiveSheet()->getStyle('C3:D'.$currentRow)->applyFromArray($estiloFirma);

// Se agregan los titulos del reporte
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('C1',$tituloReporte)
			->setCellValue('A'.$currentRow,  "ENTRADAS");

$objPHPExcel->getActiveSheet()->getStyle('A'.$currentRow.':E'.$currentRow)->applyFromArray($estiloTituloReporte);

$currentRow++;
$titulosColumnas = array('MONTO', 'REFERENCIA', 'FECHA MOVIMIENTO', 'CLIENTE', 'USUARIO');

$objPHPExcel->setActiveSheetIndex(0)			
   		    ->setCellValue('A'.$currentRow, $titulosColumnas[0])
            ->setCellValue('B'.$currentRow, $titulosColumnas[1])
   		    ->setCellValue('C'.$currentRow, $titulosColumnas[2])
       		->setCellValue('D'.$currentRow, $titulosColumnas[3])
       		->setCellValue('E'.$currentRow, $titulosColumnas[4]);

//Headers
$objPHPExcel->getActiveSheet()->getStyle('A'.$currentRow.':E'.$currentRow)->applyFromArray($styleArray);  
$objPHPExcel
->getActiveSheet()
->getStyle('A'.$currentRow.':E'.$currentRow)
->getFill()
->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
->getStartColor()
->setRGB('E0E0E0');	


// DATOS E N T R A D A S 
$query = "SELECT recibodinero.monto, recibodinero.referencia, DATE_FORMAT(recibodinero.fecha_captura, '%d/%m/%Y %h:%i:%s') fecha,
                    concat(cliente.nombre, ' ', cliente.apellidos) cliente,
                    concat(usuario.nombre, ' ' , usuario.apellidoPaterno, ' ', usuario.apellidoMaterno) usuario
            FROM recibodinero                           
            INNER JOIN usuario ON recibodinero.id_usuario_captura = usuario.idUsuario
            INNER JOIN cliente on recibodinero.idCliente = cliente.idCliente
            WHERE recibodinero.fecha_captura > '".$fechaInicial."' AND recibodinero.fecha_captura <= '".$fechaFinal."'
            AND recibodinero.formaPago = 1
            AND usuario.idSucursal = ".$idSucursal."
            ORDER BY recibodinero.fecha_captura";
       	
$cnn = new clsConexionMySQL();

$datos = $cnn->getDataSet($query);
$row = ++$currentRow;
$totalEntradas = 0;
foreach ($datos as $item)
{
	
		
	$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('A' . $row,  $item["monto"])
		->setCellValue('B' . $row,  $item["referencia"])
		->setCellValue('C' . $row,  $item["fecha"])
		->setCellValue('D' . $row,  $item["cliente"])
		->setCellValue('E' . $row,  $item["usuario"])
		;
	
	$totalEntradas += (float) $item["monto"];
		
	$row++;
}




$currentRow = $row + 2 ;

// S A L I D A S 

$objPHPExcel->setActiveSheetIndex(0)
      		    ->mergeCells('A'.$currentRow.':E'.$currentRow);				  				  				  
  		    
$objPHPExcel->getActiveSheet()->getStyle('A1:M1')->applyFromArray($estiloTituloReporte);
						
// $objPHPExcel->getActiveSheet()->getStyle('C3:D'.$currentRow)->applyFromArray($estiloFirma);

// Se agregan los titulos del reporte
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('C1',$tituloReporte)
			->setCellValue('A'.$currentRow,  "SALIDAS");

$objPHPExcel->getActiveSheet()->getStyle('A'.$currentRow.':E'.$currentRow)->applyFromArray($estiloTituloReporte);

$currentRow++;
$titulosColumnas = array('CONCEPTO', 'MONTO', 'DETALLE', 'FECHA MOVIMIENTO', 'USUARIO');
$objPHPExcel->setActiveSheetIndex(0)			
   		    ->setCellValue('A'.$currentRow, $titulosColumnas[0])
            ->setCellValue('B'.$currentRow, $titulosColumnas[1])
   		    ->setCellValue('C'.$currentRow, $titulosColumnas[2])
       		->setCellValue('D'.$currentRow, $titulosColumnas[3])
       		->setCellValue('E'.$currentRow, $titulosColumnas[4]);

//Headers
$objPHPExcel->getActiveSheet()->getStyle('A'.$currentRow.':E'.$currentRow)->applyFromArray($styleArray);  
$objPHPExcel
->getActiveSheet()
->getStyle('A'.$currentRow.':E'.$currentRow)
->getFill()
->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
->getStartColor()
->setRGB('E0E0E0');		

// DATOS S A L I D A S
$query = "SELECT tipogasto.descripcion concepto, gasto.monto, gasto.detalle, DATE_FORMAT(gasto.fecha_insert, '%d/%m/%Y %h:%i:%s') fecha,
                    concat(usuario.nombre, ' ' , usuario.apellidoPaterno, ' ', usuario.apellidoMaterno) usuario
            FROM gasto                       
            INNER JOIN tipogasto  ON gasto.idTipoGasto = tipogasto.idTipoGasto
            INNER JOIN usuario ON gasto.id_usuario_insert = usuario.idUsuario
            WHERE gasto.fecha_insert > '".$fechaInicial."' AND gasto.fecha_insert <= '".$fechaFinal."'
            AND gasto.idSucursal = ".$idSucursal."
            ORDER BY gasto.fecha_insert";
       	
$cnn = new clsConexionMySQL();

$datos = $cnn->getDataSet($query);
$row = ++$currentRow;
$totalSalidas = 0;
foreach ($datos as $item)
{
	
		
	$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('A' . $row,  $item["concepto"])
		->setCellValue('B' . $row,  $item["monto"])
		->setCellValue('C' . $row,  $item["detalle"])
		->setCellValue('D' . $row,  $item["fecha"])
		->setCellValue('E' . $row,  $item["usuario"])
		;
	
	$totalSalidas += (float) $item["monto"];
		
	$row++;
}




// T O T A L E S
$totalEfectivo = $fondoCaja + $totalVentas + $totalAbonos + $totalEntradas - $totalSalidas;
$totalRetirar = $totalEfectivo - $fondoDejadoEnCaja;


$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('C' . $rowFechas,  "Fecha Inicial: ". $fechaInicial." - Fecha Final: ".$fechaFinal);

$objPHPExcel->getActiveSheet()->getStyle('C'.$rowFechas.':E'.$rowFechas)->applyFromArray($estiloSobresaliente);		

$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('D' . $rowFolio, $estado === 'ABIERTO' ? 'ABIERTO' : $idCorteCaja);

$objPHPExcel->getActiveSheet()->getStyle('C'.$rowFolio.':E'.$rowFolio)->applyFromArray($estiloSobresaliente);		

$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('D' . $rowSucursal, $sucursal);

$objPHPExcel->getActiveSheet()->getStyle('C'.$rowSucursal.':E'.$rowSucursal)->applyFromArray($estiloSobresaliente);		

$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('D' . $rowFondoCaja,  $fondoCaja);

$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('D' . $rowVentas,  $totalVentas);
$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('D' . $rowAbonos,  $totalAbonos);
$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('D' . $rowEntradas,  $totalEntradas);
$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('D' . $rowSalidas,  $totalSalidas);

$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('D' . $rowTotalEfectivo,  $totalEfectivo);

$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('D' . $rowDejaCaja,  $fondoDejadoEnCaja);		

$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('D' . $rowTotalRetirar,  $totalRetirar);		

$objPHPExcel->getActiveSheet()->getStyle('C'.$rowTotalRetirar.':E'.$rowTotalRetirar)->applyFromArray($estiloSobresaliente);				


//*********************************************************************************************** */
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth('8');

$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth('25');

$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth('20');

$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth('20');

$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth('32');

$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth('15');



$objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight('26');
				
// for($i = 'A'; $i <= 'E'; $i++){
// 	$objPHPExcel->setActiveSheetIndex(0)			
// 		->getColumnDimension($i)->setAutoSize(TRUE);
// }

$objDrawing = new PHPExcel_Worksheet_Drawing();
$objDrawing->setName('test_img');
$objDrawing->setDescription('test_img');
//$objDrawing->setPath('C:\\xampp\\htdocs\\galvamex\\codigogalvamex\\html\\img\\galvalogo.jpeg');
$objDrawing->setPath('img/galvalogo.jpeg');
$objDrawing->setCoordinates('A1');
//setOffsetX works properly
$objDrawing->setOffsetX(0);
$objDrawing->setOffsetY(5);
//set width, height
$objDrawing->setWidth(270);
$objDrawing->setHeight(90);
$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
		
// Se asigna el nombre a la hoja
$objPHPExcel->getActiveSheet()->setTitle('Detalle Corte Caja');

// Se activa la hoja para que sea la que se muestre cuando el archivo se abre
$objPHPExcel->setActiveSheetIndex(0);
// Inmovilizar paneles 
//$objPHPExcel->getActiveSheet(0)->freezePane('A4');
//$objPHPExcel->getActiveSheet(0)->freezePaneByColumnAndRow(0,4);


// Se manda el archivo al navegador web, con el nombre que se indica (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=utf-8');
if ($estado === 'ABIERTO')
{
	header('Content-Disposition: attachment;filename="CorteCaja_ABIERTO_' . str_replace(":", "-",str_replace(" ", "-",$fechaInicial))."_".str_replace(":", "-",str_replace(" ", "-",$fechaFinal)) . '.xlsx"');
}
else
{
	header('Content-Disposition: attachment;filename="CorteCaja_' . $idCorteCaja ."_". str_replace(":", "-",str_replace(" ", "-",$fechaInicial))."_".str_replace(":", "-",str_replace(" ", "-",$fechaFinal)). '.xlsx"');
	
}
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
		exit;
		
	
