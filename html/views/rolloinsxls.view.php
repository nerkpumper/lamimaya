<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
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
	$originales  = 'à,á,â,ã,ä,ç,è,é,ê,ë,ì,í,î,ï,ñ,ò,ó,ô,õ,ö,ù,ú,û,ü,ý,ÿ,À,Á,Â,Ã,Ä,Ç,È,É,Ê,Ë,Ì,Í,Î,Ï,Ñ,Ò,Ó,Ô,Õ,Ö,Ù,Ú,Û,Ü,Ý';
	$modificadas = 'a,a,a,a,a,c,e,e,e,e,i,i,i,i,n,o,o,o,o,o,u,u,u,u,y,y,A,A,A,A,A,C,E,E,E,E,I,I,I,I,N,O,O,O,O,O,U,U,U,U,Y';

	$cadena = mb_convert_encoding($cadena, 'ISO-8859-1', 'UTF-8');
	$cadena = strtr($cadena, mb_convert_encoding($originales, 'ISO-8859-1', 'UTF-8'), $modificadas);
	$cadena = strtolower($cadena);
	return $cadena;
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
	return;
}

$claveRollo = $rollo->getCodigo();
$descripcionRollo = str_replace("<br />", " ", normaliza(mb_convert_encoding(($rollo->getDescripcion()), 'ISO-8859-1', 'UTF-8')));

if (PHP_SAPI == 'cli')
	die('Este archivo solo se puede ver desde un navegador web');

require_once FOLDER_INCLUDE . 'lib/phpspreadsheet/autoload.php';
require_once FOLDER_INCLUDE . 'lib/phpspreadsheet/class.celdaautobinder.inc.php';

$spreadsheet = new Spreadsheet();
$spreadsheet->getProperties()->setCreator("Codedrinks")->setLastModifiedBy("Codedrinks");

$sheet = $spreadsheet->getActiveSheet();
$sheet->getPageSetup()->setOrientation(PageSetup::ORIENTATION_LANDSCAPE);
$sheet->getPageSetup()->setPaperSize(PageSetup::PAPERSIZE_A4);

$tituloReporte = "Hoja de Inspección";
$titulosColumnas = array('# Rollo', 'D. Interior', 'D. Exterior', 'Ancho', 'Calibre', 'Observaciones');

$sheet->mergeCells('A1:F1');
$sheet->mergeCells('D3:F3');
$sheet->mergeCells('B32:C32');

$sheet->setCellValue('A1', $tituloReporte)
	->setCellValue('A5', $titulosColumnas[0])
	->setCellValue('B5', $titulosColumnas[1])
	->setCellValue('C5', $titulosColumnas[2])
	->setCellValue('D5', $titulosColumnas[3])
	->setCellValue('E5', $titulosColumnas[4])
	->setCellValue('F5', $titulosColumnas[5]);

$sheet->setCellValue('A3', 'Código Rollo');
$sheet->setCellValue('B3', $claveRollo);
$sheet->setCellValue('C3', 'Descripción');
$sheet->setCellValue('D3', $descripcionRollo);
$sheet->setCellValue('B32', 'Responsable');

$estiloTituloReporte = array(
	'font' => array(
		'name' => 'Arial',
		'bold' => true,
		'italic' => false,
		'strike' => false,
		'size' => 16,
		'color' => array('rgb' => '000000')
	),
	'alignment' => array(
		'horizontal' => Alignment::HORIZONTAL_CENTER,
		'vertical' => Alignment::VERTICAL_CENTER,
		'rotation' => 0,
		'wrapText' => true
	)
);

$estiloHeader = array(
	'font' => array(
		'name' => 'Arial',
		'bold' => true,
		'italic' => false,
		'strike' => false,
		'size' => 10,
		'color' => array('rgb' => '000000')
	),
	'alignment' => array(
		'horizontal' => Alignment::HORIZONTAL_CENTER,
		'vertical' => Alignment::VERTICAL_CENTER,
		'rotation' => 0,
		'wrapText' => true
	)
);

$estiloDatosLabelRollo = array(
	'font' => array(
		'name' => 'Arial',
		'bold' => true,
		'italic' => false,
		'strike' => false,
		'size' => 10,
		'color' => array('rgb' => '000000')
	),
	'alignment' => array(
		'horizontal' => Alignment::HORIZONTAL_CENTER,
		'vertical' => Alignment::VERTICAL_CENTER,
		'rotation' => 0,
		'wrapText' => true
	)
);

$estiloDatosRollo = array(
	'font' => array(
		'name' => 'Arial',
		'bold' => false,
		'italic' => false,
		'strike' => false,
		'size' => 10,
		'color' => array('rgb' => '000000')
	),
	'alignment' => array(
		'horizontal' => Alignment::HORIZONTAL_CENTER,
		'vertical' => Alignment::VERTICAL_CENTER,
		'rotation' => 0,
		'wrapText' => true
	)
);

$styleArray = array(
	'borders' => array(
		'allBorders' => array(
			'borderStyle' => Border::BORDER_THIN,
			'color' => array('rgb' => '000000'),
		),
	)
);

$estiloFirma = array(
	'borders' => array(
		'top' => array(
			'borderStyle' => Border::BORDER_THIN,
			'color' => array('rgb' => '000000'),
		),
	),
	'alignment' => array(
		'horizontal' => Alignment::HORIZONTAL_CENTER,
		'vertical' => Alignment::VERTICAL_CENTER,
		'rotation' => 0,
		'wrapText' => true
	)
);

$sheet->getStyle('A5:F28')->applyFromArray($styleArray);
$sheet->getStyle('B32:C32')->applyFromArray($estiloFirma);
$sheet->getStyle('A1:F1')->applyFromArray($estiloTituloReporte);
$sheet->getStyle('A3')->applyFromArray($estiloDatosLabelRollo);
$sheet->getStyle('B3')->applyFromArray($estiloDatosRollo);
$sheet->getStyle('C3')->applyFromArray($estiloDatosLabelRollo);
$sheet->getStyle('D3')->applyFromArray($estiloDatosRollo);
$sheet->getStyle('A5:F5')->applyFromArray($estiloHeader);

$sheet->getColumnDimension('A')->setAutoSize(false);
$sheet->getColumnDimension('A')->setWidth(13);
$sheet->getColumnDimension('B')->setAutoSize(false);
$sheet->getColumnDimension('B')->setWidth(15);
$sheet->getColumnDimension('C')->setAutoSize(false);
$sheet->getColumnDimension('C')->setWidth(15);
$sheet->getColumnDimension('D')->setAutoSize(false);
$sheet->getColumnDimension('D')->setWidth(10);
$sheet->getColumnDimension('E')->setAutoSize(false);
$sheet->getColumnDimension('E')->setWidth(10);
$sheet->getColumnDimension('F')->setAutoSize(false);
$sheet->getColumnDimension('F')->setWidth(62);

$sheet->getRowDimension('3')->setRowHeight(26);

$sheet->setTitle('Hoja Inspección');
$spreadsheet->setActiveSheetIndex(0);

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=utf-8');
header('Content-Disposition: attachment;filename="HojaInspeccion.xlsx"');
header('Cache-Control: max-age=0');

$objWriter = new Xlsx($spreadsheet);
$objWriter->save('php://output');
exit;
