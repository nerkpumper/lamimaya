<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
require_once FOLDER_INCLUDE . 'lib/fpdf/fpdfnerk.php';
require_once FOLDER_MODEL. "model.registroproduccion.inc.php";


function salir(){
	echo "<script>

					window.close();
		</script>";
}

$idRegistroProduccion = 0;

if (isset($_GET["id"]) && $_GET["id"] !== "") {
	$idRegistroProduccion = $_GET["id"];
}
else
{
	$idRegistroProduccion = -666;
	//salir();
	//exit();
}


$_tituloReporte = "Registro de Producción";
$_subtituloReporte = "";
$_campos = array("NUM. DE PEDIDO", "NOMBRE DEL CLIENTE", "PIEZAS", "ML", "TOTAL ML", "TOTAL KG", "TOTAL REAL");



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

if (PHP_SAPI == 'cli')
	die('Este archivo solo se puede ver desde un navegador web');

	
	require_once FOLDER_INCLUDE . 'lib/phpspreadsheet/autoload.php';
require_once FOLDER_INCLUDE . 'lib/phpspreadsheet/class.celdaautobinder.inc.php';
	// require_once LIB_CONEXION_MYSQL;

	
	$spreadsheet = new Spreadsheet();

	// Se asignan las propiedades del libro
	$spreadsheet->getProperties()->setCreator("Galvamex App") //Autor
	->setLastModifiedBy("Galvamex App") //Ultimo usuario que lo modificÃƒÂ³
	->setTitle("Reporte")
	->setSubject("Reporte")
	->setDescription("Reporte")
	->setKeywords("reporte")
	->setCategory("Reporte Galvamex");

	//Landscape
	// $spreadsheet->getActiveSheet()
	// 				 ->getPageSetup()
	// 				 ->setOrientation(PageSetup::ORIENTATION_LANDSCAPE);

	$spreadsheet->getActiveSheet()
	->getPageSetup()
	->setOrientation(PageSetup::ORIENTATION_PORTRAIT);

	$spreadsheet->getActiveSheet()
	->getPageSetup()
	->setPaperSize(PageSetup::PAPERSIZE_A4);

	// $tituloReporte = "REPORTE DE RECEPCIÓN DE MATERIALES";
	// $titulosColumnas = array('FECHA', 'PROVEEDOR', 'REMISIÓN', 'NUM. ROLLO', 'PRODUCTO', 'KILOS RECIB.', 'Hora', 'ts');

	//LANDSCAPE
	//Titulo
	$spreadsheet->setActiveSheetIndex(0)
	->mergeCells('C1:G1');
	//Subtitulo
	$spreadsheet->setActiveSheetIndex(0)
	->mergeCells('C2:G2');

	// //PORTRAIT
	// // //Titulo
	//  $spreadsheet->setActiveSheetIndex(0)
	//        		    ->mergeCells('D1:I1');
	// // //Subtitulo
	//  $spreadsheet->setActiveSheetIndex(0)
	//        		    ->mergeCells('D2:I2');

	 

	// Se agregan los titulos del reporte
	$spreadsheet->setActiveSheetIndex(0)
	->setCellValue('C1',$_tituloReporte);
