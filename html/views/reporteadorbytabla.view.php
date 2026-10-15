<?php

use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
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

if (PHP_SAPI == 'cli')
	die('Este archivo solo se puede ver desde un navegador web');

require_once FOLDER_INCLUDE . 'lib/phpspreadsheet/autoload.php';
require_once FOLDER_INCLUDE . 'lib/phpspreadsheet/class.celdaautobinder.inc.php';

$spreadsheet = new Spreadsheet();
$spreadsheet->getProperties()->setCreator('Galvamex App')->setLastModifiedBy('Galvamex App');

$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle('Reporte');
$sheet->getPageSetup()->setOrientation(PageSetup::ORIENTATION_PORTRAIT);
$sheet->getPageSetup()->setPaperSize(PageSetup::PAPERSIZE_A4);

$styleTitle = [
	'font' => ['name' => 'Arial', 'bold' => true, 'size' => 12, 'color' => ['rgb' => '000000']],
	'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT, 'vertical' => Alignment::VERTICAL_CENTER, 'wrapText' => false],
	'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFFFFFFF']],
];

$styleHeader = [
	'font' => ['name' => 'Arial', 'bold' => true, 'size' => 9, 'color' => ['rgb' => '000000']],
	'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER, 'wrapText' => false],
	'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFE0E0E0']],
	'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
];

$styleBorder = [
	'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
	'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER, 'wrapText' => true],
];

$styleBold = [
	'font' => ['name' => 'Arial', 'bold' => true, 'size' => 9, 'color' => ['rgb' => '000000']],
];

$numCols = count($_campos) - $_itemsAExcluir;
$lastCol = Coordinate::stringFromColumnIndex($numCols);

$sheet->setCellValue('D1', $_tituloReporte);
$sheet->setCellValue('D2', $_subtituloReporte);
$sheet->getStyle('D1:D2')->applyFromArray($styleTitle);

$col = 1;
foreach ($_campos as $colTitle)
{
	if ($col > $numCols) break;
	$sheet->setCellValue(Coordinate::stringFromColumnIndex($col) . '5', $colTitle);
	$col++;
}
$sheet->getStyle('A5:' . $lastCol . '5')->applyFromArray($styleHeader);

$rowInicial = 6;
$row = $rowInicial;
foreach ($_cuerpo as $renglon)
{
	$col = 1;
	$items = explode("|", $renglon);
	foreach ($items as $cell)
	{
		if ($col > $numCols) break;

		$fc = substr($cell, 0, 1);
		if ($fc == "$")
		{
			$cell = str_replace("$", "", $cell);
			$cell = str_replace(" ", "", $cell);
			$cell = str_replace(",", "", $cell);
		}

		$sheet->setCellValue(Coordinate::stringFromColumnIndex($col) . $row, $cell);
		$col++;
	}
	$row++;
}

if ($row > $rowInicial)
{
	$sheet->getStyle('A' . $rowInicial . ':' . $lastCol . ($row - 1))->applyFromArray($styleBorder);
}

if (trim($_formulaTotales) != "")
{
	$lstFormulasTotales = explode("|", $_formulaTotales);
	foreach ($lstFormulasTotales as $colFT)
	{
		$formula = "=SUM(" . $colFT . $rowInicial . ":" . $colFT . ($row - 1) . ")";
		$sheet->setCellValue($colFT . $row, $formula);
		$sheet->getStyle($colFT . $row)->applyFromArray($styleBold);
	}
}

$rutaLogo = __DIR__ . '/../img/lamimayalogo.png';
if (file_exists($rutaLogo))
{
	$drawing = new Drawing();
	$drawing->setPath($rutaLogo);
	$drawing->setName('Logo');
	$drawing->setCoordinates('A1');
	$drawing->setOffsetX(2);
	$drawing->setOffsetY(2);
	$drawing->setWidth(170);
	$drawing->setHeight(75);
	$drawing->setWorksheet($sheet);
}

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=utf-8');
header('Content-Disposition: attachment;filename="' . $_reportName . '_' . date('YmdHis') . '.xlsx"');
header('Cache-Control: max-age=0');

$tmpFile = tempnam(sys_get_temp_dir(), 'xlsx');
(new Xlsx($spreadsheet))->save($tmpFile);
readfile($tmpFile);
unlink($tmpFile);
exit;
