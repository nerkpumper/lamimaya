<?php

if (PHP_SAPI == 'cli')
	die('Este archivo solo se puede ver desde un navegador web');

require_once LIB_CONEXION_MYSQL;
require_once __DIR__ . '/xlsxgen.inc.php';

// --- Build the report ---
$obj = new XlsxGen();

$obj->setOrientation('landscape');
$obj->setPaperSize('A4');

// Styles
$styleTitle = $obj->addStyle([
	'font' => ['name' => 'Arial', 'bold' => true, 'size' => 16, 'color' => ['rgb' => '000000']],
	'alignment' => ['horizontal' => 'center', 'vertical' => 'center', 'wrap' => true],
]);

$styleHeader = $obj->addStyle([
	'font' => ['name' => 'Arial', 'bold' => true, 'size' => 10, 'color' => ['rgb' => '000000']],
	'alignment' => ['horizontal' => 'center', 'vertical' => 'center', 'wrap' => true],
	'fill' => ['rgb' => 'FFE0E0E0'],
	'border' => ['left' => 'thin', 'right' => 'thin', 'top' => 'thin', 'bottom' => 'thin'],
]);

$styleLabel = $obj->addStyle([
	'font' => ['name' => 'Arial', 'bold' => true, 'size' => 10, 'color' => ['rgb' => '000000']],
	'alignment' => ['horizontal' => 'center', 'vertical' => 'center', 'wrap' => true],
]);

$styleData = $obj->addStyle([
	'font' => ['name' => 'Arial', 'bold' => false, 'size' => 10, 'color' => ['rgb' => '000000']],
	'alignment' => ['horizontal' => 'center', 'vertical' => 'center', 'wrap' => true],
]);

$styleBorder = $obj->addStyle([
	'border' => ['left' => 'thin', 'right' => 'thin', 'top' => 'thin', 'bottom' => 'thin'],
	'alignment' => ['horizontal' => 'center', 'vertical' => 'center', 'wrap' => true],
]);

$styleTotal = $obj->addStyle([
	'border' => ['left' => 'thin', 'right' => 'thin', 'top' => 'thin', 'bottom' => 'thin'],
	'fill' => ['rgb' => 'FFC0C0C0'],
	'alignment' => ['horizontal' => 'center', 'vertical' => 'center', 'wrap' => true],
]);

$obj->mergeCells('A1:F1');

$obj->setCellValue('A1', "REPORTE DE RECEPCI\u00d3N DE MATERIALES X REMISI\u00d3N", $styleTitle);

$titulosColumnas = ['FECHA', 'PROVEEDOR', 'REMISI\u00d3N', 'NUM. ROLLO', 'ALMACEN', 'PRODUCTO', 'KILOS RECIB.'];
$cols = ['A', 'B', 'C', 'D', 'E', 'F', 'G'];
foreach ($titulosColumnas as $i => $t) {
	$obj->setCellValue($cols[$i] . '5', $t, $styleHeader);
}

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
$ts = "";
$totalKilos = 0;
$remisionAnterior = "";
$remisionActual = "";

foreach ($datos as $item) {
	$remisionActual = $item["remision"];

	if ($remisionAnterior != $remisionActual) {
		if ($remisionAnterior != "") {
			$obj->setCellValue('B' . $row, "REMISI\u00d3N", $styleTotal);
			$obj->setCellValue('C' . $row, $remisionActual, $styleTotal);
			$obj->setCellValue('G' . $row, (float)$totalKilos, $styleTotal);
			$totalKilos = 0;
			$row += 2;
		}
		$remisionAnterior = $remisionActual;
	}

	$obj->setCellValue('A' . $row, $item["fecha"], $styleBorder);
	$obj->setCellValue('B' . $row, $item["proveedor"], $styleBorder);
	$obj->setCellValue('C' . $row, $item["remision"], $styleBorder);
	$obj->setCellValue('D' . $row, $item["noRollo"], $styleBorder);
	$obj->setCellValue('E' . $row, $item["almacen"], $styleBorder);
	$obj->setCellValue('F' . $row, $item["producto"], $styleBorder);
	$obj->setCellValue('G' . $row, (float)$item["kilos"], $styleBorder);

	$totalKilos += (float)$item["kilos"];
	$ts = $item["ts"];
	$row++;
}

// Last remision total
$obj->setCellValue('B' . $row, "REMISI\u00d3N", $styleTotal);
$obj->setCellValue('C' . $row, $remisionActual, $styleTotal);
$obj->setCellValue('G' . $row, (float)$totalKilos, $styleTotal);

// Column widths
$obj->setColumnWidth('A', 12);
$obj->setColumnWidth('B', 16);
$obj->setColumnWidth('C', 13);
$obj->setColumnWidth('D', 15);
$obj->setColumnWidth('E', 15);
$obj->setColumnWidth('F', 48);
$obj->setColumnWidth('G', 10);

$obj->setRowHeight(3, 26);

// Logo
$obj->setImage('img/galvalogo.jpeg', 'A1', 5, 5, 380, 90);

$obj->setSheetTitle('Recepcion Material');

// Output
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=utf-8');
header('Content-Disposition: attachment;filename="reporteNoRollos_' . date('YmdHi') . '.xlsx"');
header('Cache-Control: max-age=0');

$tmpFile = tempnam(sys_get_temp_dir(), 'xlsx');
$obj->save($tmpFile);
readfile($tmpFile);
unlink($tmpFile);
exit;