// 	$spreadsheet->setActiveSheetIndex(0)
// 	->setCellValue('D2',$_subtituloReporte);

		

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
					'horizontal' => Alignment::HORIZONTAL_CENTER,
					'vertical'   => Alignment::VERTICAL_CENTER,
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
					'horizontal' => Alignment::HORIZONTAL_CENTER,
					'vertical'   => Alignment::VERTICAL_CENTER,
					'rotation'   => 0,
					'wrap'          => FALSE
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

	$col = 0;
	foreach ($_campos as $colTitle)
	{
		$spreadsheet->setActiveSheetIndex(0)
		->setCellValueByColumnAndRow($col++, 14, $colTitle);
	}

	$spreadsheet->getActiveSheet()->getStyle('F4:'. 'G14')->applyFromArray($styleArray);
	
	
	// //Headers
	// $spreadsheet->getActiveSheet()->getStyle('A5:H5')->applyFromArray($styleArray);
	$spreadsheet->getActiveSheet()->getStyle(chr(65) . '14:'. chr(64 + count($_campos)).'14')->applyFromArray($styleArray);
	$spreadsheet
	->getActiveSheet()
	->getStyle(chr(65) . '14:'. chr(64 + count($_campos)).'14')
	->getFill()
	->setFillType(Fill::FILL_SOLID)
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
	$rp = new ModeloRegistroproduccion();
	
	$rp->getRegistroProduccion($idRegistroProduccion);
	
	
	$datos = $rp->__rsDetalle;

	$row = 15;
	$ts = "";
	$totalKilos = 0;
	foreach ($datos as $item)
	{
// 		$col = 0;
// 		foreach ($item as $cell)
// 		{
// 			$spreadsheet->setActiveSheetIndex(0)
// 			->setCellValueByColumnAndRow($col++, $row, $cell);

// 		}
		$spreadsheet->setActiveSheetIndex(0)
		->setCellValueByColumnAndRow(0, $row, $item["nopedido"]);
		$spreadsheet->setActiveSheetIndex(0)
		->setCellValueByColumnAndRow(1, $row, $item["nombrecliente"]);
		$spreadsheet->setActiveSheetIndex(0)
		->setCellValueByColumnAndRow(2, $row, $item["partida"]);
		$spreadsheet->setActiveSheetIndex(0)
		->setCellValueByColumnAndRow(3, $row, $item["longitud"]);
		$spreadsheet->setActiveSheetIndex(0)
		->setCellValueByColumnAndRow(4, $row, $item["totalml"]);
		$spreadsheet->setActiveSheetIndex(0)
		->setCellValueByColumnAndRow(5, $row, $item["totalkg"]);
		$spreadsheet->setActiveSheetIndex(0)
		->setCellValueByColumnAndRow(6, $row, $item["totalreal"]);
		$spreadsheet->setActiveSheetIndex(0)
		->setCellValueByColumnAndRow(7, $row, $item["espesor"]);
		
		
		
		
		$row++;
	}
	
// 	$_subtituloReporte = $rp->getRegitroProduccionDato("norollo");
	
// 	$spreadsheet->setActiveSheetIndex(0)
// 	->setCellValue('C2',$_subtituloReporte);
	
