<?php

function salir()
{
	echo "<script>
					window.close();
		</script>";
	return;
}


if (!isset($_POST['pTableHeader']))
{
	salir();
	exit;
}

if (!isset($_POST['pTableBody']))
{
	salir();
	exit;
}

$tableHeader = $_POST['pTableHeader'];
$tableBody = $_POST['pTableBody'];

$cabecera = explode("|", $tableHeader);
$cuerpo = explode("^", $tableBody);

$_tituloReporte = "";
$_subtituloReporte = "";
$_itemsAExcluir = 0;

$_formulaTotales = "";

$_reportName = "ReporteGalvamex";

if (isset($_POST['ptituloReporte']))
{
	$_tituloReporte = $_POST['ptituloReporte'];
}

if (isset($_POST['psubTituloReporte']))
{
	$_subtituloReporte = $_POST['psubTituloReporte'];
}

if (isset($_POST['pexcluir']))
{
	$_itemsAExcluir = $_POST['pexcluir'];
}

if (isset($_POST['pnombreReporte']))
{
	$_reportName = $_POST['pnombreReporte'];
}

if (isset($_POST['pformulaTotales']))
{
    $_formulaTotales = $_POST['pformulaTotales'];
}


$_campos = $cabecera;
$_cuerpo = $cuerpo;



