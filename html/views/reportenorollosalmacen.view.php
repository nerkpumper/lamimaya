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

	//$tofind = array('Ã ','Ã¡','Ã¢','Ã£','Ã¤', 'Ã§', 'Ã¨','Ã©','Ãª','Ã«', 'Ã¬','Ã­','Ã®','Ã¯', 'Ã±', 'Ã²','Ã³','Ã´','Ãµ','Ã¶', 'Ã¹','Ãº','Ã»','Ã¼', 'Ã½','Ã¿', 'Ã€','Ã�','Ã‚','Ãƒ','Ã„', 'Ã‡', 'Ãˆ','Ã‰','ÃŠ','Ã‹', 'ÃŒ','Ã�','ÃŽ','Ã�', 'Ã‘', 'Ã’','Ã“','Ã”','Ã•','Ã–', 'Ã™','Ãš','Ã›','Ãœ', 'Ã�');
	//$replac = array('a','a','a','a','a', 'c', 'e','e','e','e', 'i','i','i','i', 'n', 'o','o','o','o','o', 'u','u','u','u', 'y','y', 'A','A','A','A','A', 'C', 'E','E','E','E', 'I','I','I','I', 'N', 'O','O','O','O','O', 'U','U','U','U', 'Y');
	//return(strtr($cadena,$tofind,$replac));
	
	//  	$cadena = mb_convert_encoding($cadena, 'ISO-8859-1', 'UTF-8');
	//  	$cadena = strtr($cadena, mb_convert_encoding($tofind, 'ISO-8859-1', 'UTF-8'), $toreplac);
	//  	$cadena = strtolower($cadena);
	return $cadena;
	//return mb_convert_encoding($cadena, 'UTF-8', 'ISO-8859-1');
}



// if (!isset($param1))
// {
// 	salir();
// 	return;
// }

// if ($param1 == "")
// {
// 	salir();
// 	return;
// }

// $idRollo = $param1;

// require_once FOLDER_MODEL. "model.rollo.inc.php";


// $rollo = new ModeloRollo();

// $rollo->setIdRollo($idRollo);

// if ($rollo->getIdRollo() == 0)
// {
// 	salir();
// }

// $claveRollo = $rollo->getCodigo();
// $descripcionRollo = str_replace("<br />", " ", normaliza (mb_convert_encoding(($rollo->getDescripcion(, 'ISO-8859-1', 'UTF-8')))));
//$descripcionRollo = $rollo->getDescripcion();
//echo $descripcionRollo;
//exit;				


if (PHP_SAPI == 'cli')
	die('Este archivo solo se puede ver desde un navegador web');

/** Se agrega la libreria PHPExcel */
require_once FOLDER_INCLUDE . 'lib/PHPExcel/PHPExcel.php';
require_once LIB_CONEXION_MYSQL;

// Se crea el objeto PHPExcel
$objPHPExcel = new PHPExcel();

		// Se asignan las propiedades del libro
$objPHPExcel->getProperties()->setCreator("Galvamex App") //Autor
					 ->setLastModifiedBy("Galvamex App") //Ultimo usuario que lo modificÃƒÆ’Ã‚Â³
					 ->setTitle("Reporte Recepcion Material")
					 ->setSubject("Reporte Recepcion Material")
					 ->setDescription("Reporte de RecepciÃ³n de Materiales")
					 ->setKeywords("reporte recepcion remision rollo")
					 ->setCategory("Reporte Galvamex");

$objPHPExcel->getActiveSheet()
				 ->getPageSetup()
				 ->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);

$objPHPExcel->getActiveSheet()
				 ->getPageSetup()
				 ->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);					 

$tituloReporte = "REPORTE DE RECEPCIÃ“N DE MATERIALES X ALMACEN";
$titulosColumnas = array('FECHA', 'PROVEEDOR', 'REMISIÃ“N', 'NUM. ROLLO', 'ALMACEN', 'PRODUCTO', 'KILOS RECIB.');

		
$objPHPExcel->setActiveSheetIndex(0)
      		    ->mergeCells('A1:F1');

