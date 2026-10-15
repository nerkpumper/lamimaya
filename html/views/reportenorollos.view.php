<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

if (PHP_SAPI == 'cli')
	die('Este archivo solo se puede ver desde un navegador web');

require_once LIB_CONEXION_MYSQL;
require_once FOLDER_INCLUDE . 'lib/phpspreadsheet/autoload.php';
require_once FOLDER_INCLUDE . 'lib/phpspreadsheet/class.celdaautobinder.inc.php';

// --- Build the report ---
$spreadsheet = new Spreadsheet();
$spreadsheet->getProperties()->setCreator('Galvamex App')->setLastModifiedBy('Galvamex App');

$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle('Recepcion Material');
$sheet->getPageSetup()->setOrientation(PageSetup::ORIENTATION_LANDSCAPE);
$sheet->getPageSetup()->setPaperSize(PageSetup::PAPERSIZE_A4);

// Styles
$styleTitle = [
	'font' => ['name' => 'Arial', 'bold' => true, 'size' => 16, 'color' => ['rgb' => '000000']],
	'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER, 'wrapText' => true],
	'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFFFFFFF']],
];

$styleHeader = [
	'font' => ['name' => 'Arial', 'bold' => true, 'size' => 10, 'color' => ['rgb' => '000000']],
	'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER, 'wrapText' => true],
	'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFE0E0E0']],
	'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
];

$styleBorder = [
	'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
	'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER, 'wrapText' => true],
];

$styleTotal = [
	'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
	'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFC0C0C0']],
	'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER, 'wrapText' => true],
];

$sheet->mergeCells('A1:F1');

$sheet->setCellValue('A1', "REPORTE DE RECEPCIÓN DE MATERIALES X REMISIÓN");
$sheet->getStyle('A1:F1')->applyFromArray($styleTitle);

$titulosColumnas = ['FECHA', 'PROVEEDOR', 'REMISIÓN', 'NUM. ROLLO', 'ALMACEN', 'PRODUCTO', 'KILOS RECIB.'];
$cols = ['A', 'B', 'C', 'D', 'E', 'F', 'G'];
foreach ($titulosColumnas as $i => $t) {
	$sheet->setCellValue($cols[$i] . '5', $t);
}
$sheet->getStyle('A5:G5')->applyFromArray($styleHeader);

// Data
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
$totalKilos = 0;
$remisionAnterior = "";
$remisionActual = "";

// Los estilos se aplican por rangos, pero solo sobre las filas de datos
// escritas (para no marcar las filas en blanco que separan remisiones).
$ranurasDatos = [];
$filasTotales = [];
$inicioRanura = null;

foreach ($datos as $item) {
	$remisionActual = $item["remision"];

	if ($remisionAnterior != $remisionActual) {
		if ($remisionAnterior != "") {
			if ($inicioRanura !== null) {
				$ranurasDatos[] = 'A' . $inicioRanura . ':G' . ($row - 1);
				$inicioRanura = null;
			}
			$sheet->setCellValue('B' . $row, "REMISIÓN");
			$sheet->setCellValue('C' . $row, $remisionActual);
			$sheet->setCellValue('G' . $row, (float)$totalKilos);
			$filasTotales[] = $row;
			$totalKilos = 0;
			$row += 2;
		}
		$remisionAnterior = $remisionActual;
	}

	$sheet->setCellValue('A' . $row, $item["fecha"]);
	$sheet->setCellValue('B' . $row, $item["proveedor"]);
	$sheet->setCellValue('C' . $row, $item["remision"]);
	$sheet->setCellValue('D' . $row, $item["noRollo"]);
	$sheet->setCellValue('E' . $row, $item["almacen"]);
	$sheet->setCellValue('F' . $row, $item["producto"]);
	$sheet->setCellValue('G' . $row, (float)$item["kilos"]);

	$inicioRanura = $inicioRanura ?? $row;
	$totalKilos += (float)$item["kilos"];
	$row++;
}

// Last remision total
if ($inicioRanura !== null) {
	$ranurasDatos[] = 'A' . $inicioRanura . ':G' . ($row - 1);
}
$sheet->setCellValue('B' . $row, "REMISIÓN");
$sheet->setCellValue('C' . $row, $remisionActual);
$sheet->setCellValue('G' . $row, (float)$totalKilos);
$filasTotales[] = $row;

foreach ($ranurasDatos as $rango) {
	$sheet->getStyle($rango)->applyFromArray($styleBorder);
}
foreach ($filasTotales as $fila) {
	$sheet->getStyle('B' . $fila . ':C' . $fila)->applyFromArray($styleTotal);
	$sheet->getStyle('G' . $fila)->applyFromArray($styleTotal);
}

// Column widths
$sheet->getColumnDimension('A')->setWidth(12);
$sheet->getColumnDimension('B')->setWidth(16);
$sheet->getColumnDimension('C')->setWidth(13);
$sheet->getColumnDimension('D')->setWidth(15);
$sheet->getColumnDimension('E')->setWidth(15);
$sheet->getColumnDimension('F')->setWidth(48);
$sheet->getColumnDimension('G')->setWidth(10);

$sheet->getRowDimension(3)->setRowHeight(26);

// Logo
$rutaLogo = __DIR__ . '/../img/lamimayalogo.png';
if (file_exists($rutaLogo)) {
	$drawing = new Drawing();
	$drawing->setPath($rutaLogo);
	$drawing->setName('Logo');
	$drawing->setCoordinates('A1');
	$drawing->setOffsetX(5);
	$drawing->setOffsetY(5);
	$drawing->setWidth(380);
	$drawing->setHeight(90);
	$drawing->setWorksheet($sheet);
}

// Output
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=utf-8');
header('Content-Disposition: attachment;filename="reporteNoRollos_' . date('YmdHi') . '.xlsx"');
header('Cache-Control: max-age=0');

$tmpFile = tempnam(sys_get_temp_dir(), 'xlsx');
(new Xlsx($spreadsheet))->save($tmpFile);
readfile($tmpFile);
unlink($tmpFile);
exit;