function normaliza ($cadena){
	//  	$originales  = 'ÃƒÆ’Ã¢â€šÂ¬ÃƒÆ’Ã¯Â¿Â½ÃƒÆ’Ã¢â‚¬Å¡ÃƒÆ’Ã†â€™ÃƒÆ’Ã¢â‚¬Å¾ÃƒÆ’Ã¢â‚¬Â¦ÃƒÆ’Ã¢â‚¬Â ÃƒÆ’Ã¢â‚¬Â¡ÃƒÆ’Ã‹â€ ÃƒÆ’Ã¢â‚¬Â°ÃƒÆ’Ã…Â ÃƒÆ’Ã¢â‚¬Â¹ÃƒÆ’Ã…â€™ÃƒÆ’Ã¯Â¿Â½ÃƒÆ’Ã…Â½ÃƒÆ’Ã¯Â¿Â½ÃƒÆ’Ã¯Â¿Â½ÃƒÆ’Ã¢â‚¬ËœÃƒÆ’Ã¢â‚¬â„¢ÃƒÆ’Ã¢â‚¬Å“ÃƒÆ’Ã¢â‚¬ï¿½ÃƒÆ’Ã¢â‚¬Â¢ÃƒÆ’Ã¢â‚¬â€œÃƒÆ’Ã‹Å“ÃƒÆ’Ã¢â€žÂ¢ÃƒÆ’Ã…Â¡ÃƒÆ’Ã¢â‚¬ÂºÃƒÆ’Ã…â€œÃƒÆ’Ã¯Â¿Â½ÃƒÆ’Ã…Â¾ÃƒÆ’Ã…Â¸ÃƒÆ’Ã‚Â ÃƒÆ’Ã‚Â¡ÃƒÆ’Ã‚Â¢ÃƒÆ’Ã‚Â£ÃƒÆ’Ã‚Â¤ÃƒÆ’Ã‚Â¥ÃƒÆ’Ã‚Â¦ÃƒÆ’Ã‚Â§ÃƒÆ’Ã‚Â¨ÃƒÆ’Ã‚Â©ÃƒÆ’Ã‚ÂªÃƒÆ’Ã‚Â«ÃƒÆ’Ã‚Â¬ÃƒÆ’Ã‚Â­ÃƒÆ’Ã‚Â®ÃƒÆ’Ã‚Â¯ÃƒÆ’Ã‚Â°ÃƒÆ’Ã‚Â±ÃƒÆ’Ã‚Â²ÃƒÆ’Ã‚Â³ÃƒÆ’Ã‚Â´ÃƒÆ’Ã‚ÂµÃƒÆ’Ã‚Â¶ÃƒÆ’Ã‚Â¸ÃƒÆ’Ã‚Â¹ÃƒÆ’Ã‚ÂºÃƒÆ’Ã‚Â»ÃƒÆ’Ã‚Â½ÃƒÆ’Ã‚Â½ÃƒÆ’Ã‚Â¾ÃƒÆ’Ã‚Â¿Ãƒâ€¦Ã¢â‚¬ï¿½Ãƒâ€¦Ã¢â‚¬Â¢ÃƒÂ¯Ã‚Â¿Ã‚Â½';
	//  	$modificadas = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRro';

	$originales  = 'ÃƒÂ ,ÃƒÂ¡,ÃƒÂ¢,ÃƒÂ£,ÃƒÂ¤,ÃƒÂ§,ÃƒÂ¨,ÃƒÂ©,ÃƒÂª,ÃƒÂ«,ÃƒÂ¬,ÃƒÂ­,ÃƒÂ®,ÃƒÂ¯,ÃƒÂ±,ÃƒÂ²,ÃƒÂ³,ÃƒÂ´,ÃƒÂµ,ÃƒÂ¶,ÃƒÂ¹,ÃƒÂº,ÃƒÂ»,ÃƒÂ¼,ÃƒÂ½,ÃƒÂ¿,Ãƒâ‚¬,Ãƒï¿½,Ãƒâ€š,ÃƒÆ’,Ãƒâ€ž,Ãƒâ€¡,ÃƒË†,Ãƒâ€°,ÃƒÅ ,Ãƒâ€¹,ÃƒÅ’,Ãƒï¿½,ÃƒÅ½,Ãƒï¿½,Ãƒâ€˜,Ãƒâ€™,Ãƒâ€œ,Ãƒâ€�,Ãƒâ€¢,Ãƒâ€“,Ãƒâ„¢,ÃƒÅ¡,Ãƒâ€º,ÃƒÅ“,Ãƒï¿½';
	$modificadas = 'a,a,a,a,a,c,e,e,e,e,i,i,i,i,n,o,o,o,o,o,u,u,u,u,y,y,A,A,A,A,A,C,E,E,E,E,I,I,I,I,N,O,O,O,O,O,U,U,U,U,Y';

	$cadena = utf8_decode($cadena);
	$cadena = strtr($cadena, utf8_decode($originales), $modificadas);
	$cadena = strtolower($cadena);

	//$tofind = array('ÃƒÂ ','ÃƒÂ¡','ÃƒÂ¢','ÃƒÂ£','ÃƒÂ¤', 'ÃƒÂ§', 'ÃƒÂ¨','ÃƒÂ©','ÃƒÂª','ÃƒÂ«', 'ÃƒÂ¬','ÃƒÂ­','ÃƒÂ®','ÃƒÂ¯', 'ÃƒÂ±', 'ÃƒÂ²','ÃƒÂ³','ÃƒÂ´','ÃƒÂµ','ÃƒÂ¶', 'ÃƒÂ¹','ÃƒÂº','ÃƒÂ»','ÃƒÂ¼', 'ÃƒÂ½','ÃƒÂ¿', 'Ãƒâ‚¬','Ãƒï¿½','Ãƒâ€š','ÃƒÆ’','Ãƒâ€ž', 'Ãƒâ€¡', 'ÃƒË†','Ãƒâ€°','ÃƒÅ ','Ãƒâ€¹', 'ÃƒÅ’','Ãƒï¿½','ÃƒÅ½','Ãƒï¿½', 'Ãƒâ€˜', 'Ãƒâ€™','Ãƒâ€œ','Ãƒâ€�','Ãƒâ€¢','Ãƒâ€“', 'Ãƒâ„¢','ÃƒÅ¡','Ãƒâ€º','ÃƒÅ“', 'Ãƒï¿½');
	//$replac = array('a','a','a','a','a', 'c', 'e','e','e','e', 'i','i','i','i', 'n', 'o','o','o','o','o', 'u','u','u','u', 'y','y', 'A','A','A','A','A', 'C', 'E','E','E','E', 'I','I','I','I', 'N', 'O','O','O','O','O', 'U','U','U','U', 'Y');
	//return(strtr($cadena,$tofind,$replac));

	//  	$cadena = utf8_decode($cadena);
	//  	$cadena = strtr($cadena, utf8_decode($tofind), $toreplac);
	//  	$cadena = strtolower($cadena);
	return $cadena;
	//return utf8_encode($cadena);
}

if (PHP_SAPI == 'cli')
	die('Este archivo solo se puede ver desde un navegador web');

	/** Se agrega la libreria PHPExcel */
	require_once FOLDER_INCLUDE . 'lib/PHPExcel/PHPExcel.php';
	// require_once LIB_CONEXION_MYSQL;

	// Se crea el objeto PHPExcel
	$objPHPExcel = new PHPExcel();

	// Se asignan las propiedades del libro
	$objPHPExcel->getProperties()->setCreator("Galvamex App") //Autor
	->setLastModifiedBy("Galvamex App") //Ultimo usuario que lo modificÃƒÆ’Ã†â€™Ãƒâ€šÃ‚Â³
	->setTitle("Reporte")
	->setSubject("Reporte")
	->setDescription("Reporte")
	->setKeywords("reporte")
	->setCategory("Reporte Galvamex");

	//Landscape
	// $objPHPExcel->getActiveSheet()
	// 				 ->getPageSetup()
	// 				 ->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);

	$objPHPExcel->getActiveSheet()
	->getPageSetup()
	->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);

	$objPHPExcel->getActiveSheet()
	->getPageSetup()
	->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);

	// $tituloReporte = "REPORTE DE RECEPCIÃƒâ€œN DE MATERIALES";
	// $titulosColumnas = array('FECHA', 'PROVEEDOR', 'REMISIÃƒâ€œN', 'NUM. ROLLO', 'PRODUCTO', 'KILOS RECIB.', 'Hora', 'ts');

	//LANDSCAPE
	//Titulo