$objPHPExcel->setActiveSheetIndex(0)
      		    ->mergeCells('C3:F3');      		    

// $objPHPExcel->setActiveSheetIndex(0)
//       		    ->mergeCells('B32:C32');      		    
						
// Se agregan los titulos del reporte
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('A1',$tituloReporte)
   		    ->setCellValue('A5',  $titulosColumnas[0])
            ->setCellValue('B5',  $titulosColumnas[1])
   		    ->setCellValue('C5',  $titulosColumnas[2])
       		->setCellValue('D5',  $titulosColumnas[3])
       		->setCellValue('E5',  $titulosColumnas[4])
       		->setCellValue('F5',  $titulosColumnas[5])
			->setCellValue('G5',  $titulosColumnas[6]);

// $objPHPExcel->setActiveSheetIndex(0)
//        		->setCellValue('A3','CÃ³digo Rollo');       		

// $objPHPExcel->setActiveSheetIndex(0)
//        		->setCellValue('B3',$claveRollo);       		

// $objPHPExcel->setActiveSheetIndex(0)
//        		->setCellValue('C3','DescripciÃ³n');       		

// $objPHPExcel->setActiveSheetIndex(0)
//        		->setCellValue('D3',$descripcionRollo);       		

       		


// //Se agregan los datos de los alumnos
// $i = 4;
// 		while ($fila = $resultado->fetch_array()) {
// 			$objPHPExcel->setActiveSheetIndex(0)
//         		    ->setCellValue('A'.$i,  $fila['alumno'])
// 		            ->setCellValue('B'.$i,  $fila['username'])
//         		    ->setCellValue('C'.$i,  $fila['estatus'])
//             		->setCellValue('D'.$i, mb_convert_encoding($fila['email'], 'UTF-8', 'ISO-8859-1');
// 					$i++;
// 		}
		
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

//Headers
$objPHPExcel->getActiveSheet()->getStyle('A5:G5')->applyFromArray($styleArray);  
$objPHPExcel
->getActiveSheet()
->getStyle('A5:G5')
->getFill()
->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
->getStartColor()
->setRGB('E0E0E0');

//echo "vamos por los datos - Row: " . $idRollo;

//Datos
$query = "SELECT fecha, p.nombre as proveedor, remision, noRollo, almacen, r.descripcion as producto, kilos, ts
            FROM remisionrollo
           INNER JOIN rollo as r
              ON r.idRollo = remisionRollo_rollo_idRollo
           INNER JOIN proveedor as p
              ON p.idProveedor = rollo_proveedor_idProveedor 
WHERE remisionrollo.estado <> 'BAJA'
		   ORDER BY remision";

$cnn = new clsConexionMySQL();

$datos = $cnn->getDataSet($query);

$row = 6;
$ts = "";
$totalKilos = 0;

$almacenAnterior = "";
$almacenActual = "";

foreach ($datos as $item)
{
	$almacenActual = $item["almacen"];
	
	if ($almacenAnterior != $almacenActual)
	{
		if ($almacenAnterior != "")
		{
			//imprimimos remision
			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('D' . $row,  "ALMACEN");
			$objPHPExcel->getActiveSheet()->getStyle('D' . $row)->applyFromArray($styleArray);
			$objPHPExcel
			->getActiveSheet()
			->getStyle('D' . $row)
			->getFill()
			->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
			->getStartColor()
			->setRGB('C0C0C0');
			
			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('E' . $row,  $almacenActual);
			$objPHPExcel->getActiveSheet()->getStyle('E' . $row)->applyFromArray($styleArray);
			/*$objPHPExcel
			->getActiveSheet()
			->getStyle('E' . $row)
			->getFill()
			->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
			->getStartColor()
			->setRGB('C0C0C0');*/
			
			
			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('G' . $row,  $totalKilos);
			
			$objPHPExcel->getActiveSheet()->getStyle('G' . $row)->applyFromArray($styleArray);
			/*$objPHPExcel
			->getActiveSheet()
			->getStyle('G' . $row)
			->getFill()
			->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
			->getStartColor()
			->setRGB('C0C0C0');*/
			
			$totalKilos = 0;		
			$row+=2	;
		}
		
	
		$almacenAnterior = $almacenActual;
	}
		
	$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('A' . $row,  $item["fecha"])
		->setCellValue('B' . $row,  $item["proveedor"])
		->setCellValue('C' . $row,  $item["remision"])
		->setCellValue('D' . $row,  $item["noRollo"])
		->setCellValue('E' . $row,  $item["almacen"])
		->setCellValue('F' . $row,  $item["producto"])
		->setCellValue('G' . $row,  $item["kilos"]);
	
	$totalKilos += (float) $item["kilos"];
		
	$objPHPExcel->getActiveSheet()->getStyle('A' . $row . ':G' . $row)->applyFromArray($styleArray);
	$ts = $item["ts"];
	$row++;
}

