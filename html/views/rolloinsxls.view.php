<?php

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

  	$cadena = mb_convert_encoding($cadena, 'ISO-8859-1', 'UTF-8');
 	$cadena = strtr($cadena, mb_convert_encoding($originales, 'ISO-8859-1', 'UTF-8'), $modificadas);
  	$cadena = strtolower($cadena);

	//$tofind = array('à','á','â','ã','ä', 'ç', 'è','é','ê','ë', 'ì','í','î','ï', 'ñ', 'ò','ó','ô','õ','ö', 'ù','ú','û','ü', 'ý','ÿ', 'À','Á','Â','Ã','Ä', 'Ç', 'È','É','Ê','Ë', 'Ì','Í','Î','Ï', 'Ñ', 'Ò','Ó','Ô','Õ','Ö', 'Ù','Ú','Û','Ü', 'Ý');
	//$replac = array('a','a','a','a','a', 'c', 'e','e','e','e', 'i','i','i','i', 'n', 'o','o','o','o','o', 'u','u','u','u', 'y','y', 'A','A','A','A','A', 'C', 'E','E','E','E', 'I','I','I','I', 'N', 'O','O','O','O','O', 'U','U','U','U', 'Y');
	//return(strtr($cadena,$tofind,$replac));
	
	//  	$cadena = mb_convert_encoding($cadena, 'ISO-8859-1', 'UTF-8');
	//  	$cadena = strtr($cadena, mb_convert_encoding($tofind, 'ISO-8859-1', 'UTF-8'), $toreplac);
	//  	$cadena = strtolower($cadena);
	return $cadena;
	//return mb_convert_encoding($cadena, 'UTF-8', 'ISO-8859-1');
}



if (!isset($param1))
{
	salir();
	return;
}

if ($param1 == "")
{
	salir();
	return;
}

require_once FOLDER_MODEL. "model.rollo.inc.php";

$rollo = new ModeloRollo();

$rollo->setIdRollo($param1);

if ($rollo->getIdRollo() == 0)
{
	salir();
}

$claveRollo = $rollo->getCodigo();
$descripcionRollo = str_replace("<br />", " ", normaliza (mb_convert_encoding(($rollo->getDescripcion(, 'ISO-8859-1', 'UTF-8')))));
//$descripcionRollo = $rollo->getDescripcion();
//echo $descripcionRollo;
//exit;				


if (PHP_SAPI == 'cli')
	die('Este archivo solo se puede ver desde un navegador web');

/** Se agrega la libreria PHPExcel */
require_once FOLDER_INCLUDE . 'lib/PHPExcel/PHPExcel.php';

// Se crea el objeto PHPExcel
$objPHPExcel = new PHPExcel();

		// Se asignan las propiedades del libro
$objPHPExcel->getProperties()->setCreator("Codedrinks") //Autor
					 ->setLastModifiedBy("Codedrinks") //Ultimo usuario que lo modificÃƒÂ³
					 ->setTitle("Reporte Excel con PHP y MySQL")
					 ->setSubject("Reporte Excel con PHP y MySQL")
					 ->setDescription("Reporte de alumnos")
					 ->setKeywords("reporte alumnos carreras")
					 ->setCategory("Reporte excel");

$objPHPExcel->getActiveSheet()
				 ->getPageSetup()
				 ->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);

$objPHPExcel->getActiveSheet()
				 ->getPageSetup()
				 ->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);					 

$tituloReporte = "Hoja de Inspección";
$titulosColumnas = array('# Rollo', 'D. Interior', 'D. Exterior', 'Ancho', 'Calibre', 'Observaciones');

		
$objPHPExcel->setActiveSheetIndex(0)
      		    ->mergeCells('A1:F1');

$objPHPExcel->setActiveSheetIndex(0)
      		    ->mergeCells('D3:F3');      		    

$objPHPExcel->setActiveSheetIndex(0)
      		    ->mergeCells('B32:C32');      		    
						
// Se agregan los titulos del reporte
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('A1',$tituloReporte)
   		    ->setCellValue('A5',  $titulosColumnas[0])
            ->setCellValue('B5',  $titulosColumnas[1])
   		    ->setCellValue('C5',  $titulosColumnas[2])
       		->setCellValue('D5',  $titulosColumnas[3])
       		->setCellValue('E5',  $titulosColumnas[4])
       		->setCellValue('F5',  $titulosColumnas[5]);

$objPHPExcel->setActiveSheetIndex(0)
       		->setCellValue('A3','Código Rollo');       		

$objPHPExcel->setActiveSheetIndex(0)
       		->setCellValue('B3',$claveRollo);       		

$objPHPExcel->setActiveSheetIndex(0)
       		->setCellValue('C3','Descripción');       		

$objPHPExcel->setActiveSheetIndex(0)
       		->setCellValue('D3',$descripcionRollo);       		

$objPHPExcel->setActiveSheetIndex(0)
       		->setCellValue('B32','Responsable');       		
		
// //Se agregan los datos de los alumnos
// $i = 4;
// 		while ($fila = $resultado->fetch_array()) {
// 			$objPHPExcel->setActiveSheetIndex(0)
//         		    ->setCellValue('A'.$i,  $fila['alumno'])
// 		            ->setCellValue('B'.$i,  $fila['username'])
//         		    ->setCellValue('C'.$i,  $fila['estatus'])
//             		->setCellValue('D'.$i, mb_convert_encoding($fila['email'], 'UTF-8', 'ISO-8859-1'));
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
       			 
$objPHPExcel->getActiveSheet()->getStyle('A5:F28')->applyFromArray($styleArray);       		

//Firma
$objPHPExcel->getActiveSheet()->getStyle('B32:C32')->applyFromArray($estiloFirma);
       		
$objPHPExcel->getActiveSheet()->getStyle('A1:F1')->applyFromArray($estiloTituloReporte);

$objPHPExcel->getActiveSheet()->getStyle('A3')->applyFromArray($estiloDatosLabelRollo);
$objPHPExcel->getActiveSheet()->getStyle('B3')->applyFromArray($estiloDatosRollo);
$objPHPExcel->getActiveSheet()->getStyle('C3')->applyFromArray($estiloDatosLabelRollo);
$objPHPExcel->getActiveSheet()->getStyle('D3')->applyFromArray($estiloDatosRollo);

$objPHPExcel->getActiveSheet()->getStyle('A5:F5')->applyFromArray($estiloHeader);
//$objPHPExcel->getActiveSheet()->getStyle('A3:D3')->applyFromArray($estiloTituloColumnas);		
//$objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "A4:D5");

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth('13');

$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth('15');

$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth('15');

$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth('10');

$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth('10');

$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth('62');

$objPHPExcel->getActiveSheet()->getRowDimension('3')->setRowHeight('26');
				
// for($i = 'A'; $i <= 'E'; $i++){
// 	$objPHPExcel->setActiveSheetIndex(0)			
// 		->getColumnDimension($i)->setAutoSize(TRUE);
// }
		
// Se asigna el nombre a la hoja
$objPHPExcel->getActiveSheet()->setTitle('Hoja Inspección');

// Se activa la hoja para que sea la que se muestre cuando el archivo se abre
$objPHPExcel->setActiveSheetIndex(0);
// Inmovilizar paneles 
//$objPHPExcel->getActiveSheet(0)->freezePane('A4');
//$objPHPExcel->getActiveSheet(0)->freezePaneByColumnAndRow(0,4);

//header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
// Se manda el archivo al navegador web, con el nombre que se indica (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=utf-8');
header('Content-Disposition: attachment;filename="HojaInspeccion.xlsx"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
		exit;
		
	
