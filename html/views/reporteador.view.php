<?php

require_once LIB_REPORTEADOR;

// define('FOLDER_INCLUDE', '../../include/');
// //define('FOLDER_INCLUDE', '/home/nerkpump/includeappgalvamex/');
// define("FOLDER_MODEL_BASE",FOLDER_INCLUDE . "model/base/");
// define("FOLDER_MODEL",FOLDER_INCLUDE . "model/extend/");
// define("LIB_CONEXION",FOLDER_INCLUDE . "lib/Conexion/Conexion.inc.php");
// define("LIB_CONEXION_MYSQL",FOLDER_INCLUDE . "lib/Conexion/ConexionMySQL.inc.php");

// define('FOLDER_HTML', './');
// define('FOLDER_IMG', FOLDER_HTML . '/img/');

// // $f=explode("/",$_SERVER['PHP_SELF']);

// // print_r($f);

// require_once LIB_CONEXION;
// require_once FOLDER_INCLUDE . 'model/clsBasicCommon.inc.php';

//print_r($_COOKIE);

// echo "Por el momento no estan disponibles estos reportes";
// return;

$reporter = new clsReporteador();



$_tituloReporte = "";
$_subtituloReporte = "";
$_campos = array();

// $_select = "";
// $_from = "";
// $_inner = "";
// $_where = "";
// $_group = "";
// $_order = "";

$_parametros = array();


// echo "hola reporteador<br>";

$i = 1;

while(true)
{	
	if (isset(${"param$i"}))
	{
		$j=$i+1;
		if (isset(${"param$j"}))
		{
			$_parametros[${"param$i"}] = ${"param$j"};
			$reporter->setParam(${"param$i"}, ${"param$j"});
			$i++;
			$i++;
		}
		else 
		{
			break;
		}		
	}
	else 
	{
		break;
	}
	
	//if ($i > 2) break;
}

if(!isset($_parametros["mod"]) || !isset($_parametros["fn"]))
{
	echo "No se ha podido generar el reporte, faltan algunos parametros.";
	return;
}
	
// print_r($_parametros);
// echo "<br>";
// $reporter->printParametros();




//echo "<br><br>";

$reporter->prepare($_parametros["mod"],$_parametros["fn"]);

if ($reporter->hayError())
{
	echo $reporter->reporteadorError();
	return;
}

$_tituloReporte = $reporter->getTitulo();
$_subtituloReporte = $reporter->getSubtitulo();
$_campos = $reporter->getCampos();

if ($reporter->hayError())
{
	echo $reporter->reporteadorError();
	return;
}

// echo $reporter->getQuery();

$reporter->executeQuery();

// $reporter->varDump($reporter->rs);

// echo $reporter->getTable("tblReportito");

// return;

// if (isset($_COOKIE["nrktitulo"]))
// {
// 	$_tituloReporte = $_COOKIE["nrktitulo"];
// }

// if (isset($_COOKIE["nrksubtitulo"]))
// {
// 	$_subtituloReporte = $_COOKIE["nrksubtitulo"];
// }

// if (isset($_COOKIE["nrkc"]))
// {
// 	$_fields = explode(",",$_COOKIE["nrkc"]);
	
	
// 	foreach ($_fields as $_field)
// 	{
// 		array_push($_campos, $_field);	
// 	}
// }

// if (isset($_COOKIE["nrks"]))
// {
// 	$_select = $_COOKIE["nrks"];
// }

// if (isset($_COOKIE["nrkt"]))
// {
// 	$_from = $_COOKIE["nrkt"];
// }

// if (isset($_COOKIE["nrki"]))
// {
// 	$_inner = $_COOKIE["nrki"];
// }

// if (isset($_COOKIE["nrkw"]))
// {
// 	$_where = $_COOKIE["nrkw"];
// }

// if (isset($_COOKIE["nrkg"]))
// {
// 	$_group = $_COOKIE["nrkg"];
// }