//imprimimos remision
			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('D' . $row,  "ALMACEN");
			$objPHPExcel->getActiveSheet()->getStyle('D' . $row)->applyFromArray($styleArray);
			$objPHPExcel
			->getActiveSheet()
			->getStyle('D' . $row)
			->getFill()
			->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
			->getStartColor()
			->setRGB('C0C0C0');
			
			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('E' . $row,  $almacenActual);
			$objPHPExcel->getActiveSheet()->getStyle('E' . $row)->applyFromArray($styleArray);
			$objPHPExcel
			->getActiveSheet()
			->getStyle('E' . $row)
			->getFill()
			->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
			->getStartColor()
			->setRGB('C0C0C0');
			


//imprimimos el total de kilos
$objPHPExcel->setActiveSheetIndex(0)
->setCellValue('G' . $row,  $totalKilos);
$objPHPExcel->getActiveSheet()->getStyle('G' . $row)->applyFromArray($styleArray);
$objPHPExcel
->getActiveSheet()
->getStyle('G' . $row)
->getFill()
->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
->getStartColor()
->setRGB('C0C0C0');


//Leyenda inicial, indicando ultimos movimientos
// $objPHPExcel->setActiveSheetIndex(0)
// ->setCellValue('C3',"Movimientos de " . $claveRollo . " registrados (" . $ts . ")");



       		
$objPHPExcel->getActiveSheet()->getStyle('A1:G1')->applyFromArray($estiloTituloReporte);

$objPHPExcel->getActiveSheet()->getStyle('A3')->applyFromArray($estiloDatosLabelRollo);
$objPHPExcel->getActiveSheet()->getStyle('B3')->applyFromArray($estiloDatosRollo);
$objPHPExcel->getActiveSheet()->getStyle('C3')->applyFromArray($estiloDatosLabelRollo);
$objPHPExcel->getActiveSheet()->getStyle('D3')->applyFromArray($estiloDatosRollo);

$objPHPExcel->getActiveSheet()->getStyle('A5:G5')->applyFromArray($estiloHeader);
//$objPHPExcel->getActiveSheet()->getStyle('A3:D3')->applyFromArray($estiloTituloColumnas);		
//$objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "A4:D5");

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth('12');

$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth('16');

$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth('13');

$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth('15');

$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth('15');

$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth('48');

$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth('10');

$objPHPExcel->getActiveSheet()->getRowDimension('3')->setRowHeight('26');
				
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
$objDrawing->setOffsetX(5);
$objDrawing->setOffsetY(5);
//set width, height
$objDrawing->setWidth(380);
$objDrawing->setHeight(90);
$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
		
// Se asigna el nombre a la hoja
$objPHPExcel->getActiveSheet()->setTitle('Recepcion Material');

// Se activa la hoja para que sea la que se muestre cuando el archivo se abre
$objPHPExcel->setActiveSheetIndex(0);
// Inmovilizar paneles 
//$objPHPExcel->getActiveSheet(0)->freezePane('A4');
//$objPHPExcel->getActiveSheet(0)->freezePaneByColumnAndRow(0,4);

//header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
// Se manda el archivo al navegador web, con el nombre que se indica (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=utf-8');
header('Content-Disposition: attachment;filename="reporteNoRollosAlmacen_' . date('YmdHi') . '.xlsx"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
		exit;
		
	
