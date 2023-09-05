<?php
require_once FOLDER_INCLUDE . 'lib/PHPExcel/PHPExcel.php';

//$filename = URL_BASE . "reportes/Reporte_20171222153456.xlsx";
$filename = FOLDER_HTML . "reportes/Reporte_20171222153456.xlsx";
// $filename = "C:\\xampp\\htdocs\\galvamex\\codigogalvamex\\html\\reportes\\Reporte_20171222153456.xlsx";

// if (is_file($filename))
// {
// 	echo $filename . " si esta el archivo";
// }
// else
// {
// 	echo $filename . " no es archivo";
// }


// header('Content-Description: File Transfer');
// header('Cache-Control: public');
header('Content-Type: application-x/force-download');
// header("Content-Transfer-Encoding: binary");
header('Content-Disposition: attachment; filename='. basename($filename));
header('Content-Length: '.filesize($filename));
ob_clean(); #THIS!
flush();
readfile($filename);


// header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=utf-8');
// header('Content-Disposition: attachment;filename="'.$filename.'"');
// header('Cache-Control: max-age=0');

// $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
// $objWriter->save('php://output');
// 		exit;