// if (isset($_COOKIE["nrko"]))
// {
// 	$_order = $_COOKIE["nrko"];
// }

// $_strQuery = "SELECT " . $_select . 
//              " FROM " . $_from . 
//              " " . $_inner;

// if ($_where != "")
// {
// 	$_strQuery .= " WHERE " .  $_where . " " ;
// }

// if ($_group != "")
// {
// 	$_strQuery .= " GROYP BY " .  $_group . " " ;
// }

// if ($_order != "")
// {
// 	$_strQuery .= " ORDER BY " .  $_order . " " ;
// }
 
// $_strQuery = str_replace("[PLUS]", "+", $_strQuery);


// if (isset($_COOKIE["isDebug"]))
// {
// 	if ($_COOKIE["isDebug"] == "1")
// 	{
// 		echo $_strQuery;
// 		return;
// 	}
// }

// echo $_strQuery;     

// return;

function salir()
{
	echo "<script>
					window.close();
		</script>";
	return;
}

function normaliza ($cadena){
//  	$originales  = 'Ã€Ã�Ã‚ÃƒÃ„Ã…Ã†Ã‡ÃˆÃ‰ÃŠÃ‹ÃŒÃ�ÃŽÃ�Ã�Ã‘Ã’Ã“Ã”Ã•Ã–Ã˜Ã™ÃšÃ›ÃœÃ�ÃžÃŸÃ Ã¡Ã¢Ã£Ã¤Ã¥Ã¦Ã§Ã¨Ã©ÃªÃ«Ã¬Ã­Ã®Ã¯Ã°Ã±Ã²Ã³Ã´ÃµÃ¶Ã¸Ã¹ÃºÃ»Ã½Ã½Ã¾Ã¿Å”Å•ï¿½';
//  	$modificadas = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRro';

  	$originales  = 'à,á,â,ã,ä,ç,è,é,ê,ë,ì,í,î,ï,ñ,ò,ó,ô,õ,ö,ù,ú,û,ü,ý,ÿ,À,Á,Â,Ã,Ä,Ç,È,É,Ê,Ë,Ì,Í,Î,Ï,Ñ,Ò,Ó,Ô,Õ,Ö,Ù,Ú,Û,Ü,Ý';
  	$modificadas = 'a,a,a,a,a,c,e,e,e,e,i,i,i,i,n,o,o,o,o,o,u,u,u,u,y,y,A,A,A,A,A,C,E,E,E,E,I,I,I,I,N,O,O,O,O,O,U,U,U,U,Y';

  	$cadena = utf8_decode($cadena);
 	$cadena = strtr($cadena, utf8_decode($originales), $modificadas);
  	$cadena = strtolower($cadena);

	//$tofind = array('à','á','â','ã','ä', 'ç', 'è','é','ê','ë', 'ì','í','î','ï', 'ñ', 'ò','ó','ô','õ','ö', 'ù','ú','û','ü', 'ý','ÿ', 'À','Á','Â','Ã','Ä', 'Ç', 'È','É','Ê','Ë', 'Ì','Í','Î','Ï', 'Ñ', 'Ò','Ó','Ô','Õ','Ö', 'Ù','Ú','Û','Ü', 'Ý');
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
					 ->setLastModifiedBy("Galvamex App") //Ultimo usuario que lo modificÃƒÂ³
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

// $tituloReporte = "REPORTE DE RECEPCIÓN DE MATERIALES";
// $titulosColumnas = array('FECHA', 'PROVEEDOR', 'REMISIÓN', 'NUM. ROLLO', 'PRODUCTO', 'KILOS RECIB.', 'Hora', 'ts');

//LANDSCAPE		
//Titulo
$objPHPExcel->setActiveSheetIndex(0)
      		    ->mergeCells('D1:M1');
//Subtitulo
$objPHPExcel->setActiveSheetIndex(0)
      		    ->mergeCells('D2:M2');

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
//        		->setCellValue('A3','Código Rollo');       		

// $objPHPExcel->setActiveSheetIndex(0)
//        		->setCellValue('B3',$claveRollo);       		

// $objPHPExcel->setActiveSheetIndex(0)
//        		->setCellValue('C3','Descripción');       		

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
        			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
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
foreach ($_campos as $colTitle)
{
	$objPHPExcel->setActiveSheetIndex(0)
       	->setCellValueByColumnAndRow($col++, 5, $colTitle);
}       	

       	
// //Headers
// $objPHPExcel->getActiveSheet()->getStyle('A5:H5')->applyFromArray($styleArray);  
$objPHPExcel->getActiveSheet()->getStyle(chr(65) . '5:'. chr(64 + count($_campos)).'5')->applyFromArray($styleArray);
$objPHPExcel
->getActiveSheet()
->getStyle(chr(65) . '5:'. chr(64 + count($_campos)).'5')
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

// $datos = $cnn->getDataSet($_strQuery);
$datos = $reporter->rs;

$row = 6;
$ts = "";
$totalKilos = 0;
foreach ($datos as $item)
{
	$col = 0;
	foreach ($item as $cell)
	{
		$objPHPExcel->setActiveSheetIndex(0)
		            ->setCellValueByColumnAndRow($col++, $row, $cell);
		
	}	
	$row++;
}



// $objPHPExcel->setActiveSheetIndex(0)
//             ->setCellValueByColumnAndRow(0, 6, "Hola mundo");

// $row = 7;
// for($i = 0 ; $i < 10 ; $i++)
// 	{
// 		$objPHPExcel->setActiveSheetIndex(0)
// 			->setCellValue('A' . $row,  "A" . $row)
// 			->setCellValue('B' . $row,  "B" . $row)
// 			->setCellValue('C' . $row,  "C" . $row)
// 			->setCellValue('D' . $row,  "D" . $row)
// 			->setCellValue('E' . $row,  "E" . $row)
// 			->setCellValue('F' . $row,  "F" . $row);
		
// 			$objPHPExcel->getActiveSheet()->getStyle('A' . $row . ':F' . $row)->applyFromArray($styleArray);
// 	$row++;
// }

for($i = 'A'; $i <= chr(64 + count($_campos)); $i++){
	$objPHPExcel->setActiveSheetIndex(0)
	->getColumnDimension($i)->setAutoSize(TRUE);

}

       		
$objPHPExcel->getActiveSheet()->getStyle('D1:H1')->applyFromArray($estiloTituloReporte);

// $objPHPExcel->getActiveSheet()->getStyle('A3')->applyFromArray($estiloDatosLabelRollo);
// $objPHPExcel->getActiveSheet()->getStyle('B3')->applyFromArray($estiloDatosRollo);
// $objPHPExcel->getActiveSheet()->getStyle('C3')->applyFromArray($estiloDatosLabelRollo);
// $objPHPExcel->getActiveSheet()->getStyle('D3')->applyFromArray($estiloDatosRollo);

$objPHPExcel->getActiveSheet()->getStyle('A5:'.chr(64 + count($_campos)).'5')->applyFromArray($estiloHeader);

//$objPHPExcel->getActiveSheet()->getStyle('A3:D3')->applyFromArray($estiloTituloColumnas);		
//$objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "A4:D5");

// $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(false);
// $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth('12');

// $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(false);
// $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth('20');

// $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(false);
// $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth('13');

// $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(false);
// $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth('15');

// $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(false);
// $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth('58');

// $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(false);
// $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth('10');

// $objPHPExcel->getActiveSheet()->getRowDimension('3')->setRowHeight('26');
				


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
header('Content-Disposition: attachment;filename="reporte_' . date('YmdHis') . '.xlsx"');
header('Cache-Control: max-age=0');
$fileName = "Reporte_".date('YmdHis').".xlsx";
$path = "../reportes/";
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
// $objWriter->save($path.$fileName);
$objWriter->save('php://output');
// echo $fileName;
exit;
		
	
