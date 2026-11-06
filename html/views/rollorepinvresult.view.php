<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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
$descripcionRollo = str_replace("<br />", " ", normaliza(mb_convert_encoding($rollo->getDescripcion(), 'ISO-8859-1', 'UTF-8')));
//$descripcionRollo = $rollo->getDescripcion();
//echo $descripcionRollo;
//exit;				


if (PHP_SAPI == 'cli')
	die('Este archivo solo se puede ver desde un navegador web');


require_once FOLDER_INCLUDE . 'lib/phpspreadsheet/autoload.php';
require_once FOLDER_INCLUDE . 'lib/phpspreadsheet/class.celdaautobinder.inc.php';


$spreadsheet = new Spreadsheet();

		// Se asignan las propiedades del libro
$spreadsheet->getProperties()->setCreator("Codedrinks") //Autor
					 ->setLastModifiedBy("Codedrinks") //Ultimo usuario que lo modificÃƒÆ’Ã‚Â³
					 ->setTitle("Reporte Excel con PHP y MySQL")
					 ->setSubject("Reporte Excel con PHP y MySQL")
					 ->setDescription("Reporte de alumnos")
					 ->setKeywords("reporte alumnos carreras")
					 ->setCategory("Reporte excel");

$spreadsheet->getActiveSheet()
				 ->getPageSetup()
				 ->setOrientation(PageSetup::ORIENTATION_LANDSCAPE);

$spreadsheet->getActiveSheet()
				 ->getPageSetup()
				 ->setPaperSize(PageSetup::PAPERSIZE_A4);					 

$tituloReporte = "Hoja de InspecciÃ³n";
$titulosColumnas = array('# Rollo', 'D. Interior', 'D. Exterior', 'Ancho', 'Calibre', 'Observaciones');

		
$spreadsheet->setActiveSheetIndex(0)
      		    ->mergeCells('A1:F1');

$spreadsheet->setActiveSheetIndex(0)
      		    ->mergeCells('D3:F3');      		    

$spreadsheet->setActiveSheetIndex(0)
      		    ->mergeCells('B32:C32');      		    
						
// Se agregan los titulos del reporte
$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('A1',$tituloReporte)
   		    ->setCellValue('A5',  $titulosColumnas[0])
            ->setCellValue('B5',  $titulosColumnas[1])
   		    ->setCellValue('C5',  $titulosColumnas[2])
       		->setCellValue('D5',  $titulosColumnas[3])
       		->setCellValue('E5',  $titulosColumnas[4])
       		->setCellValue('F5',  $titulosColumnas[5]);

$spreadsheet->setActiveSheetIndex(0)
       		->setCellValue('A3','CÃ³digo Rollo');       		

$spreadsheet->setActiveSheetIndex(0)
       		->setCellValue('B3',$claveRollo);       		

$spreadsheet->setActiveSheetIndex(0)
       		->setCellValue('C3','DescripciÃ³n');       		

$spreadsheet->setActiveSheetIndex(0)
       		->setCellValue('D3',$descripcionRollo);       		

$spreadsheet->setActiveSheetIndex(0)
       		->setCellValue('B32','Responsable');       		
		
// //Se agregan los datos de los alumnos
// $i = 4;
// 		while ($fila = $resultado->fetch_array()) {
// 			$spreadsheet->setActiveSheetIndex(0)
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
        			'horizontal' => Alignment::HORIZONTAL_CENTER,
        			'vertical'   => Alignment::VERTICAL_CENTER,
        			'rotation'   => 0,
        			'wrapText' => true
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
						'horizontal' => Alignment::HORIZONTAL_CENTER,
						'vertical'   => Alignment::VERTICAL_CENTER,
						'rotation'   => 0,
						'wrapText' => true
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
						'horizontal' => Alignment::HORIZONTAL_CENTER,
						'vertical'   => Alignment::VERTICAL_CENTER,
						'rotation'   => 0,
						'wrapText' => true
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
						'horizontal' => Alignment::HORIZONTAL_CENTER,
						'vertical'   => Alignment::VERTICAL_CENTER,
						'rotation'   => 0,
						'wrapText' => true
				)
		);


       	$styleArray = array(
       				'borders' => array(
       						'allborders' => array(
       								'style' => Border::BORDER_THIN,
       								'color' => array('argb' => 'FF000000'),
       						),
       				)
       		);
       	
       	$estiloFirma = array(
       			'borders' => array(
       					'top' => array(
       							'style' => Border::BORDER_THIN,
       							'color' => array('argb' => 'FF000000'),
       					),
       			),
       			'alignment' =>  array(
       					'horizontal' => Alignment::HORIZONTAL_CENTER,
       					'vertical'   => Alignment::VERTICAL_CENTER,
       					'rotation'   => 0,
       					'wrapText' => true
       			)
       	);
       			 
$spreadsheet->getActiveSheet()->getStyle('A5:F28')->applyFromArray($styleArray);       		

//Firma
$spreadsheet->getActiveSheet()->getStyle('B32:C32')->applyFromArray($estiloFirma);
       		
$spreadsheet->getActiveSheet()->getStyle('A1:F1')->applyFromArray($estiloTituloReporte);

$spreadsheet->getActiveSheet()->getStyle('A3')->applyFromArray($estiloDatosLabelRollo);
$spreadsheet->getActiveSheet()->getStyle('B3')->applyFromArray($estiloDatosRollo);
$spreadsheet->getActiveSheet()->getStyle('C3')->applyFromArray($estiloDatosLabelRollo);
$spreadsheet->getActiveSheet()->getStyle('D3')->applyFromArray($estiloDatosRollo);

$spreadsheet->getActiveSheet()->getStyle('A5:F5')->applyFromArray($estiloHeader);
//$spreadsheet->getActiveSheet()->getStyle('A3:D3')->applyFromArray($estiloTituloColumnas);		
//$spreadsheet->getActiveSheet()->setSharedStyle($estiloInformacion, "A4:D5");

$spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(false);
$spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth('13');

$spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(false);
$spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth('15');

$spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(false);
$spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth('15');

$spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(false);
$spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth('10');

$spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(false);
$spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth('10');

$spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(false);
$spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth('62');

$spreadsheet->getActiveSheet()->getRowDimension('3')->setRowHeight('26');
				
// for($i = 'A'; $i <= 'E'; $i++){
// 	$spreadsheet->setActiveSheetIndex(0)			
// 		->getColumnDimension($i)->setAutoSize(TRUE);
// }
		
// Se asigna el nombre a la hoja
$spreadsheet->getActiveSheet()->setTitle('Hoja InspecciÃ³n');

// Se activa la hoja para que sea la que se muestre cuando el archivo se abre
$spreadsheet->setActiveSheetIndex(0);
// Inmovilizar paneles 
//$spreadsheet->getActiveSheet(0)->freezePane('A4');
//$spreadsheet->getActiveSheet(0)->freezePaneByColumnAndRow(0,4);

//header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
// Se manda el archivo al navegador web, con el nombre que se indica (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=utf-8');
header('Content-Disposition: attachment;filename="HojaInspeccion.xlsx"');
header('Cache-Control: max-age=0');

$objWriter = new Xlsx($spreadsheet);
$objWriter->save('php://output');
		exit;
		
	