// 	$row++;
// 	$row++;
	$row = 4;
	$colDatosRP = 5;
	
	$spreadsheet->setActiveSheetIndex(0)
	->setCellValueByColumnAndRow($colDatosRP, $row, "FECHA DE PRODUCCION");
	$spreadsheet->setActiveSheetIndex(0)
	->setCellValueByColumnAndRow($colDatosRP + 1, $row++, $rp->getRegitroProduccionDato("fecha_creacion"));
	
	$spreadsheet->setActiveSheetIndex(0)
	->setCellValueByColumnAndRow($colDatosRP, $row, "NUMERO DE ROLLO");
	$spreadsheet->setActiveSheetIndex(0)
	->setCellValueByColumnAndRow($colDatosRP + 1, $row++, $rp->getRegitroProduccionDato("norollo"));
	
	$spreadsheet->setActiveSheetIndex(0)
	->setCellValueByColumnAndRow($colDatosRP, $row, "KILOS DE ROLLO");
	$spreadsheet->setActiveSheetIndex(0)
	->setCellValueByColumnAndRow($colDatosRP + 1, $row++, $rp->getRegitroProduccionDato("kilos"));
	
	$spreadsheet->setActiveSheetIndex(0)
	->setCellValueByColumnAndRow($colDatosRP, $row, "KILOS MAQUILADOS");
	$spreadsheet->setActiveSheetIndex(0)
	->setCellValueByColumnAndRow($colDatosRP + 1, $row++, $rp->getRegitroProduccionDato("kilosmaquilados"));
	
	$spreadsheet->setActiveSheetIndex(0)
	->setCellValueByColumnAndRow($colDatosRP, $row, "KILOS FALTANTES");
	$spreadsheet->setActiveSheetIndex(0)
	->setCellValueByColumnAndRow($colDatosRP + 1, $row++, $rp->getRegitroProduccionDato("kilosfaltantes"));
	
	$spreadsheet->setActiveSheetIndex(0)
	->setCellValueByColumnAndRow($colDatosRP, $row, "TOTAL DE ML");
	$spreadsheet->setActiveSheetIndex(0)
	->setCellValueByColumnAndRow($colDatosRP + 1, $row++, $rp->getRegitroProduccionDato("totalml"));
	
	$spreadsheet->setActiveSheetIndex(0)
	->setCellValueByColumnAndRow($colDatosRP, $row, "FACTOR");
	$spreadsheet->setActiveSheetIndex(0)
	->setCellValueByColumnAndRow($colDatosRP + 1, $row++, $rp->getRegitroProduccionDato("factor"));
	
	$spreadsheet->setActiveSheetIndex(0)
	->setCellValueByColumnAndRow($colDatosRP, $row, "RENDIMIENTO");
	$spreadsheet->setActiveSheetIndex(0)
	->setCellValueByColumnAndRow($colDatosRP + 1, $row++, $rp->getRegitroProduccionDato("rendimiento"));

	$spreadsheet->setActiveSheetIndex(0)
	->setCellValueByColumnAndRow($colDatosRP, $row, "LARGO DE ROLLO");
	$spreadsheet->setActiveSheetIndex(0)
	->setCellValueByColumnAndRow($colDatosRP + 1, $row++, $rp->getRegitroProduccionDato("largoRollo"));

	$spreadsheet->setActiveSheetIndex(0)
	->setCellValueByColumnAndRow($colDatosRP, $row, "ESPESOR");
	$spreadsheet->setActiveSheetIndex(0)
	->setCellValueByColumnAndRow($colDatosRP + 1, $row++, $rp->getRegitroProduccionDato("espesor"));
	
	for($i = 'A'; $i <= chr(64 + count($_campos)); $i++){
		$spreadsheet->setActiveSheetIndex(0)
		->getColumnDimension($i)->setAutoSize(TRUE);

	}

	 
	$spreadsheet->getActiveSheet()->getStyle('C1:G1')->applyFromArray($estiloTituloReporte);

	// $spreadsheet->getActiveSheet()->getStyle('A3')->applyFromArray($estiloDatosLabelRollo);
	// $spreadsheet->getActiveSheet()->getStyle('B3')->applyFromArray($estiloDatosRollo);
	// $spreadsheet->getActiveSheet()->getStyle('C3')->applyFromArray($estiloDatosLabelRollo);
	// $spreadsheet->getActiveSheet()->getStyle('D3')->applyFromArray($estiloDatosRollo);

	$spreadsheet->getActiveSheet()->getStyle('A14:'.chr(64 + count($_campos)).'14')->applyFromArray($estiloHeader);

	//$spreadsheet->getActiveSheet()->getStyle('A3:D3')->applyFromArray($estiloTituloColumnas);
	//$spreadsheet->getActiveSheet()->setSharedStyle($estiloInformacion, "A4:D5");

	// $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(false);
	// $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth('12');

	// $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(false);
	// $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth('20');

	// $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(false);
	// $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth('13');

	// $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(false);
	// $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth('15');

	// $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(false);
	// $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth('58');

	// $spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(false);
	// $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth('10');

	// $spreadsheet->getActiveSheet()->getRowDimension('3')->setRowHeight('26');



	$objDrawing = new Drawing();
	$objDrawing->setName('test_img');
	$objDrawing->setDescription('test_img');
	//$objDrawing->setPath('C:\\xampp\\htdocs\\galvamex\\codigogalvamex\\html\\img\\lamimayalogo.png');
	// $objDrawing->setPath('../img/lamimayalogo.png');
	$objDrawing->setPath('img/lamimayalogo.png');
	$objDrawing->setCoordinates('A1');
	//setOffsetX works properly
	$objDrawing->setOffsetX(2);
	$objDrawing->setOffsetY(2);
	//set width, height
	$objDrawing->setResizeProportional(false);
	$objDrawing->setWidth(170);
	$objDrawing->setHeight(75);
	$objDrawing->setWorksheet($spreadsheet->getActiveSheet());

	// Se asigna el nombre a la hoja
	$spreadsheet->getActiveSheet()->setTitle('Reporte');

	// Se activa la hoja para que sea la que se muestre cuando el archivo se abre
	$spreadsheet->setActiveSheetIndex(0);
	// Inmovilizar paneles
	//$spreadsheet->getActiveSheet(0)->freezePane('A4');
	//$spreadsheet->getActiveSheet(0)->freezePaneByColumnAndRow(0,4);

	//header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
	// Se manda el archivo al navegador web, con el nombre que se indica (Excel2007)
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=utf-8');
	header('Content-Disposition: attachment;filename="RegistroProduccion_' . date('YmdHis') . '.xlsx"');
	header('Cache-Control: max-age=0');
// 	$fileName = "Reporte_".date('YmdHis').".xlsx";
// 	$path = "../reportes/";
	$objWriter = new Xlsx($spreadsheet);
	// $objWriter->save($path.$fileName);
	$objWriter->save('php://output');
	// echo $fileName;
	exit;