// 	$objPHPExcel->setActiveSheetIndex(0)
// 	->mergeCells('D1:M1');
	//Subtitulo
// 	$objPHPExcel->setActiveSheetIndex(0)
// 	->mergeCells('D2:M2');

	// //PORTRAIT
	// // //Titulo
	//  $objPHPExcel->setActiveSheetIndex(0)
	//        		    ->mergeCells('D1:I1');
	// // //Subtitulo
	//  $objPHPExcel->setActiveSheetIndex(0)
	//        		    ->mergeCells('D2:I2');

	 

	// Se agregan los titulos del reporte
	$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue('D1',$_tituloReporte);
	$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue('D2',$_subtituloReporte);


		
		

	// $objPHPExcel->setActiveSheetIndex(0)
	//        		->setCellValue('A3','CÃƒÂ³digo Rollo');

	// $objPHPExcel->setActiveSheetIndex(0)
	//        		->setCellValue('B3',$claveRollo);

	// $objPHPExcel->setActiveSheetIndex(0)
	//        		->setCellValue('C3','DescripciÃƒÂ³n');

	// $objPHPExcel->setActiveSheetIndex(0)
	//        		->setCellValue('D3',$descripcionRollo);

	 

	// // //Se agregan los datos de los alumnos
	// // $i = 4;
	// // 		while ($fila = $resultado->fetch_array()) {
	// // 			$objPHPExcel->setActiveSheetIndex(0)
	// //         		    ->setCellValue('A'.$i,  $fila['alumno'])
	// // 		            ->setCellValue('B'.$i,  $fila['username'])
	// //         		    ->setCellValue('C'.$i,  $fila['estatus'])
	// //             		->setCellValue('D'.$i, utf8_encode($fila['email']));
	// // 					$i++;
	// // 		}

	$estiloTituloReporte = array(
			'font' => array(
					'name'      => 'Arial',
					'bold'      => true,
					'italic'    => false,
					'strike'    => false,
					'size' =>12,
					'color'     => array(
							'rgb' => '000000'
					)
			),
			'alignment' =>  array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
					'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'rotation'   => 0,
					'wrap'          => FALSE
			)
	);

	$estiloHeader = array(
			'font' => array(
					'name'      => 'Arial',
					'bold'      => true,
					'italic'    => false,
					'strike'    => false,
					'size' =>9,
					'color'     => array(
							'rgb' => '000000'
					)
			),
			'alignment' =>  array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'rotation'   => 0,
					'wrap'          => FALSE
			)
	);

	// 		$estiloDatosLabelRollo = array(
	// 				'font' => array(
	// 						'name'      => 'Arial',
	// 						'bold'      => true,
	// 						'italic'    => false,
	// 						'strike'    => false,
	// 						'size' =>10,
	// 						'color'     => array(
	// 								'rgb' => '000000'
	// 						)
	// 				),
	// 				'alignment' =>  array(
	// 						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
	// 						'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
	// 						'rotation'   => 0,
	// 						'wrap'          => TRUE
	// 				)
	// 		);

	// 		$estiloDatosRollo = array(
	// 				'font' => array(
	// 						'name'      => 'Arial',
	// 						'bold'      => false,
	// 						'italic'    => false,
	// 						'strike'    => false,
	// 						'size' =>10,
	// 						'color'     => array(
	// 								'rgb' => '000000'
	// 						)
	// 				),
	// 				'alignment' =>  array(
	// 						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
	// 						'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
	// 						'rotation'   => 0,
	// 						'wrap'          => TRUE
	// 				)
	// 		);


	$styleArray = array(
			'borders' => array(
					'allborders' => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
							'color' => array('argb' => 'FF000000'),
					),
			)
	);

	//        	$estiloFirma = array(
	//        			'borders' => array(
	//        					'top' => array(
	//        							'style' => PHPExcel_Style_Border::BORDER_THIN,
	//        							'color' => array('argb' => 'FF000000'),
	//        					),
	//        			),
	//        			'alignment' =>  array(
	//        					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
	//        					'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
	//        					'rotation'   => 0,
	//        					'wrap'          => TRUE
	//        			)
	//        	);


	$col = 0;
	$indexCols = 0;
	foreach ($_campos as $colTitle)
	{
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValueByColumnAndRow($col++, 5, $colTitle);
		
		$indexCols++;
		
		if ($indexCols >= (count($_campos) - $_itemsAExcluir))
			break;
	}


	// //Headers
	// $objPHPExcel->getActiveSheet()->getStyle('A5:H5')->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->getStyle(chr(65) . '5:'. chr(64 + count($_campos) - $_itemsAExcluir).'5')->applyFromArray($styleArray);
	$objPHPExcel
	->getActiveSheet()
	->getStyle(chr(65) . '5:'. chr(64 + count($_campos) - $_itemsAExcluir).'5')
	->getFill()
	->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
	->getStartColor()
	->setRGB('E0E0E0');

	// //echo "vamos por los datos - Row: " . $idRollo;

	//Datos
	// $_strQuery = "SELECT fecha, p.nombre as proveedor, remision, noRollo, r.descripcion as producto, kilos, ts
	//             FROM remisionrollo
	//            INNER JOIN rollo as r
	//               ON r.idRollo = remisionRollo_rollo_idRollo
	//            INNER JOIN proveedor as p
	//               ON p.idProveedor = rollo_proveedor_idProveedor";

	// $cnn = new clsConexionMySQL();

