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

$idRollo = $param1;

require_once FOLDER_MODEL. "model.rollo.inc.php";


$rollo = new ModeloRollo();

$rollo->setIdRollo($idRollo);

if ($rollo->getIdRollo() == 0)
{
	salir();
}

$claveRollo = $rollo->getCodigo();
$descripcionRollo = str_replace(
    "<br />",
    " ",
    normaliza(
        mb_convert_encoding(
            $rollo->getDescripcion(),
            'ISO-8859-1',
            'UTF-8'
        )
    )
);
//$descripcionRollo = $rollo->getDescripcion();
//echo $descripcionRollo;
//exit;				


if (PHP_SAPI == 'cli')
	die('Este archivo solo se puede ver desde un navegador web');


require_once FOLDER_INCLUDE . 'lib/phpspreadsheet/autoload.php';
require_once FOLDER_INCLUDE . 'lib/phpspreadsheet/class.celdaautobinder.inc.php';
require_once LIB_CONEXION_MYSQL;


$spreadsheet = new Spreadsheet();

		// Se asignan las propiedades del libro
$spreadsheet->getProperties()->setCreator("Galvamex App") //Autor
					 ->setLastModifiedBy("Galvamex App") //Ultimo usuario que lo modificÃƒÂ³
					 ->setTitle("Reporte Recepcion Material")
					 ->setSubject("Reporte Recepcion Material")
					 ->setDescription("Reporte de Recepción de Materiales")
					 ->setKeywords("reporte recepcion remision rollo")
					 ->setCategory("Reporte Galvamex");

$spreadsheet->getActiveSheet()
				 ->getPageSetup()
				 ->setOrientation(PageSetup::ORIENTATION_LANDSCAPE);

$spreadsheet->getActiveSheet()
				 ->getPageSetup()
				 ->setPaperSize(PageSetup::PAPERSIZE_A4);					 

$tituloReporte = "REPORTE DE RECEPCIÓN DE MATERIALES";
$titulosColumnas = array('FECHA', 'PROVEEDOR', 'REMISIÓN', 'NUM. ROLLO', 'PRODUCTO', 'KILOS RECIB.');

		
$spreadsheet->setActiveSheetIndex(0)
      		    ->mergeCells('A1:F1');

$spreadsheet->setActiveSheetIndex(0)
      		    ->mergeCells('C3:F3');      		    

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

// $spreadsheet->setActiveSheetIndex(0)
//        		->setCellValue('A3','Código Rollo');       		

// $spreadsheet->setActiveSheetIndex(0)
//        		->setCellValue('B3',$claveRollo);       		

// $spreadsheet->setActiveSheetIndex(0)
//        		->setCellValue('C3','Descripción');       		

// $spreadsheet->setActiveSheetIndex(0)
//        		->setCellValue('D3',$descripcionRollo);       		

       		

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

//Headers
$spreadsheet->getActiveSheet()->getStyle('A5:F5')->applyFromArray($styleArray);  
$spreadsheet
->getActiveSheet()
->getStyle('A5:F5')
->getFill()
->setFillType(Fill::FILL_SOLID)
->getStartColor()
->setRGB('E0E0E0');

//echo "vamos por los datos - Row: " . $idRollo;

//Datos
$query = "SELECT fecha, p.nombre as proveedor, remision, noRollo, r.descripcion as producto, kilos, ts
            FROM remisionrollo
           INNER JOIN rollo as r
              ON r.idRollo = remisionRollo_rollo_idRollo
           INNER JOIN proveedor as p
              ON p.idProveedor = rollo_proveedor_idProveedor
		   WHERE ts = (SELECT ts FROM remisionrollo WHERE remisionRollo_rollo_idRollo = " . $idRollo . " ORDER BY ts DESC LIMIT 1)";

$cnn = new clsConexionMySQL();

$datos = $cnn->getDataSet($query);

$row = 6;
$ts = "";
$totalKilos = 0;
foreach ($datos as $item)
{
	$spreadsheet->setActiveSheetIndex(0)
		->setCellValue('A' . $row,  $item["fecha"])
		->setCellValue('B' . $row,  $item["proveedor"])
		->setCellValue('C' . $row,  $item["remision"])
		->setCellValue('D' . $row,  $item["noRollo"])
		->setCellValue('E' . $row,  $item["producto"])
		->setCellValue('F' . $row,  $item["kilos"]);
	
	$totalKilos += (float) $item["kilos"];
		
	$spreadsheet->getActiveSheet()->getStyle('A' . $row . ':F' . $row)->applyFromArray($styleArray);
	$ts = $item["ts"];
	$row++;
}

//imprimimos el total de kilos
$spreadsheet->setActiveSheetIndex(0)
->setCellValue('F' . $row,  $totalKilos);
$spreadsheet->getActiveSheet()->getStyle('F' . $row)->applyFromArray($styleArray);
$spreadsheet
->getActiveSheet()
->getStyle('F' . $row)
->getFill()
->setFillType(Fill::FILL_SOLID)
->getStartColor()
->setRGB('C0C0C0');


//Leyenda inicial, indicando ultimos movimientos
$spreadsheet->setActiveSheetIndex(0)
->setCellValue('C3',"Movimientos de " . $claveRollo . " registrados (" . $ts . ")");


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
$spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth('12');

$spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(false);
$spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth('20');

$spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(false);
$spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth('13');

$spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(false);
$spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth('15');

$spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(false);
$spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth('58');

$spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(false);
$spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth('10');

$spreadsheet->getActiveSheet()->getRowDimension('3')->setRowHeight('26');
				
// for($i = 'A'; $i <= 'E'; $i++){
// 	$spreadsheet->setActiveSheetIndex(0)			
// 		->getColumnDimension($i)->setAutoSize(TRUE);
// }

$objDrawing = new Drawing();
$objDrawing->setName('test_img');
$objDrawing->setDescription('test_img');
//$objDrawing->setPath('C:\\xampp\\htdocs\\galvamex\\codigogalvamex\\html\\img\\lamimayalogo.png');
$objDrawing->setPath('img/lamimayalogo.png');
$objDrawing->setCoordinates('A1');
//setOffsetX works properly
$objDrawing->setOffsetX(5);
$objDrawing->setOffsetY(5);
//set width, height
$objDrawing->setWidth(380);
$objDrawing->setHeight(90);
$objDrawing->setWorksheet($spreadsheet->getActiveSheet());
		
// Se asigna el nombre a la hoja
$spreadsheet->getActiveSheet()->setTitle('Recepcion Material');

// Se activa la hoja para que sea la que se muestre cuando el archivo se abre
$spreadsheet->setActiveSheetIndex(0);
// Inmovilizar paneles 
//$spreadsheet->getActiveSheet(0)->freezePane('A4');
//$spreadsheet->getActiveSheet(0)->freezePaneByColumnAndRow(0,4);

//header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
// Se manda el archivo al navegador web, con el nombre que se indica (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=utf-8');
header('Content-Disposition: attachment;filename="noRollos_' . date('YmdHi') . '.xlsx"');
header('Cache-Control: max-age=0');

$objWriter = new Xlsx($spreadsheet);
$objWriter->save('php://output');
		exit;
		
	
