<?php

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

require_once __DIR__ . '/xlsxgen.inc.php';

$obj = new XlsxGen();

$obj->setOrientation('portrait');
$obj->setPaperSize('A4');

$styleTitle = $obj->addStyle([
	'font' => ['name' => 'Arial', 'bold' => true, 'size' => 12, 'color' => ['rgb' => '000000']],
	'alignment' => ['horizontal' => 'left', 'vertical' => 'center', 'wrap' => false],
]);

$styleHeader = $obj->addStyle([
	'font' => ['name' => 'Arial', 'bold' => true, 'size' => 9, 'color' => ['rgb' => '000000']],
	'alignment' => ['horizontal' => 'center', 'vertical' => 'center', 'wrap' => false],
	'fill' => ['rgb' => 'FFE0E0E0'],
	'border' => ['left' => 'thin', 'right' => 'thin', 'top' => 'thin', 'bottom' => 'thin'],
]);

$styleBorder = $obj->addStyle([
	'border' => ['left' => 'thin', 'right' => 'thin', 'top' => 'thin', 'bottom' => 'thin'],
	'alignment' => ['horizontal' => 'center', 'vertical' => 'center', 'wrap' => true],
]);

$numCols = count($_campos) - $_itemsAExcluir;
$lastCol = chr(64 + $numCols);

$obj->setCellValue('D1', $_tituloReporte, $styleTitle);
$obj->setCellValue('D2', $_subtituloReporte, $styleTitle);

$col = 0;
foreach ($_campos as $colTitle)
{
	if ($col >= $numCols) break;
	$obj->setCellValueByColumnAndRow($col++, 5, $colTitle, $styleHeader);
}

$rowInicial = 6;
$row = $rowInicial;
foreach ($_cuerpo as $renglon)
{
	$col = 0;
	$items = explode("|", $renglon);
	foreach ($items as $cell)
	{
		if ($col >= $numCols) break;

		$fc = substr($cell, 0, 1);
		if ($fc == "$")
		{
			$cell = str_replace("$", "", $cell);
			$cell = str_replace(" ", "", $cell);
			$cell = str_replace(",", "", $cell);
		}

		$obj->setCellValueByColumnAndRow($col++, $row, $cell, $styleBorder);
	}
	$row++;
}

if (trim($_formulaTotales) != "")
{
	$lstFormulasTotales = explode("|", $_formulaTotales);
	foreach ($lstFormulasTotales as $colFT)
	{
		$formula = "=SUM(" . $colFT . $rowInicial . ":" . $colFT . ($row - 1) . ")";
		$obj->setCellFormula($colFT . $row, $formula, $styleBold);
	}
}

$styleBold = $obj->addStyle([
	'font' => ['name' => 'Arial', 'bold' => true, 'size' => 9, 'color' => ['rgb' => '000000']],
]);

$obj->setImage('img/galvalogo.jpeg', 'A1', 2, 2, 170, 75);

$obj->setSheetTitle('Reporte');

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=utf-8');
header('Content-Disposition: attachment;filename="' . $_reportName . '_' . date('YmdHis') . '.xlsx"');
header('Cache-Control: max-age=0');

$tmpFile = tempnam(sys_get_temp_dir(), 'xlsx');
$obj->save($tmpFile);
readfile($tmpFile);
unlink($tmpFile);
exit;