// 	$datos = $cnn->getDataSet($_strQuery);
// 	$datos = $reporter->rs;

	$rowInicial = 6;
	$row = $rowInicial;		
	foreach ($_cuerpo as $renglon)
	{
		$col = 0;
		$items = explode("|", $renglon);
		$indexCols = 0;
		foreach ($items as $cell)
		{
			$fc = substr($cell, 0, 1);

			if ($fc == "$")
			{
				$cell = str_replace("$", "", $cell);
				$cell = str_replace(" ", "", $cell);
				$cell = str_replace(",", "", $cell);
			}

			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValueByColumnAndRow($col++, $row, $cell);
			
			$indexCols++;
			if ($indexCols >= (count($_campos) - $_itemsAExcluir))
				break;

		}
		$row++;
	}

	for($i = 'A'; $i <= chr(64 + count($_campos) - $_itemsAExcluir); $i++){
		$objPHPExcel->setActiveSheetIndex(0)
		->getColumnDimension($i)->setAutoSize(TRUE);

	}
	
// 	$objPHPExcel->setActiveSheetIndex(0)
// 	->setCellValueByColumnAndRow(1, $row, $_formulaTotales);

	if (trim($_formulaTotales) != "")
	{
	    $lstFormulasTotales = explode("|",$_formulaTotales);
	    
	    foreach ($lstFormulasTotales as $colFT)
	    {
// 	        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(2, $row, "cell: ".$colFT);
	        
	        	    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($colFT . $row, "=SUM(".   $colFT.$rowInicial.":".$colFT.($row-1).")");
	        	    $objPHPExcel->setActiveSheetIndex(0)->getStyle($colFT . $row)->getFont()->setBold(true);
	    }
	}
	
	
	
	

	 
	$objPHPExcel->getActiveSheet()->getStyle('D1')->applyFromArray($estiloTituloReporte);
 

	$objPHPExcel->getActiveSheet()->getStyle('A5:'.chr(64 + count($_campos) - $_itemsAExcluir).'5')->applyFromArray($estiloHeader);

	$objDrawing = new PHPExcel_Worksheet_Drawing();
	$objDrawing->setName('test_img');
	$objDrawing->setDescription('test_img');
	
	//$objDrawing->setPath('C:\\xampp\\htdocs\\galvamex\\codigogalvamex\\html\\img\\galvalogo.jpeg');
	// $objDrawing->setPath('../img/galvalogo.jpeg');
	
	$objDrawing->setPath('img/galvalogo.jpeg');
	$objDrawing->setCoordinates('A1');
	//setOffsetX works properly
	$objDrawing->setOffsetX(2);
	$objDrawing->setOffsetY(2);
	//set width, height
	$objDrawing->setResizeProportional(false);
	$objDrawing->setWidth(170);
	$objDrawing->setHeight(75);
	$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

	// Se asigna el nombre a la hoja
	$objPHPExcel->getActiveSheet()->setTitle('Reporte');

	// Se activa la hoja para que sea la que se muestre cuando el archivo se abre
	$objPHPExcel->setActiveSheetIndex(0);
	// Inmovilizar paneles
	//$objPHPExcel->getActiveSheet(0)->freezePane('A4');
	//$objPHPExcel->getActiveSheet(0)->freezePaneByColumnAndRow(0,4);

	//header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
	// Se manda el archivo al navegador web, con el nombre que se indica (Excel2007)
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=utf-8');
	header('Content-Disposition: attachment;filename="'.$_reportName.'_' . date('YmdHis') . '.xlsx"');
	header('Cache-Control: max-age=0');
// 	$fileName = "Reporte_".date('YmdHis').".xlsx";
// 	$path = "../reportes/";
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	// $objWriter->save($path.$fileName);
	$objWriter->save('php://output');
	// echo $fileName;
	exit;



